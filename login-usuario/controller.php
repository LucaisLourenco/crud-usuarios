<?php
session_start();

function connection()
{
    $DB_NAME = "database_test";
    $DB_USUARIO = "user";
    $DB_SENHA = "user123";
    $DB_CHARSET = "utf8";

    $str_conn = "mysql:host=localhost;dbname=" . $DB_NAME;

    return new PDO(
        $str_conn,
        $DB_USUARIO,
        $DB_SENHA,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $DB_CHARSET)
    );
}

function login($email, $senha)
{
    $connection = connection();
    $stmt = $connection->prepare("SELECT * FROM usuarios WHERE email=:email AND senha=:senha");
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":senha", $senha, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject(stdClass::class);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $usuario = login($email, $senha);

    if ($usuario != null) {
        $_SESSION['usuario'] = $usuario;
        echo 'success';
    } else {
        echo 'Usuário ou senha inválidos.';
    }
}
