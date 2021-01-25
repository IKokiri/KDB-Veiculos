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
        <th scope="col">Marca</th>
        <th scope="col">Modelo</th>
        <th scope="col">Placa</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Veículo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- FORM -->
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Marca</label>
                <input type="text" class="form-control" id="marca">
              </div>

              <div class="form-group col-md-6">
                <label for="inputEmail4">Modelo</label>
                <input type="text" class="form-control" id="modelo">
              </div>

              <div class="form-group col-md-6">
                <label for="inputEmail4">Placa</label>
                <input type="text" class="form-control" id="placa">
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
  <?php
      include "footer.php"
    ?>
    <script src="./js/base_alert.js"></script>
    <script src="./js/veiculo.js"></script>
</body>
</html>