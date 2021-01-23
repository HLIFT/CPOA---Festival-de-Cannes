<?php
    $title = "Gestion du compte";
    include("../View/header.php");

    if (isset($_GET['idUser']))
    {
        $idUser = $_GET['idUser'];
        $donnees = $managerStaff->getByID($idUser);

        $login = $donnees->getLogin();
        $password = $donnees->getPassword();
        $prenom = $donnees->getPrenom();
        $nom = $donnees->getNom();
        $fonction = $donnees->getFonction();

    }
    else
    {
        $idUser = null;
        $login= null;
        $password = null;
        $prenom = null;
        $nom = null;
        $fonction = null;
    }
?>
        <p class="message"><b>Gestion du compte</b></p>

            <div class="deco">
                <br>
                <b>Utilisateur :</b> <?php echo $login ?><br>
                <br>
                <b>Mot de passe :</b> <a href="../View/change_mdp.php?idUser=<?php echo $idUser ?>"><input class="change-mdp" type="button" value="Changer Mot de Passe"></a>
                <br>
                <br>
                <b>Prenom :</b> <?php echo $prenom ?>
                <br>
                <b>Nom :</b> <?php echo $nom ?>
                <br>
                <b>Fonction :</b> <?php echo $fonction ?>
            </div>
            <div class="div2">
                <p><b>Vos échanges :</b></p>
                <br>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="align-middle">ID Echange</th>
                            <th class="align-middle">VIP</th>
                            <th class="align-middle">Moyen de Communication</th>
                            <th class="align-middle">Date</th>
                            <th class="align-middle">Heure</th>
                            <th class="align-middle">Contenu</th>
                            <th class="align-middle">Demande spéciale</th>
                            <th class="align-middle">Traitée</th>
                            <th class="align-middle">Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $donnees = $managerEchange->getEchangesWithStaff($idstaff);

                        foreach ($donnees as $echange)
                        {
                            $donnees = $managerVip->getVipInEchange($managerEchange->getByID($echange['idechange']));
                            $donneesRelation = $managerRelation->getActionWithEchange($echange['idechange']);

                            echo '<tr>';
                            echo '<td class="align-middle">'.$echange['idechange'].'</td>';
                            if ($donnees != null)
                            {
                                echo '<td class="align-middle">';

                                foreach($donnees as $vip)
                                {
                                    echo $vip->getPrenom().' '.$vip->getNom().'<br>';
                                }

                                echo'</td>';
                            }
                            else
                            {
                                echo '<td class="align-middle"></td>';
                            }
                            echo '<td class="align-middle">'.$echange['moycom'].'</td>';
                            echo '<td class="align-middle">'.$echange['date'].'</td>';
                            echo '<td class="align-middle">'.$echange['heure'].'</td>';
                            echo '<td class="align-middle">'.$echange['contenu'].'</td>';
                            echo '<td class="align-middle">';
                            foreach($donneesRelation as $relation)
                            {
                                $idAction = $relation['idaction'];
                                $action = $managerAction->getById($idAction);
                                echo $action->getContenu();
                            }
                            echo '</td>';
                            echo '<td class="align-middle">';
                            foreach($donneesRelation as $relation)
                            {
                                $idAction = $relation['idaction'];
                                $action = $managerAction->getById($idAction);
                                echo $action->getEffectuee();
                            }
                            echo '</td>';
                            echo '<td class="align-middle"><a href = "session.php?idEchange='.$echange['idechange'].'&modif=edit_echange"><input type = "button" value = "Modifier"></a></td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>

                <div class="btn-align">
                    <a href="../View/vip.php"><input type="button" value="Retour"></a>
                    <?php
                        if($user == 'admin')
                        {
                            echo "<a href='../View/session.php?modif=add_staff'><input type='button' value='Ajouter un nouvel utilisateur'></a>";
                        }
                    ?>
                </div>
            </div>
    </body>
</html>
