<?php
    $msg_box = ""; 
    $errors = array(); 

    // если форма без ошибок
    if(empty($errors)){     
        // собираем данные из формы
        $message = "Имя: " . $_POST['user_name'] . "<br/> Номер телефона: " . $_POST['user_tel'];
        send_mail($message); // отправим письмо
    }
     
    // функция отправки письма
    function send_mail($message){
        // почта, на которую придет письмо
        $mail_to = "egor.ostashev@mail.ru"; 
        // тема письма
        $subject = "Заявка на бесплатный замер";
         
        // заголовок письма
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
        $headers .= "From: <egor.ostashev@mail.ru>\r\n"; // от кого письмо
         
        // отправляем письмо 
        mail($mail_to, $subject, $message, $headers);
    }
     
?>

<?php

//В переменную $token нужно вставить токен, который нам прислал @botFather
$token = "1856412010:AAGSUNLmAl0DQHbLtS2prnrFN6ffuiZGBDk";

//Сюда вставляем chat_id
$chat_id = "-513966792";

//Определяем переменные для передачи данных из нашей формы
    $name = ($_POST['user_name']);
    $phone = ($_POST['user_tel']);

//Собираем в массив то, что будет передаваться боту
    $arr = array(
        'Имя:' => $name,
        'Телефон:' => $phone
    );

//Настраиваем внешний вид сообщения в телеграме
    foreach($arr as $key => $value) {
        $txt .= "<b>".$key."</b> ".$value."%0A";
    };

//Передаем данные боту
    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

?>

<?php
// формируем запись в таблицу google (изменить)
$url = "https://docs.google.com/forms/d/1-8oU23LmvTGXCM2JXSMR_X7ZoqwnCiT0E5sGHbvdZek/formResponse";

// массив данных (изменить entry, draft и fbzx)
$post_data = array (
 "entry.111111111" => $_POST['user_name'],
 "entry.222222222" => $_POST['user_tel'],
 "draftResponse" => "[,,&quot;-7496768596036869238&quot;]",
 "pageHistory" => "0",
 "fbzx" => "-7496768596036869238"
);

// Далее не трогать
// с помощью CURL заносим данные в таблицу google
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// указываем, что у нас POST запрос
curl_setopt($ch, CURLOPT_POST, 1);
// добавляем переменные
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//заполняем таблицу google
$output = curl_exec($ch);
curl_close($ch);

?>