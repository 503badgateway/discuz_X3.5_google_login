<?php
/**
 * Google Login Plugin - OAuth Functions
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

/**
 * Exchange authorization code for access token
 */
function googlelogin_get_token($code) {
    global $_G, $plugin_config;
    
    $token_url = 'https://oauth2.googleapis.com/token';
    
    $params = [
        'code' => $code,
        'client_id' => $plugin_config['client_id'],
        'client_secret' => $plugin_config['client_secret'],
        'redirect_uri' => $_G['siteurl'] . 'plugin.php?id=googlelogin&action=callback',
        'grant_type' => 'authorization_code'
    ];
    
    $response = googlelogin_http_request($token_url, 'POST', $params);
    
    if($response) {
        $data = json_decode($response, true);
        if(isset($data['access_token'])) {
            return $data;
        }
    }
    
    return false;
}

/**
 * Get user info from Google
 */
function googlelogin_get_userinfo($access_token) {
    $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
    
    $response = googlelogin_http_request($userinfo_url, 'GET', [], [
        'Authorization: Bearer ' . $access_token
    ]);
    
    if($response) {
        return json_decode($response, true);
    }
    
    return false;
}
