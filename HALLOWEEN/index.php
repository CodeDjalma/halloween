<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$hostname = 'localhost'; 
$usuario = 'root';
$senha = ' ';
$banco = 'halloween';
$porta = '3306';

$conn = new mysqli($hostname, $usuario, $senha, $banco, $porta);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    echo "<script>console.log('Falha na conexão: " . $conn->connect_error . "');</script>";
} else {
    echo "<script>console.log('Conexão bem sucedida');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$nomeusuario = htmlspecialchars(trim($_POST['nome']));     
$email       = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null; 
$cpf         = htmlspecialchars(trim($_POST['cpf']));      
$cep         = htmlspecialchars(trim($_POST['cep']));         
$endereco    = htmlspecialchars(trim($_POST['endereco']));
$numero      = htmlspecialchars(trim($_POST['numero']));
$complemento = htmlspecialchars(trim($_POST['complemento']));
$bairro      = htmlspecialchars(trim($_POST['bairro']));
$cidade      = htmlspecialchars(trim($_POST['cidade']));
$uf          = htmlspecialchars(trim($_POST['uf']));
$comentario  = htmlspecialchars(trim($_POST['comentario']));

if (strlen($nomeusuario) > 100) {
    $_SESSION['error'] = "O nome não pode exceder 100 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($email) > 254) {
    $_SESSION['error'] = "O e-mail não pode exceder 254 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($cpf) > 14) {
    $_SESSION['error'] = "O CPF não pode exceder 14 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($cep) > 8) {
    $_SESSION['error'] = "O CEP não pode exceder 8 dígitos.";
    header('Location: erro.php');
    exit();
}

if (strlen($endereco) > 100) {
    $_SESSION['error'] = "O endereço não pode exceder 100 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($numero) > 10) {
    $_SESSION['error'] = "O número não pode exceder 10 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($complemento) > 50) {
    $_SESSION['error'] = "O complemento não pode exceder 50 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($bairro) > 50) {
    $_SESSION['error'] = "O bairro não pode exceder 50 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($cidade) > 50) {
    $_SESSION['error'] = "A cidade não pode exceder 50 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($uf) > 2) {
    $_SESSION['error'] = "O estado (UF) não pode exceder 2 caracteres.";
    header('Location: erro.php');
    exit();
}

if (strlen($comentario) > 16777215) { 
    $_SESSION['error'] = "O comentário é muito longo.";
    header('Location: erro.php');
    exit();
}


if (!$email) {
    $_SESSION['error'] = "Por Favor insira um E-mail Válido!";
    header('Location: erro.php');
    exit();
}

if (empty($cep) || strlen($cep) < 8) {
    $_SESSION['error'] = "O CEP deve conter pelo menos 8 dígitos.";
    header('Location: erro.php');
    exit();
}




    $sqlvalida = "SELECT cpf FROM usuarios WHERE cpf = ?";
     
    $stmt2 = $conn->prepare($sqlvalida);
     if ($stmt2) {
        $stmt2->bind_param("s",$cpf);

        if ($stmt2->execute()){
            $stmt2->store_result();
    
        if ($stmt2->num_rows > 0) {
        
          $_SESSION['formOk'] = 2; 
          header('Location: erro.php');
          $stmt2->close();
          exit();
        }
  
        }
     }

    $sql = "INSERT INTO usuarios (nome, email, cpf, cep, endereco, numero, complemento, bairro, cidade, uf, comentario) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssssssss", $nomeusuario, $email, $cpf, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $uf, $comentario);
        
        if ($stmt->execute()) {
        
            
            $stmt->close();
            $conn->close();

        
           $_SESSION['formOk'] = 1; 
            
            header("Location: convite.php");
            exit(); 
        } else {
            echo "<script>console.log('Erro ao inserir os dados: " . $stmt->error . "');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>console.log('Erro ao preparar a consulta: " . $conn->error . "');</script>";
    }

    $conn->close();  
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/abobora.ico">
    <link rel="stylesheet" href="./css/style.css">
    <title>Site de Halloween</title>
    <script>
    function validaCep() {
        const cepInput = document.getElementById('cep');
        const cep = cepInput.value.replace(/\D/g, "");
        const cepError = document.getElementById('cepError');

        if (cep.length < 8) {
            cepError.innerText = "O CEP deve conter pelo menos 8 dígitos.";
        } else {
            cepError.innerText = "";
        }
    }

    function formatarCPF() {
        const cpfInput = document.getElementById('cpf');
        let cpf = cpfInput.value.replace(/\D/g, "");
        const cpfError = document.getElementById('cpfError');

        if (cpf.length === 11) {
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
            cpfInput.value = cpf;
            cpfError.innerText = "";
        } else {
            cpfError.innerText = "O CPF deve conter exatamente 11 dígitos.";
        }
    }

    function validaEmail() {
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const email = emailInput.value;

        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(email)) {
            emailError.innerText = "Insira um e-mail válido.";
        } else {
            emailError.innerText = "";
        }
    }
