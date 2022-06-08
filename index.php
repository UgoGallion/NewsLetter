<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    // Autochargement des classes
    require_once "autoload.php";

    $submitted = false;

    $mes = false;
    $validate = false;
    $noemail = true;
    $account_exist = false;

    $inscrits = new InscritsDAO(MaBD::getInstance());
    $tab = $inscrits->getAll();

    if (isset($_POST['submit'])) {
        $submitted = true;

        $checkNews = $_POST['check_news'];
        $email = $_POST['email'];

        if ($checkNews == "newsletter") {
            //echo '<p> Vous avez acceptez la news letter';
            if ($email == NULL || $email == '') {
                $noemail = true;
            } else { // Le compte email okay puis news letter okay aussi !
                // Vérification que le compte n'existe pas déjà !
                foreach ($tab as $inscrit) {
                    if ($inscrit->email == $email) {
                        $account_exist = true;
                        $noemail = false;
                    }
                } 

                if ($account_exist == false) { // Le compte n'existe pas donc inscription dans la BDD
                    $noemail = false;

                    // Direction la BDD
                    $inscrits->save(new Inscrit(-1, $email));

                    // Envoie d'un petit mail de confirmation
                    $destinataire = $email;
                    $expediteur   = 'stephaneknopes@immobilier.com';
                    $reponse      = $expediteur;
                    
                    // HTML coding for email
                    $codehtml=
                        '<html><body>'.
                        '<h1Confirmation de votre adhésion</h1>'.
                        '<b>Merci pour l' . "'" . 'intérêt que vous portez à notre égards.</b><br>'.
                        'Vous reçevrez toutes les informations à propos de l' . "'" . 'immobilier dans les prochains <u>mois</u>' .
                        '<br><footer>' .
                        '<p><b>Si vous souhaitez se désabonné(e) des newsletters de Stephane Knopes,</b> ' . 
                        '<i><a href="http://ugogallion.fr/test/unscribe.php">clique-ici</a></i></p><br>' .
                        '<img src="http://ugogallion.fr/test/img/banniere.png" alt="bannière stephane knopes">' .
                        '</footer></body></html>';
                        

                        // Send email
                        mail($destinataire,
                            'Mail de confirmation',
                            $codehtml,
                            "From: $expediteur\r\n".
                            "Reply-To: $reponse\r\n".
                           "Content-Type: text/html; charset=\"UTF-8\"\r\n");
                    // Affichage pour confirmer inscription.
                    $validate = true;
                }
            }
        } else {
            $mes = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Main properties -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ugo Gallion | Version Alpha</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/main.css">
    </head>

    <!-- Body software -->
    <body>
        <header>
            <h1>Gardons le contact ! </h1>
        </header>
        <main>
            <section>
                <?php
                    if ($submitted == true) {
                        if($mes == true && $noemail == true) {
                            echo'<p class="erreur">Merci de cochez la case (Acceptez les newsletter).</p>';
                        } else if ($mes == false && $noemail == true) {
                            echo'<p class="erreur">Veuillez saisir une adresse mail.</p>';
                        } else if ($mes == true && $noemail == false) {
                            echo'<p class="erreur">Merci de cochez la case (Acceptez les newsletter).</p>';
                        }
                    }
                ?>
            </section>
            <section class="container">
                <div class="item_form">
                    <form action="?" method="post">
                        <input type="checkbox" name="check_news" value="newsletter" /> <label class="Newsletter">En cochant cette case vous acceptez de reçevoir les prochaines annonces immobilière. </label><br>
                        <input type="email" name="email" size="40" placeholder="Saisir votre adresse-mail"/> <br>
                        <input class="button" type="submit" name="submit" size="30" value="Valider l'email"/>
                    </form>
                </div>
            </section>
            <section>
                <?php
                    if($validate == true) {
                        echo'<p class="validate">' . "Merci vous reçevrez dès maintenant les prochaines annonces immobilière." . '</p>';
                    }
                    if ($account_exist == true) {
                        echo'<p class="erreur">Votre compte a été déjà enregistrée !</p>';
                    }
                ?>
            </section>
        </main>
        <footer>
            <section class="bas">
                <p class="bottom">Site crée par Ugo Gallion © (2021-2022)</p>
            </section>
        </footer>
    </body>
</html>