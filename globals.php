<?php
if(!session_id()) session_start();

const gDays = [
    1 => "Hetfo",
    2 => "Kedd",
    3 => "Szerda",
    4 => "Csutortok",
    5 => "Pentek",
    6 => "Szombat",
    7 => "Vasarnap",
];
$gUserInfo = [
    "uName" => "",
    "pWord" => "",
];
if(!isset($_SESSION['gUserInfo'])) {
    $_SESSION['gUserInfo'] = $gUserInfo;
}

if(!isset($_SESSION['gLoggedIn'])){
    $_SESSION['gLoggedIn'] = false;
}

if(!isset($_SESSION['gUsers'])){
    $gUsers = [
        "NagyLajosAJampi" => "lajcsivagyok",
        "LakatosPS5" => "sadlife",
    ];
    $_SESSION['gUsers'] = $gUsers;
}