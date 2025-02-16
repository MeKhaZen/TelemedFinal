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

  $pacienteID = $_GET['paciente'];
  $formAction = 'historicoPaciente.php';

  include 'topSite.html'; // Inclui cabecalho padrao
?>

<div class="container-fluid pr-5 pl-5">
  <div class="card mt-4 mb-4">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-id-card mr-2"></i>Histórico Paciente</h3>
    </div>
    <div class="card-body">
      <form action="<?php echo $formAction; ?>" method="get">
        <div class="form-group">
          <label class="font-weight-bold">Paciente:</label>
          <select class="form-control" name="paciente" required>
            <option value="">Selecione</option>
<?php
  $sql = "SELECT `paciente`, `nome` FROM `tbpacientes` ORDER BY `nome`";
  $result = $conn->query($sql);    
  while($row = $result->fetch_assoc()) {
    $selected = "";
    if($pacienteID == $row["paciente"]){
        $selected = "selected"; 
    }
    echo '<option value='.$row["paciente"].' '.$selected.'>'.$row["nome"].'</option>';
  }
?>
          </select>
        </div>
        <input class="btn btn-primary" style="width:120px" type="submit" value="Buscar">
      </form>

      <hr class="mt-5">
      <h3 class="card-title mt-4 mb-4">Consultas do Paciente</h3>      
      <table id="tbConsultasPaciente" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Médico</th>
            <th>Data da Consulta</th>
            <th>Horário da Consulta</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>       
<?php
  if (!is_null($pacienteID)) {
    $sql = "SELECT `consulta`, `tbmedicos`.`nome` AS `medicoNome`, `data`, `horario` 
             FROM `tbconsultas`
             JOIN `tbmedicos` ON `tbconsultas`.`medico_FK` = `tbmedicos`.`medico`
            WHERE `tbconsultas`.`paciente_FK` = $pacienteID
            ORDER BY `data`, `horario`";
    $result = $conn->query($sql);  
    while($row = $result->fetch_assoc()) {
      $dataConsulta = date_create($row["data"]);
      $dataConsultaFormatada = date_format($dataConsulta,"d/m/Y");    
      echo '<TR>';
      echo '<TD>'. $row["consulta"] .'</TD>';
      echo '<TD>'. $row["medicoNome"] .'</TD>';
      echo '<TD>'. $dataConsultaFormatada .'</TD>';
      echo '<TD>'. $row["horario"] .'</TD>';
      echo '<TD><i redirect="php/deleteScripts.php?tabela=tbconsultas&id='.$row["consulta"].'" class="fas fa-trash-alt text-danger" onclick="dialogDelete(this)" style="cursor:pointer"></i></TD>';
      echo '</TR>';
    }
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

<script>
  $(document).ready(function() {
    $('#tbConsultasPaciente').DataTable({
      "paging": true,
      "pageLength": 10,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "language": {
        "paginate": {
          "previous": "Anterior",
          "next": "Próximo"
        },
        "search": "Buscar:",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ consultas",
        "infoEmpty": "Mostrando 0 a 0 de 0 consultas",
        "emptyTable": "Nenhuma consulta encontrada",
        "infoFiltered": "(filtrado de _MAX_ consultas no total)"
      }
    });
  });
</script>

<script src="js/cadMedicos.js"></script>

</body>

</html>

<?php $conn->close(); ?>