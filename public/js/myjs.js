$(document).ready(function () {
    var DIRPAGE="http://"+document.location.hostname+"/"; //caminho absoluto

    $('#FormSelectCliente').on('submit', function (event) { //criando funcao de evento do formulario de selecao de clientes
        event.preventDefault(); //nao enviar formulario com refresh de pagina
        var Dados=$(this).serialize(); //enviar todos os dados
        $.ajax({
            url: DIRPAGE+'cadastrar_cliente/visualizar',
            method:'post',
            dataType:'html',
            data: Dados,
            success:function (Dados) {
                $('.resultadoPesquisa').html(Dados);

            }
        });
    });


    $(document).on('click','.ImageEdit',function(){
        var ImgRel=$(this).attr('rel');

        $.ajax({
            url: DIRPAGE+'cadastrar_cliente/puxaDB/'+ImgRel,
            method: 'post',
            dataType: 'html',
            data: {'usuario_id':ImgRel},
            success:function(data){
                $('.ResultadoFormulario').html(data);
            }
        });
    });

});