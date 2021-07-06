<?php
    session_start();
    if($_SESSION['authorisation'] != 'admin'){
        header('location:http://localhost:8888/sec/view/admin/login.php');
    }

//require postCurl function file
    require_once "../../../include/postCurl.php";
    //require Database class to get connect to database
    require_once '../../../config/Database.php';
    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //require models
    require_once "../../../models/student.php";
    require_once "../../../models/subject.php";
    require_once "../../../models/mark.php";

    //instantiate
    $student = new Student($conn);
    $subject = new Subject($conn);
    //    $Mark = new Mark($conn);
    if(isset($_GET['submit'])) {
        $student->username = $_GET['username'];
    }

    $class_id = $student->getClassIdByUsername($student->username)[0]['class_id'];
    $id = $student->getIdByUsername($student->username)['0']['id'];
    $subjects = $subject->getSubjectsInClass($class_id);

    $subjects_marks = array();
    foreach($subjects as $sub){
        $data = array(
            'subject_id' => $sub['id'],
            'student_id' => $id
        );
        $api_url = "http://localhost:8888/sec/api/mark/getStudentMarks.php";
        $res = postData($api_url, $data);

        $subjects_marks = array_merge($subjects_marks, array(
            $sub['name'] => json_decode($res,TRUE)
        ));
    }

    $keys = array_keys($subjects_marks);

//        echo '<pre>';
//        var_dump($subjects_marks);
//        echo '</pre>';

    $i = 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>suivi de notes</title>
    <link rel="icon" href="images/profile.svg">
    <link rel="stylesheet" type="text/css" href="../css/result.css">
    <link rel="stylesheet" href="../css/pers.css">
    <link rel="stylesheet" href="../css/nav.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body>
    <div class="main-container">
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
                    <a href="../student/students.php" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Élèves <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="../student/students.php"><img src="../icons/next.svg" alt="">Tous les élèves</a></li>
                        <li><a href="../student/addStudent.php"><img src="../icons/next.svg" alt="">Ajouter un eleve</a></li>
                        <li><a href="../student/delete_update.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>

                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Classes <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="../classes/classes.php"><img src="../icons/next.svg" alt="">Tous les Niveaux</a></li>
                        <li><a href="../classes/add.php"><img src="../icons/next.svg" alt="">Ajouter un niveau</a></li>
                        <li><a href="../classes/delete_update.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>
                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Resultats <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href=""><img src="../icons/next.svg" alt="">Resultats</a></li>
                        <li><a href="add.php"><img src="../icons/next.svg" alt="">Ajouter</a></li>
                        <li><a href="update_delete.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>
            </div>
            <div class="action">
                <div class="profile">
                    <a href="#">
                        <img src="../icons/profile.svg" alt="">
                        <div>
                            <p><?php echo $_SESSION['lastname'] . " " . $_SESSION['firstname'] ?></p>
                            <p><?php echo $_SESSION['username']?></p>
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
        <div class="table-container">
            <section>
                <h1>Moyenne note</h1>
                <div class="bloc1">
                    <div><span></span></div>
                    <form method="get">
                        <input type="text" name="username" placeholder="Username">
                        <input type="submit" name="submit" value="search">
                    </form>
                </div>
                <div class="bloc2">
                    <aside>Moyenne note</aside>
                </div>
                <table class="t4">
                    <tr>
                        <td>Matiére</td>
                        <td>C1</td>
                        <td>C2</td>
                        <td>C3</td>
                        <td>C4</td>
                        <td>Activités</td>
                        <td>Ceofficent</td>
                    </tr>
                    <?php
                    foreach ($subjects_marks as $sub_mark){
                        ?>

                        <tr>
                            <td>
                                <?php
                                echo $keys[$i];
                                ?>
                            </td>
                            <td><?php echo array_key_exists('message', $sub_mark) ? ( "Pas encore") :  $sub_mark[0]['mark1'] ?></td>
                            <td><?php echo array_key_exists('message', $sub_mark) ? ( "Pas encore") :  $sub_mark[0]['mark2'] ?></td>
                            <td><?php echo array_key_exists('message', $sub_mark) ? ( "Pas encore") :  $sub_mark[0]['mark3'] ?></td>
                            <td><?php echo array_key_exists('message', $sub_mark) ? ( "Pas encore") :  $sub_mark[0]['mark4'] ?></td>
                            <td><?php echo array_key_exists('message', $sub_mark) ? ( "Pas encore") :  $sub_mark[0]['mark5'] ?></td>
                            <td><?php echo array_key_exists('message', $sub_mark) ? ( "Pas encore") :  $sub_mark[0]['coef'] ?></td>
                        </tr>
                        <?php $i++; } ?>
                </table>
            </section>
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
                    <td>05-05-2001</td>
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