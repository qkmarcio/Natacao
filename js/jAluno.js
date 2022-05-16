var jsAluno = {};

var formCadastro;

jsAluno.mask = function () {
    $("#alu_telefone").mask('(99) 9999-9999');
    $("#alu_celular").mask('(99) 99999-9999');
    $("#alu_cpf").mask('999.999.999-99');
    $("#alu_cep").mask('99999-999');
};

jsAluno.eventos = function () {
    $("#insert").val('insert');

    $('#inpBuscar').focus();

    $('#inpBuscar').on('change', function (evet) {

        let FData = new FormData();
        FData.set("action", "vBuscaAll");//nome da funcao no PHP
        FData.set("where", evet.target.value);//passo os campos PHP

        var json = jsAluno.ajax(FData);

        try {
            jsAluno.tableList(json);

        } catch (erro) {
            $('#ListView').empty();

        }

    });

    $('#image-file').on('change', function () {
        console.log('This file size is: ' + this.files[0].size / 1024 / 1024 + "MiB");
    });

    //Faz a Chamada para Editar
    $('#thumbnail').on('click', function (e) {
        debugger;
        $("#alu_foto").click();
    });

    $('#alu_foto').change(function (e) {
        var img = e.target.files
        if (img.length <= 0) {
            return;
        } else {
            if (img[0].size >= 2306867) {
                swal('Oops...', 'Imagem muito grande!! Max: 2MB', 'info');
                e.target.value = '';
            } else {
                let reader = new FileReader();
                reader.onload = function (evt) {
                    $('#thumbnail').attr('src', evt.target.result);
                }
                reader.readAsDataURL(img[0]);
            }
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
        jsAluno.editar(id);
    });

    //Quando o Form esta show modal
    $('#formCadastro').on('shown.bs.modal', function () {

        $("#alu_nome").focus();
        jsAluno.ValidaForm();

        if ($("#insert").val() == 'insert') {
            jsAluno.ListaProfessor();
            jsAluno.ListaAula();
        }
    });

    //Quando o Form esta hide modal
    $('#formCadastro').on('hide.bs.modal', function () {
        $("#inpBuscar").focus();
        $(".limpar").val(''); //Limpar os tudo com esta class
//        $('#formCadastro input,textarea,select').each(function () {
//            $(this).val('');
//        });
        $(".modal-body :input").each(function () {
            $(this).attr("disabled", false);
        });

        if (formCadastro.valid() == false) {
            formCadastro.destroy();
        }

        //Deixa o Form padrão para fazer o insert
        $("#insert").val('insert');
        $('#thumbnail').attr('src', "../Fotos/semfoto.jpg");
    });
};

// O submit do form que chama esta funcao
jsAluno.ValidaForm = function () {

    formCadastro = $('#formCadastro').validate({
        debug: true,
        ignore: '*:not([name])',
        rules: {
            alu_nome: {
                required: true
            },
            alu_resposavel: {
                required: true
            },
            alu_celular: {
                required: true
            },
            alu_sexo: {
                required: true
            },
            prof_email: {
                required: true,
                email: true
            }
        },
        messages: {
            alu_nome: {
                required: "Coloque Nome Completo"
            },
            alu_resposavel: {
                required: "Coloque um Reponsavel"
            },
            alu_sexo: {
                required: "Selecione o Sexo"
            },
            prof_email: "Coloque um email valido"

        },
        submitHandler: function (form) {
            //alert('inside');

            let Form = jsAluno.getForm();

            Form.set("action", "vCadastro"); //nome da funcao no PHP

            if (jsAluno.ajax(Form, 'vCadastro')) {
                $("#formCadastro").modal('hide');

                jsAluno.getlista();

                swal('Registo...', jsAluno.msg, 'success');
            }

        }
    });
}

jsAluno.getForm = function () {

    let FData = new FormData();
    FData.set('insert', $("#insert").val());
    FData.set('id', $("#alu_id").val());
    FData.set('nome', $("#alu_nome").val());
    FData.set('nascimento', $("#alu_nascimento").val());
    FData.set('resposavel', $("#alu_resposavel").val());
    FData.set('cep', $("#alu_cep").val());
    FData.set('bairro', $("#alu_bairro").val());
    FData.set('endereco', $("#alu_endereco").val());
    FData.set('cidade', $("#alu_cidade").val());
    FData.set('cpf', $("#alu_cpf").val());
    FData.set('telefone', $("#alu_telefone").val());
    FData.set('celular', $("#alu_celular").val());
    FData.set('sexo', $("#alu_sexo").val());
    FData.set('email', $("#alu_email").val());
    FData.set('email_recibo', $("#alu_email_recibo").val());
    FData.set('obs', $("#alu_obs").val());
    FData.set('senha', $("#alu_senha").val());
    FData.set('ativado', $("#alu_ativado").val());
    FData.set('foto', $("#alu_foto")[0].files[0]);
    FData.set('foto2', $("#thumbnail").attr('src'));

    return FData;

};

jsAluno.setForm = function (obj) {
    $("#alu_id").val(obj.id);
    $("#alu_nome").val(obj.nome);
    $("#alu_nascimento").val(obj.nascimento);
    $("#alu_resposavel").val(obj.resposavel);
    $("#alu_cep").val(obj.cep);
    $("#alu_bairro").val(obj.bairro);
    $("#alu_endereco").val(obj.endereco);
    $("#alu_cidade").val(obj.cidade);
    $("#alu_cpf").val(obj.cpf);
    $("#alu_telefone").val(obj.telefone);
    $("#alu_celular").val(obj.celular);
    $("#alu_sexo").val(obj.sexo);
    $("#alu_email").val(obj.email);
    $("#alu_email_recibo").val(obj.email_recibo);
    $("#alu_obs").val(obj.obs);
    $("#alu_senha").val(obj.senha);
    $("#alu_ativado").val(obj.ativado);
    $('#thumbnail').attr('src', obj.foto);
};

jsAluno.tableList = function (json) {
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
                '<td class="col-3 text-left">' + dados[i].nome + '</td>' +
                '<td class="col-2 text-left">' + dados[i].resposavel + '</td>' +
                '<td class="col-1 text-left">' + dados[i].celular + ' </td>' +
                '<td class="col-2 text-left">' + dados[i].email + ' </td>' +
                '<td class="col-1 text-center" ><span class="' + classe + '">' + ativado + '</span> </td>' +
                '<td class="col-1 text-center" style="min-width: 100px;">\n\
                    <i class="btn-link fa bi-eye fa-lg" title="Visualizar"></i>\n\
                    <i class="btn-link fa bi-pencil-square fa-lg" title="Editar"></i>\n\
                </td>' +
                '</tr>';
    }

    $('#ListView').empty();
    $('#ListView').append(linha);
};

