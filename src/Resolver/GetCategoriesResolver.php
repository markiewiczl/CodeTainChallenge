<?php

namespace App\Resolver;

use App\Repository\CategoriesRepository;

class GetCategoriesResolver implements GetCategoriesResolverInterface
{
    private CategoriesRepository $categories;

    public function __construct(CategoriesRepository $categories)
    {
        $this->categories = $categories;
    }

    public function getAllCategories():array
    {
        return $this->categories->findAll();
    }
}