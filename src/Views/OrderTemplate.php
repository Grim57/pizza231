<?php
namespace App\Views;

class OrderTemplate
{
    public function getOrderTemplate(array $arr): string
    {
        $content = '';
        
        // Заголовки страницы
        $content .= '<h1 class="mb-5">Создание заказа</h1>';
        $content .= '<h3>Корзина</h3>';
        
        $all_sum = 0;
        $products = $arr;
        
        if (count($products) > 0) {
            foreach ($products as $product) {
                $name = $product['name'];
                $price = $product['price'];
                $quantity = $product['quantity'];
                $sum = $product['sum'];
                $all_sum += $sum;

                $content .= <<<LINE
                <div class="row mb-2 border-bottom pb-2">
                    <div class="col-6">
                        {$name}
                    </div>
                    <div class="col-4">
                        {$quantity} ед. × {$price} руб.
                    </div>
                    <div class="col-2 text-end">
                        {$sum} ₽
                    </div>
                </div>
                LINE;
            }
            
            // Итоговая сумма
            $content .= <<<LINE
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <strong>Итого: {$all_sum} ₽</strong>
                </div>
            </div>
            LINE;
            
            // Кнопка очистки корзины
            $content .= <<<LINE
            <div class="row mt-3">
                <div class="col-6"></div>
                <div class="col-6 text-end">
                    <form action="/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary">
                            Очистить корзину
                        </button>
                    </form>
                </div>
            </div>
            LINE;
            
        } else {
            // Нет товаров в корзине
            $content .= <<<LINE
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-light">- нет добавленных товаров -</div>
                </div>
            </div>
            LINE;
        }
        
        // === НОВАЯ ФОРМА ДОСТАВКИ ===
        $content .= <<<LINE
        <h3 class="mt-5 mb-3">Данные для доставки</h3>
        <form action="/order" method="POST">
            <div class="mb-3">
                <label for="fio" class="form-label">Ваше ФИО:</label>
                <input type="text" class="form-control" id="fio" name="fio" required>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Адрес доставки:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон:</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Создать заказ</button>
        </form>
        LINE;
        // === КОНЕЦ ФОРМЫ ===
        
        // Возвращаем через базовый шаблон
        $baseTemplate = BaseTemplate::getTemplate();
        return sprintf($baseTemplate, 'Заказ - Тур Агенство', $content);
    }
}