<?php

if(!session_id()){
    session_start();
}

if(!isset($_SESSION['gLoggedIn'])){
    $_SESSION['gLoggedIn'] = false;
}

if(!isset($_SESSION['review'])){
    $_SESSION['review'] = [];
}

if(!isset($_SESSION['reviewC'])){
    $_SESSION['reviewC'] = 0;
}

function cookiesEnabled(): bool
{
    if (isset($_COOKIE["testing"]) && $_COOKIE["testing"] == 'good') {
        return true;
    }
    return false;
}