document.addEventListener("DOMContentLoaded", () => {
    initTheme();
    initClock();
    initSearch();
    initForm();
});

function initTheme() {
    const toggleBtn = document.getElementById("dark-mode-toggle");
    if (!toggleBtn) return;

    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    toggleBtn.setAttribute("aria-pressed", savedTheme === "dark");

    toggleBtn.addEventListener("click", () => {
        const isDark = document.documentElement.getAttribute("data-theme") === "dark";
        const newTheme = isDark ? "light" : "dark";

        document.documentElement.setAttribute("data-theme", newTheme);
        toggleBtn.setAttribute("aria-[ressed", newTheme === "dark");
        localStorage.setItem("theme", newTheme);
    });
}

function initClock() {
    const display = document.getElementById("clock-display");
    const btnStart = document.getElementById("btn-clock-start");
    const btnStop = document.getElementById("btn-clock-stop");

    if (!display || !btnStart || !btnStop) return;

    let clockInterval = null;

    const updateClock = () => {
        const now = new Date();
        const formatter = new Intl.DateTimeFormat("pl-PL", {
            year: "numeric", month: "2-digit", day: "2-digit",
            hour: "2-digit", minute: "2-digit", second: "2-digit"
        });
        display.textContent = formatter.format(now);
    };

    const startClock = () => {
        if (!clockInterval) {
            updateClock();
            clockInterval = setInterval(updateClock, 1000);
        }
    };

    const stopClock = () => {
        if (clockInterval) {
            clearInterval(clockInterval);
            clockInterval = null;
        }
    };

    btnStart.addEventListener("click", startClock);
    btnStop.addEventListener("click", stopClock);

    startClock();
}

function initSearch() {
    const searchInput = document.getElementById("search-input");
    const cards = document.querySelectorAll(".catalog-grid .card");
    const counter = document.getElementById("search-counter");
    const message = document.getElementById("search-message");

    if (!searchInput || !cards.length === 0) return;

    const updateSearch = () => {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.querySelector("h2").textContent.toLowerCase();
            if (title.includes(query)) {
                card.hidden = false;
                visibleCount++;
            } else {
                card.hidden = true;
            }
        });

        if (visibleCount === 0) {
            message.textContent = "Brak produktów spełniających kryteria wyszukiwania";
            counter.textContent = "";
        } else {
            message.textContent = "";
            counter.textContent = "Liczba znalezionych produktów: " + visibleCount.toString();
        }
    };

    searchInput.addEventListener("input", updateSearch);
}

function initForm() {
    const form = document.querySelector("form");
    const productSelect = document.getElementById("field-produkt");
    const quantityInput = document.getElementById("field-ilosc");
    const messageInput = document.getElementById("field-wiadomosc");
    const summaryDiv = document.getElementById("form-summary");

    if (!form || !productSelect || !quantityInput || !messageInput) return;

    const products = [
        { id: 'gigabyte', nazwa: 'Gigabyte G27Q2', cenaGrosze: 62900 },
        { id: 'iiyama', nazwa: 'Iiyama G-Master G2741QSU-B1', cenaGrosze: 62900 },
        { id: 'msi', nazwa: 'MSI MAG 275QF E20', cenaGrosze: 57900 }
    ];

    const calculateTotal = (cena, ilosc) => cena * ilosc;

    const updateLivePreview = () => {
        const prodId = productSelect.value;
        const qtyStr = quantityInput.value;

        let preview = document.getElementById("live-price-preview");
        if (!preview) {
            preview = document.createElement("p");
            preview.id = "live-price-preview";
            quantityInput.parentNode.appendChild(preview);
        }

        if (!prodId || qtyStr === "") {
            preview.textContent = "Wypełnij produkt i ilość aby zobaczyć wycenę";
            return;
        }

        const qty = Number(qtyStr);
        if (!Number.isInteger(qty) || qty < 1 || qty > 5) {
            preview.textContent = "Wprowadź poprawną ilość produktów (od 1 do 5)."
            return;
        }

        const product = products.find(p => p.id === prodId);
        if (product) {
            const totalGrosze = calculateTotal(product.cenaGrosze, qty);
            const formatter = new Intl.NumberFormat("pl-PL", {
                style: "currency", currency: "PLN"
            });
            preview.textContent = "Szacowana wartość zamówienia: " + formatter.format(totalGrosze / 100);
        }
    }

    productSelect.addEventListener("change", updateLivePreview);
    quantityInput.addEventListener("input", updateLivePreview);

    form.addEventListener("submit", (e) => {
        e.preventDefault();
        summaryDiv.innerHTML = "";

        const msgText = messageInput.value.trim();
        let error = document.getElementById("msg-error");

        if (!error) {
            error = document.createElement("div");
            error.id = "msg-error";
            error.style.color = "var(--focur-ring)";
            error.style.margin = "0.25rem";
            messageInput.parentNode.appendChild(error);
        }

        if (msgText.length < 10) {
            error.textContent = "Wiadomość po usunięciu spacji musi mieć co najmniej 10 znaków.";
            messageInput.focus();
            return;
        } else {
            error.textContent = "";
        }

        const prodId = productSelect.value;
        const qty = Number(quantityInput.value);
        const product = products.find(p => p.id === prodId);

        const totalGrosze = calculateTotal(product.cenaGrosze, qty);
        const formatter = new Intl.NumberFormat("pl-PL", {
            style: "currency", currency: "PLN"
        });

        const summaryTitle = document.createElement("h3");
        summaryTitle.textContent = "Lokalny podgląd zapytania";

        const summaryInfo = document.createElement("p");
        summaryInfo.textContent = "Produkt: " + product.nazwa.toString() +
                                " | Ilość: " + qty.toString() +
                                " | Wartość: " + formatter.format(totalGrosze/100);
        
        const summaryMsg = document.createElement("blockquote");
        summaryMsg.textContent = msgText;

        summaryDiv.append(summaryTitle, summaryInfo, summaryMsg);
    });
}