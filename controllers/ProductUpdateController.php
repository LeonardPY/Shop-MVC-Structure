<?php

class ProductUpdateController extends Controller
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
        $id = (int)$params[0] ?? null;

        if (!$id ) {
            header("Location: product");
        }
        $this->head = [
            'title' => 'product',
            'description' => '',
        ];

        $product = $this->productManager->find($id);
        if(!$product) {
            header("Location: product");
        }
        $this->head = [
            'title' => 'products',
            'description' => '',
        ];
        $this->data['product'] = $product;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->productService->makeProductData($product->image);
            $this->productManager->update($id, $data);
            header('Location: product');
        }

        $this->view = 'product/update';
    }
}