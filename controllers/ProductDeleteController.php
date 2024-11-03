<?php

class ProductDeleteController extends Controller
{
    private ProductManager $productManager;
    public function __construct()
    {
        if (!isset($_SESSION['admin'])) {
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

        $this->productManager->delete($id);

        $this->view = 'home';
    }
}