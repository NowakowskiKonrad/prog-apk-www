## Lab 1

### Jak uruchomić:

```sh
python -m http.server 8000
```

### Uruchamiane serwera php

Linux:
```sh
php --server localhost:8000 --docroot .
```

Windows:
```
Należy wykorzystać XAMPP
```

## Sprawdzenie działania animacji jQuery

### Próba: Szybkie kliknięcia A

#### Wynik oczekiwany: Zgodny z oczekiwaniami

#### Wynik finalny: Zgodny z oczekiwaniami
Stan końcowy zgadza się z liczbą kliknięć dzięki przerywaniu obecnie działającej animacji i odtwarzaniu kolejnej zaraz po.

---

### Próba: Kursor i fokus B

#### Wynik oczekiwany: Zgodny z oczekiwaniami

#### Wynik finalny: Zgodny z oczekiwaniami
Samo najechanie i zabranie myszki wraca do stanu bazowego. Wybranie przycisku tabem, najechanie oraz zabranie myszki z przycisku utrzymuje powiększony stan, ponieważ przycisk nadal posiada focus z klawiatury. Aby pozbyć się stanu powiększonego należy zmienić focus za pomocą przycisku tab.

---

### Próba: Limit i reset C

#### Wynik oczekiwany: Zgodny z oczekiwaniami

#### Wynik finalny: Zgodny z oczekiwaniami
Kliknięcie guzika 5 razy wraz z czekaniem na zakończenie animacji daje oczekiwany, maksymalny rozmiar. Dalsze kliknięcia nie powiększają obrazu, ponieważ liczba kliknięć jest śledzona i każde kliknięcie ponad limit kończy funkcję wcześniej. Reset podczas animacji zeruje stan, nie trzeba czekać na koniec animacji.

---

### Próba: Klawiatura i ruch

#### Wynik oczekiwany: Zgodny z oczekiwaniami

#### Wynik finalny: Zgodny z oczekiwaniami
Tab dociera do wszystkich przycisków, enter i spacja poprawnie działają na przyciski i jQuery odpowiednio na to reaguje, ograniczenie ruchu znacznie przyspiesza animacje (testowane poprzez DevTools -> Show Rendering -> Emulate CSS media feature prefers-reduced-motion), zachowując odpowiednią funkcjonalność.

---

Konsola w przeglądarce jest wolna od błędów, poprzednia funkcjonalność działa poprawnie.

## PHP

Po wprowadzeniu odpowiednich danych do celu zapytania otrzymywany jest porawny wynik w postaci "PHP działa".
---
Jeżeli nazwa pliku status.php zostanie zmieniona zwracany jest kod HTML głównej strony. Jest to prawdopodobnie spowodowane domyślną konfiguracją serwera PHP na Linuxie. Wrócenie do odpowiedniej nazwy pliku poprawnie zwraca oczekiwaną wiadomość.
---
Symulacja ograniczonej prędkości sieci (3G w DevTools/Networking) sprawia, że zapytanie wykonywane jest dłużej, jednak na tyle krótko żeby nie wywołać timeout'u.