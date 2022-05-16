/* global custom */

var jGerenciar = {};

jGerenciar.start = function () {
    

    var usuario = $("#usuarioID").val();
    if (usuario == 3) { // verifica se o usuario tem permissao
        $("#gerencial01").hide();
    } else {
        $("#gerencial01").show();
    }

    $("#excelExport,#excelExport1,#excelExport2").jqxButton();
    $("#excelExport").click(function () {
        $("#listaGerecial").jqxDataTable('exportData', 'xls');
    });
    $("#excelExport1").click(function () {
        $("#listaVentaPorVendedor").jqxDataTable('exportData', 'xls');
    });
    $("#excelExport2").click(function () {
        $("#listaVentaPorCliente").jqxDataTable('exportData', 'xls');
    });
    $("#vendaInicio,#clienteInicio").jqxDateTimeInput({width: 190, height: 25, selectionMode: 'range'});

    var date1 = new Date();
    var ano = date1.getFullYear();
    var mm = date1.getMonth();
    date1.setFullYear(ano, mm, 1);

    var date2 = new Date();
    var ano2 = date2.getFullYear();
    var dd2 = date2.getDate();
    var mm2 = date2.getMonth();
    date2.setFullYear(ano2, mm2, dd2);

    $("#vendaInicio,#clienteInicio").jqxDateTimeInput('setRange', date1, date2);

    jGerenciar.ListaGerencial();
    jGerenciar.ListaVentaPorVendedor(date2.toISOString().substring(0, 8) + '01', jGerenciar.data());
    jGerenciar.ListaVentaPorCliente(date2.toISOString().substring(0, 8) + '01', jGerenciar.data());

};

$("#vendaInicio").on('change', function (event) {
    var selection = $("#vendaInicio").jqxDateTimeInput('getRange');
    if (selection.from !== null) {
        //console.info("<div>From: " + selection.from.toLocaleDateString() + " <br/>To: " + selection.to.toLocaleDateString() + "</div>");
        //var data1 = custom.convertDatePortuguestoSql(selection.from.toLocaleDateString());
        var data1 = custom.convertDatePortuguestoSql(window.fromText)
        //var data2 = custom.convertDatePortuguestoSql(selection.to.toLocaleDateString());
        var data2 = custom.convertDatePortuguestoSql(window.toText);

        jGerenciar.ListaVentaPorVendedor(data1, data2);

    }
});

$("#clienteInicio").on('change', function (event) {
    var selection = $("#clienteInicio").jqxDateTimeInput('getRange');
    if (selection.from !== null) {
        //console.info("<div>From: " + selection.from.toLocaleDateString() + " <br/>To: " + selection.to.toLocaleDateString() + "</div>");
        //var data1 = custom.convertDatePortuguestoSql(selection.from.toLocaleDateString());
        var data1 = custom.convertDatePortuguestoSql(window.fromText);
        //var data2 = custom.convertDatePortuguestoSql(selection.to.toLocaleDateString());
        var data2 = custom.convertDatePortuguestoSql(window.toText);

        jGerenciar.ListaVentaPorCliente(data1, data2);
    }
});

jGerenciar.data = function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var dia = yyyy + '-' + mm + '-' + (dd);

    return dia;
};
// lista gerencial de 
jGerenciar.ListaGerencial = function () {
    var obj = new Object();
    var data = {'obj': obj, 'funcao': 'getListaCheques'};
    var source = {type: "POST", datatype: "json", datafields: [
            {name: "grupo"}, {name: "tipo"}, {name: "valorGS"}, {name: "valorRS"}, {name: "valorUS"}
        ],
        id: 'id',
        url: '../view/vGerenciar.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaGerecial").jqxDataTable({
        width: '100%',
        height: 320,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        groups: ['grupo'],
        groupsRenderer: function (value, rowData, level)
        {
            return value;
        },
        exportSettings: {
            fileName: "Lista Gerecial"
        },
        columns: [
            {text: 'Supplier Name', hidden: true, cellsAlign: 'left', align: 'left', dataField: 'grupo', width: '100%'},
            {text: ' ', datafield: 'tipo', width: 150},
            {text: 'Valor G$', datafield: 'valorGS', width: 120, cellsAlign: 'right', align: 'right', cellsformat: 'd'},
            {text: 'Valor U$', datafield: 'valorUS', width: 100, cellsAlign: 'right', align: 'right', cellsformat: 'd'},
            {text: 'Valor R$', datafield: 'valorRS', width: 100, cellsAlign: 'right', align: 'right', cellsformat: 'd'}
        ]
    });

};

jGerenciar.ListaVentaPorVendedor = function (data1, data2) {

    var obj = new Object();
    obj.data = "'" + data1 + "' and '" + data2 + "' and vendedor not in(20,36)";
    obj.campo = "(SELECT f.nome FROM funcionario f WHERE v.vendedor=f.idfuncionario ) AS nome,\n\
                v.vendedor as id,\n\
                (SELECT SUM(c.subtotal)\n\
                    FROM COMPRA c\n\
                    WHERE c.codvendadev IS NOT NULL\n\
                    AND c.cancelada IS NULL\n\
                    AND c.data_nota BETWEEN '" + data1 + "' and '" + data2 + "' AND c.idfunc=v.vendedor\n\
                ) AS devolucao";
    obj.group = 'v.vendedor';
    var data = {'obj': obj, 'funcao': 'getListaVendaDev'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "id"},
            {name: "nome"},
            {name: "t_valor", type: 'float'},
            {name: "t_custo", type: 'float'},
            {name: "devolucao", type: 'float'},
            {name: "saldo", type: 'float'},
            {name: "t_margen", type: 'string'}
        ],
        id: 'id',
        url: '../view/vGerenciar.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaVentaPorVendedor").jqxDataTable({
        width: '100%',
        height: 320,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        aggregatesHeight: 25,
        showAggregates: true,
        columns: [
            {text: 'Vendedor', datafield: 'nome', width: 200, align: 'center'},
            {text: 'Margem %', datafield: 't_margen', width: '80px', cellsAlign: 'right', align: 'center', cellsFormat: 'p'},
            {text: 'T.Venda', datafield: 't_valor', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'T.Custo', datafield: 't_custo', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'T.Devolução', datafield: 'devolucao', width: 120, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'Saldo', datafield: 'saldo', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']}

        ]
    });
};
jGerenciar.ListaVentaPorCliente = function (data1, data2) {

    var obj = new Object();
    obj.data = "'" + data1 + "' and '" + data2 + "'";
    obj.campo = '(select c.nome from cliente c where c.idcliente=v.cliente) as Nome,v.cliente as id';
    obj.group = 'v.cliente';
    var data = {'obj': obj, 'funcao': 'getListaVendaClietnte'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "id"},
            {name: "nome"},
            {name: "t_margen", type: 'string'},
            {name: "t_valor", type: 'float'},
            {name: "t_custo", type: 'float'}

        ],
        id: 'id',
        url: '../view/vGerenciar.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaVentaPorCliente").jqxDataTable({
        width: '100%',
        height: 320,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        aggregatesHeight: 25,
        showAggregates: true,
        columns: [
            {text: 'Cliente', datafield: 'nome', width: 200, align: 'center'},
            {text: 'Margem %', datafield: 't_margen', width: '80px', cellsAlign: 'right', align: 'center', cellsFormat: 'p'},
            {text: 'T.Venda', datafield: 't_valor', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'T.Custo', datafield: 't_custo', width: 120, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']}

        ]
    });
};
jGerenciar.start();