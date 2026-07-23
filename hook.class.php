<?php
/**
 * Google Login Plugin - Hook Class
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_googlelogin {
    
    /**
     * Hook for login page
     */
    public function global_login_extra() {
        global $_G;
        
        if($_G['cache']['plugin']['googlelogin']['enabled']) {
            return $this->_get_login_button();
        }
        
        return '';
    }
    
    /**
     * Hook for user profile page
     */
    public function global_usernav_extra1() {
        global $_G;
        
        if($_G['uid'] && $_G['cache']['plugin']['googlelogin']['enabled']) {
            return $this->_get_profile_bind();
        }
        
        return '';
    }
    
    /**
     * Get login button HTML
     */
    private function _get_login_button() {
        return '<div class="google-login-container">
            <a href="plugin.php?id=googlelogin:googlelogin&action=login" class="google-login-btn">
                <span>使用Google帳號登入</span>
            </a>
        </div>';
    }
    
    /**
     * Get profile bind HTML
     */
    private function _get_profile_bind() {
        global $_G;
        
        $google_bind = C::t('#googlelogin#googlelogin_users')->fetch_by_uid($_G['uid']);
        
        if($google_bind) {
            return '<a href="plugin.php?id=googlelogin:googlelogin&action=unbind">解除Google綁定</a>';
        } else {
            return '<a href="plugin.php?id=googlelogin:googlelogin&action=bind">綁定Google</a>';
        }
    }
}
?>
