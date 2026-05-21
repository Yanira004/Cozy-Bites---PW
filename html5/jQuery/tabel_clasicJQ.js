$(function() {
    let directieSortare = 1; 

    function randeazaTabel(date) {
        const $corp = $("#corp-tabel-classic");
        $corp.empty(); 
        
        $.each(date, function(index, r) {
            $corp.append(`<tr>
                <td>${r.nume}</td>
                <td>${r.dificultate}</td>
                <td>${r.timp}</td>
            </tr>`);
        });
    }

    $("#tabel-classic th.sortabil").click(function() {
        const coloanaIndex = $(this).index();
        const coloane = ["nume", "dificultate", "timp"];
        const cheie = coloane[coloanaIndex];

        reteteDate.sort((a, b) => {
            let valA = a[cheie];
            let valB = b[cheie];

            if (typeof valA === "string") {
                return valA.localeCompare(valB) * directieSortare;
            }
            return (valA - valB) * directieSortare;
        });

        directieSortare *= -1;

        $("#tabel-classic th").removeClass("sort-asc sort-desc tabel-activ");
        
        if (directieSortare === -1) {
            $(this).addClass("sort-asc tabel-activ");
        } else {
            $(this).addClass("sort-desc tabel-activ");
        }

        randeazaTabel(reteteDate);
    });

    randeazaTabel(reteteDate);
});