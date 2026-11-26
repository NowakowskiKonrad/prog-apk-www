## Lab 6

Wersja: v1.5

### Uruchamianie serwera PHP i bazy danych

Linux:
```sh
make server-run
php --server localhost:8000 --docroot .

```

Windows (XAMPP):

```text
Uruchom moduły Apache oraz MySQL w panelu XAMPP.
Skopiuj projekt do katalogu htdocs/lab6 i otwórz http://localhost/lab6/index.php

```

### Odtworzenie bazy danych i konfiguracja lokalna

1. Utwórz bazę `moja_strona` oraz tabelę `page_list` importując plik `sql/schema.sql` w phpMyAdmin lub z linii poleceń:

```sh
mysql -u root -p < sql/schema.sql

```

2. Zaimportuj przykładowe podstrony (4 opublikowane i 1 szkic) z pliku `sql/seed.sql`:

```sh
mysql -u root -p < sql/seed.sql

```

3. Utwórz lokalnego użytkownika bazy danych z uprawnieniem wyłącznie do odczytu (`SELECT`) tabeli `moja_strona.page_list`:

```sql
CREATE USER IF NOT EXISTS 'cms_reader'@'localhost' IDENTIFIED BY 'TwojeSilneHaslo123!';
GRANT SELECT ON `moja_strona`.`page_list` TO 'cms_reader'@'localhost';
FLUSH PRIVILEGES;

```

4. Skopiuj plik `cfg.example.php` do `cfg.php` i uzupełnij dane dostępowe (plik `cfg.php` jest ignorowany przez Git w `.gitignore`):

```sh
cp cfg.example.php cfg.php

```

## Adresy aplikacji

* `index.php` oraz `index.php?idp=` oraz `index.php?idp=glowna` – strona główna pobierana z `page_list`
* `index.php?idp=produkt` – podstrona szczegółów produktu pobierana z `page_list`
* `index.php?idp=kontakt` – podstrona z formularzem kontaktowym pobierana z `page_list`
* `index.php?idp=filmy` – podstrona z materiałami wideo pobierana z `page_list`
* `lab4.php` – katalog produktów z filtrowaniem GET, zapisem POST i sesją (`includes/produkty.php`)
* `status.php` – endpoint zwracający odpowiedź tekstową dla żądań AJAX
* `admin/admin.php` – szkielet przyszłego panelu administracyjnego CMS

## Struktura projektu

```text
lab6/
├── admin
│   └── admin.php
├── cfg.example.php
├── cfg.php
├── css
│   └── style.css
├── doc-img
│   └── request.png
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
├── Makefile
├── README.md
├── showpage.php
├── sql
│   ├── schema.sql
│   └── seed.sql
├── status.php
├── TESTY.md
└── vendor
    └── jquery-4.0.0.min.js

```

## Pseudokod

### Walidacja żądania, odczyt z bazy i obsługa błędów (`index.php`, `showpage.php`)

```text
$activeAlias = null
$requestedAlias = null
$pageData = null
$menuItems = []
$returnCode = 200
$siteTitle = 'Strona główna'

JEŚLI brak $_GET['idp'] LUB $_GET['idp'] === '':
    $requestedAlias = 'glowna'
W PRZECIWNYM RAZIE JEŚLI $_GET['idp'] jest tekstem I pasuje do /^[a-z0-9-]{1,20}$/:
    $requestedAlias = $_GET['idp']
W PRZECIWNYM RAZIE:
    $returnCode = 404
    $siteTitle = 'Nie znaleziono strony (404)'

SPRÓBUJ (przed wysłaniem jakiegokolwiek kodu HTML):
    Wczytaj cfg.php (utworzenie $pdo z charset=utf8mb4, ERRMODE_EXCEPTION, EMULATE_PREPARES=false)
    Wczytaj showpage.php

    Pobierz aktywne pozycje menu:
        SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id ASC
        Zapisz wynik w $menuItems

    JEŚLI $returnCode === 200 I $requestedAlias !== null:
            $pageData = PokazPodstrone($pdo,$requestedAlias)
        JEŚLI $pageData !== null:
            $activeAlias = $requestedAlias
            $siteTitle = $pageData['page_title']
        W PRZECIWNYM RAZIE:
            $returnCode = 404
            $siteTitle = 'Nie znaleziono strony (404)'
PRZECHWYĆ wyjątek $exception:
    Zapisz szczegóły do lokalnego logu serwera (error_log)
    $returnCode = 500
    $activeAlias = null
    $pageData = null
    $menuItems = []
    $siteTitle = 'Błąd serwera (500)'

Ustaw kod odpowiedzi HTTP: http_response_code($returnCode)
Wygeneruj szablon HTML (<title>, <nav>, <main>, <footer>)

```

## Wyniki prób

### 1. Odczyt i aktualizacja treści

Kroki:
Otwarcie `index.php` oraz `index.php?idp=`, a następnie zmiana fragmentu treści rekordu `glowna` w phpMyAdmin i odświeżenie strony w przeglądarce.

