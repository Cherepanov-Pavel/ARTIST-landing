<?php
    require "PHPMailer/PHPMailerAutoload.php";


    //не стал ради одной модели делать контроллер и mvc модель, создал лишь отдельный файл для валидации, и отправки письма
    if(isset($_POST['name']) && isset($_POST['phone']))
    {
        $result = [];
        //работает с номерами +7 и 8
        if(!preg_match('/^\+?[0-9]{11,11}$/', $_POST['phone'])){
            $result += ['phone' => 'Введите корректный номер телефона'];
        }
        if(preg_match('/^[а-яА-Яa-zA-Z ]*$/ui',$_POST['name']) == 0){
            $result += ['name' => 'Имена не могут содержать спец. символов и цифр'];
        }
        if(preg_match('/^[ ]*$/ui',$_POST['name']) > 0){
            $result += ['name' => 'Введите имя'];
        }
        if($result == []){
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.jino.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'kurgan@kotopes45.ru';    //Логин
            $mail->Password = '449628pahan';                   //Пароль
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setLanguage('ru');
            $mail->CharSet = "utf-8";
            $mail->setFrom('kurgan@kotopes45.ru', 'Артист');
            $mail->isHTML(true);
            $mail->addAddress('ae@arteast.ru', 'Artist');
            $mail->Subject = 'Новый заказ!';
            $mail->Body    = '<p>Новый заказ! От ' . $_POST['name'] . ' С номером телефона: ' . $_POST['phone'] . '</p>';
            $mail->AltBody = 'Новый заказ! От ' . $_POST['name'] . ' С номером телефона: ' . $_POST['phone'];
            $mail->send();
        }
        header('Content-Type: application/x-javascript; charset=utf8');
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
?>