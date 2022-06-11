var jsAula = {};

var formCadastro;
var selectedDia = [];

jsAula.eventos = function() {

    $("#insert").val('insert');
    //Buscar 
    $('#inpBuscar').focus();
    $('#inpBuscar').on('change', function(evet) {

        let FData = new FormData();
        FData.set("action", "vBuscaAll"); //nome da funcao no PHP
        FData.set("where", evet.target.value); //passo os campos PHP

        var json = jsAula.ajax(FData);

        try {
            jsAula.tableList(json);

        } catch (erro) {
            $('#ListView').empty();
        }
    });

    //escuta o click da class .btn-link da lista de professores
    $('table').on('click', '.btn-link', function(e) {
        var id = $(this).closest('tr').children('td:first').text();

        if ($(this).attr("title") == 'Visualizar') {
            $(".modal-body :input").each(function() {
                $(this).attr("disabled", true);
            });
        }

        jsAula.editar(id);
    });

    //Quando o Form esta show modal
    $('#formCadastro').on('shown.bs.modal', function() {
        $("#aul_nome").focus();
        jsAula.ValidaForm();

    });

    //Quando o Form esta hide modal
    $('#formCadastro').on('hide.bs.modal', function() {
        $("#inpBuscar").focus();
        $('#formCadastro input,textarea,select').each(function() {
            $(this).val('');
        });

        $('div#aul_dia input[type=checkbox]').prop("checked", false);

        $(".modal-body :input").each(function() {
            $(this).attr("disabled", false);
        });

        if (formCadastro.valid() == false) {
            formCadastro.destroy();
        }
        //Deixa o Form padrao para fazer o insert
        $("#insert").val('insert');
    });

    //INICIO NOVA CHAMADA DE AUTO COMPLETAR NOME DO NIVEL CIDADE DO JQUERY UI 
    $("#aul_prof_nome").autocomplete({
        source: function(request, response) {
            var obj = new Object();
            obj.action = "vAutocomplete"; //nome da funcao no PHP
            obj.letra = request.term; //passo os campos PHP

            $.ajax({
                url: "../view/vProfessor.php",
                type: "POST",
                data: obj,
                dataType: "json",
                success: function(data) {
                    response($.map(data.dados, function(item) {
                        return { label: item.id + ' - ' + item.nome, i: item }
                    }));
                },
                error: function(data) {
                    swal('Oops...', 'Professor não localizado', 'error');
                    $("#aul_prof_nome").removeClass('ui-autocomplete-loading');
                }
            });
        },

        select: function(event, ui) {
            $("#aul_prof_nome").val(ui.item.label);
            $("#aul_prof_id").val(ui.item.i.id);
        }
    });
};

// O submit do form que chama esta funcao
jsAula.ValidaForm = function() {
    formCadastro = $('#formCadastro').validate({
        debug: true,
        ignore: '*:not([name])',
        rules: {
            aul_nome: {
                required: true,
                minlength: 3
            },
            aul_horario: {
                required: true
            },
            aul_dia: {
                required: true
            },
            aul_prof_id: {
                required: true
            },
        },
        messages: {
            aul_nome: {
                required: "Coloque um nome",
                minlength: "Seu nome deve consistir em pelo menos 3 caracteres"
            },
            aul_horario: {
                required: "Marque um Horario"
            },
            aul_dia: {
                required: "Selecione um Dia"
            },
            aul_prof_id: {
                required: "Selecione um Professor"
            }
        },
        submitHandler: function(form) {

            let Form = jsAula.getForm();

            Form.set("action", "vCadastro"); //nome da funcao no PHP

            if (jsAula.ajax(Form, 'vCadastro')) {
                $("#formCadastro").modal('hide');

                jsAula.getlista();

                swal('Registo...', jsAula.msg, 'success');
            }

        }
    });
}

