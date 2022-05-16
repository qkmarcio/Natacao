var jsTipoReceita = {};

var formCadastro;

jsTipoReceita.mask = function () {
//    $("#tipo_receita_telefone").mask('(99) 9999-9999');
//    $("#tipo_receita_celular").mask('(99) 99999-9999');
//    $("#tipo_receita_cpf").mask('999.999.999-99');
//    $("#tipo_receita_cep").mask('99999-999');
};

jsTipoReceita.eventos = function () {
    $("#insert").val('insert');

    $('#inpBuscar').focus();

    $('#inpBuscar').on('change', function (evet) {

        let FData = new FormData();
        FData.set("action", "vBuscaAll");//nome da funcao no PHP
        FData.set("where", evet.target.value);//passo os campos PHP

        var json = jsTipoReceita.ajax(FData);

        try {
            jsTipoReceita.tableList(json);

        } catch (erro) {
            $('#ListView').empty();

        }

    });


    //escuta o click da class .btn-link da lista de professores
    $('table').on('click', '.btn-link', function (e) {
        var id = $(this).closest('tr').children('td:first').text();

        if ($(this).attr("title") == 'Visualizar') {
            $(".modal-body :input").each(function () {
                $(this).attr("disabled", true);
            });
        }
        ;
        jsTipoReceita.editar(id);
    });

    //Quando o Form esta show modal
    $('#formCadastro').on('shown.bs.modal', function () {

        $("#tipo_receita_nome").focus();
        jsTipoReceita.ValidaForm();

    });

    //Quando o Form esta hide modal
    $('#formCadastro').on('hide.bs.modal', function () {
        $("#inpBuscar").focus();
        $(".limpar").val(''); //Limpar os tudo com esta class
        $(".modal-body :input").each(function () {
            $(this).attr("disabled", false);
        });

        if (formCadastro.valid() == false) {
            formCadastro.destroy();
        }

        //Deixa o Form padrão para fazer o insert
        $("#insert").val('insert');
    });
};

// O submit do form que chama esta funcao
jsTipoReceita.ValidaForm = function () {

    formCadastro = $('#formCadastro').validate({
        debug: true,
        ignore: '*:not([name])',
        rules: {
            tipo_receita_nome: {
                required: true
            }
        },
        messages: {
            tipo_receita_nome:"Coloque um Tipo de Receita"

        },
        submitHandler: function (form) {
            //alert('inside');

            let Form = jsTipoReceita.getForm();

            Form.set("action", "vCadastro"); //nome da funcao no PHP

            if (jsTipoReceita.ajax(Form, 'vCadastro')) {
                $("#formCadastro").modal('hide');

                jsTipoReceita.getlista();

                swal('Registo...', jsTipoReceita.msg, 'success');
            }

        }
    });
}

jsTipoReceita.getForm = function () {

    let FData = new FormData();
    FData.set('insert', $("#insert").val());
    FData.set('id', $("#tipo_receita_id").val());
    FData.set('nome', $("#tipo_receita_nome").val());
    FData.set('obs', $("#tipo_receita_obs").val());
    FData.set('ativado', $("#tipo_receita_ativado").val());

    return FData;

};

jsTipoReceita.setForm = function (obj) {
    $("#tipo_receita_id").val(obj.id);
    $("#tipo_receita_nome").val(obj.nome);
    $("#tipo_receita_obs").val(obj.obs);
    $("#tipo_receita_ativado").val(obj.ativado);
};

jsTipoReceita.tableList = function (json) {
    var linha = '';
    var dados = json.dados;

    for (var i = 0; i < dados.length; i++) {

        var classe = "label label-danger";

        if (dados[i].ativado === "1") {
            classe = "label label-success";
        }

        switch (dados[i].ativado) {
            case '0':
                classe = "label label-danger";
                ativado = "INATIVO";
                break;
            case '1':
                classe = "label label-success";
                ativado = "ATIVO";
                break;
        }

        linha += '<tr class="visualiar">' +
                '<td class="col-1 text-center">' + dados[i].id + '</td>' +
                '<td class="col-5 text-left">' + dados[i].nome + '</td>' +
                '<td class="col-2 text-left">' + dados[i].data_cadastro + ' </td>' +
                '<td class="col-2 text-center" ><span class="' + classe + '">' + ativado + '</span> </td>' +
                '<td class="col-2 text-center" style="min-width: 100px;">\n\
                    <i class="btn-link fa bi-eye fa-lg" title="Visualizar"></i>\n\
                    <i class="btn-link fa bi-pencil-square fa-lg" title="Editar"></i>\n\
                </td>' +
                '</tr>';
    }

    $('#ListView').empty();
    $('#ListView').append(linha);
};

jsTipoReceita.getlista = function () {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP

    var json = jsTipoReceita.ajax(FData);

    try {
        jsTipoReceita.tableList(json);

    } catch (erro) {
        $('#ListView').empty();
        //$('#ListView').append("<tr>PROFESSORES NÃO LOCALIZADO !</tr>");
    }
};

jsTipoReceita.salvar = function () {

    let Form = jsTipoReceita.getForm();

    Form.set("action", "vCadastro"); //nome da funcao no PHP

    if (jsTipoReceita.ajax(Form, 'vCadastro')) {
        $("#formCadastro").modal('hide');

        jsTipoReceita.getlista();

        swal('Registo...', jsTipoReceita.msg, 'success');
    }
};

jsTipoReceita.editar = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP
    FData.set("where", "where tipo_receita_id=" + id);//passo os campos PHP

    var json = jsTipoReceita.ajax(FData, 'vLocalizar');

    jsTipoReceita.setForm(json.dados[0]);

    $(".modal-title").text('Editar Cadastro');
    $("#insert").val('update');
    $("#formCadastro").modal("show");
};

jsTipoReceita.ajax = function (FormData, action, v) {
    var view = v == null ? '../view/vTipoReceita.php' : v;
    var retorno;
    $.ajax({
        url: view, type: "POST", data: FormData, dataType: "json", async: false, processData: false, contentType: false,
        success: function (php) {
            jsTipoReceita.msg = php.messages;
            retorno = php;
        },
        error: function (php) {
            //debugger;
            //var responseText = JSON.parse(php.responseText);
            jsTipoReceita.msg = php.responseText;
            swal('Oops...', jsTipoReceita.msg, 'error');

            retorno = false;
        }
    });
    return retorno;

};

jsTipoReceita.start = function () {
    jsTipoReceita.eventos();

    jsTipoReceita.mask();

    jsTipoReceita.getlista();

};

jsTipoReceita.start();