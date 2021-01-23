<?php

if (isset($_POST['Valider'])) {
    header("Location: ../View/vip.php");
}

$title = "Ajouter vip";
include("../View/header.php");

if (isset($_POST['prenom'])) {
    $prenom = (is_string($_POST['prenom']) && $_POST['prenom'] != '') ? $_POST['prenom'] : false;
    $nom = (is_string($_POST['nom']) && $_POST['nom'] != '') ? $_POST['nom'] : false;
    $fonction = (is_string($_POST['fonction']) && $_POST['fonction'] != '') ? $_POST['fonction'] : false;
    $nationalite = (is_string($_POST['nationalite']) && $_POST['nationalite'] != '') ? $_POST['nationalite'] : false;
    $compagnon = (is_string($_POST['compagnon']) && $_POST['compagnon'] != '') ? $_POST['compagnon'] : false;
    $coeffimortance = $_POST['coeff'];
    $npec = $_POST['npec'];
    @$films = $_POST['film'];

    if ($prenom && $nom && $fonction && $nationalite && $coeffimortance && $npec && $films == null) {
        if (
            isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024
        ) //Méga bytes
        {
            $infosfichier = pathinfo($_FILES['fichier']['name']);
            $ext_upload = $infosfichier['extension'];
            if (in_array($ext_upload, array('jpg', 'png', 'jpeg'))) {
                move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Photos/' . basename($_FILES['fichier']['name']));
            }
        }

        $photo = basename($_FILES['fichier']['name']);

        if ($photo == '') {
            $photo = null;
        }

        if ($managerVip->exist($prenom, $nom) > 0) {
            header("Location: ../View/add_vip.php?erreur=1");
        } else {
            $newVip = new Vip([
                'prenom' => $prenom,
                'nom' => $nom,
                'fonction' => $fonction,
                'nationalite' => $nationalite,
                'compagnon' => $compagnon,
                'coeffimportance' => $coeffimortance,
                'idnpec' => $npec,
                'photo' => $photo
            ]);

            $managerVip->add($newVip);
        }
    } elseif ($prenom && $nom && $fonction && $nationalite && $coeffimortance && $npec && $films != null) {
        if (
            isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024
        ) //Méga bytes
        {
            $infosfichier = pathinfo($_FILES['fichier']['name']);
            $ext_upload = $infosfichier['extension'];
            if (in_array($ext_upload, array('jpg', 'png', 'jpeg'))) {
                move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Photos/' . basename($_FILES['fichier']['name']));
            }
        }

        $photo = basename($_FILES['fichier']['name']);

        if ($photo == '') {
            $photo = null;
        }

        if ($managerVip->exist($prenom, $nom) > 0) {
            header("Location: ../View/add_vip.php?erreur=1");
        } else {
            $newVip = new Vip([
                'prenom' => $prenom,
                'nom' => $nom,
                'fonction' => $fonction,
                'nationalite' => $nationalite,
                'compagnon' => $compagnon,
                'coeffimportance' => $coeffimortance,
                'idnpec' => $npec,
                'photo' => $photo
            ]);

            $managerVip->add($newVip);

            $id = $newVip->getIdVip();

            foreach ($films as $film) {
                $filmID = (int) $film;

                if ($managerFilm->getById($filmID) != null) {
                    $newCasting = new Casting([
                        'idfilm' => $filmID,
                        'idvip' => $id
                    ]);

                    $managerCasting->add($newCasting);
                }
            }
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

        <input type='text' name='prenom' placeholder="Prenom" required>
        <input type='text' name='nom' placeholder="Nom" required>
        <input type='text' name='fonction' placeholder="Fonction" required>
        <input type='text' name='nationalite' placeholder="Nationalite" required>
        <input type='text' name='compagnon' placeholder="Compagnon">
        <p>Coefficient d'imortance :</p>
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
            <option value="10">10</option>
        </select>
        <p>Niveau de prise en charge :</p>
        <select name='npec' required>
            <?php
            $donnees = $managerPriseEnCharge->getNpecs();

            foreach ($donnees as $npec) {
            ?>
                <option value="<?php echo $npec['idnpec'] ?>"><?php echo $npec['idnpec'] . ' - ' . $npec['libelle'] ?></option>
            <?php
            }
            ?>
        </select>
        <p>Ajouter un ou plusieurs film(s) au vip :</p>
        <select name='film[]' multiple>
            <option value="" disabled></option>;
            <?php
            $donnees = $managerFilm->getFilms();

            foreach ($donnees as $film) {
            ?>
                <option value="<?php echo $film['idfilm'] ?>"><?php echo $film['idfilm'] . ' - ' . $film['titre'] ?></option>
            <?php
            }
            ?>
        </select>

        <p>Ajouter une photo au vip :</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input type="file" name="fichier" />

        <a href="../View/vip.php"><input type="button" value="Retour"></a>
        <input type='submit' name='Valider' value='Valider'>

        <br>

    </form>
</div>
</body>

</html>