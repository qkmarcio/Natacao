/* global custom */


//$('#a').attr({'style':'width: 90%'}).html('<h4>100%</h4>');
//$('#b').attr({'style':'width: 0%'}).html('<h4>40%</h4>');
//$('#c').attr({'style':'width: 10%'}).html('<h4>10%</h4>');

var jDashboard = {};
jDashboard.start = function () {
//    if (usuario == 3) { // verifica se o usuario tem permissao
//        $("#gerencial01").hide();
//    } else {
//        $("#gerencial01").show();
//    }
    var date1 = new Date();
    var ano = date1.getFullYear();
    var mm = date1.getMonth();
    date1.setFullYear(ano, mm, 1);
    var date2 = new Date();
    var ano = date2.getFullYear();
    var mm = date2.getMonth();
    var dd = date2.getDate();
    date2.setFullYear(ano, mm, dd);

    var data_inicio = jDashboard.data(0, 01);
    var data_fim = jDashboard.data();
    $("#dataInicio").jqxDateTimeInput({width: 200, height: 25, selectionMode: 'range'});
    $("#dataInicio").jqxDateTimeInput('setRange', date1, date2);
    $(".ExcelDashbord1").click(function () {
        $("#list_ChequeRecebidos").jqxDataTable('exportData', 'xls');
    });
    $(".ExcelDashbord2").click(function () {
        $("#list_Cliente").jqxDataTable('exportData', 'xls');
    });
    $(".ExcelDashbord3").click(function () {
        $("#list_Venda_Dev_Rota").jqxDataTable('exportData', 'xls');
    });

    var antInData1 = jDashboard.data(2, 01); //datas das metas
    var antOutData1 = jDashboard.data(2, 02);  //datas das metas
    jDashboard.ListaMetas(data_inicio, data_fim);

    jDashboard.ListaDashboard(data_inicio, data_fim);
    jDashboard.ListaVendas(data_inicio, data_fim);
    jDashboard.ListaCliente(data_inicio, data_fim);
    jDashboard.ListaSeparacao(data_inicio, data_fim);
    jDashboard.ChequeRecebidos();
};

$("#dataInicio").on('change', function (event) {

    var selection = $("#dataInicio").jqxDateTimeInput('getRange');
    if (selection.from !== null) {
        var data1 = custom.convertDatePortuguestoSql(window.fromText);
        var data2 = custom.convertDatePortuguestoSql(window.toText);
        console.info(data1);
        $("#listaVentas,#listaMVentas,#listaMGanacia").empty();
        jDashboard.ListaDashboard(data1, data2);
        jDashboard.ListaVendas(data1, data2);
        jDashboard.ListaCliente(data1, data2);
        jDashboard.ListaSeparacao(data1, data2);
    }
});

jDashboard.data = function (a, v) {
    var today = new Date();
    var dd, yyyy, mm, dia;
    if (a === 2) {
        var u = new Date(today.getFullYear() - 1, today.getMonth() + 1, 0);
        dd = u.getDate();
        yyyy = u.getFullYear();
    } else {
        dd = today.getDate();
        yyyy = today.getFullYear();
    }
    mm = today.getMonth() + 1; //January is 0!

    if (v === 01) {
        dd = '01';
    } else if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }

    dia = yyyy + '-' + mm + '-' + dd;
    return dia;
};

jDashboard.ListaDashboard = function (data1, data2) {
    var obj = new Object();
    obj.inicio = "'" + data1 + "'";
    obj.final = "'" + data2 + "'";
    var json = jDashboard.ajax(obj, 'getListaDashboard');
    if (true) {
        $("#dasTFaturamento").text('Facturación! ' + json[0].FATURAMENTO);
        $("#dasTCobros").text('Cobros! ' +json[0].COBROS);
        $("#dasTReceber").text('Receber! ' +json[0].A_RECEBER);
        $("#dasTEstoque").text('Estoque! ' +json[0].ESTOQUE);
        $("#dasTItens").text('Total de Items!  ' +json[0].ITENS);
        $("#dasTClientes").text('Total de Clientes!  ' +json[0].CLIENTE);
        $("#dasTMargen").text('---- ' +json[0].MARGEM + '%');
        $("#dasTPedido").text('Pedidos!  ' + json[0].PEDIDOS);
        $("#dasTFatura").text('Facturas!  ' + json[0].FATURAS);
    }
};

jDashboard.ListaMetas = function (inicio, final) {

    var obj = new Object();
    obj.inicio = "'" + inicio + "'";
    obj.final = "'" + final + "'";

    var json = jDashboard.ajax(obj, 'getConsultaMestas');
    if (true) {
        jDashboard.progressMeta(json);
    }
};

