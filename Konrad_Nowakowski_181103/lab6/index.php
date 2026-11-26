<?php
declare(strict_types=1);

$projectVersion = 'v1.5';

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$activeAlias = null;
$requestedAlias = null;
$pageData = null;
$menuItems = [];
$returnCode = 200;
$siteTitle = 'Strona główna';

if (!isset($_GET['idp']) || $_GET['idp'] === '') {
    $requestedAlias = 'glowna';
} elseif (is_string($_GET['idp']) && preg_match('/^[a-z0-9-]{1,20}$/',$_GET['idp']) === 1) {
    $requestedAlias = $_GET['idp'];
} else {
    $returnCode = 404;
    $siteTitle = 'Nie znaleziono strony (404)';
}

try {
    require_once __DIR__ . '/cfg.php';
    require_once __DIR__ . '/showpage.php';

    $menuStmt = $pdo->prepare( 'SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id ASC' );
    $menuStmt->execute();
    $menuItems = $menuStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($returnCode === 200 && $requestedAlias !== null) {

        $pageData = PokazPodstrone($pdo,$requestedAlias);
        if ($pageData !== null) {
            $activeAlias = $requestedAlias;
            $siteTitle = (string)$pageData['page_title'];
        } else {
            $returnCode = 404;
            $siteTitle = 'Nie znaleziono strony (404)'; }
    }
} catch (Throwable $exception) {
    error_log('[CMS DB Error] ' . $exception->getMessage());
    $returnCode = 500;
    $activeAlias = null;
    $pageData = null;
    $menuItems = [];
    $siteTitle = 'Błąd serwera (500)';
}

http_response_code($returnCode);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title><?php echo e($siteTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="vendor/jquery-4.0.0.min.js" defer></script>
    <script src="js/main.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>
<body>
    <nav class="main-nav">
        <?php if ($menuItems !== []): ?>
            <?php foreach ($menuItems as $item): ?>
                <?php
                $itemAlias = (string) $item['alias'];
                $itemTitle = (string) $item['page_title'];
                $href = $itemAlias === 'glowna' ? 'index.php' : 'index.php?idp=' . urlencode($itemAlias);
                ?>
                <a href="<?php echo e($href); ?>"<?php if ($activeAlias === $itemAlias) { echo ' aria-current="page"'; } ?>>
                    <?php echo e($itemTitle); ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <a href="index.php">Strona główna</a>
        <?php endif; ?>
        <a href="lab4.php">Katalog PHP</a>
        <button type="button" id="dark-mode-toggle" aria-pressed="false">Tryb czarny</button>
    </nav>
    <header></header>
    <main class="container">
        <?php if ($returnCode === 200 && $pageData !== null): ?>
            <?php echo $pageData['page_content']; ?>
        <?php elseif ($returnCode === 404): ?>
            <section>
                <h1>404 - Nie znaleziono podstrony</h1>
                <p>Podana podstrona nie istnieje, jest szkicem lub adres jest nieprawidłowy.</p>
                <p><a href="index.php">Wróć na stronę główną</a></p>
            </section>
        <?php else: ?>
            <section>
                <h1>500 - Błąd wewnętrzny serwera</h1>
                <p>Wystąpił problem podczas pobierania zawartości strony. Spróbuj ponownie później.</p>
                <p><a href="index.php">Wróć na stronę główną</a></p>
            </section>
        <?php endif; ?>
    </main>
    <footer>
        <p>
            <?php
            $monitor_shop = 'sklep z monitorami';
            echo e($monitor_shop . ' ' .$projectVersion);
            ?>
        </p>
    </footer>
</body>
</html>