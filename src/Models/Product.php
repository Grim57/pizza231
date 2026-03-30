<?php
namespace App\Models;

use App\Config\Config;

class Product {
    
    /**
     * Загружает товары из JSON-файла
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

    /**
     * Возвращает товары из корзины с полными данными
     */
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
                $quantity = $_SESSION['basket'][$id]['quantity'];
                $name = $product['name'];
                $price = $product['price'];
                $sum = $price * $quantity;

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
    
    /**
     * Подготавливает данные заказа для сохранения.
     * Формирует массив с ключами 'fio', 'products', 'all_sum' и другими.
     * 
     * @param array $formData Данные из формы ($_POST)
     * @param array $basketData Товары корзины
     * @return array Массив готовых данных заказа
     */
    public function prepareData(array $formData, array $basketData): array
    {
        // Обработка данных формы для единообразия с OrderController
        // Это "то, чего не хватало" для идеальной работы.
        $safeFormData = [
            'fio' => isset($formData['fio']) ? trim(urldecode($formData['fio'])) : '',
            'phone' => isset($formData['phone']) ? trim($formData['phone']) : '',
            'address' => isset($formData['address']) ? trim(urldecode($formData['address'])) : '',
            'comment' => isset($formData['comment']) ? trim(urldecode($formData['comment'])) : '',
        ];

        $allSum = 0;
        $items = [];

        // Формируем список товаров и считаем общую сумму
        foreach ($basketData as $item) {
            $price = (float)($item['price'] ?? 0);
            $quantity = (int)($item['quantity'] ?? 0);
            
            $itemSum = $price * $quantity;
            $allSum += $itemSum;

            $items[] = [
                'id' => $item['id'] ?? null,
                'name' => $item['name'] ?? '',
                'price' => $price,
                'quantity' => $quantity,
                'sum' => $itemSum,
            ];
        }

        // Собираем итоговый массив заказа в формате OrderController
        return [
            'order_id' => uniqid('ord_', true),
             'fio' => $safeFormData['fio'],
             'user_phone' => $safeFormData['phone'],
             'user_address' => $safeFormData['address'],
             'user_comment' => $safeFormData['comment'],
             'products' => $items,
             'all_sum' => $allSum,
             'created_at' => date('Y-m-d H:i:s'),
             'status' => 'new',
        ];
    }
    
    /**
     * Сохраняет данные заказа в JSON-файл
     */
    public function saveData(array $arr): void
    {
        $nameFile = Config::FILE_ORDERS;
        
        $dir = dirname($nameFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $allRecords = [];
        if (file_exists($nameFile) && filesize($nameFile) > 0) {
            $handle = fopen($nameFile, "r");
            if ($handle) {
                $data = fread($handle, filesize($nameFile));
                $allRecords = json_decode($data, true) ?? [];
                fclose($handle);
            }
        }
        
        $allRecords[] = $arr;
        
        $json = json_encode($allRecords, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        
        $handle = fopen($nameFile, "w");
        if ($handle) {
            fwrite($handle, $json);
            fclose($handle);
        }
    }
}