<?php
namespace App\Views;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        // Получаем базовый шаблон от родительского класса
        $template = parent::getTemplate();

        // Заголовок страницы
        $title = 'О нас';

        // Контент страницы с исправленным путём к картинке
        $content = <<<LINE2
        <main class="row">
            <div class="mt-5">
                <p>Наше здание находится на территории "Кемеровского кооперативного техникума"</p>
                <!-- Путь к картинке исправлен: /asserts -> /assets -->
                <p><img class="h-50 w-70" src="/assets/img/map-ya.png" alt="Карта"></p>
            </div>
        </main>
LINE2;

        // Подставляем заголовок и контент в шаблон
        $resultTemplate = sprintf($template, $title, $content);

        return $resultTemplate;
    }
}