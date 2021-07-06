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

    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //collect classes here to display them in select element
    //instantiate an object here
    $class = new Class_($conn);
    $classes = $class->getClasses()->fetchAll(PDO::FETCH_ASSOC);

    //update subject
    $data = array();
    if (isset($_POST['mat-mod'])) {
        //collect data
        $data = array('nameAmod' => $_POST['modifier'],
            'name' => $_POST['subject'],
            'class_id' => $_POST['class_id']
        );

        //Api url
        $api_url = 'http://localhost:8888/sec/api/subject/update.php';

        //response
        $res = postData($api_url, $data);

    }
    //delete subject
    if (isset($_POST['mat-sup'])) {
        //collect data
        $data = array('name' => $_POST['subj']);

        //Api url
        $api_url = 'http://localhost:8888/sec/api/subject/delete.php';

        //response
        $res = postData($api_url, $data);

    }

    //update class name
    if (isset($_POST['mod-class'])) {
        //collect data
        $data = array('nameAmod' => $_POST['modifier'],
                        'name' => $_POST['class']);

        //Api url
        $api_url = 'http://localhost:8888/sec/api/class_/update.php';

        //response
        $res = postData($api_url, $data);
    }
    //delete subject
    if (isset($_POST['sup-class'])) {
        //collect data
        $data = array('name' => $_POST['class_name']);

        //Api url
        $api_url = 'http://localhost:8888/sec/api/class_/delete.php';

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
    <link rel="stylesheet" href="../css/delete_update_class.css">
    <link rel="stylesheet" href="../css/pers.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" >
    <title>Modifier une class</title>
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
                        <li><a href="classes.php"><img src="../icons/next.svg" alt="">Tous les Niveaux</a></li>
                        <li><a href="add.php"><img src="../icons/next.svg" alt="">Ajouter un niveau</a></li>
                        <li><a href=""><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
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
        <div class="m-container">
            <div class="vertical-container one">
                <h1>Matiere</h1>
                <div class="form-container subject oone">
                    <h1>Modifier</h1>
                    <form action="" method="post">
                        <div>
                            <label for="modifier">À modifier*</label>
                            <input type="text" name="modifier" id="modifier" class="sensitive" required>
                            <label for="subject">Matiere*</label>
                            <input type="text" name="subject" id="subject" required>
                            <select name="class_id" id="class_id" required>
                                <option value=""  disabled selected> Niveau</option>
                                //iterate on classes
                                <?php foreach($classes as $option) {?>
                                    <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <input type="submit" name="mat-mod" value="Modifier" class="enreg">
                    </form>
                </div>
                <div class="form-container otwo">
                    <h1 id="h1">Suprrimer</h1>
                    <form action="" method="POST">
                        <div>
                            <label for="subj">Matiere*</label>
                            <input type="text" name="subj" id="subj" class="subj" required>
                        </div>
                        <input type="submit" name="mat-sup" value="Supprimer" class="enreg">
                    </form>
                </div>
            </div>
            <div class="vertical-container two">
                <h1>Niveau</h1>
                <div class="form-container subject tone">
                    <h1>Modifier</h1>
                    <form action="" method="POST">
                        <div>
                            <label for="modifier">A modifier</label>
                            <input type="text" name="modifier" id="modifier" required>
                            <label for="class">Niveau*</label>
                            <input type="text" name="class" id="class" required>
                        </div>
                        <input type="submit" name="mod-class" value="Modifier" class="enreg">
                    </form>
                </div>
                <div class="form-container ttwo">
                    <h1 id="h1">Supprimer</h1>
                    <form action="" method="post">
                        <div>
                            <label for="niveau">Niveau*</label>
                            <input type="text" name="class_name"  id="class_name" class="class_name" required>
                        </div>
                        <input type="submit" name="sup-class" value="Supprimer" class="enreg">
                    </form>
                </div>
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