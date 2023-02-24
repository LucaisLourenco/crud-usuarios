<?php

namespace App\Controllers;

require_once 'app/Models/Usuario.php';
use App\Models\Usuario;

class UsuarioController {

    public static function index() {
        $usuarios = Usuario::all();
        return json_encode($usuarios);
    }

    public static function create(Usuario $usuario) {
        $retorno = Usuario::create($usuario);
        return json_encode($retorno);
    }

    public static function update(Usuario $usuario, $id) {
        $retorno = Usuario::update($usuario, $id);
        return json_encode($retorno);
    }

    public static function delete($id) {
        $retorno = Usuario::delete($id);
        return json_encode($retorno);
    }
}