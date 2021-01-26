<?php
  include "nav.php"
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>
        
  <div class="text-center">
    <button class="btn btn-primary m-1" id="abrir_modal">
        +
    </button> 
  </div>
  
  <div class="col-10 offset-1" id="base_alert"></div>
  <table class="table table-bordered  table-hover col-10 offset-1">
    <thead>
      <tr>
        <th scope="col">Veículo</th>
        <th scope="col">Saída</th>
        <th scope="col">Retorno</th>
        <th scope="col">Local</th>
        <th scope="col">Info</th>
        <th scope="col">Alterar</th>
        <th scope="col">Remover</th>
      </tr>
    </thead>
    <tbody class="grid">
    </tbody>
  </table>
  <div class="offset-1">
      <nav aria-label="Page navigation example">
      <ul class="pagination">
      </ul>
      </nav>
  </div>
<!-- Modal -->
<div class="modal fade" id="modal_principal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reserva</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- FORM -->
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Veículo</label>
                <select  class="form-control" id="id_veiculo">
                </select>
              </div>
              
              <div class="form-group col-md-6">
                <label for="inputEmail4">Funcionário</label>
                <select  class="form-control" id="id_funcionario">
                </select>
              </div>
              
              
              <div class="form-group col-md-6">
                <label for="inputEmail4">Saída</label>
                <input  class="form-control" type="datetime-local" name="" id="data_saida">
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail4">Retorno</label>
                <input class="form-control" type="datetime-local" name="" id="data_retorno">
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail4">Local</label>
                <input class="form-control" type="text" name="" id="local">
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail4">Contrato</label>
                <select  class="form-control" id="id_contrato">
                </select>
              </div>
            </div>
            <input type="hidden" id="id">
          </form>
          <!-- FORM -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="salvar" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informações</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <h5>Veiculo: </h5><span id="veic"></span>
        <h5>Funcionario: </h5><span id="func"></span>
        <h5>Saída: </h5><span id="said"></span>
        <h5>Retorno: </h5><span id="reto"></span>
        <h5>Local: </h5><span id="loca"></span>
        <h5>Contrato: </h5><span id="cont"></span>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="salvar" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>
  <?php
      include "footer.php"
    ?>
    <script src="./js/base_alert.js"></script>
    <script src="./js/reserva.js"></script>
</body>
</html>