<?php
include "conn.php";

$nome = $_POST['inputPacienteNome'];
$cpf = $_POST['inputCPF'];
$plano = isset($_POST['inputPlano']) ? 1 : 0;
$dataNascimento = $_POST['inputDataNascimento'];

$sqlQuery = "INSERT INTO `tbpacientes` (`nome`, `cpf`, `plano`, `data_nascimento`) 
             VALUES ('$nome', '$cpf', '$plano', '$dataNascimento')";

if ($conn->query($sqlQuery) === TRUE) {
    $msg = "Registro incluído com sucesso";            
} else {
    $msg = "ERRO SQL: ".$sqlQuery." - Mensagem do Servidor: ".$conn->error;
}  
echo '<script>alert("'.$msg.'");window.location.href="../pacientes.php";</script>';

$conn->close();
?>