<?php
session_start();
ob_start();

require '../server/Conn.php';
//require './Crud.php';

if ((!isset($_SESSION['id'])) and (!isset($_SESSION['nome']))) {
    if ($_SESSION['nivel-acesso'] > 2) {
        $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Necessário realizar o login para acessar a página!</p>";
        header("Location: login.php");

        //Mostra a mensagen e depois destroi a mesma
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    }
}
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
    <title>BRA PARK</title>
</head>

<body class="listar-adm">

    <div class="content">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="dashboard.php" class="sidebar-nav"><i class="icon fa-solid fa-gauge"></i><span>Perfil</span></a>

            <a href="vagas.php" class="sidebar-nav"><i class="icon fa-solid fa-car"></i><span>Vagas</span></a>

            <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-file-lines"></i><button class="btn btn-link" type="button" data-bs-toggle="modal" data-bs-target="#cadUsuarioModal">Cadastrar</button></a>

            <!-- <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cadUsuarioModal"> Cadastrar</button> -->
            <!-- <a href="visualizar.php" class="sidebar-nav"><i class="icon fa-solid fa-eye"></i><span>Visualizar</span></a> -->

            <!-- <a href="alerta.php" class="sidebar-nav"><i class="icon fa-solid fa-triangle-exclamation"></i><span>Alerta</span></a>

        <a href="botao.php" class="sidebar-nav"><i class="icon fa-solid fa-egg"></i><span>Botões</span></a> -->

            <a href="sair.php" class="sidebar-nav"><i class="icon fa-solid fa-arrow-right-from-bracket"></i><span>Logout</span></a>
        </div>

        <div class="container">
            <h2 class="container" id="editUsuarioModalLabel">Editar Curriculo</h2>
            <form class="row g-3 needs-validation" id="edit-usuario-form">
                <span id="msgAlertaErroEdit"></span>

                <input type="hidden" name="id" id="editid">

                <div class="col-md-6">
                    <label for="nome_usuario" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" name="nome" id="editnome" placeholder="Digite seu nome completo" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                </div>

                <div class="invalid-feedback">
                    Digite o nome corretamente!
                </div><br>

                <div class="col-md-3">
                    <label for="validationCustom02" class="form-label">Telefone de contato</label>
                    <input type="text" class="form-control" id="celular" name="editcelular" placeholder="(00) 0 0000-0000" value="" onchange="validaCel()" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Digite um telefone válido!
                    </div>
                </div><br>

                <div class="col-md-3">
                    <label for="validationCustom03" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="editcpf" name="cpf" placeholder="000.000.000-00" value="" onchange="validaCpf()" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Digite seu CPF!
                    </div><br>
                </div>

                <div class="col-md-2">
                    <label for="validationCustom05" class="form-label">Tretenção Salarial</label>
                    <input type="text" name="cep" class="form-control" id="editcep" id="cep" placeholder="" required>
                    <div class="invalid-feedback">
                        Digite o cep corretamente!
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="exampleInputEmail" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" id="editemail" placeholder="Ex: joao@gmail.com" aria-describedby="emailHelp" value="" required>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Digite seu e-mail!
                    </div><br>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Data de Nacimento</label>
                    <input type="date" name="data_nascimento" class="form-control" id="editdata_nascimento" placeholder="01/05/1995" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="password" name="brapa" class="form-control" id="editbraba" placeholder="**********" value="" onkeyup="senhaForca()" required>
                    <div id="impForcaSenha">
                        <label>Força da senha</label>
                    </div>
                </div>

                <div class="invalid-feedback">
                    Digite uma senha válida!
                </div><br>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Sexo</label>
                    <input type="text" name="sexo" class="form-control" id="editsexo" placeholder="Masculino" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Estado Civil</label>
                    <input type="text" name="estado_civil" class="form-control" id="editestado" placeholder="Casado" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>

                <div class="col-md-6">
                    <label for="validationCustom06" class="form-label">Ecolaridade</label><br>
                    <select name="escolaridade" id="editescolaridade">
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
                    <input type="text" name="empresa" class="form-control" id="editempresa" placeholder="" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom05" class="form-label">Cargo</label>
                    <input type="text" name="cargo" class="form-control" id="editcargo" placeholder="" required>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>
                <div class="col-md-2">
                    <label for="validationCustom05" class="form-label">Periodo Entrada</label>
                    <input type="date" name="periodo_entrada" class="form-control" id="editperiodo_entrada" placeholder="" required>
                </div>
                <div class="col-md-2">
                    <label for="validationCustom05" class="form-label">Periodo Saida</label>
                    <input type="date" name="periodo_saida" class="form-control" id="editperiodo_saida" placeholder="" required>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Cursos/Especializações</label>
                    <textarea type="text" name="curso" class="form-control" id="editcurso" placeholder="Java" required></textarea>
                    <div class="invalid-feedback">
                        Digite corretamente!
                    </div><br>
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-outline-warning btn-sm" id="edit-usuario-btn" value="Salvar" />
                </div>
            </form>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="../js/custom2.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>