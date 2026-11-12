## Lab 4

### Uruchamianie serwera php

Linux:
```sh
php --server localhost:8000 --docroot .
```

Windows:
```
Należy wykorzystać XAMPP
```

## Struktura projektu

```
lab4/
├── index.html
├── lab4.php
├── status.php
├── includes/
│   ├── naglowek.php
│   └── produkty.php
├── html/
├── css/
├── js/
├── img/
└── README.md
```

## Pseudokod

### Wspólny szkielet pliku

```
session_start()
require_once includes/produkty.php  -> $produkty
$method = $_SERVER['REQUEST_METHOD']

JEŚLI $method == 'POST'  -> gałąź zapisu wyboru
W PRZECIWNYM RAZIE       -> gałąź filtra GET

widok: sesja -> formularz GET -> katalog (while) -> formularz POST (for)
```

### Poprawne żądanie POST

```
id     = numberFromForm($_POST,'produkt')   # is_string + FILTER_VALIDATE_INT -> int
amount = numberFromForm($_POST,'ilosc')

JEŚLI id = null                       -> błąd pola produkt
W PRZECIWNYM RAZIE brak produktu o id -> błąd pola produkt
JEŚLI amount = null                   -> błąd pola ilosc
W PRZECIWNYM RAZIE amount < 1 LUB > MAX_COUNT -> błąd pola ilosc
JEŚLI brak błędów I amount > produkt.stan     -> błąd pola ilosc (magazyn)

JEŚLI brak błędów:
    $_SESSION['ostatni_wybor'] = { id: id, ilosc: amount }
    header('Location: lab4.php', true, 303)
    exit
```

### Błędne żądanie POST

```
http_response_code(400)
$sent = przesłane wartości tekstowe (do pokazania w formularzu)
# $_SESSION NIETKNIĘTA -> wcześniejszy wybór zostaje
widok: pełny katalog + komunikat przy błędnym polu
```

### Żądanie GET (filtr)

```
JEŚLI brak $_GET['kategoria']                                  -> filter = 'wszystkie'
JEŚLI kategoria jest tekstem ZE zbioru {wszystkie,ksiazki,akcesoria} -> filter = kategoria
W PRZECIWNYM RAZIE (tablica lub nieznana wartość)              -> filter = 'wszystkie' + komunikat
# gałąź GET nie zapisuje nic w sesji
widok: 200 + produkty przefiltrowane pętlą while
```

## Wyniki prób

### Filtr GET

Wynik Oczekiwany:
?kategoria=ksiazki pokazuje tylko książki. Nieznana kategoria lub
?kategoria[]=ksiazki pokazuje pełną listę i komunikat

Wynik rzeczywisty:
?kategoria=ksiazki zwraca tylko książki
?kategoria=ksiazkid zwraca wszystko + wyświetla komunikat
?kategoria[]=ksiazki zwraca wszystko + wyświetla komunikat


### Poprawny POST i odświeżenie

Wynik Oczekiwany:
Wybierz dostępny produkt i poprawną ilość. W Network widać POST
303, potem GET 200. Po odświeżeniu i zmianie filtra zapisany wybór
pozostaje widoczny.

Wynik rzeczywisty:
W Network po kliknięciu guzika widać 303 POST, następnie 200 GET. Ustalone wartości zostają zapisane, nawet po odświeżeniu strony.

### Błędne wartości POST

Wynik Oczekiwany:
Sprawdź ilość 0, 6, 2.5, 2abc, brak pola, tablicę i nieznany produkt.
Każda próba daje HTTP 400 i pozostawia poprzedni wybór.

Wynik rzeczywisty:
Zmieniając pole value w formularzu i wysyłając zapytanie otrzymujemy odpowiedź 400, błędne zapytanie nie zmienia zapisanego wyboru.

### Stan magazynowy

Wynik Oczekiwany:
Dla produktu ze stanem 1 spróbuj wybrać 2 sztuki. Serwer odrzuca
wybór, mimo że 2 mieści się w przedziale 1–5.

Wynik rzeczywisty:
Serwer odrzuca zapytanie ze stosownym powodem wypisanym pod formularzem.

### Odrębna sesja i tekst HTML

Wynik Oczekiwany:
W nowej sesji, np. w osobnym oknie prywatnym, nie ma wyboru. Nazwa
testowa `<b>Test</b>` wyświetla się jako tekst; przywróć zwykłą
nazwę.

Wynik rzeczywisty:
Nazwa testowa wyświetlana jest bezpośrednio, bez konwersji na HTML dzięki wykorzystaniu `htmlspecialchars()`.

### Strona po zmianie ścieżek

Wynik Oczekiwany:
Otwórz stronę główną i podstrony. Działają style, obrazy, linki i funkcje z
lab3, w tym animacje i żądanie do status.php.

Wynik rzeczywisty:
Cała funkcjonalność z poprzedniego laboratorium nadal działa poprawnie.