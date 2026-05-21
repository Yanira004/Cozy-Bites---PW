$(function() {
    const slides = [
        {link: "formular5.html", text: "Bucură-te de un tort răcoritor de lămâie!", imagine: "../images/lemon_cake.jpeg"},
        { link: "formular5.html", text: "Adaugă propria ta rețetă de Butter Chicken!", imagine: "../images/butter_chicken.jpeg" },
        { link: "carduri.html", text: "Vezi cardurile noastre cu Biscuiți delicioși!", imagine: "../images/cookies.jpeg" },
        { link: "reteta_briose.html", text: "Descoperă rețeta noastră de brioșe cu lămâie!", imagine: "../images/briose_lamaie.jpeg" },
        { link: "home5.html", text: "Încearcă un brownie simplu dar decadent!", imagine: "../images/brownie.jpeg" }
    ];

    let indexCurent = 0;
    const $container = $('#carousel-slide');
    const $textDescriere = $('#carousel-text');
    const $linkButon = $('#carousel-link');

    function afiseazaSlide(index) {
        const slide = slides[index];
        $container.css("background-image", `url('${slide.imagine}')`);
        $textDescriere.text(slide.text);
        $linkButon.attr("href", slide.link);
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

    $('#btn-next').click(function() {
        clearInterval(autoPlay); 
        slideUrmator();
        autoPlay = setInterval(slideUrmator, 3000); 
    });

    $('#btn-prev').click(function() {
        clearInterval(autoPlay);
        slideAnterior();
        autoPlay = setInterval(slideUrmator, 3000);
    });
});