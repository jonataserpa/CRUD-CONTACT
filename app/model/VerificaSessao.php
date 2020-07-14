<?php

session_start();
if($_SESSION['logado'] != true){
	echo "<script>location.href='/';</script>";
    exit();
}
 