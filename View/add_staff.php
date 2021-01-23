<?php
    $title = "Nouvel utilisateur";
    include("../View/header.php");

    @$prenom=$_POST["prenom"];
    @$nom=$_POST["nom"];
    @$fonction=$_POST["fonction"];
    @$login=$_POST["login"];
    @$pass=$_POST["pass"];
    @$repass=$_POST["repass"];
    @$valider=$_POST["valider"];

    if(isset($valider)){
        if($pass!=$repass) header("location:../View/add_staff.php?erreur=1");
        else
        {
            if (isset($_GET['erreur']))
            {
                if(($id = $managerStaff->getId($login))>0)
                {
                    header("location:../View/add_staff.php?erreur=2");
                }

                else
                {
                    $pass = password_hash($pass, PASSWORD_DEFAULT);

                    $newStaff = new Staff([
                        'prenom' => $prenom,
                        'nom' => $nom,
                        'fonction' => $fonction,
                        'login' => $login,
                        'password' => $pass
                    ]);
        
                    $managerStaff->add($newStaff);

                    header("location:../View/staff.php?idUser=".$idstaff);
                }
            }

            else
            {
                if(($id = $managerStaff->getId($login))>0)
                {
                    header("location:../View/add_staff.php?erreur=2");
                }
    
                else
                {
                    $pass = password_hash($pass, PASSWORD_DEFAULT);
                    
                    $newStaff = new Staff([
                        'prenom' => $prenom,
                        'nom' => $nom,
                        'fonction' => $fonction,
                        'login' => $login,
                        'password' => $pass
                    ]);

                    $managerStaff->add($newStaff);
                    
                    header("location:../View/staff.php?idUser=".$idstaff);
                }   
            } 
        }
    }
?>
      <div class="div">
            <form method="post" action="">
                <h1>Inscription</h1>
                <p class="erreur">
                    <?php
                        if (isset($_GET['erreur']))
                        {
                            $err = $_GET['erreur'];
                            if($err == 1)
                            {
                                echo "Les mots de passe sont différents";
                            }
                            else if($err == 2)
                            {
                                echo "Le login est déjà prit";
                            }
                        }
                    ?>
                </p>
                <input type="text" name="prenom" placeholder="Prenom" required/><br />
                <input type="text" name="nom" placeholder="Nom" required/><br />
                <input type="text" name="fonction" placeholder="Fonction" required/><br />
                <input type="text" name="login" placeholder="Login" required/><br />
                <input type="password" name="pass" placeholder="Mot de passe" required/><br />
                <input type="password" name="repass" placeholder="Confirmer Mot de passe" required/><br />
                <a href="../View/staff.php?idUser=<?php echo $idstaff ?>"><input type="button" value="Retour"/></a>
                <input type="submit" name="valider" value="Valider" />
            </form>
        </div>
   </body>
</html>
