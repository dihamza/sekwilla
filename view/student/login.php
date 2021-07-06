<?php
    //start session.php here
    session_start();

    //require Auth
    require_once '../../include/auth.php';

    //require database connection
    require_once '../../config/database.php';

    //connection to database
    $database = new Database();
    $conn = $database->getConnection();
    if(isset($_SESSION['authorisation'])) {
        if ($_SESSION['authorisation'] === 'admin') {
            header('location: http://localhost:8888/sec/view/admin/student/students.php');
        } else if ($_SESSION['authorisation'] === 'student') {
            header('location: http://localhost:8888/sec/view/student/result/home.php');
        }
    }

    if(isset($_POST['submit'])){
        $Admin = new Auth($conn);
        $Admin->email = $_POST['user_email'];
        $Admin->username = $_POST['user_email'];
        $Admin->password = $_POST['password'];
        $res = $Admin->isExist('students');
        $data = $res->fetchAll(PDO::FETCH_ASSOC);

        if($res->rowCount() && password_verify($Admin->password, $data[0]['password'])){

            $_SESSION['authorisation'] = 'student';
            $_SESSION['class_id'] = $data[0]['class_id'];
            $_SESSION['username'] = $data[0]['username'];
            $_SESSION['email'] = $data[0]['email'];
            $_SESSION['lastname'] = $data[0]['lastname'];
            $_SESSION['firstname'] = $data[0]['firstname'];
            header('location: result/home.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in</title>
    <link rel="stylesheet" href="../admin/css/login.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
</head>
<body>
<div class="container">
    <div class="left">
        <h6>AR | FR</h6>
        <form method="post">
            <input type="text" name="user_email" placeholder="Adresse email" />
            <div class="midl">
                <input type="password" name="password" placeholder="Mot de passe" />
                <a href="#" class="stlink">Mot de passe oublié ?</a>
            </div>
            <input type="submit" name="submit" value="connexion" />
        </form>
    </div>
    <div class="right">
        <img src="../admin/img/bg.svg" alt="" />
        <h1>Bienvenue dans votre <br />espace privé</h1>
    </div>
</div>
</body>
</html>
