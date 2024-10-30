<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Domain/Models/CategoryModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/IUpdateUserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CRUD/Application/Contracts/Categories/ICategoryRepository.php";

class UpdateCategoryService implements IUpdateCategoryService
{
    private $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function UpdateCategory(CategoryModel $category): void
    {
        $this->categoryRepository->UpdateCategorys($category);
    }
}
