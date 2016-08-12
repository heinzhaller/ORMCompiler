<?php
/**
 * SignatureManager interface
 * 
 * @author Mario Rimpler 24.02.2009
 */
interface iSignatureManager {
	public function setConfiguration( array $path, $selectspeech, $system, $layout );
	public function getSignatureByCobrandingUid( $cobrandingid );
	public function getSignatureByLicencepartnerUid( $lpuid );
	public function getSignatureObjectByCobrandingUid( $cobrandingid );
	public function getSignatureObjectByLicencepartnerUid( $lpuid );
	public function getSignatureObjectByCobrandingFromLicencepartnerUid( $lpuid );
}

/**
 * signatue object
 * 
 * @author Mario Rimpler 23.02.2009
 * @copyright storeforyou.de
 */
class Signature {

	private $licencpartnernumber;
	private $imprintuid;
	private $companyname;
	private $street;
	private $countryiso2;
	private $zipcode;
	private $city;
	private $phonenumber;
	private $faxnumber;
	private $website;
	private $email;
	private $businessmanager;
	private $localcourtcity;
	private $localcourtnumber;
	private $taxidnumber;
	private $userdefined1;
	private $userdefined2;
	private $userdefined3;
	
	public function getLicencpartnernumber(){
		return $this->licencpartnernumber;
	}
	
	public function setLicencepartnernumber( $str ){
		$this->licencpartnernumber = (string) $str;
	}
	
	public function getImprintuid(){
		return $this->imprintuid;
	}
	
	public function setImprintuid( $int ){
		$this->imprintuid = (int) $int;
	}
		
	public function getCompanyname(){
		return $this->companyname;
	}
	
	public function setCompanyname( $str ){
		$this->companyname = (string) $str;
	}
	
	public function getStreet(){
		return $this->street;
	}
	
	public function setStreet( $str ){
		$this->street = (string) $str;
	}
	
	public function getCountryiso2(){
		return $this->countryiso2;
	}
	
	public function setCountryiso2( $str ){
		$this->countryiso2 = (string) $str;
	}
	
	public function getZipcode(){
		return $this->zipcode;
	}
	
	public function setZipcode( $str ){
		$this->zipcode = (string) $str;
	}
	
	public function getCity(){
		return $this->city;
	}
	
	public function setCity( $str ){
		$this->city = (string) $str;
	}
	
	public function getPhonenumber(){
		return $this->phonenumber;
	}
	
	public function setPhonenumber( $str ){
		$this->phonenumber = (string) $str;
	}
	
	public function getFaxnumber(){
		return $this->faxnumber;
	}
	
	public function setFaxnumber( $str ){
		$this->faxnumber = (string) $str;
	}
	
	public function getWebsite(){
		return $this->website;
	}
	
	public function setWebsite( $str ){
		$this->website = (string) $str;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail( $str ){
		$this->email = (string) $str;
	}
	
	public function getBusinessmanager(){
		return $this->businessmanager;
	}
	
	public function setBusinessmanager( $str ){
		$this->businessmanager = (string) $str;
	}
	
	public function getLocalcourtcity(){
		return $this->localcourtcity;
	}
	
	public function setLocalcourtcity( $str ){
		$this->localcourtcity = (string) $str;
	}
	
	public function getLocalcourtnumber(){
		return $this->localcourtnumber;
	}
	
	public function setLocalcourtnumber( $str ){
		$this->localcourtnumber = (string) $str;
	}
	
	public function getTaxidnumber(){
		return $this->taxidnumber;
	}
	
	public function setTaxidnumber( $str ){
		$this->taxidnumber = (string) $str;
	}
	
	public function getUserdefined1(){
		return $this->userdefined1;
	}
	
	public function setUserdefined1( $str ){
		$this->userdefined1 = (string) $str;
	}
	
	public function getUserdefined2(){
		return $this->userdefined2;
	}
	
	public function setUserdefined2( $str ){
		$this->userdefined2 = (string) $str;
	}
	
	public function getUserdefined3(){
		return $this->userdefined3;
	}
	
	public function setUserdefined3( $str ){
		$this->userdefined3 = (string) $str;
	}
}

/**
 * SignatureManager
 * 
 * @author Mario Rimpler 24.02.2009
 * @copyright storeforyou.de
 */
class SignatureManager extends Signature implements iSignatureManager {
		
