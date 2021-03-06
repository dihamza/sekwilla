<?php
    session_start();
    if($_SESSION['authorisation'] != 'admin'){
        header('location:http://localhost:8888/sec/view/admin/login.php');
    }
    //require class_ model
    require_once '../../../models/class_.php';

    //require Database class to get connect to database
    require_once '../../../config/Database.php';

    //require utilities (need of postDta function)
    require_once "../../../config/Utilities.php";

    $getData = json_decode(file_get_contents("http://localhost:8888/sec/api/student/read.php"),TRUE);
    $nbr = sizeof($getData);
    $counter = 0;
    $i = 0;

    //connection to database

    $database = new Database();
    $conn = $database->getConnection();

    //collect classes here to display them in select element
    //instantiate an object here
    $class = new Class_($conn);
    $classes = $class->getClasses()->fetchAll(PDO::FETCH_ASSOC);

    //controlle next-previous
    if(isset($_GET['next'])){
        $counter = $counter + 15;
        $i = $i + 15;
    }

    if(isset($_GET['previous']) && $i > 0){
        $counter = $counter - 15;
        $i = $i - 15;
    }

    //controll search with classes

    if(isset($_POST['search']) && !empty($_POST['username'])){
        //collect data
        $data = array('username' => $_POST['username']);

        //Api url
        $api_url = 'http://localhost:8888/sec/api/student/getStudent.php';

        //response
        $res = postData($api_url, $data);

        $getData = json_decode($res, TRUE);
        array_key_exists('message', $getData) ? $nbr = 0 : $nbr = 1;


    }else if(isset($_POST['search']) &&
        empty($_POST['username']) &&
        !empty($_POST['class_id'])){
        //collect data
        $data = array('class_id' => $_POST['class_id']);

        //Api url
        $api_url = 'http://localhost:8888/sec/api/student/getStudentsInClass.php';

        //response
        $res = postData($api_url, $data);

        $getData = json_decode($res, TRUE);

        array_key_exists('message', $getData) ? $nbr = 0 : $nbr = sizeof($getData);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/pers.css">
    <link rel="stylesheet" href="../css/student.css">
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
                    <a href="#" class="first_link"> <img src="../icons/writing 1.svg" alt="" class="one"> ??l??ves <img src="../icons/next.svg" alt="" class="two"></a>
                    <ul>
                        <li><a href=""><img src="../icons/next.svg" alt="">Tous les ??l??ves</a></li>
                        <li><a href="addStudent.php"><img src="../icons/next.svg" alt="">Ajouter un eleve</a></li>
                        <li><a href="delete_update.php"><img src="../icons/next.svg" alt="">supprimer/modifier</a></li>
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
        <section class="sec1">
            <h4>Tous les ??l??ves</h4>
            <form action="" class="form1" name="search" method="POST">
                <input type="text" name="username" placeholder="chercher par username...">
                <select name="class_id" id="class" >
                    <option value=""  disabled selected> Niveau</option>
                    //iterate on classes
                    <?php foreach($classes as $option) {?>
                        <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                    <?php }?>
                </select>
                <input type="submit" class="fa" value="" name="search">
            </form>
            <table class="t4">
                <tr class="th1">
                    <td >N??</td>
                    <td>Photo</td>
                    <td>Username</td>
                    <td>Nom</td>
                    <td >Genre</td>
                    <td >Nivau</td>
                    <td>Naissance</td>
                    <td>T??l??phone</td>
                    <td>Email</td>
                </tr>
                <?php
                $end1 = $counter + 15;
                for($i ; ($i < $end1) && ($i < $nbr) ; $i++){
                    ?>
                    <tr class="th2">
                        <td><?php echo $getData[$i]['id']?></td>
                        <td><div class="photo"></div></td>
                        <td><?php echo $getData[$i]['username']?></td>
                        <td><?php echo $getData[$i]['firstname']." ".$getData[$i]['lastname']?></td>
                        <td>M</td>
                        <td><?php echo $class->getClassById($getData[$i]['class_id'])[0]['name'];?></td>
                        <td>04/02/2006</td>
                        <td>0606060606</td>
                        <td><?php echo $getData[$i]['email']?></td>
                    </tr>
                <?php } ?>
            </table>
            <footer>
                    <form action="" method="GET">
                        <input type="submit" name="previous" class="F2" value="Pr??c??dent">
                        <input type="submit" name="next" class="F2" value="Suivant">
                    </form>
            </footer>
        </section>
        <div class="per-info">
            <div class="per-img">
                <img src="../icons/man.svg" alt="">
            </div>
            <h2><?php echo $_SESSION['lastname']." ".$_SESSION['firstname']; ?></h2>
            <hr>
            <table>
                <tr>
                    <td>Name :</td>
                    <td>Flani</td>
                </tr>
                <tr>
                    <td>Prenom :</td>
                    <td>Flan</td>
                </tr>
                <tr>
                    <td>Genre :</td>
                    <td>Homme</td>
                </tr>
                <tr>
                    <td>Date de naissance :</td>
                    <td>21/05/2017</td>
                </tr>
                <tr>
                    <td>Niveau :</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Class :</td>
                    <td>3AP-6</td>
                </tr>
                <tr>
                    <td>Address :</td>
                    <td>Quariter #3,rue #42 ville #18</td>
                </tr>
                <tr>
                    <td>Nom Tuteure :</td>
                    <td>Flani</td>
                </tr>
                <tr>
                    <td>Prenom Tuteure :</td>
                    <td>Flani</td>
                </tr>
                <tr>
                    <td>Telephone Tuteure :</td>
                    <td>0606060606</td>
                </tr>
                <tr>
                    <td>Email Tuteure :</td>
                    <td>email@email.com</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>