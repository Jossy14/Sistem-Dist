<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/IDeleteCategoryService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/ICategoryRepository.php";

class DeleteCategoryService implements IDeleteCategoryService
{
    private $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function DeleteCategory(string $codigo): void
    {
        $this->categoryRepository->DeleteCategorysByCodigo($codigo);
    }
}
