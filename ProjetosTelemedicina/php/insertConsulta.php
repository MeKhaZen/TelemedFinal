<?php
include "conn.php";

$medico = $_POST['inputMedico'];
$paciente = $_POST['inputPaciente'];
$dataConsulta = $_POST['inputDataConsulta'];
$horarioConsulta = $_POST['inputHorarioConsulta'];

$sqlQuery = "INSERT INTO `tbconsultas` (`medico_FK`, `paciente_FK`, `data`, `horario`) 
             VALUES ('$medico', '$paciente', '$dataConsulta', '$horarioConsulta')";

if ($conn->query($sqlQuery) === TRUE) {
    $msg = "Consulta incluída com sucesso";            
} else {
    $msg = "ERRO SQL: ".$sqlQuery." - Mensagem do Servidor: ".$conn->error;
}  
echo '<script>alert("'.$msg.'");window.location.href="../consultas.php";</script>';

$conn->close();
?>