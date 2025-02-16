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
  $formAction = 'php/insertPaciente.php';

  if(!is_null($alteraID)){
    $sql = "SELECT `nome`, `cpf`, `plano`, `data_nascimento` FROM `tbpacientes` WHERE `paciente` =" . $alteraID;    
    $result = $conn->query($sql); 
    $row = $result->fetch_assoc();

    $btnAlterar = true;
    $formAction = 'php/updatePaciente.php?id='.$alteraID;
    $nomeInput = $row["nome"];
    $cpfInput = $row["cpf"];
    $planoInput = $row["plano"];
    $data_nascimentoInput = $row["data_nascimento"];
  }

  include 'topSite.html'; // Inclui cabecalho padrao
?>

<div class="container-fluid pr-5 pl-5">
  <div class="card mt-4 mb-4">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-user-injured mr-2"></i>Cadastro de Pacientes</h3>
    </div>
    <div class="card-body">
      <form action="<?php echo $formAction; ?>" method="post">
        <div class="form-group">
          <label class="font-weight-bold">Nome:</label>
          <input type="text" class="form-control" name="inputPacienteNome" placeholder="Digite o nome" value="<?php echo isset($nomeInput) ? $nomeInput : ''; ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">CPF:</label>
          <input type="text" class="form-control" name="inputCPF" placeholder="Digite o CPF" value="<?php echo isset($cpfInput) ? $cpfInput : ''; ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Plano:</label>
          <input type="checkbox" class="form-control" name="inputPlano" <?php echo (isset($planoInput) && $planoInput == '1') ? 'checked' : ''; ?>>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Data de Nascimento:</label>
          <input type="date" class="form-control" name="inputDataNascimento" value="<?php echo isset($data_nascimentoInput) ? $data_nascimentoInput : ''; ?>" required>
        </div>
        <!-- Armazena o ID Para alter -->
        <input type="text" class="form-control" id="idPaciente" style="display:none">
        <?php 
          if ($btnAlterar){
        ?>        
          <input class="btn btn-primary" style="width:120px" type="submit" value="Alterar">
          <a class="btn btn-secondary" href="pacientes.php" style="width:120px" role="submit">Cancelar</a>
          
          <?php } else { ?>
            <input class="btn btn-primary" style="width:120px" type="submit" value="Cadastrar">
        <?php } ?>
      </form>

      <hr class="mt-5">
      <h3 class="card-title mt-4 mb-4">Pacientes Cadastrados</h3>      
      <table id="tbPacientes" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Plano</th>
            <th>Data de Nascimento</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>       
<?php
    
  $sql = "SELECT `paciente`, `nome`, `cpf`, `plano`, `data_nascimento` 
           FROM `tbpacientes` 
          ORDER BY `nome`";
  $result = $conn->query($sql);  
  while($row = $result->fetch_assoc()) {
    $dataNascimento = date_create($row["data_nascimento"]);
    $dataNascimentoFormatada = date_format($dataNascimento,"d/m/Y");    
    echo '<TR>';
    echo '<TD>'. $row["paciente"] .'</TD>';
    echo '<TD>'. $row["nome"] .'</TD>';
    echo '<TD>'. $row["cpf"] .'</TD>';
    echo '<TD>'. ($row["plano"] == '1' ? 'Sim' : 'Não') .'</TD>';
    echo '<TD>'. $dataNascimentoFormatada .'</TD>';
    echo '<TD><a href="pacientes.php?altera='.$row["paciente"].'"><i class="fas fa-sync-alt text-info mr-3"></i></a><i redirect="php/deletePaciente.php?id='.$row["paciente"].'" class="fas fa-trash-alt text-danger" onclick="dialogDelete(this)" style="cursor:pointer"></i></TD>';
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



<script src="js/cadPacientes.js"></script>

</body>

</html>

<?php $conn->close(); ?>