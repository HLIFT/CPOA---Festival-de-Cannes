<?php

    if (isset($_GET['idVip']))
    {
        $idvip = $_GET['idVip'];
    }
    
    if (isset($_POST['Valider']))
    {
        header("Location: ../View/session.php?idVip=".$idvip."&modif=detail_vip");
    }

    $title = "Ajouter échange";
    include("../View/header.php");


    if(isset($_POST['moyCom']))
    {
        $moyCom = $_POST["moyCom"];
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $contenu = (is_string($_POST['contenu']) && $_POST['contenu'] != '') ? $_POST['contenu'] : false;
        $action = (is_string($_POST['action']) && $_POST['action'] != '') ? $_POST['action'] : false;
        $effectuee = $_POST["effectuee"];

        if($moyCom && $date && $heure && $contenu && $action == false)
        { 
            $newEchange = new Echange([
                'idvip' => $idvip,
                'idstaff' => $idstaff,
                'contenu' => $contenu,
                'date' => $date,
                'heure' => $heure,
                'moycom' => $moyCom
            ]);

            $managerEchange->add($newEchange);
        }

        elseif ($moyCom && $date && $heure && $contenu && $action)
        {

            $newEchange = new Echange([
                'idvip' => $idvip,
                'idstaff' => $idstaff,
                'contenu' => $contenu,
                'date' => $date,
                'heure' => $heure,
                'moycom' => $moyCom
            ]);

            $managerEchange->add($newEchange);

            $idEchange = $newEchange->getIdEchange();

            $newAction = new Action([
                'contenu' => $action,
                'effectuee' => $effectuee
            ]);

            $managerAction->add($newAction);


            $idAction = $newAction->getIdAction();

            $newRelation = new Relation([
                'idechange' => $idEchange,
                'idaction' => $idAction
            ]);

            $managerRelation->add($newRelation);
        }

        
    }
?>
        <div class="div">
            <form action="" method="post">
                <h1><b>Ajouter un échange :</b></h1>
                <?php
                $vip = $managerVip->getById($idvip);
                $vip = $vip->getPrenom()." ".$vip->getNom();
                ?>
                <p><b><i><?php echo $vip ?></i></b></p>
                <p>Moyen de Communication :</p>
                <select name="moyCom" required>
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <br>
                <br>
                <p>Date :</p>
                <input type='date' name='date' placeholder="Date" value="<?php echo date('Y-m-d') ?>" required>
                <br>
                <p>Heure :</p>
                <input type='time' name='heure' placeholder="Heure" required> 
                <input type='text' name='contenu' placeholder="Contenu" required>
                <input type='text' name='action' placeholder="Demande spéciale">
                <p>Action effectuée ?</p>
                <select name="effectuee" >
                    <option value="0"></option>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
                <a href="../View/session.php?idVip=<?php echo $idvip ?>&modif=detail_vip"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>
                
                <br>
                
            </form>
        </div>
    </body>
</html>
