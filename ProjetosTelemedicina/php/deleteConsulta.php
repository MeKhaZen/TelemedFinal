<?php
include "conn.php";

$id = $_GET['id'];

$sqlQuery = "DELETE FROM `tbconsultas` WHERE `consulta` = ".$id;

if ($conn->query($sqlQuery) === TRUE) {
    $msg = "Consulta excluída com sucesso";            
} else {
    $msg = "ERRO SQL: ".$sqlQuery." - Mensagem do Servidor: ".$conn->error;
}  
echo '<script>alert("'.$msg.'");window.location.href="../consultas.php";</script>';

$conn->close();
?>