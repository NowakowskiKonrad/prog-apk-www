<?php
include_once(__DIR__ . "/includes/produkty.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include(__DIR__ . "/includes/naglowek.php")
    ?>
    <title>
        <?php
        $title = "Katalog PHP";
        $group = "ISI 2";
        echo $title . " | " . $group;
        ?>
    </title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="index.html">Strona główna</a>
    <?php
    echo $title . " | " . $group;
    ?>
</body>
</html>