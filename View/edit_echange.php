<?php

    $title = "Ajouter échange";
    include("../View/header.php");

    if(isset($_GET['idEchange']))
    {
        $idEchange = $_GET['idEchange'];
        $donnees = $managerEchange->getByID($idEchange);

        $idVip = $donnees->getIdVip();
        $contenu = $donnees->getContenu();
        $date = $donnees->getDate();
        $heure = $donnees->getHeure();
        $moyCom = $donnees->getMoyCom();

        $actionExist = $managerRelation->actionExiste($idEchange);
        if($actionExist)
        {
            $donneesAction = $managerAction->getActionByEchange($donnees);
            $idAction = $donneesAction['idaction'];
            $action = $donneesAction['contenu'];
            $effectuee = $donneesAction['effectuee'];

            $Action = $managerAction->getByID($idAction);

            $donneesRelation = $managerRelation->getBy($donnees, $Action);
            foreach($donneesRelation as $relation)
            {
                $idRelation = $relation->getIdRelation();
            }
        }
        else
        {
            $idAction = null;
            $action = null;
            $effectuee = null;

            $idRelation = null;
        }
        

    }
    else
    {
        $idEchange = null;
        $idVip = null;
        $contenu = null;
        $date = null;
        $heure = null;
        $moyCom = null;

        $idAction = null;
        $action = null;
        $effectuee = null;

        $idRelation = null;
    }
    
    if (isset($_POST['Valider']))
    {
        header("Location: ../View/staff.php?idUser=".$idstaff);
    }

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
                'idechange' => $idEchange,
                'idvip' => $idVip,
                'idstaff' => $idstaff,
                'contenu' => $contenu,
                'date' => $date,
                'heure' => $heure,
                'moycom' => $moyCom
            ]);

            $managerEchange->update($newEchange);
        }

        elseif ($moyCom && $date && $heure && $contenu && $action)
        {

            $newEchange = new Echange([
                'idEchange' => $idEchange,
                'idvip' => $idVip,
                'idstaff' => $idstaff,
                'contenu' => $contenu,
                'date' => $date,
                'heure' => $heure,
                'moycom' => $moyCom
            ]);
            
            $managerEchange->update($newEchange);

            if($idAction != null)
            {
                $newAction = new Action([
                    'idaction' => $idAction,
                    'contenu' => $action,
                    'effectuee' => $effectuee
                ]);

                $managerAction->update($newAction);

                $newRelation = new Relation([
                    'idrelation' => $idRelation,
                    'idechange' => $idEchange,
                    'idaction' => $idAction
                ]);
    
                $managerRelation->update($newRelation);
            }
            else
            {
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

        
    }
?>
        <div class="div">
            <form action="" method="post">
                <h1><b>Modifier un échange :</b></h1>
                <?php
                $vip = $managerVip->getById($idVip);
                $vip = $vip->getPrenom()." ".$vip->getNom();
                ?>
                <p><b><i><?php echo $vip ?></i></b></p>
                <p>Moyen de Communication :</p>
                <?php 
                    switch($moyCom) { 
                        case "Telephone":
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>" selected>Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <?php 
                    break;
                    case "SMS": 
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>" selected>SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <?php 
                    break;
                    case "Mail": 
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>" selected>Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <?php 
                    break;
                    case "Oral": 
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>" selected>Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <?php 
                    break;
                    case "Fax": 
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>" selected>Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <?php 
                    break;
                    case "VisioConference": 
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>" selected>Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>">Courrier</option>
                </select>
                <?php 
                    break;
                    case "Courrier": 
                ?>
                <select name="moyCom" required >
                    <option value="<?php echo MoyenCommunication::Telephone?>">Téléphone</option>
                    <option value="<?php echo MoyenCommunication::SMS?>">SMS</option>
                    <option value="<?php echo MoyenCommunication::Mail?>">Mail</option>
                    <option value="<?php echo MoyenCommunication::Oral?>">Oral</option>
                    <option value="<?php echo MoyenCommunication::Fax?>">Fax</option>
                    <option value="<?php echo MoyenCommunication::VisioConference?>">Visio-conférence</option>
                    <option value="<?php echo MoyenCommunication::Courrier?>" selected>Courrier</option>
                </select>
                <?php
                    break;
                    }
                ?>
                <br>
                <br>
                <p>Date :</p>
                <input type='date' name='date' placeholder="Date" value="<?php echo $date ?>" required>
                <br>
                <p>Heure :</p>
                <input type='time' name='heure' placeholder="Heure" value="<?php echo $heure ?>"required> 
                <input type='text' name='contenu' placeholder="Contenu" value="<?php echo $contenu ?>" required>
                <input type='text' name='action' placeholder="Demande spéciale" value="<?php echo $action ?>">
                <p>Action effectuée ?</p>
                <?php if($effectuee == true) {?>
                <select name="effectuee" >
                    <option value="0"></option>
                    <option value="1" selected>Oui</option>
                    <option value="0">Non</option>
                </select>
                <?php } else {?>
                    <select name="effectuee" >
                    <option value="0"></option>
                    <option value="1" selected>Oui</option>
                    <option value="0" selected>Non</option>
                </select>
                <?php }?> 
                <a href="../View/staff.php?idUser=<?php echo $idstaff ?>"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>
                
                <br>
                
            </form>
        </div>
    </body>
</html>
