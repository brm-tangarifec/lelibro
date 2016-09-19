<?php
require('db/requires.php');
ini_set('display_errors','1');
/*se ejecutan eventos dependiendo de lo solicitado*/
$varPost=filter_input_array(INPUT_POST);
$camiseta=new camisetaFt();

//printVar($varPost);
$vrtCtr=$varPost['vrtCrt'];
//printVar($vrtCtr);
switch ($vrtCtr) {
	/*Trae ciudades por departamento*/
	case 'ciudad':
		# code...
	//echo 'Hola';
		  $idRegion=$varPost['idDepto'];
          $ciudad = $camiseta->traeCiudad($idRegion);
          //printVar($ciudad);
          echo json_encode($ciudad);
		break;
	/*Verifica si ya se encuentra registrada la cedula*/
	case 'cc':
		# code...
		$cedula=$varPost['prodCedula'];
		//printVar($cedula);

		$existe=$camiseta->cedulaRegistrada($cedula);
		//printVar($existe[0]->id);
		if($existe[0]->id!=NULL || $existe[0]->id!=0){
			$mensaje='existeC';
		}else{
			$mensaje='noexiste';
		}
		echo json_encode($mensaje);
		break;
	/*Registro de usuario*/
	case 'registrar':
		# code...
		printVar($varPost);
		printVar($_FILES);
		/*Datos de usauario*/
		if(isset($varPost['email']) && $varPost['email']!='' && isset($varPost['autorizo']) && $varPost['autorizo']=='S'){

			$campos['archivo'] = $_FILES['upload-img'];

		$campos['nombre']=utf8_decode($varPost['nombre']);
		$campos['email']=$varPost['email'];
		$campos['idDepto']=$varPost['departamento'];
		$campos['idea']=utf8_decode($varPost['ideaE']);
		$campos['idCiudad']=$varPost['ciudad'];
		$campos['direccion']=$varPost['direccion'];
		$campos['tipoDocumento']=$varPost['tipoD'];
		$campos['documento']=$varPost['numDoc'];
		$campos['fnacimiento']=$varPost['fechaN'];
		$campos['autorizaNestle']=$varPost['autorizo'];
		$campos['terminos']=$varPost['terminos'];
		$subida=$camiseta->subeArchivo($campos);
		$campos['urlArchivo']=$subida;

		//printVar($subida,'Hola s');
		$guardaUsu=$camiseta->registraSolicitante($campos);
		die();
		if($guardaUsu>0){
			$mensaje="exitoso";
		}else{
			$mensaje="noguarda";
		}
	}else{
		$mensaje="Registro no válido";
	}
		echo json_encode($mensaje);
		break;
	/*Valida código de redención*/
	
	default:
		# code...
		break;
}
?>