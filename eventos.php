<?php
require('db/requires.php');
ini_set('display_errors','0');
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
		/*Datos de usauario*/
		if(isset($varPost['email']) && $varPost['email']!='' && isset($varPost['autorizo']) && $varPost['autorizo']=='S'){


		$campos['nombre']=utf8_decode($varPost['nombre']);
		$campos['email']=$varPost['email'];
		$campos['idDepto']=$varPost['idDepto'];
		$campos['idea']=utf8_decode($varPost['idea']);
		$campos['idCiudad']=$varPost['idCiudad'];
		$campos['direccion']=$varPost['direccion'];
		$campos['tipoDocumento']=$varPost['tipodoc'];
		$campos['documento']=$varPost['documento'];
		$campos['fnacimiento']=$varPost['fechaN'];
		$campos['autorizaNestle']=$varPost['autorizo'];
		$campos['terminos']=$varPost['terminos'];
		
		$guardaUsu=$camiseta->registraSolicitante($campos);
		printVar($guardaUsu);
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