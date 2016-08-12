<?php
#ä
/**
 * MailqueueMailtype Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueMailtypeQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const MAILTYPENAME = 'tbl_mailqueue_mailtype.mailtypename';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_mailqueue_mailtype';
		$this->modelname = 'MailqueueMailtype';
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
	 * @return MailqueueMailtypeList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return MailqueueMailtype
	 */
	public function findOne(){
		return parent::findOne();
	}

}
