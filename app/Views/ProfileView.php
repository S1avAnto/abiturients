<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/profile.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <script src="./scripts/jquery.js"></script>
    <script src="./scripts/profile.js"></script>
    <link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<style>
    #username {
        position: relative;
        width: 300px;
        height: 100px;
        transform: none;
        top: 0;
        left: 0;
        padding: 0;
        border: none;
    }
</style>
<body>
<?php
include_once __VIEW_PATH__ . "/templates/header.php";
?>
<main>
    <?php if (isset($_SESSION["messageError"])) {
        echo $_SESSION["messageError"];
    }?>
    <div id="profile">

        <div class="profile__fraction" style="word-break: break-word;">
            <img src="<?= App\Filer::dataUri(__UPLOADS_PATH__ . $this->params["profileImgUrl"], 'image/jpeg'); ?>" alt="" id="profile__userImg">
            <?php if($this->params["userFullName"] !== null) {
                echo $this->params["userFullName"];
            }
            else { ?>
                <form method="post" action="/profile/changeUserFullname" id="username">
                    <input name="userFullName" placeholder="Введите своё ФИО">
                    <button type="submit" class="button">Принять</button>
                </form>
            <?php }
            ?>
        </div>

        <div class="profile__fraction">

            <div>Ваше место по согласием:</div>

            <div class="profile__fraction__requests">
                Программная инженерия: 55 из 100
            </div>

            <div class="profile__fraction__requests">
                Программная инженерия: 55 из 100
            </div>

            <div class="profile__fraction__requests">
                Программная инженерия: 55 из 100
            </div>

            <div class="button" id="requests__add__button">Добавить заявку</div>
            <div class="button" id="requests__add__button">Добавить согласие</div>
        </div>

        <div id="profile__fraction__links">
            <div class="button">Добавить документы</div>
            <a href="/logout" class="button">Выйти из аккаунта</a>
        </div>

        <div class="profile__fraction">

            <div style="margin-bottom: 30px;">Предметы</div>
            <?php if (isset($this->params["userEgeResults"]) && !empty($this->params["userEgeResults"])) {
                foreach ($this->params["userEgeResults"] as $egeResult) {?>
                    <div class="profile__fraction__subject">
                        <div class="subject__name"><?= $egeResult["Name"] . ": " . $egeResult["Points"] ?></div>
                    </div>
                <?php }
            }
            else {?>
                <div class="profile__fraction__subject">
                    <div class="subject__name">Здесь будут отображаться ваши результаты ЕГЭ</div>
                </div>
            <?php }
            ?>

            <div class="button" id="ege_results__add__button">Добавить предмет</div>

        </div>

    </div>

    <form id="requests" method="post" action="/profile/addRequest" class="is-non-active">

        <div class="closeModal" id="requests__close__button"></div>

        <div style="text-align:center;">Участие в конкурсе по направлению:</div>


        <input type="text" id="direction" list="directions" />
        <datalist id="directions">
            <?php if (isset($this->params["allSpecialties"])) {
                foreach ($this->params["allSpecialties"] as $specialty) { ?>
                    <option value="<?= $specialty["Name_speciality"] ?>"></option>
                <?php }
            }
            ?>
        </datalist>

        <button class="button">Принять участие</button>

    </form>

    <form id="ege_results" method="post" action="/profile/addEgeResults" class="is-non-active">

        <div class="closeModal" id="ege_results__close__button"></div>

        <div style="text-align:center;">Добавить результаты ЕГЭ по предмету:</div>

        <input type="text" name="subject" list="subjects" />
        Количество баллов:
        <input type="text" name="subject_result" />
        <datalist id="subjects">
            <?php if (isset($this->params["allAcademicSubjects"])) {
                foreach ($this->params["allAcademicSubjects"] as $academicSubject) { var_dump($academicSubject);?>
                    <option value="<?= $academicSubject["Name"] ?>"></option>
                <?php }
            }
            ?>
        </datalist>

        <button type="submit" class="button">Принять участие</button>

    </form>

    <form id="documents" method="post" action="/profile/addDox" class="is-non-active">
        <div class="closeModal" id="documents__close__button"></div>
    </form>

</main>

<?php include_once __VIEW_PATH__ . "/templates/footer.php";?>

</body>
</html>
