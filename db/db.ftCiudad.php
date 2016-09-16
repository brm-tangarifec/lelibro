<?php
/**
 * Table Definition for ft_ciudad
 */

class DataObject_FtCiudad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ft_ciudad';                       // table name
    public $idCiudad;                        // int(11)  not_null primary_key auto_increment
    public $idDepto;                         // int(11)  not_null multiple_key
    public $nombre;                          // string(45)  not_null
    public $codDane;                         // string(45)  
    public $nombreDane;                      // string(45)  
    public $coordenada;                      // string(45)  not_null
    public $fecha;                           // datetime(19)  not_null binary

    /* Static get */
    function &staticGet($class,$k,$v=NULL) { return DB_DataObject::staticGet('DataObject_FtCiudad',$k,$v); }

    function table()
    {
         return array(
             'idCiudad' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idDepto' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombre' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'codDane' =>  DB_DATAOBJECT_STR,
             'nombreDane' =>  DB_DATAOBJECT_STR,
             'coordenada' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME + DB_DATAOBJECT_NOTNULL,
         );
    }

    function keys()
    {
         return array('idCiudad');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'nombre' => '',
             'codDane' => '',
             'nombreDane' => '',
             'coordenada' => '',
         );
    }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
