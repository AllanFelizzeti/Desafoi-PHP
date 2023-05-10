<?php
session_start();
ob_start();

require '../server/Conn.php';
require '../server/Crud.php';


//Recebe o Array do form
$formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//echo "<pre>"; print_r($formData); die;
//Verifica se não está vazio 
if (!empty($formData['email'])) {
    $check_query = "SELECT * FROM curriculos WHERE email = :email OR cpf = :cpf LIMIT 1";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':email', $formData['email']);
    $check_stmt->bindParam(':cpf', $formData['cpf']);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        // Já existe um registro com o email ou cpf informado
        echo "<script>alert('Já existe um registro com o email ou cpf informado.');</script>";
    } else {
        //var_dump($formData);
        //Cria o objeto para fazer o cadastro no banco
        $query_cadastrar = "INSERT INTO curriculos (nome, celular, cpf, email, brapa, 
        pretencao_salario, sexo, data_nascimento, estado_civil, escolaridade, empresa, cargo, curso, periodo_entrada, periodo_saida, created) 
                            VALUES (:nome, :celular, :cpf, :email, :brapa, 
        :pretencao_salario, :sexo, :data_nascimento, :estado_civil, :escolaridade, :empresa, :cargo, :curso, :periodo_entrada, :periodo_saida, NOW())";
        $add_cadastro = $conn->prepare($query_cadastrar);
        $add_cadastro->bindParam(':nome', $formData['nome']);
        $add_cadastro->bindParam(':celular', $formData['celular']);
        $add_cadastro->bindParam(':cpf', $formData['cpf']);
        $add_cadastro->bindParam(':email', $formData['email']);
        $add_cadastro->bindParam(':brapa', $formData['brapa']);
        $add_cadastro->bindParam(':pretencao_salario', $formData['pretencao_salario']);
        $add_cadastro->bindParam(':sexo', $formData['sexo']);
        $add_cadastro->bindParam(':data_nascimento', $formData['data_nascimento']);
        $add_cadastro->bindParam(':estado_civil', $formData['estado_civil']);
        $add_cadastro->bindParam(':escolaridade', $formData['escolaridade']);
        $add_cadastro->bindParam(':empresa', $formData['empresa']);
        $add_cadastro->bindParam(':cargo', $formData['cargo']);
        $add_cadastro->bindParam(':curso', $formData['curso']);
        $add_cadastro->bindParam(':periodo_entrada', $formData['periodo_entrada']);
        $add_cadastro->bindParam(':periodo_saida', $formData['periodo_saida']);

        $add_cadastro->execute();

        if ($add_cadastro->rowCount()) {
            //Mostra a mensagem se cadastrado com sucesso redireciona para a pagina index.php
            $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
            header("Location: login.php");
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não cadastrado com sucesso!</p>";
            header("Location: index.php");
        } // Não existe nenhum registro com o email ou cpf informado, então pode fazer o cadastro
        // ...
    }
} else {
    echo "<script>alert('Formulario invalido.');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Alteracao: incluindo shrink-to BS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS Bootstrap -->
    <!-- <link rel="shortcut icon" href="image/favicon2.ico"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/customcadastrar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>BRA parking</title>
</head>

<body>
    <!-- Criação da Barra de Menu -->
    <nav class="navbar">
        <div class="max-width">
            <div class="logo">
                <!-- <img src="image/Logo carro.png" alt="BRA parking"> -->
                <a href="index.php">Amais Educação</a>
            </div>
            <ul class="menu" id="menu-site">
                <li><a href="index.php">Home</a></li>
                <li><a href="sobre-empresa.php">Sobre Empresa</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
            <div class="menu-btn" id="menu-btn">
                <i class="fa-solid fa-bars" id="menu-icon"></i>
            </div>
        </div>
    </nav>

    <!-- Form de cadastro teste -->

    <div class="container">
        <br><br><br><br>
        <h2>Cadastro de Currículo</h2><br>
        <form class="row g-3 needs-validation" active="" method="POST" novalidate>
            <div class="col-md-6">
                <label for="nome_usuario" class="form-label">Nome completo</label>
                <input type="text" class="form-control" name="nome" id="nome_usuario" placeholder="Digite seu nome completo" required>
                <div class="valid-feedback">
                    Ok
                </div>
            </div>

            <div class="invalid-feedback">
                Digite o nome corretamente!
            </div><br>

            <div class="col-md-3">
                <label for="validationCustom02" class="form-label">Telefone de contato</label>
                <input type="text" class="form-control" id="validationCustom02" name="celular" placeholder="(00) 0 0000-0000" value="" onchange="validaCel()" required>
                <div class="valid-feedback">
                    Ok
                </div>
                <div class="invalid-feedback">
                    Digite um telefone válido!
                </div>
            </div><br>

            <div class="col-md-3">
                <label for="validationCustom03" class="form-label">CPF</label>
                <input type="text" class="form-control" id="validationCustom03" name="cpf" placeholder="000.000.000-00" value="" onchange="validaCpf()" required>
                <div class="valid-feedback">
                    Ok
                </div>
                <div class="invalid-feedback">
                    Digite seu CPF!
                </div><br>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Tretenção Salarial</label>
                <input type="text" name="cep" class="form-control" id="validationCustom05" id="cep" placeholder="" required>
                <div class="invalid-feedback">
                    Digite o cep corretamente!
                </div>
            </div>

            <div class="col-md-4">
                <label for="exampleInputEmail" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail" placeholder="Ex: joao@gmail.com" aria-describedby="emailHelp" value="" required>
                <div class="valid-feedback">
                    Ok
                </div>
                <div class="invalid-feedback">
                    Digite seu e-mail!
                </div><br>
            </div>

            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Data de Nacimento</label>
                <input type="date" name="data_nascimento" class="form-control" id="validationCustom05" placeholder="01/05/1995" required>
                <div class="invalid-feedback">
                    Digite corretamente!
                </div>
            </div>

            <div class="col-md-3">
                <label for="exampleInputPassword1">Senha</label>
                <input type="password" name="brapa" class="form-control" id="exampleInputPassword1" placeholder="**********" value="" onkeyup="senhaForca()" required>
                <div id="impForcaSenha">
                    <label>Força da senha</label>
                </div>
            </div>

            <div class="invalid-feedback">
                Digite uma senha válida!
            </div><br>

            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Sexo</label>
                <input type="text" name="sexo" class="form-control" id="validationCustom05" placeholder="Masculino" required>
                <div class="invalid-feedback">
                    Digite corretamente!
                </div>
            </div>

            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Estado Civil</label>
                <input type="text" name="estado_civil" class="form-control" id="validationCustom05" placeholder="Casado" required>
                <div class="invalid-feedback">
                    Digite corretamente!
                </div><br>
            </div>

            <div class="col-md-6">
                <label for="validationCustom06" class="form-label">Ecolaridade</label><br>
                <select name="escolaridade" id="escolaridade">
                    <option selected="Ensino Fundamental" value="1">Ensino Fundamental</option>
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
                <input type="text" name="empresa" class="form-control" id="validationCustom05" placeholder="" required>
                <div class="invalid-feedback">
                    Digite corretamente!
                </div><br>
            </div>
            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Cargo</label>
                <input type="text" name="cargo" class="form-control" id="validationCustom05" placeholder="" required>
                <div class="invalid-feedback">
                    Digite corretamente!
                </div><br>
            </div>
            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Periodo Entrada</label>
                <input type="date" name="periodo_entrada" class="form-control" id="validationCustom05" placeholder="" required>
            </div>
            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Periodo Saida</label>
                <input type="date" name="periodo_saida" class="form-control" id="validationCustom05" placeholder="" required>
            </div>

            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Cursos/Especializações</label>
                <textarea type="text" name="curso" class="form-control" id="validationCustom05" placeholder="Java" required></textarea>
                <div class="invalid-feedback">
                    Digite corretamente!
                </div><br>
            </div>

            <div hidden>
                <input type="number" name="nivel-acesso" value="4">
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                        Aceito os termos e condições
                    </label>
                    <div class="invalid-feedback">
                        Você deve concordar antes de enviar.
                    </div>
                </div><br>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit" name="SendAddUser" value="cadastrar">Cadastrar</button>
            </div>
            <div>
                <?php if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                } ?>
            </div>
        </form>
    </div>
    </div>
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