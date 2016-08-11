<?php
#ä
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);

error_reporting ( E_ALL & ~E_STRICT & ~E_DEPRECATED );

$myPath = $_SERVER['SCRIPT_FILENAME'];
define('ORMCOMPILER_PATH', substr($myPath, 0, strrpos($myPath, '/')));


require_once ORMCOMPILER_PATH.'/class.ORMBase.php';
include_once ORMCOMPILER_PATH.'/class.ORMConfig.php'; // serialize
$save_file = ORMCOMPILER_PATH.'/config.sav';

$myConfig = null;

if(file_exists($save_file))
{
	$myConfig = unserialize(file_get_contents($save_file));
}

if(!$myConfig)
	$myConfig = new ORMConfig();

@ob_start();

if( !empty($_POST) ){
	try {
		$myConfig->reset();
		$myConfig->setCreolePath($_POST['creole']);
		$creole_path = substr($_POST['creole'], 0, strpos(strtolower($_POST['creole']), 'creole.php'));

		$myConfig->setDbDriver($_POST['driver']);
		$myConfig->setDbDatabase($_POST['database']);
		$myConfig->setDbHost($_POST['host']);
		$myConfig->setDbCharset($_POST['charset']);
		#$myConfig->setDbLoginname('dbmwc');
		#$myConfig->setDbPassword('mcwebcity');
		$myConfig->pdo = false;
		if( $_POST['pdo'] == "1" )
			$myConfig->pdo = true;

		$myConfig->setDbLoginname($_POST['username']);
		$myConfig->setDbPassword($_POST['passwort']);

		$myConfig->setApplicationPath($_POST['application']);
		$myConfig->setAbstractionPath($_POST['abstraction']);
		$myConfig->setSystemPath($_POST['system']);
		$myConfig->setIncludeSystem(!empty($_POST['include_system']) ? true : false );

		$myConfig->setReferenceIsUnassigned(!empty($_POST['reference_is_unassigned']) ? true : false );

		if(!$myConfig->isValid())
			die('Config muss vollständig sein.');


	} catch (Exception $e) {
		echo $e->getMessage();
		exit();
	}

	if(!file_exists($myConfig->getCreolePath()))
		die('creole nicht gefunden');
	define ('CREOLE_BASEPATH', substr($myConfig->getCreolePath(), 0, strrpos($myConfig->getCreolePath(), '/') ));

	// workarounds
	if( substr($myConfig->getApplicationPath(),-1) != '/' )
		$myConfig->setApplicationPath($myConfig->getApplicationPath().'/');
	if( substr($myConfig->getAbstractionPath(),-1) != '/' )
		$myConfig->setAbstractionPath($myConfig->getAbstractionPath().'/');

	// save config
	file_put_contents($save_file, serialize($myConfig));

	#ORMBuilderBaseClass::build($myConfig,DBAbstractionCreole::getTable(DBConnection::getConnection($myConfig)->getDatabaseInfo()->getTable('tbl_manager')), $fk_tables);
	#die();
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //
	// MUSS NOCH IN NE KLASS REIN !!!!!!!!!!
	// hat noch probleme wenn tabellennamen und spalten gleich heissen. fix this!
	// checkt alle tabellen-referenzen durch
	// damit lassen sich leichter die klassen zusammenbauen


	// hier ist alles mit creole
	// TODO: PDO reibringen

	try{ $connection = DBConnection::getConnection($myConfig); }catch(Exception $e){ die('Datenbankverbindung fehlgeschlagen. Grund: <br>'.$e->getMessage()); }
	#DBAbstractionCreole::getTable(DBConnection::getConnection($myConfig)->getDatabaseInfo()->getTable('tbl_student'));
	#die();

	$myTables = $connection->getDatabaseInfo()->getTables();
	$fk_tables = array();
	$m2m_tables = array();
	foreach ($myTables as $table){
		if( substr(strtolower($table->getName()), 0, 3) != 'tbl' )
			continue;

		$rare_reference_2to1_self = false;

		$count_pk = count($table->getPrimaryKey()->getColumns());
		$count_fk = count($table->getForeignKeys());
		$is_manytomany = ( $count_pk == 2 AND $count_fk == $count_pk );

		// mehrfach referenzen feststellen
		$myReferences = array();
		foreach ( $table->getForeignKeys() as $fk ){
			$references = $fk->getReferences();
			$ref_column = $references[0][1];
			$ref_table = $ref_column->getTable();
			if( !isset($myReferences[$ref_table->getName()]))
				$myReferences[$ref_table->getName()] = 0;
			$myReferences[$ref_table->getName()]++;
		}
		// es sind 2 pk und die fks zeigen auf die selbe tabelle - seltene selbstreferenz (z.B.: Freundesliste, eine person hat mehrere Freunde (assoziationen))
		// hier soll es sich um eine normale single-to-many referenz handeln -> workaround
		if( $is_manytomany AND count($myReferences) == 1 ){
			$rare_reference_2to1_self = true; // 2 zu 1 auf sich selbst
			continue;
		}

		if($is_manytomany){

			// many to many
			$fks = $table->getForeignKeys();

			$ref1 = $fks[0]->getReferences();
			$ref2 = $fks[1]->getReferences();
			$cross_col1 = $fks[0]->getName();
			$cross_col2 = $fks[1]->getName();
			$ziel1 = $ref1[0][1]->getTable();
			$ziel2 = $ref2[0][1]->getTable();

			$myArray1 = array(
				'table' => $ziel2->getName(),
				'referenz_name' => ORMBuilderBase::makeClassName($ziel2->getName()),
				'referenz_name_org' => str_replace('tbl_','',strtolower($ziel2->getName())),
				'quelle_name' => $ziel1->getName(),
				'quelle_name_org' => str_replace('tbl_','',strtolower($ziel1->getName())),
				'classname' => ORMBuilderBase::makeClassName($ziel2->getName()),
				'quelle_classname' => ORMBuilderBase::makeClassName($ziel1->getName()),
				'quelle_tablename' => $ziel1->getName(),
				'col_ref' => $ref2[0][1]->getName(),
				'col_ref_attributename' => ORMBuilderBase::formatAttributename($ref2[0][1]->getName()),
				'col_own' => $ref1[0][1]->getName(),
				'col_own_attributename' => ORMBuilderBase::formatAttributename($ref1[0][1]->getName()),
				'cross_col' => ORMBuilderBase::formatAttributename($cross_col1),
				'cross_col_org' => $cross_col1,
				'type' => DBReferenceTypes::REFERENCE_MANY_TO_MANY,
				'ref_table' => $table->getName(),
				'assigned' => true,
				'nullable' => false
			);
			// beide fks zeigen auf die selbe tabelle - namen ändern!
			if( count($myReferences) == 1)
				$myArray1['referenz_name_org'] = $myArray1['referenz_name_org'].'_'.$myArray1['cross_col_org'];

			$fk_tables[$ziel1->getName()][] = $myArray1;

			$myArray2 = array(
				'table' => $ziel1->getName(),
				'referenz_name' => ORMBuilderBase::makeClassName($ziel1->getName()),
				'referenz_name_org' => str_replace('tbl_','',strtolower($ziel1->getName())),
				'quelle_name' => $ziel2->getName(),
				'quelle_name_org' => str_replace('tbl_','',strtolower($ziel2->getName())),
				'classname' => ORMBuilderBase::makeClassName($ziel1->getName()),
				'quelle_classname' => ORMBuilderBase::makeClassName($ziel2->getName()),
				'quelle_tablename' => $ziel2->getName(),
				'col_ref' => $ref1[0][1]->getName(),
				'col_ref_attributename' => ORMBuilderBase::formatAttributename($ref1[0][1]->getName()),
				'col_own' => $ref2[0][1]->getName(),
				'col_own_attributename' => ORMBuilderBase::formatAttributename($ref2[0][1]->getName()),
				'cross_col' => ORMBuilderBase::formatAttributename($cross_col2),
				'cross_col_org' => $cross_col2,
				'type' => DBReferenceTypes::REFERENCE_MANY_TO_MANY,
				'ref_table' => $table->getName(),
				'assigned' => true,
				'nullable' => false
			);
			// beide fks zeigen auf die selbe tabelle - namen ändern!
			if( count($myReferences) == 1)
				$myArray2['referenz_name_org'] = $myArray2['referenz_name_org'].'_'.$myArray2['cross_col_org'];

			$myArray2['referenz_name'] = ORMBuilderBase::makeClassName($myArray2['referenz_name_org']);

			$fk_tables[$ziel2->getName()][] = $myArray2;

			// m2m hinzufügen - verknüpfungstabelle braucht auch referenzierungen
			$myArray1['type'] = DBReferenceTypes::REFERENCE_SINGLE_TO_MANY;
			$myArray1['col_own'] = $myArray2['cross_col_org'];
			$myArray1['col_own_attributename'] = $myArray2['cross_col'];
			$myArray2['type'] = DBReferenceTypes::REFERENCE_SINGLE_TO_MANY;
			$myArray2['col_own'] = $myArray1['cross_col_org'];
			$myArray2['col_own_attributename'] = $myArray1['cross_col'];
			if( !isset($fk_tables[$table->getName()]) )
				$fk_tables[$table->getName()] = array();
			$fk_tables[$table->getName()][] = $myArray1;

			if(!$rare_reference_2to1_self)
				$fk_tables[$table->getName()][] = $myArray2;

			$m2m_tables[$table->getName()] = array($ziel1->getName(), $ziel2->getName());
		}else{

			// default - SINGLE-TO-MANY
			foreach ( $table->getForeignKeys() as $fk ){
				$references = $fk->getReferences();
				$ref_column = $references[0][1];
				$own_column = $references[0][0];

				$own_type = DBReferenceTypes::REFERENCE_SINGLE_TO_MANY;
				// type rausfinden
				$primarykey_cols = $ref_column->getTable()->getPrimaryKey()->getColumns();

				// ziel checken und selbst die referenz geben, ziel ist meisst "single" -> PK
				if( count($primarykey_cols) == 1 AND $ref_column->getName() == $primarykey_cols[0]->getName() )
					$own_type = DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE;

				$ref_table = $ref_column->getTable();

				// wenn die referenz mehrfach vorhanden ist - werden die referenz namen anhand des spaltennamens geändert - "managerid_sender, managerid_recipient"
				$referenz_name_own_org = $ref_table->getName();
				$referenz_name_ref_org = $table->getName();
				$referenz_name_own = ORMBuilderBase::makeClassName(ORMBuilderBase::makeRefName($referenz_name_own_org));
				$referenz_name_ref = ORMBuilderBase::makeClassName(ORMBuilderBase::makeRefName($referenz_name_ref_org));
				if( $myReferences[$ref_table->getName()] > 1 ){
					$referenz_name = $own_column->getName();
					if( strpos($referenz_name, '_') )
						$referenz_name = substr($referenz_name, strpos($referenz_name, '_')+1 );

					$referenz_name_own_org = $ref_table->getName() .'_'. $referenz_name;
					$referenz_name_ref_org = $table->getName() .'_'. $referenz_name;
					$referenz_name_own = ORMBuilderBase::makeClassName($ref_table->getName()) . ORMBuilderBase::makeClassName($referenz_name);
					$referenz_name_ref = ORMBuilderBase::makeClassName($table->getName()) . ORMBuilderBase::makeClassName($referenz_name);
				}


				// ziel referenz prüfen
				$ziel_type = DBReferenceTypes::REFERENCE_SINGLE_TO_MANY;
				// wenn fk auch ein pk ist - dann kanns nur single sein
				$pk_check = $table->getPrimaryKey()->getColumns();
				// wenn nur ein PK gesetzt ist und diese spalte mit der Referenz-spalte übereinstimmt, handelt es sich um "single"
				if($pk_check[0]->getName() == $ref_column->getName() and count($pk_check) == 1)
					$ziel_type = DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE;
				// wenn fk ein unique ist - dann kanns nur single sein
				foreach ($table->getIndices() as $index ) {
					$idx_cols = $index->getColumns();
					if($idx_cols[0]->getName() == $ref_column->getName() AND $index->isUnique() == true )
						$ziel_type = DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE;
				}


				// selbst eine referenz geben
				// nur wenn ziel tabelle nicht eigene ist - Selbstreferenz
				if($table->getName() != $ref_table->getName()){
					$myArray = array(
						'table' => $ref_table->getName(),
						'referenz_name' => $referenz_name_own,
						'referenz_name_org' => str_replace('tbl_','',strtolower($referenz_name_own_org)),
						'quelle_name' => $referenz_name_ref,
						'quelle_name_org' => str_replace('tbl_','',strtolower($referenz_name_ref_org)),
						'classname' => ORMBuilderBase::makeClassName($ref_table->getName()),
						'quelle_classname' => ORMBuilderBase::makeClassName($table->getName()),
						'quelle_tablename' => $table->getName(),
						'type' => $own_type,
						'type_ziel' => $ziel_type,
						'col_ref' => $ref_column->getName(),
						'col_ref_attributename' => ORMBuilderBase::formatAttributename($ref_column->getName()),
						'col_own' => $own_column->getName(),
						'col_own_attributename' => ORMBuilderBase::formatAttributename($own_column->getName()),
						'ref_table' => null,
						'assigned' => true,
						'nullable' => $own_column->isNullable()
					);
					$fk_tables[$table->getName()][] = $myArray;
				}


				$myArray = array(
					'table' => $table->getName(),
					'referenz_name' => $referenz_name_ref,
					'referenz_name_org' => str_replace('tbl_','',strtolower($referenz_name_ref_org)),
					'quelle_name' => $referenz_name_own,
					'quelle_name_org' => str_replace('tbl_','',strtolower($referenz_name_own_org)),
					'classname' => ORMBuilderBase::makeClassName($table->getName()),
					'quelle_classname' => ORMBuilderBase::makeClassName($table->getName()),
					'quelle_tablename' => $table->getName(),
					'type' => $ziel_type,
					'type_ziel' => $own_type,
					'col_ref' => $own_column->getName(),
					'col_ref_attributename' => ORMBuilderBase::formatAttributename($own_column->getName()),
					'col_own' => $ref_column->getName(),
					'col_own_attributename' => ORMBuilderBase::formatAttributename($ref_column->getName()),
					'ref_table' => null,
					'assigned' => true,
					'nullable' => false
				);
				if($table->getName() == $ref_table->getName())
					$myArray['nullable'] = $own_column->isNullable();
				$fk_tables[$ref_table->getName()][] = $myArray;
			}
		}

	}

	// referenztabellen markieren - die selber keine fks besitzen
	$fk_tables['unassigned'] = array();
	if($myConfig->getReferenceIsUnassigned() == false)
	foreach ($myTables as $table){

		$assigned = false;
		foreach ( $m2m_tables as $quertabelle ){
			if( in_array($table->getName(), $quertabelle) )
				$assigned = true;
		}
		if( count($table->getForeignKeys()) == 0 AND $assigned == false )
			$fk_tables['unassigned'][] = $table->getName();
	}
	//var_dump($m2m_tables,$fk_tables['tbl_association']);
	#die();
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //

	$myDatabase = DBAbstractionCreole::getDatabase(DBConnection::getConnection($myConfig)->getDatabaseInfo());
	foreach($myDatabase->getTables() as $myTable ){
		// DAO klassen bauen
		$blah = ORMBuilderQueryClass::build($myConfig, $myTable,$fk_tables, $m2m_tables);
		$blah = ORMBuilderDAOClass::build($myConfig, $myTable,$fk_tables, $m2m_tables);
		$blah = ORMBuilderBaseObjectClass::build($myConfig, $myTable, $fk_tables);
		$blah = ORMBuilderAbstractionClass::build($myConfig, $myTable,$fk_tables, $m2m_tables);
		$blah = ORMBuilderBaseClass::build($myConfig, $myTable,$fk_tables, $m2m_tables);
		$blah = ORMBuilderListClass::build($myConfig, $myTable);

		echo str_repeat(' ',256);
		if (ob_get_length()){
        @ob_flush();
        @flush();
    }

	}
	$blah = ORMBuilderLibraryClass::build($myConfig, $myDatabase);
	if($myConfig->getIncludeSystem() == true)
		$blah = ORMBuilderTemplateClass::build($myConfig, $myDatabase);
	echo '<font color="green">Alle Dateien wurden erfolgreich erstellt!</font>';
	echo str_repeat(' ',256);
	if (ob_get_length()){
    @ob_flush();
  	@flush();
  }
}
?>
<style type="text/css">
body {
	font-family: helvetica;
	font-size: 14;
}

