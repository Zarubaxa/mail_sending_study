<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg_box = "";
$errors = array();

// Проверка полей формы
if ($_POST['user_name'] == "") $errors[] = "Поле имени не заполнено!";
if (($_POST['user_email'] == "") || (filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) == false)) {
    $errors[] = "Поле email не заполнено!";
}
if (($_POST['user_phone'] == "") || strlen($_POST['user_phone']) < 12) {
    $errors[] = "Поле номер телефона не заполнено!";
}
if ($_POST['text_comment'] == "") $errors[] = "Поле text не заполнено!";

if (empty($errors)) {
    $message = "ФИО пользователя: " . $_POST['user_name'] . "<br>";
    $message .= "Email пользователя: " . $_POST['user_email'] . "<br>";
    $message .= "Номер телефона пользователя: " . $_POST['user_phone'] . "<br>";
    $message .= "Текст письма: " . $_POST['text_comment'];

    // Отправляем письмо через PHPMailer
    if (send_mail($message)) {
        $msg_box = "<span style='color: green;'>Сообщение успешно отправлено!</span>";
    } else {
        $msg_box = "<span style='color: red;'>Ошибка при отправке сообщения!</span>";
    }
} else {
    foreach ($errors as $one_error) {
        $msg_box .= "<span style='color: red;'>$one_error</span><br>";
    }
}
echo $msg_box;

// Функция отправки письма с использованием PHPMailer
function send_mail($message)
{
    $mail = new PHPMailer(true);

    try {
        // Настройки сервера
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Адрес SMTP сервера
        $mail->SMTPAuth = true;
        $mail->Username = 'zarubaxa@gmail.com'; // Ваш логин
        $mail->Password = getenv('EMAIL_PASSWORD'); // Получаем пароль из переменной окружения
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Шифрование
        $mail->Port = 587;

//        $mail->SMTPDebug = 2;  // Уровень отладки: 2 выводит самые подробные сообщения (можно использовать 1 для менее подробных)
//        $mail->Debugoutput = 'html';  // Вывод отладки в формате HTML


        $mail->setFrom('no-reply@yourdomain.com', 'Test letter');
        $mail->addAddress('zarubaxa@gmail.com'); // Получатель письма

        $mail->isHTML(true);
        $mail->Subject = 'Request form';
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Ошибка при отправке сообщения: {$mail->ErrorInfo}";
        return false;
    }
}
