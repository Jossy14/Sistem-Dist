<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";

interface ISearchCategoryService
{
    public function SearchCategory(string $codigo) : CategoryModel;
}
