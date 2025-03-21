<?php

if(isset($_POST['btnCerrarSesion'])){
    session_start(); 
    session_unset(); 
    session_destroy(); 
    header('Location: ../index.php');
}