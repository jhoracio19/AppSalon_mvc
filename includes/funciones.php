<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//
function esUltimo(string $actual, $proximo) : bool {
    if($actual != $proximo){
        return true;
    }
    return false;
}

// Funcion que revisa que el usuario esta autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

// Funcion que revisa si el usuario es administrador
function isAdmin() : void {
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}