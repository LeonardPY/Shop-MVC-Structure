<?php

class CartController extends Controller
{
    private OrderManager $orderManager;
    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
        $this->orderManager = new OrderManager();
    }

    /**
     * @throws Exception
     */
    function process(array $params): void
    {
        $cart = $this->orderManager->userCardWithProducts($_SESSION['user']['id'], OrderStatusEnum::IN_CARD->value)[0] ?? null;

        if (!$cart)
            $this->redirect('error');

        if(isset($_POST['product_id'])) {
            $this->addToCart(['product_id' => $_POST['product_id']]);
        }
        $this->head = [
            'title' => 'card',
            'description' => '',
        ];
        $this->data['title'] = 'card';
        $this->data['cart'] = $cart;

        $this->view = 'order/cart';
    }

    /** @throws Exception */
    public function addToCart(array $data): string
    {
        if (!isset($data['product_id'])) {
            throw new ErrorException('');
        }

        $userId = $_SESSION['user']['id'];
        $order = $this->orderManager->userCard($userId, OrderStatusEnum::IN_CARD->value);
        $product = ProductManager::model()->find($data['product_id']);

        if (!$product) {
            throw new ErrorException('');
        }

        $orderId = $order ? $order->id : OrderManager::model()->create([
            'user_id' => $userId,
            'status' => OrderStatusEnum::IN_CARD->value,
        ]);

        $count = $data['count'] ?? 1;
        $db = OrderProductManager::query();
        $db->beginTransaction();
        try {
            $orderProduct = OrderProductManager::model()->getProductInCardByOrderIdCardId($orderId, $product->id);
            if ($orderProduct) {
                $updatedData = [
                    'product_count' => $orderProduct->product_count + $count,
                    'product_price' => $orderProduct->product_price + ($product->price * $count)
                ];
                OrderProductManager::model()->update($orderProduct->id, $updatedData);
            } else {
                $newData = [
                    'order_id' => $orderId,
                    'product_id' => $product->id,
                    'product_price' => $product->price * $count,
                    'product_count' => $count,
                ];
                OrderProductManager::model()->create($newData);
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        return 'success';
    }
}