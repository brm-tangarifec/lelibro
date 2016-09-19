<?php

class Registro{
	function getDatosAdmin(){
		DB_DataObject::debugLevel(0);
		$obj = DB_DataObject::Factory('Admin');
		$obj->find();
		$i=0;
		$contacto=array();
		while($obj->fetch()){
			$contacto[$i]['nombre']=utf8_decode($obj->nombre);
			$contacto[$i]['apellido']=utf8_decode($obj->apellido);
			$contacto[$i]['dni']=$obj->dni;
			$contacto[$i]['img']=$obj->img;
			$contacto[$i]['destino']=$obj->destino;
			$contacto[$i]['url']=$obj->url;
			$contacto[$i]['fecha']=$obj->fecha;
			$contacto[$i]['Departamento']=$obj->Departamento;
			$contacto[$i]['ciudad']=utf8_decode($obj->ciudad);
			$contacto[$i]['email']=$obj->email;
			$i++;
		}
		$obj->free();
		return $contacto;
	}

	function getDatos($dni){
		DB_DataObject::debugLevel(0);
		$obj = DB_DataObject::Factory('Usuario');
		$obj->dni=$dni;
		$obj->find();
		$ret= array();
		if($obj->fetch()){
			
			$ret['dni']=$obj->dni;
			$ret['sexo']=$obj->sexo;
			$ret['nombre']=utf8_decode($obj->nombre);
			$ret['apellido']=utf8_decode($obj->apellido);
			$ret['email']=$obj->email;
			$ret['ciudad']=utf8_decode($obj->ciudad);
			$ret['celular']=$obj->celular;
			$ret['fechaNacimiento']=$obj->fechaNacimiento;
			$ret['terminos']=$obj->terminos;
			$ret['condiciones']=$obj->condiciones;
			$ret['idDepartamento']=$obj->idDepartamento;
		}
		$obj->free();
		return $ret;
	}
	function getDepartamentos(){
		DB_DataObject::debugLevel(0);
		$obj=DB_DataObject::Factory('Departamento');
		$obj->find();
		$ret=array();
		$i=0;
		while ($obj->fetch()) {
			$ret[$i]['id']=$obj->id;
			$ret[$i]['nombre']=utf8_encode($obj->nombre);
			$i++;
		}
		return $ret;
		$obj->free();
	}

