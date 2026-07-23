<?php
/**
 * Google Login Plugin - Utility Functions
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

/**
 * Generate unique username
 */
function googlelogin_generate_username($email, $name) {
    // Try using name first
    $username = preg_replace('/[^a-zA-Z0-9_]/', '', $name);
    
    if(empty($username)) {
        // Use email prefix
        $username = explode('@', $email)[0];
        $username = preg_replace('/[^a-zA-Z0-9_]/', '', $username);
    }
    
    // Check if username exists
    $original_username = $username;
    $suffix = 1;
    
    while(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username=%s", [$username])) {
        $username = $original_username . $suffix;
        $suffix++;
    }
    
    return $username;
}

/**
 * Perform user login
 */
function googlelogin_dologin($uid) {
    global $_G;
    
    // 重新生成session ID防止會話固定攻擊
    if(function_exists('session_regenerate_id')) {
        session_regenerate_id(true);
    }
    
    $member = DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid=%d", [$uid]);
    
    if(!$member) {
        showmessage('用戶不存在', './');
    }
    
    // Set login cookies
    dsetcookie('auth', authcode($member['password']."\t".$member['uid'], 'ENCODE'), 2592000);
    
    // Update member status
    DB::update('common_member_status', [
        'lastip' => $_G['clientip'],
        'lastvisit' => TIMESTAMP,
        'lastactivity' => TIMESTAMP
    ], ['uid' => $uid]);
    
    $return_url = $_G['cookie']['google_return_url'] ?? './';
    dsetcookie('google_return_url', '', -1);
    dsetcookie('google_oauth_state', '', -1);
    
    showmessage('登入成功', $return_url);
}
