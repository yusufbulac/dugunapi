<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\SMSService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="api_products_index", methods={"GET"})
     */
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $name = $request->query->get("name");
        $status = $request->query->get("status");
        $startPrice = $request->query->get("startPrice");
        $endPrice = $request->query->get("endPrice");
        $startDate = $request->query->get("startDate");
        $endDate = $request->query->get("endDate");

        $products = $productRepository->findProducts([
            'name' => $name,
            'status' => $status,
            'startPrice' => $startPrice,
            'endPrice' => $endPrice,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return new JsonResponse($products, Response::HTTP_OK);
    }

    /**
     * @Route("/products", name="api_products_create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request, SMSService $SMSService): Response
    {
        $name = $request->request->get('name');
        $price = $request->request->get('price');
        $status = $request->request->get('status');

        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product
            ->setName($name)
            ->setPrice($price)
            ->setStatus($status);
        $entityManager->persist($product);
        $entityManager->flush();

        $SMSService->sendSMS(
            SMSService::SMS_TO, sprintf('The product named %s has been successfully created.',
                $product->getName())
        );

        return new JsonResponse(
            [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'status' => $product->getStatus(),
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * @Route("/products/{id}", name="api_products_update", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        $name = $request->request->get('name');
        $price = $request->request->get('price');
        $status = $request->request->get('status');

        $entityManager = $this->getDoctrine()->getManager();
        $productRepository = $entityManager->getRepository(Product::class);

        $product = $productRepository->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Product ID Not Found");
        }

        $product
            ->setName($name)
            ->setPrice($price)
            ->setStatus($status);
        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(
            [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'status' => $product->getStatus(),
            ],
            Response::HTTP_OK
        );

    }


    /**
     * @Route("/products/{id}", name="api_products_delete", methods={"DELETE"})
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productRepository = $entityManager->getRepository(Product::class);

        $product = $productRepository->find($id);

        if ($product == null) {
            throw new NotFoundHttpException("Invalid ID.");
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new JsonResponse("Product deleted", Response::HTTP_NO_CONTENT);

    }


}
