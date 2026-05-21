
document.addEventListener("DOMContentLoaded", function() {

    const retetaForm = document.getElementById("retetaForm");
    if (retetaForm) {
        retetaForm.addEventListener("submit", function(event) {
            let esteValid = true;
            
            const inputNume = document.getElementById("nume_reteta");
            if (inputNume.value.trim().length < 3) {
                inputNume.classList.add("eroare-input");
                esteValid = false;
            } else {
                inputNume.classList.remove("eroare-input");
            }

            const inputTimp = document.getElementById("timp");
            if (inputTimp.value <= 0) {
                inputTimp.classList.add("eroare-input");
                esteValid = false;
            } else {
                inputTimp.classList.remove("eroare-input");
            }

            if (!esteValid) {
                event.preventDefault(); 
            }
        });
    }

    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            let esteValid = true;

            const user = document.getElementById("username");
            if (user.value.trim() === "") {
                user.classList.add("eroare-input");
                esteValid = false;
            } else {
                user.classList.remove("eroare-input");
            }

            const parola = document.getElementById("parola");
            if (parola.value.length < 6) {
                parola.classList.add("eroare-input");
                esteValid = false;
            } else {
                parola.classList.remove("eroare-input");
            }

            const dataNastere = document.getElementById("data_nastere");
            if (!dataNastere.value || dataNastere.value.split('-')[0] > 2006) {
                dataNastere.classList.add("eroare-input");
                esteValid = false;
            } else {
                dataNastere.classList.remove("eroare-input");
            }

            if (!esteValid) event.preventDefault();
        });
    }

    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        contactForm.addEventListener("submit", function(event) {
            let esteValid = true;

            const poza = document.getElementById("poza");
            if (poza.value === "") {
                poza.classList.add("eroare-input");
                esteValid = false;
            } else {
                poza.classList.remove("eroare-input");
            }

            const termeni = document.getElementById("termeni");
            const eroareTermeni = document.getElementById("eroare-termeni");
            if (!termeni.checked) {
                eroareTermeni.innerText = "Trebuie sa bifezi casuta!";
                esteValid = false;
            } else {
                eroareTermeni.innerText = "";
            }

            if (!esteValid) event.preventDefault();
        });
    }
});