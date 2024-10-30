<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Users/IUserRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Infrastructure/Repository/UserRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/UserModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Business/Users/SaveUserService.php";

class UserController {
    private $userRepository;

    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function ExecuteAction() : void {
        // Verifica si "action" está definido en $_REQUEST, y usa un valor por defecto si no
        $action = isset($_REQUEST["action"]) ? mb_strtoupper(trim($_REQUEST["action"])) : '';
        
        switch ($action) {
            case "GUARDAR":
                $this->SaveUser();
                break;
            case "LOGIN":
                $this->LoginUser();
                break;
            // Puedes añadir más casos si es necesario
        }
    }
    
    public function LoginUser(): void {
        try {
            $email = $_POST["email"];
            $password = $_POST["password"];
    
            // Validar las credenciales
            $user = $this->userRepository->FindUserByEmail($email);
            if ($user && $user->getPassword() === $password) { // Comparar la contraseña aquí
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user->getId();
                header("Location: ../Views/Forms/Users/index.php");
                exit();
            } else {
                echo "Usuario o contraseña incorrectos.";
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo "Error: $message"; // Puedes manejar el error según sea necesario
        }
    }
    
    
    

    public function SaveUser(): void {
        try {
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            // Verificar si el correo ya existe
            $user = $this->userRepository->FindUserByEmail($email);
            
            if ($user) {
                // Si el correo ya existe, redirigir con un mensaje de error
                $message = "El correo ya está en uso.";
                header("Location: ../Views/Forms/Users/login.php?message=$message");
                exit();
            } else {
                // Si el correo no existe, guardar el usuario
                $userModel = new UserModel($email, $password);
                $saveUserService = new SaveUserService($this->userRepository);
                $total = $saveUserService->SaveUser($userModel);
                $message = "Usuario Guardado, Total: $total";
                header("Location: ../Views/Forms/Users/index.php?message=$message");
                exit();
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            header("Location: ../Views/Forms/Users/register.php?message=$message");
        }
    }
    
}

$userRepository = new UserRepository();
$controller = new UserController($userRepository);
$controller->ExecuteAction();
