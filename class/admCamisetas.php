<?php
class descargCamiseta {

	
	function datosBase(){
//DB_DataObject::debugLevel(1);
		$objDBO = DB_DataObject::Factory('FtLoteXUsuario');
		$objDBO -> selectadd();
		$objDBO -> selectadd('id,lote,idUsuario,refeCamiseta,fecha');
		$objDBO -> orderBy("id ASC");
		//$objDBO -> whereAdd("idDepto=" . $idRegion);
		//$objDBO -> limit('1');
		$objDBO -> find();
		
		$count = 0;
		while ($objDBO -> fetch()) {
			$ret[$count]->id = $objDBO->id;
			$ret[$count]->lote = $objDBO->lote;
			$ret[$count]->idUsuario = $objDBO->idUsuario;
			$ret[$count]->refeCamiseta = $objDBO->refeCamiseta;
			$ret[$count]->fecha = $objDBO->fecha;
			$count++;
		}
		//$ret = $ret + 1;
		//Libera el objeto DBO
		return $ret;
		$objDBO -> free();


		}

		/*Datos de usuario*/
	function traeUsuario($id){
		//DB_DataObject::debugLevel(1);
		$objDBO = DB_DataObject::Factory('FtUsuario');
		$objDBO -> selectadd();
		$objDBO -> selectadd('id,nombre,apellido,email,telefono,genero,idDepto,idCiudad,tipoDocumento,documento,fechaNacimiento');
		$objDBO -> orderBy("id ASC");
		$objDBO -> whereAdd("id=" . $id);
		$objDBO -> limit('1');
		$objDBO -> find();
		
		$count = 0;
		while ($objDBO -> fetch()) {
			$ret[$count]->id = $objDBO->id;
			$ret[$count]->nombre = $objDBO->nombre;
			$ret[$count]->apellido = $objDBO->apellido;
			$ret[$count]->email = $objDBO->email;
			$ret[$count]->telefono = $objDBO->telefono;
			$ret[$count]->genero = $objDBO->genero;
			$ret[$count]->idDepto = $objDBO->idDepto;
			$ret[$count]->idCiudad = $objDBO->idCiudad;
			$ret[$count]->tipoDocumento = $objDBO->tipoDocumento;
			$ret[$count]->documento = $objDBO->documento;
			$ret[$count]->fechaNacimiento = $objDBO->fechaNacimiento;
			
			$count++;
		}
		//$ret = $ret + 1;
		//Libera el objeto DBO
		return $ret;
		$objDBO -> free();
	}
	/*Descarga de usuarios*/
	function departamentoReg($idDepto){
		//debug(1);
		//printVar($idDepto,'hola');
		$deptoReg=DB_DataObject::Factory('FtDepartamento');
		$deptoReg-> selectAdd();
		$deptoReg-> selectAdd("nombre");
		$deptoReg-> whereAdd("idDepto=" . $idDepto);
		$deptoReg -> find();
		$deptoReg->fetch();
		$departamentosReg = $deptoReg->nombre;
		return $departamentosReg;
		$deptoReg -> free();
	}
	/*Ciudades registro*/
	function ciudadReg($idCiudad){
		$ciudadR =DB_DataObject::Factory('FtCiudad');
		$ciudadR-> selectAdd();
		$ciudadR-> selectAdd("nombre");
		$ciudadR-> whereAdd("idCiudad=" . $idCiudad);
		$ciudadR -> find();
		$ciudadR->fetch();
		$ciudadesReg = $ciudadR->nombre;
		return $ciudadesReg;

	}
}
?>
