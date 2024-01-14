<?php


namespace App ;


class ActiveRecord  {
     //Base de datos 
     protected static $db;
     protected static $columnasDB = [];
     protected static $tabla  = '';



     //Manejo de errores 
     protected static $errores = [];

 

 
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
 
 
        // crea un nuevo registro
        public function crear() {
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();
    
            // Insertar en la base de datos
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' "; 
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";
    
            echo $query;
            // Resultado de la consulta
            $resultado = self::$db->query($query);
    
            // Mensaje de exito
            if($resultado) {
                // Redireccionar al usuario.
                header('Location: /admin?resultado=1');
            }
        }
 

     public function actualizar() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');
        }
    }
     //Eliminar el registro 
    public function eliminar() {
        // Eliminar el registro
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        //   debuguear($resultado) ; 
        if($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

 
     //Identificar y unir los atributos de la base de datos
     public function atributos()
     {
         $atributos = [];
         foreach (static::$columnasDB as $columna) {
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
 
      // Validación
      public static function getErrores() {
        return static::$errores;
    }
    public function validar() {
        static::$errores = [];
        return static::$errores;
    }
     //lista todos los registros  
 
     public static function all()
     {
         $query = "SELECT * FROM " . static::$tabla;
 
 
         $resultado = self::consultarSQL($query);
 
         return $resultado;
     }
    //Obtiene una cantidad determinada de registros 
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . "LIMIT" . $cantidad;

         // debuguear($query) ; 
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
             $array[] = static::crearObjeto($registro);
         };
 
 
         //liberar la memoria  
         $resultado->free();
 
 
         //retornar los resultados 
         return $array;
     }
 
     protected static function crearObjeto($registro)
     {
         $objeto = new static();
 
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