<?php
/**
 * Google Login Plugin - Main Module
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

// Load helper files
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_http.php';
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_oauth.php';
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_helper.php';
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_user.php';
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_account.php';
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_utils.php';
require_once DISCUZ_ROOT . './source/plugin/googlelogin/googlelogin_bind.php';

// Load plugin configuration
$pluginid = 'googlelogin';
$plugin_config = $_G['cache']['plugin'][$pluginid];

// Get action parameter
$action = $_GET['action'] ?? 'login';

switch($action) {
    case 'login':
        googlelogin_authorize();
        break;
    case 'callback':
        googlelogin_callback();
        break;
    case 'bind':
        googlelogin_bind();
        break;
    case 'unbind':
        googlelogin_unbind();
        break;
    default:
        showmessage('invalid_action', dreferer());
}

/**
 * Redirect to Google authorization page
 */
function googlelogin_authorize() {
    global $_G, $plugin_config;
    
    if(empty($plugin_config['client_id'])) {
        showmessage('Google Client ID未設置', 'admin.php?action=plugins&operation=config&do=' . $pluginid);
    }
    
    // Generate secure state token for CSRF protection
    $state = function_exists('random_bytes') ? bin2hex(random_bytes(32)) : bin2hex(openssl_random_pseudo_bytes(32));
    dsetcookie('google_oauth_state', $state, 3600);
    
    // Validate and store return URL (防止開放重定向)
    $return_url = $_GET['referer'] ?? $_SERVER['HTTP_REFERER'] ?? './';
    $parsed_url = parse_url($return_url);
    $site_host = parse_url($_G['siteurl'], PHP_URL_HOST);
    
    // 只允許相對路徑或本站域名
    if (isset($parsed_url['host']) && $parsed_url['host'] !== $site_host) {
        $return_url = './';
    }
    dsetcookie('google_return_url', $return_url, 3600);
    
    // Build authorization URL
    $params = [
        'client_id' => $plugin_config['client_id'],
        'redirect_uri' => $_G['siteurl'] . 'plugin.php?id=googlelogin&action=callback',
        'response_type' => 'code',
        'scope' => 'openid email profile',
        'state' => $state,
        'access_type' => 'online',
        'prompt' => 'select_account'
    ];
    
    $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    header('Location: ' . $auth_url);
    exit;
}
