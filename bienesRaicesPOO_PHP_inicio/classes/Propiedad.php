<?php



namespace App;



class Propiedad
{

    //Base de datos 
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    //Manejo de errores 
    protected static $errores = [] ; 



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
        $this->precio =$args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('y/m/d');
        $this->vendedores_id =$args['vendedores_id'] ?? 1;
        $this->descripcion = $args['descripcion'] ?? '';
        //debuguear($args) ; 
    }
    
    //Definir la conexion a la DB 
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        //Sanitizar los datos 
        $atributos = $this->sanitizarAtributos();
          
 


        //Insertar en la base de datos 
        $query = "INSERT INTO propiedades ("; 
        $query .= join(', ', array_keys($atributos)); 
        $query .= ") VALUES ('"; 
        $query .= join("', '", array_values($atributos)); 
        $query .= "')";
           
       // debuguear($query);
        $resultado =  self::$db->query($query);

        return $resultado ; 
    }


    //Identificar y unir los atributos de la base de datos
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Subida de archivos 
    public function setImagen($imagen) {
     //Asignar al atributo de la imagen el nombre de la imagen 
        if($imagen) {
            $this->imagen = $imagen ; 
        }
    }

    //Validacion 
    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->precio) {
            self::$errores[] = 'El Precio es Obligatorio';
        }

        if( strlen( $this->descripcion ) < 50 ) {
            self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$this->habitaciones) {
            self::$errores[] = 'El Número de habitaciones es obligatorio';
        }
        
        if(!$this->wc) {
            self::$errores[] = 'El Número de Baños es obligatorio';
        }

        if(!$this->estacionamiento) {
            self::$errores[] = 'El Número de lugares de Estacionamiento es obligatorio';
        }

        if(!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria' ; 
        }
      

        return self::$errores;
    }

     //lista todas las propiedades 

     public static function all() {
     $query = "SELECT * FROM propiedades" ; 
     

     $resultado = self::consultarSQL($query) ;
     
     return $resultado ; 
     
     }
      //Busca una propiedad por su Id 
      

  




     public static function consultarSQL($query) {
           //Consultar la Base De Datos 
            $resultado = self::$db->query($query) ; 

           //Iterar los resultados 
             $array = [] ; 
            while($registro = $resultado->fetch_assoc()) {
                $array[] = self::crearObjeto($registro) ; 
            } ; 

         
           //liberar la memoria  
            $resultado->free(); 


           //retornar los resultados 
            return $array ; 

     }

     protected static function crearObjeto($registro) {
      $objeto = new self() ; 

      foreach($registro as $key => $value) {
        if(property_exists( $objeto, $key  ))
        $objeto->$key = $value ; 
       }


       return $objeto ; 
     }

}
