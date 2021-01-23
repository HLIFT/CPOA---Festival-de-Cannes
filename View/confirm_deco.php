<?php
    $title = "Déconnexion";
    include("../View/header.php");

    if (isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];
    }
?>

    <p class="message"><b>Voulez-vous vraiment vous déconnecter ?</b></p>
        <div class="div2">
            <div class="deco">
                <br>
                <b>Utilisateur :</b> <?php echo $user ?><br>
                <br>
                <a href="../index.php"><input type="button" value="Annuler"></a><a href="../View/logout.php"><input type="button" value="Déconnexion"></a>
            </div>
        </div>
    </body>
</html>

