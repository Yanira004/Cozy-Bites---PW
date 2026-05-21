document.addEventListener("DOMContentLoaded", function() {
    const inputPortii = document.getElementById("input-portii");
    const btnMinus = document.getElementById("btn-minus");
    const btnPlus = document.getElementById("btn-plus");
    const afisajPortii = document.getElementById("afisaj-portii");
    const elementeIngrediente = document.querySelectorAll(".lista-calculata li[data-baza]");

    const PORTII_INITIALE = 24; 

    function actualizeazaCantitati() {
        let numarPortii = parseInt(inputPortii.value);
        
        if (isNaN(numarPortii) || numarPortii < 1) {
            numarPortii = 1;
        }

        afisajPortii.innerText = numarPortii;

        elementeIngrediente.forEach(function(item) {
            const baza = parseFloat(item.getAttribute("data-baza"));
            const rezultat = (baza / PORTII_INITIALE) * numarPortii;
            
            const valoareFinala = (rezultat % 1 === 0) ? rezultat : rezultat.toFixed(1);
            
            item.querySelector("span").innerText = valoareFinala;
        });
    }

    btnMinus.addEventListener("click", function() {
        if (inputPortii.value > 1) {
            inputPortii.value--;
            actualizeazaCantitati();
        }
    });

    btnPlus.addEventListener("click", function() {
        inputPortii.value++;
        actualizeazaCantitati();
    });

    inputPortii.addEventListener("input", actualizeazaCantitati);
});