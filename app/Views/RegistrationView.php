<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <script src="./scripts/jquery.js"></script>
    <script src="./scripts/registration.js"></script>
    <link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include __VIEW_PATH__ . "/templates/header.php";?>
<main>

    <?php if (isset($_SESSION["messageError"])) {
        echo $_SESSION["messageError"];
        unset($_SESSION["messageError"]);
    }?>

    <form method="post" id="reg" action="">
        Зарегистрироваться
        <input type="text" name="mail" placeholder="example@example.example" />
        <div class="password">
            <input id="password_1" type="password" name="password_1" placeholder="password" />
            <i id="eye_1" class="fa fa-eye password-control"></i>
        </div>
        <div class="password">
            <input id="password_2" type="password" name="password_2" placeholder="repeat password" />
            <i id="eye_2" class="fa fa-eye password-control"></i>
        </div>
        <div class="message"></div>
        <button class="button" onclick="sendJson()">Регистрация</button>
        <div>
            <a href="/login" class="href">Есть аккаунт?</a>
        </div>
    </form>

    <!--script>
        function sendJson() {
            let form = document.getElementById("reg");
            alert(form.action);
            alert("script");
            /*let xhr = new XMLHttpRequest();
            url = "http://127.0.0.1:8080/registration";
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                alert("Alright");
            }*/
        }
    </script-->

</main>

<?php include __VIEW_PATH__ . "/templates/footer.php";?>

</body>
</html>