	private $path = array();
	private $selectspeech;
	private $system;
	private $layout;
	
	private function getPath(){
		return $this->path;
	}
	
	private function setPath( array $array ){
		$this->path = $array;
	}
	
	private function getSelectspeech(){
		return $this->selectspeech;
	}
	
	private function setSelectspeech( $str ){
		$this->selectspeech = (string) $str;
	}
	
	private function getSystem(){
		return $this->system;
	}
	
	private function setSystem( $str ){
		$this->system = (string) $str;
	}
	
	private function getLayout(){
		return $this->layout;
	}
	
	private function setLayout( $str ){
		$this->layout = (string) $str;
	}
	
	/**
	 * set configuration
	 *
	 * @param array $path
	 * @param string $selectspeech
	 * @param string $system
	 * @param string $layout
	 */
	public function setConfiguration( array $path, $selectspeech, $system, $layout ){
		$this->setPath( $path );
		$this->setSelectspeech( $selectspeech );
		$this->setSystem( $system );
		$this->setLayout( $layout ); 
	}
	
	/**
	 * signature template
	 * 
	 * @author Mario Rimpler 24.02.2009
	 */
	private function getSignatureTemplate(){
		$myTemplate = '
---------------------------------------
TEMP_HEADER
---------------------------------------
TEMP_COMPANY
TEMP_STREET
TEMP_ADRESS
TEMP_PHONE
TEMP_FAX
TEMP_WEB
TEMP_EMAIL

TEMP_MANAGER
TEMP_DATA
TEMP_USERDEFINED1
---------------------------------------
TEMP_FOOTER';
		
		return $myTemplate;
	}
	
	/**
	 * build signature from signature object
	 * 
	 * @author Mario Rimpler 24.02.2009
	 */
	private function buildSignatureTemplate(){	
		// load constants
		$this->loadConstantsForSignatureAndImprint();

		// load template
		$myTemplate = $this->getSignatureTemplate();
				
		// write data
		$myTemplate = str_replace('TEMP_HEADER', IMPRINT_EMAIL_HEADERTEXT,	$myTemplate);
		$myTemplate = str_replace("TEMP_COMPANY\n", ( strlen( $this->getCompanyname() ) > 0 ? $this->getCompanyname() . "\n" :	null  ), $myTemplate);
		$myTemplate = str_replace("TEMP_STREET\n", ( strlen( $this->getStreet() ) > 0 ? $this->getStreet() . "\n" :	null  ), $myTemplate); 
		$myTemplate = str_replace("TEMP_ADRESS\n", 
		(
			strlen( $this->getCity() ) > 0 ? 
				( 
					strlen( $this->getCountryiso2() ) > 0 ? $this->getCountryiso2() . '-' : NULL 
				)
			. $this->getZipcode() . ' ' . $this->getCity() . "\n" :	null  
		), $myTemplate);
		$myTemplate = str_replace("TEMP_PHONE\n", ( strlen( $this->getPhonenumber() ) > 0 ? IMPRINT_PHONENUMBER . ' ' . $this->getPhonenumber() . "\n" :	null  ), $myTemplate);
		$myTemplate = str_replace("TEMP_FAX\n", ( strlen( $this->getFaxnumber() ) > 0 ? IMPRINT_FAXNUMBER . ' ' . $this->getFaxnumber() . "\n" :	null  ), $myTemplate);
		$myTemplate = str_replace("TEMP_WEB\n", ( strlen( $this->getWebsite() ) > 0 ? IMPRINT_WEBSITE . ' ' . $this->getWebsite() . "\n" :	null  ), $myTemplate);
		$myTemplate = str_replace("TEMP_EMAIL\n", ( strlen( $this->getEmail() ) > 0 ? IMPRINT_EMAILADDRESS . ' ' .  $this->getEmail() . "\n" :	null  ), $myTemplate);
		$myTemplate = str_replace("TEMP_MANAGER\n", ( strlen( $this->getBusinessmanager() ) > 0 ? IMPRINT_BUSINESSMANAGER . ' ' . $this->getBusinessmanager() . "\n" :	null  ), $myTemplate);
		$myTemplate = str_replace("TEMP_DATA\n", 
		(
			strlen( $this->getLocalcourtcity() ) > 0 ? IMPRINT_LOCALCOURT .	' ' . $this->getLocalcourtcity() . ' ' . $this->getLocalcourtnumber() . ' ' .
				( 
					strlen( $this->getTaxidnumber() ) > 0 ? IMPRINT_TAXIDNUMBER . ' ' . $this->getTaxidnumber() : null			
				) 
		 . "\n"	: NULL ) 
		, $myTemplate);
		$myTemplate = str_replace("TEMP_USERDEFINED1\n", ( strlen($this->getUserdefined1()) > 0 ? $this->getUserdefined1() . "\n" : null ), $myTemplate);
		$myTemplate = str_replace('TEMP_FOOTER', ( strlen( @constant('IMPRINT_EMAIL_FOOTERTEXT') ) > 0 ? IMPRINT_EMAIL_FOOTERTEXT : null ), $myTemplate);
	
		return $myTemplate;
	}

