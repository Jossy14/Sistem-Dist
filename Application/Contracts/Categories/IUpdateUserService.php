<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

interface IUpdateCategoryService
{
    public function UpdateCategory(CategoryModel $category) : void;
}
