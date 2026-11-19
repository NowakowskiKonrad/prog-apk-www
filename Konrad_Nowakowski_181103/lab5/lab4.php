<?php
session_start();

require_once(__DIR__ . "/includes/produkty.php");

const MAX_COUNT = 5;

$allowedCategories = ["wszystkie", "ksiazki", "akcesoria"];

$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function numberFromForm(array $source, string $key): ?int
{
    if (!isset($source[$key]) || !is_string($source[$key])) {
        return null;
    }

    $output = filter_var($source[$key], FILTER_VALIDATE_INT);

    return $output === false ? null : $output;
}

function findProduct(array $products, int $id): ?array
{
    foreach ($products as $product) {
        if ($product["id"] === $id) {
            return $product;
        }
    }

    return null;
}

$filter = "wszystkie";
$errors = [];
$sent = ["produkt" => "", "ilosc" => "1"];
$message = "";

if ($method === "POST") {
    $id = numberFromForm($_POST, "produkt");
    $amount = numberFromForm($_POST, "ilosc");

    if ($id === null) {
        $errors["produkt"] = "Wybierz produkt z listy.";
    } elseif (findProduct($produkty, $id) === null) {
        $errors["produkt"] = "Nie ma produktu o takim id.";
    }

    if ($amount === null) {
        $errors["ilosc"] = "Podaj ilość jako liczbę całkowitą od 1 do " . MAX_COUNT . ".";
    } elseif ($amount < 1 || $amount > MAX_COUNT) {
        $errors["ilosc"] = "Ilość musi mieścić się w zakresie 1-" . MAX_COUNT . ".";
    }

    // Stan magazynowy sprawdzamy dopiero, gdy oba pola są poprawne.
    if ($errors === []) {
        $selectedProduct = findProduct($produkty, $id);
        if ($amount > $selectedProduct["stan"]) {
            $errors["ilosc"] = "Produkt „" . $selectedProduct["nazwa"] . "” ma w magazynie tylko "
                . $selectedProduct["stan"] . " szt.";
        }
    }

    if ($errors === []) {
        $_SESSION["ostatni_wybor"] = ["id" => $id, "ilosc" => $amount];

        // 303 przed jakimkolwiek HTML -> przeglądarka zrobi GET.
        header("Location: lab4.php", true, 303);
        exit;
    }

    http_response_code(400);

    $sent["produkt"] = is_string($_POST["produkt"] ?? null) ? $_POST["produkt"] : "";
    $sent["ilosc"]   = is_string($_POST["ilosc"] ?? null) ? $_POST["ilosc"] : "";
} else {
    if (array_key_exists("kategoria", $_GET)) {
        $kategoria = $_GET["kategoria"];

        if (is_string($kategoria) && in_array($kategoria, $allowedCategories, true)) {
            $filter = $kategoria;
        } else {
            $message = "Nieznana kategoria.";
        }
    }
}

$lastChoice = $_SESSION["ostatni_wybor"] ?? null;
$sessionProduct = null;

if (is_array($lastChoice) && isset($lastChoice["id"], $lastChoice["ilosc"])) {
    $sessionProduct = findProduct($produkty, (int) $lastChoice["id"]);
}

$title = "Katalog PHP";
$group = "ISI 2";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include(__DIR__ . "/includes/naglowek.php"); ?>
    <title><?php echo e($title . " | " . $group); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <a href="index.php">Strona główna</a>
    </nav>
    <main>
        <h1><?php echo e($title); ?></h1>
        <p>Grupa: <?php echo e($group); ?></p>

        <section aria-labelledby="naglowek-wybor">
            <h2 id="naglowek-wybor">Ostatni zapisany wybór</h2>
            <?php if ($sessionProduct !== null): ?>
                <p>
                    <?php echo e($sessionProduct["nazwa"]); ?>
                    &times; <?php echo (int) $lastChoice["ilosc"]; ?> szt.
                </p>
            <?php else: ?>
                <p>Nie zapisano żadnego wyboru.</p>
            <?php endif; ?>
        </section>

        <section aria-labelledby="naglowek-filtr">
            <h2 id="naglowek-filtr">Filtr katalogu (GET)</h2>
            <form action="lab4.php" method="get">
                <label for="kategoria">Kategoria:</label>
                <select name="kategoria" id="kategoria" aria-describedby="info-kategoria">
                    <option value="wszystkie" <?php if ($filter === "wszystkie") { echo "selected"; } ?>>Wszystkie</option>
                    <option value="ksiazki" <?php if ($filter === "ksiazki") { echo "selected"; } ?>>Książki</option>
                    <option value="akcesoria" <?php if ($filter === "akcesoria") { echo "selected"; } ?>>Akcesoria</option>
                </select>
                <button type="submit">Filtruj</button>
                <?php if ($message !== ""): ?>
                    <p id="info-kategoria" class="komunikat" role="alert"><?php echo e($message); ?></p>
                <?php endif; ?>
            </form>
        </section>

        <section aria-labelledby="naglowek-katalog">
            <h2 id="naglowek-katalog">Katalog</h2>
            <ul class="katalog">
                <?php
                $i = 0;
                $elements = count($produkty);
                $visible = 0;

                while ($i < $elements):
                    $produkt = $produkty[$i];
                    $i++;

                    if ($filter !== "wszystkie" && $produkt["kategoria"] !== $filter) {
                        continue;
                    }

                    $visible++;

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
                ?>
                <li class="produkt">
                    <span class="nazwa"><?php echo e($produkt["nazwa"]); ?></span>
                    <span class="kategoria"><?php echo e($label); ?></span>
                    <span class="stan">Stan: <?php echo (int) $produkt["stan"]; ?></span>
                    <span class="status"><?php echo e($status); ?></span>
                </li>
                <?php endwhile; ?>

                <?php if ($visible === 0): ?>
                    <li>Brak elementów w wybranej kategorii.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section aria-labelledby="naglowek-formularz">
            <h2 id="naglowek-formularz">Zapisz wybór (POST)</h2>
            <form action="lab4.php" method="post">
                <p>
                    <label for="produkt">Produkt:</label>
                    <select name="produkt" id="produkt" aria-describedby="blad-produkt">
                        <option value="">-- wybierz produkt --</option>
                        <?php foreach ($produkty as $produkt): ?>
                            <option value="<?php echo (int) $produkt["id"]; ?>"
                                <?php if ($sent['produkt'] === (string) $produkt['id']) { echo 'selected'; } ?>>
                                <?php echo e($produkt['nazwa']); ?> (stan: <?php echo (int) $produkt['stan']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['produkt'])): ?>
                        <span id="blad-produkt" class="blad" role="alert"><?php echo e($errors['produkt']); ?></span>
                    <?php endif; ?>
                </p>
                <p>
                    <label for="ilosc">Ilość (1-<?php echo MAX_COUNT; ?>):</label>
                    <select name="ilosc" id="ilosc" aria-describedby="blad-ilosc">
                        <?php for ($n = 1; $n <= MAX_COUNT; $n++): ?>
                            <option value="<?php echo $n; ?>"
                                <?php if ($sent['ilosc'] === (string) $n) { echo 'selected'; } ?>>
                                <?php echo $n; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                    <?php if (isset($errors['ilosc'])): ?>
                        <span id="blad-ilosc" class="blad" role="alert"><?php echo e($errors['ilosc']); ?></span>
                    <?php endif; ?>
                </p>

                <p><button type="submit">Zapisz wybór</button></p>
            </form>
        </section>
    </main>
</body>
</html>