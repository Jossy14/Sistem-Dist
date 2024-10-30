<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/CRUD/Infrastructure/Libs/Orm/Config.php';

class UserEntity extends ActiveRecord\Model {
    public static $table_name = "usuarios"; // Nombre de la tabla
    public static $primary_key = "id"; // Clave primaria
    
    // Definir los atributos necesarios para ActiveRecord
    public static $attributes = ['id', 'email', 'password'];
}
