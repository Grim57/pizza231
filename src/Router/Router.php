<?php
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController; 

class Router {
    public function route(string $url): string {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", $path);
        $resource = $pieces[1];
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
            case "products":
                $product = new ProductController();
                $id = (isset($pieces[2])) ? intval($pieces[2]) : 0;
                return $product->get($id);
            default:
                $home = new HomeController();
                return $home->get();
            case "basket":
            $basketController = new BasketController();
            $basketController->add();
            // Возвращаем пользователя на предыдущую страницу
            $prevUrl = $_SERVER['HTTP_REFERER'];
            header("Location: {$prevUrl}");
            exit();    
        }
    }
}