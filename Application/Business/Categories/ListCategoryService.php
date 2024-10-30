<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/IListCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/ICategoryRepository.php";

class ListCategoryService implements IListCategoryService
{
    private $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function ListCategorys() : array
    {
        return $this->categoryRepository->GetAllCategorys();
    }
}
