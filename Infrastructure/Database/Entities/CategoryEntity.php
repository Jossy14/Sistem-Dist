<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/CRUD/Infrastructure/Libs/Orm/Config.php';

class CategoryEntity extends ActiveRecord\Model {
    public static $table_name = "categorias"; // Nombre de la tabla
    public static $primary_key = "codigo"; // Clave primaria
    
    // Definir los atributos necesarios para ActiveRecord
    public static $attributes = ['codigo', 'nombre_categoria', 'descripcion', 'fecha_creacion', 'estado', 'id_padre', 'imagen', 'orden'];

    public function __construct($attributes = [], $guardAttributes = true, $instantiatingViaFind = false, $newRecord = true) {
        // Verifica si la sesión está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Llamar al constructor del padre
        parent::__construct($attributes, $guardAttributes, $instantiatingViaFind, $newRecord);
        
        // Asignar id_padre del user_id en la sesión si está disponible
        $this->id_padre = $_SESSION['user_id'] ?? null;
    }
}
