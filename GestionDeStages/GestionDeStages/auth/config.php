<?php

$authTableData = [
    'table' => 'users',
    'idfield' => 'login',
    'cfield' => 'mdp',
    'uidfield' => 'uid',
    'rfield' => 'role',
];

$pathFor = [
    "login"  => "login.php",
    "login_user"=>"login_user.php",
    "logout" => "logout.php",
    "adduser" =>"/adduser.php",
    "root"   => "/",
];

const SKEY = '_Redirect';