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

  $medicoID = $_GET['medico'];
  $formAction = 'historicoMedico.php';

  include 'topSite.html'; // Inclui cabecalho padrao
?>

<div class="container-fluid pr-5 pl-5">
  <div class="card mt-4 mb-4">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-user-md mr-2"></i>Histórico Médico</h3>
    </div>
    <div class="card-body">
      <form action="<?php echo $formAction; ?>" method="get">
        <div class="form-group">
          <label class="font-weight-bold">Médico:</label>
          <select class="form-control" name="medico" required>
            <option value="">Selecione</option>
<?php
  $sql = "SELECT `medico`, `nome` FROM `tbmedicos` ORDER BY `nome`";
  $result = $conn->query($sql);    
  while($row = $result->fetch_assoc()) {
    $selected = "";
    if($medicoID == $row["medico"]){
        $selected = "selected"; 
    }
    echo '<option value='.$row["medico"].' '.$selected.'>'.$row["nome"].'</option>';
  }
?>
          </select>
        </div>
        <input class="btn btn-primary" style="width:120px" type="submit" value="Buscar">
      </form>

      <hr class="mt-5">
      <h3 class="card-title mt-4 mb-4">Consultas do Médico</h3>      
      <table id="tbConsultasMedico" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Paciente</th>
            <th>Data da Consulta</th>
            <th>Horário da Consulta</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>       
<?php
  if (!is_null($medicoID)) {
    $sql = "SELECT `consulta`, `tbpacientes`.`nome` AS `pacienteNome`, `data`, `horario` 
             FROM `tbconsultas`
             JOIN `tbpacientes` ON `tbconsultas`.`paciente_FK` = `tbpacientes`.`paciente`
            WHERE `tbconsultas`.`medico_FK` = $medicoID
            ORDER BY `data`, `horario`";
    $result = $conn->query($sql);  
    while($row = $result->fetch_assoc()) {
      $dataConsulta = date_create($row["data"]);
      $dataConsultaFormatada = date_format($dataConsulta,"d/m/Y");    
      echo '<TR>';
      echo '<TD>'. $row["consulta"] .'</TD>';
      echo '<TD>'. $row["pacienteNome"] .'</TD>';
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
    $('#tbConsultasMedico').DataTable({
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