<?php

class ProductCreateController extends Controller
{
    private ProductService $productService;
    private ProductManager $productManager;
    public function __construct()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: home");
            exit;
        }
        $this->productService = new ProductService();
        $this->productManager = new ProductManager();
    }
    function process(array $params): void
    {
        $this->head = [
            'title' => 'products',
            'description' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->productService->makeProductData();
            $this->productManager->create($data);
            header('Location: product');
        }

        $this->view = 'product/create';
    }
}