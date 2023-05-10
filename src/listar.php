<?php
session_start();
ob_start();

require '../server/Conn.php';

if ((!isset($_SESSION['id'])) and (!isset($_SESSION['nome']))) {
    if ($_SESSION['nivel-acesso'] > 2) {
        $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Necessário realizar o login para acessar a página!</p>";
        header("Location: login.php");

        //Mostra a mensagem e depois destrói a mesma
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    }
}

$query_usuario = "SELECT * FROM curriculos WHERE id = ? LIMIT 1";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->execute(array($_SESSION['id']));

$curriculo = $result_usuario->fetch();

$formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
// echo "<pre>";
// print_r($formData);
// die;

if (!empty($formData['email'])) {
    $query_atualizar = "UPDATE curriculos SET 
                            nome = :nome, 
                            celular = :celular, 
                            cpf = :cpf, 
                            email = :email, 
                            brapa = :brapa, 
                            pretencao_salario = :pretencao_salario, 
                            sexo = :sexo, 
                            data_nascimento = :data_nascimento, 
                            estado_civil = :estado_civil, 
                            escolaridade = :escolaridade, 
                            empresa = :empresa, 
                            cargo = :cargo, 
                            curso = :curso, 
                            periodo_entrada = :periodo_entrada, 
                            periodo_saida = :periodo_saida
                        WHERE id = :id";
    $atualizar_cadastro = $conn->prepare($query_atualizar);
    $atualizar_cadastro->bindParam(':id', $formData['id']);
    $atualizar_cadastro->bindParam(':nome', $formData['nome']);
    $atualizar_cadastro->bindParam(':celular', $formData['celular']);
    $atualizar_cadastro->bindParam(':cpf', $formData['cpf']);
    $atualizar_cadastro->bindParam(':email', $formData['email']);
    $atualizar_cadastro->bindParam(':brapa', $formData['brapa']);
    $atualizar_cadastro->bindParam(':pretencao_salario', $formData['pretencao_salario']);
    $atualizar_cadastro->bindParam(':sexo', $formData['sexo']);
    $atualizar_cadastro->bindParam(':data_nascimento', $formData['data_nascimento']);
    $atualizar_cadastro->bindParam(':estado_civil', $formData['estado_civil']);
    $atualizar_cadastro->bindParam(':escolaridade', $formData['escolaridade']);
    $atualizar_cadastro->bindParam(':empresa', $formData['empresa']);
    $atualizar_cadastro->bindParam(':cargo', $formData['cargo']);
    $atualizar_cadastro->bindParam(':curso', $formData['curso']);
    $atualizar_cadastro->bindParam(':periodo_entrada', $formData['periodo_entrada']);
    $atualizar_cadastro->bindParam(':periodo_saida', $formData['periodo_saida']);

    $atualizar_cadastro->execute();


    if ($atualizar_cadastro->rowCount()) {
        $_SESSION['msg'] = "<p style='color: green;'>Usuário atualizado com sucesso!</p>";
        header("Location: listar.php");
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não atualizado com sucesso!</p>";
        header("Location: listar.php");
    }
}

// echo '<pre>';
// print_r($curriculo);
// die;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="image/favicon2.ico">
    <link rel=" folha de estilo " href=" CSS/reset.css ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/custom.css">
    <title>amais Educação</title>
</head>

