<?php
#ä
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderBaseClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig, DBTable &$myTable, array $fk_tables, array $m2m_tables = null){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' Base-Manager');
		$myContent .= 'abstract class '.self::makeClassName($myTable->getName()).'BaseManager extends '.self::makeClassName($myTable->getName()).'AbstractionLayer { '.parent::LN().parent::LN();
		$myContent .= self::buildConstants($myTable);
		$myContent  .= parent::TAB().'/**************************** SELECT METHODS ****************************/'.parent::LN();
		$myContent .= self::defaultSelects($myTable); // default selects
		foreach ($myTable->getColumns() as $column){
			$myContent .= self::buildSingleSelectMethods($myTable, $column, $m2m_tables);
		}

		if(in_array($myTable->getName(),$m2m_tables))
			$myContent .= self::buildm2mReferences($myTable, $fk_tables);
		else
			$myContent .= self::buildReferences($myTable, $fk_tables);
		$myContent .= parent::FOOTER();

		$filename = 'class.'.self::makeClassName($myTable->getName()).'BaseManager.php';
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

	private static final function defaultSelects(DBTable &$myTable){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param SQLLimit &$myLimit'.parent::LN();
		$content .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).'List'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function get'.self::makeClassName($myTable->getName()).'List(SQLLimit &$myLimit = null){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'return parent::get'.self::makeClassName($myTable->getName()).'ListBySql(\'1 = 1\', null, $myLimit);'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildConstants(DBTable &$myTable){
		$content  = parent::TAB().'/**************************** ATTRIBUTES ****************************/'.parent::LN();
		foreach ($myTable->getColumns() as $column){
			$content .= parent::TAB().'const '.strtoupper($column->getName()).' = \''.strtolower($column->getName()).'\';'.self::LN();
		}
		$content .= self::LN();
		return $content;
	}

	private static final function buildSingleSelectMethods(DBTable &$myTable, DBColumn &$myColumn, array $m2m_tables){
		$is_many = true;
		// index
		foreach ($myTable->getIndices() as $index){
			foreach($index->getColumns() as $idx_col)
				if($myColumn->getName() == $idx_col->getName() AND $index->getIsUnique())
					$is_many = false;
		}
		// pk
		if($myTable->getPrimaryKey()){
			$pk_cols = $myTable->getPrimaryKey()->getColumns();
			if($myColumn->getName() == $pk_cols[0]->getName() AND count($pk_cols) == 1)
				$is_many = false;
		}

		$col = strtolower($myColumn->getName());
		$type = DBTypes::getCreoleName($myColumn->getType());
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.self::getPHPType($type).' $'.$col.parent::LN();
		$content .= parent::TAB().' * @param SQLLimit &$myLimit'.parent::LN();
		$content .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).($is_many ? 'List' : ' or null').parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function get'.self::makeClassName($myTable->getName()).($is_many ? 'List' : '').'By'.parent::formatAttributename($myColumn->getName()).'($'.$col.', SQLLimit &$myLimit = null){'.parent::LN();
		if($is_many == false){
			$content .= parent::TAB().parent::TAB().'$myObject = parent::get'.self::makeClassName($myTable->getName()).'ListBySql(self::'.strtoupper($myColumn->getName()).'.\' = ?\', array($'.$col.'), $myLimit);'.self::LN();
			$content .= parent::TAB().parent::TAB().'return ( $myObject->valid() ? $myObject->current() : null );'.self::LN();
		}else{
			$content .= parent::TAB().parent::TAB().'return parent::get'.self::makeClassName($myTable->getName()).'ListBySql(self::'.strtoupper($myColumn->getName()).'.\' = ?\', array($'.$col.'), $myLimit);'.self::LN();
		}
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildm2mReferences(DBTable &$myTable, $fk_tables){
		die("hier m2m");
		$content  = parent::TAB().'/**************************** REFERENCES ****************************/'.parent::LN();
		//new method
		$m2m = self::makeClassName($myTable->getName());
		$tbl = array();
		$references = $fk_tables[$myTable->getName()];
		$index = 0;
		foreach ($references as $key => $ref)
			$tbl[$index++] = $ref;

		$quelle = self::makeClassName($tbl[0]['name']);
		$quelle_col = parent::formatAttributename($tbl[0]['col']);
		$ziel = self::makeClassName($tbl[1]['name']);
		$ziel_col = self::makeClassName($tbl[1]['col']);
		$ziel_lib = str_replace('TBL_', '', strtoupper($tbl[1]['name']));
		$content .= parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.$quelle.' &$myObject'.parent::LN();
		$content .= parent::TAB().' * @return '.$ziel.'List'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function get'.$ziel.'By'.$quelle.'('.$quelle.' &$myObject){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.$ziel_lib.'());'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObjects = self::get'.$m2m.'By'.$quelle.'($myObject->get'.$quelle_col.'());'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myList = new '.$ziel.'List();'.self::LN();
		$content .= parent::TAB().parent::TAB().'foreach ($myObjects as $object)'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'$myList->add('.$ziel.'Manager::get'.$ziel.'By'.$ziel_col.'($object->get'.$quelle_col.'()));'.self::LN();
		$content .= parent::TAB().parent::TAB().'return $myList;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();


		$quelle = self::makeClassName($tbl[1]['name']);
		$quelle_col = parent::formatAttributename($tbl[1]['col']);
		$ziel = self::makeClassName($tbl[0]['name']);
		$ziel_col = self::makeClassName($tbl[0]['col']);
		$ziel_lib = str_replace('TBL_', '', strtoupper($tbl[0]['name']));
		$content .= parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.$quelle.' &$myObject'.parent::LN();
		$content .= parent::TAB().' * @return '.$ziel.'List'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function get'.$ziel.'By'.$quelle.'('.$quelle.' &$myObject){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.$ziel_lib.'());'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObjects = self::get'.$m2m.'ListBy'.$quelle.'($myObject->get'.$quelle_col.'());'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myList = new '.$ziel.'List();'.self::LN();
		$content .= parent::TAB().parent::TAB().'foreach ($myObjects as $object)'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'$myList->add('.$ziel.'Manager::get'.$ziel.'By'.$ziel_col.'($object->get'.$ziel_col.'()));'.self::LN();
		$content .= parent::TAB().parent::TAB().'return $myList;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();

		return $content;
	}

	private static final function buildReferences(DBTable &$myTable, $fk_tables){
		$content  = parent::TAB().'/**************************** REFERENCES ****************************/'.parent::LN();
		//new method
		if(isset($fk_tables[$myTable->getName()]))
		foreach ($fk_tables[$myTable->getName()] as $reference){
			$classname = self::makeClassName($myTable->getName());
			$ref_classname = $reference['classname']; // old
			$ref_referencename = $reference['referenz_name']; // old
			$referenz_name = $reference['referenz_name'];
			$quelle_colname =  parent::formatAttributename($reference['col_ref']);
			$attributename = parent::formatAttributename($reference['table']);
			$colname = $reference['col_ref'];
			#$own_pk = $myTable->getPrimaryKey()->getColumns();
			#$own_colname = $own_pk[0]->getName();
			$is_manytomany = ( $reference['ref_table'] != null AND $reference['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY);
			#$is_many = ($reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY AND $reference['col'] != $own_colname);
			$is_many = ($reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY);

			// kreuzreferenz - die Bücher eines Authoren: "Author->getBooks()" hierfür brauch ich ich die buchid für die zwischentabelle.
			$crossref = ( isset($reference['crossref']) ? $reference['crossref'] : null );

			// debug
			#if($reference['table'] == 'buch_status'){
				#var_dump($reference, $is_manytomany OR $is_many );
			#}
			$content .= parent::TAB().'/**'.parent::LN();
			$content .= parent::TAB().' * @param '.$ref_classname.' &$myObject'.parent::LN();

			// ausgabe umdrehen - wegen referenz auf tabelle
			$isList = 'List';
			if( ( isset($reference['type_ziel']) AND $reference['type_ziel'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY ) OR $reference['ref_table'] != null OR $is_manytomany ){
				$content .= parent::TAB().' * @return '.$classname.$isList.parent::LN();
			}elseif($reference['type_ziel'] == DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE OR $myTable->getName() == $reference['table'] ){
				$isList = '';
				$content .= parent::TAB().' * @return '.$classname.$isList.parent::LN();
			}else{
				$isList = '';
				$content .= parent::TAB().' * @return '.$classname.$isList.parent::LN();
			}

			$content .= parent::TAB().' */'.parent::LN();
			if( $reference['ref_table'] != null OR $reference['type_ziel'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY )
				$content .= parent::TAB().'public static final function get'.$classname.'ListBy'.$ref_referencename.'('.$ref_classname.' &$myObject, SQLLimit &$myLimit = null){'.parent::LN();
			else
				$content .= parent::TAB().'public static final function get'.$classname.$isList.'By'.$ref_referencename.'('.$ref_classname.' &$myObject'.($isList ? ', SQLLimit &$myLimit = null' : '').'){'.parent::LN();
			if( $is_manytomany ){
				$ref_tablename = self::makeClassName($reference['ref_table']);
				$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.str_replace('TBL_','',strtoupper($reference['ref_table'])).'());'.self::LN();
				$content .= parent::TAB().parent::TAB().'$myList = '.$ref_tablename.'Manager::get'.$ref_tablename.'ListBy'.$ref_classname.'($myObject, $myLimit);'.self::LN();
				$content .= parent::TAB().parent::TAB().'$my'.$classname.'List = new '.$classname.'List();'.self::LN();
				$content .= parent::TAB().parent::TAB().'foreach($myList as $item)'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$my'.$classname.'List->add(self::get'.$classname.'By'.$reference['col_own_attributename'].'($item->get'.$reference['cross_col'].'()));'.self::LN();
				$content .= parent::TAB().parent::TAB().'return $my'.$classname.'List;'.self::LN();
			}else{
				if($myTable->getName() == $reference['table']){
					$content .= parent::TAB().parent::TAB().'return self::get'.$classname.'By'.$reference['col_own_attributename'].'($myObject->get'.$reference['col_own_attributename'].'()); // blub'.self::LN();
				}elseif( $reference['ref_table'] != null OR $reference['type_ziel'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY ){
					// verknüpfungstabelle
					 $content .= parent::TAB().parent::TAB().'return self::get'.$classname.'ListBy'.$reference['col_own_attributename'].'($myObject->get'.$reference['col_ref_attributename'].'(), $myLimit);'.self::LN();
				}else{
					if( $myTable->getName() == 'tbl_zipcodes' ){
					var_dump($reference, $myTable);
					die();
				}
					$content .= parent::TAB().parent::TAB().'return self::get'.$classname.'By'.$reference['col_own_attributename'].'($myObject->get'.$reference['col_ref_attributename'].'());  // blah'.self::LN();
				}

			}
			$content .= parent::TAB().'}'.self::LN();
			$content .= self::LN();

			// selbstreferenz braucht nur eine funktion
			if($myTable->getName() == $reference['table']){
				continue;
			}

			if( $myTable->getName() == 'buch_status'){
				#var_dump($reference);
			}

			// is_many - über type holen
			#$is_many = ( $reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY );
			$content .= parent::TAB().'/**'.parent::LN();
			$content .= parent::TAB().' * @param '.$classname.' &$my'.self::makeClassName($myTable->getName()).parent::LN();
			if($is_manytomany OR $is_many)
				$content .= parent::TAB().' * @return '.$ref_classname.'List'.parent::LN();
			else
				$content .= parent::TAB().' * @return '.$ref_classname.''.parent::LN();
			$content .= parent::TAB().' */'.parent::LN();
			if($is_manytomany OR $is_many)
				$content .= parent::TAB().'public static final function get'.$ref_referencename.'ListBy'.$classname.'('.$classname.' &$myObject, SQLLimit &$myLimit = null){'.parent::LN();
			else
				$content .= parent::TAB().'public static final function get'.$ref_referencename.'By'.$classname.'('.$classname.' &$myObject){'.parent::LN();
			if( $is_manytomany){
				$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.strtoupper($reference['referenz_name_org']).'());'.self::LN();
				#$content .= parent::TAB().parent::TAB().'return '.self::makeClassName($reference['ref_table']).'Manager::get'.$ref_classname.'By'.$classname.'($myObject);'.self::LN();
				$content .= parent::TAB().parent::TAB().'return '.$ref_classname.'Manager::get'.$ref_classname.'ListBy'.$classname.'($myObject, $myLimit);'.self::LN();
			}else{
				if( $is_many ){
					$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.str_replace('TBL_','',strtoupper($reference['table'])).'());'.self::LN();
					$content .= parent::TAB().parent::TAB().'return '.$ref_classname.'Manager::get'.$ref_classname.'ListBy'.$reference['quelle_name'].'($myObject, $myLimit);'.self::LN();
				}else{
					// single
					if($myTable->getName() != $reference['table'])
						$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.str_replace('TBL_','',strtoupper($reference['table'])).'());'.self::LN();
					$content .= parent::TAB().parent::TAB().'return '.$ref_classname.'Manager::get'.$ref_classname.'By'.$reference['quelle_name'].'($myObject);'.self::LN();
				}
			}
			$content .= parent::TAB().'}'.self::LN();
			$content .= self::LN();
		}
		return $content;
	}

}
?>