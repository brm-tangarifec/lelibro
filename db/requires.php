<?php
@ini_set("display_errors","0");
//error_reporting(E_ALL & ~( E_NOTICE | E_STRICT | E_DEPRECATED ) );

global $prefijo;

require($prefijo."db/DBO.php");

//DataObjects

require($prefijo."db/requires.ini.php");

//Clases
require($prefijo."class/class.General.inc.php");
require($prefijo.'class/classCamiseta.php');

//Smarty
//echo $_SERVER["DOCUMENT_ROOT"];
//require($_SERVER["DOCUMENT_ROOT"]."/mercadazo/Smarty/libs/Smarty.class.php");
require($_SERVER["DOCUMENT_ROOT"]."/Smarty/libs/Smarty.class.php");
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->left_delimiter = '{#';
$smarty->right_delimiter = '#}';

function cambiaParaEnvio($cadena){
	//$cadena = htmlentities($cadena,ENT_NOQUOTES,"ISO8859-1");
	$cadena = utf8_encode($cadena);
	return($cadena);
}

function printVar( $variable, $title = "" ){
	$var = print_r( $variable, true );
	echo "<pre style='background-color:#dddd00; border: dashed thin #000000;'><strong>[$title]</strong> $var</pre>";
}
/* Funciones Facebook */
function objectToArray($d) {
	if (is_object($d)) {
		$d = get_object_vars($d);
	}
	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	} else {
		return $d;
	}
}
		
?>