<?php

    $title = "Modifier VIP";
    include("../View/header.php");

    if(isset($_GET['idVip']))
    {
        $idVip = $_GET['idVip'];
        $donnees = $managerVip->getById($idVip);

        $idnpec = $donnees->getIdNpec();
        $idjury = $donnees->getIdJury();
        $prenomBase = $donnees->getPrenom();
        $nomBase = $donnees->getNom();
        $fonction = $donnees->getFonction();
        $photo = $donnees->getPhoto();
        $nationalite = $donnees->getNationalite();
        $coeff = $donnees->getCoeffImportance();
        $compagnon = $donnees->getCompagnon();
    }
    else
    {
        $idVip = null;
        $idnpec = null;
        $idjury = null;
        $prenomBase = null;
        $nomBase = null;
        $fonction = null;
        $photo = null;
        $nationalite = null;
        $coeff = null;
        $compagnon = null;
    }

    /*
    if (isset($_POST['Valider']))
    {
        
    }
    */

    if(isset($_POST['prenom']))
    {
        $prenom = (is_string($_POST['prenom']) && $_POST['prenom'] != '') ? $_POST['prenom'] : false;
        $nom = (is_string($_POST['nom']) && $_POST['nom'] != '') ? $_POST['nom'] : false;
        $fonction = (is_string($_POST['fonction']) && $_POST['fonction'] != '') ? $_POST['fonction'] : false;
        $nationalite = (is_string($_POST['nationalite']) && $_POST['nationalite'] != '') ? $_POST['nationalite'] : false;
        $compagnon = (is_string($_POST['compagnon']) && $_POST['compagnon'] != '') ? $_POST['compagnon'] : false;
        $coeffimortance = $_POST['coeff'];
        $npec = $_POST['npec'];
        @$film = $_POST['film'];
        @$filmSupp = $_POST['filmSupp'];

        if($prenom && $nom && $fonction && $nationalite && $compagnon && $coeffimortance && $npec && $film == null && $filmSupp == null)
        { 
            if (isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024) //Méga bytes
            {
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $ext_upload = $infosfichier['extension'];
                if (in_array($ext_upload, array('jpg','png', 'jpeg')))
                {
                    move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Photos/'.basename($_FILES['fichier']['name']));
                }
            }

            if(basename($_FILES['fichier']['name'])!='')
            {
                $photo = basename($_FILES['fichier']['name']);
            }

            if(($prenomBase != $prenom || $nomBase != $nom) && $managerVip->exist($prenom, $nom))
            {
                header("Location: ../View/edit_vip.php?erreur=1&idVip=".$idVip);
            }
            else
            {
                $newVip = new Vip([
                    'idvip' => $idVip,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'fonction' => $fonction,
                    'nationalite' => $nationalite,
                    'compagnon' => $compagnon,
                    'coeffimportance' => $coeffimortance,
                    'idnpec' => $npec,
                    'photo' => $photo
                ]);
    
                $managerVip->update($newVip);

                header("Location: ../View/details_vip.php?idVip=".$idVip);
            }
        }

        elseif ($prenom && $nom && $fonction && $nationalite && $compagnon && $coeffimortance && $npec && $film != null || $filmSupp != null)
        {
            if (isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024) //Méga bytes
            {
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $ext_upload = $infosfichier['extension'];
                if (in_array($ext_upload, array('jpg','png', 'jpeg')))
                {
                    move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Photos/'.basename($_FILES['fichier']['name']));
                }
            }

            if(basename($_FILES['fichier']['name'])!='')
            {
                $photo = basename($_FILES['fichier']['name']);
            }

            if(($prenomBase != $prenom || $nomBase != $nom) && $managerVip->exist($prenom, $nom))
            {
                header("Location: ../View/edit_vip.php?erreur=1&idVip=".$idVip);
            }
            else
            {
                $newVip = new Vip([
                    'idvip' => $idVip,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'fonction' => $fonction,
                    'nationalite' => $nationalite,
                    'compagnon' => $compagnon,
                    'coeffimportance' => $coeffimortance,
                    'idnpec' => $npec,
                    'photo' => $photo
                ]);
    
                $managerVip->update($newVip);
    
                if(isset($_POST['film']))
                {
                    foreach($film as $donnees)
                    {
                        $filmID = (int) $donnees;
    
                        if ($managerFilm->getById($filmID) != null)
                        {
                            $newCasting = new Casting([
                                'idfilm' => $filmID,
                                'idvip' => $idVip
                            ]);
                
                            $managerCasting->add($newCasting);
                        }
                    }
                }
    
                if (isset($_POST['filmSupp']))
                {
                    foreach($filmSupp as $donnees)
                    {
                        $filmSuppID = (int) $donnees;
    
                        if($managerFilm->getById($filmSuppID) != null)
                        {
                            $idCast = $managerCasting->getId($filmSuppID, $idVip);
    
                            $cast = new Casting([
                                'idcasting' => $idCast,
                                'idfilm' => $filmSuppID,
                                'idvip' => $idVip
                            ]);
                            
                            $managerCasting->delete($cast);
                        }   
                    }
                }

                header("Location: ../View/details_vip.php?idVip=".$idVip);
            }            
        }
    }
