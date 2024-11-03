<?php

class ProductController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
    }
    function process(array $params): void
    {
        $product = new ProductManager();
        $products = $product->getProducts($params);

        if (!$products)
            $this->redirect('error');


        $this->head = [
            'title' => 'products',
            'description' => '',
        ];
        $this->data['title'] = $products['products'];
        $this->data['products'] = $products;

        $this->view = 'products';
    }
}