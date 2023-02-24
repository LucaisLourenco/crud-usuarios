<?php

namespace App\Models;

use Exception;
use PDO;

class Usuario {

    private $id = 0;
    private $nome = '';
    private $email = '';
    private $senha = '';

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getNome(): string {
        return $this->nome;
    }
    
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public static function connection() {

        $DB_NAME = "database_test";
        $DB_USUARIO = "user";
        $DB_SENHA = "user123";
        $DB_CHARSET = "utf8";

        $str_conn = "mysql:host=localhost;dbname=".$DB_NAME;

        return new PDO($str_conn, $DB_USUARIO, $DB_SENHA, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$DB_CHARSET));
    }

    public static function findById($id) {
        $connection = self::connection();
        $stmt = $connection->prepare("SELECT * FROM usuarios WHERE id = $id");
        $stmt->execute();
        $usuario = $stmt->fetchObject(Usuario::class);
        return $usuario;
    }

    public static function all() {
        $connection = self::connection();
        $stmt = $connection->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(Usuario $usuario) {

        try{
            $connection = self::connection();
            $stmt = $connection->prepare("INSERT INTO usuarios VALUES(NULL, :_nome, :_email, :_senha)");
            $stmt->bindValue(":_nome", $usuario->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":_email", $usuario->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(":_senha", $usuario->getSenha(), PDO::PARAM_STR);
            $stmt->execute();
            return ['succes' => 'Usuário cadastrado com sucesso.'];
        } catch(Exception $e) {
            return ['error' => 'Erro ao cadastrar usuário.'];
        }
    }

    public static function update(Usuario $usuario, $id) {

        try {
            $connection = self::connection();
            $stmt = $connection->prepare("UPDATE usuarios SET nome=:_nome, email=:_email, senha=:_senha WHERE id =:_id");
            $stmt->bindValue(":_nome", $usuario->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":_email", $usuario->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(":_senha", $usuario->getSenha(), PDO::PARAM_STR);
            $stmt->bindValue(":_id", $id, PDO::PARAM_STR);
            $stmt->execute();
            return ['succes' => 'Usuário editado com sucesso.'];
        } catch(Exception $e) {
            return ['error' => 'Erro ao editar usuário.'];
        }
    }

    public static function delete($id) {
        try {
            $connection = self::connection();
            $stmt = $connection->prepare("DELETE FROM usuarios WHERE id=$id");
            $stmt->execute();
            return ['succes' => 'Usuário excluído com sucesso.'];
        } catch(Exception $e) {
            return ['error' => 'Erro ao excluir usuário.'];
        }
    }
}