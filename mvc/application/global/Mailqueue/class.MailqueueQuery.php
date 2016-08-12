<?php
#ä
/**
 * Mailqueue Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const MAILQUEUEID = 'tbl_mailqueue.mailqueueid';
	const USERID = 'tbl_mailqueue.userid';
	const CHARSET = 'tbl_mailqueue.charset';
	const SENDERADRESS = 'tbl_mailqueue.senderadress';
	const SENDERNAME = 'tbl_mailqueue.sendername';
	const MAILTYPENAME = 'tbl_mailqueue.mailtypename';
	const SUBJECT = 'tbl_mailqueue.subject';
	const CONTENT = 'tbl_mailqueue.content';
	const COMMENTARY = 'tbl_mailqueue.commentary';
	const FILEPATH = 'tbl_mailqueue.filepath';
	const FILENAME = 'tbl_mailqueue.filename';
	const SIGNATURE = 'tbl_mailqueue.signature';
	const TSTAMP_CREATED = 'tbl_mailqueue.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_mailqueue.tstamp_modified';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_mailqueue';
		$this->modelname = 'Mailqueue';
		if( !$load_member )
			return true;

		$myJoin = new MailqueueMailtypeQuery(false);
		$myJoin->add(MailqueueMailtypeQuery::MAILTYPENAME, Criteria::EQUAL, MailqueueQuery::MAILTYPENAME);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new UserQuery(false);
		$myJoin->add(UserQuery::USERID, Criteria::EQUAL, MailqueueQuery::USERID);
		$this->addJoin($myJoin, Criteria::JOIN_LEFT);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return MailqueueList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Mailqueue
	 */
	public function findOne(){
		return parent::findOne();
	}

}
