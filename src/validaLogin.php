<?php
session_start();
ob_start();

require '../server/Conn.php';
//require './Crud.php';
$db = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (strlen($db['brapa']) <= 5) {
    $_SESSION['msg'] =  "<p style='color: #f00;'>Senha deve ter no minimo 6 números</p>";
    //echo "<pre>"; print_r($db); die;
    header("Location: login.php");
} else {
    if (!empty($db['db_login'])) {
        $query_usuarios = "SELECT id, nome, email, brapa FROM curriculos WHERE email=:email LIMIT 1";
        $result_usuarios = $conn->prepare($query_usuarios);
        $result_usuarios->bindParam(':email', $db['email']);
        $result_usuarios->execute();
    }

    //var_dump($result_usuarios);
    if (!empty($result_usuarios)) {
        foreach ($result_usuarios as $row_usuarios) {
            extract($row_usuarios);
            if ($db['email'] == $email && $db['brapa'] == $brapa) {
                $_SESSION['msg'] = "<p style='color: green;'>Usuário logado com sucesso!</p>";
                $_SESSION['id'] = $row_usuarios['id'];
                $_SESSION['nome'] = $row_usuarios['nome'];
                if ($_SESSION['nome'] = $row_usuarios['nome']) {
                    header("Location: listar.php");
                }
            } else {
                $_SESSION['msg'] =  "<p style='color: #f00;'>Usuário não encontrado!</p>";
                header("Location: login.php");
            }
        }
    } else {
        $_SESSION['msg'] =  "<p style='color: #f00;'>Usuário não encontrado!</p>";
        header("Location: login.php");
    }
}
