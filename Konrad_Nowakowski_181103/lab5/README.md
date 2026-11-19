## Lab 5

### Uruchamianie serwera php

Linux:
```sh
php --server localhost:8000 --docroot .

```

Windows:

```
Należy wykorzystać XAMPP (katalog htdocs/lab5, adres http://localhost/lab5/index.php)

```

## Adresy aplikacji

* `index.php` oraz `index.php?idp=glowna` – strona główna we wspólnym szablonie
* `index.php?idp=produkt` – podstrona szczegółów produktu
* `index.php?idp=kontakt` – podstrona z formularzem kontaktowym
* `index.php?idp=filmy` – podstrona z osadzonymi materiałami wideo
* `lab4.php` – katalog produktów z filtrowaniem GET, zapisem POST i sesją
* `status.php` – endpoint zwracający odpowiedź tekstową dla żądań AJAX

## Struktura projektu

```
lab5/
├── css
│   └── style.css
├── doc-img
│   └── request.png
├── html
│   ├── filmy.html
│   ├── glowna.html
│   ├── kontakt.html
│   └── produkt.html
├── img
│   ├── gigabyte.webp
│   ├── iiyama.webp
│   └── msi.webp
├── includes
│   ├── naglowek.php
│   └── produkty.php
├── index.php
├── js
│   ├── lab3.js
│   └── main.js
├── jsconfig.json
├── lab4.php
├── README.md
├── status.php
├── TESTY.md
└── vendor
    └── jquery-4.0.0.min.js

```

## Punkt odniesienia

Po skopiowaniu plików do katalogu `lab5` i otwarciu wersji bazowej `index.html` przed wydzieleniem szablonu PHP zweryfikowano:

* Filtr katalogu (`lab4.php?kategoria=...`): poprawnie filtruje produkty oraz wyświetla komunikat przy nieznanej kategorii.
* Zapis wyboru (`lab4.php`): poprawne żądanie `POST` zapisuje wybór w `$_SESSION['ostatni_wybor']` i zwraca przekierowanie `303` na `lab4.php` (`200`).
* Żądanie AJAX (`status.php`): przycisk sprawdzania serwera pobiera odpowiedź z `status.php` (`200`) i wypisuje jej treść na stronie.

## Pseudokod

### Wybór widoku i weryfikacja pliku

```
$views = mapa dozwolonych widoków: klucz -> { title, file }
$activeKey = null
$viewFile = null
$returnCode = 200

JEŚLI brak $_GET['idp'] LUB $_GET['idp'] == '' -> $activeKey = 'glowna'
W PRZECIWNYM RAZIE JEŚLI $_GET['idp'] jest tekstem I klucz istnieje w $views -> $activeKey =$_GET['idp']
W PRZECIWNYM RAZIE -> $returnCode = 404

JEŚLI $returnCode == 200:
    $path = __DIR__ . '/' . $views[$activeKey]['file']
    JEŚLI is_file($path) I is_readable($path):
        $viewFile = $path
        $siteTitle = $views[$activeKey]['title']
    W PRZECIWNYM RAZIE:
        $returnCode = 500
        $activeKey = null
        $siteTitle = 'Błąd serwera (500)'
W PRZECIWNYM RAZIE:
    $siteTitle = 'Nie znaleziono strony (404)'

http_response_code($returnCode)

```

### Generowanie szablonu i dołączanie treści

```
<title> -> wypisz $siteTitle przez htmlspecialchars(..., UTF-8)
<nav>   -> wygeneruj linki z $views; dla $key == $activeKey dodaj aria-current="page"
        -> dodaj odnośnik do lab4.php

<main>:
    JEŚLI $returnCode == 200 I $viewFile != null -> include $viewFile
    W PRZECIWNYM RAZIE JEŚLI $returnCode == 404   -> komunikat 404 + link do index.php
    W PRZECIWNYM RAZIE                           -> komunikat 500 + link do index.php

<footer> -> wypisz identyfikator projektu przez echo

```

## Wyniki prób

### Adres domyślny i menu

Kroki:
Otwarcie `index.php`, `index.php?idp=` oraz przejście kolejno po wszystkich linkach w nawigacji (`Strona główna`, `Produkt`, `Kontakt`, `Filmy`).

