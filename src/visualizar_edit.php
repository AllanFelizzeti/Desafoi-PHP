<?php
include_once '../server/Conn.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_usuario = "SELECT cur.id, cur.nome, cur.cpf, cur.celular, cur.email, cur.brapa, cur.pretencao_salario,
    cur.sexo, cur.data_nascimento, cur.estado_civil, cur.escolaridade, cur.empresa, cur.cargo, cur.curso, 
    cur.periodo_entrada, cur.periodo_saida  
    FROM curriculos AS cur  
    WHERE cur.id = :id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id);
    $result_usuario->execute();

    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

    $retorna = ['erro' => false, 'dados' => $row_usuario];
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>"];
}

echo json_encode($retorna);

// if (!empty($id)) {

//     $query_endereco = "SELECT id, cep, rua, numero, complemento, bairro, cidade, usuario_id FROM enderecos WHERE usuario_id = :usuario_id LIMIT 1";
//     $result_endereco = $conn->prepare($query_endereco);
//     $result_usuario->bindParam(':usuario_id', $id);
//     $result_endereco->execute();

//     $row_usuario = $result_endereco->fetch(PDO::FETCH_ASSOC);

//     $retorna2 = ['erro' => false, 'dados2' => $row_usuario];    
// } else {
//     $retorna2 = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>"];
// }

// echo json_encode($retorna2);