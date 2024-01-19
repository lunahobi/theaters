<!DOCTYPE html>
<html lang="en">

<?php
require_once __DIR__ . '/helpers.php';
checkGuest();
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
                        <a class="nav-link" href="possibilities.php">Возможности</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="theaters.php">Поиск</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php">Карта</a>
                    </li>
                    <?php
                        if (!isset($_SESSION)) session_start();
                        if(empty($_SESSION['user'])){?>
                            <li class="nav-item">
                                <a class="nav-link" href="autorization.php">Авторизация</a>
                            </li>   
                        <?php }
                        if(!empty($_SESSION['user'])){?>
                            <li class="nav-item">
                                <a class="nav-link" href="lk.php">Личный кабинет</a>
                            </li>   
                        <?php }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <main id="reg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <h3 class="mt-5 mb-3 text-center">Регистрация</h3>
                    <div class="form mb-5">
                        <form action="actions/reg.php" method="post" style="width: 22rem;">
                            <div class="form-outline mb-4">
                                <input type="text" id="fio" name='fio' class="form-control" placeholder="Имя" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" <?php echo validationErrorAttr('fio') ?> value=<?php echo old('fio') ?>>
                                <?php if (hasValidationError('fio')) : ?>
                                    <small><?php echo validationErrorMessage('fio'); ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" id="e-mail" name='e-mail' class="form-control" placeholder="E-mail" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" <?php echo validationErrorAttr('e-mail') ?> value=<?php echo old('e-mail') ?>>
                                <?php if (hasValidationError('e-mail')) : ?>
                                    <small><?php echo validationErrorMessage('e-mail'); ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="row d-flex">
                                <div class="col">
                                    <div class="form-outline mb-4">
                                        <input type="password" id='pass' name='pass' class="form-control" placeholder="Пароль" autocomplete="off" <?php echo validationErrorAttr('pass') ?> />
                                        <?php if (hasValidationError('pass')) : ?>
                                            <small><?php echo validationErrorMessage('pass'); ?></small>
                                        <?php endif; ?>
                                    </div>

                                </div>

                                <div class="col">
                                    <div class="form-outline mb-4">
                                        <input type="password" id='pass_conf' name='pass_conf' class="form-control" placeholder="Подтверждение" />
                                    </div>
                                </div>
                            </div>


                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4 btn-auth">Зарегистрироваться</button>

                            <!-- Register buttons -->
                            <div class="text-center">
                                <p>У вас уже есть аккаунт? <a href="autorization.php">Войти</a></p>
                            </div>
                        </form>
                        <?php clearValidation() ?>
                    </div>

                </div>
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
                            <label for="email" class="form-label">E-mail</label>
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