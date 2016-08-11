<?
#ä
set_time_limit(0);
session_write_close();

Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER_CONTENT());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE_PLACEHOLDER());

if( !empty($_REQUEST['import']) )
{

	@touch(GLOBAL_DOCUMENT_ROOT.'/project/tbl_translation_placeholder_misses.csv');
	$file = file_get_contents(GLOBAL_DOCUMENT_ROOT.'/project/tbl_translation_placeholder.csv');
	$rows = preg_split('/\r\n/', $file);
	foreach ( $rows as $key => $row )
	{
		if( $key == 0 )
			continue;

		$values = preg_split('/\";\"/', $row);

		$placeholder = substr($values[0], 1);
		$text = substr($values[1],0, -1);
		$text = str_replace('""', '"', $text);


		$myPlaceholder = TranslationPlaceholderManager::getTranslationPlaceholderByPlaceholdername($placeholder);
		if( !$myPlaceholder )
		{
			var_dump($placeholder, $text, $values);
			die();
		}

		$myQuery = new TranslationPlaceholderContentQuery();
		$myQuery->add( TranslationPlaceholderContentQuery::TRANSLATIONPLACEHOLDERID, Criteria::EQUAL, $myPlaceholder->getTranslationplaceholderid() );
		$myQuery->add( TranslationPlaceholderContentQuery::LANGUAGEISO2, Criteria::EQUAL, 'EN' );
		$myContent = $myQuery->findOne();

		if( !$myContent )
		{
			$myContent = new TranslationPlaceholderContent();
			$myContent->setTranslationplaceholderid($myPlaceholder->getTranslationplaceholderid());
			$myContent->setLanguageiso2('EN');
		}
		$myContent->setContent($text);
		$myContent->setHash(md5($text));

		try {
			echo "save<hr>";
			TranslationPlaceholderContentManager::save($myContent);
		} catch (Exception $e) {
			var_dump($placeholder , $text);
			$csv_line = '"'.$placeholder.'";"'.$text.'"'."\r\n";
			file_put_contents(GLOBAL_DOCUMENT_ROOT.'/project/tbl_translation_placeholder_misses.csv', $csv_line);
		}


	}

}

// CACHE füllen
$cache_renew = '';
if( !empty($_REQUEST['cache']) )
{
	TranslationTemplateManager::cacheTranslations();
	$cache_renew = '<br /><span style="color: green">Cache wurde erneuert!</span>';
}

if(  !empty($_REQUEST['content']) AND !empty($_REQUEST['placeholderid']) )
{
	$return = null;
	$placeholderid = (int) $_REQUEST['placeholderid'];
	$myPlaceholder = TranslationPlaceholderManager::getTranslationPlaceholderByTranslationplaceholderid($placeholderid);

	$myQuery = new TranslationPlaceholderContentQuery(false);
	$myQuery->add(TranslationPlaceholderContentQuery::TRANSLATIONPLACEHOLDERID, Criteria::EQUAL, $placeholderid);
	$myContentList = $myQuery->find();

	foreach ( $_REQUEST['content'] as $language => $content )
	{
		//$content = trim($content); // erstmal raus - an bestimmten stellen möchte ich kein trim
		$content = stripslashes($content);

		$myContent = $myContentList->getBySearch('languageiso2', strtoupper($language));

		// prüfen ob inhalt schon vorhanden ist
		$exists = false;
		$rs = BaseDAO::genericQuery('SELECT placeholdername FROM tbl_translation_placeholder holder,tbl_translation_placeholder_content content WHERE content.translationplaceholderid = holder.translationplaceholderid AND content.hash = ? AND content.languageiso2 = ?', array(md5($content), strtoupper($language)));
		if( $rs->next() )
			$exists = $rs->getString('placeholdername');

		if( !$myContent )
			$myContent = new TranslationPlaceholderContent();
		$myContent->setTranslationplaceholderid($placeholderid);
		$myContent->setHash(md5($content));
		$myContent->setContent($content);
		$myContent->setLanguageiso2(strtoupper($language));

		if( !$exists )
		{
			TranslationPlaceholderContentManager::saveOnly($myContent);
			TranslationTemplateManager::cacheTranslations($placeholderid, $language);
		 	DBConnection::commit();
		 	$return = 'ok';
		}
	}

	// als ajax aufruf
	if( !empty($_REQUEST['send_content']) )
	{
		#if( $exists )
		#	$return = "Achtung: Der Text ist bereits vorhanden!\n\nBitten den entsprechenden Platzhalter verwenden!\n\nPlatzhaltername: [".$exists."]";

		exit($return);
	}
}

