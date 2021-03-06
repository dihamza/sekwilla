<?php
    session_start();
    if($_SESSION['authorisation'] != 'admin'){
        header('location:http://localhost:8888/sec/view/admin/login.php');
    }

    //require utilities (need of postDta function)
    require_once "../../../config/Utilities.php";

    //require class_ model
    require_once '../../../models/class_.php';

    //require Database class to get connect to database
    require_once '../../../config/Database.php';

    //collecting posted data
    $data = array();
    if (isset($_POST['class'])) {
        //collect data
        $data = array('name' => $_POST['niveau']);

        //Api url
        $api_url = 'http://localhost:8888/sec/api/class_/create.php';

        //response
        $res = postData($api_url, $data);
//        echo $res;

    }



    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //collect classes here to display them in select element
    //instantiate an object here
    $class = new Class_($conn);
    $classes = $class->getClasses()->fetchAll(PDO::FETCH_ASSOC);

    //create subject
    if (isset($_POST['subject'])) {
        //collect data
        $data = array('name' => $_POST['matiere'],
                      'class_id' => $_POST['class_id']
        );

        //Api url
        $api_url = 'http://localhost:8888/sec/api/subject/create.php';

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
                    <a href="../student/students.php" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> ??l??ves <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="../student/students.php"><img src="../icons/next.svg" alt="">Tous les ??l??ves</a></li>
                        <li><a href="../student/addStudent.php"><img src="../icons/next.svg" alt="">Ajouter un eleve</a></li>
                        <li><a href="../student/delete_update.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>

                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Classes <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="classes.php"><img src="../icons/next.svg" alt="">Tous les Niveaux</a></li>
                        <li><a href=""><img src="../icons/next.svg" alt="">Ajouter un niveau</a></li>
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
                        <p>D??connexion</p>
                    </a>
                </div>
            </div>
        </nav>
        <div class="m-container">
            <div class="form-container">
                <h1>Ajouter une matiere</h1>
                <form action="" method="POST">
                    <div>
                        <label for="matiere">Matiere*</label>
                        <input type="text" name="matiere" id="matiere" required>
                        <select name="class_id" id="class" required>
                            <option value=""  disabled selected> Niveau</option>
                            //iterate on classes
                            <?php foreach($classes as $option) {?>
                            <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <input type="button" value="Reintialiser" class="rei">
                    <input type="submit" name="subject" value="Modifier" class="enreg">
                </form>
            </div>
            <div class="form-container">
                <h1 id="h1">Ajouer un niveau</h1>
                <form action="" method="POST">
                    <div>
                        <label for="niveau">Niveau*</label>
                        <input type="text" name="niveau" id="niveau" class="niveau" required>
                    </div>
                    <input type="submit" name="class" value="Ajouter" class="enreg">
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