legend {
	color: blue;
	font-size: 16;
}

input {
	width: 300px;
}
</style>
<title>ORMCompiler - v0.1 beta</title>
<h1>ORMCompiler</h1>
<form action="" method="post">
<fieldset>
	<legend>Extensions</legend>
<?
if( class_exists('PDO') AND in_array('mysql', PDO::getAvailableDrivers()) )
	echo 'PDO - <span style="color: green">"MySQL für PDO" ist aktiviert und kann benutzt werden!</span>';
?>
</fieldset>
<br />

<fieldset>
	<legend>DBConfig</legend>
	<input type="text" name="driver" value="<?=$myConfig->getDbDriver()?>"> Driver<br><br>
	<input type="text" name="charset" value="<?=$myConfig->getDbCharset()?>"> Charset<br><br>
	<input type="text" name="host" value="<?=$myConfig->getDbHost()?>"> Host<br><br>
	<input type="text" name="database" value="<?=$myConfig->getDbDatabase()?>"> Database<br><br>
	<input type="text" name="username" value="<?=$myConfig->getDbLoginname()?>"> Loginname<br><br>
	<input type="text" name="passwort" value="<?=$myConfig->getDbPassword()?>"> Passwort<br>
</fieldset>
<br />

<fieldset>
	<legend>Paths</legend>
	<input type="text" name="application" value="<?=$myConfig->getApplicationPath()?>" style="width: 500px;"> Application-Path<br><br>
	<input type="text" name="abstraction" value="<?=$myConfig->getAbstractionPath()?>" style="width: 500px;"> Abstraction-Path<br><br>

	<br />
	PDO benutzen <input type="radio" name="pdo" value="1" <?=( !$myConfig->getCreolePath() ? 'checked="checked"' : '' ) ?> style="width: inherit;">
	Creole benutzen <input type="radio" name="pdo" value="0" <?=( $myConfig->getCreolePath() ? 'checked="checked"' : '' ) ?> style="width: inherit;"> <br/>
	<input type="text" name="creole" value="<?=$myConfig->getCreolePath()?>" style="width: 500px;"> Creole-Path<br>
