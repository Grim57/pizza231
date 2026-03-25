<?php
namespace App\Models;

use App\Config\Config;

class Product {
    /* открывает файл с именем Config::FILE_PRODUCTS в режиме чтения ('r'), 
    затем считывает все содержимое из него в переменную $data, 
    закрывает файл, декодирует строку (формата json) в ассоциативный массив $arr
    функцией json_decode($data, true); и возвращает получившийся массив $arr 
    оператором return
    */
    public function loadData(): ?array
    {
        $data = file_get_contents(Config::FILE_PRODUCTS);
        if ($data) {
            $arr = json_decode($data, true);
            return $arr;
        }
        return null;
    }

    // НОВЫЙ МЕТОД: возвращает товары из корзины
    public function getBasketData(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        
        $products = $this->loadData();
        if ($products === null) {
            return [];
        }
        
        $basketProducts = [];

        foreach ($products as $product) {
            $id = $product['id'];

            if (array_key_exists($id, $_SESSION['basket'])) {
                // Количество берём из корзины
                $quantity = $_SESSION['basket'][$id]['quantity'];

                // Характеристики берём из товара
                $name = $product['name'];
                $price = $product['price'];
                $sum = $price * $quantity;

                // Формируем элемент для вывода
                $basketProducts[] = [
                    'id' => $id,
                    'name' => $name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'sum' => $sum,
                ];
            }
        }
        
        return $basketProducts;
    }
}