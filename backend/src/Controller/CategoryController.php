<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/category')]
class CategoryController extends APIController
{
    #[Route(path: "/", name: "app_category_get_all", methods: 'GET')]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $items = $entityManager->getRepository(Category::class)->getTree();
        return $this->response(items: $items);
    }
}