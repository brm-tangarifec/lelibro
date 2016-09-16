<?php
class General
{
	/**
	* Se crea la tupla en la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	*/


	public function setInstancia($tabla, $campoExcluir = NULL){
		//sDB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		
		unset($campos["id"]);
		unset($campos["fechaCreacion"]);
		unset($campos["fecha"]);
		unset($campos["fechaReg"]);
		if ($campoExcluir != NULL) {
			foreach ($campoExcluir as $nombre => $valor) {
				unset($campos[$valor]);
			}
		}
		//Asigna los valores
		foreach($campos as $key => $value){
			$objDBO->$key = ($this->$key);
		}
		
		$objDBO->find();
		
		if ($objDBO->fetch()) {
			$ret = $objDBO->id;
		} else {
			$objDBO->fecha=date("Y-m-d H:i:s");
			$ret = $objDBO->insert();
		}
		//printVar($insert);
		//Libera el objeto DBO
		$objDBO->free();
		
		return ($ret);
	}
	

	
	/**
	* Traemos total de registros de nuestra tabla
	*/
	public function getTotalInstancia($tabla, $where = ''){
		//DB_DataObject::debugLevel(1);
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		$contador = 0;
		$ret = false;
		
		//Si necesitamos algun condicional
		if($where != ''){
			$objDBO->whereAdd($where);
		}							
		
		$objDBO->find();		
		
		$ret = $objDBO->count();
		
		//Libera el objeto DBO
		$objDBO->free();

		return ($ret);
	}
	
	/**
	* Traemos total de registros de nuestra tabla
	*/
	public function getRowInstancia($tabla, $where = '', $field="", $orden = "", $limiteInferior = -1, $limiteSuperior = -1, $join = ""){
		//DB_DataObject::debugLevel(1);
		$objDBO = DB_DataObject::Factory($tabla);		
		$campos = $objDBO->table();
		//printVar($campos);
		
		if($field!=""){
			$campos = $field;			
		}
		
		$objDBO->selectAdd();
		//Creamos un String para Agregar todos los campos de la tabla
		$rowsSelect = '';
		foreach ($campos as $key => $value) {
			$rowsSelect .= $objDBO->__table.'.'.$key.', ';
		}
		
		//Join
		if(is_array($join)){
			foreach($join as $key => $value){
				$var[$key] = DB_DataObject::Factory($value['dbObj']);
                $campos[$value['rowAs']] = "";
				$rowsSelect .= $var[$key]->__table.'.'.$value['rows'].' AS '.$value['rowAs'].', ';
				$objDBO->joinAdd($var[$key], $value['type']);
			}
		}
		
		//Agregamos todos los campos de la tabla
		$rowsSelect = substr ($rowsSelect, 0, strlen($rowsSelect) - 2);
		$objDBO->selectAdd($rowsSelect);
				
		$contador = 0;
		$ret = false;
		
		//Si necesitamos algun condicional
		if($where != ''){
			$objDBO->whereAdd($where);
		}
		
		//Ordenamos segun Parametro
		if($orden != ""){
			$objDBO->orderBy($orden);
		}
		
		//Si existe un limit, aumenta en el condicional de la consulta
		if($limiteInferior >= 0){
			$star_item = ($limiteInferior-1)*$limiteSuperior;
			$objDBO->limit($star_item,$limiteSuperior);
			//$this->conteo = $usuarioDBO->count();
		}				
		
		$objDBO->find();
		//Asigna los valores
		while ($objDBO->fetch()) {
			foreach ($campos as $key => $value) {
				$ret[$contador]->$key = utf8_encode(stripslashes($objDBO->$key));
			}
			$contador++;
		}
		
		//printVar($ret);
		
		//Libera el objeto DBO
		$objDBO->free();

		return ($ret);
	}
	
