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
}