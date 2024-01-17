<!DOCTYPE html>
<html lang="en">

<?php
include "mysql/Theaters_DB_Access.php";

$conn = new Theater_DB_Access;
$result = $conn->issue_query("SELECT `id`, `На карте`, `Название` FROM dataset");
// Массив для хранения координат
$coordinates = [];

while ($location = $conn->fetch_array($result)) {
    // Обработка JSON-строки
    $jsonCoordinates = json_decode($location['На карте'], true);
    $id = $location['id'];
    $name = $location['Название'];

    // Поменять координаты местами
    $coordinates[] = [
        'latitude' => $jsonCoordinates['coordinates'][1],
        'longitude' => $jsonCoordinates['coordinates'][0],
    ];
    $ides[] = $id;
    $names[] = $name;
}
?>

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
    <script src="https://api-maps.yandex.ru/2.1/?apikey=949c419f-7cb8-41ba-9e1b-e7c3f69e0086&lang=ru_RU" type="text/javascript"></script>

</head>

<body id="cart">
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
                        <a class="nav-link active" href="map.php">Карта</a>
                    </li>
                    <?php
                    session_start();
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
        <div class="container-fluid">
            <div id="map" class="mt-5 mb-5">
                <script>
                    <?php
                    if (!isset($_GET['fav'])) { ?>

                        function init() {
                            var customLatitude = <?= isset($_GET['latitude']) ? floatval($_GET['latitude']) : 63.60766003438781 ?>;
                            var customLongitude = <?= isset($_GET['longitude']) ? floatval($_GET['longitude']) : 97.76806979477598 ?>;
                            var customZoom = <?= isset($_GET['latitude']) ? 18 : 4 ?>;

                            var myMap = new ymaps.Map("map", {
                                center: [customLatitude, customLongitude],
                                zoom: customZoom,
                            });

                            var myClusterer = new ymaps.Clusterer();
                            var coordinates = <?= json_encode($coordinates, JSON_NUMERIC_CHECK) ?>;
                            var name = <?= json_encode($names) ?>;
                            var id = <?= json_encode($ides) ?>;

                            for (var i = 1; i < coordinates.length; i++) {
                                myPlacemark = new ymaps.Placemark([coordinates[i]['latitude'], coordinates[i]['longitude']], {
                                    balloonContentHeader: name[i],
                                    balloonContentFooter: '<a href="theater.php?id=' + id[i] + '">Подробнее</a>',
                                    hintContent: name[i]
                                });
                                myMap.geoObjects.add(myPlacemark);
                                myClusterer.add(myPlacemark);
                            };
                            myMap.geoObjects.add(myClusterer);

                            var searchControl = new ymaps.control.SearchControl({
                                options: {
                                    // Будет производиться поиск по топонимам и организациям.
                                    provider: 'yandex#map',
                                    noPlacemark: true
                                }
                            });
                            myMap.controls.add(searchControl);


                            // // Удаление ненужных элементов управления
                            myMap.controls.remove('geolocationControl');
                            myMap.controls.remove('trafficControl');
                            myMap.controls.remove('typeSelector');
                            myMap.controls.remove('fullscreenControl');
                            myMap.controls.remove('zoomControl');
                            myMap.controls.remove('rulerControl');
                            myMap.controls.remove('searchControl')
                        }
                        ymaps.ready(init);
                    <?php };
                    if (isset($_GET['fav'])) { ?>

                        function init() {
                            var customLatitude = <?= floatval($_GET['latitude']) ?>;
                            var customLongitude = <?= floatval($_GET['longitude']) ?>;
                            var customZoom = 15;

                            var myMap = new ymaps.Map("map", {
                                center: [customLatitude, customLongitude],
                                zoom: 15
                                // controls: ['routePanelControl']
                            });

                            const routePanel = new ymaps.control.RoutePanel({
                                options: {
                                    types: {
                                        masstransit: true,
                                        pedestrian: true,
                                        taxi: true
                                    }
                                }
                            });

                            myMap.controls.add(routePanel);

                            const options = {
                                enableHighAccuracy: true,
                                timeout: 5000,
                                maximumAge: 0
                            };

                            function success(pos) {
                                const crd = pos.coords;

                                console.log(`Latitude: ${crd.latitude}`);
                                console.log(`Longitude: ${crd.longitude}`);

                                const reverseGeocoder = ymaps.geocode([crd.latitude, crd.longitude]);
                                let locationText = null;

                                const reverseGeocoder2 = ymaps.geocode([customLatitude, customLongitude]);
                                let locationText2 = null;

                                reverseGeocoder.then(function(res) {
                                    locationText = res.geoObjects.get(0).properties.get('text');

                                    reverseGeocoder2.then(function(res) {
                                        locationText2 = res.geoObjects.get(0).properties.get('text');

                                        routePanel.routePanel.state.set({
                                            type: 'masstransit',
                                            fromEnabled: true,
                                            from: locationText,
                                            toEnabled: false,
                                            to: locationText2,
                                        });
                                    });
                                });
                            }

                            function error(err) {
                                console.warn(`ERROR(${err.code}): ${err.message}`);
                            }

                            navigator.geolocation.getCurrentPosition(success, error, options);


                            

                            myMap.controls.remove('geolocationControl');
                            myMap.controls.remove('trafficControl');
                            myMap.controls.remove('typeSelector');
                            myMap.controls.remove('fullscreenControl');
                            myMap.controls.remove('zoomControl');
                            myMap.controls.remove('rulerControl');
                            myMap.controls.remove('searchControl')
                        }

                        ymaps.ready(init);


                    <?php } ?>
                </script>
            </div>
        </div>
    </main>


    <!-- Форма обратной связи и контакты -->
    <section id='contacts' class="py-5">
        <div class="container mw-80">
            <div class="row">
                <h2 class="text-center">Контакты</h2>
                <div class="col">
                    <form action="actions/feedback.php" method="POST">
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
                            <div class="status"></div>
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
                        <a href="https://telegram.org/"><img src="img/telegram.svg" alt="telegram"></a>
                        <a href="https://whatsapp.com/"><img src="img/whatsapp.svg" alt="whatsapp"></a>
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