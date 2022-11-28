<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/checkbox.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <script src="./scripts/jquery.js"></script>
    <script src="./scripts/login.js"></script>
    <link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include __VIEW_PATH__ . "/templates/header.php";?>
<main>

    <?php if (isset($_SESSION["messageError"])) {
        echo $_SESSION["messageError"];
        unset($_SESSION["messageError"]);
    }?>

    <form method="post">
        Войти
        <input type="text" name="mail" placeholder="example@example.example" />

        <div class="password">
            <input id="password" type="password" name="password" placeholder="password" />
            <i id="eye" class="fa fa-eye password-control"></i>
        </div>

        <button class="button">Вход</button>

        <div>
            <input id="inSystem" class="custom-checkbox" name="inSystem" type="checkbox">
            <label for="inSystem">Оставаться в системе</label>
        </div>
        <div>
            <a href="/resetpass" class="href">Забыли пароль?</a> &#149;
            <a href="/registration" class="href">Зарегистрироваться</a>
        </div>
    </form>

</main>

<footer class="container">
    To contact with me: workslavanto@gmail.com
</footer>
</body>
</html>
