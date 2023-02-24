<?php

require_once './app/Controllers/UsuarioController.php';
require_once './app/Models/Usuario.php';

use App\Controllers\UsuarioController;
use App\Models\Usuario;

header("Content-Type: application/json");

$path = $_SERVER['PATH_INFO'] ?? '/';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $path === '/listAll') {
    $usuarios = UsuarioController::index();
    echo($usuarios);
}

elseif($_SERVER['REQUEST_METHOD'] === 'POST' && $path === '/create') {
    $usuario = new Usuario;
    $usuario->setNome($_REQUEST['nome']);
    $usuario->setEmail($_REQUEST['email']);
    $usuario->setSenha($_REQUEST['senha']);
    $retorno = UsuarioController::create($usuario);
    echo($retorno);
}

elseif($_SERVER['REQUEST_METHOD'] === 'PUT' && $path === '/update') {
    $usuario = Usuario::findById($_REQUEST['id']);
    if(isset($_REQUEST['nome'])) { $usuario->setNome($_REQUEST['nome']); }
    if(isset($_REQUEST['email'])) { $usuario->setEmail($_REQUEST['email']); }
    if(isset($_REQUEST['senha'])) { $usuario->setSenha($_REQUEST['senha']); }
    $retorno = UsuarioController::update($usuario, $_REQUEST['id']);
    echo($retorno);
}

elseif($_SERVER['REQUEST_METHOD'] === 'DELETE' && $path === '/delete') {
    $retorno = UsuarioController::delete($_REQUEST['id']);
    echo($retorno);
}