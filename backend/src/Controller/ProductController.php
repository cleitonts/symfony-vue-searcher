<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/product')]
class ProductController extends APIController
{
    #[Route(path: "/", name: "app_product_get_all", methods: 'GET')]
    public function getAll(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $items = $entityManager->getRepository(Product::class)->search($request->query->all());
        return $this->response(items: $items, groups: ["product", "countable"]);
    }

    #[Route(path: "/brands", name: "app_product_brand_get_all", methods: 'GET')]
    public function getBrands(EntityManagerInterface $entityManager): JsonResponse
    {
        $items = $entityManager->getRepository(Product::class)->getBrands();
        return $this->response(items: $items);
    }
}