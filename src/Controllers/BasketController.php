<?php

namespace App\Controllers; // Проверьте ваш неймспейс

class BasketController
{
    public function add(): void
    {
        session_start();

        if (isset($_POST['id'])) {
            $product_id = $_POST['id'];

            // Инициализируем корзину, если она пустая
            if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = [];
            }

            // Если товар уже есть, увеличиваем количество
            if (isset($_SESSION['basket'][$product_id])) {
                $_SESSION['basket'][$product_id]['quantity']++;
            } else {
                // Иначе добавляем новый товар с количеством 1
                $_SESSION['basket'][$product_id] = [
                    'quantity' => 1
                    // Сюда можно добавить цену или название, если они нужны сразу
                ];
            }
            
            // Для отладки можно раскомментировать:
            var_dump($_SESSION);
            exit();
        }
    }

    /* 
     * Очистка корзины
     */
    public function clear(): void
    {
        session_start();
        $_SESSION['basket'] = [];
        // Перенаправление обратно
        $prevUrl = $_SERVER['HTTP_REFERER'] ?? '/pizza221/';
        header("Location: {$prevUrl}");
        exit();
    }
}