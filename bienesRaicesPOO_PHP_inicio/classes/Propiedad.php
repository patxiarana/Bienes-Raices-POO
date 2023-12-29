<?php



namespace App;



class Propiedad
{

  //Base de datos 
protected static $db ; 



    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jgp';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar()
    {
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, vendedorId, creado  ) VALUES ( '$this->titulo', '$this->precio', '$this->imagen',
         '$this->descripcion',  '$this->habitaciones', '$this->wc', '$this->estacionamiento', '$this->vendedores_id', '$this->creado' )";

        $resultado =  self::$db->query($query) ; 

        debuguear($resultado) ; 
    }

    //Definir la conexion a la DB 
   public static function setDB($database) {
    self::$db = $database ; 
   }

}