	/**
	* Actualiza la tupla con id dado en la tabla dada
	* @param tabla: Nombre del DBO de la tabla a actualizar
	* @param id: Id del registro a actualizar
	*/
	public function updateInstancia($tabla, $fields){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		$llaves = $objDBO->keys();				
		
		foreach($llaves as $key => $value){
			$objDBO->$value = $fields[$value];	
		}
				
		$objDBO->find();
		if($objDBO->fetch()){
			//Asigna los valores
			if(is_array($fields)){
				foreach($fields as $key => $value){
					$objDBO->$key = $value;
				}
			}
			//print_r($objDBO,'class.General -> $objDBO');
			$ret = $objDBO->update();
		}else{
			if(is_array($fields)){
				foreach($fields as $key => $value){
					$objDBO->$key = $value;
				}
			}
		
			$ret = $objDBO->insert();
			$ret = false;
		}
		//Libera el objeto DBO
		$objDBO->free();
		
		return ($ret);
	}
	
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Obtenemos los campos de la tabla
	*/
	public function getFieldsTable($tabla){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();				
		
		$objDBO->find();
		
		//Libera el objeto DBO
		$objDBO->free();
		

		return ($campos);
	}
	
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	* @param campo: arreglo con la dupla campo y valor
	*/
	public function getInstancia($tabla, $fieldData="", $unsetField=NULL, $campoWhere, $join=""){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);		
		$campos = $objDBO->table();
		
		$objDBO->selectAdd();
		//Creamos un String para Agregar todos los campos de la tabla
		$rowsSelect = '';
		if(is_array($unsetField)){			
			foreach ($unsetField as $key => $value) {
				unset($campos[$key]);
			}
		}
		if(is_array($fieldData)){
			$campos = $fieldData;
		}
		foreach ($campos as $key => $value) {
			$rowsSelect .= $objDBO->__table.'.'.$key.', ';
		}
		
		//Join
		if(is_array($join)){
			foreach($join as $key => $value){
				$var[$key] = DB_DataObject::Factory($value['dbObj']);
				//Separamos cada campo
				$value['rows'] = explode(',', $value['rows']);
				$value['rowsAs'] = explode(',', $value['rowsAs']);
				for($x=0;$x<count($value['rows']);$x++){
					$campos[$value['rowsAs'][$x]] = "";
					$rowsSelect .= $var[$key]->__table.'.'.$value['rows'][$x].' AS '.$value['rowsAs'][$x].', ';
				}
				$objDBO->joinAdd($var[$key], $value['type'], $var[$key]->__table);
			}
		}
		
		//Agregamos todos los campos de la tabla
		$rowsSelect = substr ($rowsSelect, 0, strlen($rowsSelect) - 2);
		$objDBO->selectAdd($rowsSelect);
		
		
		if(is_array($campoWhere)){
			foreach($campoWhere as $key => $value){
				$objDBO->$key = $value;
			}
		}
		
		$objDBO->find();
		if($objDBO->fetch()){
			//Asigna los valores
			foreach($campos as $key => $value){	
				$encoding= mb_detect_encoding($objDBO->$key, "auto");
					if($encoding == 'UTF-8'){
						$ret->$key =  utf8_encode($objDBO->$key);
					}else{
						if($encoding == 'ASCII'){
							$ret->$key = $objDBO->$key;
						}else{
							$ret->$key = cambiaParaEnvio(htmlentities(stripslashes($objDBO->$key)));
						}
					}
			}
		}else{
			$ret = false;
		}
		
		//Libera el objeto DBO
		$objDBO->free();			

