<?php
    session_start();
    // remove all session.php variables
    session_unset();

    // destroy the session.php
    session_destroy();

    header('location:../index.php');

    ?>