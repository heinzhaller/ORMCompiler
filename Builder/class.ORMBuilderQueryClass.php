<?php
#ä
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderQueryClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig, DBTable &$myTable, array $fk_tables, array $m2m_tables = null){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' Query');
		$myContent .= 'class '.self::makeClassName($myTable->getName()).'Query extends BaseQuery { '.parent::LN().parent::LN();
		$myContent .= self::buildConstants($myTable);
		$myContent .= self::constructor($myTable, $fk_tables, $m2m_tables);
		$myContent .= parent::TAB().'/**'.parent::LN();
		$myContent .= parent::TAB().' * @return int'.parent::LN();
		$myContent .= parent::TAB().' */'.parent::LN();
		$myContent .= parent::TAB().'public function count(){'.parent::LN();
		$myContent .= parent::TAB().parent::TAB().'return parent::count();'.parent::LN();
		$myContent .= parent::TAB().'}'.parent::LN().parent::LN();

		$myContent .= parent::TAB().'/**'.parent::LN();
		$myContent .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).'List'.parent::LN();
		$myContent .= parent::TAB().' */'.parent::LN();
		$myContent .= parent::TAB().'public function find(){'.parent::LN();
		$myContent .= parent::TAB().parent::TAB().'return parent::find();'.parent::LN();
		$myContent .= parent::TAB().'}'.parent::LN().parent::LN();

		$myContent .= parent::TAB().'/**'.parent::LN();
		$myContent .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).''.parent::LN();
		$myContent .= parent::TAB().' */'.parent::LN();
		$myContent .= parent::TAB().'public function findOne(){'.parent::LN();
		$myContent .= parent::TAB().parent::TAB().'return parent::findOne();'.parent::LN();
		$myContent .= parent::TAB().'}'.parent::LN().parent::LN();
		$myContent .= parent::FOOTER();

		$filename = 'class.'.self::makeClassName($myTable->getName()).'Query.php';
		$path = $myConfig->getApplicationPath();
		if( substr($path, -1) == '/' )
			$path = substr($path, 0, -1);
		$myName = str_replace(array('new_', 'tbl_'), '', strtolower($myTable->getName()));
		$myFolder = explode('_', $myName);
		foreach ($myFolder as $folder){
			$path .= '/'.parent::formatName($folder);
		}
		$path_folder = $path;
		$path = $path.'/'.$filename;

		self::write($path,$myContent);

		$manager_path = $path_folder.'/class.'.self::makeClassName($myTable->getName()).'Manager.php';
		if(!file_exists($manager_path))
			ORMBuilderManagerClass::build($myConfig, $myTable);
	}

	private static final function constructor(DBTable &$myTable, array $fk_tables, array $m2m_tables = null){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * constructor'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public function __construct($load_member = true){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'$this->tablename = \''.$myTable->getName().'\';'.self::LN();
		$content .= parent::TAB().parent::TAB().'$this->modelname = \''.self::makeClassName($myTable->getName()).'\';'.self::LN();
		$content .= parent::TAB().parent::TAB().'if( !$load_member )'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'return true;'.self::LN();
		// tabelle selbst ist keine m2m zwischentabelle
		$joins = '';
		if( 1==1 OR !isset($m2m_tables[$myTable->getName()]) ){
			// kein plan was das war
			if(isset($fk_tables[$myTable->getName()]) AND !in_array($myTable->getName(),$fk_tables['unassigned'])){
				// referenzierungen durchgehen
				foreach ($fk_tables[$myTable->getName()] as $ref){
					$ref_name = $ref['classname'];
					$ref_col = parent::formatAttributename($ref['col_ref']);
					$attributename = $ref['referenz_name'];
					$m2m = self::makeClassName($ref['ref_table']);
					$is_many = ($ref['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY OR $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY );
					$is_m2m = ( $ref['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY AND $ref['ref_table'] != $myTable->getName()); // reference ist m2m
					$referencetype = '';
					if($is_m2m)
						$referencetype .= 'List';

					// skip "not redirectable" references
					$assigned = in_array($ref['table'],$fk_tables['unassigned']);
					#$assigned = ($fk_tables[$ref['name']][$myTable->getName()]['assigned'] == false);
					if( $assigned AND !$is_m2m )
						continue;

					$nullable = $ref['nullable'];

					// keine many to many
					if($is_m2m == false){

						if( $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY ){
							// für single to many erstmal keine joins ...
						}else{
							// single-to-single - bei selbstreferenz brauchen wir auch keinen join
							if($myTable->getName() != $ref['table']){
								$jointype = 'Criteria::JOIN_INNER';
								if($nullable)
									$jointype = 'Criteria::JOIN_LEFT';

								$joins .= self::LN();
								$joins .= parent::TAB().parent::TAB().'$myJoin = new '.$ref_name.'Query(false);'.self::LN();
								$joins .= parent::TAB().parent::TAB().'$myJoin->add('.$ref_name.'Query::'.strtoupper($ref['col_ref']).', Criteria::EQUAL, '.parent::makeClassName($myTable->getName()).'Query::'.strtoupper($ref['col_own']).');'.self::LN();
								$joins .= parent::TAB().parent::TAB().'$this->addJoin($myJoin, '.$jointype.');'.self::LN();
							}
						}

					}else{
						// m2m - bei selbstreferenz brauchen wir auch keinen join

						//die();
						// erstmal raus damit
						if( 1==2 AND $myTable->getName() != $ref['table']){
							$jointype = 'Criteria::JOIN_INNER';
							if($nullable)
								$jointype = 'Criteria::JOIN_LEFT';

							// quertabelle
							$ref_name = self::makeClassName($ref['ref_table']);
							$joins .= self::LN();
							$joins .= parent::TAB().parent::TAB().'$myJoin = new '.$ref_name.'Query();'.self::LN();
							$joins .= parent::TAB().parent::TAB().'$myJoin->add('.$ref_name.'Query::'.strtoupper($ref['col_own']).', Criteria::EQUAL, '.parent::makeClassName($myTable->getName()).'Query::'.strtoupper($ref['col_own']).');'.self::LN();
							$joins .= parent::TAB().parent::TAB().'$this->addJoin($myJoin, '.$jointype.');'.self::LN();

							// zieltabelle
							$ref_name = $ref['referenz_name'];
							$joins .= self::LN();
							$joins .= parent::TAB().parent::TAB().'$myJoin = new '.$ref_name.'Query();'.self::LN();
							$joins .= parent::TAB().parent::TAB().'$myJoin->add('.$ref_name.'Query::'.strtoupper($ref['col_ref']).', Criteria::EQUAL, '.self::makeClassName($ref['ref_table']).'Query::'.strtoupper($ref['col_ref']).');'.self::LN();
							$joins .= parent::TAB().parent::TAB().'$this->addJoin($myJoin, '.$jointype.');'.self::LN();
						}

						/*
						// MANY TO MANY
						$primarykey = $pk_col[0];
						$joins .= parent::TAB().parent::TAB().'foreach($myObject->get'.self::makeClassName($ref['referenz_name']).$referencetype.'() as $sub){'.self::LN();
						#$content .= parent::TAB().parent::TAB().parent::TAB().$m2m.'Manager::saveM2M($myObject,$sub);'.self::LN();
						$joins .= parent::TAB().parent::TAB().parent::TAB().'$m2m_'.$m2m.' = new '.$m2m.'();'.self::LN();
						$joins .= parent::TAB().parent::TAB().parent::TAB().'$m2m_'.$m2m.'->set'.$primarykey.'($myObject->get'.$primarykey.'());'.self::LN();
						$joins .= parent::TAB().parent::TAB().parent::TAB().'$m2m_'.$m2m.'->set'.self::formatAttributename($ref['cross_col_org']).'($mySub->get'.$ref_col.'());'.self::LN();
						$joins .= parent::TAB().parent::TAB().parent::TAB().$m2m.'Manager::saveOnly($m2m_'.$m2m.');'.self::LN();
						$joins .= parent::TAB().parent::TAB().'}'.self::LN();
						*/

					}
				}
			}
		}

		$content .= $joins;
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildConstants(DBTable &$myTable){
		$content  = parent::TAB().'/**************************** KEYS ****************************/'.parent::LN();
		foreach ($myTable->getColumns() as $column){
			$content .= parent::TAB().'const '.strtoupper($column->getName()).' = \''.strtolower($myTable->getName()).'.'.strtolower($column->getName()).'\';'.self::LN();
		}
		$content .= self::LN();
		return $content;
	}

}