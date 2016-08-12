<?php
#ä

abstract class DirectoryManager {
	
	//erstellt einen neuen Pfad
	public static final function makeDIR($ordnerstruktur, $lpuid = 0){
	
		$chmod = 0777;
		$x = 0;
		
		if($lpuid != 0){
			$x = 1;
			
			$dir = $ordnerstruktur[0];
			if (!is_dir($dir)) { mkdir($dir,$chmod); chmod($dir,$chmod); }
			
			$md5 = md5($lpuid);
			$newstring = str_split($md5,2);
			$dir = $dir."/".$newstring[0];
			if (!is_dir($dir)) { mkdir($dir,$chmod); chmod($dir,$chmod); }
			
			$dir = $dir."/".$lpuid;
	
			if (!is_dir($dir)) { mkdir($dir,$chmod); chmod($dir,$chmod); }
		}
		
		for($i = $x; $i < count($ordnerstruktur); $i++){
			//Pfad noch abändern
			$dir .= $ordnerstruktur[$i];
			if (!is_dir($dir)) { mkdir($dir,$chmod); chmod($dir,$chmod); }
		}
			
		return $dir;
	}
	
	public static final function getAbsoluteDirPath($ordnerstruktur, $lpuid = 0){
		$myPath = GLOBALCONFIG_GLOBALDIR.'/';
		$myPath .= $ordnerstruktur[0].'/';
		$myPath .= str_split(md5($lpuid),2).'/';
		for($i=1;$i<=count($ordnerstruktur);$i++){
			$myPath .= $ordnerstruktur[$i].'/';
		}
		return $myPath; 
	}
	
	//prüft Bilder nach richtigkeit bevor Sie hochgeladen werden können
	public static final function checkPicture($bild, $max_breite, $max_hoehe) {
		
		if ($bild['type'] == 'image/gif' || $bild['type'] == 'image/jpeg' || $bild['type'] == 'image/pjpeg' || $bild['type'] == 'image/png') {
			$imagesize = getimagesize($bild['tmp_name']);
			$breite = $imagesize[0];
			$hoehe = $imagesize[1];
			$extension = explode(".", $bild['name']);
			$extension = $extension[(count($extension)-1)];
			
			if (($breite <= $max_breite) && ($hoehe <= $max_hoehe)) {
				$output = 1; //bild OK
			} else {
				$output = 2; //Bild zu groß
			}
		} else {
			$output = 3; //Datentyp falsch
		}
		
		return $output;
	}
	
}

?>