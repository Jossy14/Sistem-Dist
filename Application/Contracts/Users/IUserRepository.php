<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/UserModel.php";

interface IUserRepository
{
    
    public function SaveUser(UserModel $user) : int;

}
