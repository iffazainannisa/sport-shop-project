<?php
session_start();
require_once('Controller.php');
$controller = new Controller();
require_once('Db.php');

header("Refresh: 0; url=view_kategori.php");

// $controller->view('view_kategori.php');
// header('Refresh: 0; url=view_kategori.php?v=1');
