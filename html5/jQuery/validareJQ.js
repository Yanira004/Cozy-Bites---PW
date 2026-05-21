$(function() {
    $("#retetaForm").submit(function(event) {
        let esteValid = true;
        
        const $inputNume = $("#nume_reteta");
        if ($.trim($inputNume.val()).length < 3) {
            $inputNume.addClass("eroare-input");
            esteValid = false;
        } else {
            $inputNume.removeClass("eroare-input");
        }

        const $inputTimp = $("#timp");
        if ($inputTimp.val() <= 0) {
            $inputTimp.addClass("eroare-input");
            esteValid = false;
        } else {
            $inputTimp.removeClass("eroare-input");
        }

       if (!esteValid) {
            event.preventDefault(); 
        }
    });

    
    $("#loginForm").submit(function(event) {
        let esteValid = true;

        const $user = $("#username");
        if ($.trim($user.val()) === "") {
            $user.addClass("eroare-input");
            esteValid = false;
        } else {
            $user.removeClass("eroare-input");
        }

        const $parola = $("#parola");
        if ($parola.val().length < 6) {
            $parola.addClass("eroare-input");
            esteValid = false;
        } else {
            $parola.removeClass("eroare-input");
        }

        const $dataNastere = $("#data_nastere");
        const valData = $dataNastere.val();
        if (!valData || valData.split('-')[0] > 2006) {
            $dataNastere.addClass("eroare-input");
            esteValid = false;
        } else {
            $dataNastere.removeClass("eroare-input");
        }

        if (!esteValid) event.preventDefault();
    });

   
    $("#contactForm").submit(function(event) {
        let esteValid = true;

        const $poza = $("#poza");
        if ($poza.val() === "") {
            $poza.addClass("eroare-input");
            esteValid = false;
        } else {
            $poza.removeClass("eroare-input");
        }

        const $termeni = $("#termeni");
        const $eroareTermeni = $("#eroare-termeni");
        if (!$termeni.is(":checked")) {
            $eroareTermeni.text("Trebuie sa bifezi casuta!");
            esteValid = false;
        } else {
            $eroareTermeni.text("");
        }

        if (!esteValid) event.preventDefault();
    });
});