	/**
	 * Load constants from translation database
	 *
	 * @author Mario Rimpler 24.02.2009
	 */
	private function loadConstantsForSignatureAndImprint(){
		if( $this->getPath() == NULL OR $this->getSelectspeech() == null OR $this->getSystem() == NULL ){
			throw new Exception(__CLASS__ . ' -  [ERROR 100] - Configuration must be set' );
		} else {
			require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.modules/Utilities/class.TranslationManager.php';
			TranslationManager::loadPlaceholderByArray( $this->getPath(), $this->getSelectspeech(), $this->getSystem(), $this->getLayout() );
		}
	}
	
/**
	 * get Signarture by CobrandingUid without Template
	 * 
	 * @author Sonja Stengel 27.04.2009
	 */
	public static function getSignaturByCobrandingUidWithoutTemplate($cobrandingid){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.CobrandingDAO.php';
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.ImprintDAO.php';
		
		$cobrandingid = (int) $cobrandingid;
		
		$myCobranding = CobrandingDAO::queryWithPreparedStatementWhereCondition('cobrandingid = ?', array( $cobrandingid ));
		
		if(strlen($myCobranding[0]->getImprintuid()) == 0){
			$myCobranding = CobrandingDAO::queryWithPreparedStatementWhereCondition('cobrandingid = ?', array( 1033 ));
		}
		// get imprint-object from database
		$myImprintObject = ImprintDAO::queryWithPreparedStatementWhereCondition('imprintuid = ?', array( $myCobranding[0]->getImprintuid() ));
		return $myImprintObject;
	}
		
	/**
	 * load data into signature-object from ImprintDAO
	 *
	 * @param Imprint $imprint
	 * @author Mario Rimpler 24.02.2009
	 */
	private function loadDataIntoObjectForCobranding( ImprintDAO $imprint ) {
		$this->setImprintuid( $imprint->getImprintuid() );
		$this->setCompanyname( $imprint->getCompanyname() );
		$this->setStreet( $imprint->getStreet() );
		$this->setCountryiso2( $imprint->getCountryiso2() );
		$this->setZipcode( $imprint->getZipcode() );
		$this->setCity( $imprint->getCity() );
		$this->setPhonenumber( $imprint->getPhonenumber() );
		$this->setFaxnumber( $imprint->getFaxnumber() );
		$this->setWebsite( $imprint->getWebsite() );
		$this->setEmail( $imprint->getEmail() );
		$this->setBusinessmanager( $imprint->getBusinessmanager() );
		$this->setLocalcourtcity( $imprint->getLocalcourtcity() );
		$this->setLocalcourtnumber( $imprint->getLocalcourtnumber() );
		$this->setTaxidnumber( $imprint->getTaxidnumber() );
		$this->setUserdefined1( $imprint->getUserdefined1() );
	}
	
