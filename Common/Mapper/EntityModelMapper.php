<?php 

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Infrastructure/Database/Entities/UserEntity.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Infrastructure/Database/Entities/CategoryEntity.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/UserModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

class EntityModelMapper 
{
    public static function UserEntityToModel(UserEntity $entity) : UserModel
    {
        return new UserModel($entity->email, $entity->password);
    }

    public static function UserModelToEntity(UserModel $model) : UserEntity
    {
        $entity = new UserEntity();
        $entity->email = $model->getEmail();
        $entity->password = $model->getPassword();

        return $entity;
    }

    public static function CategoryEntityToModel(CategoryEntity $entity) : CategoryModel
    {
        // Asegúrate de que $entity->nombre_categoria existe en tu base de datos
        return new CategoryModel(
            $entity->codigo, 
            $entity->nombre_categoria, // Mapear según nombre en la base de datos
            $entity->descripcion, 
            $entity->fecha_creacion->format('Y-m-d'),
            $entity->estado, 
            $entity->id_padre,
            $entity->imagen, // Asegúrate de que "imagen" exista
            $entity->orden
        );
    }

    public static function CategoryModelToEntity(CategoryModel $model) : CategoryEntity
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Asegura que la sesión esté activa
        }
        
        $entity = new CategoryEntity();
        $entity->codigo = $model->getCodigo();
        $entity->nombre_categoria = $model->getNombre_categoria(); // Usa el alias correspondiente
        $entity->descripcion = $model->getDescripcion();
        $entity->fecha_creacion = $model->getFecha_creacion();
        $entity->estado = $model->getEstado();
        $entity->id_padre = $_SESSION['user_id'] ?? null;
        $entity->imagen = $model->getImagen();
        $entity->orden = $model->getOrden();

        

        return $entity;
    }
}