Wynik oczekiwany:
`index.php` i `index.php?idp=` pokazują stronę główną (`200 OK`). Odnośniki otwierają właściwe treści ze wspólnym szablonem, poprawnym `<title>` oraz atrybutem `aria-current="page"` na aktywnej pozycji.

Wynik rzeczywisty:
Wszystkie widoki zwracają `200 OK`, zachowują wspólny nagłówek, nawigację i stopkę, a aktywny link otrzymuje `aria-current="page"`.

### Nieznany lub tablicowy klucz

Kroki:
Wywołanie w przeglądarce adresów `index.php?idp=nieznana` oraz `index.php?idp[]=filmy` z otwartym panelem Network.

Wynik oczekiwany:
Oba żądania zwracają status HTTP `404` oraz wyświetlają komunikat błędu z odnośnikiem powrotnym do `index.php`, bez ostrzeżeń PHP.

Wynik rzeczywisty:
Panel Network rejestruje status `404 Not Found` dla obu adresów; strona wyświetla komunikat 404 oraz link powrotny bez żadnych warningów PHP.

### Próba podania ścieżki

Kroki:
Wywołanie adresu `index.php?idp=..%2Fstatus.php`.

Wynik oczekiwany:
Status HTTP `404`, brak dołączenia pliku `status.php`.

Wynik rzeczywisty:
Zwrócony kod odpowiedzi to `404 Not Found`, a zawartość `status.php` nie została dołączona do dokumentu.

### Brak pliku widoku

Kroki:
Tymczasowa zmiana nazwy pliku `html/filmy.html` na `html/filmy_bak.html`, otwarcie `index.php?idp=filmy`, sprawdzenie kodu w panelu Network i przywrócenie pierwotnej nazwy pliku.

Wynik oczekiwany:
Adres `?idp=filmy` zwraca HTTP `500` bez ujawnienia ścieżki systemowej na dysku.

Wynik rzeczywisty:
Panel Network pokazuje status `500 Internal Server Error`, a treść strony zawiera wyłącznie ogólny komunikat błędu i link powrotny (bez ścieżki systemowej). Po przywróceniu nazwy plik ponownie działa z kodem `200`.

### Strona główna i AJAX

Kroki:
Otwarcie `index.php`, weryfikacja ładowania arkusza stylów, grafik i animacji przycisków oraz kliknięcie przycisku sprawdzającego status serwera.

Wynik oczekiwany:
Na stronie głównej działają style, grafiki i animacje. W panelu Sieć widać udane żądanie do `status.php` (`200`), a na stronie pojawia się jego wynik.

Wynik rzeczywisty:
Wszystkie zasoby ładują się poprawnie, animacje działają, a kliknięcie przycisku wysyła żądanie GET do `status.php` (`200 OK`) i wyświetla odpowiedź `PHP działa`.

### Katalog i sesja po migracji

Kroki:
Przejście z menu do `lab4.php`, filtrowanie kategorii, wysłanie formularza z poprawnym wyborem, przejście na `index.php`, następnie `index.php?idp=filmy` i powrót do `lab4.php`.

Wynik oczekiwany:
Zapis wyboru zwraca `POST 303`, a następnie `GET 200`. Po nawigacji między podstronami i powrocie do katalogu zapisany wybór nadal jest widoczny.

Wynik rzeczywisty:
W panelu Network widoczne jest `POST 303` oraz `GET 200`, a wybrany wcześniej produkt i ilość pozostają zapisane w sesji po powrocie z podstron `index.php`.

### Filmy i układ mobilny

Kroki:
Otwarcie `index.php?idp=filmy`, uruchomienie wszystkich trzech odtwarzaczy wideo, przejście po linkach klawiszem `Tab` oraz sprawdzenie widoku w trybie responsywnym o szerokości `360 px`.

Wynik oczekiwany:
Trzy filmy można uruchomić, odnośniki obok odtwarzaczy działają i są dostępne z klawiatury, a przy szerokości `360 px` strona nie przewija się w poziomie.

Wynik rzeczywisty:
Wszystkie trzy odtwarzacze uruchamiają się poprawnie, nawigacja klawiszem `Tab` przenosi fokus na odnośniki pod każdym filmem, a przy szerokości `360 px` układ mieści się w oknie bez poziomego paska przewijania.