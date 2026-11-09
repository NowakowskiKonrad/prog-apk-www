# Testy – Laboratorium 2

User Agent przeglądarki:

```
Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36

Chromium @ Fedora Linux

```

## 1. Motyw i nawigacja

* Oczekiwany wynik: Zmiana motywu utrzymuje się po odświeżeniu i zmianie podstrony; aria-pressed odpowiada stanowi.


* Zaobserwowany wynik: jw. Skrypt poprawnie zapisuje wartość ('light' lub 'dark') w `localStorage`. Przy załadowaniu podstrony atrybut `aria-pressed` przycisku od razu otrzymuje właściwą wartość boolowską.

## 2. Start trzy razy potem Stop i Start

* Oczekiwany wynik: Działa jeden interwał; Stop zatrzymuje aktualizację, a wznowienie pokazuje aktualny czas.


* Zaobserwowany wynik: jw. Wielokrotne wciśnięcie przycisku "Start" nie powoduje nałożenia się na siebie wywołań `setInterval`, ponieważ przypisanie nowej instancji jest blokowane, jeśli zmienna przechowująca identyfikator interwału nie jest pusta. Po wznowieniu obiekt `Date` odczytuje poprawnie aktualny czas z systemu bazowego.

## 3. Fragment nazwy ze spacjami i inną wielkością liter

* Oczekiwany wynik: Pasujące karty pozostają widoczne; licznik zgadza się z widokiem.


* Zaobserwowany wynik: jw. Metoda `toLowerCase()` zastosowana na stringach wejściowych skutecznie uodparnia system na wielkość liter, a funkcja `trim()` radzi sobie z nadmiarowymi białymi znakami przed rozpoczęciem pętli sprawdzającej węzły w DOM.

## 4. Brak dopasowania i wyczyszczenie pola

* Oczekiwany wynik: Pojawia się komunikat o braku wyników; wyczyszczenie przywraca trzy karty.


* Zaobserwowany wynik: jw. Usunięcie znaków z pola `input` natychmiastowo cofa atrybut `hidden` dla iterowanych elementów `.card`.

## 5. Cena 1999 gr oraz ilość 3

* Oczekiwany wynik: Wynik wynosi 59,97 zł.


* Zaobserwowany wynik: jw. Realizacja obliczeń matematycznych na liczbach całkowitych (groszach) skutecznie omija typowe błędy arytmetyki zmiennoprzecinkowej w JavaScript (np. problem z wyliczeniem `0.1 + 0.2`). Podział wyniku końcowego i użycie `Intl.NumberFormat` formatuje kwotę bezbłędnie.

## 6. Ilość pusta, 0, 6 oraz 1,5

* Oczekiwany wynik: Wycena nie pokazuje błędnej wartości; formularz nie przechodzi do poprawnego podsumowania.


* Zaobserwowany wynik: jw. Warunki brzegowe blokują generowanie ceny. Skrypt weryfikuje liczby przy użyciu `Number.isInteger()`, dlatego ułamek dziesiętny wyświetla odpowiedni monit błędu.

## 7. Dziesięć spacji oraz tekst `<b>Test</b>`

* Oczekiwany wynik: Same spacje są odrzucone; poprawna wiadomość ze znacznikami jest pokazana jako dosłowny tekst.


* Zaobserwowany wynik: jw. Funkcja weryfikująca stosuje operację `trim()`, co demaskuje ciąg pustych znaków, a nałożony limit wymusza wyjście z błędem w konsoli i DOM. Użycie `textContent` (zamiast `innerHTML`) w pełni zabezpiecza formularz przed atakiem XSS – znaczniki zostają wyrenderowane czystym tekstem.

## 8. Klawiatura, widoki i wyłączony JavaScript

* Oczekiwany wynik: Kontrolki działają klawiaturą przy 375 i 1280 px; bez JS katalog, treść i menu pozostają dostępne.


* Zaobserwowany wynik: jw. Przechwytywanie zachowania w pliku `main.js` dodanym w tagu `<head>` z parametrem `defer` sprawia, że bez włączonego JS witryna działa jako czysty, semantyczny i w pełni czytelny dokument HTML.

## 9. Eksperyment i analiza błędów w DevTools

* Oczekiwany wynik: Świadome wywołanie funkcji z błędem (literówka w nazwie) ma umożliwić odczytanie numeru linii z błędem w konsoli.


* Zaobserwowany wynik: Wprowadzono błąd w wywołaniu metody (np. `document.getElemntById`). Konsola zgłasza `TypeError: document.getElemntById is not a function` wskazując poprawnie na określoną linijkę. Po ustawieniu breakpointu na funkcji wyliczającej kwotę, podgląd wartości wskazywał prawidłowe mapowanie `cenaGrosze`. Kod skorygowano, a końcowa konsola wyjściowa nie zwraca już żadnych ostrzeżeń.
