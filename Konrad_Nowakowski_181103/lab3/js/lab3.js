if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    $.fx.off = true;
}

/*
Pobierz przycisk A
Zainicjalizuj zmienną trzymającą stan przycisku : isExpanded

Jeżeli przycisk naciśnięty:
    Przypisz isExpanded wartość odwrotną
    Zmień atrybut aria-pressed przycisku zgodnie z zmienną isExpanded
    Znajdź odpowiednią wartość wysokości i szerokości zgodnie ze zmienną isExpanded (w tym przypadku wykorzystując tzw. ternary operator)
    Zatrzymaj trwającą animację
    Uruchom nową animację
*/

let $btnA = $("#dem-btn-1");
let isExpandedA = false;

$btnA.on("click", function () {
    isExpandedA = !isExpandedA;
    $btnA.attr("aria-pressed", isExpandedA.toString());

    let targetWidth = isExpandedA ? 240 : 160;
    let targetHeight = isExpandedA ? 130 : 90;

    $btnA.stop(true, false).animate({
        width: targetWidth + "px",
        height: targetHeight + "px"
    }, 300);
});

/*
Pobierz przycisk B
Zainicjalizuj zmienne trzymające stan przycisku : isFocused oraz isHovered

Stwórz metodę odpowiedzialną za animowanie przycisku:
    Zainicjalizuj zmienną shouldExpand z wartością zależną od isFocused oraz isHovered. (Jeżeli którakolwiek ze zmiennych jest true to shouldExpand również jest true)
    Znajdź docelową wysokość oraz szerokość zależnie od zmiennej shouldExpand (ternary operator)

    Zatrzymaj animację
    Uruchom nową animację

Przy najechaniu myszki na przycisk zmień zmienną isHovered na true i uruchom animację
Przy złapaniu focusu przez przycisk zmień zmienną isFocused na true i uruchom animację
Przy zjechaniu myszki z przycisku zmień zmienną isHovered na false i uruchom animację
Przy straceniu focusu przez przycisk zmień zmienną isFocused na false i uruchom animację
*/

let $btnB = $("#dem-btn-2")

let isFocused = false;
let isHovered = false;

function updateSize() {
    let shouldExpand = isHovered || isFocused;
    let targetWidth = shouldExpand ? 220 : 160;
    let targetHeight = shouldExpand ? 120 : 90;

    $btnB.stop(true, false).animate({
        height: targetHeight + "px",
        width: targetWidth + "px"
    });
}

$btnB.on("mouseenter", function() {
    isHovered = true;
    updateSize();
});

$btnB.on("focus", function() {
    isFocused = true;
    updateSize();
});

$btnB.on("mouseleave", function() {
    isHovered = false;
    updateSize();
});

$btnB.on("blur", function() {
    isFocused = false;
    updateSize();
});

/*
Pobierz przycisk C
Pobierz kontener wyświetlający liczbę kliknięć

Zainicjalizuj zmienne trzymające ilość kliknięć, bazową szerokość i bazową wysokość

Jeżeli guzik zostanie kliknięty:
    Jeżeli liczba kliknięć jest większa lub równa 5 - przerwij działanie
    Jeżeli przycisk jest obecnie animowany - przerwij działanie

    Zwiększ liczbę kliknięć o 1
    Zmień tekst wyświetlany w kontenerze
    Uruchom nową animację:
        Oblicz nową wysokość i szerokość bazująć na liczbie kliknięć oraz parametrach bazowych
*/
let $btnC = $("#dem-btn-3")
let $status = $("output[role='status']")
let clicks = 0;
let baseWidth = 160;
let baseHeight = 90;

$btnC.on("click", function () {
    if (clicks >= 5) return;
    if ($btnC.is(":animated")) return;

    clicks += 1;
    $status.text(clicks + " / 5");
    $btnC.animate({
        height: clicks * 10 + baseHeight + "px",
        width: clicks * 20 + baseWidth + "px"
    });
});

/*
Pobierz przycisk odpowiedzialny za reset

Po kliknięciu przycisku odpowiedzialnego za reset:
    Zatrzymaj animajcę przycisku A oraz zmień jego CSS na domyślny
    Zatrzymaj animajcę przycisku C oraz zmień jego CSS na domyślny

    Ustaw wartość zmiennej isExpandedA na false
    Zmień atrybut aria-pressed przycisku A na false

    Ustaw wartość zmiennej clicks na 0
    Zmień tekst wyświetlany przez status na domyślny
*/
let $btnReset = $("#dem-btn-reset")

$btnReset.on("click", function () {
    $btnA.stop(true, false).css({width: "160px", height: "90px"});
    $btnC.stop(true, false).css({width: "160px", height: "90px"});

    isExpandedA = false;
    $btnA.attr("aria-pressed", "false");

    clicks = 0;
    $status.text("0 / 5");
});
