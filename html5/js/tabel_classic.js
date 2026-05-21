let directieSortare = 1; 

function randeazaTabel(date) {
    const corp = document.getElementById("corp-tabel-classic");
    corp.innerHTML = ""; 
    date.forEach(r => {
        const row = `<tr>
            <td>${r.nume}</td>
            <td>${r.dificultate}</td>
            <td>${r.timp}</td>
        </tr>`;
        corp.innerHTML += row;
    });
}

function sorteazaTabel(coloanaIndex) {
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

    const headers = document.querySelectorAll("#tabel-classic th");
    headers.forEach((h, idx) => {
        h.classList.remove("sort-asc", "sort-desc", "tabel-activ");
        if (idx === coloanaIndex) {
            h.classList.add(directieSortare === -1 ? "sort-asc" : "sort-desc");
            h.classList.add("tabel-activ");
        }
    });

    randeazaTabel(reteteDate);
}


document.addEventListener("DOMContentLoaded", () => randeazaTabel(reteteDate));