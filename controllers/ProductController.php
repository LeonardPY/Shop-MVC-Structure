<?php

class ProductController extends Controller
{
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