$templateid = ( !empty($_GET['templateid']) ? (int) $_GET['templateid'] : null );

$myTemplate = null;
if($templateid)
{
	$myTemplate = TranslationTemplateManager::getTranslationTemplateByTranslationtemplateid($templateid);
}

// template löschen
if( !empty($_GET['deletetemplate']) )
{
	BaseDAO::genericQuery('DELETE FROM tbl_translation_template_placeholder WHERE translationtemplateid = ?', array((int)$_GET['deletetemplate'] ));
	BaseDAO::genericQuery('DELETE FROM tbl_translation_template WHERE translationtemplateid = ?', array((int)$_GET['deletetemplate'] ));
}

// Platzhalter neu anlegen
$placeholder = null;
if( !empty($_POST['placeholder']) )
{
	$values = explode(',', $_POST['placeholder']);

	foreach ( $values as $name )
	{
		$name = str_replace(' ', '', $name);
		$name = strtolower($name);

		$exists = TranslationPlaceholderManager::getTranslationPlaceholderByPlaceholdername($name);
		if( $exists ){
			$assign = $exists->getTranslationplaceholderid();
		}else{
			$placeholder = new TranslationPlaceholder();
			$placeholder->setPlaceholdername($name);
			TranslationPlaceholderManager::saveOnly($placeholder);
			$assign = $placeholder->getTranslationplaceholderid();
		}

		try {
			// zuweisen
			$myTemplatePlaceholder = new TranslationTemplatePlaceholder();
			$myTemplatePlaceholder->setTranslationtemplateid($templateid);
			$myTemplatePlaceholder->setTranslationplaceholderid($assign);
			TranslationTemplatePlaceholderManager::saveOnly($myTemplatePlaceholder);
		} catch (Exception $e) {
		}

	}

}

// zuweisen
if( !empty($_POST['assign']) )
{
	$placeholderid = (int) $_POST['assign'];
	// platzhalter system zuweisen
	$myTemplatePlaceholder = new TranslationTemplatePlaceholder();
	$myTemplatePlaceholder->setTranslationtemplateid($templateid);
	$myTemplatePlaceholder->setTranslationplaceholderid($placeholderid);
	try {
		TranslationTemplatePlaceholderManager::saveOnly($myTemplatePlaceholder);
		DBConnection::commit();
	} catch (Exception $e) {
	}

}

if( !empty($_GET['deleteplaceholder']) )
{
	// TODO: Content löschen
	BaseDAO::genericQuery('DELETE FROM tbl_translation_template_placeholder WHERE translationplaceholderid = ?', array((int)$_GET['deleteplaceholder'] ));
	BaseDAO::genericQuery('DELETE FROM tbl_translation_placeholder_content WHERE translationplaceholderid = ?', array((int)$_GET['deleteplaceholder'] ));
	BaseDAO::genericQuery('DELETE FROM tbl_translation_placeholder WHERE translationplaceholderid = ?', array((int)$_GET['deleteplaceholder'] ));
}
// verknüpfung löschen
if( !empty($_GET['deleteassign']) )
	BaseDAO::genericQuery('DELETE FROM tbl_translation_template_placeholder WHERE translationplaceholderid = ? AND translationtemplateid = ? ', array((int)$_GET['deleteassign'], $templateid ));

?>
<style>

	textarea {
		width: 99%;
		height: 100px;
		padding: 5px;
		color: green;
	}
	textarea.disabled {
		background: #EAE4D4;
	}

	fieldset legend {
		font-size: 20px;
		color: blue;
		font-weight: bold;
		font-style: italic;
	}
	fieldset {
		padding: 10px;
		margin: 10px auto;
	}

	.saved {
		color: green;
		font-weight: bold;
		display: none;
	}

	.error {
		color: red;
		font-weight: bold;
		display: none;
	}

	table {
		width: 100%;
		padding: 5px;
	}

	td, th {
		border-bottom: 1px dotted #555;
		padding: 7px;
		margin: 2px;
		width: 300px;
	}

	input {
		color: black;
	}
	input.placeholdername {
		font-weight: bold;
	}

