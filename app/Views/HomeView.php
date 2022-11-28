<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
    <link rel="stylesheet" type="text/css" href="./css/tables.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
</head>
<body>
<?php include __VIEW_PATH__ . "/templates/header.php";?>
<main>

    <!--?= $this->params[""] ?-->
    <?php foreach ($this->params["requestsBySpecialties"] as $speciality => $requests) {?>
        <div class="section">
            <div class="section__direction"><?= $speciality ?></div>
            <table class="section__table">
                <tr class="section__table__header">
                    <th>№</th>
                    <th>ФИО</th>
                    <th>Сумма баллов</th>
                    <th>Согласие</th>
                </tr>
                <?php foreach ($requests as $request) {
                    if (!empty($request["Full_name"]) && !empty($request["Scores"]) && !empty($request["Consent"])) {?>
                        <tr class="section__table__item">
                            <td><?= $request["Position"] ?></td>
                            <td><?= $request["Full_name"] ?></td>
                            <td><?= $request["Scores"] ?></td>
                            <td><?= $request["Consent"] ?></td>
                        </tr> <?php
                    }
                    ?>

                    <?php
                }?>
            </table>
        </div><?php
    }?>


</main>

<?php include __VIEW_PATH__ . "/templates/footer.php";?>

</body>
</html>
