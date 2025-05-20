<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- сыллки подключения стилей -->
    <link rel="stylesheet" href="css/CatalogStyle.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/Js.js"></script>


    <title>Вишневый сад | Каталог</title>
</head>

<body>
    <!--Панель навигации-->
    <header class="IndexHeader">
        <nav class="IndexHeadernav">
            <ul class="IndexHeaderul">
                <li><a class="IndexHeadera" href="index.html#MainBlock1"><img id="LogoIMG"
                            src="css/Pictures/лого.svg"></a></li>
                <li><a class="Abzach" class="IndexHeadera" id="nav" href="index.html#MainAboutCompany">О Компании</a></li>
                <li><a class="Abzach" class="IndexHeadera" id="nav" href="map.html">Местоположение</a></li>
                <li><a class="Abzach" class="IndexHeadera" id="nav" href="Catalog.html">Каталог</a></li>
                <li class="IndexHeadera"><a href="ДляВзаимодействия/Autoris.html"><img id="profileIMG" href=""
                            src="css/Pictures/profile-user.svg"></a></li>
                <div class="burger" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <nav class="NavigateBlock" id="NavigateBlock">
                    <a class="Abzach" class="IndexHeadera" href="#MainAboutCompany">О Компании</a>
                    <a class="Abzach" class="IndexHeadera" href="map.html">Местоположение</a>
                    <a class="Abzach" class="IndexHeadera" href="Catalog.html">Каталог</a>
                </nav>
            </ul>
        </nav>
    </header>

    <!-- Место для каталога -->
    <?
    // Подключение к бд
    require_once 'connect.php';
    // Запрос для получения выборки товаров из бд
    $sql = "SELECT ID_Dish , Name, IMG, ID_category  FROM Dishes";
    $result = $conn->query($sql);
    // Получениие всех продуктов из бд в массив
    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }


    // Получаем категории из БД
    $sql_categories = "SELECT DISTINCT ID_Category, Name FROM Category ORDER BY Name";
    $result_categories = $conn->query($sql_categories);
    // Получениие всех категорий из бд в массив
    $categories = [];
    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    $conn->close();
    ?>
    <!-- Сам каталог -->
    <div class="BodyForCatalog">
        <nav class="Catalog-Nav">
            <ul>
                <li><a href="#all">Все товары</a></li>
                <!-- Вызов элементов из массива с категориями и вставка их в определенный формат -->
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="#<?php echo htmlspecialchars($category['ID_Category']); ?>">
                            <?php echo htmlspecialchars($category['Name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <!-- Конец вызова -->
            </ul>
        </nav>
        <div class="Catalog">
            <div class="Catalog-Container">
                <!-- Вызов элементов из массива с продукцией и вставка их в определенный формат -->
                <?php foreach ($products as $product): ?>
                    <div class="Catalog-Card" id="<?php echo htmlspecialchars($product['ID_category']); ?>">
                        <img src="<?php echo htmlspecialchars($product['IMG']); ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>">
                        <p><?php echo htmlspecialchars($product['Name']); ?></p>
                    </div>
                <?php endforeach; ?>
                <!-- Конец вызова -->
            </div>

        </div>
    </div>




    <!--Футер-->
    <footer>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Подсветка активной категории навигации
            const navLinks = document.querySelectorAll('.Catalog-Nav a');


            // Обработчик для кликов кнопок навигации
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });


        });
    </script>
</body>

</html>