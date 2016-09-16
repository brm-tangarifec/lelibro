<?php
//error_reporting(E_ALL);
require("db/requires.php");
 ini_set('display_errors', '0');


$general= new General();

$regiones= $general->getTotalDatos("FtDepartamento");
//printVar($regiones);
	$smarty->assign('regiones',$regiones);
	//$smarty->assign('camisetasini',$camisetasG);
	$smarty->display("index.html"); 

?>