<?php
namespace App\Controllers;

use App\Models\Product;
use App\Views\OrderTemplate;

class OrderController
{
    public function get(): string
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }
        
        $productModel = new Product();
        $data = $productModel->getBasketData();
        
        $orderView = new OrderTemplate();
        return $orderView->getOrderTemplate($data);
    }
    
    public function create(): string
    {
        $arr = [];
        $arr['fio'] = urldecode($_POST['fio']);
        $arr['address'] = urldecode($_POST['address']);
        $arr['phone'] = $_POST['phone'];
        $arr['created_at'] = date("d-m-Y H:i:s");

        $model = new Product();
        $products = $model->getBasketData();
        $arr['products'] = $products;
        
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;

        $model->saveData($arr);

        // === Очистка корзины и уведомление ===
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Спасибо! Нам приятны ваши деньги";
        
        // === КОРРЕКТНЫЙ РЕДИРЕКТ ===
        // Используем абсолютный путь и exit для остановки скрипта
        header("Location: /pizza221/");
        exit; // ⚠️ Важно! Без exit код продолжит выполняться
    }
}