jsAula.getForm = function() {

    var selected = [];

    $('div#aul_dia input[type=checkbox]').each(function() {
        if ($(this).is(":checked")) {
            selected.push($(this).attr('name'));
        }
    });

    let FData = new FormData();
    FData.set('insert', $("#insert").val());
    FData.set('id', $("#aul_id").val());
    FData.set('nome', $("#aul_nome").val());
    FData.set('horario', $("#aul_horario").val());
    FData.set('dia_semana', selected);
    FData.set('comissao', 0);
    FData.set('ativado', '1');
    FData.set('prof_id', $("#aul_prof_id").val());
    FData.set('obs', $("#aul_obs").val());

    return FData;

};

jsAula.setForm = function(obj) {
    $("#aul_id").val(obj.id);
    $("#aul_nome").val(obj.nome);
    $("#aul_horario").val(obj.horario);
    $("#aul_prof_nome").val(obj.prof_nome);
    $("#aul_prof_id").val(obj.prof_id);
    $("#aul_obs").val(obj.obs);


    //marcao checkbox 
    const myArray = obj.dia_semana.split(',');
    for (var i = 0; i < myArray.length; i++) {
        $('div#aul_dia input[name=' + myArray[i] + ']').prop("checked", true);

    }
};

jsAula.tableList = function(json) {
    var linha = '';
    var dados = json.dados;
    var classe = '';

    for (var i = 0; i < dados.length; i++) {

        linha += '<tr class="visualiar">' +
            '<td class="col-1 text-center">' + dados[i].id + '</td>' +
            '<td class="col-2 text-left">' + dados[i].nome + '</td>' +
            '<td class="col-3 text-left">' + dados[i].prof_nome + ' </td>' +
            '<td class="col-3 text-left">' + dados[i].dia_semana + ' </td>' +
            '<td class="col-2 text-left">' + dados[i].horario + ' </td>' +
            '<td class="col-2 text-center" style="min-width: 100px;">\n\
                    <i class="btn-link fa bi-eye fa-lg" title="Visualizar"></i>\n\
                    <i class="btn-link fa bi-pencil-square fa-lg" title="Editar"></i>\n\
                </td>' +
            '</tr>';
    }

    $('#ListView').empty();
    $('#ListView').append(linha);
};

jsAula.getlista = function() {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP

    var json = jsAula.ajax(FData);

    try {
        jsAula.tableList(json);

    } catch (erro) {
        $('#ListView').empty();
    }
};

jsAula.salvar = function() {

    let Form = jsAula.getForm();

    Form.set("action", "vCadastro"); //nome da funcao no PHP

    if (jsAula.ajax(Form, 'vCadastro')) {
        $("#formCadastro").modal('hide');

        jsAula.getlista();

        swal('Registo...', jsAula.msg, 'success');
    }
};

jsAula.editar = function(id) {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP
    FData.set("where", "where aul_id=" + id); //passo os campos PHP

    var json = jsAula.ajax(FData, 'vLocalizar');

    jsAula.setForm(json.dados[0]);

    $(".modal-title").text('Editar Cadastro');
    $("#insert").val('update')
    $("#formCadastro").modal("show");
};

jsAula.ListaProfessor = function() {
    $('#aul_prof_id').empty();

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP

    var json = jsAula.ajax(FData, null, '../view/vProfessor.php');
    var dados = json.dados;
    for (var i = 0; i < json.total; i++) {
        $("#aul_prof_id").append(new Option(dados[i].nome, dados[i].id));
    }
};

jsAula.ajax = function(FormData, action, v) {
    var view = v == null ? '../view/vAula.php' : v;
    var retorno;
    $.ajax({
        url: view,
        type: "POST",
        data: FormData,
        dataType: "json",
        async: false,
        processData: false,
        contentType: false,
        success: function(php) {
            jsAula.msg = php.messages;
            retorno = php;
        },
        error: function(php) {
            jsAula.msg = php.responseText;
            swal('Oops...', jsAula.msg, 'error');

            retorno = false;
        }
    });
    return retorno;

};
jsAula.start = function() {
    jsAula.eventos();
    jsAula.getlista();

};

jsAula.start();