document.addEventListener("DOMContentLoaded", function() {

    const dateCategorii = {
        "mic_dejun": ["Omletă", "Clătite", "Cereale", "Sandwich"],
        "fel_principal": ["Supă sau Ciorbă", "Friptură la grătar", "Paste", "Tocăniță"],
        "desert": ["Tort", "Înghețată", "Prăjitură de casă", "Biscuiți"]
    };

    const selectCategorie = document.getElementById("categorie");
    const selectSubcategorie = document.getElementById("subcategorie");

    if (selectCategorie && selectSubcategorie) {
        selectCategorie.addEventListener("change", function() {
            const categorieAleasa = this.value;
            selectSubcategorie.innerHTML = '<option value="">-- Alege --</option>';

            if (categorieAleasa !== "") {
                selectSubcategorie.disabled = false;
                const optiuni = dateCategorii[categorieAleasa];
                
                for (let i = 0; i < optiuni.length; i++) {
                    let optNode = document.createElement("option");
                    optNode.value = optiuni[i].toLowerCase(); 
                    optNode.innerHTML = optiuni[i]; 
                    selectSubcategorie.appendChild(optNode);
                }
            } else {
                selectSubcategorie.innerHTML = '<option value="">-- Alege întâi categoria --</option>';
                selectSubcategorie.disabled = true;
            }
        });
    }

    const checkCoacere = document.getElementById("necesita_coacere");
    const inputTemp = document.getElementById("temperatura");

    if (checkCoacere && inputTemp) {
        checkCoacere.addEventListener("change", function() {
            if (this.checked) {
                inputTemp.disabled = false;
                inputTemp.focus();
            } else {
                inputTemp.disabled = true;
            }
        });
    }
});