	function registrar($parametros){
		
		$existe=$this->existe($parametros[0]);//pregunta si existe el dni en $existe se almacena el id del usuario si es que existe 
		
		if ($existe != 0) {// si existe el usuario 
			
			$rutaDir=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['REQUEST_URI']).'/facturas/'.$parametros[0];
			//$rur= $_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/facturas/'.$parametros[0];
			
			if(file_exists($rutaDir)){ // verifica que la carpeta esta creada 
				//++++++
				$ext=explode('.',$parametros[10]['name']);
					//var_dump($parametros[10]);
					$imgOriginal=$parametros[10]['name'];
					$temporal=$parametros[10]['tmp_name'];
					$imgFinal=$parametros[0].'-'.date('Y_m_d_H_i_s').'.'.$ext[1];
					$urlDef=$rutaDir.'/'.$imgFinal;
					$guarda=move_uploaded_file($temporal, $urlDef);//$guarda true si guardo la factura en la carpeta recien creada
					if ($guarda) { //si guarda la imagen en la carpeta
						
						$ret=$this->agregarFactura($existe,$imgOriginal,$imgFinal,$urlDef);
						if ($ret>0) {  // si agrega los datos a la factura
							return 'ok';
						}else { // si no agrega los datos a la factura 
							return 'bad_factura_usuario_existente';
						}
					}else{// si no gurado la imagen en la carpeta
						return 'bad_guardar_directorio';

					}
					

				//+++++++
				//echo 'si existe la carpeta';
			}else{ //si al verificar la carpeta no esta creada
				//echo 'no existe la carpeta';
				$dir=$this->crearCarpeta($parametros[0]); //dir array [0] true si creo dir [1] direccion del nuevo directorio creado
				if ($dir[0]) { //si creo el directorio
					$ext=explode('.',$parametros[10]['name']);
					//var_dump($parametros[10]);
					$imgOriginal=$parametros[10]['name'];
					$temporal=$parametros[10]['tmp_name'];
					$imgFinal=$parametros[0].'-'.date('Y_m_d_H_i_s').'.'.$ext[1];
					$urlDef=$dir[1].'/'.$imgFinal;
					$guarda=move_uploaded_file($temporal, $urlDef);//$guarda true si guardo la factura en la carpeta recien creada
					if ($guarda) { //si guarda la imagen en la carpeta
						
						$ret=$this->agregarFactura($existe,$imgOriginal,$imgFinal,$urlDef);
						if ($ret>0) {
							return 'ok';
						}else {
							return 'bad_factura';
						}
					}else{// si no gurado la imagen en la carpeta
						return  'bad_guardar_directorio';

					}
				}
				else{ // no creo directorio 
					return 'bad_crear_directorio';

				}
			}
			
			//	
		}
		else { //sii no esta registrado se registra
			DB_DataObject::debugLevel(0);
			$obj=DB_DataObject::Factory('Usuario');
			$obj->dni=$parametros[0];
			$obj->sexo=$parametros[1];
			$obj->nombre=utf8_encode($parametros[2]);
			$obj->apellido=utf8_encode($parametros[3]);
			$obj->email=$parametros[4];
			$obj->ciudad=utf8_encode($parametros[5]);
			$obj->celular=$parametros[6];
			$obj->fechaNacimiento=$parametros[7];
			$obj->terminos='S';
			$obj->condiciones='S';
			$obj->idDepartamento=$parametros[11];
			$obj->fecha= date("Y-m-d H:i:s");
			$reg=$obj->insert();
			
			if ($reg>0) { //si se registro el usuario correctamente 
				
					

				$rutaDir=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['REQUEST_URI']).'/facturas/'.$parametros[0];
				//$rur= $_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/facturas/'.$parametros[0];
				
				if(file_exists($rutaDir)){ // verifica que la carpeta esta creada 
					//++++++
					$ext=explode('.',$parametros[10]['name']);
						//var_dump($parametros[10]);
						$imgOriginal=$parametros[10]['name'];
						$temporal=$parametros[10]['tmp_name'];
						$imgFinal=$parametros[0].'-'.date('Y_m_d_H_i_s').'.'.$ext[1];
						$urlDef=$rutaDir.'/'.$imgFinal;
						$guarda=move_uploaded_file($temporal, $urlDef);//$guarda true si guardo la factura en la carpeta recien creada
						if ($guarda) { //si guarda la imagen en la carpeta
							
							$ret=$this->agregarFactura($reg,$imgOriginal,$imgFinal,$urlDef);
							if ($ret>0) {  // si agrega los datos a la factura
								return 'ok';
							}else { // si no agrega los datos a la factura 
								return 'bad_factura_usuario_noexistente';
							}
						}else{// si no gurado la imagen en la carpeta
							return  'bad_guardar_directorio';

						}
						

					//+++++++
					//echo 'si existe la carpeta';
				}else{ //si al verificar la carpeta no esta creada
					//echo 'no existe la carpeta';
					$dir=$this->crearCarpeta($parametros[0]); //dir array [0] true si creo dir [1] direccion del nuevo directorio creado
					if ($dir[0]) { //si creo el directorio
						$ext=explode('.',$parametros[10]['name']);
						//var_dump($parametros[10]);
						$imgOriginal=$parametros[10]['name'];
						$temporal=$parametros[10]['tmp_name'];
						$imgFinal=$parametros[0].'-'.date('Y_m_d_H_i_s').'.'.$ext[1];
						$urlDef=$dir[1].'/'.$imgFinal;
						$guarda=move_uploaded_file($temporal, $urlDef);//$guarda true si guardo la factura en la carpeta recien creada
						if ($guarda) { //si guarda la imagen en la carpeta
							
							$ret=$this->agregarFactura($reg,$imgOriginal,$imgFinal,$urlDef);
							if ($ret>0) {
								return 'ok';
							}else {
								return 'bad_factura_usuario_noexistente';
							}
						}else{// si no gurado la imagen en la carpeta
							return  'bad_guardar_directorio';

						}
					}
					else{ // no creo directorio 
						return 'bad_crear_directorio_usuario_noexistente';

					}
				}


			}
			else{  // si no se registro correctamente el usuario

				return  'bad_guardar_usuario';
			}
		
		$obj->free();
		}
	}

	function agregarFactura($reg,$imgOriginal,$imgFinal,$urlDef){
		//var_dump($urlDef);
		$ruPartida=explode('/', $urlDef);
		//var_dump($ruPartida);
		$inicio=(count($ruPartida)-1);
		$fin=(count($ruPartida)-4);
		
		$ultimo=$ruPartida[$inicio];
		$tercer=$ruPartida[($inicio-1)];
		$segundo=$ruPartida[($inicio-2)];
		$primer=$ruPartida[$fin];
		$urlF=$_SERVER['SERVER_NAME'].'/'.$primer.'/'.$segundo.'/'.$tercer.'/'.$ultimo;
		
		DB_DataObject::debugLevel(0);
		$obj=DB_DataObject::Factory('Factura');
		$obj->idUsuario=$reg;
		$obj->img=$imgOriginal;
		$obj->destino=$imgFinal;
		$obj->url=$urlF;
		$obj->fecha=date('Y-m-d h:i:s');
		$ret=$obj->insert();
		$obj->free();
		return $ret;
	}

	function existe($dni){ // indaga si existe el dni si existe retorna el id si no existe retorna 0
		DB_DataObject::debugLevel(0);
		$obj=DB_DataObject::Factory('Usuario');
		$obj->dni=$dni;
		$obj->find();
		$ret=0;
		if ($obj->fetch()) {
			$ret=$obj->id;
		}
		return $ret;
		$obj->free();
	}

	function crearCarpeta($dni){
		$destino=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['REQUEST_URI']).'/facturas/'.$dni;
		$directorio=array();
		//var_dump($destino);
		//echo getcwd();
		$dir = mkdir($destino,'0777');
		$directorio[0]=$dir;
		$directorio[1]= $destino;
		return $directorio;
		
	}


}
?>