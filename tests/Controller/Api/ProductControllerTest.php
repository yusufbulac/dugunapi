<?php

namespace App\Tests\Api;

use App\Controller\Api\ProductController;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    public function index()
    {
        $index = new ProductController();
        $result= $index->index()
    }
}