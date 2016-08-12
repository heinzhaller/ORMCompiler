<?php
#ä
/**
 * User Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class UserQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const USERID = 'tbl_user.userid';
	const USERNAME = 'tbl_user.username';
	const PASSWORD = 'tbl_user.password';
	const EMAIL = 'tbl_user.email';
	const TSTAMP_CREATED = 'tbl_user.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_user.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_user.tstamp_deleted';
	const STATUSNAME = 'tbl_user.statusname';
	const TSTAMP_CONFIRMED = 'tbl_user.tstamp_confirmed';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_user';
		$this->modelname = 'User';
		if( !$load_member )
			return true;
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return UserList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return User
	 */
	public function findOne(){
		return parent::findOne();
	}

}
