<?php
session_start();
require("helpers.php");
require('dbConfig.php');
$_SESSION = [];
echo include_template('authorization.php',
    ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']);
session_destroy();