</fieldset>
<br />

<fieldset>
	<legend>Additionals</legend>
	<input type="checkbox" name="reference_is_unassigned" <?=($myConfig->getReferenceIsUnassigned() == true ? 'checked="checked"' : '')?>> Referenzen für Tabellen die selbst keine besitzen. (z.B: Status))<br>

	<input type="checkbox" name="include_system" <?=($myConfig->getIncludeSystem() == true ? 'checked="checked"' : '')?>> System Tools (DAO, Creole, Exception, List, Iterators, ...)<br>
	<input type="text" name="system" value="<?=$myConfig->getSystemPath()?>" style="width: 500px;"> System-Path<br>

</fieldset>

<br />
<input type="submit" value="::::::::::::::::::::::: Build and save config :::::::::::::::::::::::">
</form>

<h1>Installation</h1>
<pre>
1. Copy "mvc" folder and rename it as your project root folder.
2. Run ORMCompiler Setup
</pre>

<br /><br />
<h2>Notices</h2>
<pre>
Many-2-Many:
 - Zwischentabelle muss aus Zusammengesetzten Primärschlüssel und gleicher anzahl an ForeignKeys bestehen. [Bsp: 2 IDs und 2 FKs]
 - ACHTUNG: unter MYSQL müssen auf den FK-Spalten auch "KEY"s liegen. "ALTER TABLE `tbl_blah` ADD INDEX ( `spalte` );"
</pre>

<pre>
News:
  - DAO-Objekte werden bald vollständig entfernt. Save-, Update-, Delete-Funktion werden zum AbstractionLayer hinzugefügt.
  - Alle Timestamps werden mittels UNIX_TIMESTAMP und FROM_UNIXTIME ausgelesen/übergeben

Todos:
  - m2m macht bei den querys noch probeleme - eine Tabelle die mit zwei FK auf eine Tabelle zeigt ist schwer zu joinen
  - m2m referenz die auf sich selbst zeigt .... Freundesliste - Im Moment noch nicht verfügbar. Referenz wird ignoriert. Erstmal raus mit dem scheiss - bevor ich noch durchdreh
 </pre>