</style>
<div class="box">
	<div class="box_content ticket">

		<a href="?">Templateübersicht / Übersetzungen</a>

		<a href="?cache=true<?=( $templateid ? '&templateid='.$templateid : '' )?>" style="margin-left: 30px; color: red">[CACHE NEU ERZEUGEN]</a>
		<?=$cache_renew?>
		<br />

		<? if( !$templateid ){
		// template wo noch übersetzungen für englisch fehlen
		$res = BaseDAO::genericQuery('
		select count(*) cnt, translationtemplateid from tbl_translation_template_placeholder where translationplaceholderid in
		(
			SELECT translationplaceholderid FROM tbl_translation_placeholder pl where (select count(*) from tbl_translation_placeholder_content where pl.translationplaceholderid = translationplaceholderid AND languageiso2 = \'EN\'  ) = 0
		)
		group by translationtemplateid
		', array());
		$needed_list = array();
		while($res->next())
			$needed_list[$res->getInt('translationtemplateid')] = $res->getInt('cnt');
		?>
		<fieldset>
			<legend>Templates</legend>
			<ul>
			<?
			if( !empty($_POST['template']) AND !empty($_POST['description']) )
			{
				BaseDAO::genericQuery('OPTIMIZE TABLE tbl_translation_template', array());
				$template = new TranslationTemplate();
				$template->setTemplatename(strtolower($_POST['template']));
				$template->setCommentary($_POST['description']);
				TranslationTemplateManager::saveOnly($template);
			}
			$myQuery = new TranslationTemplateQuery();
			$myQuery->AddOrder(TranslationTemplateQuery::TEMPLATENAME, Criteria::ASC);
			$myQuery->setLimit(999);
			foreach( $myQuery->find() as $template )
			{
				$template instanceof TranslationTemplate;

				echo '
				<li>
					<a href="?templateid='.$template->getTranslationtemplateid().'">'.$template->getTemplatename().'</a> <span class="tip">('.$template->getCommentary().')</span>
					<a href="?deletetemplate='.$template->getTranslationtemplateid().'" style="color: red" onclick="if(!confirm(\'Achtung damit werden alle Verknüpfungen gelöscht!!\')) return false;">[X]</a>
					'.( isset($needed_list[$template->getTranslationtemplateid()]) ? '<span style="color: grey; font-style: italic">(Es fehlen '.$needed_list[$template->getTranslationtemplateid()].' Übersetzungen)</span>' : '' ).'
				</li>';
			}
			//$myTemplate
			?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Neues Template anlegen:</legend>
			<form action="?" method="post">
				<input type="text" name="template" value="" placeholder="name" size="30" />
				<input type="text" name="description" size="50" value="" placeholder="beschreibung" />
				<input type="submit" value="Template anlegen">
			</form>
		</fieldset>
		<? } ?>

		<? if( isset($_GET['templateid']) ){ ?>
		<fieldset>
			<legend>Template: [ <?=$myTemplate->getTemplatename()?> ]</legend>
			<table>
				<tr>
					<th width="10%">Platzhalter</th>
					<th witdh="30%">DE</th>
					<th witdh="30%">EN</th>
					<!-- <th witdh="22%">IT</th> -->
				</tr>
			<?
			// verknüpfung löschen
			$info = 'Keine &lt;br/&gt; benutzen!';

			// Farben
			// http://www.franken-maxit.de/uploads/RTEmagicC_purcalc_farben_01.jpg.jpg
			$colors = array(
				'/^title\_/' => '#97A9D9',
				'/^button\_/' => '#FFDFAC',
				'/^nav\_/' => '#D3E6F4',
			);

			$sql = '
			SELECT
				pl.placeholdername, pl.translationplaceholderid
			FROM
				tbl_translation_placeholder pl
			#JOIN#
			ORDER BY placeholdername ASC
			';
			$sql = str_replace('#JOIN#', 'INNER JOIN tbl_translation_template_placeholder temp ON temp.translationplaceholderid = pl.translationplaceholderid AND temp.translationtemplateid = ?', $sql);
			$rs = BaseDAO::genericQuery($sql, array($templateid));
			while( $rs->next() )
			{
				$placeholderid = $rs->getInt('translationplaceholderid');
				$placeholdername = $rs->getString('placeholdername');
				$keys[$placeholderid] = $placeholdername;

				$content = array();
				$content['DE'] = '';
				$content['EN'] = '';
				$br_count = 1;
				$myQuery = new TranslationPlaceholderContentQuery(false);
				$myQuery->add(TranslationPlaceholderContentQuery::TRANSLATIONPLACEHOLDERID, Criteria::EQUAL, $placeholderid);
				$myContentList = $myQuery->find();
				foreach ( $myContentList as $text )
				{
					$content[$text->getLanguageiso2()] = stripslashes($text->getContent());
					$count = substr_count($text->getContent(), "\n") + 1;
					if( $count > $br_count )
						$br_count = $count;
				}

				$height = ($br_count * 32);

				$color = '';
				foreach ( $colors as $regexp => $hex )
					if( preg_match($regexp, $placeholdername) )
						$color = 'style="background-color: '.$hex.'"';

				$link = '<br /><a style="color: red" onclick="if(!confirm(\'Willst du den Platzhalter wirklich löschen?\n\nAchtung:\nÜbersetzungen werden auch gelöscht!!!\')) return false;" href="?deleteplaceholder='.$placeholderid.( $myTemplate ? '&templateid='.$templateid : '' ).'">[Platzhalter löschen]</a>';
				if($myTemplate)
					$link = '<br /><a style="color: orange" href="?templateid='.$templateid.'&deleteassign='.$placeholderid.'">[Verknüpfung lösen]</a>'.$link;

				$placeholdername_contant = 'LANG_'.strtoupper($placeholdername);

				echo '
				<form action="" method="post">
				<tr '.$color.'>
					<td>
						<b style="color: black">'.$placeholdername.'</b>
						'.$link.'
						<input onclick="this.select(); this.focus();" value="'.$placeholdername_contant.'" style="background: #DDD" />
						<input type="hidden" name="placeholderid" value="'.$placeholderid.'" />
					</td>
					<td>
						<textarea name="content[de]" class="'.( empty($content['DE']) ? 'disabled' : '' ).'" style="height: '.$height.'px" >'.@$content['DE'].'</textarea>
						<input type="submit" value="Speichern" class="submit-content" /> <span class="saved">Gespeichert!</span> <span class="error">Error!</span> '.$info.'
					</td>
					<td>
						<textarea name="content[en]" class="'.( empty($content['EN']) ? 'disabled' : '' ).'" style="height: '.$height.'px">'.@$content['EN'].'</textarea>
						<input type="submit" value="Speichern" class="submit-content" /> <span class="saved">Gespeichert!</span> '.$info.'
					</td>
				</tr>
				</form>
				';
			}
			//$myTemplate
			?>
			</table>

			<br />
			<? if($myTemplate){ ?>
			<form action="?templateid=<?=$templateid?>" method="post">
				Platzhalter mit Template [<?=$myTemplate->getTemplatename()?>] verknüpfen:<br />
				<select name="assign">
					<?
					$myQuery = new TranslationPlaceholderQuery();
					$myQuery->AddOrder(TranslationPlaceholderQuery::PLACEHOLDERNAME, Criteria::ASC);
					$myQuery->setLimit(999);
					$myQuery->AddGroupBy(TranslationPlaceholderQuery::PLACEHOLDERNAME);
					foreach ( $myQuery->find() as $placeholder )
					{
						if( isset($keys[$placeholder->getTranslationplaceholderid()]) )
							continue;

						$content = '';
						echo '<option value="'.$placeholder->getTranslationplaceholderid().'" title="'.$content.'">'.$placeholder->getPlaceholdername().'</option>';
					}
					?>
				</select>
				<input type="submit" value="Platzhalter verknüpfen">
			</form>
			<? } ?>
		</fieldset>

		<fieldset>
			<legend>Platzhalter neu anlegen</legend>
			<form action="<?=( $myTemplate ? '?templateid='.$templateid : '' )?>" method="post">
				<br />
				Platzhaltername:
				<input type="text" name="placeholder" value="" placeholder="name" size="30" />
				<input type="submit" value="Platzhalter anlegen">
				<br /> Hinweis: <i>Platzhalter wird automatisch mit diesem Template verknüpft - auch wenn er bereits vorhanden ist</i>
				<br /> Hinweis: <i>Es können auch mehrere Platzhalter getrennt durch ein Komma "," angegeben werde</i>
			</form>
		</fieldset>
		<? } ?>

	</div>
</div>
</body>
</html>
<?
DBConnection::commit();
