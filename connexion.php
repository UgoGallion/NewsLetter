<?php
    // Chargement de toutes les classes
    require_once "autoload.php";

    session_start();

    $mes = false;
    $admin = new AdministrateurDAO(MaBD::getInstance());
    $_SESSION['user']='NULL';

    if (isset($_POST['submit'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user = $admin->check($login, $password);

        if ($user != null) {
            // Connexion réussi
            $_SESSION['user']=$user;
            header("Location: gestion.php");
            exit(0);
        } else {
            // Connexion échoué
            $mes = true;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="css/contacts.css"/>
        <title>Connexion | Gestion des newsletter</title>
    </head>
    <body>
        <!--En-tête -->
        <header>
            <h1 class ="titre">Attente identification</h1>
        </header>
        
        <?php
            if($mes == true) {
                echo'<p class="erreur">Mauvais identifiant</p>';
            }
        ?>
        
        <!-- Principale action -->
        <main>
            <form id="formLogin" action="?" method="post">
                <table>
                    <tr>
                        <td>Identifiant : </td>
                        <td><input type="text" name="login" size="20" value=""/></td>
                    </tr>
                    <tr>
                        <td>Mot de passe : </td>
                        <td><input type="password" name="password" size="20" value=""/></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="submit" value="Connexion"/></td>
                    </tr>
                </table>
            </form>
        </main>
        <!-- Bas de page -->
        <footer>
            <section class="bas">
                <p>Réalisée par : Gallion Ugo - Groupe C2i</p><br>
            </section>
            <p class="binome">En cas de problème technique contactez-moi : <a mailto="gallion.ugo.pro@gmail.com">gallion.ugo.pro@gmail.com</a></p>
        </footer>
    </body>
</html>
