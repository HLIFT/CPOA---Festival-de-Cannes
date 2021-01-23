<?php

    include("../View/header.php");

    if(isset($_GET["modif"]))
    {
        $modif = $_GET["modif"];

        if($isConnect == true)
        {
            if($modif == "add_vip")
            {
                header("location:../View/add_vip.php");
            }

            else if($modif == "deconnexion")
            {
                header("location: ../View/confirm_deco.php");
            }

            else if($modif == "liste_vip")
            {
                header("location: ../View/vip.php");
            }

            else if($modif == "add_staff")
            {
                if($user == "admin")
                {
                    header("location: ../View/add_staff.php");
                }
                else
                {
                    header("location:../View/impossible.php");
                }
            }

            if(isset($_GET["idVip"]))
            {
                $idVip = $_GET["idVip"];

                if($modif == "detail_vip")
                {
                    header("location:../View/details_vip.php?idVip=".$idVip);
                }

                else if($modif == "add_echange")
                {
                    header("location:../View/add_echange.php?idVip=".$idVip."&idStaff=".$idstaff);
                }

                else if($modif == "edit_vip")
                {
                    if($user == "admin")
                    {
                        header("location: ../View/edit_vip.php?idVip=".$idVip);
                    }
                    else
                    {
                        header("location:../View/impossible.php");
                    }
                }
            }

            if(isset($_GET["idEchange"]))
            {
                $idEchange = $_GET["idEchange"];

                if($modif == "edit_echange")
                {
                    header("location:../View/edit_echange.php?idEchange=".$idEchange);
                }
            }
        }

        else
        {
            header("location:../View/impossible.php");
        }
    }

?>