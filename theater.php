<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Театральные площадки и коллективы</title>
    <link rel="shortcut icon" href="img/logo.svg" type="image/x-icon" />
    <meta name="description" content="Сведения о Театральных учреждениях, занесенных в информационную систему с описанием деятельности учреждения, его расположения, контактных данных, сайта учреждения и времени его работы.">

    <!-- подключение стилей gooleFonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;1,600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top d-flex flex-wrap">
        <div class="container">
            <a class="navbar-brand d-flex me-md-auto" href="index.php">Театры России</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="theaters.php">Список</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php">Карта</a>
                    </li>
                    <?php
                    if (!isset($_SESSION)) session_start();
                    if (empty($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="autorization.php">Авторизация</a>
                        </li>
                    <?php }
                    if (!empty($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="lk.php">Личный кабинет</a>
                        </li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section id="about_theater" class="py-5">
            <div class="container mw-80">
                <div class="row justify-content-center">
                    <?php
                    include "db.php";

                    $query = mysqli_query($mysql, 'SELECT * FROM dataset WHERE id=' . $_GET['id'] . ';');
                    $result = mysqli_fetch_array($query);

                    $jsonCoordinates = json_decode($result['На карте'], true);
                    // Поменять координаты местами
                    $coordinates = [
                        'latitude' => $jsonCoordinates['coordinates'][1],
                        'longitude' => $jsonCoordinates['coordinates'][0],
                    ];
                    echo '<h2 class="text-center">' . $result['Название'] . '</h2>';


                    ?>
                    <div class="col-10 my-auto">

                        <div id="imageSlider" class="carousel slide mb-6" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Слайды будут добавлены динамически с использованием JavaScript -->
                            </div>
                            <button class="carousel-control-prev d-none" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next d-none" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <script>
                            $(document).ready(function() {
                                // Загрузка данных из базы данных
                                $.getJSON('get_images.php?id=<?php echo $_GET['id']; ?>', function(data) {

                                    var carouselInner = $('.carousel-inner');
                                    var controlPrev = $('.carousel-control-prev');
                                    var controlNext = $('.carousel-control-next');

                                    data.forEach(function(image, index) {
                                        var activeClass = index === 0 ? 'active' : '';
                                        var carouselItem = $('<div class="carousel-item ' + activeClass + '">');

                                        // Добавляем фото в качестве background-image
                                        carouselItem.css('background-image', 'url(' + image.url + ')');
                                        carouselItem.css('background-size', 'cover');

                                        carouselInner.append(carouselItem);
                                    });

                                    // Проверяем наличие фотографий
                                    if (data.length > 1) {
                                        // Показываем кнопки управления
                                        controlPrev.removeClass('d-none');
                                        controlNext.removeClass('d-none');
                                    }
                                });
                            });
                        </script>
                    </div>

                </div>
                <div class="rows text-center mt-3">
                    <div class="col">
                        <div id="theaterInfo" data-theater-id="<?= $theaterId ?>"></div>

                        <?php
                        $theaterId = $_GET['id'];
                        $query = "SELECT * FROM dataset WHERE id = ?";
                        $stmt = mysqli_prepare($mysql, $query);
                        mysqli_stmt_bind_param($stmt, "i", $theaterId);
                        mysqli_stmt_execute($stmt);
                        $res = mysqli_stmt_get_result($stmt);
                        $theater = mysqli_fetch_assoc($res);

                        $isFavorite = false;
                        if (isset($_SESSION['user']['id'])) {
                            // Замените это на ваш код проверки (например, запрос к базе данных)
                            $userId = $_SESSION['user']['id'];
                            $queryCheckFavorite = "SELECT * FROM favourites WHERE user_id = ? AND theater_id = ?";
                            $stmtCheckFavorite = mysqli_prepare($mysql, $queryCheckFavorite);
                            mysqli_stmt_bind_param($stmtCheckFavorite, "ii", $userId, $theaterId);
                            mysqli_stmt_execute($stmtCheckFavorite);
                            $resultCheckFavorite = mysqli_stmt_get_result($stmtCheckFavorite);
                            $isFavorite = mysqli_num_rows($resultCheckFavorite) > 0;
                        }

                        // Вывод кнопок в зависимости от авторизации и наличия в избранном
                        if (isset($_SESSION['user']['id'])) {
                            if ($isFavorite) {
                                echo '<button class="btn btn-danger" onclick="removeFromFavorites(' . $theaterId . ')">Удалить из избранного</button>';
                            } else {
                                echo '<button class="btn btn-success" onclick="addToFavorites(' . $theaterId . ')">Добавить в избранное</button>';
                            }
                        }
                        ?>

                        <script>
                            var theaterId = document.getElementById('theaterInfo').dataset.theaterId;

                            function addToFavorites(theaterId) {
                                $.post("actions/add_to_favourites.php", {
                                    theaterId: theaterId
                                }, function(data) {
                                    alert(data);
                                    window.location.reload();
                                });
                            }

                            function removeFromFavorites(theaterId) {
                                $.post("actions/remove_from_favourites.php", {
                                    theaterId: theaterId
                                }, function(data) {
                                    alert(data);
                                    window.location.reload();
                                });
                            }
                        </script>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <a href="map.php?latitude=<?= $coordinates['latitude'] ?>&longitude=<?= $coordinates['longitude'] ?>">Показать на карте</a>
                </div>
                <div class="row mt-3 text-center">
                    <a href="map.php?latitude=<?= $coordinates['latitude'] ?>&longitude=<?= $coordinates['longitude'] ?>&fav=1">Построить маршрут</a>
                </div>
                <div class="row icons">

                    <div class="col py-3 tel-block">
                        <div class="hstack gap-2">
                            <img src="img/telephone-black.svg" alt="telephone">
                            <div class="tel">
                                <?php
                                // Ваш JSON-строка (здесь я предполагаю, что она хранится в переменной $jsonString)
                                $jsonString = $result['Номер'];

                                // Преобразование JSON в ассоциативный массив
                                $data = json_decode($jsonString, true);

                                // Проверка наличия данных
                                if ($data) {
                                    // Вывод данных
                                    foreach ($data as $index => $item) {
                                        $phoneNumber = $item['value'];
                                        $comment = isset($item['comment']) ? $item['comment'] : null;

                                        // Вывод иконки телефона и номера с комментарием
                                        if (!empty($comment)) {
                                            echo '+' . $phoneNumber . ' - ' . $comment;
                                        } else {
                                            echo '+' . $phoneNumber;
                                        }

                                        // Проверка, является ли текущий элемент последним в массиве
                                        if ($index < count($data) - 1) {
                                            // Если не последний, добавить переход на новую строку
                                            echo '<br>';
                                        }
                                    }
                                } else {
                                    // Вывод сообщения, если JSON пуст
                                    echo '<p>Нет данных</p>';
                                    // Скрываем блок, если нет данных
                                    echo '<style>.tel-block { display: none; }</style>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>




                    <?php if ($result['Адрес электронной почты'] !== null) : ?>
                        <div class="col py-3">
                            <div class="hstack gap-2">
                                <img src="img/email-black.svg" alt="e-mail">
                                <?= $result['Адрес электронной почты'] ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result['Адрес'] !== null) : ?>

                        <div class="col py-3">
                            <div class="hstack gap-2">
                                <img src="img/adress.svg" alt="adress">
                                <?= $result['Адрес'] ?>
                                <br><br>
                                <?= $result['Примечание'] ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Определение функции allValuesNull
                    function allValuesNull($array)
                    {
                        return count(array_filter($array, function ($value) {
                            return $value !== null;
                        })) === 0;
                    }

                    $query_hours = "SELECT ПН, ВТ, СР, ЧТ, ПТ, СБ, ВС FROM dataset WHERE id = ?;";
                    $stmt = mysqli_prepare($mysql, $query_hours);

                    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);

                    $result_hours = mysqli_stmt_get_result($stmt);

                    // Проверка на успешность выполнения запроса
                    if ($result_hours) {
                        $row = mysqli_fetch_assoc($result_hours);

                        // Список дней недели
                        $daysOfWeek = ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"];

                        // Проверка наличия данных
                        if (!empty($row) && !allValuesNull($row)) {
                            echo '<div class="col py-3">';
                            echo '<div class="hstack gap-2">';
                            echo '<img src="img/clock.svg" alt="clock">';
                            echo '<div>';

                            $workingHoursString = '';

                            foreach ($daysOfWeek as $day) {
                                // Проверяем, есть ли значение для текущего дня
                                if ($row[$day] !== null) {
                                    $dayData = json_decode($row[$day], true);

                                    $startTime = isset($dayData['from']) ? substr($dayData['from'], 0, 5) : null;
                                    $endTime = isset($dayData['to']) ? substr($dayData['to'], 0, 5) : null;

                                    if (!empty($workingHoursString)) {
                                        $workingHoursString .= '<br>';
                                    }

                                    $workingHoursString .= $day . ': ' . $startTime . ' - ' . $endTime;
                                } else {
                                    // Если значение равно null, считаем, что это выходной
                                    if (!empty($workingHoursString)) {
                                        $workingHoursString .= '<br>';
                                    }

                                    $workingHoursString .= $day . ': выходной';
                                }
                            }

                            // Вывод строки с рабочим временем
                            echo $workingHoursString;

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        // Освобождение ресурсов
                        mysqli_free_result($result_hours);
                    } else {
                        // Вывод ошибки выполнения запроса
                        echo "Ошибка выполнения запроса: " . mysqli_error($mysql);
                    }

                    // Закрытие запроса
                    mysqli_stmt_close($stmt);

                    // Закрытие соединения
                    mysqli_close($mysql);
                    ?>


                    <?php if ($result['Адрес сайта'] !== null) : ?>
                        <div class="col py-3">
                            <div class="hstack gap-2">
                                <img src="img/site.svg" alt="site">
                                <a href="<?= $result['Адрес сайта'] ?>" target="_blank"><?= $result['Адрес сайта'] ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-3">
                    <?php echo $result['Описание'] ?>
                </div>


            </div>

        </section>

    </main>

    <!-- Форма обратной связи и контакты -->
    <section id='contacts' class="py-5">
        <div class="container mw-80">
            <div class="row">
                <h2 class="text-center">Контакты</h2>
                <div class="col">
                    <form action="feedback.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Сообщение</label>
                            <textarea class="form-control w-100" id="message" rows="4" cols="30" name="message" required></textarea>
                        </div>
                        <div class="text-center">
                            <button id='btn-contacts' type="submit" class="btn">Отправить</button>
                        </div>
                    </form>

                </div>
                <div class="col py-3">
                    <div class="hstack gap-2 mb-1">
                        <img src="img/email.svg" alt="e-mail">
                        muradyan.lusine.05@mail.ru
                    </div>

                    <div class="hstack gap-2 mb-2">
                        <img src="img/telephone.svg" alt="telephone">
                        +7 (967) 382-30-10
                    </div>

                    <div class="hstack gap-2 ">
                        <a href="https://telegram.org/" target="_blank"><img src="img/telegram.svg" alt="telegram"></a>
                        <a href="https://whatsapp.com/" target="_blank"><img src="img/whatsapp.svg" alt="whatsapp"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-1">
        Copyright &copy; <script>
            document.write(new Date().getFullYear());
        </script> All rights reserved.<br>
        Для создания приложения были использованы открытые данные <a href="https://opendata.mkrf.ru/" target="_blank">Министерства культуры РФ</a>:<br>
        <a href="https://opendata.mkrf.ru/opendata/7705851331-theaters" target="_blank">Театральные площадки и коллективы</a>
    </footer>
    <!-- Bootstrap JS и зависимости -->
    <script src="js/bootstrap.bundle.min.js"></script>


</body>

</html>