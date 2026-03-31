<?php
namespace App\Controllers;

use App\Models\Product;
use App\Views\OrderTemplate;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OrderController
{
    public function get(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->create();
        }

        $productModel = new Product();
        $basketData = $productModel->getBasketData();
        $orderView = new OrderTemplate();
        return $orderView->getOrderTemplate($basketData);
    }

    public function create(): string
    {
        $model = new Product();
        $formData = $_POST;
        $basketData = $model->getBasketData();
        $orderData = $model->prepareData($formData, $basketData);
        $model->saveData($orderData);

        // Отправка письма
        $email = $formData['email'] ?? '';
        if (!empty($email)) {
            $clientName = $formData['name'] ?? 'Клиент';
            $this->sendMail($email, $clientName, $orderData);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Спасибо! Нам очень приятный ваши деньги.";

        header("Location: /");
        exit;
    }

    private function sendMail(string $email, string $clientName, array $orderData): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->isSMTP();
            $mail->Host = 'smtp.mail.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'coopteh231@mail.ru';
            $mail->Password = 'oBdxSwM2AWnco7ALXUk5';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('coopteh231@mail.ru', 'По мультивселенной');
            $mail->addAddress($email, $clientName);
            $mail->addReplyTo('coopteh231@mail.ru', 'Поддержка');

            $mail->isHTML(true);
            $mail->Subject = 'Тур подтверждён';

            $items = $orderData['products'] ?? [];
            $itemsHtml = '';
            $total = $orderData['all_sum'] ?? 0;

            foreach ($items as $item) {
                $name = htmlspecialchars($item['name'] ?? 'Тур');
                $price = $item['price'] ?? 0;
                $qty = $item['quantity'] ?? 1;
                $subtotal = $price * $qty;
                $itemsHtml .= "<li>{$name} × {$qty} = <b>{$subtotal} ₽</b></li>";
            }

            // Поддержка разных ключей для телефона и адреса
            $phone = htmlspecialchars($orderData['phone'] ?? ($orderData['user_phone'] ?? ''));
            $address = htmlspecialchars($orderData['address'] ?? ($orderData['user_address'] ?? ''));

            $mail->Body = "
                <html>
                <head><style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background: #0A3D62; color: white; padding: 20px; text-align: center; }
                    .content { padding: 20px; }
                    .order-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    .items { list-style: none; padding: 0; }
                    .items li { padding: 5px 0; border-bottom: 1px solid #eee; }
                    .total { font-size: 1.2em; font-weight: bold; color: #0A3D62; margin-top: 15px; }
                    .footer { text-align: center; color: #666; font-size: 0.9em; margin-top: 30px; }
                </style></head>
                <body>
                    <div class='header'>
                        <h2>По мультивсленной</h2>
                        <p>Ваша покупка подтверждёна</p>
                    </div>
                    <div class='content'>
                        <p>Здравствуйте, <b>{$clientName}</b>!</p>
                        <div class='order-info'>
                            <p><b>Дата заказа:</b> " . date('d.m.Y H:i') . "</p>
                            <p><b>Телефон:</b> {$phone}</p>
                            <p><b>Адрес доставки:</b> {$address}</p>
                        </div>
                        <p><b>Состав заказа:</b></p>
                        <ul class='items'>" . ($itemsHtml ?: '<li>Список товаров недоступен</li>') . "</ul>
                        <p class='total'>Итого к оплате: {$total} ₽</p>
                        <p>Спасибо за покупку!</p>
                        <div class='footer'>
                            <p>Это письмо сгенерировано автоматически.<br>Не отвечайте на это сообщение.</p>
                            <p>© 2025 Кемеровский кооперативный техникум</p>
                        </div>
                    </div>
                </body>
                </html>";

            $mail->AltBody = "Тур подтверждён!\nЗдравствуйте, {$clientName}!\n"
                . "Телефон: {$phone}\n"
                . "Адрес: {$address}\n"
                . "Итого к оплате: {$total} ₽\n"
                . "Состав заказа:\n"
                . implode("\n", array_map(function($i) {
                    return "- {$i['name']} × ".($i['quantity']??1)." = ".(($i['price']??0)*($i['quantity']??1))." ₽";
                }, $items));

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $mail->ErrorInfo . " | Exception: " . $e->getMessage());

            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['mail_error'] = 'Не удалось отправить email: ' . $mail->ErrorInfo;
            }
            return false;
        }
    }
}