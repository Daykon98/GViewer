<?php

class Application{

    //mysqli db object
    private static $instance = NULL;

    //array('host' => '', '' => '', 'user' => '', 'pass' => '');
    
    private static $datosBD = NULL;

    public function __construct(){
    }

    //Devuelve NULL si los datos no están inicializados, o False si falla al inicializar la conexión
    public static function conexionBD(){
        if(self::$instance == NULL)
            if (self::$datosBD != NULL)
                self::$instance = new \mysqli(self::$datosBD['host'], self::$datosBD['user'], self::$datosBD['pass'], self::$datosBD['bd']);

        return self::$instance;    
    }

    //$newDatosBD debe ser un array con ['host'], ['user'], ['pass'], ['bd']
    public static function initBD($newDatosBD){
        self::$datosBD = $newDatosBD;
    }

    public static function shutdown()
    {
        if (self::$instance)
        {
            $instance->close();
        }
    }

}