$(function() {
    const dateCategorii = {
        "mic_dejun": ["Omletă", "Clătite", "Cereale", "Sandwich"],
        "fel_principal": ["Supă sau Ciorbă", "Friptură la grătar", "Paste", "Tocăniță"],
        "desert": ["Tort", "Înghețată", "Prăjitură de casă", "Biscuiți"]
    };

    const $selectCategorie = $("#categorie");
    const $selectSubcategorie = $("#subcategorie");

    if ($selectCategorie.length && $selectSubcategorie.length) {
        $selectCategorie.change(function() {
            const categorieAleasa = $(this).val(); 
            
            $selectSubcategorie.html('<option value="">-- Alege --</option>');

            if (categorieAleasa !== "") {
                $selectSubcategorie.prop("disabled", false);
                const optiuni = dateCategorii[categorieAleasa];
                
                $.each(optiuni, function(index, valoare) {
                    $selectSubcategorie.append($('<option>', {
                        value: valoare.toLowerCase(),
                        text: valoare
                    }));
                });
            } else {
                $selectSubcategorie.html('<option value="">-- Alege întâi categoria --</option>');
                $selectSubcategorie.prop("disabled", true);
            }
        });
    }

    const $checkCoacere = $("#necesita_coacere");
    const $inputTemp = $("#temperatura");

    if ($checkCoacere.length && $inputTemp.length) {
        $checkCoacere.change(function() {
            if ($(this).is(":checked")) {
                $inputTemp.prop("disabled", false).focus();
            } else {
                $inputTemp.prop("disabled", true);
            }
        });
    }
});