jDashboard.progressMeta = function (a) {
    var b = a[0].venta - a[0].final;
    /*$('#metas').html('<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: ' + b + '%;" id="venta" aria-valuemax="100"><h4>' + a[0].venta + '%</h4></div>');
    $('#metas').append('<div class="progress-bar progress-bar-danger" role="progressbar" style="width: ' + a[0].meta + '%" id="meta" aria-valuemax="100"><h4>' + a[0].meta + '%</h4></div>');
    $('#metas').append('<div class="progress-bar progress-bar-success" role="progressbar" style="width: ' + a[0].final + '%" id="final" aria-valuemax="100"><h4>' + a[0].final + '%</h4></div>');
*/
$('#metas').html('<i>Meta '+a[0].venta+' <--> '+a[0].meta+' </i>');
$('#metas').append('<br><i>Meta '+a[0].MesAtual+' <--> '+a[0].UmMes+' </i>');
};
jDashboard.convertDateSqltoPortugues = function (date) {
    if (date !== null) {
        var s = date.split("-");
        var ano = s[0];
        var mes = s[1];
        var dia = s[2];
        return dia + "/" + mes + "/" + ano;
    }
};

jDashboard.ListaCliente = function (data1, data2) {

    var obj = new Object();
    obj.inicio = "'" + data1 + "'";
    obj.final = "'" + data2 + "'";
    var data = {'obj': obj, 'funcao': 'getLCliente'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "Idvendedor"},
            {name: "Vendedor"},
            {name: "Idcliente"},
            {name: "Cliente"},
            {name: "Status"},
            {name: "LIMITI", type: 'float'},
            {name: "T_FATURAS", type: 'float'},
            {name: "t_valor", type: 'float'},
            {name: "VENCIDAS", type: 'float'},
            {name: "LUCRO", type: 'float'},
            {name: "VENCER", type: 'float'},
            {name: "CHEQUES", type: 'float'},
            {name: "DEV_CHEQUES", type: 'float'},
            {name: "DEV_CHEQUES_TODOS", type: 'float'},
            {name: "DESCUENTO", type: 'float'}
        ],
        id: 'id',
        url: '../view/vDashboard.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#list_Cliente").jqxDataTable({
        width: '100%',
        height: 345,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        filterable: true,
        exportSettings: {
            fileName: "Lista Cliente"
        },
        columns: [
            {text: 'Vendedor', datafield: 'Vendedor', width: 90, align: 'center'},
            {text: 'Cod', datafield: 'Idcliente', width: 60, cellsAlign: 'right', align: 'center'},
            {text: 'Cliente', datafield: 'Cliente', width: 330, align: 'center'},
            {text: 'Ventas', datafield: 't_valor', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Descuento', datafield: 'DESCUENTO', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'F. Vencidas', datafield: 'VENCIDAS', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'F. A Vencer', datafield: 'VENCER', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Saldo', datafield: 'T_FATURAS', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Limiti', datafield: 'LIMITI', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Cheques', datafield: 'CHEQUES', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Dv. Cheques', datafield: 'DEV_CHEQUES', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Dv.Hist.CH', datafield: 'DEV_CHEQUES_TODOS', width: 120, cellsAlign: 'right', align: 'center', cellsformat: 'd'},
            {text: 'Status', datafield: 'Status', width: 90, align: 'center'}
        ]
    });
};

jDashboard.ListaSeparacao = function (data1, data2) {


    var obj = new Object();
    obj.inicio = "'" + data1 + "'";
    obj.fim = "'" + data2 + "'";

    var data = {'obj': obj, 'funcao': 'getVListaEquipeRank'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "equipes"},
            {name: "pedidos"},
            {name: "nome"},
            {name: "itens"},
            {name: "itens_hora"},
            {name: "punto"}
        ],
        id: 'id',
        url: '../view/vExpedicion.php',
        data: data}
    ;
    var cellClass = function (row, datafields, value, cellText, rowData) {
        var v = cellText;

        if (v.equipes == 1) {
            return "azul";
        } else if (v.equipes == 2) {
            return "vermelho";
        } else if (v.equipes == 3) {
            return "verde";
        }
    };
    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#list_Separacao").jqxDataTable({
        width: '100%',
        height: 200,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        exportSettings: {
            fileName: "Lista Equipes"
        },
        columns: [
            {text: 'Grupo', datafield: 'nome', width: '30%', cellsAlign: 'left', align: 'center', cellClassName: cellClass},
            {text: 'T.Itens', datafield: 'itens', width: '25%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'I.Media', datafield: 'itens_hora', width: '25%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'Puntos', datafield: 'punto', width: '20%', cellsAlign: 'center', align: 'center', cellClassName: cellClass}
        ]
    }
    );
};

$('#list_Cliente').on('rowSelect', function (event) {
    debugger;
    console.info(event);
    var r = event.args.row;
    $('#ModHistoricoCliente').modal('show');
    var modal = $('#ModHistoricoCliente');
    modal.find('.modal-title').text(r.Idcliente + ' - ' + r.Cliente);
});

