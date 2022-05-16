var jsContrato = {};

var formCadastro;

jsContrato.mask = function () {
    $("#con_meses").mask('99');
    $("#con_valor").mask('999.999.999,99', {reverse: true, maxlength: false});
};
jsContrato.eventos = function () {

    $("#con_valor").val('000');
    $("#insert").val('insert');
    //Buscar 
    $('#inpBuscar').focus();
    $('#inpBuscar').on('change', function (evet) {

        let FData = new FormData();
        FData.set("action", "vBuscaAll");//nome da funcao no PHP
        FData.set("where", evet.target.value);//passo os campos PHP

        var json = jsContrato.ajax(FData);

        try {
            jsContrato.tableList(json);

        } catch (erro) {
            $('#ListView').empty();
        }

    });

    //escuta o click da class .btn-link da lista das tables
    $('table').on('click', '.btn-link', function (e) {
        var id = $(this).closest('tr').children('td:first').text();
        var title = $(this).attr("title");

        jsContrato.click_table(id, title);

    });


    //escuta o click 
    $('#gravar_men_data').on('click', function (e) {
        var idContrato = $("#data_men_contrato").val();

        let FData = new FormData();
        FData.set("id", $("#data_men_id").val());
        FData.set("sqlCampos", "men_vencimento='" + $("#men_vencimento").val() + "'");
        FData.set("action", "vMensalidadeAlterar"); //nome da funcao no PHP

        if (jsContrato.ajax(FData, null, '../view/vMensalidade.php')) {
            $("#formMensalidadeData").modal('hide');

            jsContrato.mensalida(idContrato);

            swal('Registo...', jsContrato.msg, 'success');
        }

    });
    //escuta o click 
    $('#gravar_men_pago').on('click', function (e) {
        var idContrato = $("#pago_men_contrato").val();

        let FData = new FormData();
        FData.set('id', $("#pago_men_id").val());
        FData.set('men_status', '3');
        FData.set('men_data_pago', $("#men_data_pago").val());
        FData.set('men_valor_pago', $("#men_valor_pago").val());
        FData.set('men_pago_tipo', $("#men_pago_tipo").val());
        FData.set('men_pago_obs', $("#men_pago_obs").val());
        FData.set("action", "vMensalidadePagamento"); //nome da funcao no PHP

        if (jsContrato.ajax(FData, null, '../view/vMensalidade.php')) {
            $("#formMensalidadePagar").modal('hide');

            jsContrato.mensalida(idContrato);

            swal('Registo...', jsContrato.msg, 'success');
        }

    });

    //Quando o Form esta show modal
    $('#formCadastro').on('shown.bs.modal', function () {
        $("#con_vencimento").focus();
        jsContrato.ValidaForm();

        if ($("#insert").val() === 'insert') {

            jsContrato.ListaModalidade();
            jsContrato.ListaAluno();
        }

    });

    //Quando o Form esta hide modal
    $('#formCadastro').on('hide.bs.modal', function () {
        $("#inpBuscar").focus();
        $('#formCadastro input,textarea,select').each(function () {
            $(this).val('');
        });

        $(".modal-body :input").each(function () {
            $(this).attr("disabled", false);
        });

        if (formCadastro.valid() == false) {
            formCadastro.destroy();
        }

        //Deixa o Form padrão para fazer o insert
        $("#insert").val('insert');
    });


    //Quando o Form esta show modal
    $('#formMensalidadeData').on('shown.bs.modal', function () {
        $("#men_vencimento").focus();

    });
    //Quando o Form esta show modal
    $('#formMensalidadePagar').on('shown.bs.modal', function () {
        $("#men_data_pago").focus();

    });

    //Quando o Form esta hide modal
    $('#formMensalidadeData').on('hide.bs.modal', function () {
        $('#formMensalidadeData input,textarea,select').each(function () {
            $(this).val('');
        });

        $(".modal-body :input").each(function () {
            $(this).attr("disabled", false);
        });


    });

    //Quando o Form esta hide modal
    $('#formMensalidadePagar').on('hide.bs.modal', function () {
        $('#formMensalidadePagar input,textarea,select').each(function () {
            $(this).val('');
        });

        $(".modal-body :input").each(function () {
            $(this).attr("disabled", false);
        });


    });


};
// O submit do form que chama esta funcao
jsContrato.ValidaForm = function () {

    formCadastro = $('#formCadastro').validate({
        debug: true,
        ignore: '*:not([name])',
        rules: {
            con_vencimento: {
                required: true,
            },
            con_valor: {
                required: true
            },
            con_meses: {
                required: true
            },
            alunos_id: {
                required: true
            },
            modalidades_id: {
                required: true
            }
        },
        messages: {
            con_vencimento: "Ex 08/12/2000",
            con_valor: "Ex 250,00",
            con_meses: "2",
            alunos_id: "Luiz",
            modalidades_id: "*",
        },
        submitHandler: function (form) {
            //alert('inside');

            let Form = jsContrato.getForm();

            Form.set("action", "vCadastro"); //nome da funcao no PHP

            if (jsContrato.ajax(Form, 'vCadastro')) {
                $("#formCadastro").modal('hide');

                jsContrato.getlista();

                swal('Registo...', jsContrato.msg, 'success');
            }

        }
    });
}