	/**
	 * load data into signature-object from ImpressumDAO
	 *
	 * @param Impressum $impressum
	 * @author Mario Rimpler 26.02.2009
	 */
	private function loadDataIntoObjectForLicencepartner( Impressum $impressum ) {
		$this->setCompanyname( $impressum->getCompany() );
		$this->setStreet( $impressum->getStreet() );
		$this->setCountryiso2( $impressum->getCountry() );
		$this->setZipcode( $impressum->getZip() );
		$this->setCity( $impressum->getCountry() );
		$this->setPhonenumber( $impressum->getPhone() );
		$this->setFaxnumber( $impressum->getFax() );
		$this->setEmail( $impressum->getEmail() );
		$this->setBusinessmanager( $impressum->getFirstname() . ' ' . $impressum->getLastname() );
		$this->setLocalcourtcity( $impressum->getLocalcourtCity());
		$this->setLocalcourtnumber( $impressum->getHousenumber());
		$this->setTaxidnumber(  ( strlen($impressum->getLocalcourtNumber()) > 0 ? $impressum->getLocalcourtNumber() : $impressum->getVatidnumber() ) );
	}
	
	/**
	 * return ImprintDAO
	 *
	 * @param int $cobrandingid
	 * @return ImprintDAO
	 */
	private function getImprintDAOObject($cobrandingid){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.ImprintDAO.php';
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.CobrandingDAO.php';
		$cobrandingid = (int) $cobrandingid;
		
		$myCobranding = CobrandingDAO::queryWithPreparedStatementWhereCondition('cobrandingid = ?', array($cobrandingid));

		// get imprint-object from database
		$myImprintObject = ImprintDAO::queryWithPreparedStatementWhereCondition('imprintuid = ?', array( $myCobranding[0]->getImprintuid() ));
		$myImprintObject = ( $myImprintObject[0] == null ? new ImprintDAO() : $myImprintObject[0] );
		
		return $myImprintObject;
	}
	
	/**
	 * return ImpressumDAO
	 *
	 * @param int $lpuid
	 * @return Impressum $impressum
	 */
	public function getImpressumDAOObject( $lpuid ){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.ImpressumDAO.php';
		$lpuid = (int) $lpuid;

		// get imprint-object from database
		$myImpressumDAOObject = ImpressumDAO::genericDAOquery('SELECT * FROM (SELECT * FROM new_impressum WHERE lpid = ? ORDER BY tstamp_created DESC) WHERE rownum = 1', array( $lpuid ));
		$myImpressumDAOObject = ( $myImpressumDAOObject[0] == null ? new ImpressumDAO() : $myImpressumDAOObject[0] );

			
		return self::copyDAOToImpressum($myImpressumDAOObject);
	}
	
	
/**
	* erzeugt ein Impressum-Objekt
	* 
	* @param ImpressumDAO $impressumObject
	* 
	* return Impressum $impressum
	*/
	public static function copyDAOToImpressum(ImpressumDAO &$dao){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.modules/Utilities/class.Impressum.php';
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.KontaktinformationDAO.php';
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.AdresseDAO.php';
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.RegistraturDAO.php';
		$impressum = new Impressum();
		$impressum->setImpressumUid($dao->getImpressumid());
		$impressum->setLicencepartnerUid($dao->getLpid());
		$impressum->setCompany($dao->getFirma());
		$impressum->setFirstname($dao->getVorname());
		$impressum->setLastname($dao->getName());
		
		$impressum->setKontaktid($dao->getKontaktid());
		$impressum->setAdresseid($dao->getAdressid());
		$impressum->setRegistraturid($dao->getRegistraturid());
		
		// get other informations
		$myContact = KontaktinformationDAO::queryWithPreparedStatementWhereCondition('kontaktid = ?', array($dao->getKontaktid()));
		$myAddress = AdresseDAO::queryWithPreparedStatementWhereCondition('adresseid = ?', array($dao->getAdressid()));
		$myRegister = RegistraturDAO::queryWithPreparedStatementWhereCondition('registraturid = ?', array($dao->getRegistraturid()));
		
		if(isset($myAddress) && count($myAddress) > 0){
			$impressum->setStreet($myAddress[0]->getStrasse());
			$impressum->setHousenumber($myAddress[0]->getHausnr());
			$impressum->setZip($myAddress[0]->getPlz());
			$impressum->setCountry($myAddress[0]->getLand());
			$impressum->setCity($myAddress[0]->getOrt());
		}
		
		if(isset($myContact) && count($myContact) > 0){
			$impressum->setEmail($myContact[0]->getEmail());
			$impressum->setPhone($myContact[0]->getTel());
			$impressum->setFax($myContact[0]->getFax());
			$impressum->setMobile($myContact[0]->getFunk());
		}
		
		if(isset($myRegister) && count($myRegister) > 0){
			$impressum->setLocalcourtCity($myRegister[0]->getAmtsgericht());
			$impressum->setLocalcourtNumber($myRegister[0]->getRegisterid());
			$impressum->setStnrtyp($myRegister[0]->getStnrtyp());
			$impressum->setTaxnumber($myRegister[0]->getSsnumber());
			$impressum->setVatidnumber($myRegister[0]->getUstid());
		}
		
		return $impressum;	
	}
	