jsAluno.getlista = function () {

    let FData = new FormData();
    FData.set("action", "vListaAll");//nome da funcao no PHP

    var json = jsAluno.ajax(FData);

    try {
        jsAluno.tableList(json);

    } catch (erro) {
        $('#ListView').empty();
        //$('#ListView').append("<tr>PROFESSORES NÃO LOCALIZADO !</tr>");
    }
};

jsAluno.salvar = function () {

    let Form = jsAluno.getForm();

    Form.set("action", "vCadastro"); //nome da funcao no PHP

    if (jsAluno.ajax(Form, 'vCadastro')) {
        $("#formCadastro").modal('hide');

        jsAluno.getlista();

        swal('Registo...', jsAluno.msg, 'success');
    }
};

jsAluno.editar = function (id) {

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP
    FData.set("where", "where alu_id=" + id);//passo os campos PHP

    var json = jsAluno.ajax(FData, 'vLocalizar');

    jsAluno.setForm(json.dados[0]);

    $(".modal-title").text('Editar Cadastro');
    $("#insert").val('update');
    $("#formCadastro").modal("show");
};

jsAluno.ListaAula = function () {
    $('#alu_aul_id').empty();

    let FData = new FormData();
    FData.set("action", "vListaAll"); //nome da funcao no PHP

    var json = jsAluno.ajax(FData, null, '../view/vAula.php');
    var dados = json.dados;
    for (var i = 0; i < json.total; i++) {
        $("#alu_aul_id").append(new Option(dados[i].horario + ' - ' + dados[i].dia, dados[i].id));
    }

};

jsAluno.ajax = function (FormData, action, v) {
    var view = v == null ? '../view/vAluno.php' : v;
    var retorno;
    $.ajax({
        url: view, type: "POST", data: FormData, dataType: "json", async: false, processData: false, contentType: false,
        success: function (php) {
            jsAluno.msg = php.messages;
            retorno = php;
        },
        error: function (php) {
            //debugger;
            //var responseText = JSON.parse(php.responseText);
            jsAluno.msg = php.responseText;
            swal('Oops...', jsAluno.msg, 'error');

            retorno = false;
        }
    });
    return retorno;

};

jsAluno.start = function () {
    jsAluno.eventos();

    jsAluno.mask();

    jsAluno.getlista();

};

jsAluno.start();