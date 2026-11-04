## Lab 1

### Jak uruchomić:

```sh
python -m http.server 8000
```

### Przepływ danych w aplikacji (Lab 2)

#### 1. Zmiana motywu (Tryb ciemny/jasny)

* Zdarzenie: Kliknięcie (`click`) przycisku "Tryb ciemny".


* Dane wejściowe: Odczytanie aktualnej wartości atrybutu `data-theme` z elementu `<html>` lub pobranie zapisanego uprzednio wyboru z `localStorage`.


* Obliczenie: Odwrócenie stanu logicznego motywu (np. przejście z `light` na `dark`).


* Zmiana DOM: Zaktualizowanie atrybutu `data-theme` na elemencie `<html>`, ustawienie boolowskiego stanu atrybutu `aria-pressed` na przycisku oraz utrwalenie nowej wartości w pamięci `localStorage`.



#### 2. Zegar i data

* Zdarzenie: Zdarzenie załadowania skryptu oraz przypisanie cyklicznego odświeżania funkcją `setInterval` (co 1000 ms), sterowane kliknięciami w przyciski Start/Stop.


* Dane wejściowe: Aktualny czas odczytywany za każdym wywołaniem bezpośrednio z wbudowanego obiektu `Date()`.


* Obliczenie: Formatowanie daty i czasu do docelowej struktury (pełny rok, system 24-godzinny, sekundy) przy użyciu lokalizacji pl-PL w obiekcie `Intl.DateTimeFormat`.


* Zmiana DOM: Dynamiczne nadpisanie zawartości tekstowej elementu zegara za pośrednictwem właściwości `textContent`.



#### 3. Wyszukiwanie i filtrowanie produktów

* Zdarzenie: Wprowadzanie modyfikacji znakowych w polu `<input type="search">` poprzez wychwytywanie zdarzenia `input`.


* Dane wejściowe: Surowy ciąg znaków podany przez użytkownika, odczytywane asynchronicznie tytuły z nagłówków `<h2>` w poszczególnych kartach.


* Obliczenie: Standaryzacja zapytania poprzez wycięcie skrajnych spacji (`trim()`) i ujednolicenie wielkości liter (`toLowerCase()`), a następnie weryfikacja zawartości (przez `includes()`) oraz inkrementacja zmiennej zliczającej poprawne trafienia.


* Zmiana DOM: Nadanie lub usunięcie właściwości `hidden` na analizowanych kartach `.card` w drzewie DOM, zaktualizowanie komunikatu błędu i licznika wewnątrz przygotowanego kontenera z atrybutem `aria-live="polite"`.



#### 4. Kalkulacja wartości i podgląd lokalny formularza

* Zdarzenie: Wstępna wycena wyzwalana przy zdarzeniach `change` / `input` wewnątrz kontrolek wyboru, a ostateczny podgląd uruchamiany przez zdarzenie `submit`.


* Dane wejściowe: Wartość wybranej opcji z elementu `<select>`, wprowadzona liczba wewnątrz pola ilości, a także tekst z obiektu `<textarea>`.


* Obliczenie: Walidacja matematyczna – sprawdzenie bycia liczbą całkowitą z zadanego przedziału, pomnożenie ilości sztuk na bazie wartości w groszach, przeliczenie wyniku na złotówki z użyciem formattera walutowego `Intl.NumberFormat`; weryfikacja długości treści po uprzednim oczyszczeniu ze spacji.


* Zmiana DOM: Przerwanie domyślnego działania przeglądarki metodą `preventDefault()`, wstrzyknięcie komunikatów błędów przy nieprawidłowych polach z przeniesieniem fokusu, usunięcie poprzednich potwierdzeń oraz wstawienie kompletnego, zaktualizowanego bloku z wykorzystaniem `textContent` celem odrzucenia tagów HTML w polu wiadomości.



---

Źródło grafik: [x-kom.pl](https://x-kom.pl)
