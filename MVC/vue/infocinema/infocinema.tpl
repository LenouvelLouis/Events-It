    <!DOCTYPE HTML>
    <html lang="fr">
    <meta charset="UTF-8">

    <head>
        <link rel="stylesheet" href="./vue/infocinema/infocinema.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    </head>

    <body>
        <?php require("./vue/navbar/nav.tpl"); ?>
        <div class="barre">
            <a href="./?path=pages/accueil">Accueil</a> /
            <a href="./?path=pages/cinema">Cinéma</a> /
            <a href="./?path=pages/infocinema">Info cinéma</a>
        </div>
        <center class ="titre_cine">
            <h1></h1>
        </center>

        <div class="container_flex">
            <div class="image-container img-cine">
                <img id="img" src=""/>
            </div>
            <div>
                <h3>Contact :</h3>
                <p class="adresse_cine"></p>
                <p class="telephone_cine"></p>
                <p class="email_cine"></p>
            </div>
            <div>
                <h3>Accessibilit&eacute; :&nbsp;</h3>
                <p class="icons-wheelchair"><i class="fa-solid fa-wheelchair icons"></i><span class="texttd"> PMR</span></p>
                <p class="icons-ear-deaf"><i class="fa-solid fa-ear-deaf icons"></i><span class="texttd"> Malentandant</span></p>
                <p class="icons-eye-slash"><i class="fa-regular fa-eye-slash icons"></i><span class="texttd"> Audio description</span></p>
                <p class="accessibility-text"></p>
            </div>
        </div>
        <center><h3>Informations complémentaires</h3><center>

        <div class="display_info">

            <div>
                <iframe id="google_maps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2626.7616134560744!2d2.2773399753126453!3d48.82460970308475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e670797935962f%3A0xa2a4098b11eb5c09!2s10%20Rue%20de%20Vanves%2C%2092170%20Issy-les-Moulineaux!5e0!3m2!1sfr!2sfr!4v1713004630545!5m2!1sfr!2sfr" width="400" height="300" allowfullscreen=""frameborder="0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div>
                <iframe id="meteo" src="https://api.wo-cloud.com/content/widget/?geoObjectKey=5350008&language=fr&region=FR&timeFormat=HH:mm&windUnit=kmh&systemOfMeasurement=metric&temperatureUnit=celsius" name="CW2" scrolling="no" width="290" height="318" frameborder="0" ></iframe>
            </div>
        </div>
        
    </body>
</table>
        </center>
        <?php require("./vue/footer/footer.tpl"); ?>
    </body>
    <script src="./vue/infocinema/infocinema.js"></script>
    </html>
