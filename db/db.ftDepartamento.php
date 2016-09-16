<?php
/**
 * Table Definition for ft_departamento
 */

class DataObject_FtDepartamento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ft_departamento';                 // table name
    public $idDepto;                         // int(11)  not_null primary_key auto_increment
    public $idPais;                          // int(11)  not_null multiple_key
    public $nombre;                          // string(45)  not_null
    public $region;                          // string(45)  
    public $coordenada;                      // string(45)  
    public $fecha;                           // datetime(19)  not_null binary

    /* Static get */
    function &staticGet($class,$k,$v=NULL) { return DB_DataObject::staticGet('DataObject_FtDepartamento',$k,$v); }

    function table()
    {
         return array(
             'idDepto' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idPais' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombre' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'region' =>  DB_DATAOBJECT_STR,
             'coordenada' =>  DB_DATAOBJECT_STR,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME + DB_DATAOBJECT_NOTNULL,
         );
    }

    function keys()
    {
         return array('idDepto');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'nombre' => '',
             'region' => '',
             'coordenada' => '',
         );
    }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
