<?php
    $title = "Vips";
    include("../View/header.php");
?>

<div class="div2">
            <h1><b>Liste des VIP :</b></h1>

            <div class="btn-align">
                <a href="../index.php"><input type="button" value="Accueil"></a>
                <a href="session.php?modif=add_vip"><input type="button" value="Ajouter un VIP"></a>
                <a href="../View/staff.php?idUser=<?php echo $idstaff ?>"><input type="button" value="Accéder à mes échanges"></a>
            </div>

            <table class="table table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Photo</th>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>Fonction</th>
                        <th>Nationalité</th>
                        <th>Coefficient d'importance</th>
                        <th>Niveau de prise en charge</th>
                        <th>Compagnon</th>
                        <th>Plus</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <?php
                        $donneesVip = $managerVip->getVips();

                        foreach ($donneesVip as $vip)
                        {
                            $donnees = $managerPriseEnCharge->getByID($vip['idnpec']);

                            $src = '../Style/Photos/'.$vip['photo'];

                            echo '<tr>';
                            echo '<td class="align-middle"><img src="'.$src.'" alt="photo" class ="img"/></td>';
                            echo '<td class="align-middle">'.$vip['prenom'].'</td>';
                            echo '<td class="align-middle">'.$vip['nom'].'</td>';
                            echo '<td class="align-middle">'.$vip['fonction'].'</td>';
                            echo '<td class="align-middle">'.$vip['nationalite'].'</td>';
                            echo '<td class="align-middle">'.$vip['coeffimportance'].'</td>';
                            

                            if ($donnees != null)
                            {
                                echo '<td class="align-middle">';
                                echo $donnees->getLibelle();
                                echo'</td>';
                            }
                            else
                            {
                                echo '<td></td>';
                            }

                            echo '<td class="align-middle">'.$vip['compagnon'].'</td>';
                            ?>
                            
                            <td class="align-middle">
                                <a href = "session.php?idVip=<?=$vip['idvip']?>&modif=detail_vip"><input type = "button" value = "Détails"></a>
                            </td>
                    <?php
                            echo '<tr>';
                        }
                    ?>
                </tbody>
            </table> 

            <div class="btn-align">
                <a href="../index.php"><input type="button" value="Accueil"></a>
                <a href="session.php?modif=add_vip"><input type="button" value="Ajouter un vip"></a>
                <a href="../View/staff.php?idUser=<?php echo $idstaff ?>"><input type="button" value="Accéder à mes échanges"></a>
            </div>
        </div>
    </body>
</html>