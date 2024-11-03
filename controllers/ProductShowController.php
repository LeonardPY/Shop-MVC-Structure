<?php

class ProductShowController extends Controller
{
    private ProductManager $productManager;
    public function __construct()
    {
        if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
        $this->productManager = new ProductManager();
    }
    function process(array $params): void
    {
        $id = (int)$params[0] ?? null;

        if (!$id ) {
            header("Location: product");
        }
        $this->head = [
            'title' => 'product',
            'description' => '',
        ];

        $product = $this->productManager->find($id);
        if (!$product) {
            $this->view = 'products';
        }
        $this->data['product'] = $product;

        $this->view = 'product/show';
    }
}