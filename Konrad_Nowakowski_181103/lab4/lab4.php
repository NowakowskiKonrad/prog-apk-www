<?php
include_once(__DIR__ . "/includes/produkty.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include(__DIR__ . "/includes/naglowek.php");
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
    $produkty = [
        [
            'id' => 1,
            'nazwa' => 'Czysty Kod. Podręcznik dobrego stylu',
            'kategoria' => 'ksiazki',
            'stan' => 0
        ],
        [
            'id' => 2,
            'nazwa' => 'Władca Pierścieni: Drużyna Pierścienia',
            'kategoria' => 'ksiazki',
            'stan' => 1
        ],
        [
            'id' => 3,
            'nazwa' => 'Drewniana zakładka do książki',
            'kategoria' => 'akcesoria',
            'stan' => 15
        ],
        [
            'id' => 4,
            'nazwa' => 'Lampka LED do czytania',
            'kategoria' => 'akcesoria',
            'stan' => 8
        ]
    ];

    $i = 0;
    $productCount = count($produkty);

    $filtr = "";
    if (isset($_GET["kategoria"])) {
        $filtr = $_GET["kategoria"];
    }

    echo "<ul>";
    while ($i < $productCount) {
        $produkt = $produkty[$i];
        $i++;

        if (!empty($filtr) && $produkt["kategoria"] !== $filtr) {
            continue;
        }

        if ($produkt["stan"] === 0) {
            $status = "Niedostępny";
        } elseif ($produkt["stan"] <= 5) {
            $status = "Niski stan";
        } else {
            $status = "Dostępny";
        }

        switch ($produkt["kategoria"]) {
            case "ksiazki":
                $label = "Książki";
                break;
            
            case "akcesoria":
                $label = "Akcesoria";
                break;
            
            default:
                $label = "Inne";
                break;
        }

            echo "<li>";
            echo $produkt["nazwa"] . " | " . $label . " | " . $status;
            echo "</li>";
    }
    echo "</ul>";
    ?>

    <form action="lab4.php" method="get">
        <label for="kategoria">Wybierz kategorię:</label>
        <select name="kategoria" id="kategoria">
        <?php
        for ($i = 1; $i <= 5; $i++) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
        </select>
    </form>
</body>
</html>