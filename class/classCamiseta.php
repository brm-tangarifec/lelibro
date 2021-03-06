<?php
class camisetaFt {

	
	function traeCiudad($idRegion){

	//DB_DataObject::debugLevel(5);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory('FtCiudad');
		$objDBO -> selectadd();
		$objDBO -> selectadd('idCiudad,nombre');
		$objDBO -> orderBy("idCiudad ASC");
		$objDBO -> whereAdd("idDepto=" . $idRegion);
		//$objDBO -> limit('1');
		$objDBO -> find();
		
		$count = 0;
		while ($objDBO -> fetch()) {
			$ret[$count]->idCiudad = $objDBO->idCiudad;
			$ret[$count]->nombre = utf8_encode($objDBO->nombre);
			$count++;
		}
		//$ret = $ret + 1;
		//Libera el objeto DBO
		return $ret;
		$objDBO -> free();


		}

	

	function registraSolicitante($campos){
		//printVar($campos);
		DB_DataObject::debugLevel(3);
		$dbdata = DB_DataObject::Factory('LncRegistro');
		$dbdata->nombreCompleto = $campos['nombre'];
		$dbdata->email = $campos['email'];
		$dbdata->idea = $campos['idea'];
		$dbdata->multimedia = $campos['urlArchivo'];
		$dbdata->idDepto = $campos['idDepto'];
		$dbdata->idCiudad = $campos['idCiudad'];
		$dbdata->direccion = $campos['direccion'];
		$dbdata->tipoDocumento = $campos['tipoDocumento'];
		$dbdata->documento = $campos['documento'];
		$dbdata->fechaNacimiento = $campos['fnacimiento'];
		$dbdata->autorizoNestle = $campos['autorizaNestle'];
		$dbdata->aceptoTerminos = $campos['terminos'];
		$dbdata->fecha = date("Y-m-d H:i:s");

		$dbdata -> insert();

		$dbdata -> free();
		return $dbdata->id;
	}

	/*Valida cedula registrada*/
	function cedulaRegistrada($cedula){
		$dbdata = DB_DataObject::Factory('LncRegistro');
		$dbdata->selectAdd();
		$dbdata->selectAdd('id,documento');
		$dbdata->whereAdd("documento ='".$cedula."'");
		$dbdata->find();
		$count = 0;
		while ($dbdata -> fetch()) {
			$cedulaE[$count] -> id = $dbdata -> id;
			$cedulaE[$count] -> documento = $dbdata -> documento;
			$count++;
		}
		//printVar($existe);
		return $cedulaE;
		$dbdata-> free();
	}
	/*Valida cedula registrada*/
	function emailRegistrado($email){
		$dbdata = DB_DataObject::Factory('LncRegistro');
		$dbdata->selectAdd();
		$dbdata->selectAdd('id,email');
		$dbdata->whereAdd("email ='".$email."'");
		$dbdata->find();
		$count = 0;
		while ($dbdata -> fetch()) {
			$cedulaE[$count] -> id = $dbdata -> id;
			$cedulaE[$count] -> email = $dbdata -> email;
			$count++;
		}
		//printVar($existe);
		return $emailE;
		$dbdata-> free();
	}
	
	/*Cuenta camisetas por usuario*/
	function cuentaUsuario($idUsuario){

		//printVar($idUsuario);
		$usuario=DB_DataObject::Factory('FtLoteXUsuario');
		$usuario->whereAdd("idUsuario='".$idUsuario."'");
		$total = $usuario->count(DB_DATAOBJECT_WHEREADD_ONLY);
		$usuario->free();
		return $total;
	}

	function subeArchivo($campos){
		//printVar($campos);
		
			//ini_set('display_errors', '1');		
			$rutaDir=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['REQUEST_URI']).'/files/';
			//$rutaDir=dirname($_SERVER['REQUEST_URI']).'/files/';
			printVar($rutaDir);
			//$rur= $_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/facturas/'.$parametros[0];
			
			if(file_exists($rutaDir)){ // verifica que la carpeta esta creada 
				//++++++
				$ext=explode('.',$campos['archivo']['name']);
					//var_dump($campos['archivo']);
					$imgOriginal=$campos['archivo']['name'];
					$temporal=$campos['archivo']['tmp_name'];
					$imgFinal=$campos['documento'].'-'.date('Y_m_d_H_i_s').'.'.$ext[1];
					//printVar($imgFinal);
					$urlDef=$rutaDir.$imgFinal;
					$guarda=move_uploaded_file($temporal, $urlDef);//$guarda true si guardo la factura en la carpeta recien creada
					//printVar($guarda);
					if ($guarda) { //si guarda la imagen en la carpeta

							return 'files/'.$imgFinal;
						
					}else{// si no gurado la imagen en la carpeta
						return 'errorG';

					}
					

				//+++++++
				//echo 'si existe la carpeta';
			
				
	}
}
}
?>
