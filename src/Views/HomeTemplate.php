<?php
namespace App\Views;

class HomeTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Главная страница';

        $content = <<<LINE
        <!-- Hero Section (Шапка с формой) -->
        <section class="bg-primary text-white text-center py-5" style="background-image: url('/assets/img/pizza1.jpg'); background-size: cover; background-position: center;">
            <div class="container position-relative">
                <div class="overlay bg-black opacity-50"></div>
                <h1 class="display-4 fw-bold position-relative" style="font-family: 'Caveat', cursive; z-index: 1;">Планируйте путешествие мечты</h1>
                
                <!-- Форма поиска -->
                <form class="d-flex justify-content-center mt-4 position-relative z-index-1" style="max-width: 600px; margin: 0 auto;">
                    <input class="form-control me-2" type="search" placeholder="Куда хотите поехать?" aria-label="Search">
                    <button class="btn btn-light" type="submit">Найти тур</button>
                </form>
            </div>
        </section>

        <!-- Popular Destinations (Карточки) -->
        <main class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold" style="color: #343A40;">Популярные направления</h2>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4 col-sm-6" style="opacity: 0; transform: translateY(30px); animation: fadeInUp 1s forwards; animation-delay: 0.2s; transition: transform .3s;">
                        <a href="#" class="text-decoration-none text-dark card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 2px solid transparent;">
                            <img src="/assets/img/pizza1.jpg" class="card-img-top" alt="...">
                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title">Горы</h5>
                                <p class="card-text flex-grow-1">Величественные вершины и свежий воздух.</p>
                                <button class="btn btn-outline-primary mt-auto">Подробнее</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6" style="opacity: 0; transform: translateY(30px); animation: fadeInUp 1s forwards; animation-delay: 0.4s; transition: transform .3s;">
                        <a href="#" class="text-decoration-none text-dark card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 2px solid transparent;">
                            <img src="/assets/img/pizza02.jpg" class="card-img-top" alt="...">
                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title">Море</h5>
                                <p class="card-text flex-grow-1">Солнечные пляжи и теплое море.</p>
                                <button class="btn btn-outline-primary mt-auto">Подробнее</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6" style="opacity: 0; transform: translateY(30px); animation: fadeInUp 1s forwards; animation-delay: 0.6s; transition: transform .3s;">
                        <a href="#" class="text-decoration-none text-dark card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 2px solid transparent;">
                            <img src="/assets/img/pizza03.jpg" class="card-img-top" alt="...">
                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title">Города</h5>
                                <p class="card-text flex-grow-1">Архитектура и история.</p>
                                <button class="btn btn-outline-primary mt-auto">Подробнее</button>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Special Offers (Акции) -->
                <section class="mt-5 py-5 bg-light">
                    <div class="container">
                        <h2 class="text-center mb-4 fw-bold" style="color: #343A40;">Горящие туры</h2>
                        <div class="row g-4 justify-content-center align-items-stretch">
                            <div class="col-md-6 col-lg-4" style="opacity: 0; transform: translateY(30px); animation: fadeInUp 1s forwards; animation-delay: 0.8s; transition: transform .3s;">
                                <div class="card h-100 shadow border-danger">
                                    <img src="/assets/img/pizza1.jpg" class="card-img-top" alt="...">
                                    <div class="card-body d-flex flex-column p-3">
                                        <h5 class="card-title text-danger"><i class="bi bi-fire me-2"></i> Турция, Анталия</h5>
                                        <p class="card-text flex-grow-1">Отдых на берегу Средиземного моря.</p>
                                        <span class="badge bg-danger text-white fs-6 mt-auto"><i class="bi bi-tag"></i> -30%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4" style="opacity: 0; transform: translateY(30px); animation: fadeInUp 1s forwards; animation-delay: 1.0s; transition: transform .3s;">
                                <div class="card h-100 shadow border-success">
                                    <img src="/assets/img/pizza02.jpg" class="card-img-top" alt="...">
                                    <div class="card-body d-flex flex-column p-3">
                                        <h5 class="card-title text-success"><i class="bi bi-sun me-2"></i> Египет, Хургада</h5>
                                        <p class="card-text flex-grow-1">Все включено по лучшей цене.</p>
                                        <span class="badge bg-success text-white fs-6 mt-auto"><i class="bi bi-tag"></i> -25%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Reviews (Отзывы) -->
                <section id="reviews" class="mt-5 pt-5 border-top border-2 border-primary bg-light">
                    <div class="container">
                        <h2 class="text-center mb-4 fw-bold" style="color: #343A40;">Отзывы наших клиентов</h2>
                        <div id="reviewCarousel" class="carousel slide w-75 mx-auto" data-bs-ride="carousel">
                            <div class="carousel-inner w-75 mx-auto">
                                <div class="carousel-item active text-center p-4 rounded shadow-sm bg-white" style="opacity: 0; transform: translateY(20px); animation: fadeInUp 1s forwards; animation-delay: 1.2s; transition: transform .3s; border-radius: 25px; background-color: rgba(255,255,255,0.9); backdrop-filter: blur(5px); border: 1px solid rgba(0,0,0,.1); box-shadow: 0 8px 25px rgba(0,0,0,.08);">
                                    <p>"Отличная организация! Все было на высшем уровне."</p>
                                    <p><strong>— Иван Петров</strong></p>
                                </div>
                                <div class="carousel-item text-center p-4 rounded shadow-sm bg-white" style="opacity: 0; transform: translateY(20px); animation: fadeInUp 1s forwards; animation-delay: 1.6s; transition: transform .3s; border-radius: 25px; background-color: rgba(255,255,255,0.9); backdrop-filter: blur(5px); border: 1px solid rgba(0,0,0,.1); box-shadow: 0 8px 25px rgba(0,0,0,.08);">
                                    <p>"Спасибо за незабываемые впечатления! Обязательно поеду еще."</p>
                                    <p><strong>— Анна Смирнова</strong></p>
                                </div>
                            </div>
                            <button class="carousel-control-prev position-relative top-50 start-5 translate-middle-y" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev"></button>
                            <button class="carousel-control-next position-relative top-50 end-5 translate-middle-y" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next"></button>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        <!-- Footer (Подвал сайта) -->
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p>© 2026 Туристическое агентство "Мультивселенная". Все права защищены.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="/about" class="text-white me-3">О нас</a> |
                        <a href="/products" class="text-white me-3">Каталог туров</a> |
                        <a href="#" class="text-white me-3">Контакты</a> |
                        <a href="#" class="">+7 (999) 123-45-67</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Анимации и стили -->
        <style>
            /* Анимация появления */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            
            /* Эффект наведения для карточек */
            .card {
                transition: transform .3s ease-in-out, box-shadow .3s ease-in-out;
            }
            .card a {
                color: inherit;
            }
            .card a img {
                transition: transform .3s ease;
            }
            .card a img.card-img-top {
                height: 200px;
                object-fit-cover;
            }
            .card a img.card-img-top.darken-on-hover {
                filter: brightness(95%);
            }
            .card a img.card-img-top.brighten-on-hover {
                filter: brightness(110%);
            }
            
            /* Эффект при наведении на всю карточку */
            .card a.hover-zoom {
                display: block;
                transition-duration:.7s;
            }
            
            .card a.hover-zoom img {
                transition-duration:.7s;
            }
            
            .card a.hover-zoom .card-img-top {
                transition-timing-function:ease-out;
            }
            
            .card a.hover-zoom .card-img-top.darken-on-hover {
                transition-timing-function:ease-in;
            }
            
            .card a.hover-zoom.darken-on-hover {
                transition-timing-function:ease-in;
            }
            
            /* Стиль для кнопок */
            .btn-outline-primary {
                transition: background-color .3s ease;
            }
            
            /* Стиль для Hero-секции */
            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index:-1;
            }
        </style>
        
        LINE;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}