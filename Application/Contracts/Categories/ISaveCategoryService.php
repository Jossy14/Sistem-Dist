<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

interface ISaveCategoryService
{
    public function SaveCategory(CategoryModel $category) : int;
}
