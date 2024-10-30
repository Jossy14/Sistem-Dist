<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Users/IUserRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Common/Mapper/EntityModelMapper.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Exceptions/EntityExistsException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Exceptions/EntityNotFoundException.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Infrastructure/Database/Entities/UserEntity.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/UserModel.php";

class UserRepository implements IUserRepository
{
    /**
     * Devuelve El Total De Usuarios En La BD
     * @return int
     */
    public function CountUsers() : int
    {
        return UserEntity::count();
    }

    /**
     * Guarda Un Usuario En La BD
     * @return int
     */
    public function SaveUser(UserModel $userModel) : int
    {
        try {
            // Primero verifica si el usuario ya existe
            $user = $this->GetUserByEmail($userModel->getEmail());
            if ($user) {
                throw new EntityExistsException("Ya existe un usuario con el correo '" . $userModel->getEmail() . "'");
            }
        } catch (EntityNotFoundException $ex) {
            // Si no existe, lo crea
            $userEntity = EntityModelMapper::UserModelToEntity($userModel);
            $userEntity->save();
            return $this->CountUsers();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Busca Un Usuario En La BD
     * @return UserModel
     */
    public function GetUserByEmail(string $email) : UserModel
    {
        try {
            $userEntity = UserEntity::find($email);
            return EntityModelMapper::UserEntityToModel($userEntity);
        } catch (Exception $ex) {
            throw new EntityNotFoundException("No existe un usuario con el correo '$email'");
        }
    }

   
    /**
     * Devuelve Todos Los Usuarios De La BD
     * @return array
     */
    public function GetAllUsers() : array
    {
        try {
            $userModelList = array();
            $userEntityList = UserEntity::all();
            foreach ($userEntityList as $userEntity) {
                $userModelList[] = EntityModelMapper::UserEntityToModel($userEntity);
            }
            return $userModelList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function FindUserByEmail($email) {
        try {
            $userEntity = UserEntity::find_by_email($email);
    
            if ($userEntity) {
                return new UserModel($userEntity->email, $userEntity->password, $userEntity->id);
            } else {
                throw new EntityNotFoundException("No existe un usuario con el correo '$email'.");
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    
}
