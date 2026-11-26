SET NAMES utf8mb4;

USE `moja_strona`;

TRUNCATE TABLE `page_list`;

INSERT INTO `page_list` (`alias`, `page_title`, `page_content`, `status`) VALUES
(
  'glowna',
  'Strona główna',
  '<section class="controls-section">
            <div id="clock-container">
                <p id="clock-display"></p>
                <button type="button" id="btn-clock-start">Start zegara</button>
                <button type="button" id="btn-clock-stop">Stop zegara</button>
            </div>
            <div class="search-container">
                <label for="search-input">Znajdź produkt:</label>
                <input type="search" id="search-input" placeholder="Wpisz fragment nazwy...">
                <div aria-live="polite">
                    <span id="search-counter"></span>
                    <span id="search-message"></span>
                </div>
            </div>
        </section>
        <h1>Strona główna</h1>
        <div class="catalog-grid">
            <article class="card">
                <h2>Iiyama G2741QSU-B1</h2>
                <img src="img/iiyama.webp" alt="Iiyama G-Master G2741QSU-B1" width="800" height="600">
                <p>
                    Monitor iiyama G-Master G2741QSU-B1 Black Hawk to idealny wybór dla zapalonych graczy,
                    którzy szukają wyjątkowego doświadczenia wizualnego.
                    Dzięki swojej matowej, 27-calowej matrycy IPS w rozdzielczości WQHD,
                    każdy szczegół w grach staje się bardziej wyrazisty,
                    co pozwala na pełne zanurzenie w wirtualnym świecie.
                    Monitor została zaprojektowany z myślą o graczach,
                    oferując wysoką częstotliwość odświeżania 144 Hz oraz niski czas reakcji 1 ms,
                    co znacząco wpływa na płynność rozgrywki.
                </p>
                <p>Cena: 629 zł</p>
                <a href="index.php?idp=produkt">Link do produktu</a>
            </article>
            <article class="card">
                <h2>Gigabyte G27Q2</h2>
                <img src="img/gigabyte.webp" alt="Gigabyte G27Q2" width="800" height="600">
                <p>
                    Monitor Gigabyte G27Q2 to doskonały wybór dla pasjonatów gier oraz multimediów.
                    Jego imponująca jakość obrazu w rozdzielczości WQHD oraz częstotliwości odświeżania 200 Hz sprawiają,
                    że każdy detal jest perfekcyjnie widoczny.
                    Dzięki nowoczesnej matrycy IPS,
                    zyskujesz znakomite kąty widzenia oraz żywe kolory,
                    które ożywią Twoje ulubione tytuły i filmy.
                </p>
                <p>Cena: 629 zł</p>
            </article>
            <article class="card">
                <h2>MSI MAG 275QF E20</h2>
                <img src="img/msi.webp" alt="MSI MAG 275QF E20" width="617" height="530">
                <p>
                    Monitor MSI MAG 275QF E20 to idealny wybór dla zapalonych graczy,
                    którzy cenią sobie wysoką jakość obrazu oraz płynność podczas intensywnych rozgrywek.
                    Dzięki technologii Rapid IPS oraz rozdzielczości WQHD,
                    każdy szczegół na ekranie będzie wyrazisty i pełen kolorów.
                    Jego nowoczesny design bezramkowy sprawi,
                    że idealnie wkomponuje się w Twoje stanowisko pracy lub gamingowe.
                </p>
                <p>Cena: 579 zł</p>
            </article>
        </div>
        <section>
            <h1>Sekcja demonstracyjna</h1>
            <button type="button" class="demonstration-button" id="dem-btn-1">Przycisk 1</button>
            <button type="button" class="demonstration-button" id="dem-btn-2">Przycisk 2</button>
            <button type="button" class="demonstration-button" id="dem-btn-3">Przycisk 3</button>
            <div class="status-clicks">
                <span>Liczba klików:</span>
                <output role="status" id="c-button-status">0 / 5</output>
            </div>
            <button type="button" class="demonstration-button" id="dem-btn-reset">Resetuj A orac C</button>
            <div>
                <button type="button" class="demonstration-button" id="check-server">Sprawdź serwer</button>
                <div class="status-clicks">
                    <output role="status" id="php-response"></output>
                </div>
            </div>
        </section>',
  1
),
(
  'produkt',
  'Produkt',
  '<h1>Product</h1>
        <article>
            <h2>Iiyama G-Master G2741QSU-B1</h2>
            <img src="img/iiyama.webp" alt="Iiyama G-Master G2741QSU-B1" width="800" height="600">
            <p>
                Monitor <strong>Iiyama G-Master G2741QSU-B1</strong> Black Hawk to idealny wybór dla zapalonych graczy,
                którzy szukają wyjątkowego doświadczenia wizualnego.
                Dzięki swojej matowej, <em>27-calowej matrycy IPS w rozdzielczości WQHD</em>,
                każdy szczegół w grach staje się bardziej wyrazisty,
                co pozwala na pełne zanurzenie w wirtualnym świecie.
                Monitor została zaprojektowany z myślą o graczach,
                oferując wysoką częstotliwość odświeżania 144 Hz oraz niski czas reakcji 1 ms,
                co znacząco wpływa na płynność rozgrywki.
            </p>
            <ul>
                <li>Wysoka jakość obrazu</li>
                <li>Technologia G-SYNC</li>
                <li>Niski czas reakcji</li>
            </ul>
            <p>Cena: 629 zł</p>
            <table>
            <caption>Tabela parametrów technicznych</caption>
            <thead>
                <tr>
                <th scope="col">Nazwa parametru</th>
                <th scope="col">Wartość</th>
                <th scope="col">Jednostka</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>Przekątna ekranu</td>
                <td>27</td>
                <td>cale</td>
                </tr>
                <tr>
                <td>Powłoka matrycy</td>
                <td>Matowa</td>
                <td></td>
                </tr>
                <tr>
                <td>Częstotliwość odświeżania</td>
                <td>144</td>
                <td>Hz</td>
                </tr>
                <tr>
                <td>Rozdzielczość ekranu</td>
                <td>2560x1440</td>
                <td>px</td>
                </tr>
            </tbody>
            </table>
            <a href="index.php?idp=kontakt">Zapytaj o produkt</a>
        </article>',
  1
),
(
  'kontakt',
  'Kontakt',
  '<h1>Kontakt</h1>
        <p>
            <strong>Podgląd lokalny. Formularz nie wysyła wiadomości.</strong> Ceny i walidacja w przeglądarce są demonstracją; w docelowym sklepie serwer musi je niezależnie sprawdzić.
        </p>

        <form action="index.php?idp=kontakt" method="get">
        <div class="form-group">
            <label for="field-email">Adres e-mail *</label>
            <input 
            type="email" 
            id="field-email" 
            required 
            placeholder="jan.kowalski@example.com"
            >
        </div>
        <div class="form-group">
            <label for="field-produkt">Wybierz produkt *</label>
            <select id="field-produkt" name="produkt" required>
            <option value="">Wybierz produkt</option>
            <option value="gigabyte">Gigabyte G27Q2</option>
            <option value="iiyama">Iiyama G-Master G2741QSU-B1</option>
            <option value="msi">MSI MAG 275QF E20</option>
            </select>
        </div>
        <div class="form-group">
            <label for="field-ilosc">Liczba sztuk (zakres: od 1 do 5)</label>
            <input 
            type="number" 
            id="field-ilosc" 
            name="ilosc" 
            required 
            min="1" 
            max="5" 
            step="1" 
            placeholder="1"
            >
        </div>
        <div class="form-group">
            <label for="field-wiadomosc">Treść wiadomości (od 10 do 500 znaków)</label>
            <textarea 
            id="field-wiadomosc" 
            name="wiadomosc" 
            required 
            minlength="10" 
            maxlength="500" 
            rows="5" 
            placeholder="Wpisz tutaj treść swojej wiadomości..."
            ></textarea>
        </div>
        <button type="submit">Sprawdź zapytanie</button>
        </form>

        <div id="form-summary" aria-live="polite"></div>',
  1
),
(
  'filmy',
  'Filmy',
  '<h1>Prezentacje i testy monitorów</h1>
<p>Zestawienie materiałów wideo dotyczących monitorów gamingowych WQHD IPS.</p>

<section class="catalog-grid">
    <article class="card">
        <h2>iiyama G-Master G2741QSU-B1 Black Hawk</h2>
        <iframe
            src="https://www.youtube.com/embed/of5aAEDB0Rw?si=LLdxtNtzBwFLFljV"
            title="Prezentacja monitora iiyama G-Master G2741QSU-B1 Black Hawk"
            loading="lazy"
            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
        <p><a href="https://www.youtube.com/watch?v=of5aAEDB0Rw" target="_blank" rel="noopener noreferrer">Otwórz materiał w serwisie YouTube</a></p>
    </article>

    <article class="card">
        <h2>Gigabyte G27Q2</h2>
        <iframe
            src="https://www.youtube.com/embed/XDT-kh8mzGU?si=sQhbZlTWPWnfCrn-"
            title="Omówienie monitora Gigabyte G27Q2 WQHD 200 Hz"
            loading="lazy"
            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
        <p><a href="https://www.youtube.com/watch?v=XDT-kh8mzGU" target="_blank" rel="noopener noreferrer">Otwórz materiał w serwisie YouTube</a></p>
    </article>

    <article class="card">
        <h2>MSI MAG 275QF E20</h2>
        <iframe
            src="https://www.youtube.com/embed/AFhscKrE3OQ?si=3sUnWcmyqDBA5hIU"
            title="Przegląd monitora MSI MAG 275QF E20 Rapid IPS"
            loading="lazy"
            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
        <p><a href="https://www.youtube.com/watch?v=AFhscKrE3OQ" target="_blank" rel="noopener noreferrer">Otwórz materiał w serwisie YouTube</a></p>
    </article>
</section>',
  1
),
(
  'promocje',
  'Promocje',
  '<h1>Promocje sezonowe</h1>
<p>Strona robocza (szkic) przygotowywana na kolejną kampanię rabatową.</p>',
  0
);