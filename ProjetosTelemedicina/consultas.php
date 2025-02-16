<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Resto do código -->
<?php
  include "php/conn.php";

  $alteraID = isset($_GET['altera']) ? $_GET['altera'] : null;
  $btnAlterar = false;
  $formAction = 'php/insertConsulta.php';

  if(!is_null($alteraID)){
    $sql = "SELECT `medico_FK`, `paciente_FK`, `data`, `horario` FROM `tbconsultas` WHERE `consulta` =" . $alteraID;    
    $result = $conn->query($sql); 
    $row = $result->fetch_assoc();

    $btnAlterar = true;
    $formAction = 'php/updateConsulta.php?id='.$alteraID;
    $medicoInput = $row["medico_FK"];
    $pacienteInput = $row["paciente_FK"];
    $dataConsultaInput = $row["data"];
    $horarioConsultaInput = $row["horario"];
  }

  include 'topSite.html'; // Inclui cabecalho padrao
?>

<div class="container-fluid pr-5 pl-5">
  <div class="card mt-4 mb-4">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-calendar-alt mr-2"></i>Cadastro de Consultas</h3>
    </div>
    <div class="card-body">
      <form action="<?php echo $formAction; ?>" method="post">
        <div class="form-group">
          <label class="font-weight-bold">Médico:</label>
          <select class="form-control" name="inputMedico" required>
            <option value="">Selecione</option>
<?php
  $sql = "SELECT `medico`, `nome` FROM `tbmedicos` ORDER BY `nome`";
  $result = $conn->query($sql);    
  while($row = $result->fetch_assoc()) {
    $selected = "";
    if(isset($medicoInput) && $medicoInput == $row["medico"]){
        $selected = "selected"; 
    }
    echo '<option value='.$row["medico"].' '.$selected.'>'.$row["nome"].'</option>';
  }
?>
          </select>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Paciente:</label>
          <select class="form-control" name="inputPaciente" required>
            <option value="">Selecione</option>
<?php
  $sql = "SELECT `paciente`, `nome` FROM `tbpacientes` ORDER BY `nome`";
  $result = $conn->query($sql);    
  while($row = $result->fetch_assoc()) {
    $selected = "";
    if(isset($pacienteInput) && $pacienteInput == $row["paciente"]){
        $selected = "selected"; 
    }
    echo '<option value='.$row["paciente"].' '.$selected.'>'.$row["nome"].'</option>';
  }
?>
          </select>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Data da Consulta:</label>
          <input type="date" class="form-control" name="inputDataConsulta" value="<?php echo isset($dataConsultaInput) ? $dataConsultaInput : ''; ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Horário da Consulta:</label>
          <input type="time" class="form-control" name="inputHorarioConsulta" value="<?php echo isset($horarioConsultaInput) ? $horarioConsultaInput : ''; ?>" required>
        </div>
        <!-- Armazena o ID Para alter -->
        <input type="text" class="form-control" id="idConsulta" style="display:none">
        <?php 
          if ($btnAlterar){
        ?>        
          <input class="btn btn-primary" style="width:120px" type="submit" value="Alterar">
          <a class="btn btn-secondary" href="consultas.php" style="width:120px" role="submit">Cancelar</a>
          
          <?php } else { ?>
            <input class="btn btn-primary" style="width:120px" type="submit" value="Cadastrar">
        <?php } ?>
      </form>

      <hr class="mt-5">
      <h3 class="card-title mt-4 mb-4">Consultas Cadastradas</h3>      
      <table id="tbConsultas" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Médico</th>
            <th>Paciente</th>
            <th>Data da Consulta</th>
            <th>Horário da Consulta</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>       
<?php
    
  $sql = "SELECT `consulta`, `tbmedicos`.`nome` AS `medicoNome`, `tbpacientes`.`nome` AS `pacienteNome`, `data`, `horario` 
           FROM `tbconsultas`
           JOIN `tbmedicos` ON `tbconsultas`.`medico_FK` = `tbmedicos`.`medico`
           JOIN `tbpacientes` ON `tbconsultas`.`paciente_FK` = `tbpacientes`.`paciente`
          ORDER BY `data`, `horario`";
  $result = $conn->query($sql);  
  while($row = $result->fetch_assoc()) {
    $dataConsulta = date_create($row["data"]);
    $dataConsultaFormatada = date_format($dataConsulta,"d/m/Y");    
    echo '<TR>';
    echo '<TD>'. $row["consulta"] .'</TD>';
    echo '<TD>'. $row["medicoNome"] .'</TD>';
    echo '<TD>'. $row["pacienteNome"] .'</TD>';
    echo '<TD>'. $dataConsultaFormatada .'</TD>';
    echo '<TD>'. $row["horario"] .'</TD>';
    echo '<TD><a href="consultas.php?altera='.$row["consulta"].'"><i class="fas fa-sync-alt text-info mr-3"></i></a><i redirect="php/deleteConsulta.php?id='.$row["consulta"].'" class="fas fa-trash-alt text-danger" onclick="dialogDelete(this)" style="cursor:pointer"></i></TD>';
    echo '</TR>';
  }
?>


        </tbody>             
      </table>
    </div>

  </div>
</div>
</div> <!-- DIV FORA DO ARQUIVO-->
</div> <!-- DIV FORA DO ARQUIVO-->
<!-- /#page-content-wrapper -->
</div> <!-- DIV FORA DO ARQUIVO-->
<!-- /#wrapper -->



<!-- Menu Toggle Script -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>

<script type="text/javascript" src="vendor/DataTables/datatables.min.js"></script>


<script src="js/cadConsultas.js"></script>

</body>

</html>

<?php $conn->close(); ?>