<?php
/**
 * Google Login Plugin - Bind/Unbind Functions
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

/**
 * Bind Google account to user
 */
function googlelogin_bind_account($uid, $google_id, $google_email, $google_name, $google_avatar) {
    $data = [
        'uid' => $uid,
        'google_id' => $google_id,
        'google_email' => $google_email,
        'google_name' => $google_name,
        'google_avatar' => $google_avatar,
        'bind_time' => TIMESTAMP,
        'last_login' => TIMESTAMP
    ];
    
    return DB::insert('common_member_google', $data);
}

/**
 * Handle bind action
 */
function googlelogin_bind() {
    global $_G;
    
    if(!$_G['uid']) {
        showmessage('請先登入', 'member.php?mod=logging&action=login');
    }
    
    // Redirect to Google authorization
    googlelogin_authorize();
}

/**
 * Handle unbind action
 */
function googlelogin_unbind() {
    global $_G;
    
    if(!$_G['uid']) {
        showmessage('請先登入', 'member.php?mod=logging&action=login');
    }
    
    // 驗證formhash防止CSRF攻擊
    if(!submitcheck('unbindsubmit')) {
        showmessage('invalid_request', dreferer());
    }
    
    DB::delete('common_member_google', ['uid' => $_G['uid']]);
    
    showmessage('已解除Google綁定', 'home.php?mod=space&do=profile');
}
?>
