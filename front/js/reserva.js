const controller = "ReservaController"
const veiculoController = "VeiculoController"
const apiFunc = "http://201.49.127.157:9003/gesstor/App/API/funcionarios.php"
const apiCont = "http://201.49.127.157:9003/gesstor/App/API/contratos.php"
var funcionarioApi = {}
$(document).ready(function(){

inicio();

function inicio(){
    busca_veiculos()
    limpar_campos()
    apiFuncionarios()
    apiContratos()    
    $('#modal_principal').modal('hide')
}
function cleanInfo(){

    document.querySelector("#veic").innerHTML = ""
    document.querySelector("#func").innerHTML = ""
    document.querySelector("#validadeCNH").innerHTML = ""
    document.querySelector("#said").innerHTML = ""
    document.querySelector("#reto").innerHTML = ""
    document.querySelector("#reto_prev").innerHTML = ""
    document.querySelector("#loca").innerHTML = ""
    document.querySelector("#cont").innerHTML = ""
    document.querySelector("#obse").innerHTML = ""
}

function carregar_campos(){

    inputFile = document.querySelector('input[type="file"]')

    formData = new FormData();
    let id_veiculo = document.querySelector("#id_veiculo").value;
    let id_funcionario = document.querySelector("#id_funcionario").value;
    let data_saida = document.querySelector("#data_saida").value;
    let data_retorno = document.querySelector("#data_retorno").value;
    let data_retorno_previsto = document.querySelector("#data_retorno_previsto").value;
    let local = document.querySelector("#local").value;
    let id_contrato = document.querySelector("#id_contrato").value;
    let observacao = document.querySelector("#observacao").value;
    let id = document.querySelector("#id").value;

    formData.append('id_veiculo', id_veiculo);
    formData.append('observacao', observacao);
    formData.append('id_funcionario', id_funcionario);
    formData.append('data_saida', data_saida);
    formData.append('data_retorno', data_retorno);
    formData.append('data_retorno_previsto', data_retorno_previsto);
    formData.append('local', local);
    formData.append('id_contrato', id_contrato);
    formData.append('id', id);

    return formData;
}

function limpar_campos(){
    
    let id_veiculo = document.querySelector("#id_veiculo").value = "";
    let observacao = document.querySelector("#observacao").value = "";
    let id_funcionario = document.querySelector("#id_funcionario").value = "";    
    let data_saida = document.querySelector("#data_saida").value = "";
    let data_retorno = document.querySelector("#data_retorno").value = "";
    let data_retorno_previsto = document.querySelector("#data_retorno_previsto").value = "";
    let local = document.querySelector("#local").value = "";
    let id_contrato = document.querySelector("#id_contrato").value = "";
    let id = document.querySelector("#id").value = "";

}

function preencher_form(data){
    
    let id_veiculo = data.id_veiculo;
    let observacao = data.observacao;
    let id_funcionario = data.id_funcionario;
    let data_saida = data.data_saida;
    let data_retorno = data.data_retorno;
    let data_retorno_previsto = data.data_retorno_previsto;
    let local = data.local;
    let id_contrato = data.id_contrato;
    let id = data.id;

    $('#modal_principal').modal('show')
    document.querySelector("#id_veiculo").value = id_veiculo
    document.querySelector("#id_funcionario").value = id_funcionario
    document.querySelector("#data_saida").value = data_saida.replace(" ","T")
    document.querySelector("#data_retorno").value = data_retorno.replace(" ","T")
    document.querySelector("#data_retorno_previsto").value = data_retorno_previsto.replace(" ","T")
    document.querySelector("#local").value = local
    document.querySelector("#id_contrato").value = id_contrato
    document.querySelector("#observacao").value = observacao
    document.querySelector("#id").value = id
    
}

$(document).on('click','#abrir_modal',function(){
    $('#modal_principal').modal('show')
})


$(document).on('click','.info',async function(){
    cleanInfo()
    id = $(this).data("id");
    await info(id)
    $("#loadingInfo").show()
    $('#modal_info').modal('show')
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

function doisDigitos(n){
    if(n < 10){
        n = 0+""+n;
    }   
    return n
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

            cor="";

            d = new Date();

            ano = d.getFullYear(); 
            mes = doisDigitos(d.getMonth()+1); 
            dia = doisDigitos(d.getDate()); 
            hora = doisDigitos(d.getHours()); 
            minuto = doisDigitos(d.getMinutes()); 
            segundo = doisDigitos(d.getSeconds()); 

            saida = ano+""+mes+""+dia+""+hora+""+minuto+""+segundo;
            saidaR = dados[linha].data_saida.replace(" ","").replace(":","").replace(":","").replace("-","").replace("-","")
            
            if(dados[linha].data_retorno == "0000-00-00 00:00:00"){
                cor="table-warning";
            }
            
            if(parseInt(saidaR) > parseInt(saida)){
                cor="table-danger";
            }

            grid +=
            `
                <tr class=${cor}>
                    <td>${dados[linha].marca} ${dados[linha].modelo} - ${dados[linha].placa}</td>
                    <td>${dados[linha].data_saida}</td>
                    <td>${dados[linha].data_retorno}</td>
                    <td>${dados[linha].data_retorno_previsto}</td>
                    <td>${funcionarioApi[dados[linha].id_funcionario].nome}</td>
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
        funcionarioApi = data
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
        
        grid_principal();
        
    })
    .catch(console.error);
}

$(document).on("change","#id_funcionario",function(){
    let id_func = $(this).val()
    let cnh = funcionarioApi[id_func].cnh
    let validade = funcionarioApi[id_func].validadeCNH
    let categoria = funcionarioApi[id_func].categoriaCNH

    let data = new Date()

    let dataAtual = data.getFullYear()+"/"+(data.getMonth()+1)+"/"+data.getDate()

    let color = 'alert-danger'
    if(compareDataEN(dataAtual,validade)){
        color = 'alert-primary'
    }
    
    $('#alert_cnh').html("CNH: "+cnh)
    $('#alert_validade').html("VALIDADE: "+dataENBR(validade))
    $('#alert_categoria').html(categoria)

    $('.alert-cnh').removeClass('alert-danger')
    $('.alert-cnh').removeClass('alert-primary')
    $('.alert-cnh').addClass(color)
})

function dataENBR(data){
    let arrData = data.split('-')
    return arrData[2] +"/"+arrData[1] +"/"+arrData[0]
}

function compareDataEN(data1,data2) {

    let d1 = parseInt(data1.replaceAll('/','').replaceAll('-',''))
    let d2 = parseInt(data2.replaceAll('/','').replaceAll('-',''))

    console.log(d1+"<="+d2)
    if(d1 <= d2) {
        console.log("s");
        return true
    }
    console.log("n");

    return false
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
$(document).on('click','#imprimir',function(){

    var conteudo = document.getElementById('imp_info').innerHTML
    tela_impressao = window.open('about:blank');
    tela_impressao.document.write(conteudo);
    setTimeout(function(){
        tela_impressao.window.print();

    },1000)
    // tela_impressao.window.close();
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


async function info(id){

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
            
        document.querySelector("#veic").innerHTML = linha.marca+" "+linha.modelo+" - "+linha.placa
        document.querySelector("#func").innerHTML = linha.funcionario
        document.querySelector("#validadeCNH").innerHTML = "Validade da CNH: "+dataENBR(funcionarioApi[linha.id_funcionario].validadeCNH || '0000-00-00')
        document.querySelector("#said").innerHTML = linha.data_saida
        document.querySelector("#reto").innerHTML = linha.data_retorno
        document.querySelector("#reto_prev").innerHTML = linha.data_retorno_previsto
        document.querySelector("#loca").innerHTML = linha.local
        document.querySelector("#cont").innerHTML = linha.contrato
        document.querySelector("#obse").innerHTML = nl2br("<br>"+linha.observacao)

        $("#loadingInfo").hide()
        return true
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
