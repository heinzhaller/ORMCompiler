<?php
#ä

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
// Captcha Image PHP																															v1.0b
//
// Mario Rimpler																														 09.01.2007
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//session_start();
if(isset($_SESSION['captcha_spam']))
	unset($_SESSION['captcha_spam']);

function randomString($len) 
{
  function make_seed(){
     list($usec , $sec) = explode (' ', microtime());
     return (float) $sec + ((float) $usec * 100000);
  }
  srand(make_seed());

  //Der String $possible enthält alle Zeichen, die verwendet werden sollen
  #$possible		= 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
  $possible		= 'ABCDEFGHJKLMNPRSTUVWXYZ23456789'; // mögliche zeichen
  $str				= '';
  while(strlen($str) < $len) {
    $str .= substr($possible,(rand()%(strlen($possible))),1);
  }
return($str);
}

$text = randomString(5);  //Die Zahl bestimmt die Anzahl stellen
$_SESSION['captcha_spam'] = $text; // Durch diese SESSION var wird der captcha abgefragt

header('Content-type: image/png'); // Header auf IMG setzen

//Bild Standartgrössen
$width 		= 140;
$height 	= 40;

//$img 	 	= ImageCreateFromPNG('captcha.png'); //Backgroundimage
$img 			= imagecreatetruecolor($width, $height); // erstellt ein neues Bild
$col1 		= ImageColorAllocate($img, 255, 255, 255); //Farbe weiss
$col2 		= ImageColorAllocate($img, rand(200,255), rand(50,100), rand(50,100)); //Farbe rötlich
//$col3 		= ImageColorAllocate($img, rand(0,100), rand(0,100), rand(0,100)); //Farbe antibot
$r 		 		= rand(0,100); $g = rand(0,100); $b = rand(0,100); // RGB farben
$color 		= ImageColorAllocate($img, $r, $g, $b); //Farbe
$col2 = $color;

// Hintergrundbild mit Brush erzeugen
for( $x = 0; $x < $width; $x++ ) for ($y = 0; $y < $height; $y++){
	$r = rand(1,100);
	if($r < 75 ){
		imagesetpixel  ( $img  , $x  , $y  , $col1 );
	}elseif( $r > 95 ) {
		imagesetpixel  ( $img  , $x  , $y  , $color );
	}else{
		imagesetpixel  ( $img  , $x  , $y  , $col2 );
	}
}

//$r 		 		= rand(0,100); $g = rand(0,100); $b = rand(0,100); // RGB farben
//$color 		= ImageColorAllocate($img, $r, $g, $b); //Farbe

// random lines
for($i = 0; $i < rand(30,50); $i++) {
	$rand_x_1 = rand(0, $width - 1);
	$rand_x_2 = rand(0, $width - 1 - 3);
	$rand_y_1 = rand(0, $height - 1);
	$rand_y_2 = rand(0, $height - 1 - 4);
	imageline($img, $rand_x_1, $rand_y_1, $rand_x_2, $rand_y_2, $color);

	// Set the line thickness to 5
	#imagesetthickness($img, 1);

	// Draw the rectangle
	#imagerectangle($img, $rand_x_1 , $rand_x_1 , $rand_y_1, $rand_y_1, $color);
}
$ttf_rnd  = rand(1,5);
$_SESSION['ttf'] = rand(2,5);
$ttf 			= GLOBAL_INCLUDE_SYSTEMLAYER.'/Captcha/font_'.$ttf_rnd.'.ttf'; //Schriftart random wählen

$ttfsize 	= rand(23,24); //Schriftgrösse
$angle 		= rand(0,5);
$t_x 			= rand(10,15);
$t_y 			= rand(32,35);
imagettftext($img, $ttfsize, $angle, $t_x, $t_y, $color, $ttf, $text);
imagepng($img); //Gibt das Bild aus
imagedestroy($img);
