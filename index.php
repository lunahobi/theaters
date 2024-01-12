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

    <script src="js/jquery.validate.min.js"></script>
    <script src="js/script.js"></script>
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
                        <a class="nav-link active" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php">Карта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Авторизация</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div id="carousel-1" class="carousel-item active">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1 class='text-carousel-h1 d-none d-md-block'>Добро пожаловать на сайт с театральными плошадками и коллективами РФ!</h1>
                            <h1 class='text-carousel-h1 d-block d-md-none'>Добро пожаловать!</h1>
                            <p class='text-carousel-p d-none d-md-block'>Здесь вы сможете выбрать театр поблизости либо по различным критериям, также у вас есть возможность просматировать их на карте, а еще прокладывать к ним путь</p>
                            <p class='text-carousel-p d-block d-md-none'>Здесь вы сможете выбрать театр, также у вас есть возможность просматировать их на карте, а еще прокладывать к ним путь</p>
                            <p><a class="btn btn-lg btn-carousel" href="#info">Подробнее</a></p>
                        </div>
                    </div>
                </div>
                <div id="carousel-2" class="carousel-item">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1 class="text-carousel-h1">Большой театр</h1>
                            <p class="text-carousel-p d-none d-md-block">Большой театр России всегда был и остается одним из основных символов нашего государства
                                и его культуры. Это главный национальный театр России, носитель традиций российской
                                и центр мировой музыкальной культуры, способствующий развитию театрального искусства страны</p>
                            <p class="text-carousel-p d-block d-md-none">Большой театр России всегда был и остается одним из основных символов нашего государства
                                и его культуры</p>
                            <p><a class="btn btn-lg btn-carousel" href="theater.php?id=998">Подробнее</a></p>
                        </div>
                    </div>
                </div>
                <div id="carousel-3" class="carousel-item">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1 class="text-carousel-h1">Мариинский театр</h1>
                            <p class="text-carousel-p">Театр оперы и балета в Санкт-Петербурге, один из ведущих музыкальных театров России и мира</p>
                            <p><a class="btn btn-lg btn-carousel" href="theater.php?id=121">Подробнее</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <section id='info' class="py-5">
            <div class="container mw-80">
                <div class="row justify-content-center">

                    <h2 class="text-center mb-5" style="color:#25204e">На нашем сайте можно</h2>

                    <div class="col-lg-3 col-md-4 col-10">
                        <a href="theaters.php" style="text-decoration: none;">
                            <div class="card align-items-center justify-content-center mb-3">
                                <img src="img/info.svg" class="card-img-top img-small img-fluid mt-4" alt="info">
                                <div class="card-body">
                                    <h6 class="card-title text-center">Просмотреть информацию о театральных площадках и коллективах с возможностью фильтрации</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-10">
                        <a href="map.php" style="text-decoration: none;">
                            <div class="card align-items-center justify-content-center mb-3">
                                <img src="img/map.svg" class="card-img-top img-small img-fluid mt-4" alt="map">
                                <div class="card-body">
                                    <h6 class="card-title text-center">Наглядно увидеть на карте местоположения всех театральных площадок и коллективов с возможностью перехода на более подробную информацию</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-10">
                        <a href="authorization.php" style="text-decoration: none;">
                            <div class="card align-items-center justify-content-center">
                                <img src="img/route.svg" class="card-img-top img-small img-fluid mt-4" alt="route">
                                <div class="card-body">
                                    <h6 class="card-title text-center">Добавить театры в избранное и проложить удобный маршрут от выбранного вами места до театров<br> (необходима авторизация)</h6>
                                </div>
                            </div>
                        </a>
                    </div>
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
                    <form action="" method="POST">
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
                    <?php

                    include "db.php";
                    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
                        $query = "INSERT INTO `messages` (`name`, `email`, `message`) VALUES ('{$_POST['name']}', '{$_POST['email']}', '{$_POST['message']}')";

                        $result = mysqli_query($mysql, $query);
                    }
                    ?>

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
        Для создания приложения были использованы открытые данные <a href="https://opendata.mkrf.ru/">Министерства культуры РФ</a>:<br>
        <a href="https://opendata.mkrf.ru/opendata/7705851331-theaters">Театральные площадки и коллективы</a>
    </footer>
    <!-- Bootstrap JS и зависимости -->
    <script src="js/bootstrap.bundle.min.js"></script>


</body>

</html>