?>
        <div class="div">
            <form action="" method="post" enctype="multipart/form-data">
                <h1><b>Ajouter un vip :</b></h1>

                <p class="erreur">
                    <?php
                    if (isset($_GET['erreur'])) {
                        $err = $_GET['erreur'];
                        if ($err == 1) {
                            echo "Prenom et nom déjà existants";
                        }
                    }
                    ?>
                </p>


                <input type='text' name='prenom' placeholder="Prenom" value="<?php echo $prenomBase ?>" required>
                <input type='text' name='nom' placeholder="Nom" value="<?php echo $nomBase ?>" required>
                <input type='text' name='fonction' placeholder="Fonction" value="<?php echo $fonction ?>" required>
                <input type='text' name='nationalite' placeholder="Nationalite" value="<?php echo $nationalite ?>" required>
                <input type='text' name='compagnon' placeholder="Compagnon" value="<?php echo $compagnon ?>">
                <p>Coefficient d'imortance :</p>
                <?php 
                    switch($coeff) { 
                        case "1":
                ?>
                <select name="coeff" required>
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "2": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2" selected>2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "3": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3" selected>3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "4": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4" selected>4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "5": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5" selected>5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "6": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6" selected>6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "7": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7" selected>7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "8": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8" selected>8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "9": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9" selected>9</option>
                    <option value="10">10</option>
                </select>
                <?php 
                    break;
                    case "10": 
                ?>
                <select name="coeff" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10" selected>10</option>
                </select>
                <?php
                    break;
                    }
                ?>
                <p class="mt-2">Niveau de prise en charge :</p>
                <?php $libellenpec = $managerPriseEnCharge->getById($idnpec)->getLibelle() ?>
                <select name='npec' required>
                    <?php
                        $donnees = $managerPriseEnCharge->getNpecs();
                    ?>
                    <option value="<?php echo $idnpec ?>"><?php echo $idnpec.' - '.$libellenpec ?></option>
                    <option value="" disabled></option>
                    <?php
                        foreach($donnees as $npec)
                        {
                    ?>
                            <option value="<?php echo $npec['idnpec']?>"><?php echo $npec['idnpec'].' - '.$npec['libelle'] ?></option>
                    <?php
                        }
                    ?>
                </select>
                <p class="mt-2">Ajouter un ou plusieurs film(s) au vip :</p>
                <select name='film[]' multiple>
                    <option value=""></option>;
                    <?php
                        $films = $managerFilm->getFilms();
                        $films_vip = array();
                        $donnees = $managerFilm->getFilmsVip($idVip);

                        foreach($donnees as $da)
                        {
                            $films_vip[] = $da['idfilm'];
                        }

                        foreach($films as $film)
                        {
                            if(in_array($film['idfilm'], $films_vip) == false)
                            {
                            ?>
                                <option value="<?php echo $film['idfilm']?>"><?php echo $film['idfilm'].' - '.$film['titre'] ?></option>
                            <?php
                            }
                        }
                    ?>  
                </select>
                <p class="mt-2">Supprimer un ou plusieurs film(s) au vip :</p>
                <select name='filmSupp[]' multiple>
                    <option value=""></option>;
                    <?php
                        $donnees = $managerFilm->getFilmsVip($idVip);

                        foreach($donnees as $film)
                        {
                    ?>
                        <option value="<?php echo $film['idfilm']?>"><?php echo $film['idfilm'].' - '.$film['titre'] ?></option>
                    <?php
                        }
                    ?>  
                </select>

                <p>Modifier la photo du vip :</p>
                <input type="hidden"  name="MAX_FILE_SIZE" value="1048576" />
                <input type="file" name="fichier" />

                <a href="../View/details_vip.php?idVip=<?php echo $idVip ?>"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>
                
                <br>
                
            </form>
        </div>
    </body>
</html>