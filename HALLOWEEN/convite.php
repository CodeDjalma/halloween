<?php 
session_start(); 

if (isset($_SESSION['formOk']) && $_SESSION['formOk'] === 1) {
    unset($_SESSION['formOk']);
} else {
    header("Location: erro.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Convite para Festa de Halloween</title>
    <style>
        body {
    background-color: #282c34;
    color: #f5f5f5;
    font-family: 'Arial', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.invite {
    background-color: #3e3e3e;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    padding: 30px;
    text-align: center;
    width: 400px; /* Define a largura do convite */
    position: relative;
    overflow: hidden;
}

.invite h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #ffcc00; /* Cor do título */
}

.date, .time, .location, .description, .rsvp {
    font-size: 1.2rem;
    margin: 10px 0;
}

.rsvp {
    font-weight: bold;
}

.rsvp-button {
    background-color: #ff5733;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background-color 0.3s;
}

.rsvp-button:hover {
    background-color: #c70039; /* Cor do botão ao passar o mouse */
}

    </style>    
</head>
<body>
    <div class="container">
        <div class="invite">
            <h1>Convite para a Festa de Halloween!</h1>
            <p class="date">Data: 31 de Outubro</p>
            <p class="time">Horário: 19:00</p>
            <p class="location">Local: Rua das Abóboras, 123</p>
            <p class="description">Venha se divertir com muita música, comida gostosa e surpresas horripilantes!</p>
            <p class="rsvp">Confirme sua presença até o dia 25 de Outubro.</p>
            <button class="rsvp-button">Confirmar Presença</button>
        </div>
    </div>
</body>
</html>
