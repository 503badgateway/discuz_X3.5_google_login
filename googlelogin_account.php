<?php
/**
 * Google Login Plugin - Account Functions
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

/**
 * Create new user account
 */
function googlelogin_create_user($email, $name, $avatar) {
    global $_G;
    
    // 驗證輸入長度
    if (strlen($email) > 255 || strlen($name) > 100 || strlen($avatar) > 255) {
        showmessage('用戶資料格式錯誤', './');
    }
    
    // Generate username from email or name
    $username = googlelogin_generate_username($email, $name);
    
    // Generate secure random password
    $password = function_exists('random_bytes') ? bin2hex(random_bytes(10)) : bin2hex(openssl_random_pseudo_bytes(10));
    $salt = function_exists('random_bytes') ? bin2hex(random_bytes(3)) : bin2hex(openssl_random_pseudo_bytes(3));
    
    // Prepare user data
    $group_id = isset($_G['setting']['newusergroupid']) ? $_G['setting']['newusergroupid'] : 10;
    
    // Get next available UID
    $uid = DB::result_first("SELECT MAX(uid) FROM ".DB::table('common_member'));
    $uid = intval($uid) + 1;
    
    // Insert into common_member
    $member_data = [
        'uid' => $uid,
        'username' => $username,
        'password' => md5(md5($password) . $salt),
        'email' => $email,
        'groupid' => $group_id,
        'regdate' => TIMESTAMP,
        'emailstatus' => 1
    ];
    
    $result = DB::insert('common_member', $member_data);
    
    if($result) {
        // Insert member count
        DB::insert('common_member_count', ['uid' => $uid]);
        
        // Insert member status
        DB::insert('common_member_status', [
            'uid' => $uid,
            'regip' => $_G['clientip'],
            'lastip' => $_G['clientip'],
            'lastvisit' => TIMESTAMP,
            'lastactivity' => TIMESTAMP
        ]);
        
        return $uid;
    }
    
    return false;
}
