<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    require_once "autoload.php";
    session_start();

    if ($_SESSION['user']=='NULL') {
        echo 'La session est NULL';
        header("Location: connexion.php");
        exit(0);
    }

    $inscrits = new InscritsDAO(MaBD::getInstance());
    $tab = $inscrits->getAll();

    if (isset($_POST['submit'])) {
        $texte = $_POST['mail'];
        $title = $_POST['title'];

        $codehtml = 
        '<html><body>' 
            . $texte .
            '<br><footer>' .
            '<p><b>Si vous souhaitez se désabonné(e) des newsletters de Stephane Knopes,</b> ' . 
            '<i><a href="http://ugogallion.fr/test/unscribe.php">clique-ici</a></i></p><br>' .
            '<img src="http://ugogallion.fr/test/img/banniere.png" alt="bannière stephane knopes">' .
            '</footer></body></html>';

        $expediteur   = 'stephaneknopes@immobilier.com';
        $reponse      = $expediteur;

        foreach ($tab as $inscrit) { // Envoie à toute les personnes de la newsletter
            $destinataire = $inscrit->email;
            
            // Sending email to destination
            mail($destinataire,
                $title,
                $codehtml,
                "From: $expediteur\r\n".
                "Reply-To: $reponse\r\n".
                "Content-Type: text/html; charset=\"UTF-8\"\r\n"
            );
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Main properties -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Gestion du site | Newsletter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/fonts.css">
    </head>

    <body>
        <header>
            <h1 class ="titre">Saisir ce que vous voulez envoyez.</h1>
        </header>
        <main>
            <section class="deconnexion_container">
                <form action="connexion.php" method="post">
                    <input class="deconnexion" type=submit name="submit()" value="Déconnexion">
                </form>
                <?php
                    if (isset($_POST['submit'])) {
                        echo'<p class="validate"> <b>' . "Vous venez d'envoyer la news letter à vos contacts" . '</b></p>';
                    }
                ?>
            </section>
            
            <form id="formGestion" action="?" method="post">
                <input class="title" type="text" placeholder="En-tête du mail" name="title" required> <br>
                <textarea id="address" class="comment" name="mail" rows="9" cols="70" placeholder="Ecrivez le mail que vous voulez envoyer." required></textarea>
                <input class="button" type="submit" name="submit" size="35" value="Envoyez ce mail aux client inscrits"/>
            </form>
            
            <!-- Mettre du style dans notre mail -->
            <section>
                <button id="btn" onclick="actionPutTitle()">Mettre un titre</button>
                <button id="btn" onclick="actionUnderline()">Soulignez</button>
                <button id="btn" onclick="actionPutItalic()">Mettre en italic</button>
                <button id="btn" onclick="actionPutBold()">Mettre en gras</button>
                <button id="btn" onclick="actionPutLink()">Ajouter un lien</button> <br>
                <button id="couleurButtonYellow" onclick="actionPutYellowColor()">Couleur Jaune</button>
                <button id="couleurButtonGreen" onclick="actionPutGreenColor()">Couleur Verte</button>
                <button id="couleurButtonRed" onclick="actionPutRedColor()">Couleur Rouge</button>
                <button id="couleurButtonBlack" onclick="actionPutBlackColor()">Couleur Noire</button>
            </section>
            <section>
                <button class="views" onclick="actionView()">Visualiser le mail</button><br>
                <div id="actionView"></div>
            </section>
        </main>
        <footer>
            <section class="bas">
                <p>Réalisée par : Gallion Ugo - Groupe C2i</p> 
            </section>
        </footer>
    </body>
    <!-- Déplacement dans un fichier JS -->
    <script>
        // JavaScript

        /*
        * Action de rédaction
        */

        function actionUnderline() {
            document.getElementById('address').value += '<u>Ecrivez ici</u>';
        }

        function actionPutTitle() {
            document.getElementById('address').value += '<h1>Ecrivez un titre</h1>';
        }

        function actionPutItalic() {
            document.getElementById('address').value += '<i>Ecrivez en italic</i>';
        }

        function actionPutBold() {
            document.getElementById('address').value += '<b>Ecrivez en gras</b>';
        }

        function actionPutLink() {
            document.getElementById('address').value += '<a href="Votre lien ici !">Ajoutez un lien de redirection</a>';
        }

        function actionPutYellowColor() {
            document.getElementById('address').value += '<font color="yellow">Texte en jaune</font>';
        }

        function actionPutGreenColor() {
            document.getElementById('address').value += '<font color="green">Texte en vert</font>';
        }

        function actionPutRedColor() {
            document.getElementById('address').value += '<font color="red">Texte en rouge</font>';
        }

        function actionPutBlackColor() {
            document.getElementById('address').value += '<font color="black">Texte en noir</font>';
        }

        /**
         * Visualiser le mail
         */
        function actionView() {
            document.getElementById('actionView').innerHTML = document.getElementById('address').value;
        }

        window.onload = function() {
            var value = 0;
            var back_line = 13;
        
            window.onkeydown= function(gfg) {
                if(gfg.keyCode === back_line) {
                    document.getElementById('address').value += '<br>';
                };
            };
        };    
    </script>
</html>