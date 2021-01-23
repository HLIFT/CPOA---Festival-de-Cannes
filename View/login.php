<?php
    $title = "Connexion";
    include("../View/header.php");

    @$login=$_POST["login"];
    @$pass=($_POST["pass"]);
    @$valider=$_POST["valider"];
    
    if(isset($valider)){
        if(isset($_GET['erreur']))
        {
            if(($id = $managerStaff->getId($login))>0)
            {
                if(password_verify($pass, ($managerStaff->getById($id)->getPassword())))
                {
                    $_SESSION["user"]=$login;
                    $_SESSION["connected"]=true;
                    header("location:../index.php");
                }   
                else
                {
                    $isConnect=false;
                    header("location:../View/login.php?erreur=1");
                }
            }
        }
        else
        {
            if(($id = $managerStaff->getId($login))>0)
            {
                if(password_verify($pass, ($managerStaff->getById($id)->getPassword())))
                {
                    $_SESSION["user"]=$login;
                    $_SESSION["connected"]=true;
                    header("location:../index.php");
                }
                else
                {
                    $isConnect=false;
                    header("location:../View/login.php?erreur=1");
                }
            }
            else
            {
                $isConnect=false;
                header("location:../View/login.php?erreur=1");
            }
        }
        
    }
?>
        <div class="div">
            <form method="post" action="">
                <h1>Connexion</h1>
                <p class="erreur">
                    <?php
                        if (isset($_GET['erreur']))
                        {
                            $err = $_GET['erreur'];
                            if($err == 1)
                            {
                                echo "Nom d'utilisateur ou mot de passe incorrect";
                            }
                        }
                    ?>
                </p>
                <input type="text" name="login" placeholder="Nom d'utilisateur" required/><br />
                <input type="password" name="pass" placeholder="Mot de passe" required/><br />
                <input type="submit" name="valider" value="Se connecter" />
        </div>
   </body>
</html>
