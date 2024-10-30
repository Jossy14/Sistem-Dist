<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/ICategoryRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Business/Categories/ListCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Business/Categories/SaveCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Business/Categories/SearchCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Business/Categories/UpdateCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Business/Categories/DeleteCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Infrastructure/Repository/CategoryRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Exceptions/EntityExistsException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Exceptions/EntityNotFoundException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

class CategoryController 
{
    private $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function ExecuteAction() : void
    {
        $action = isset($_REQUEST["action"]) ? mb_strtoupper(trim($_REQUEST["action"])) : '';

        switch ($action)
        {
            case "GUARDAR":
                $this->SaveCategory();
                break;

            case "LISTAR":
                $this->ListAllCategorys();
                break;

            case "BUSCAR":
                $this->SearchCategory();
                break;

            case "EDIT":
                $this->SearchEditCategory();
                break;

            case "ACTUALIZAR":
                $this->UpdateCategory();
                break;

            case "DELETE":
                $this->DeleteCategory();
                break;
            
            default:
                echo "Acción no reconocida";
                break;
        }
    }

    public function SaveCategory(): void {
        try {
                $codigo = $_POST["codigo"] ?? '';
                $nombre_categoria = $_POST["nombre_categoria"] ?? '';
                $descripcion = $_POST["descripcion"] ?? '';
                $fecha_creacion = $_POST["fecha_creacion"] ?? '';
                $estado = $_POST["estado"] ?? '';
                $id_padre = $_SESSION['user_id'] ?? null; // Cambiar a null si no está definido
                $imagen = $FILES["imagen"] ?? '';
                $orden = $_POST["orden"] ?? '';

                // Validar imagen
                if ($imagen && $imagen['tmp_name']) {
                    $imagePath = '../../uploads/' . basename($imagen['name']);
                    move_uploaded_file($imagen['tmp_name'], $imagePath);
                } else {
                    $imagePath = ''; // O manejar un valor por defecto
                }

                if (empty($codigo) || empty($nombre_categoria)) {
                    throw new Exception("El código y el nombre de la categoría son obligatorios.");
                }
                
                $categoryModel = new CategoryModel($codigo, $nombre_categoria, $descripcion, $fecha_creacion, $estado, $id_padre, $imagen, $orden);

                $saveCategoryService = new SaveCategoryService($this->categoryRepository);
                $total = $saveCategoryService->SaveCategory($categoryModel);

                $message = "Categoría Guardada, Total: $total";
                header("Location: ../Views/Forms/Categories/Create.php?message=$message");
               
        } catch (Exception $e) {
            $message = $e->getMessage();
            header("Location: ../Views/Forms/Categories/Create.php?message=$message");
        }
    }
    

        public function ListAllCategorys() : void {
            try {
                $listCategoryService = new ListCategoryService($this->categoryRepository);
                $categories = $listCategoryService->ListCategorys();
                $total = count($categories);
        
                if ($total > 0) {
                    $serializeCategories = serialize($categories);
                    $_SESSION["categories.all"] = $serializeCategories;
                    $message = "Total Categorías: $total";
                } else {
                    $_SESSION["categories.all"] = null;
                    $message = "Total Categorías: 0";
                }
                header("Location: ../Views/Forms/Categories/List.php?message=$message");
            } catch (Exception $e) {
                $_SESSION["categories.all"] = null;
                $message = $e->getMessage();
                header("Location: ../Views/Forms/Categories/List.php?message=$message");
            }
        }

        public function SearchCategory() {
            try {
                if (!isset($_POST["codigo"]) || empty(trim($_POST["codigo"]))) {
                    throw new Exception("Código de categoría no proporcionado.");
                }
        
                $codigo = trim($_POST["codigo"]);
                error_log("Buscando categoría con código: $codigo"); // Agrega este log
        
                $searchCategoryService = new SearchCategoryService($this->categoryRepository);
                $categoryModel = $searchCategoryService->SearchCategory($codigo);
        
                $_SESSION["category.find"] = serialize($categoryModel);
                $message = "Categoría Encontrada";
                header("Location: ../Views/Forms/Categories/Search.php?message=" . urlencode($message));
                exit();
            } catch (Exception $e) {
                $_SESSION["category.find"] = null;
                error_log("Error buscando categoría: " . $e->getMessage()); // Agrega este log
                $message = $e->getMessage();
                header("Location: ../Views/Forms/Categories/Search.php?message=" . urlencode($message));
                exit();
            }
        }
        
        
        

        public function SearchEditCategory()
        {
            try {
                if (!isset($_GET["codigo"]) || empty(trim($_GET["codigo"]))) {
                    throw new Exception("Código de categoría no proporcionado.");
                }

                $codigo = trim($_GET["codigo"]);
                $searchCategoryService = new SearchCategoryService($this->categoryRepository);
                $categoryModel = $searchCategoryService->SearchCategory($codigo);

                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Asegura que la sesión esté activa
                }

                $_SESSION["category.find"] = serialize($categoryModel);
                $message = "Categoría Encontrada";
                
                // Redirige a la página de edición con el mensaje como parámetro GET
                header("Location: ../Views/Forms/Categories/Edit.php?message=" . urlencode($message));
                exit();
            } catch (Exception $e) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Asegura que la sesión esté activa
                }

                $_SESSION["category.find"] = null;
                $message = $e->getMessage();
                
                // Redirige al controlador con el mensaje de error como parámetro
                header("Location: CategoryController.php?action=LISTAR&message=" . urlencode($message));
                exit();
            }
        }


        public function UpdateCategory() {
            try {
                $codigo = $_POST["codigo"];
                $nombre_categoria = $_POST["nombre_categoria"];
                $descripcion = $_POST["descripcion"];
                $fecha_creacion = $_POST["fecha_creacion"];
                $estado = $_POST["estado"];
                $id_padre = $_POST["id_padre"];
                $imagen = $_POST["imagen"];
                $orden = $_POST["orden"];

                
                $categoryModel = new CategoryModel($codigo, $nombre_categoria, $descripcion, $fecha_creacion, $estado, $_SESSION["user_id"], $imagen, $orden);

                $updateCategoryService = new UpdateCategoryService($this->categoryRepository);
                $updateCategoryService->UpdateCategory($categoryModel);

                $_SESSION["category.find"] = serialize($categoryModel);
                $message = "Categoría actualizada";
                header("Location: ../Views/Forms/Categories/Edit.php?message=$message");

            } catch (Exception $e) {
                $message = $e->getMessage();
                header("Location: ../Views/Forms/Categories/Edit.php?message=$message");
            }
        }

        public function DeleteCategory() {
            try {

                $codigo = $_GET["codigo"];
                
                
                $deleteCategoryService = new DeleteCategoryService($this->categoryRepository);
                $deleteCategoryService->DeleteCategory($codigo);
                
                
                header("Location: CategoryController.php?action=Listar&message=");
                
            } catch (Exception $e) {
                              
                header("Location: CategoryController.php?action=Listar&message=");
              
            }
        }
    
    
    
}

$categoryRepository = new CategoryRepository();
$controller = new CategoryController($categoryRepository);
$controller->ExecuteAction();