</script>
</head>

<body style="background-image: url('./img/voando.png'); background-size: cover;">


    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav_logo">	
                <center>Halloween
                <br>
                <img src="img/abobora.png" alt="abobora" class="nav_logo" width="60px" height="60px"></center>
            </a>
        </nav>
    </header>

    <main class="main">
        <section class="section_contact">
            <h2 class="section_title">Receber Convite para Festa</h2>
            <center><img src="img/bastao.png" alt="bastao" class="nav_bastao" width="60px" height="60px"></center>
            <br>
            
            <form class="contato_form container grid" enctype="multipart/form-data" id="contato_form" action="" method="POST">
                <input type="text" placeholder="Seu Nome" class="contact_input" name="nome" required autocomplete="off">

                <input type="email" placeholder="Seu Email" class="contact_input" name="email" id="email" required autocomplete="off" onblur="validaEmail()">
                <small id="emailError" style="color: red;"></small>
              
                <input type="text" placeholder="Seu CPF" class="contact_input" name="cpf" id="cpf" required autocomplete="off" onblur="formatarCPF()">
        
                <small id="cpfError" style="color: red;"></small>
                <input type="text" placeholder="CEP" class="input_cep" name="cep" id="cep" required autocomplete="off" onblur="validaCep()">
                <small id="cepError" style="color: red;"></small>

                <input type="text" placeholder="Endereço" class="input_end" name="endereco" required autocomplete="off">
                <input type="text" placeholder="Número" class="input_num" name="numero" required autocomplete="off">
                <input type="text" placeholder="Complemento" class="input_comp" name="complemento" autocomplete="off">
                <input type="text" placeholder="Bairro" class="input_bairro" name="bairro" required autocomplete="off">
                <input type="text" placeholder="Cidade" class="input_cidade" name="cidade" required autocomplete="off">
                <div class="combodoc">
                    <select class="input_UF" name="uf" autocomplete="off" required>
                        <option value="" disabled selected>Selecione o UF</option>
                        <option value="AC">Acre (AC)</option>
                        <option value="AL">Alagoas (AL)</option>
                        <option value="AP">Amapá (AP)</option>
                        <option value="AM">Amazonas (AM)</option>
                        <option value="BA">Bahia (BA)</option>
                        <option value="CE">Ceará (CE)</option>
                        <option value="DF">Distrito Federal (DF)</option>
                        <option value="ES">Espírito Santo (ES)</option>
                        <option value="GO">Goiás (GO)</option>
                        <option value="MA">Maranhão (MA)</option>
                        <option value="MT">Mato Grosso (MT)</option>
                        <option value="MS">Mato Grosso do Sul (MS)</option>
                        <option value="MG">Minas Gerais (MG)</option>
                        <option value="PA">Pará (PA)</option>
                        <option value="PB">Paraíba (PB)</option>
                        <option value="PR">Paraná (PR)</option>
                        <option value="PE">Pernambuco (PE)</option>
                        <option value="PI">Piauí (PI)</option>
                        <option value="RJ">Rio de Janeiro (RJ)</option>
                        <option value="RN">Rio Grande do Norte (RN)</option>
                        <option value="RS">Rio Grande do Sul (RS)</option>
                        <option value="RO">Rondônia (RO)</option> 
                        <option value="RR">Roraima (RR)</option>
                        <option value="SC">Santa Catarina (SC)</option> 
                        <option value="SP">São Paulo (SP)</option>
                        <option value="SE">Sergipe (SE)</option>
                        <option value="TO">Tocantins (TO)</option> 
                    </select>
                </div>
                <textarea placeholder="Sua Mensagem" class="contact_input" name="comentario"  autocomplete="off" required></textarea>
                <button type="submit" class="button">Solicitar Convite</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <div class="footer_container container grid">
            <h1 class="footer_title">H a l l o w e e n</h1>
            <p class="footer_description">A festa mais divertida do ano.</p>
        </div>
    </footer>

</body>
</html>
