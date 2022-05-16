/* 
 * Marcio O. de Souza - 12/10/2017 - Criação do arquivo
 * 
 * 
 */

var jUsuario = {};

$('#UsuarioModal').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

    var obj = new Object();
    obj.usu_id = $("#usuarioID").val();

    var json = jUsuario.ajax(obj, 'buscaId');
    var v = json.data[0];
    $("#p_usu_id").val(v.usu_id);
    $("#p_usu_login").val(v.usu_login);
    $("#p_usu_nome").val(v.usu_nome);
    $("#p_usu_senha").val('0');



    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(recipient);
    //modal.find('.modal-body input').val(recipient);

    //verificar se é usuario marcio para add um novo
    if (v.usu_id == 1) {
        $("#Usuario_novo").show();
    }
});

$('#Usuario_novo').click(function () {
    var modal = $('#UsuarioModal');

    modal.find('.modal-title').text('Nuevo Usuario');

    modal.find('input').val('');
    $("#p_usu_id").val('0'); // deixa o id como (novo) para validar quando inserir um novo
});

$('#Usuario_salvar').click(function () {

    var obj = new Object();
    obj.usu_id = $("#p_usu_id").val();
    obj.usu_login = $("#p_usu_login").val();
    obj.usu_nome = $("#p_usu_nome").val();
    obj.usu_senha = $("#p_usu_senha").val();


    if (obj.usu_id === '0') {
        jUsuario.Inserir(obj);

    } else {
        jUsuario.Alterar(obj);
    }

});       // BOTAO NOVA AUTORIZACAO

$('#p_usu_senha').on('keypress', function (e) {
    if (e.keyCode == 13) {
        $("#Usuario_salvar").click();
    }
});

jUsuario.Inserir = function (obj) {
    var json = jUsuario.ajax(obj, 'insert');
    alert(json.message);
    $('#UsuarioModal').modal('hide');
};
jUsuario.Alterar = function (obj) {
    var json = jUsuario.ajax(obj, 'update');
    alert(json.message);
    $('#UsuarioModal').modal('hide');
};

jUsuario.Buscar = function (value) {
    var obj = new Object();
    obj.usu_id = value;
    var json = jUsuario.ajax(obj, 'buscaId');
    var v = json.data;
    return v;
};

jUsuario.ajax = function (obj, funcao, v) {                                      // FUNCAO RESPONSAVEL POR CONVERSAR COM A VIEW        
    var view = v == null ? '../view/vUsuario.php' : v;                           // CAMINHO DA VIEW
    var data = {'obj': obj, 'funcao': funcao};                                   // SETA OS PARAMETROS
    var retorno;                                                                 // VAR DE RETORNO
    $.ajax({type: "POST", url: view, dataType: "json", data: data, async: false, // FAZ UM AJAX SINCRONIZADO COM A FUNCAO
        success: function (json) {
            retorno = json;
        }, // RETORNO DO AJAX NO SUCCESS
        error: function () {
            retorno = null;
        }                                                                        // RETORNO DO AJAX NO ERROR
    });                                                                          // FIM DO AJAX
    return retorno;                                                              // RETORNAR
};                                                                               // FIM DA FUNCAO AJAX



