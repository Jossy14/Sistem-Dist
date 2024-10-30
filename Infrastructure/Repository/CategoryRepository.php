<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/ICategoryRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Common/Mapper/EntityModelMapper.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Exceptions/EntityExistsException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Exceptions/EntityNotFoundException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Infrastructure/Database/Entities/CategoryEntity.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

class CategoryRepository implements ICategoryRepository {
    public function CountCategorys() : int {
        return CategoryEntity::count();
    }

    public function SaveCategorys(CategoryModel $categoryModel) : int {
        try {
            $category = $this->GetCategorysByCodigo($categoryModel->getCodigo());
            if ($category) {
                throw new EntityExistsException("Ya existe una categoría con el código '" . $categoryModel->getCodigo() . "'");
            }
        } catch (EntityNotFoundException $ex) {
            $categoryEntity = EntityModelMapper::CategoryModelToEntity($categoryModel);
            $categoryEntity->save();
            return $this->CountCategorys();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    

    public function GetCategorysByCodigo(string $codigo) : CategoryModel {
        try {
            $categoryEntity = CategoryEntity::find_by_codigo($codigo); 
            if (!$categoryEntity) {
                throw new EntityNotFoundException("No existe una categoría con el código '$codigo'");
            }
            return EntityModelMapper::CategoryEntityToModel($categoryEntity);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function UpdateCategorys(CategoryModel $categoryModel) : void {
        try {
            $categoryEntity = CategoryEntity::find_by_codigo($categoryModel->getCodigo());
            if ($categoryEntity) {
                $categoryEntity->codigo = $categoryModel->getCodigo();
                $categoryEntity->nombre_categoria = $categoryModel->getNombre_categoria();
                $categoryEntity->descripcion = $categoryModel->getDescripcion();
                $categoryEntity->fecha_creacion = $categoryModel->getFecha_creacion();
                $categoryEntity->estado = $categoryModel->getEstado();
                $categoryEntity->imagen = $categoryModel->getImagen();
                $categoryEntity->orden = $categoryModel->getOrden();
                $categoryEntity->save();
            } 
        } catch (Exception $ex) {
            throw new EntityNotFoundException("No existe una categoría con el código '" . $categoryModel->getCodigo() . "'"); 
        }
    }

    public function DeleteCategorysByCodigo(string $codigo) : void {
        try {
            $categoryEntity = CategoryEntity::find_by_codigo($codigo);
            if ($categoryEntity) {
                $categoryEntity->delete();
            } 
        } catch (Exception $ex) {
            throw new EntityNotFoundException("No existe una categoria con codigo '$codigo'");
        }
    }

    public function GetAllCategorys() : array {
        try {
            $categoryModelList = array();
            $categoryEntityList = CategoryEntity::all();
            foreach ($categoryEntityList as $categoryEntity) {
                $categoryModelList[] = EntityModelMapper::CategoryEntityToModel($categoryEntity);
            }
            return $categoryModelList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function FindCategoryByCodigo($codigo) {
        try {
            $categoryEntity = CategoryEntity::find_by_codigo($codigo); // Asegúrate de que este método está bien configurado
            if ($categoryEntity) {
                return EntityModelMapper::CategoryEntityToModel($categoryEntity);
            } else {
                throw new EntityNotFoundException("No existe una categoría con el código '$codigo'.");
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
