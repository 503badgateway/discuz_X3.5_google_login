<?php
/**
 * Google Login Plugin - Install Script
 * Discuz! X3.5
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_common_member_google` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `google_id` varchar(100) NOT NULL DEFAULT '',
  `google_email` varchar(255) NOT NULL DEFAULT '',
  `google_name` varchar(100) NOT NULL DEFAULT '',
  `google_avatar` varchar(255) NOT NULL DEFAULT '',
  `bind_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `google_id` (`google_id`),
  KEY `google_email` (`google_email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOF;

runquery($sql);

$finish = TRUE;
?>