Wynik oczekiwany:
Oba adresy otwierają stronę główną ze statusem `200 OK`. Po zmianie rekordu w bazie nowa treść jest widoczna od razu po odświeżeniu bez modyfikacji plików PHP.

Wynik rzeczywisty:
Oba adresy zwracają `200 OK`, a zmiana zapisana w `moja_strona.page_list` pojawia się natychmiast po odświeżeniu karty przeglądarki.

### 2. Nowa strona i menu

Kroki:
Dodanie w phpMyAdmin nowego opublikowanego rekordu (`alias = 'o-nas'`, `status = 1`) oraz przejście do niego przez menu nawigacyjne.

Wynik oczekiwany:
Nowy link pojawia się automatycznie w `<nav>`, otwiera treść z kodem `200 OK` bez zmian w plikach PHP, a aktywny link otrzymuje `aria-current="page"`.

Wynik rzeczywisty:
Pozycja pojawia się w menu na końcu listy (zgodnie z `ORDER BY id ASC`), podstrona zwraca `200 OK`, a bieżący link ma atrybut `aria-current="page"`.

### 3. Szkic i publikacja

Kroki:
Sprawdzenie widoczności rekordu ze `status = 0` (`promocje`) w menu oraz pod adresem `index.php?idp=promocje`, zmiana `status` na `1`, a także próba dodania drugiego rekordu z identycznym aliasem `glowna`.

Wynik oczekiwany:
Szkic nie występuje w menu i zwraca `404` przy bezpośrednim wywołaniu; po zmianie `status = 1` staje się widoczny. Próba wstawienia duplikatu aliasu jest blokowana przez indeks `UNIQUE`.

Wynik rzeczywisty:
Dla `status = 0` link nie jest generowany w nawigacji, a bezpośrednie wejście zwraca `404 Not Found`. Po ustawieniu `status = 1` strona działa z kodem `200`. Próba dodania drugiego wiersza z aliasem `glowna` kończy się błędem `Duplicate entry` po stronie MariaDB.

### 4. Błędne dane w adresie

Kroki:
Wywołanie w przeglądarce adresów `index.php?idp=nieznana`, `index.php?idp[]=filmy`, `index.php?idp=../cfg.php` oraz `index.php?idp=OR%201%3D1--` z otwartym panelem Network.

Wynik oczekiwany:
Wszystkie cztery żądania zwracają status HTTP `404` oraz komunikat błędu z linkiem powrotnym, bez żadnych ostrzeżeń PHP.

Wynik rzeczywisty:
Panel Network rejestruje `404 Not Found` dla każdego z czterech adresów; strona wyświetla komunikat `404` i odnośnik do `index.php` bez wycieku ostrzeżeń PHP.

### 5. Awaria bazy

Kroki:
Tymczasowa zmiana portu na niepoprawny (`$dbPort = 3307;`) w `cfg.php`, otwarcie `index.php`, sprawdzenie statusu HTTP i logu błędów PHP, a następnie przywrócenie poprawnego portu `3306`.

Wynik oczekiwany:
Strona zwraca HTTP `500` z ogólnym komunikatem błędu bez ujawniania SQL, haseł czy ścieżek plików, a szczegóły błędu trafiają do logu serwera.

Wynik rzeczywisty:
Przeglądarka otrzymuje `500 Internal Server Error` i bezpieczny komunikat ogólny, natomiast w logu błędów PHP zapisuje się komunikat `SQLSTATE[HY000] [2002] Connection refused`. Po przywróceniu portu `3306` strona wraca do działania (`200 OK`).

### 6. Funkcje po migracji

Kroki:
Weryfikacja stylów, obrazów, animacji jQuery, żądania AJAX do `status.php`, trzech odtwarzaczy wideo na `index.php?idp=filmy` oraz działania katalogu i sesji w `lab4.php`.

Wynik oczekiwany:
Wszystkie zasoby, animacje, AJAX (`200`), odtwarzacze wideo oraz zapis wyboru w `lab4.php` (`POST 303`, następnie `GET 200` i zachowanie sesji między podstronami) działają poprawnie.

Wynik rzeczywisty:
Style, grafiki WebP, zegar, wyszukiwarka, animacje i przycisk AJAX (`PHP działa`) funkcjonują bez zmian, wszystkie trzy osadzone filmy odtwarzają się poprawnie, a `lab4.php` zapisuje wybór w sesji (`POST 303` -> `GET 200`).

### 7. Odtworzenie środowiska

Kroki:
Utworzenie czystej bazy testowej, import `sql/schema.sql` oraz `sql/seed.sql`, konfiguracja `cfg.php` na bazie `cfg.example.php` i weryfikacja polskich znaków diakrytycznych.

Wynik oczekiwany:
Projekt uruchamia się zgodnie z instrukcją w `README.md`, a polskie znaki są poprawnie zapisywane i wyświetlane.

Wynik rzeczywisty:
Po imporcie schematu i danych aplikacja uruchamia się poprawnie, zachowując pełne kodowanie `utf8mb4` dla polskich znaków.