		return ($ret);
	}
	
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	* @param campo: arreglo con la dupla campo y valor
	*/
	public function getInstancia2($tabla,$campos='',$where='',$join='',$order='',$limit=""){
		DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		//printVar(count($campos));
		
		
		if($campos==""){
			$campos = $objDBO->table();
		}
					
		//printVar($campos);
		
		$objDBO->selectAdd();
		//Creamos un String para Agregar todos los campos de la tabla
		$rowsSelect = '';
		foreach ($campos as $key => $value) {			
			$rowsSelect .= $objDBO->__table.'.'.$key.', ';
		}
		
		//Join
		if(is_array($join)){
			foreach($join as $key => $value){
				$var[$key] = DB_DataObject::Factory($value['dbObj']);
                $campos[$value['rowAs']] = "";
				if($value['rows']!=""){				
				$rowsSelect .= $var[$key]->__table.'.'.$value['rows'].' AS '.$value['rowAs'].', ';
				}
				$objDBO->joinAdd($var[$key], $value['type']);
			}
		}
		
		//Agregamos todos los campos de la tabla
		$rowsSelect = substr ($rowsSelect, 0, strlen($rowsSelect) - 2);
		$objDBO->selectAdd($rowsSelect);
		

		
		//Si necesitamos algun condicional
		if($where != ''){
			$objDBO->whereAdd($where);
		}
		
		//Ordenamos segun Parametro
		if($order != ""){
			$objDBO->orderBy($order);
		}
		if($limit!=""){
		$objDBO->limit(1);
		}
		$objDBO->find();		
		if($objDBO->fetch()){
			//Asigna los valores
			
			foreach($campos as $key => $value){
				if($key!=""){
					$ret->$key = cambiaParaEnvio($objDBO->$key);
				}
			}
		}else{
			$ret = false;
		}
		
		//Libera el objeto DBO
		$objDBO->free();
		
		return ($ret);
	}
	
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	* @param campo: arreglo con la dupla campo y valor
	*/
	public function getInstanciaWhere($tabla,$campo,$where=""){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		//Si necesitamos algun condicional
		if($where != ''){
			$objDBO->whereAdd($where);
		}
		
		$contador = 0;
		$objDBO->find();
		$columna = $objDBO->table();
		$ret = false;
		while ($objDBO->fetch()) {
			foreach ($columna as $key => $value) {
				$ret[$contador]->$key = cambiaParaEnvio($objDBO->$key);
			}
			$contador++;
		}
		
		//Libera el objeto DBO
		$objDBO->free();
		
		if($campo!=""){
			return $ret->$campo;
		}

		return $ret;	
	}
	
	/**
	* Borrar la tupla con id dado en la tabla dada
	* @param tabla: Nombre del DBO de la tabla donde se va a borrar
	* @param id: Id del registro a borrar
	*/
	public function unSetInstancia($tabla,$id){
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
			
		$campos = $objDBO->table();
		
		if(strpos($id,',') === false){
			$objDBO->get($id);
		}else{
			$datos = split(',',$id);
			$objDBO->get($datos[0],$datos[1]);
		}
		
		
		$ret = $objDBO->delete();
		
		//Libera el objeto DBO
		$objDBO->free();
		

		return ($ret);
	}

	/**
	* Trae el listado de campos sin id ni fecha
	* @param tabla: Nombre del DBO de la tabla 
	*/
	public function getCampos($tabla){
		//DB_DataObject::debugLevel(5);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		
		unset($campos["id"]);
		unset($campos["fecha"]);
		
		//Libera el objeto DBO
		$objDBO->free();
		
		return ($campos);
	}
	
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	* @param id: Id del registro a traer
	*/
	public function getInstanciaCampo($tabla,$campo,$dato=''){
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		
		$objDBO->$campo = $dato;
		
		$objDBO->find();
		if($objDBO->fetch()){
			//Asigna los valores
			foreach($campos as $key => $value){
				$ret->$key = cambiaParaEnvio($objDBO->$key);
			}
		}else{
			$ret = false;
		}
		
		//Libera el objeto DBO
		$objDBO->free();
		
		return ($ret);
	}
	
	/**
	* 
	* 
	* 
	*/
	public function getSelect($table, $output, $params="", $notInField='', $notIn="", $like="") {
		//DB_DataObject::debugLevel(1);
		$objDBO = DB_DataObject::Factory($table);
		if ( $params != '' ) {
			foreach( $params as $field => $value ){
				$objDBO->$field = $value;
			}
		}
		
		if( $notInField != '' && $notIn != '' ){		
			$objDBO->whereAdd("$notInField NOT IN($notIn)");
		}
		
		if ( $like != '' ){
			$index = array_keys($like);
			$valorLike = $like[$index[0]];
			$objDBO->whereAdd("$index[0] like '%$valorLike%'");
		}
		$rows = array();
		$ret = false;

		//Trae los campos de secci�n con id recibido
		$objDBO->find();
		$contador = 0;
		while ( $objDBO->fetch() ) {
			//Asigna los valores
			for ( $i=0;$i<count($output);$i++ ) {
				//$objDBO->id
				$rows[$contador]->$output[$i] = utf8_encode($objDBO->$output[$i]);
			}
			$ret = true;
			$contador++;
		}

		//Free DBO object
		$objDBO->free();
		if($ret){
			$ret = $rows;
		}
		return($ret);
	}
	
	public function ciudades()
		{
		$punto=DB_DataObject::Factory("PuntoAtencion");
		$ciudad=DB_DataObject::Factory("mgrciudad");
		$punto->groupBy("punto_atencion.Ciudad");
		//DB_DataObject::debugLevel(2);
		$punto->joinAdd($ciudad);
		$punto->find();
		$res=array();
		$c=0;
		while($punto->fetch())
			{$res[$c]->id=$punto->idCiudad;
			$res[$c]->nombre=utf8_encode($punto->ciudad);
			$c++;
			}
		$punto->free();
		$ciudad->free();
		return $res;
		}

	public function puntosAtencion()
		{//DB_DataObject::debugLevel(1);
		$punto=DB_DataObject::Factory("PuntoAtencion");
		$ciudad=DB_DataObject::Factory("mgrciudad");
		$punto->orderBy("punto_atencion.idCiudad");
		$punto->joinAdd($ciudad);
		$punto->find();
		$res=array();
		$c=0;
		while($punto->fetch())
			{$res[$c]->id=$punto->idCiudad;
			$res[$c]->nombre=utf8_encode($punto->ciudad);
			$res[$c]->oficina=utf8_encode($punto->oficina);
			$res[$c]->direccion=utf8_encode($punto->direccion);
			$res[$c]->horarioLV=utf8_encode($punto->horarioLV);
			$res[$c]->tran=utf8_encode($punto->transacciones);
			$res[$c]->tipo=utf8_encode($punto->tipoOficina);
			$res[$c]->corr=utf8_encode($punto->correspondencia);
			$c++;
			}
		$punto->free();
		$ciudad->free();
		return $res;
		}

	public function getTotalDatos($table = '',$fields = '',$conditions = '',$orden = '',$limiteInferior = -1,$limiteSuperior = -1,$disctinc=false){
		//DB_DataObject::debugLevel(1);
		
		//printVar($table);
		$objDBO = DB_DataObject::Factory($table);
		
		$rows = array();
		$ret=false;
		if(is_array($conditions)){ // como arreglo asociativo
			foreach($conditions as $key => $value){
				$objDBO->$key = $value;
			}
		}else{ // como cadena
			if($conditions != ''){
				$objDBO->whereAdd($conditions);
			}
		}
		
		if(is_array($fields)){
			$objDBO->selectAdd();
			foreach($fields as $key => $value){
				if($disctinc){
					$cadenaDisc=$value.",";
				}else{
					$objDBO->selectAdd($value);
				}
			}
			if($disctinc){
				$objDBO->selectAdd("DISTINCT(".substr($cadenaDisc,0,-1).")");
			}
		}else{
			$fields = $objDBO->table();
			foreach($fields as $key => $value){
				$fields[$key] = $key;
			}
			/*printVar($fields);
			$fields = array_flip($fields);
			printVar($fields);*/
		}
		
		//Si existe un limit, aumenta en el condicional de la consulta
		if( $limiteInferior >= 0 )
		{
			$star_item = ($limiteInferior-1)*$limiteSuperior;
			$objDBO->limit($star_item, $limiteSuperior);
		}
		
		
		if($orden != ""){
			$objDBO->orderBy($orden);
		}
		
		$objDBO->find();
		$cont = 0;
		
		while($objDBO->fetch()){
			//Asigna los valores
			if(isset($objDBO->id)){
				$rows[$cont]->id = $objDBO->id;	
			}
			if(is_array($fields)){
				foreach($fields as $key => $value){
					$posCad = strpos($value, "AS");
					if($posCad !== FALSE){
						$value = substr($value,$posCad + 3);
					}
					//$rows[$cont]->$value = cambiaParaEnvio($objDBO->$value);
					$encoding= mb_detect_encoding($objDBO->$value, "auto");
					//printVar($encoding);
					if($encoding == 'UTF-8'){
						$rows[$cont]->$value =  utf8_encode($objDBO->$value);
					}else{
						if($encoding == 'ASCII'){
							$rows[$cont]->$value = utf8_decode($objDBO->$value);
						}else{
							$rows[$cont]->$value = $objDBO->$value;
						}
					}
					
				}
			}
			$cont++;
			$ret = true;
		}
		
		//DB_DataObject::debugLevel(0);
		
		//Free DBO object
		$objDBO->free();
		if($ret){
			$ret = $rows;
		}
		return($ret);
	}
        
        /**
	* Actualiza la tupla con id dado en la tabla dada
	* @param tabla: Nombre del DBO de la tabla a actualizar
	* @param id: Id del registro a actualizar
	*/
	public function updateData($tabla, $id, $fields = '')
	{
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);

		

		//$objDBO->id = $id;

		foreach($id as $key => $value) {
				$objDBO->$key=$value;
		}
                
		//Asigna los valores
		$objDBO->find();	
		
		if($objDBO->fetch()){
			if( is_array($fields) )
			{ 
				foreach($fields as $key => $value) {
					$objDBO->$key=$value;
				}
			}
			$objDBO->fechaActualizacion = date("Y-m-d H:i:s");
			$objDBO->update();
			$ret = true;
		}else{
			$ret = false;
		}

		//Libera el objeto DBO
		$objDBO->free();

		return ($ret);
	}
	
	/*TRUNCAR TABLA*/
	/*ruta de crom http://localhost/nestum/ajax.php?tipo=actualiza&case=actualiza*/
   public function borrarTabla(){//DB_DataObject::debugLevel(1);
		   $tableDB = DB_DataObject::Factory("NestumRankingcron");
		   $tableDB->query("TRUNCATE  TABLE nestum_rankingcron ");
		   return $tableDB;
   }               
   /*ACTUALIZA RANKING*/
   public function actualizaRanking(){
   //DB_DataObject::debugLevel(1);
	   $tableDB = DB_DataObject::Factory("VistaNestumRanking");
	   $tableDB->query("insert into nestum_rankingcron (idUsuario,idFacebook,nombreCompleto,nombres,apellidos,total) select  idUsuario,idFacebook,concat(nombres,' ',apellidos),nombres,apellidos,total from vista_nestum_ranking ORDER BY total DESC");
	   return $tableDB;
   }
   
   public function picture($marca){
   		
   		$obj = DB_DataObject::Factory('MpBrand');
		DB_DataObject::debugLevel(1);
		printVar($obj);
		$obj->name=$marca;
		$find=$obj->find();
		if($find <0) {
			while($obj->fetch()){
				echo $obj->picture;	
			}
		    
		}else{
		    echo 'ni mir..';
		}
		$obj->free();
   }
}
?>