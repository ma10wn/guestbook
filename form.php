<?php
session_start();

if (!isset($_SESSION['captcha']) || empty($_SESSION['captcha'])) {
    $captcha_text = '';
    for ($i = 0; $i < 6; $i++) {
        $captcha_text .= chr(rand(97, 122));
    }
    $_SESSION['captcha'] = strtolower($captcha_text); 
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            width: 550px;
            background-color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }
        input[type="text"],
        textarea,
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 18px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type="submit"] {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            padding: 10px 24px;
            background-color: #37B7C3;
            border: 2px solid #37B7C3;
            border-radius: 25px;
            transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }
        input[type="submit"]:hover {
            color: #fff;
            background-color: #088395;
            border-color: #088395;
        }
        button {
            display: inline-block;
            margin-top: 20px;
            font-size: 15px;
            color: #fff;
            text-decoration: none;
            padding: 7px 24px;
            background-color: #CD8D7A;
            border: 2px solid #CD8D7A;
            border-radius: 25px;
            transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }

        button:hover {
            color: #fff;
            background-color: #7d4331;
            border-color: #7d4331;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }
        .captcha {
            margin-top: 10px;
            display: flex;
            align-items: center;
        }
        .captcha img {
            margin-left: 10px;
            vertical-align: middle;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Добавить сообщение</h1>
        <form name="messageForm" action="submit.php" onsubmit="return validateForm()" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" oninput="restrictToCyrillic(event)" required>

            <label for="email">Электронная почта:</label>
            <input type="text" id="email" name="email" oninput="restrictToLatinEmail(event)" required>

            <label for="text">Сообщение:</label>
            <textarea id="text" name="text" required></textarea>

            <div class="captcha">
                <label for="captcha">CAPTCHA:</label>
                <?php echo '<img src="data:image/png;base64,' . base64_encode(generateCaptcha()) . '" alt="CAPTCHA">'; ?>
                <input type="text" id="captcha" name="captcha" required>
            </div>

            <input type="submit" value="Отправить">
            <button type="button" onclick="goToIndexPage()">Назад</button>
        </form>
    </div>

    <script>
        function validateForm() {
            var username = document.forms["messageForm"]["username"].value;
            var email = document.forms["messageForm"]["email"].value;
            var text = document.forms["messageForm"]["text"].value;
            var captcha = document.forms["messageForm"]["captcha"].value;

            var usernamePattern = /^[а-яёЁ]+$/i;
            if (!usernamePattern.test(username)) {
                alert("Имя пользователя должно содержать только буквы кириллицы");
                return false;
            }

            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                alert("Введите правильный адрес электронной почты");
                return false;
            }

            if (text.trim() === "") {
                alert("Пожалуйста, введите текст сообщения");
                return false;
            }

            var expectedCaptcha = "<?php echo $_SESSION['captcha']; ?>";
            if (captcha.trim().toLowerCase() !== expectedCaptcha) {
                alert("CAPTCHA должна быть идентична той, что на картинке");
                return false;
            }
            return true;
        }
        function restrictToCyrillic(event) {
            var input = event.target;
            var regex = /^[а-яёЁ]+$/i;
            var isValid = regex.test(input.value);
            if (!isValid) {
                input.value = input.value.replace(/[^а-яёЁ]+/ig, '');
            }
        }
        function restrictToLatinEmail(event) {
            var input = event.target;
            var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var isValid = regex.test(input.value);
            if (!isValid) {
                input.value = input.value.replace(/[^a-zA-Z0-9._%+-@.]+/g, '');
            }
        }
        function goToIndexPage() {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>

<?php
function generateCaptcha() {
    $captcha_text = '';
    for ($i = 0; $i < 6; $i++) {
        $captcha_text .= chr(rand(97, 122));
    }
    $_SESSION['captcha'] = strtolower($captcha_text); 

    $image_width = 150;
    $image_height = 50;
    $image = imagecreatetruecolor($image_width, $image_height);

    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 0, 0, 0);

    imagefilledrectangle($image, 0, 0, $image_width, $image_height, $background_color);

    $font_size = 20;
    $text_x = 10;
    $text_y = 30;
    imagestring($image, $font_size, $text_x, $text_y, $captcha_text, $text_color);

    $line_color = imagecolorallocate($image, 180, 180, 180);
    for ($i = 0; $i < 5; $i++) {
        imageline($image, rand(0, $image_width), rand(0, $image_height), rand(0, $image_width), rand(0, $image_height), $line_color);
    }

    $noise_color = imagecolorallocate($image, 150, 150, 150);
    for ($i = 0; $i < 50; $i++) {
        imagesetpixel($image, rand(0, $image_width), rand(0, $image_height), $noise_color);
    }
    echo '<script>';
    echo 'console.log("CAPTCHA:", "' . strtolower($_SESSION['captcha']) . '");';
    echo '</script>';
    ob_start();
    imagepng($image);
    $image_data = ob_get_contents();
    ob_end_clean();

    return $image_data;
}
?>
