<?php 
session_start();

// Verifica se a ação é para limpar a sessão
if (isset($_GET['action']) && $_GET['action'] === 'clear_session') {
    unset($_SESSION['error']);
    unset($_SESSION['formOk']);
    session_destroy(); // Destrói a sessão se necessário
    header('Location: index.php'); // Redireciona após limpar
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H842TTLJSP"></script>
<script src="google.js"></script>
<link rel="shortcut icon" href="./img/abobora.ico">
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H842TTLJSP');
</script>
    <meta charset="UTF-8">
    <title>Erro - Efetue o cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3d3d3d;
            text-align: center;
            padding: 10px;
        }

        h1 {
            color: #333;
        }

        p {
            color: red;
            font-size: 20px;
            margin-bottom: 20px;
        }

        a {
            color: #007bff;
            font-size: 20px;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        main{
          margin: 240px 500px;
          align-items: center;
          box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.5);
          border-radius: 20px;
          text-align: center;
          padding: 4px 5px 4px 5px;
          background-color: rgb(109, 108, 108);


        }
        .link {
         color: orange; 
        }

       h1{
        color: white;
        font-size: 20px;
       }
       h2 {
        font-size: 40px;
       }

    </style>
</head>
<body style="background-image: url('./img/voando.png'); background-size: cover;">
<main>
    <br>
    <br>
    <center><img src="./img/bruxa.png" width="250" height="150"></center>
    <h2>Ops HAHAHA!!</h2>
    
    <?php 
    if (isset($_SESSION['error'])) {
        echo "<h1>". $_SESSION['error'] ."</h1> ";
    }
    if (isset($_SESSION['formOk']) && (int)$_SESSION['formOk'] === 2) {
        echo "<h1>Este CPF já possui um cadastro!</h1> ";
    } elseif (isset($_SESSION['formOk']) && (int)$_SESSION['formOk'] === 1) {
        echo "<h1>Solicite seu CONVITE, basta preencher nosso formulário!</h1> ";
    } else {
        echo "<h1>Solicite seu CONVITE, basta preencher nosso formulário!</h1> ";  
    };
    ?>
    
    <a href="erro.php?action=clear_session" class="link">Clique aqui para fazer o login...</a>


    <br>
    <br>
</main>
</body>
</html>
