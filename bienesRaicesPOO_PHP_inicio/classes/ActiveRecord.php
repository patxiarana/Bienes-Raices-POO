<?php


namespace App ;


class ActiveRecord {
     //Base de datos 
     protected static $db;
     protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];
     protected static $tabla  = '';
     //Manejo de errores 
     protected static $errores = [];
 
 
 
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
         $this->id = $args['id'] ?? NULL;
         $this->titulo = $args['titulo'] ?? '';
         $this->precio = $args['precio'] ?? '';
         $this->imagen = $args['imagen'] ?? '';
         $this->habitaciones = $args['habitaciones'] ?? '';
         $this->wc = $args['wc'] ?? '';
         $this->estacionamiento = $args['estacionamiento'] ?? '';
         $this->creado = date('y/m/d');
         $this->vendedores_id = $args['vendedores_id'] ?? 1;
         $this->descripcion = $args['descripcion'] ?? '';
         //debuguear($args) ; 
     }
 
     //Definir la conexion a la DB 
     public static function setDB($database)
     {
         self::$db = $database;
     }
 
     public function guardar() {
         if(!is_null($this->id)) {
             // actualizar
             $this->actualizar();
         } else {
             // Creando un nuevo registro
             $this->crear();
         }
     }
 
 
     public function crear()
     {
         //Sanitizar los datos 
         $atributos = $this->sanitizarAtributos();
 
 
 
 
         //Insertar en la base de datos 
         $query = "INSERT INTO " . static::$tabla   ." (";
         $query .= join(', ', array_keys($atributos));
         $query .= ") VALUES ('";
         $query .= join("', '", array_values($atributos));
         $query .= "')";
 
         $resultado =  self::$db->query($query);
 
         // Mensaje de exito
         if($resultado) {
             // Redireccionar al usuario.
             header('Location: /admin?resultado=1');
         }
     }
 
     public function actualizar()
     {
         //Sanitizar los datos 
         $atributos = $this->sanitizarAtributos();
 
         $valores = [];
         foreach ($atributos as $key => $value) {
             $valores[]  = "{$key}='{$value}'";
         }
         $query = "UPDATE " . static::$tabla ."SET ";
         $query .=  join(', ', $valores);
         $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
         $query .= " LIMIT 1 ";
 
         $resultado = self::$db->query($query);
 
         if ($resultado) {
             // Redireccionar al usuario.
             header('Location: /admin?resultado=2');
         }
     }
     //Eliminar el registro 
       public function eliminar() {
         $query = "DELETE FROM ". static::$tabla ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
         $resultado = self::$db->query($query); 
         if($resultado) {
             $this->borrarimagen(); 
             header('location: /admin?resultado=3');
         }
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
         // Elimina la imagen previa
         if( !is_null($this->id) ) {
             $this->borrarImagen();
         }
         // Asignar al atributo de imagen el nombre de la imagen
         if($imagen) {
             $this->imagen = $imagen;
         }
     }
 
          //Eliminar archivo 
          public function borrarimagen() {
             //Comprobar si existe el archivo
             $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
             if ($existeArchivo) {
                 unlink(CARPETA_IMAGENES . $this->imagen);
             }
          }
 
     //Validacion 
     public static function getErrores()
     {
         return self::$errores;
     }
 
     public function validar()
     {
 
         if (!$this->titulo) {
             self::$errores[] = "Debes añadir un titulo";
         }
 
         if (!$this->precio) {
             self::$errores[] = 'El Precio es Obligatorio';
         }
 
         if (strlen($this->descripcion) < 50) {
             self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
         }
 
         if (!$this->habitaciones) {
             self::$errores[] = 'El Número de habitaciones es obligatorio';
         }
 
         if (!$this->wc) {
             self::$errores[] = 'El Número de Baños es obligatorio';
         }
 
         if (!$this->estacionamiento) {
             self::$errores[] = 'El Número de lugares de Estacionamiento es obligatorio';
         }
 
         if (!$this->imagen) {
             self::$errores[] = 'La imagen es obligatoria';
         }
 
 
         return self::$errores;
     }
 
     //lista todos los registros  
 
     public static function all()
     {
         $query = "SELECT * FROM " . static::$tabla;
 
 
         $resultado = self::consultarSQL($query);
 
         return $resultado;
     }
     //Busca una registro por su Id 
 
     public static function find($id)
     {
         $query = "SELECT * FROM " . static::$tabla .   " WHERE id = $id ";
 
         $resultado = self::consultarSQL($query);
         return  array_shift($resultado);
     }
 
 
 
 
     public static function consultarSQL($query)
     {
         //Consultar la Base De Datos 
         $resultado = self::$db->query($query);
 
         //Iterar los resultados 
         $array = [];
         while ($registro = $resultado->fetch_assoc()) {
             $array[] = self::crearObjeto($registro);
         };
 
 
         //liberar la memoria  
         $resultado->free();
 
 
         //retornar los resultados 
         return $array;
     }
 
     protected static function crearObjeto($registro)
     {
         $objeto = new self();
 
         foreach ($registro as $key => $value) {
             if (property_exists($objeto, $key))
                 $objeto->$key = $value;
         }
 
 
         return $objeto;
     }
 
     //Sincroniza el objeto en memoria con los cambios realizados por el uusuario 
     public function sincronizar($args = [])
     {
         foreach ($args as $key => $value) {
             if (property_exists($this, $key) && !is_null($value)) {
                 $this->$key = $value;
             }
         }
     }
}