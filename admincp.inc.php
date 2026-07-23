<?php
/**
 * Google Login Plugin - Admin Panel
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$pluginid = 'googlelogin';
$plugin_config = $_G['cache']['plugin'][$pluginid];

// Display admin panel
echo '<div class="google-admin-panel">';
echo '<h3>Google登入插件管理</h3>';
echo '<div class="google-admin-info">';
echo '<p><strong>插件版本：</strong>1.0.0</p>';
echo '<p><strong>支持版本：</strong>Discuz! X3.5 / PHP 7.4+</p>';
echo '</div>';

echo '<div class="google-admin-config">';
echo '<h4>配置說明</h4>';
echo '<ol>';
echo '<li>前往 <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>';
echo '<li>創建新項目或選擇現有項目</li>';
echo '<li>啟用 Google+ API</li>';
echo '<li>創建OAuth 2.0憑證</li>';
echo '<li>設置授權重定向URI：<code>' . $_G['siteurl'] . 'plugin.php?id=googlelogin&action=callback</code></li>';
echo '<li>複製Client ID和Client Secret並填入下方表單</li>';
echo '</ol>';
echo '</div>';

echo '</div>';
?>