jDashboard.ListaVendas = function (data1, data2) {

    var obj = new Object();
    obj.inicio = "'" + data1 + "'";
    obj.final = "'" + data2 + "'";

    var json = jDashboard.ajax(obj, 'getDashboardVentas');
    var MGanacia = new Array();
    var MVentas = new Array();
    for (var i = 0; i < json.length; i++) {
        var a = new Object();
        var b = new Object();
        a.label = json[i].nome;
        a.value = json[i].m_lucro;
        b.label = json[i].nome;
        b.value = json[i].t_vendas;
        MGanacia.push(a);
        MVentas.push(b);
    }

    Morris.Bar({
        element: 'listaVentas',
        data: json,
        xkey: 'nome',
        ykeys: ['t_valor', 't_custo', 't_lucro', 'devolucao'],
        labels: ['Faturacion', 'Costo', 'Lucro B', 'Devolução'],
        hideHover: 'auto',
        barColors: ['#337AB7', '#5CB85C', '#F0AD4E', '#D9534F'],
        resize: true,
        gridTextSize: 11
    });

    jDashboard.Donut(MVentas, 'listaMVentas');
    jDashboard.Donut(MGanacia, 'listaMGanacia');
    jDashboard.ListVendaDevRota(json);

};

jDashboard.ListVendaDevRota = function (d) {
    var source =
            {
                localData: d,
                dataType: "array"
            };

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#list_Venda_Dev_Rota").jqxDataTable({
        width: '100%',
        height: 345,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        aggregatesHeight: 25,
        showAggregates: true,
        exportSettings: {
            fileName: "Lista Vendas"
        },
        columns: [
            {text: 'Vendedor', datafield: 'nome', width: 90, align: 'center'},
            {text: ' % ', datafield: 'm_lucro', width: 40, cellsAlign: 'right', align: 'center', cellsFormat: 'p'},
            {text: 'T.Venda', datafield: 't_valor', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'T.Devolução', datafield: 'devolucao', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'Saldo', datafield: 'sub_valor', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'Comicion', datafield: 'comicion', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']},
            {text: 'T.Custo', datafield: 't_custo', width: 150, cellsAlign: 'right', align: 'center', cellsFormat: 'd', aggregates: ['sum']}

        ]
    });
};

jDashboard.Donut = function (data, element) {
    Morris.Donut({
        element: element,
        data: data,
        resize: true
    });
};
jDashboard.ChequeRecebidos = function () {
    var obj = new Object();
    var data = {'obj': obj, 'funcao': 'getListaCheques'};
    var source = {type: "POST", datatype: "json", datafields: [
            {name: "grupo"}, {name: "tipo"}, {name: "valorGS"}, {name: "valorRS"}, {name: "valorUS"}
        ],
        id: 'id',
        url: '../view/vDashboard.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO
    console.info(dataAdapter);

    $("#list_ChequeRecebidos").jqxDataTable({
        width: '100%',
        height: 345,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        groups: ['grupo'],
        groupsRenderer: function (value, rowData, level)
        {
            return value;
        },
        exportSettings: {
            fileName: "Cheque Recebidos"
        },
        columns: [
            {text: 'Supplier Name', hidden: true, cellsAlign: 'left', align: 'left', dataField: 'grupo', width: '100%'},
            {text: ' ', datafield: 'tipo', width: 90},
            {text: 'Valor G$', datafield: 'valorGS', width: 150, cellsAlign: 'right', align: 'right', cellsformat: 'd'},
            {text: 'Valor U$', datafield: 'valorUS', width: 150, cellsAlign: 'right', align: 'right', cellsformat: 'd'},
            {text: 'Valor R$', datafield: 'valorRS', width: 140, cellsAlign: 'right', align: 'right', cellsformat: 'd'}
        ]
    });

};

jDashboard.EscondeDiv = function (id, pagina) {
    $(id).slideUp("slow");//efeito de sobe e desce o footer
    $(id).slideDown("slow");//efeito de sobe e desce o footer
};

jDashboard.ajax = function (obj, funcao) {                                                  // FUNÇÃO AJAX
    var data = {'obj': obj, 'funcao': funcao};                                             // SETA OS PARAMETROS
    var retorno;                                                                        // VAR DE RETORNO
    $.ajax({
        type: "POST",
        url: "../view/vDashboard.php",
        dataType: "json",
        async: false,
        data: data,
        success: function (result) {
            //console.info(result)
            retorno = result;
        }, // RETORNO DO AJAX NO SUCCESS
        error: function (xhr, status, error) {
            alert(error);
        }
    });                                                                                 // FIM DO AJAX        
    return retorno;                                                                     // RETORNO DA FUNÇÃO
};
jDashboard.start();