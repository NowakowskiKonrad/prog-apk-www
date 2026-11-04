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