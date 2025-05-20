<?php
session_start();
// Подключение к базе данных
include 'connect.php';

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);
    $confirm_password = trim($_POST['psw-repeat']);

    $errors = [];

    // Валидация email
    if (empty($email)) {
        $errors[] = "Пожалуйста, введите email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный формат email";
    }

    // Валидация пароля
    if (empty($password)) {
        $errors[] = "Пожалуйста, введите пароль";
    } elseif (strlen($password) < 6) {
        $errors[] = "Пароль должен содержать минимум 6 символов";
    }

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают";
    }

    // Проверка уникальности email
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Этот email уже зарегистрирован";
        }
    }

    // Регистрация пользователя
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");

        if ($stmt->execute([$email, $hashed_password])) {
            // Успешная регистрация
            $_SESSION['registration_success'] = true;
            header("Location: registration_success.php");
            exit();
        } else {
            $errors[] = "Ошибка при регистрации. Пожалуйста, попробуйте позже.";
        }
    }

    // Сохраняем ошибки в сессии для отображения в форме
    if (!empty($errors)) {
        $_SESSION['reg_errors'] = $errors;
        $_SESSION['old_email'] = $email;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Вишневый сад | Регистрация</title>
    <link rel="stylesheet" href="/css/cssAction/cssReg.css" />
    <link rel="stylesheet" href="/css/styles.css" />
    <script src="js/Js.js"></script>
</head>

<body>
    <!--Панель навигации-->
    <header class="Header">
        <nav class="IndexHeadernav">
            <ul class="IndexHeaderul">
                <li>
                    <a class="IndexHeadera" href="/index.php"><img id="LogoIMG" src="css/Pictures/лого.svg" alt="Логотип" /></a>
                </li>
                <li>
                    <a class="Abzach IndexHeadera" id="nav" href="/index.php#MainAboutCompany">О Компании</a>
                </li>
                <li>
                    <a class="Abzach IndexHeadera" id="nav" href="/map.php">Местоположение</a>
                </li>
                <li>
                    <a class="Abzach IndexHeadera" id="nav" href="/Catalog.php">Каталог</a>
                </li>

                <div class="burger" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <nav class="NavigateBlock" id="NavigateBlock">
                    <a class="Abzach IndexHeadera" href="/index.php#MainAboutCompany">О Компании</a>
                    <a class="Abzach IndexHeadera" href="/map.php">Местоположение</a>
                    <a class="Abzach IndexHeadera" href="/Catalog.php">Каталог</a>
                </nav>
            </ul>
        </nav>
    </header>

    <div class="container">
        <form method="post" class="registration-form">
            <h1>Форма регистрации</h1>
            <p>Пожалуйста, заполните эту форму, чтобы создать учетную запись.</p>
            <hr />

            <?php
            // Вывод ошибок
            if (isset($_SESSION['reg_errors'])) {
                echo '<div class="error-messages">';
                foreach ($_SESSION['reg_errors'] as $error) {
                    echo '<p class="error">' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';
                unset($_SESSION['reg_errors']);
            }
            ?>

            <label for="email"><b>Email</b></label>
            <input
                type="text"
                placeholder="Введите вашу почту"
                name="email"
                value="<?php echo isset($_SESSION['old_email']) ? htmlspecialchars($_SESSION['old_email']) : ''; ?>"
                required />
            <?php unset($_SESSION['old_email']); ?>

            <label for="psw"><b>Пароль</b></label>
            <input type="password" placeholder="Введите пароль" name="psw" required />

            <label for="psw-repeat"><b>Повторить пароль</b></label>
            <input
                type="password"
                placeholder="Повторите пароль"
                name="psw-repeat"
                required />

            <label>
                <input type="checkbox" checked="checked" name="remember" /> Запомнить меня
            </label>

            <p>
                Создавая учетную запись, вы соглашаетесь с нашим
                <a href="#" class="terms-link">Условия и конфиденциальность</a>
            </p>

            <a class="account-exists" href="Autoris.php">Уже есть аккаунт?</a>
            <div class="clearfix">
                <button type="button" class="cancelbtn">Отменить</button>
                <button type="submit" class="signupbtn">Регистрация</button>
            </div>
        </form>
    </div>

    <script src="/js/script.js"></script>
</body>

</html>