var jsTipoDespesa = {};

var formCadastro;

jsTipoDespesa.mask = function () {
//    $("#tipo_despesa_telefone").mask('(99) 9999-9999');
//    $("#tipo_despesa_celular").mask('(99) 99999-9999');
//    $("#tipo_despesa_cpf").mask('999.999.999-99');
//    $("#tipo_despesa_cep").mask('99999-999');
};

jsTipoDespesa.eventos = function () {
    $("#insert").val('insert');

    $('#inpBuscar').focus();

    $('#inpBuscar').on('change', function (evet) {

        let FData = new FormData();
        FData.set("action", "vBuscaAll");//nome da funcao no PHP
        FData.set("where", evet.target.value);//passo os campos PHP

        var json = jsTipoDespesa.ajax(FData);

        try {
            jsTipoDespesa.tableList(json);

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
        jsTipoDespesa.editar(id);
    });

    //Quando o Form esta show modal
    $('#formCadastro').on('shown.bs.modal', function () {

        $("#tipo_despesa_nome").focus();
        jsTipoDespesa.ValidaForm();

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
jsTipoDespesa.ValidaForm = function () {

    formCadastro = $('#formCadastro').validate({
        debug: true,
        ignore: '*:not([name])',
        rules: {
            tipo_despesa_nome: {
                required: true
            }
        },
        messages: {
            tipo_despesa_nome:"Coloque um tipo de Despesa"

        },
        submitHandler: function (form) {
            //alert('inside');

            let Form = jsTipoDespesa.getForm();

            Form.set("action", "vCadastro"); //nome da funcao no PHP

            if (jsTipoDespesa.ajax(Form, 'vCadastro')) {
                $("#formCadastro").modal('hide');

                jsTipoDespesa.getlista();

                swal('Registo...', jsTipoDespesa.msg, 'success');
            }

        }
    });
}

jsTipoDespesa.getForm = function () {

    let FData = new FormData();
    FData.set('insert', $("#insert").val());
    FData.set('id', $("#tipo_despesa_id").val());
    FData.set('nome', $("#tipo_despesa_nome").val());
    FData.set('obs', $("#tipo_despesa_obs").val());
    FData.set('ativado', $("#tipo_despesa_ativado").val());

    return FData;

};

jsTipoDespesa.setForm = function (obj) {
    $("#tipo_despesa_id").val(obj.id);
    $("#tipo_despesa_nome").val(obj.nome);
    $("#tipo_despesa_obs").val(obj.obs);
    $("#tipo_despesa_ativado").val(obj.ativado);
};

jsTipoDespesa.tableList = function (json) {
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

jsTipoDespesa.getlista = function () {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP

    var json = jsTipoDespesa.ajax(FData);

    try {
        jsTipoDespesa.tableList(json);

    } catch (erro) {
        $('#ListView').empty();
        //$('#ListView').append("<tr>PROFESSORES NÃO LOCALIZADO !</tr>");
    }
};

jsTipoDespesa.salvar = function () {

    let Form = jsTipoDespesa.getForm();

    Form.set("action", "vCadastro"); //nome da funcao no PHP

    if (jsTipoDespesa.ajax(Form, 'vCadastro')) {
        $("#formCadastro").modal('hide');

        jsTipoDespesa.getlista();

        swal('Registo...', jsTipoDespesa.msg, 'success');
    }
};

jsTipoDespesa.editar = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP
    FData.set("where", "where tipo_despesa_id=" + id);//passo os campos PHP

    var json = jsTipoDespesa.ajax(FData, 'vLocalizar');

    jsTipoDespesa.setForm(json.dados[0]);

    $(".modal-title").text('Editar Cadastro');
    $("#insert").val('update');
    $("#formCadastro").modal("show");
};

jsTipoDespesa.ajax = function (FormData, action, v) {
    var view = v == null ? '../view/vTipoDespesa.php' : v;
    var retorno;
    $.ajax({
        url: view, type: "POST", data: FormData, dataType: "json", async: false, processData: false, contentType: false,
        success: function (php) {
            jsTipoDespesa.msg = php.messages;
            retorno = php;
        },
        error: function (php) {
            //debugger;
            //var responseText = JSON.parse(php.responseText);
            jsTipoDespesa.msg = php.responseText;
            swal('Oops...', jsTipoDespesa.msg, 'error');

            retorno = false;
        }
    });
    return retorno;

};

jsTipoDespesa.start = function () {
    jsTipoDespesa.eventos();

    jsTipoDespesa.mask();

    jsTipoDespesa.getlista();

};

jsTipoDespesa.start();