jsContrato.getForm = function () {

    let FData = new FormData();
    FData.set('insert', $("#insert").val());
    FData.set('id', $("#con_id").val());
    FData.set('vencimento', $("#con_vencimento").val());
    FData.set('valor', $("#con_valor").val());
    FData.set('meses', $("#con_meses").val());
    FData.set('obs', $("#con_obs").val());
    FData.set('ativado', $("#con_ativado").val());
    FData.set('email_notificacao', $("#con_email_notificacao").val());
    FData.set('data_cadastro', $("#con_data_cadastro").val());
    FData.set('alunos_id', $("#alunos_id").val());
    FData.set('modalidades_id', $("#modalidades_id").val());

    return FData;

};

jsContrato.setForm = function (obj) {

    $("#con_id").val(obj.id);
    $("#con_vencimento").val(obj.vencimento);
    $("#con_valor").val(obj.valor);
    $("#con_meses").val(obj.meses);
    $("#con_obs").val(obj.obs);
    $("#con_ativado").val(obj.ativado);
    $("#con_email_notificacao").val(obj.email_notificacao);
    $("#con_data_cadastro").val(obj.data_cadastro);
    $("#alunos_id").val(obj.alunos_id);
    $("#modalidades_id").val(obj.modalidades_id);
};

jsContrato.tableList = function (json) {
    var linha = '';
    var dados = json.dados;
    var classe = '';

    for (var i = 0; i < dados.length; i++) {

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
                '<td class="col-1 text-center">' + dados[i].vencimentoPT + '</td>' +
                '<td class="col-1 text-center" ><span class="' + classe + '">' + ativado + '</span> </td>' +
                '<td class="col-1 text-center">' + dados[i].data_cadastro + '</td>' +
                '<td class="col-1 text-center">' + dados[i].valor + '</td>' +
                '<td class="col-1 text-center">' + dados[i].meses + ' </td>' +
                '<td class="col-3 text-left">' + dados[i].alunos_nome + ' </td>' +
                '<td class="col-2 text-left">' + dados[i].modalidades_nome + ' </td>' +
                '<td class="col-1 text-center" style="min-width: 100px;">\n\
                    <i class="btn-link fa bi-eye fa-lg" title="Visualizar"></i>\n\
                    <i class="btn-link fa bi-pencil-square fa-lg" title="Editar"></i>\n\
                </td>' +
                '</tr>';
    }

    $('#ListView').empty();
    $('#ListView').append(linha);
};

jsContrato.tableList_Contrato = function (json) {
    var linha = '';
    var dados = json.dados;
    var classe = '';

    for (var i = 0; i < dados.length; i++) {

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
                '<td class="col-1 text-center">' + dados[i].vencimentoPT + '</td>' +
                '<td class="col-1 text-center" ><span class="' + classe + '">' + ativado + '</span> </td>' +
                '<td class="col-1 text-center">' + dados[i].data_cadastro + '</td>' +
                '<td class="col-1 text-center">' + dados[i].valor + '</td>' +
                '<td class="col-1 text-center">' + dados[i].meses + ' </td>' +
                '<td class="col-3 text-left">' + dados[i].alunos_nome + ' </td>' +
                '<td class="col-2 text-left">' + dados[i].modalidades_nome + ' </td>' +
                '<td class="col-1 text-center" style="min-width: 100px;">\n\
                    <i class="btn-link fa bi-pencil-square fa-lg" title="Editar"></i>\n\
                </td>' +
                '</tr>';
    }

    $('#Contrato_ListView').empty();
    $('#Contrato_ListView').append(linha);
};

jsContrato.tableList_Mensalidade = function (json) {
    var linha = '';
    var dados = json.dados;
    var classe = '';

    for (var i = 0; i < dados.length; i++) {

        switch (dados[i].status) {
            case '0':
                classe = "text-danger";
                ativado = "Pendente";
                break;
            case '1':
                classe = "text-primary";
                ativado = " Pago Parcial";
                break;
            case '3':
                classe = "text-green";
                ativado = " Pago Concluido";
                break;
        }

        linha += '<tr class="visualiar">' +
                '<td class="col-1 text-center">' + dados[i].id + '</td>' +
                '<td class="col-1 text-center">' + dados[i].vencimento + '</td>' +
                '<td class="col-1 text-center">' + dados[i].data_pago + '</td>' +
                '<td class="col-2 text-center" ><p class="' + classe + '">' + ativado + '</p> </td>' +
                '<td class="col-1 text-center">' + dados[i].valor + '</td>' +
                '<td class="col-1 text-center">' + dados[i].valor_pago + '</td>' +
                '<td class="col-2 text-center">' + dados[i].modalidade_nome + ' </td>' +
                '<td class="col-2 text-center" style="min-width: 100px;">\n\
                    <i class="btn-link fa bi-cash-coin fa-lg" title="Pagar"></i>\n\
                    <i class="btn-link fa bi-whatsapp fa-lg" title="Solicitar"></i>\n\
                    <i class="btn-link fa bi-pencil-square fa-lg" title="Editar_data"></i>\n\
                    <i class="btn-link fa bi-file-earmark-x fa-lg" title="Excluir"></i>\n\
                </td>' +
                '</tr>';
    }

    $('#Mesalidade_ListView').empty();
    $('#Mesalidade_ListView').append(linha);
};

