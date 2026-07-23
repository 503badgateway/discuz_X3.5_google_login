<?php
/**
 * Google Login Plugin - Helper Functions
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

/**
 * Handle Google OAuth callback
 */
function googlelogin_callback() {
    global $_G, $plugin_config;
    
    // Verify state token - use $_G['cookie'] for Discuz cookie handling
    $state = $_GET['state'] ?? '';
    $saved_state = $_G['cookie']['google_oauth_state'] ?? '';
    
    // Debug info (remove in production)
    if(empty($saved_state)) {
        // Try alternative cookie reading
        $saved_state = isset($_COOKIE[COOKIEPRE.'google_oauth_state']) ? $_COOKIE[COOKIEPRE.'google_oauth_state'] : '';
    }
    
    if(empty($state) || empty($saved_state) || $state !== $saved_state) {
        // 記錄詳細錯誤但不向用戶暴露
        writelog('googlelogin', 'CSRF verification failed. State: '.$state.', Saved: '.$saved_state);
        showmessage('授權驗證失敗，請重試', './');
    }
    
    // Get authorization code
    $code = $_GET['code'] ?? '';
    if(empty($code)) {
        $error = $_GET['error'] ?? 'unknown';
        showmessage('授權失敗: ' . htmlspecialchars($error), './');
    }
    
    // Exchange code for access token
    $token_data = googlelogin_get_token($code);
    if(!$token_data) {
        showmessage('無法獲取訪問令牌', './');
    }
    
    // Get user info
    $user_info = googlelogin_get_userinfo($token_data['access_token']);
    if(!$user_info) {
        showmessage('無法獲取用戶信息', './');
    }
    
    // Process login/registration
    googlelogin_process_user($user_info);
}
