<?php 
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);
//$varPost = filter_input_array(INPUT_POST);
require 'db/requires.php';

	if( isset($_POST['dni']) && !empty($_POST['dni']) && 
		isset($_POST['sexo']) && !empty($_POST['sexo']) &&
		isset($_POST['nombre']) && !empty($_POST['nombre']) &&
		isset($_POST['apellido']) && !empty($_POST['apellido']) &&
		isset($_POST['email']) && !empty($_POST['email']) &&
		isset($_POST['ciudad']) && !empty($_POST['ciudad']) &&
		isset($_POST['celular']) && !empty($_POST['celular']) &&
		isset($_POST['nacimiento']) && !empty($_POST['nacimiento']) &&
		isset($_POST['terminos']) && !empty($_POST['terminos']) &&
		isset($_POST['politicas']) && !empty($_POST['politicas']) &&
		isset($_FILES['image']) && !empty($_FILES['image']) &&
		isset($_POST['departamento']) && !empty($_POST['departamento'])){
			
			
					$parametros[0] = $_POST['dni'];
					$parametros[1] = $_POST['sexo'];
					$parametros[2] = $_POST['nombre'];
					$parametros[3] = $_POST['apellido'];
					$parametros[4] = $_POST['email'];
					$parametros[5] = $_POST['ciudad'];
					$parametros[6] = $_POST['celular'];
					$parametros[7] = $_POST['nacimiento'];
					$parametros[8] = $_POST['terminos'];
					$parametros[9] = $_POST['politicas'];
					$parametros[10] = $_FILES['image'];
					$parametros[11] = $_POST['departamento'];
					
		$obj = new Registro();
		$ret=$obj->registrar($parametros);
		echo json_encode($ret);
	}else{
		echo 'Error en el envio de los parametros';
	}

	/**/

?>