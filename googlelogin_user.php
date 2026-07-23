<?php
/**
 * Google Login Plugin - User Processing
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

/**
 * Process user login/registration
 */
function googlelogin_process_user($user_info) {
    global $_G, $plugin_config;
    
    $google_id = $user_info['id'];
    $google_email = $user_info['email'];
    $google_name = $user_info['name'];
    $google_avatar = $user_info['picture'] ?? '';
    
    // Check if Google account is already bound
    $uid = DB::result_first("SELECT uid FROM ".DB::table('common_member_google')." WHERE google_id=%s", [$google_id]);
    
    if($uid) {
        // User exists, update last login time
        DB::update('common_member_google', [
            'last_login' => TIMESTAMP
        ], ['uid' => $uid]);
        
        // Perform login
        googlelogin_dologin($uid);
    } else {
        // New Google user
        if($plugin_config['auto_create']) {
            // Auto create account
            $uid = googlelogin_create_user($google_email, $google_name, $google_avatar);
            if($uid) {
                // Bind Google account
                googlelogin_bind_account($uid, $google_id, $google_email, $google_name, $google_avatar);
                // Login
                googlelogin_dologin($uid);
            } else {
                showmessage('創建帳號失敗', './');
            }
        } else {
            showmessage('請先註冊帳號並綁定Google', 'member.php?mod=register');
        }
    }
}
