<?php
include "conn.php";

$id = $_GET['id'];
$medico = $_POST['inputMedico'];
$paciente = $_POST['inputPaciente'];
$dataConsulta = $_POST['inputDataConsulta'];
$horarioConsulta = $_POST['inputHorarioConsulta'];

$sqlQuery = "UPDATE `tbconsultas` SET 
             `medico_FK` = '$medico', 
             `paciente_FK` = '$paciente', 
             `data` = '$dataConsulta', 
             `horario` = '$horarioConsulta' 
             WHERE `consulta` = $id";

if ($conn->query($sqlQuery) === TRUE) {
    $msg = "Consulta atualizada com sucesso";            
} else {
    $msg = "ERRO SQL: ".$sqlQuery." - Mensagem do Servidor: ".$conn->error;
}  
echo '<script>alert("'.$msg.'");window.location.href="../consultas.php";</script>';

$conn->close();
?>