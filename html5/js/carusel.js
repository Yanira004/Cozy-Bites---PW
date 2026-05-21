
document.addEventListener('DOMContentLoaded', () => {
    
    const slides = [
        {
            link: "formular5.html",
            text: "Bucură-te de un tort răcoritor de lămâie!",
            imagine: "../images/lemon_cake.jpeg"
        },
        {
            link: "formular5.html",
            text: "Adaugă propria ta rețetă de Butter Chicken!",
            imagine: "../images/butter_chicken.jpeg"
        },
        {
            link: "carduri.html",
            text: "Vezi cardurile noastre cu Biscuiți delicioși!",
            imagine: "../images/cookies.jpeg"
        },
        {
            link: "reteta_briose.html", 
            text: "Descoperă rețeta noastră de brioșe cu lămâie!",
            imagine: "../images/briose_lamaie.jpeg"
        },
        {
            link: "home5.html", 
            text: "Încearcă un brownie simplu dar decadent!",
            imagine: "../images/brownie.jpeg"
        },
        


    ];

    let indexCurent = 0;
    const container = document.getElementById('carousel-slide');
    const textDescriere = document.getElementById('carousel-text');
    const linkButon = document.getElementById('carousel-link');

    function afiseazaSlide(index) {
        const slide = slides[index];
        container.style.backgroundImage = `url('${slide.imagine}')`;
        textDescriere.textContent = slide.text;
        linkButon.href = slide.link;
    }

    function slideUrmator() {
        indexCurent = (indexCurent + 1) % slides.length;
        afiseazaSlide(indexCurent);
    }

    function slideAnterior() {
        indexCurent = (indexCurent - 1 + slides.length) % slides.length;
        afiseazaSlide(indexCurent);
    }

    afiseazaSlide(indexCurent);

    let autoPlay = setInterval(slideUrmator, 3000);

    document.getElementById('btn-next').addEventListener('click', () => {
        clearInterval(autoPlay); 
        slideUrmator();
        autoPlay = setInterval(slideUrmator, 3000); 
    });

    document.getElementById('btn-prev').addEventListener('click', () => {
        clearInterval(autoPlay);
        slideAnterior();
        autoPlay = setInterval(slideUrmator, 3000);
    });
});