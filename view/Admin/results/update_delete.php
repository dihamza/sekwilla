<?php
session_start();
if($_SESSION['authorisation'] != 'admin'){
    header('location:http://localhost:8888/sec/view/admin/login.php');
}

//require utilities (need of postDta function)
require_once "../../../config/Utilities.php";

//require class_ model
require_once '../../../models/student.php';

//require subject model
require_once '../../../models/subject.php';

//require Database class to get connect to database
require_once '../../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//collect classes here to display them in select element
//instantiate an object here
$subject = new Subject($conn);
$subjects = $subject->getSubjects()->fetchAll(PDO::FETCH_ASSOC);

//collecting posted data
$data = array();
if (isset($_POST['subject'])) {
    //collect data
    //get id by username
    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //collect classes here to display them in select element
    //instantiate an object here
    $id = Student::getIdByUsername($_POST['username'], $conn)[0]['id'];

    $data = array('insertIn' => $_POST['mark'],
        'subject_id' => $_POST['subject_id'],
        'student_id' => $id,
        'mark' => $_POST['note']);

    //Api url
    $api_url = 'http://localhost:8888/sec/api/mark/update.php';

    //response
    $res = postData($api_url, $data);
}


if (isset($_POST['delete'])) {
    //collect data
    //get id by username
    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //collect classes here to display them in select element
    //instantiate an object here
    $id = Student::getIdByUsername($_POST['username'], $conn)[0]['id'];

    $data = array('subject_id' => $_POST['subject_id'],
                    'student_id' => $id);

    //Api url
    $api_url = 'http://localhost:8888/sec/api/mark/delete.php';

    //response
    $res = postData($api_url, $data);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/add_class_subject.css">
    <link rel="stylesheet" href="../css/pers.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" >
    <title>Modifier resultas</title>
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
                    <li><a href="results.php"><img src="../icons/next.svg" alt="">Resultats</a></li>
                    <li><a href="add.php"><img src="../icons/next.svg" alt="">Ajouter</a></li>
                    <li><a href=""><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
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
                <a href="http://localhost:8888/sec/include/logout.php">
                    <img src="../icons/profile.svg" alt="">
                    <div>
                        <p><?php echo $_SESSION['lastname'] . " " . $_SESSION['firstname'] ?></p>
                        <p><?php echo $_SESSION['username']?></p>
                    </div>
                </a>
            </div>
            <div class="logout">
                <a href="#">
                    <img src="../icons/log-out 1.svg" alt="">
                    <p>Déconnexion</p>
                </a>
            </div>
        </div>
    </nav>
    <div class="m-container">
        <div class="form-container">
            <h1>Ajouter une Note</h1>
            <form action="" method="POST">
                <div>
                    <select name="subject_id" id="subject_id" required>
                        <option value=""  disabled selected>Matiere</option>
                        //iterate on classes
                        <?php foreach($subjects as $option) {?>
                            <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                        <?php }?>
                    </select>
                    <select name="mark" id="class" required>
                        <option value=""  disabled selected>Examen:</option>
                        <option value="mark1">Le premier examen</option>
                        <option value="mark2">Le deuxieme examen</option>
                        <option value="mark3">Le troisieme examen</option>
                        <option value="mark4">Le quatrieme examen</option>
                        <option value="mark5">Assiduité</option>

                    </select>
                </div>
                <div>
                    <label for="username">Username*</label>
                    <input type="text" name="username" id="username" required>
                    <label for="note">Note*</label>
                    <input type="text" name="note" id="note" required>
                </div>
                <div>
                    <input type="button" value="Reintialiser" class="rei">
                    <input type="submit" name="subject" value="Ajouter" class="enreg">
                </div>
            </form>
        </div>
        <div class="form-container">
            <h1>Supprimer</h1>
            <form action="" method="POST">
                <div class="no-margin">
                    <select name="subject_id" id="subject_id" required>
                        <option value=""  disabled selected>Matiere</option>
                        //iterate on subjects
                        <?php foreach($subjects as $option) {?>
                            <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                        <?php }?>
                    </select>
                    <input type="text" name="username" id="username" placeholder="Username" required />
                    <input type="submit" name="delete" value="Supprimer" class="enreg small">

                </div>
            </form>
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