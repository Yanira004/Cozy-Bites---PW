<?php
session_start();

if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    header("Location: login.php?mesaj=trebuie_logat");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Cozy Bites - Adaugă Rețetă</title>
    <link rel="icon" type="image/png" href="images/LogoCircle.png">
    <link rel="stylesheet" href="css/orizontal.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .preview-wrapper {
            width: 100px;
            height: 100px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }
        .preview-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="form-page">

<img src="../images/pan.png" class="decor-pan" alt="decor" aria-hidden="true">
<img src="../images/tel_rm.png" class="decor-cookie" alt="decor" aria-hidden="true">
<img src="../images/chohoCup.png" class="decor-choco" alt="decor" aria-hidden="true">
<img src="../images/rollingPin.png" class="decor-rollingPin" alt="decor" aria-hidden="true">
<img src="../images/waffle_rm.png" class="decor-waffle" alt="decor" aria-hidden="true">
<img src="../images/cookie_rm.png" class="decor-tel" alt="decor" aria-hidden="true">

<nav class="navbar">
    <div class="nav-left">
        <img src="../images/LogoCircle.png" class="logo-nav" alt="Logo">
        <span class="logo-text">Cozy Bites</span>
    </div>

    <ul class="nav-center">
        <li><a href="home5.html">Acasă</a></li>
        <li><a href="formular5.php">Adaugă Rețetă</a></li>
        <li><a href="carduri.php">Carduri Rețete</a></li>
    </ul>

    <div class="nav-right">
        <a href="contact.html" title="Contact"><i class="fas fa-phone"></i></a>
        <a href="login.php" title="Contul Meu"><i class="fas fa-user"></i></a>
    </div>
</nav>

<h1 class = "form-title" style="font-family: 'Pacifico', cursive;">Propune o rețetă nouă</h1>

<form id="retetaForm" action="procesare_reteta.php" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Informații Generale</legend>
        <p>
            <label>Nume Rețetă: </label>
            <input type="text" id="nume_reteta" placeholder="ex: Red Velvet Cake" name="nume_reteta" size="40" maxlength="100">
            <span class="mesaj-eroare">Numele rețetei trebuie să aibă minim 3 litere!</span>
            <span>(Obligatoriu)</span>
        </p>
        <p>
            Sursă rețetă: <input type="text" name="sursa"  placeholder="ex: Utilizator Anonim">
        </p>
        <p>
            Dificultate:
            <input type="radio" name="dif" value="1" checked> Ușoară
            <input type="radio" name="dif" value="2"> Medie
            <input type="radio" name="dif" value="3"> Grea
        </p>
    </fieldset>

    <fieldset>
        <legend>Imagini Rețetă</legend>
        <p>
            Selectează imagini:
            <input type="file" id="poze" name="poze[]" multiple accept="image/*">
        <div id="preview-container"></div>
        </p>
    </fieldset>

    <fieldset>
        <legend>Descriere și Categorii</legend>

        <p>
            <b>Categorie:</b>
            <select id="categorie" name="categorie">
                <option value="">-- Alege --</option>
                <option value="mic_dejun">Mic Dejun</option>
                <option value="fel_principal">Fel Principal</option>
                <option value="desert">Desert</option>
            </select>
        </p>
        <p>
            <b>Subcategorie:</b>
            <select id="subcategorie" name="subcategorie" disabled>
                <option value="">-- Alege întâi categoria --</option>
            </select>
        </p>
        <p>
            <input type="checkbox" id="necesita_coacere" name="necesita_coacere">
            <b>Necesită coacere la cuptor</b>
        </p>
        <p>
            Temperatura (°C):
            <input type="number" id="temperatura" name="temperatura" value="180" disabled>
        </p>
        <hr>
        <p>
            Ingrediente: <br>
            <textarea name="ingrediente" rows="10" cols="50" placeholder="ex: 100ml ulei"></textarea>
        </p>
        <p>
            Origine:
            <select name="origine" size="1">
                <option value="ro" selected>România</option>
                <option value="it">Italia</option>
                <option value="fr">Franța</option>
                <option value="in">India</option>
                <option value="uk">Marea Britanie</option>
            </select>
        </p>
        <p>
            Etichete adiționale (Selectați mai multe): <br>
            <select name="tags" multiple size="4">
                <option value="bio">Bio</option>
                <option value="rapid">Rapid</option>
                <option value="ieftin">Ieftin</option>
                <option value="festiv">Festiv</option>
                <option value="vegan">Vegan</option>
            </select>
        </p>
        <p>
            Instrucțiuni de preparare: <br>
            <textarea name="instructiuni" rows="10" cols="50" placeholder=""></textarea>
        </p>
        <p>
            Timp estimat (minute):
            <input type="number" id="timp" name="timp" value="30" max="500" step="5">
            <span class="mesaj-eroare">Timpul trebuie să fie mai mare ca 0!</span>
        </p>
        <p>
            <input type="submit" value="Trimite Rețeta">
        </p>
    </fieldset>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="jQuery/validareJQ.js"></script>
<script src="jQuery/dependenteJQ.js"></script>
<script>
    $(document).ready(function() {
        $('#poze').on('change', function() {
            var files = $(this)[0].files;
            $('#preview-container').empty();
            if (files.length > 0) {
                $.each(files, function(i, file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-container').append('<div class="preview-wrapper"><img src="' + e.target.result + '"></div>');
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>
</body>

</html>