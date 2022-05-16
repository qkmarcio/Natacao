var jsModalidade = {};

var formCadastro;

jsModalidade.mask = function () {
//    $("#modalidade_telefone").mask('(99) 9999-9999');
//    $("#modalidade_celular").mask('(99) 99999-9999');
//    $("#modalidade_cpf").mask('999.999.999-99');
//    $("#modalidade_cep").mask('99999-999');
};

jsModalidade.eventos = function () {
    $("#insert").val('insert');

    $('#inpBuscar').focus();

    $('#inpBuscar').on('change', function (evet) {

        let FData = new FormData();
        FData.set("action", "vBuscaAll");//nome da funcao no PHP
        FData.set("where", evet.target.value);//passo os campos PHP

        var json = jsModalidade.ajax(FData);

        try {
            jsModalidade.tableList(json);

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
        jsModalidade.editar(id);
    });

    //Quando o Form esta show modal
    $('#formCadastro').on('shown.bs.modal', function () {

        $("#modalidade_nome").focus();
        jsModalidade.ValidaForm();

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
jsModalidade.ValidaForm = function () {

    formCadastro = $('#formCadastro').validate({
        debug: true,
        ignore: '*:not([name])',
        rules: {
            modalidade_nome: {
                required: true
            }
        },
        messages: {
            modalidade_nome:"Coloque uma Modalidade"

        },
        submitHandler: function (form) {
            //alert('inside');

            let Form = jsModalidade.getForm();

            Form.set("action", "vCadastro"); //nome da funcao no PHP

            if (jsModalidade.ajax(Form, 'vCadastro')) {
                $("#formCadastro").modal('hide');

                jsModalidade.getlista();

                swal('Registo...', jsModalidade.msg, 'success');
            }

        }
    });
}

jsModalidade.getForm = function () {

    let FData = new FormData();
    FData.set('insert', $("#insert").val());
    FData.set('id', $("#modalidade_id").val());
    FData.set('nome', $("#modalidade_nome").val());
    FData.set('obs', $("#modalidade_obs").val());
    FData.set('ativado', $("#modalidade_ativado").val());

    return FData;

};

jsModalidade.setForm = function (obj) {
    $("#modalidade_id").val(obj.id);
    $("#modalidade_nome").val(obj.nome);
    $("#modalidade_obs").val(obj.obs);
    $("#modalidade_ativado").val(obj.ativado);
};

jsModalidade.tableList = function (json) {
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

jsModalidade.getlista = function () {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP

    var json = jsModalidade.ajax(FData);

    try {
        jsModalidade.tableList(json);

    } catch (erro) {
        $('#ListView').empty();
        //$('#ListView').append("<tr>PROFESSORES NÃO LOCALIZADO !</tr>");
    }
};

jsModalidade.salvar = function () {

    let Form = jsModalidade.getForm();

    Form.set("action", "vCadastro"); //nome da funcao no PHP

    if (jsModalidade.ajax(Form, 'vCadastro')) {
        $("#formCadastro").modal('hide');

        jsModalidade.getlista();

        swal('Registo...', jsModalidade.msg, 'success');
    }
};

jsModalidade.editar = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP
    FData.set("where", "where modalidade_id=" + id);//passo os campos PHP

    var json = jsModalidade.ajax(FData, 'vLocalizar');

    jsModalidade.setForm(json.dados[0]);

    $(".modal-title").text('Editar Cadastro');
    $("#insert").val('update');
    $("#formCadastro").modal("show");
};

jsModalidade.ajax = function (FormData, action, v) {
    var view = v == null ? '../view/vModalidade.php' : v;
    var retorno;
    $.ajax({
        url: view, type: "POST", data: FormData, dataType: "json", async: false, processData: false, contentType: false,
        success: function (php) {
            jsModalidade.msg = php.messages;
            retorno = php;
        },
        error: function (php) {
            //debugger;
            //var responseText = JSON.parse(php.responseText);
            jsModalidade.msg = php.responseText;
            swal('Oops...', jsModalidade.msg, 'error');

            retorno = false;
        }
    });
    return retorno;

};

jsModalidade.start = function () {
    jsModalidade.eventos();

    jsModalidade.mask();

    jsModalidade.getlista();

};

jsModalidade.start();