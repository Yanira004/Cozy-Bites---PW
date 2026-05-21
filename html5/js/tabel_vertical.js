function randeazaVertical(date) {
    const tabel = document.getElementById("tabel-vertical");
    tabel.innerHTML = "";

    const randuri = [
        { label: "Nume Rețetă", cheie: "nume", index: 0 },
        { label: "Dificultate", cheie: "dificultate", index: 1 },
        { label: "Timp (min)", cheie: "timp", index: 2 }
    ];

    randuri.forEach(rand => {
        let htmlRand = `<tr><th class="sortabil" onclick="sorteazaVertical(${rand.index})">${rand.label}</th>`;
        date.forEach(item => {
            htmlRand += `<td>${item[rand.cheie]}</td>`;
        });
        htmlRand += "</tr>";
        tabel.innerHTML += htmlRand;
    });
}

function sorteazaVertical(index) {
    const chei = ["nume", "dificultate", "timp"];
    const cheie = chei[index];

    reteteDate.sort((a, b) => {
        if (typeof a[cheie] === "string") return a[cheie].localeCompare(b[cheie]);
        return a[cheie] - b[cheie];
    });

    randeazaVertical(reteteDate);
}

document.addEventListener("DOMContentLoaded", () => randeazaVertical(reteteDate));