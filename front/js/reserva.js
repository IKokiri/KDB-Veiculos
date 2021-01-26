const controller = "ReservaController"
const veiculoController = "VeiculoController"
const apiFunc = "http://201.49.127.157:9003/gesstor/App/API/funcionarios.php"
const apiCont = "http://201.49.127.157:9003/gesstor/App/API/contratos.php"

$(document).ready(function(){

inicio();

function inicio(){
    grid_principal();
    busca_veiculos()
    limpar_campos()
    apiFuncionarios()
    apiContratos()
    $('#modal_principal').modal('hide')
}

function carregar_campos(){

    inputFile = document.querySelector('input[type="file"]')

    formData = new FormData();
    let id_veiculo = document.querySelector("#id_veiculo").value;
    let id_funcionario = document.querySelector("#id_funcionario").value;
    let data_saida = document.querySelector("#data_saida").value;
    let data_retorno = document.querySelector("#data_retorno").value;
    let local = document.querySelector("#local").value;
    let id_contrato = document.querySelector("#id_contrato").value;
    let id = document.querySelector("#id").value;

    formData.append('id_veiculo', id_veiculo);
    formData.append('id_funcionario', id_funcionario);
    formData.append('data_saida', data_saida);
    formData.append('data_retorno', data_retorno);
    formData.append('local', local);
    formData.append('id_contrato', id_contrato);
    formData.append('id', id);

    return formData;
}

function limpar_campos(){

    let id_veiculo = document.querySelector("#id_veiculo").value = "";
    let id_funcionario = document.querySelector("#id_funcionario").value = "";    
    let data_saida = document.querySelector("#data_saida").value = "";
    let data_retorno = document.querySelector("#data_retorno").value = "";
    let local = document.querySelector("#local").value = "";
    let id_contrato = document.querySelector("#id_contrato").value = "";
    let id = document.querySelector("#id").value = "";

}

function preencher_form(data){

    let id_veiculo = data.id_veiculo;
    let id_funcionario = data.id_funcionario;
    let data_saida = data.data_saida;
    let data_retorno = data.data_retorno;
    let local = data.local;
    let id_contrato = data.id_contrato;
    let id = data.id;

    $('#modal_principal').modal('show')
    document.querySelector("#id_veiculo").value = id_veiculo
    document.querySelector("#id_funcionario").value = id_funcionario
    document.querySelector("#data_saida").value = data_saida.replace(" ","T")
    document.querySelector("#data_retorno").value = data_retorno.replace(" ","T")
    document.querySelector("#local").value = local
    document.querySelector("#id_contrato").value = id_contrato
    document.querySelector("#id").value = id
    
}

$(document).on('click','#abrir_modal',function(){
    $('#modal_principal').modal('show')
})


$(document).on('click','.info',function(){
    $('#modal_info').modal('show')
    id = $(this).data("id");
    info(id)
})

$('#modal_principal').on('hidden.bs.modal', function () {
    document.querySelector("#id").value = ""
  })

$(document).on('click','#salvar',function(){
    formData = carregar_campos()
    id = formData.get("id");

    if(id){
        update(formData)
    }else{
        criar(formData)
    }

})

$(document).on('click','#remover',function(){
    
    id = $(this).attr("data-id");
    
    var res = confirm("Deseja remover o registro?");
    if (res == true) {
        remover(id);
    } else {
    
    }
    
})

$(document).on('click','#edit',function(){

    $('#modal_principal').modal('show')
    id = $(this).attr("data-id");
    edit(id);
    
})

$(document).on("keyup","#buscar",function(){
    term = document.querySelector("#buscar").value;
    buscar(term)
})

function buscar(term){
    grid_principal(term);
}


function busca_veiculos(){

    formData = new FormData();

    formData.append('class', veiculoController);
  
        formData.append('method', 'read');
 
    

    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => { 
        optV = "<option value='0'>SELECIONE</option>"
        dados = data.result_array
        for(linha in dados){
            optV += 
            `
                <option value="${dados[linha].id}">
                    ${dados[linha].marca} - ${dados[linha].modelo} ${dados[linha].placa}
                </option>
            `
        }
        document.querySelector("#id_veiculo").innerHTML = optV
       
    })
    .catch(console.error);
}
function grid_principal(term = "",ini = 0,fim = 10){

    formData = new FormData();

    formData.append('class', controller);
    if(term){
        formData.append('method', 'filter');
        formData.append('term', term);
    }else{
        formData.append('method', 'readLimit');
    }
    
    formData.append('pagini', ini);    
    formData.append('pagfim', fim);

    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => { 
        grid = ""
        dados = data.result_array
        for(linha in dados){
            grid += 
            `
                <tr>
                    <td>${dados[linha].marca} ${dados[linha].modelo} - ${dados[linha].placa}</td>
                    <td>${dados[linha].data_saida}</td>
                    <td>${dados[linha].data_retorno}</td>
                    <td>${dados[linha].local}</td>
                    <td data-id="${dados[linha].id}" class='info'><img src="./icons/info.png"  alt=""></td>
                    <td data-id="${dados[linha].id}" id="edit"><img src="./icons/001-pencil.png"  alt=""></td>
                    <td data-id="${dados[linha].id}" id="remover"><img src="./icons/002-delete.png"  alt=""></td>
                </tr>
            `
        }
        document.querySelector(".grid").innerHTML = grid
       
        pagination(ini,fim,data.count);
    })
    .catch(console.error);
}

