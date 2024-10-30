<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

interface ICategoryRepository {
    public function SaveCategorys(CategoryModel $categoryModel) : int;
    public function GetCategorysByCodigo(string $codigo) : CategoryModel;
    public function UpdateCategorys(CategoryModel $categoryModel) : void;
    public function DeleteCategorysByCodigo(string $codigo) : void;
    public function CountCategorys() : int;
    public function GetAllCategorys() : array;
}
