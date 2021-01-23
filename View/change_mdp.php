<?php
    $title = "Changer mot de passe";
    include("../View/header.php");

    @$pass=$_POST["pass"];
    @$repass=$_POST["repass"];
    @$valider=$_POST["valider"];
    @$a_pass=$_POST["a_pass"];

    if(isset($_GET['idUser']))
    {
        $idUser = $_GET['idUser'];
        $donnees = $managerStaff->getById($idUser);

        $login = $donnees->getLogin();
        $password = $donnees->getPassword();
    }
    else
    {
        $idUser = null;
        $login = null;
        $password = null;
    }

    if(isset($valider)){
        if($pass != $repass) header("location:../View/change_mdp.php?erreur=1&idUser=".$idUser);
        else
        {
            if(isset($_GET['erreur']))
            {
                if(!password_verify($a_pass, $password))
                {   
                    header("location:../View/change_mdp.php?erreur=2&idUser=".$idUser);
                }
                else
                {
                    $newStaff = new Staff([
                        'idstaff' => $idUser,
                        'login' => $login,
                        'password' => password_hash($pass, PASSWORD_DEFAULT)   
                    ]);
        
                    $managerStaff->update($newStaff);
                    
                    header("location:../View/staff.php?idUser=".$idUser);
                }

            }
            else
            {
                if($a_pass != $password)
                {   
                    header("location:../View/change_mdp.php?erreur=2&idUser=".$idUser);
                }
                else
                {
                    $newStaff = new Staff([
                        'idstaff' => $idUser,
                        'login' => $login,
                        'password' => password_hash($pass, PASSWORD_DEFAULT)
                    ]);
        
                    $managerStaff->update($newStaff);
                    
                    header("location:../View/staff.php?idUser=".$idUser);
                }
                
            }
        }       
    }
?>
      <div class="div">
            <form method="post" action="">
                <h1>Changer Mot de Passe</h1>
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
                                echo "Votre ancien mot de passe est incorrect";
                            }
                        }
                    ?>
                </p>
                <input type="password" name="a_pass" placeholder="Ancien mot de passe" required/><br />
                <input type="password" name="pass" placeholder="Nouveau Mot de passe" required/><br />
                <input type="password" name="repass" placeholder="Confirmer Nouveau Mot de passe" required/><br />
               

                <a href="../View/staff.php?idUser=<?php echo $idUser ?>"><input type="button" value="Annuler"></a>
                <input type="submit" name="valider" value="Changer mot de passe" />
            </form>
        </div>
   </body>
</html>