<body class="listar-adm">

    <div class="content">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-gauge"></i><span>Perfil</span></a>

            <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-file-lines"></i><span>Vagas</span></a>

            <a href="sair.php" class="sidebar-nav"><i class="icon fa-solid fa-arrow-right-from-bracket"></i><span>Logout</span></a>
        </div>

        <div class="container">
            <h2 class="container" id="editUsuarioModalLabel">Editar Curriculo</h2>
            <?php if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            } ?>
            <form class="row g-3 needs-validation" active="" method="POST" novalidate>
                <span id="msgAlertaErroEdit"></span>

                <input type="hidden" name="id" id="id" value="<?= $curriculo['id'] ?>">

                <div class="col-md-6">
                    <label for="nome_usuario" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" name="nome" id="nome" value="<?= $curriculo['nome'] ?>" placeholder="Digite seu nome completo" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                </div>

                <div class="invalid-feedback">
                    Digite o nome corretamente!
                </div><br>

                <div class="col-md-3">
                    <label for="validationCustom02" class="form-label">Telefone de contato</label>
                    <input type="text" class="form-control" id="validationCustom02" name="celular" value="<?= $curriculo['celular'] ?>" placeholder="(00) 0 0000-0000" value="" onchange="validaCel()" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Digite um telefone válido!
                    </div>
                </div><br>

                <div class="col-md-3">
                    <label for="validationCustom03" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="validationCustom03" name="cpf" value="<?= $curriculo['cpf'] ?>" placeholder="000.000.000-00" value="" onchange="validaCpf()" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Digite seu CPF!
                    </div><br>
                </div>

                <div class="col-md-2">
                    <label for="validationCustom05" class="form-label">Tretenção Salarial</label>
                    <input type="text" name="pretencao_salario" class="form-control" id="pretencao_salario" value="<?= $curriculo['pretencao_salario'] ?>" id="cep" placeholder="" required>
                    <div class="invalid-feedback">
                        Digite o cep corretamente!
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="exampleInputEmail" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $curriculo['email'] ?>" placeholder="Ex: joao@gmail.com" aria-describedby="emailHelp" value="" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Digite seu e-mail!
                    </div><br>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Data de Nacimento</label>
                    <input type="date" name="data_nascimento" class="form-control" id="data_nascimento" value="<?= $curriculo['data_nascimento'] ?>" placeholder="01/05/1995" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="password" name="brapa" class="form-control" id="exampleInputPassword1" value="<?= $curriculo['brapa'] ?>" placeholder="**********" value="" onkeyup="senhaForca()" required>
                    <div id="impForcaSenha">
                        <label>Força da senha</label>
                    </div>
                </div>

                <div class="invalid-feedback">
                    Digite uma senha válida!
                </div><br>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Sexo</label>
                    <input type="text" name="sexo" class="form-control" id="sexo" value="<?= $curriculo['sexo'] ?>" placeholder="Masculino" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Estado Civil</label>
                    <input type="text" name="estado_civil" class="form-control" id="estado_civil" value="<?= $curriculo['estado_civil'] ?>" placeholder="Casado" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>

                <div class="col-md-6">
                    <label for="validationCustom06" class="form-label">Ecolaridade</label><br>
                    <select name="escolaridade" id="escolaridade" value="<?= $curriculo['escolaridade'] ?>" placeholder="escolaridade" require>
                        <option value="Ensino Fundamental">Ensino Fundamental</option>
                        <option value="Segundo Gral">Segundo Gral</option>
                        <option value="Tecnico">Tecnico</option>
                        <option value="Faculdade">Faculdade</option>

                    </select>
                    <div class="valid-feedback">
                        Ok
                    </div>
                </div>

                <div class="col-md-10">
                    <h4>Ultima experiencia profissional</h4><br>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom05" class="form-label">Empresa</label>
                    <input type="text" name="empresa" class="form-control" id="empresa" value="<?= $curriculo['empresa'] ?>" placeholder="" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom05" class="form-label">Cargo</label>
                    <input type="text" name="cargo" class="form-control" id="cargo" value="<?= $curriculo['cargo'] ?>" placeholder="" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>
                <div class="col-md-2">
                    <label for="validationCustom05" class="form-label">Periodo Entrada</label>
                    <input type="date" name="periodo_entrada" class="form-control" id="periodo_entrada" value="<?= $curriculo['periodo_entrada'] ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="validationCustom05" class="form-label">Periodo Saida</label>
                    <input type="date" name="periodo_saida" class="form-control" id="periodo_saida" value="<?= $curriculo['periodo_saida'] ?>" required>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Cursos/Especializações</label>
                    <textarea type="text" name="curso" class="form-control" id="curso" value="<?= $curriculo['curso'] ?>" placeholder="Java" required></textarea>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit" name="SendEdtUser" value="cadastrar">Editar</button>
                </div>
            </form>
        </div>


        <script src="../js/custom.js"></script>
        <!--Validando campos celular e cpf com mask Cleave -->
        <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
        <script>
            new Cleave('#validationCustom03', {
                delimiters: ['.', '.', '-'],
                blocks: [3, 3, 3, 2],
                numericOnly: true
            });

            new Cleave('#validationCustom02', {
                delimiters: ['(', ')', '-'],
                blocks: [0, 2, 5, 4],
                numericOnly: true
            });
        </script>
</body>

</html>