function apiFuncionarios(){
    opt = "<option value='0'>SELECIONE</option>";
    fetch(apiFunc)
    .then(response => response.json())
    .then(data => { 

        for(linha in data){
            opt += `<option value='${data[linha].id}'>${data[linha].nome}</option>`;
        }

        
        document.querySelector("#id_funcionario").innerHTML = opt
        
        
    })
    .catch(console.error);
}

function apiContratos(){
    optC = "<option value='0'>SELECIONE</option>";
    fetch(apiCont)
    .then(response => response.json())
    .then(data => { 

        for(linha in data){
            optC += `<option value='${data[linha].id_scon}'>${data[linha].contrato}</option>`;
        }

        
        document.querySelector("#id_contrato").innerHTML = optC
        
        
    })
    .catch(console.error);
}

function pagination(ini,fim = 10,count){
    
    ini = parseInt(ini);
    fim = parseInt(fim);
   
    pag = ` <li class="page-item anterior" data-ini=${ini-10}  data-fim=${fim}><a class="page-link" href="javascript:void(0)"><<</a></li>
    <li class="page-item"><a class="page-link" href="javascript:void(0)">${ini+1} a ${ini+10}</a></li>
    <li class="page-item proximo"  data-ini=${ini+10}  data-fim=${fim}><a class="page-link" href="javascript:void(0)">>></a></li>`
    document.querySelector(".pagination").innerHTML = pag
   
}

$(document).on('click','.anterior',function(){
  
    ini = $(this).attr("data-ini");
    fim = $(this).attr("data-fim");
    ini = parseInt(ini);
    fim = parseInt(fim);
    if(ini < 0){
        return;
    }
    grid_principal("",ini,fim)
})


$(document).on('click','.proximo',function(){
    ini = $(this).attr("data-ini");
    fim = $(this).attr("data-fim");
    ini = parseInt(ini);
    fim = parseInt(fim);
    grid_principal("",ini,fim)
})

// CRIAR
function criar(formData){
    
    formData = carregar_campos();
    formData.append('class', controller);
    formData.append('method', 'create');
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
            inicio()
        })
        .catch(console.error);
}

function remover(id){
    
    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'delete');
    formData.append('id', id);
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }      
            inicio()
        })
        .catch(console.error);
}


function info(id){

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'getId');
    formData.append('id', id);
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
            linha = data.result_array[0];
            console.log(linha)
        })
        .catch(console.error);
}

function edit(id){

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'getId');
    formData.append('id', id);
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
            $linha = data.result_array[0];
            preencher_form($linha);

        })
        .catch(console.error);
}

function update(formData){

    formData.append('class', controller);
    formData.append('method', 'update');
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }      
            inicio()
        })
        .catch(console.error);
}



})
