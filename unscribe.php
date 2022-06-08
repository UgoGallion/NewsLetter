<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    require_once "autoload.php";

    $inscrits = new InscritsDAO(MaBD::getInstance());

    $submitted = false;
    $validate = false;
    $noemail = true;
    $tab = $inscrits->getAll();

    if (isset($_POST['submit'])) { // Submitted !
        $email = $_POST['email'];
        $submitted = true;

        foreach ($tab as $inscrit) {
            if ($inscrit->email == $email) {
                $noemail = false;
                // Check account into BDD
                $inscrits->delete($inscrit);
                $validate = true;
            } else {
                $noemail = true;
                $validate = false;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Main properties -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ugo Gallion | Se désabonné(e)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/main.css">
    </head>

    <!-- Body software -->
    <body>
        <header>
            <h1>Procédure pour se désabonné(e)</h1>
        </header>
        <main>
            <section>
                <?php
                    if ($submitted == true) {
                        if ($noemail == true) {
                            echo'<p class="erreur">Cette adresse mail n' . "'" . 'existe pas.'.'</p>';
                        }
                    }
                ?>
            </section>
            <section class="container">
                <div class="item_form">
                    <form action="?" method="post">
                        <input type="email" name="email" size="40" placeholder="Saisir votre adresse-mail"/> <br>
                        <input class="button" type="submit" name="submit" size="30" value="Se désabonné(e)"/>
                    </form>
                </div>
            </section>
            <section>
                <?php
                    if($validate == true) {
                        echo'<p class="validate">' . "Vous êtes désabonné(e) de toutes les newsletters provenant de Stephane Knopes." . '</p>';
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