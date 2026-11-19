<?php
$views = [
    "glowna" => [
        "title" => "Strona główna",
        "file"  => "html/glowna.html",
    ],
    "produkt" => [
        "title" => "Produkt",
        "file"  => "html/produkt.html",
    ],
    "kontakt" => [
        "title" => "Kontakt",
        "file"  => "html/kontakt.html",
    ],
    "filmy" => [
        "title" => "Filmy",
        "file"  => "html/filmy.html",
    ],
];

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$activeKey = null;
$viewFile = null;
$returnCode = 200;

if (!isset($_GET["idp"]) || $_GET["idp"] === "") {
    $activeKey = "glowna";
} elseif (is_string($_GET["idp"]) && array_key_exists($_GET["idp"], $views)) {
    $activeKey =$_GET["idp"];
} else {
    $returnCode = 404;
}

if ($returnCode === 200) {$path = __DIR__ . "/" . $views[$activeKey]["file"];

    if (is_file($path) && is_readable($path)) {
        $viewFile =$path;
        $siteTitle = $views[$activeKey]["title"];
    } else {
        $returnCode = 500;
        $activeKey = null;
        $siteTitle = "Błąd serwera (500)";
    }
} else {
    $siteTitle = "Nie znaleziono strony (404)";
}

http_response_code($returnCode);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title><?php echo e($siteTitle) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="vendor/jquery-4.0.0.min.js" defer></script>
    <script src="js/main.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>
<body>
    <nav class="main-nav">
        <?php foreach ($views as $key =>$data): ?>
            <a href="<?php echo $key === "glowna" ? "index.php" : "index.php?idp=" . urlencode($key); ?>"<?php if ($activeKey === $key) { echo ' aria-current="page"'; } ?>>
                <?php echo e($data["title"]); ?>
            </a>
        <?php endforeach; ?>
        <a href="lab4.php">Katalog PHP</a>
        <button type="button" id="dark-mode-toggle" aria-pressed="false">Tryb czarny</button>
    </nav>    
    <header></header>
    <main class="container">
    <?php if ($returnCode === 200 && $viewFile !== null): ?>
            <?php include $viewFile; ?>
        <?php elseif ($returnCode === 404): ?>
            <section>
                <h1>404 - Nie znaleziono podstrony</h1>
                <p>Podana podstrona nie istnieje lub adres jest nieprawidłowy.</p>
                <p><a href="index.php">Wróć na stronę główną</a></p>
            </section>
        <?php else: ?>
            <section>
                <h1>500 - Błąd wewnętrzny serwera</h1>
                <p>Nie udało się wczytać zawartości wybranej podstrony.</p>
                <p><a href="index.php">Wróć na stronę główną</a></p>
            </section>
        <?php endif; ?>
        </main>
        <footer>
            <?php
            $monitor_shop = "sklep z monitorami";
            echo $monitor_shop;
            ?>
    </footer>
</body>
</html>