<?php
/**
 * Google Login Plugin - Database Table Class
 * Discuz! X3.5 - PHP 7.4
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_googlelogin_users extends discuz_table {
    
    public function __construct() {
        $this->_table = 'common_member_google';
        $this->_pk = 'uid';
        parent::__construct();
    }
    
    /**
     * Fetch user by Google ID
     */
    public function fetch_uid_by_googleid($google_id) {
        $data = DB::fetch_first("SELECT uid FROM %t WHERE google_id=%s", [$this->_table, $google_id]);
        return $data ? $data['uid'] : 0;
    }
    
    /**
     * Fetch Google data by UID
     */
    public function fetch_by_uid($uid) {
        return DB::fetch_first("SELECT * FROM %t WHERE uid=%d", [$this->_table, $uid]);
    }
    
    /**
     * Insert new binding
     */
    public function insert($data, $return_insert_id = false, $replace = false) {
        return DB::insert($this->_table, $data, $return_insert_id, $replace);
    }
    
    /**
     * Update binding data
     */
    public function update($uid, $data) {
        return DB::update($this->_table, $data, ['uid' => $uid]);
    }
    
    /**
     * Delete binding
     */
    public function delete($uid) {
        return DB::delete($this->_table, ['uid' => $uid]);
    }
}
?>
