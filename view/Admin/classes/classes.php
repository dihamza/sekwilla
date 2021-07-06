<?php

    session_start();
    if($_SESSION['authorisation'] != 'admin'){
        header('location:http://localhost:8888/sec/view/admin/login.php');
    }

    //require student class to instantiate an object
    require_once '../../../models/student.php';

    //require Database class to get connect to database
    require_once '../../../config/Database.php';

    $data = json_decode(file_get_contents("http://localhost:8888/sec/api/class_/getClasses.php"),TRUE);
//    var_dump($data);
    $nbr = sizeof($data);
    $i = 0;

    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //get subject instance here
    $student = new Student($conn);

    //get the number total of students
    $total = $student->getStudents()->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/classes.css">
    <link rel="stylesheet" href="../css/pers.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" >
    <title>CSS STYLE</title>
</head>
<body>
    <div class="container">
        <nav>
            <div class="tittle">
                <img src="../icons/graduation-hat 1.svg" alt="">
                <h2>ECOLE <br>SEKWILLA</h2>
            </div>
            <div class="nav_elements">
                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/home 1.svg" alt="" class="one"> Acceuille </a>
                </div>
                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Élèves <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="../student/students.php"><img src="icons/next.svg" alt="">Tous les élèves</a></li>
                        <li><a href="../student/addStudent.php"><img src="icons/next.svg" alt="">Ajouter un eleve</a></li>
                        <li><a href="../student/delete_update.php"><img src="icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>

                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Classes <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href=""><img src="../icons/next.svg" alt="">Tous les Niveaux</a></li>
                        <li><a href="add.php"><img src="../icons/next.svg" alt="">Ajouter un niveau</a></li>
                        <li><a href="delete_update.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>
                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Resultats <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="../results/results.php"><img src="../icons/next.svg" alt="">Resultats</a></li>
                        <li><a href="../results/add.php"><img src="../icons/next.svg" alt="">Ajouter</a></li>
                        <li><a href="../results/update_delete.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>
                <!-- <div class="element">
                    <a href="#" class="first_link"> <img src="icons/bell 1.svg" alt="" class="one"> Transport</a>
                </div>
                <div class="element">
                    <a href="#" class="first_link"> <img src="icons/bell 1.svg" alt="" class="one"> Notifier</a>
                </div> -->
            </div>
            <div class="action">
                <div class="profile">
                    <a href="#">
                        <img src="../icons/profile.svg" alt="">
                        <div>
                            <p><?php echo $_SESSION['lastname'] . " " . $_SESSION['firstname'] ?></p>
                        </div>
                    </a>
                </div>
                <div class="logout">
                    <a href="http://localhost:8888/sec/include/logout.php">
                        <img src="../icons/log-out 1.svg" alt="">
                        <p>Déconnexion</p>
                    </a>
                </div>
            </div>
        </nav>
        <div class="x-container">
            <div class="first-container totale-m">
                <h5 class="totale-head">Totale</h5>
                <div class="genders">
                    <h4 class="number-head"><?php echo $total; ?></h4>
                </div>
            </div>
            <div class="first-container">
                <?php
                    $end1 = 3;
                    for($i ; $i < $end1 && $i < $nbr ; $i++){
                ?>
                <div class="class-container">
                    <h1>
                        <?php
                            echo $data[$i]['name'];
                            $student->class_id = $data[$i]['id'];
                            $classTotal = $student->getStudentsInClass()->rowCount();
                            $male = $student->getGenderInClass('M')->rowCount();
                            $female = $student->getGenderInClass('F')->rowCount();
                        ?>
                    </h1>
                    <div class="genders">
                        <div class="gendre">
                            <h3>Male</h3>
                            <h4 class="number"><?php echo $male; ?></h4>
                        </div>
                        <div class="gendre">
                            <h3>Female</h3>
                            <h4 class="number"><?php echo $female; ?></h4>
                        </div>
                    </div>
                    <div class="totale">
                        <h3>Totale</h3>
                        <h4 class="number"><?php echo $classTotal; ?></h4>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="first-container">
                <?php
                $end1 = min($nbr-1,5);
                for($i ; $i <= $end1 && $i <= $nbr ; $i++){
                    ?>
                    <div class="class-container">
                        <h1>
                            <?php
                            echo $data[$i]['name'];
                            $student->class_id = $data[$i]['id'];
                            $classTotal = $student->getStudentsInClass()->rowCount();
                            $male = $student->getGenderInClass('M')->rowCount();
                            $female = $student->getGenderInClass('F')->rowCount();
                            ?>
                        </h1>
                        <div class="genders">
                            <div class="gendre">
                                <h3>Male</h3>
                                <h4 class="number"><?php echo $male; ?></h4>
                            </div>
                            <div class="gendre">
                                <h3>Female</h3>
                                <h4 class="number"><?php echo $female; ?></h4>
                            </div>
                        </div>
                        <div class="totale">
                            <h3>Totale</h3>
                            <h4 class="number"><?php echo $classTotal; ?></h4>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="per-info">
            <div class="per-img">
                <img src="../icons/man.svg" alt="">
            </div>
            <h2><?php echo $_SESSION['username']?></h2>
            <hr>
            <table>
                <tr>
                    <td>Name :</td>
                    <td><?php echo $_SESSION['lastname']?></td>
                </tr>
                <tr>
                    <td>Prenom :</td>
                    <td><?php echo $_SESSION['firstname']?></td>
                </tr>
                <tr>
                    <td>Genre :</td>
                    <td>Homme</td>
                </tr>
                <tr>
                    <td>Date de naissance :</td>
                    <td>Femme</td>
                </tr>
                <tr>
                    <td>Address :</td>
                    <td>Quariter #3,rue #42 ville #18</td>
                </tr>
                <tr>
                    <td>Telephone :</td>
                    <td>0606060606</td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><?php echo $_SESSION['email']?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>