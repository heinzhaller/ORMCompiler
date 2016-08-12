<?php
#ä
/**
 * MailqueueRecipient Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueRecipientQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const MAILQUEUERECIPIENTID = 'tbl_mailqueue_recipient.mailqueuerecipientid';
	const MAILQUEUEID = 'tbl_mailqueue_recipient.mailqueueid';
	const RECIPIENTADRESS = 'tbl_mailqueue_recipient.recipientadress';
	const RECIPIENTNAME = 'tbl_mailqueue_recipient.recipientname';
	const TYPENAME = 'tbl_mailqueue_recipient.typename';
	const STATUS = 'tbl_mailqueue_recipient.status';
	const LASTTRY = 'tbl_mailqueue_recipient.lasttry';
	const TRYS = 'tbl_mailqueue_recipient.trys';
	const STATUSTEXT = 'tbl_mailqueue_recipient.statustext';
	const TSTAMP_CREATED = 'tbl_mailqueue_recipient.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_mailqueue_recipient.tstamp_modified';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_mailqueue_recipient';
		$this->modelname = 'MailqueueRecipient';
		if( !$load_member )
			return true;

		$myJoin = new MailqueueQuery(false);
		$myJoin->add(MailqueueQuery::MAILQUEUEID, Criteria::EQUAL, MailqueueRecipientQuery::MAILQUEUEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new MailqueueRecipienttypeQuery(false);
		$myJoin->add(MailqueueRecipienttypeQuery::TYPENAME, Criteria::EQUAL, MailqueueRecipientQuery::TYPENAME);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return MailqueueRecipientList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return MailqueueRecipient
	 */
	public function findOne(){
		return parent::findOne();
	}

}
