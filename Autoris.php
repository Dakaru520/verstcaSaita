<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вишневый сад | Авторизация</title>
    <link rel="stylesheet" href="../css/cssAction/cssAutor.css">
</head>

<body>

    <?
    session_start();
    require_once 'connect.php';
    $conn = new mysqli($host, $username, $password, $dbname);
    // Вывод ошибки если к бд не смогли подключиться
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    } else {
        $login = $_POST['login'];
        $query = "SELECT * FROM Users WHERE login='$login'";
        $user = mysqli_fetch_assoc(mysqli_query($conn, $query));
        if (empty($user)) {


            if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['email'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                $query = "INSERT INTO Users(id, login, password, email) VALUES (null, '$login','$password','$email')";

                mysqli_query($conn, $query);
                if (!empty($_['login']) and !empty($_POST['password']) and !empty($_['email'])) {
                    $login = $_POST['login'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];

                    $query = "SELECT * FROM users WHERE login='$login' and password='$password' and email='$email' ";

                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) == 1) {
                        $_SESSION['login'] = $login;
                        $id = mysqli_insert_id($conn);
                        $_SESSION['id'] = $id;

                        echo "Добро пожаловать, " . $login;
                        exit();
                    } else {
                        echo "Ошибка ввода";
                    }
                }
            }
        } else {
            echo "пользователь с таким логином уже существует.";
        }
    }

    ?>
    <div>
        <a href="../index.html">Вернуться на главную</a>
    </div>
    <div class="container">
        <form method="post" action="" class="registration-form">
            <h1>Форма входа</h1>
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

            <label>
                <input type="checkbox" checked="checked" name="remember" /> Запомнить меня
            </label>

            <a class="account-exists" href="Registr.php">Ещё не зарегистрированы?</a>
            <div class="clearfix">
                <button type="button" class="cancelbtn">Отменить</button>
                <button type="submit" class="signupbtn">Вход</button>
            </div>
        </form>
    </div>
</body>

</html>