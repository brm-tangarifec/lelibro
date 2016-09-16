<?php
/**
 * Table Definition for lnc_registro
 */

class DataObject_LncRegistro extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lnc_registro';                    // table name
    public $id;                              // int(11)  not_null primary_key auto_increment
    public $nombreCompleto;                  // string(100)  
    public $email;                           // string(150)  
    public $tipoDocumento;                   // string(2)  enum
    public $documento;                       // string(45)  unique_key
    public $multimedia;                      // string(255)  
    public $fechaNacimiento;                 // date(10)  binary
    public $idDepto;                         // int(11)  
    public $idCiudad;                        // int(11)  
    public $direccion;                       // string(255)  
    public $idea;                            // blob(65535)  blob
    public $autorizoNestle;                  // string(1)  enum
    public $aceptoTerminos;                  // string(1)  enum
    public $fecha;                           // datetime(19)  binary

    /* Static get */
    function &staticGet($class,$k,$v=NULL) { return DB_DataObject::staticGet('DataObject_LncRegistro',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombreCompleto' =>  DB_DATAOBJECT_STR,
             'email' =>  DB_DATAOBJECT_STR,
             'tipoDocumento' =>  DB_DATAOBJECT_STR,
             'documento' =>  DB_DATAOBJECT_STR,
             'multimedia' =>  DB_DATAOBJECT_STR,
             'fechaNacimiento' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE,
             'idDepto' =>  DB_DATAOBJECT_INT,
             'idCiudad' =>  DB_DATAOBJECT_INT,
             'direccion' =>  DB_DATAOBJECT_STR,
             'idea' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_BLOB,
             'autorizoNestle' =>  DB_DATAOBJECT_STR,
             'aceptoTerminos' =>  DB_DATAOBJECT_STR,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
         );
    }

    function keys()
    {
         return array('id');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'nombreCompleto' => '',
             'email' => '',
             'tipoDocumento' => '',
             'documento' => '',
             'multimedia' => '',
             'direccion' => '',
             'idea' => '',
             'autorizoNestle' => 'N',
             'aceptoTerminos' => '',
         );
    }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
