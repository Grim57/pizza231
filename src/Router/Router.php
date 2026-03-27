<?php
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;
use App\Controllers\OrderController;

class Router {
    
    // Базовый путь проекта - измените если нужно
    private const BASE_PATH = 'pizza221';
    
    public function route(string $url): string {
        // Получаем путь из URL
        $path = parse_url($url, PHP_URL_PATH);
        
        // Убираем базовый путь из начала строки
        $path = $this->stripBasePath($path);
        
        // Разбиваем на части
        $pieces = array_filter(explode("/", $path)); // array_filter убирает пустые элементы
        $pieces = array_values($pieces); // переиндексируем массив
        
        // Получаем ресурс (первый элемент после очистки)
        $resource = $pieces[0] ?? '';
        
        // Получаем дополнительные параметры (id товара и т.д.)
        $param = $pieces[1] ?? null;

        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
                
            case "products":
                $product = new ProductController();
                $id = $param ? intval($param) : 0;
                return $product->get($id);
                
            case "basket":
                $basketController = new BasketController();
                $basketController->add();
                $prevUrl = $_SERVER['HTTP_REFERER'] ?? '/pizza221/';
                header("Location: {$prevUrl}");
                exit;
                
            case "order":
                $orderController = new OrderController();
                return $orderController->get();
                
            case "basket_clear":
                $basketController = new BasketController();
                $basketController->clear();
                $prevUrl = $_SERVER['HTTP_REFERER'] ?? '/pizza221/';
                header("Location: {$prevUrl}");
                exit;
                
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
    
    /**
     * Убирает базовый путь из начала строки
     */
    private function stripBasePath(string $path): string {
        $basePath = '/' . self::BASE_PATH;
        
        // Если путь начинается с /pizza221, убираем это
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        // Убираем слеш в начале если есть
        $path = ltrim($path, '/');
        
        return $path;
    }
}