jsContrato.getlista = function () {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP

    var json = jsContrato.ajax(FData);

    try {
        jsContrato.tableList(json);

    } catch (erro) {
        $('#ListView').empty();
        //$('#ListView').append("<tr>PROFESSORES NÃO LOCALIZADO !</tr>");
    }
};

jsContrato.salvar = function () {

    let Form = jsContrato.getForm();

    Form.set("action", "vCadastro"); //nome da funcao no PHP

    if (jsContrato.ajax(Form, 'vCadastro')) {
        $("#formCadastro").modal('hide');

        jsContrato.getlista();

        swal('Registo...', jsContrato.msg, 'success');
    }
};

jsContrato.editar = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP
    FData.set("where", "where con_id=" + id);//passo os campos PHP

    var json = jsContrato.ajax(FData, 'vLocalizar');

    jsContrato.setForm(json.dados[0]);

    $(".modal-title").text('Editar Cadastro');
    $("#insert").val('update')
    $("#formCadastro").modal("show");
};

jsContrato.click_table = function (id, title) {

    var FData = new FormData();

    switch (title) {
        case 'Visualizar':
            $('.Contratos').hide("slow") //esconde a lista de contratos

            jsContrato.contrato(id);
            jsContrato.mensalida(id);

            $('.Contrato_Mesalidade').show("slow");

            break;
        case 'Editar':

            jsContrato.ListaModalidade();
            jsContrato.ListaAluno();
            jsContrato.editar(id);

            break;
        case 'Pagar':

            FData.set("action", "vMensalidadeID"); //nome da funcao no PHP
            FData.set('id', id);//passo os campos PHP

            var json = jsContrato.ajax(FData, null, '../view/vMensalidade.php');

            $("#pago_men_id").val(json.dados[0].id);
            $("#pago_men_contrato").val(json.dados[0].contratos_id);
            $("#men_data_pago").val(json.dados[0].vencimento);
            $("#men_valor_pago").val(json.dados[0].valor);


            $("#formMensalidadePagar").modal("show");

            break;
        case 'Solicitar':

            alert('Solicitar');

            break;
        case 'Editar_data':

            FData.set("action", "vMensalidadeID"); //nome da funcao no PHP
            FData.set('id', id);//passo os campos PHP

            var json = jsContrato.ajax(FData, null, '../view/vMensalidade.php');

            $("#data_men_id").val(json.dados[0].id);
            $("#data_men_contrato").val(json.dados[0].contratos_id);
            $("#men_vencimento").val(json.dados[0].vencimento);


            $("#formMensalidadeData").modal("show");

            break;
        case 'Anular':

            alert('Anular');

            break;
        case 'Excluir':

            alert('Excluir');

            break;
    }

};

jsContrato.contrato = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP
    FData.set("where", "where con_id=" + id);//passo os campos PHP

    let json = jsContrato.ajax(FData);
    jsContrato.tableList_Contrato(json);

};

jsContrato.mensalida = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP
    FData.set("where", "where contratos_id=" + id);//passo os campos PHP

    let json = jsContrato.ajax(FData, null, '../view/vMensalidade.php');
    jsContrato.tableList_Mensalidade(json);

};

jsContrato.ListaModalidade = function () {
    $('#modalidades_id').empty();
    $("#modalidades_id").append(new Option('', ''));

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP

    var json = jsContrato.ajax(FData, null, '../view/vModalidade.php');
    var dados = json.dados;
    for (var i = 0; i < json.total; i++) {
        $("#modalidades_id").append(new Option(dados[i].nome, dados[i].id));
    }
    //$('#aul_prof_id').val(id);
};

jsContrato.ListaAluno = function () {
    $('#alunos_id').empty();
    $("#alunos_id").append(new Option('', ''));
    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP

    var json = jsContrato.ajax(FData, null, '../view/vAluno.php');
    var dados = json.dados;
    for (var i = 0; i < json.total; i++) {
        $("#alunos_id").append(new Option(dados[i].nome, dados[i].id));
    }
    //$('#aul_prof_id').val(id);
};

jsContrato.ajax = function (FormData, action, v) {
    var view = v == null ? '../view/vContrato.php' : v;
    var retorno;
    $.ajax({
        url: view, type: "POST", data: FormData, dataType: "json", async: false, processData: false, contentType: false,
        success: function (php) {
            jsContrato.msg = php.messages;
            retorno = php;
        },
        error: function (php) {
            //debugger;
            //var responseText = JSON.parse(php.responseText);
            jsContrato.msg = php.responseText;
            swal('Oops...', jsContrato.msg, 'error');

            retorno = false;
        }
    });
    return retorno;

};
jsContrato.start = function () {
    jsContrato.eventos();
    jsContrato.mask();
    jsContrato.getlista();

};

jsContrato.start();