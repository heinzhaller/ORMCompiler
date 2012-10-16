<?

class PartnerManager {

	public static function getResultByQuery(PartnerQuery $myQuery){
		return $myQuery;
	}

}

class PartnerQuery extends QueryBase {



	const PARTNERID = 'tbl_partner.partnerid';
	const FIRSTNAME = 'tbl_partner.firstname';
	const LASTNAME = 'tbl_partner.lastname';
	const SIZE = 'tbl_partner.size';

	public function __construct(){
		$this->tablename = 'tbl_partner';
		$this->modelname = 'Partner';
		$this->table_alias = "sdfasdasdfasdf";
	}
}

class CustomerQuery extends QueryBase {
	const CUSTOMERID = 'tbl_customer.customerid';
	const FIRSTNAME = 'tbl_customer.firstname';
	const LASTNAME = 'tbl_customer.lastname';
	const PARTNERID = 'tbl_customer.partnerid';

	public function __construct(){
		$this->tablename = 'tbl_customer';
		$this->modelname = 'Partner';
		$this->table_alias = "blah";
	}
}


$finder = new PartnerQuery();
$finder->add(PartnerQuery::FIRSTNAME, Criteria::EQUAL, 'Heinz');
$finder->addOr(PartnerQuery::FIRSTNAME, Criteria::LIKE, 'Hei%');

$myJoin = new CustomerQuery();
$myJoin->add(CustomerQuery::PARTNERID, Criteria::EQUAL, PartnerQuery::PARTNERID);

$finder->addJoin( $myJoin, Criteria::JOIN_INNER );
$finder->AddGroupBy(PartnerQuery::PARTNERID);
$finder->AddGroupBy(PartnerQuery::PARTNERID);
$finder->AddOrder(PartnerQuery::PARTNERID, Criteria::DESC);
$finder->AddOrder(PartnerQuery::PARTNERID, Criteria::DESC);
$finder->setLimit(30);
$finder->setOffset(10);

$myResult = $finder->find();

if ( $myResult ){
	$myResult instanceof Partner;
#var_dump($myResult);
}

exit();