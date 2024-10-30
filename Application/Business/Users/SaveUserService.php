<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/UserModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Users/ISaveUserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Users/IUserRepository.php";

class SaveUserService implements ISaveUserService
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function SaveUser(UserModel $user): int
    {
        return $this->userRepository->SaveUser($user);
    }
}
