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
    if (isset($_POST['supprimer'])) {
        $data = [
            'username' => $_POST['username1']
        ];

        //Api url
        $api_url = 'http://localhost:8888/sec/api/student/delete.php';

        //response
        $res = postData($api_url, $data);
    //    echo $res;
    }

if(isset($_POST['modifier'])){
    //collect data
    $data = [
        'update_username' => $_POST['update_username'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'email' => $_POST['email'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'class_id' => $_POST['class_id']
//        'gender' => $_POST['gender'],
//        'birth' => $_POST['birth']
    ];

//    var_dump($data);
    //Api url
    $api_url = 'http://localhost:8888/sec/api/student/update.php';

    //response
    $res = postData($api_url, $data);
    echo $res;
}
    //connection to database
    $database = new Database();
    $conn = $database->getConnection();

    //collect classes here to display them in select element
    //instantiate an object here
    $class = new Class_($conn);
    $classes = $class->getClasses()->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/delete_update.css">
    <link rel="stylesheet" href="../css/pers.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" >
    <title>Modifier un eleve</title>
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
                        <li><a href="students.php"><img src="../icons/next.svg" alt="">Tous les élèves</a></li>
                        <li><a href="addStudent.php"><img src="../icons/next.svg" alt="">Ajouter un eleve</a></li>
                        <li><a href=""><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
                    </ul>
                </div>

                <div class="element">
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> Classes <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href="../classes/classes.php"><img src="../icons/next.svg" alt="">Tous les Niveaux</a></li>
                        <li><a href="../classes/add.php"><img src="../icons/next.svg" alt="">Ajouter un niveau</a></li>
                        <li><a href="../classes/delete_update.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>                    </ul>
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
                            <p><?php echo $_SESSION['lastname'] . " " . $_SESSION['firstname'] ?>/p>
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
            <div class="form-container">
                <h1>Modifier</h1>
                <form action="" method="POST">
                    <div>
                        <label for="update_username">À modifier*</label>
                        <input type="text" name="update_username" placeholder="Username" id="update_username" class="sensitive"  required>
                        <label for="lastname">Nom*</label>
                        <input type="text" name="lastname" id="lastname" required>
                        <label for="firstname">Prenom*</label>
                        <input type="text" name="firstname" id="firstname" required>
                        <select name="gender" id="gender" required>
                            <option value=""  disabled selected>Genre</option>
                            <option value="M">homme</option>
                            <option value="F">femme</option>
                        </select>
                    </div>
                    <div>
                        <label for="birthday">Date de naissance*</label>
                        <input type="date" name="birthday" id="birthday" required>
                        <select name="class_id" id="class" >
                            <option value=""  disabled selected> Niveau</option>
                            //iterate on classes
                            <?php foreach($classes as $option) {?>
                                <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                            <?php }?>
                        </select>

                        <label for="email">Email*</label>
                        <input type="email" name="email" id="email" required>
                        <label for="phone">Phone*</label>
                        <input type="text" name="phone" id="phone" required>
                    </div>
                    <div>
                        <label for="username">Username*</label>
                        <input type="text" name="username" id="username" class="sensitive"  required>
                        <label for="password">Password*</label>
                        <input type="password" name="password" id="password" class="sensitive" required>
                    </div>
    
                    <footer>
                        <input type="button" value="Reintialiser" class="rei">
                        <input type="submit" name="modifier" value="Mdifier" class="enreg">
                    </footer>
                </form>
            </div>
            <div class="form-container">
                <h1 id="h1">Supprimer</h1>
                <form action="" method="POST">
                    <div>
                        <label for="username1">Username*</label>
                        <input type="text" name="username1" id="username1" style="width:97%;" class="sensitive"required>
                    </div>
                    <input type="submit" name="supprimer" value="supprimer" class="enreg">
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