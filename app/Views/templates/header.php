<header class="container">
    <a href="/" class="href">Списки поступающих</a>
    <?php use App\Filer;

    if (!$this->params["auth"]) {?>
        <div id="sign">
            <a href="/login" class="href">Вход</a>
        </div>
    <?php }
        else {
            ?>
            <div id="header__profile">
                <?php
                if (strcmp($this->params["role"], __ADMIN__) === 1) {?>
                    <a href="/statistic" class="href">Админка</a>
                    <?php
                }?>
                <a href="/profile" class="href">
                    <img src="<?= Filer::dataUri(__UPLOADS_PATH__ . $this->params["profileImgUrl"], 'image/jpeg');  ?>" alt="ава">
                    Профиль
                </a>
            </div>
    <?php    }
    ?>

</header>

<!--header class="container">
    <a href="/" class="href">Списки поступающих</a>
    <div id="sign">
        <a href="/login" class="href">Вход</a>
    </div>
    <div id="header__profile">
    <a href="/profile/<= $this->params["idUser"] ?>" class="href">
        <a href="/profile" class="href">
            <img src="./img/admin.jpg" alt="аватар">
            Profile
        </a>
    </div>
</header-->