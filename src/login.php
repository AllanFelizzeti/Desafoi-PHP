<?php
session_start();
ob_start();

include_once '../server/Conn.php';
//require './Crud.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="image/favicon2.ico">
    <link rel="stylesheet" href="../css/custom-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Amais Educação- Login</title>
</head>

<body>
    <nav class="navbar">
        <div class="max-width">
            <div class="logo">
                <a href="index.php"><img src="" alt=""></a>
            </div>
            <ul class="menu" id="menu-site">
                <li><a href="#">Home</a></li>
                <li><a href="#">Sobre Empresa</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="login.php">Login|Cadastro</a></li>
            </ul>
            <div class="menu-btn" id="menu-btn">
                <i class="fa-solid fa-bars" id="menu-icon"></i>
            </div>
        </div>
    </nav>

    <section class="top">
        <div class="max-width">
            <div class="top-content">
                <nav class="d-flex">
                    <div class="container-login">
                        <div class="wrapper-login">
                            <div class="title">
                                <div class="logo1">
                                    <!-- <img src="image/Logo carro.png" alt="BRA parking" width="30px"> -->
                                    <span>Amais Educação</span>
                                </div>
                            </div>
                            <form action="./validaLogin.php" method="POST" class="form-login">
                                <div class="row">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="email" placeholder="E-mail" required>
                                </div>
                                <div class="row">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" name="brapa" placeholder="Senha" required>
                                </div>

                                <div class="row button">
                                    <input type="submit" name="db_login" value="Acessar">
                                </div>

                                <div class="signup-link">
                                    <a href="cadastrar.php">Cadastrar</a> - <a href="#">Esqueceu a senha</a><br>
                                    <?php if (isset($_SESSION['msg'])) {
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </section>
    <footer>
        <span>Created By <a href="https://www.amaiseducacao.com.br/">amais educação</a></span>
    </footer>
    <script src="../js/custom.js"></script>
</body>

</html>