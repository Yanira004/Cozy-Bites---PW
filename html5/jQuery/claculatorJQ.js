$(function() {
    const $inputPortii = $("#input-portii");
    const $afisajPortii = $("#afisaj-portii");
    const $elementeIngrediente = $(".lista-calculata li[data-baza]");
    const PORTII_INITIALE = 24; 

    function actualizeazaCantitati() {
        let numarPortii = parseInt($inputPortii.val());
        
        if (isNaN(numarPortii) || numarPortii < 1) {
            numarPortii = 1;
        }

        $afisajPortii.text(numarPortii);

        $elementeIngrediente.each(function() {
            const baza = parseFloat($(this).data("baza"));
            const rezultat = (baza / PORTII_INITIALE) * numarPortii;
            
            const valoareFinala = (rezultat % 1 === 0) ? rezultat : rezultat.toFixed(1);
            
            $(this).find("span").text(valoareFinala);
        });
    }

    $("#btn-minus").click(function() {
        if ($inputPortii.val() > 1) {
            $inputPortii.val($inputPortii.val() - 1);
            actualizeazaCantitati();
        }
    });

    $("#btn-plus").click(function() {
        $inputPortii.val(parseInt($inputPortii.val()) + 1);
        actualizeazaCantitati();
    });

    $inputPortii.on("input", actualizeazaCantitati);
});