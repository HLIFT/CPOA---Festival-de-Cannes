<?php

    $title = "Détails VIP";
    include("../View/header.php");

    if (isset($_GET['idVip']))
    {
        $idvip = $_GET['idVip'];
        $donnees = $managerVip->getById($idvip);

        $prenom = $donnees->getPrenom();
        $nom = $donnees->getNom();
        $fonction = $donnees->getFonction();
        $nationalite = $donnees->getNationalite();
        $compagnon = $donnees->getCompagnon();
        $photo = $donnees->getPhoto();
        $coeff = $donnees->getCoeffImportance();
        $idnpec = $donnees->getIdNpec();
        $idjury = $donnees->getIdJury();
    }
    else
    {
        $idvip = null;
        $prenom = null;
        $nom = null;
        $fonction = null;
        $nationalite = null;
        $compagnon = null;
        $photo = null;
        $coeff = null;
        $idnpec = null;
        $idjury = null;
    }

?>
    <div class="container">
        <div class="detail">
            <div class="profil">
                <?php $src = '../Style/Photos/'.$photo?>
                <img src="<?php echo $src ?>" alt="Photo profil" class = "img-profil"/>
            </div>
            <div class="infos">
                <?php
                $npec = $managerPriseEnCharge->getById($idnpec);
                if($idjury == null)
                {
                    $jury = 'Non';
                }
                else
                {
                    $jury = $managerJury->getById($idjury)->getLibelle();
                }

                echo '<b>'.$prenom.' '.$nom.'</b><br>';
                echo 'Fonction : '.$fonction.'<br>';
                echo 'Nationalite : '.$nationalite.'<br>';
                echo 'Importance : '.$coeff.'<br>';
                echo 'Prise en charge : '.$npec->getLibelle().'<br>';
                echo 'Compagnon : '.$compagnon.'<br>'; 
                echo 'Jury : '.$jury.'<br>';      
                ?>
            </div>
        </div>
        <div class="echange">
            <p>Echanges</p>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle">ID Echange</th>
                        <th class="align-middle">ID Vip</th>
                        <th class="align-middle">ID Staff</th>
                        <th class="align-middle">Moyen de communication</th>
                        <th class="align-middle">Date</th>
                        <th class="align-middle">Heure</th>
                        <th class="align-middle">Contenu</th>
                        <th class="align-middle">Demande spéciale</th>
                        <th class="align-middle">Traitée</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $donneesEchange = $managerEchange->getEchangesWithVip($idvip);

                        foreach ($donneesEchange as $echange)
                        {
                            $idEchange = $echange['idechange'];

                            $donneesRelation = $managerRelation->getActionWithEchange($idEchange);
                            echo '<tr>';
                            echo '<td class="align-middle">'.$echange['idechange'].'</td>';
                            echo '<td class="align-middle">'.$echange['idvip'].'</td>';
                            echo '<td class="align-middle">'.$echange['idstaff'].'</td>';
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
                            echo '<tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="../View/vip.php"><input type="button" value="Retour"></a>
        <a href = "session.php?idVip=<?php echo $idvip?>&idStaff=<?php echo $idstaff ?>&modif=add_echange"><input type = "button" value = "Ajouter échange"></a>
        <?php 
            if($user == 'admin')
            {
                echo '<a href = "session.php?idVip='.$idvip.'&modif=edit_vip"><input type = "button" value = "Modifier VIP"></a>';
            }
        
        ?>
    </div>
</body>
</html>