<?php
include "conn.php";

$id = $_GET['id'];

$sqlQuery = "DELETE FROM `tbpacientes` WHERE `paciente` = ".$id;

if ($conn->query($sqlQuery) === TRUE) {
    $msg = "Registro excluído com sucesso";            
} else {
    $msg = "ERRO SQL: ".$sqlQuery." - Mensagem do Servidor: ".$conn->error;
}  
echo '<script>alert("'.$msg.'");window.location.href="../pacientes.php";</script>';

$conn->close();
?>