<?php
/**
 * Google Login Plugin - Uninstall Script
 * Discuz! X3.5
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = "DROP TABLE IF EXISTS `pre_common_member_google`";
runquery($sql);

$finish = TRUE;
?>
