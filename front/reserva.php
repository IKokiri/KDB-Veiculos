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
        <th scope="col">Retorno Previsto</th>
        <th scope="col">Funcionário</th>
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
          <div class="alert-cnh alert" role="alert">
            <span id="alert_cnh"></span>
            <span id="alert_categoria"></span>
            <span id="alert_validade"></span>
          </div>
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
                <label for="inputEmail4">Retorno Previsto</label>
                <input class="form-control" type="datetime-local" name="" id="data_retorno_previsto">
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
              <div class="form-group col-md-12">
                <label for="inputEmail4">Observação</label>
                <textarea  class="form-control" id="observacao"></textarea>
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
        <div class="spinner-border" id="loadingInfo" role="status">
          <span class="sr-only">Loading...</span>
        </div>
          <h5 class="modal-title" id="exampleModalLabel">Informações</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="imp_info">
        <table width="100%">
        <tr>
          <td>
        <h4>Requisição de veículo</h4>
          </td>
          <td align="right">
          <img src="icons/logo.png">

          </td>
        </tr>
        </table>
        <p>
        O Sr(a). <span id="func"></span> 
        </p>
        <p>
        habilitado, está autorizado a utilizar o Veículo </h5><span id="veic"></span>
        </p>
        <span id="validadeCNH"></span>
        <br/>
        <br/>
        <p>
        Contrato/C.Custo: <span id="cont"></span>
       </p>
       <p>
       Saída: <span id="said"></span> 
       </p>
       <p>
       
       Retorno Previsto: <span id="reto_prev"></span> 
       </p>
       <p>
       Retorno:
       <span id="reto"></span>.
       </p>
        <p>
         Destino: <span id="loca"></span>
        </p>
        <p>Hora ___:___:____ Data__/__/____ Km __________ Tanque____\____|____/____ Visto ____________</p>
        <p>Hora ___:___:____ Data__/__/____ Km __________ Tanque____\____|____/____ Visto ____________</p>
        <p>
        Observações:<span id="obse"></span></p>
        <hr/>
        <ol>
          <li>As multas referentes a infrações de trânsito são de responsabilidade do motorista;</li>
          <li>Devolva o veículo com, no mínimo, ¼ de tanque de combustível;</li>
          <li>Anote no verso anormalidades de funcionamento ou necessidade de manutenção;</li>
          <li>Use o cinto de segurança-obrigatório a partir de 23/01/98;</li>
          <li>Em caso de acidentes, deverá ser feita ocorrência policial. </li>
        </ol>
        <p>Autorizado pelo Setra</p>

        <center>
          <br>
        <p>________________________________</p>
        <p>Assinatura motorista</p>
      </center>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="imprimir" class="btn btn-primary">Imprimir</button>
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