<?php

class OrderController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
    }
    function process(array $params): void
    {
        $orders = new OrderManager();
        $orders = $orders->userOrdersWithProducts($_SESSION['user']['id'], OrderStatusEnum::ORDER->value);

        if (!$orders)
            $this->redirect('error');


        $this->head = [
            'title' => 'products',
            'description' => '',
        ];
        $this->data['title'] = 'orders';
        $this->data['orders'] = $orders;

        $this->view =  'order/orders';
    }
}