<?php
/**
 * Google Login Plugin - Template Hook Class
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_googlelogin_hook extends plugin_googlelogin {
    
    /**
     * Hook for member login page
     */
    function member_logging_output() {
        global $_G;
        
        if(!$_G['cache']['plugin']['googlelogin']['enabled']) {
            return '';
        }
        
        $client_id = $_G['cache']['plugin']['googlelogin']['client_id'];
        if(empty($client_id)) {
            return '';
        }
        
        return '
<style type="text/css">
.google-login-container { margin: 15px 0; text-align: center; border-top: 1px solid #e5e5e5; padding-top: 15px; }
.google-login-btn { display: inline-block; padding: 10px 20px; background-color: #4285f4; color: #ffffff !important; text-decoration: none; border-radius: 4px; font-size: 14px; }
.google-login-btn:hover { background-color: #357ae8; }
</style>
<div class="google-login-container">
    <a href="plugin.php?id=googlelogin:googlelogin&action=login" class="google-login-btn">
        使用Google帳號登入
    </a>
</div>';
    }
}
?>
