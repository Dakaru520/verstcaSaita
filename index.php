<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вишневый сад | Главная</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/IndexStyle.css">
    <script src="js/Js.js"></script>
    <!-- Подключение Bootstrap для карусели комментариев -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Скрипт Плавного скролла-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smoothscroll/1.4.10/SmoothScroll.min.js"
        integrity="sha256-huW7yWl7tNfP7lGk46XE+Sp0nCotjzYodhVKlwaNeco=" crossorigin="anonymous"></script>
</head>

<body>
    <!--Главная страница-->
    <article class="MainBlock1" id="MainBlock1">

    </article>

    <!--Панель навигации-->
    <header class="IndexHeader">
        <nav class="IndexHeadernav">
            <ul class="IndexHeaderul">
                <li><a class="IndexHeadera" href="#MainBlock1"><img id="LogoIMG"
                            src="css/Pictures/лого.svg"></a></li>
                <li><a class="Abzach" class="IndexHeadera" id="nav" href="#MainAboutCompany">О Компании</a></li>
                <li><a class="Abzach" class="IndexHeadera" id="nav" href="map.html">Местоположение</a></li>
                <li><a class="Abzach" class="IndexHeadera" id="nav" href="Catalog.php">Каталог</a></li>
                <li><a class="Abzach" id="nav" href="Registr.php"><img id="profileIMG"
                            src="css/Pictures/profile-user.svg"></a></li>
                <div class="burger" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="NavigateBlock" id="NavigateBlock">
                    <nav class="NavBurg">
                        <a class="Abzach" class="IndexHeadera" href="#MainAboutCompany">О Компании</a>
                        <a class="Abzach" class="IndexHeadera" href="map.html">Местоположение</a>
                        <a class="Abzach" class="IndexHeadera" href="Catalog.html">Каталог</a>
                        <a class="Abzach" class="IndexHeadera" href="Registr.php">Личный кабинет</a>
                    </nav>
                </div>
            </ul>
        </nav>

    </header>
    <!--О компании текст и картинка-->
    <article class="MainAboutCompany" id="MainAboutCompany">
        <img id="MainAboutCompanyIMG" src="css/Pictures/Main2.jpg">
        <div class="TEXTMainAboutCompany">
            <h1 class="Zagolovok1">О Компании</h1>
            <h5 class="Abzach">“Вишневый сад” ресторан-кондитерская которая находится на рынке белее 10 лет переживая
                много
                изменений и сейчас имеет внутри себя производство совершенно разной продукции.</h5>

            <h5 class="Abzach">В кондитерской продукции вы можете встретить пироженные, конфеты, печенья, торты а
                также хлеба.</h5>

            <h5 class="Abzach">Также можно увидеть разные соусы и паштеты. Еще можно купить из готовой продукции
                заморозку -
                это вареники, блины и пельмени</h5>


        </div>
    </article>


    <!--Авторские блюда-->
    <div class="MainAvtorFood">
        <div class="TextAvtorFood">
            <h1 class="Zagolovok1">Авторские блюда</h1>

        </div>
        <div class="AvtorFood">
            <div class="ForFood">
                <h1 class="Zagolovok1">Соусы</h1>
                <div class="SomeFood"><img id="Souse" src="css/Pictures/yablo.jpg"></div>

            </div>
            <div class="ForFood">
                <h1 class="Zagolovok1">Паштеты</h1>
                <div class="SomeFood"><img id="Pashtet" src="css/Pictures/yablo.jpg"> </div>

            </div>
            <div class="ForFood">
                <h1 class="Zagolovok1">Десерты</h1>
                <div class="SomeFood"><img id="Desert" src="css/Pictures/yablo.jpg"></div>
            </div>
        </div>
    </div>


    <!-- Скрипт -->
    <?
    // Подключение к бд
    require_once 'connect.php';

    // Получаем только видимые комментарии
    $sql = "SELECT content FROM feedback WHERE Visibility = 1 ORDER BY ID_feedback  DESC";
    $result = $conn->query($sql);

    $comments = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row['content']; // Сохраняем только текст
        }
    }

    $conn->close();

    // Оставляем только количество комментариев, кратное 3 (чтобы блоки были полными)
    $commentCount = count($comments);
    $commentsToShow = floor($commentCount / 3) * 3;
    $comments = array_slice($comments, 0, $commentsToShow);
    ?>

    <div class="MainComment">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <!-- Первый блок -->
                <div class="carousel-item active">
                    <div class="ForComment">
                        <!-- Получение первых трех комментариев для главного блока -->
                        <?php for ($i = 0; $i < 3 && $i < count($comments); $i++): ?>
                            <div class="comment" id="com<?php echo $i + 1; ?>">
                                <p class="content"><?php echo htmlspecialchars($comments[$i]); ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Остальные блоки -->
                <?php
                if (count($comments) > 3) {
                    // Пропускаем первые 3 (они уже в первом блоке)
                    $remainingComments = array_slice($comments, 3);
                    // Разбиваем на блоки по 3 
                    $chunks = array_chunk($remainingComments, 3);


                    // Генерация других блоков комментариев
                    foreach ($chunks as $chunkIndex => $chunk) {
                        echo '<div class="carousel-item">';
                        echo '<div class="ForComment">';
                        foreach ($chunk as $commentIndex => $comment) {
                            echo '<div class="comment" id="com' . ($commentIndex + 1) . '">';
                            echo '<p class="ComText">' . htmlspecialchars($comment) . '</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <!-- Кнопки навигации -->
            <?php if (count($comments) > 3): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php endif; ?>
        </div>
    </div>
    <!--Футер-->
    <footer>
        <nav>
            <ul>
                <li><a class="Abzach" href="#MainBlock1">Вернуться наверх</a></li>
            </ul>
        </nav>
        <nav>
            <ul>

                <li>
                    <p class="Abzach">адрес г.Кемерово</p>
                </li>
                <li>
                    <p class="Abzach">Время работы</p>
                </li>

            </ul>
        </nav>
        </nav>
        <nav>
            <ul>
                <li>
                    <a class="Abzach" href="https://e.mail.ru/compose/?to=ooo.vkus@mail.ru&subject=Вопрос%20по%20сайту&body=Здравствуйте%2C%20у%20меня%20вопрос%3A" target="_blank">ooo.vkus@mail.ru</a>
                </li>
                <li><a class="Abzach" href="PrivacyPolicy.html">Политика конфидециальности</a></li>
            </ul>
        </nav>
        <nav class="footerCentre">
            <ul>
                <li><a class="Abzach" href="PrivacyPolicy.html">© ООО "Вкус"</a></li>
            </ul>
        </nav>
    </footer>
</body>

</html>