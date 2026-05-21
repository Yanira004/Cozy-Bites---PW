$(function() {
    
    
    function randeazaVertical(date) {
        const $tabel = $("#tabel-vertical");
        $tabel.empty(); 

        const randuri = [
            { label: "Nume Rețetă", cheie: "nume", index: 0 },
            { label: "Dificultate", cheie: "dificultate", index: 1 },
            { label: "Timp (min)", cheie: "timp", index: 2 }
        ];

        $.each(randuri, function(idx, rand) {
            let htmlRand = `<tr><th class="sortabil" data-index="${rand.index}">${rand.label}</th>`;
            
            $.each(date, function(_, item) {
                htmlRand += `<td>${item[rand.cheie]}</td>`;
            });
            
            htmlRand += "</tr>";
            $tabel.append(htmlRand); 
        });
    }

    $("#tabel-vertical").on("click", "th.sortabil", function() {
        const index = $(this).data("index");
        
        const chei = ["nume", "dificultate", "timp"];
        const cheie = chei[index];

        reteteDate.sort((a, b) => {
            if (typeof a[cheie] === "string") return a[cheie].localeCompare(b[cheie]);
            return a[cheie] - b[cheie];
        });

        randeazaVertical(reteteDate);
    });

    randeazaVertical(reteteDate);
});