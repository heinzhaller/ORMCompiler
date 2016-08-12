<?php
#ä
/**
 * MailqueueRecipienttype Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueRecipienttypeQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const TYPENAME = 'tbl_mailqueue_recipienttype.typename';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_mailqueue_recipienttype';
		$this->modelname = 'MailqueueRecipienttype';
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
	 * @return MailqueueRecipienttypeList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return MailqueueRecipienttype
	 */
	public function findOne(){
		return parent::findOne();
	}

}
