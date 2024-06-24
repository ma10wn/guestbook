<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'guestbook');

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$text = $_POST['text'];
$captcha = $_POST['captcha'];

$usernamePattern = '/^[а-яёЁ]+$/ui'; 
if (!preg_match($usernamePattern, $username)) {
    die("Имя пользователя должно содержать только буквы кириллицы");
}

$emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
if (!preg_match($emailPattern, $email)) {
    die("Введите правильный адрес электронной почты");
}

if (trim($text) === "") {
    die("Пожалуйста, введите текст сообщения");
}

if (strtolower($captcha) !== strtolower($_SESSION['captcha'])) {
    die("CAPTCHA должна быть идентична той, что на картинке");
}

$text = strip_tags($text);

$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$sql = "INSERT INTO messages (username, email, text, ip_address, user_agent) VALUES ('$username', '$email', '$text', '$ip_address', '$user_agent')";
if ($conn->query($sql) === TRUE) {
    echo '<script>';
    echo 'alert("Сообщение успешно добавлено");';
    echo 'window.location.href = "index.php";';
    echo '</script>';
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