	/**
	 * generates signature for cobranding
	 *
	 * @author Mario Rimpler 24.02.2009 
	 * @param int $cobrandingid
	 * @return string Signaturetemplate
	 */ 
	private function buildSignatureByCobrandingUid( $cobrandingid ){
		// get object
		$myImprintObject = $this->getImprintDAOObject( $cobrandingid );
		
		// load signature-object whit data from imprint-object
		$this->loadDataIntoObjectForCobranding( $myImprintObject );

		if( is_null($myImprintObject) OR strlen($this->getCompanyname()) == 0 ) {
			return ''; // return empty string		
		} else {
			// generate template and return output
			return $this->buildSignatureTemplate();
		}
	}
	
	/**
	 * generates signature for licencepartner
	 *
	 * @author Mario Rimpler 24.02.2009 
	 * @param int $lpuid
	 * @return string Signaturetemplate
	 */
	private function buildSignatureByLicencepartnerUid( $lpuid ){
		// get object
		$myImprintObject = $this->getImpressumDAOObject( $lpuid );
		
		// load signature-object whit data from imprint-object
		$this->loadDataIntoObjectForLicencepartner( $myImprintObject );

		if( $myImprintObject == NULL OR strlen( $this->getCompanyname() ) <= 1 ) {
					return ''; // return empty string
		} else {
			// generate template and return output
			return $this->buildSignatureTemplate();
		}
	}	
		
	/**
	 * return signatue for cobrandingid [require setConfiguration]
	 * 
	 * @author Mario Rimpler 24.02.2009
	 * @param int $lpuid Licenceparnter UID
	 * @return string Signaturetemplate
	 */
	public function getSignatureByCobrandingUid( $cobrandingid ){
		return $this->buildSignatureByCobrandingUid( $cobrandingid );			
	}
	
	/**
	 * return signatue for licencpartner 
	 *  - primary for email signatures
	 *
	 * @author Mario Rimpler 24.02.2009
	 * @param int $lpuid Licenceparnter UID
	 * @return string Signaturetemplate
	 */
	public function getSignatureByLicencepartnerUid( $lpuid ){
		return $this->buildSignatureByLicencepartnerUid( $lpuid );
	}
	
	/**
	 * build signatureobject from new_impressum by licencepartner uid
	 *
	 * @param int $lpuid
	 */
	public function getSignatureObjectByLicencepartnerUid( $lpuid ){
		$myImpressumDAO = $this->getImpressumDAOObject( $lpuid );
		$this->loadDataIntoObjectForLicencepartner( $myImpressumDAO );
	}
	
	/**
	 * build signatureobject by cobranding uid
	 *
	 * @param int $cobrandingid
	 */
	public function getSignatureObjectByCobrandingUid( $cobrandingid ){
		$myImprintDAO = $this->getImprintDAOObject( $cobrandingid );
		$this->loadDataIntoObjectForCobranding( $myImprintDAO );
	}
	
	/**
	 * build signatureobject from tbl_imprint over cobranding
	 *
	 * @param int $lpuid
	 */
	public function getSignatureObjectByCobrandingFromLicencepartnerUid( $lpuid ){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.CmUsersDAO.php';
		$myLicencepartner = CmUsersDAO::queryWithPreparedStatementWhereCondition('lpid = ?', array( $lpuid ));
		$myImprintDAO = $this->getImprintDAOObject( $myLicencepartner[0]->getCobrandingid() );
		$this->loadDataIntoObjectForCobranding( $myImprintDAO );
	}
	
}
?>