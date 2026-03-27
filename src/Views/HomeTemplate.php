<?php
namespace App\Views;

class HomeTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Главная страница';

        $content = <<<LINE
        <section class="py-5 text-center">
            <div class="container">
                
                <!-- НОВЫЙ БЛОК: Заголовок над каруселью -->
                <div class="mb-5">
                    <h1 class="display-4 fw-bold" style="font-family: 'Caveat', cursive; color: #0A3D62;">По мультивселенной</h1>
                </div>

                <!-- Карусель -->
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner w-75 mx-auto">
                        <div class="carousel-item active" style="height: 50vh;">
                            <img src="/assets/img/pizza01.jpg" class="d-block w-100 h-100 object-fit-cover" alt="...">
                        </div>
                        <div class="carousel-item" style="height: 50vh;">
                            <img src="/assets/img/pizza02.jpg" class="d-block w-100 h-100 object-fit-cover" alt="...">
                        </div>
                        <div class="carousel-item" style="height: 50vh;">
                            <img src="/assets/img/pizza03.jpg" class="d-block w-100 h-100 object-fit-cover" alt="...">
                        </div>
                    </div>
                    
                    <!-- Кнопки управления -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Назад</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Вперед</span>
                    </button>
                </div>
            </div>
        </section>
        
        <main class="py-5">
            <div class="container">
                <p>Здесь можно заказать тур.</p>
                <p>Широкий ассортимент, низкие цены!</p>
                <p> (*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме"<br>
                по специальности 09.02.07 "Специалист по информационным технологиям".</p>
            </div>
        </main> 
        LINE;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}