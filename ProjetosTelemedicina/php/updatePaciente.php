<?php
include "conn.php";

$id = $_GET['id'];
$nome = $_POST['inputPacienteNome'];
$cpf = $_POST['inputCPF'];
$plano = isset($_POST['inputPlano']) ? 1 : 0;
$dataNascimento = $_POST['inputDataNascimento'];

$sqlQuery = "UPDATE `tbpacientes` SET 
             `nome` = '$nome', 
             `cpf` = '$cpf', 
             `plano` = '$plano', 
             `data_nascimento` = '$dataNascimento' 
             WHERE `paciente` = $id";

if ($conn->query($sqlQuery) === TRUE) {
    $msg = "Registro atualizado com sucesso";            
} else {
    $msg = "ERRO SQL: ".$sqlQuery." - Mensagem do Servidor: ".$conn->error;
}  
echo '<script>alert("'.$msg.'");window.location.href="../pacientes.php";</script>';

$conn->close();
?>