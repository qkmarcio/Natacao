/* global custom */

var jExpedicon = {};
jExpedicon.start = function () {

    // var usuario = $("#usuarioID").val();
    if ($("#usuarioID").val() == 5) { // verifica se o usuario tem permissao
        setInterval(function () {
            jExpedicon.ListaSeparacion1(data_inicio, data_fim);
        }, 60000);
        setInterval(function () {
            jExpedicon.ListaSeparacion2(data_inicio, data_fim);
        }, 600000);
        setInterval(function () {
            jExpedicon.ListaSeparacion3(data_inicio, data_fim);
        }, 1200000);
        setInterval(function () {
            jExpedicon.ListaSeparacion4(data_inicio, data_fim);
        }, 1200000);
        //$("#page-wrapper").get;
    }
    $(".Separador2").click(function () {
        $("#listaSeparacion2").jqxDataTable('exportData', 'xls');
    });
    var date1 = new Date();
    var ano = date1.getFullYear();
    var mm = date1.getMonth();
    date1.setFullYear(ano, mm, 1);
    var date2 = new Date();
    var ano = date2.getFullYear();
    var mm = date2.getMonth();
    var dd = date2.getDate();
    date2.setFullYear(ano, mm, dd);

    var data_inicio = jExpedicon.data(01);
    var data_fim = jExpedicon.data();

    /* data_inicio = '2018-07-01';
     data_fim = '2018-07-30';*/


    jExpedicon.ListaSeparacion1(data_inicio, data_fim);
    jExpedicon.ListaSeparacion2(data_inicio, data_fim);
    jExpedicon.ListaSeparacion3(data_inicio, data_fim);
    jExpedicon.ListaSeparacion4(data_inicio, data_fim);
    jExpedicon.relogio();


};
jExpedicon.adicionarZero = function (a) {
    if (a < 10) {
        a = "0" + a;
    }
    return a;
};

jExpedicon.data = function (v) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (v === 01) {
        dd = '01';
    } else if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }


    var dia = yyyy + '-' + mm + '-' + dd;
    return dia;
};

jExpedicon.convertDateSqltoPortugues = function (date) {
    if (date !== null) {
        var s = date.split("-");
        var ano = s[0];
        var mes = s[1];
        var dia = s[2];
        return dia + "/" + mes + "/" + ano;
    }
};
//Separacion traz todos os pedidos em separacion
jExpedicon.ListaSeparacion1 = function (data1, data2) {

    var obj = new Object();
//    obj.inicio = "'" + data1 + "'";
//    obj.fim = "'" + data2 + "'";
    obj.inicio = "'2019-01-01'";
    obj.fim = "'2019-01-31'";
    obj.campo = "'" + data1 + "'";

    var data = {'obj': obj, 'funcao': 'getVListaSepIS'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "equipes"},
            {name: "pedidos"},
            {name: "media"},
            {name: "nome"},
            {name: "itens"},
            {name: "tempo"},
            {name: "vendedor"},
            {name: "cliente"},
            {name: "transportadora"}
        ],
        id: 'id',
        url: '../view/vExpedicion.php',
        data: data};

    var cellClass = function (row, datafields, value, cellText, rowData) {
        var v = cellText;

        if (v.equipes == 1) {
            return "azul";
        } else if (v.equipes == 2) {
            return "vermelho";
        } else if (v.equipes == 3) {
            return "verde";
        }
        // debugger;
    };
    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaSeparacion1").jqxDataTable({
        width: '100%',
        height: 500,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        exportSettings: {
            fileName: "Lista Separação"
        },
        columns: [
            {text: 'Nombre', datafield: 'nome', width: '30%', cellsAlign: 'left', align: 'center', cellClassName: cellClass},
            {text: 'Pedido', datafield: 'pedidos', width: '20%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'Itens', datafield: 'itens', width: '15%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'Tiempo', datafield: 'tempo', width: '15%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'Prevision', datafield: 'media', width: '20%', cellsAlign: 'center', align: 'center', cellClassName: cellClass}
        ]
    });
};

jExpedicon.ListaSeparacion2 = function (data1, data2) {

    var obj = new Object();
    obj.inicio = "'" + data1 + "'";
    obj.fim = "'" + data2 + "'";

    var data = {'obj': obj, 'funcao': 'getVListaSepRank'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "equipes"},
            {name: "nome"},
            {name: "itens"},
            {name: "itens_hora"},
            {name: "punto"}
        ],
        id: 'id',
        url: '../view/vExpedicion.php',
        data: data};
    var cellClass = function (row, datafields, value, cellText, rowData) {
        var v = cellText;

        if (v.equipes == 1) {
            return "azul";
        } else if (v.equipes == 2) {
            return "vermelho";
        } else if (v.equipes == 3) {
            return "verde";
        }
        // debugger;
    };
    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaSeparacion2").jqxDataTable({
        width: '100%',
        height: 500,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        exportSettings: {
            fileName: "Lista Rank Separação"
        },
        columns: [
            {text: 'Nombre', datafield: 'nome', width: '30%', cellsAlign: 'left', align: 'center', cellClassName: cellClass},
            {text: 'T.Itens', datafield: 'itens', width: '25%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'I.Media', datafield: 'itens_hora', width: '25%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'Puntos', datafield: 'punto', width: '20%', cellsAlign: 'center', align: 'center', cellClassName: cellClass}

        ]
    });
};
jExpedicon.ListaSeparacion3 = function (data1, data2) {

    var obj = new Object();
    obj.inicio = "'" + data1 + "'";
    obj.fim = "'" + data2 + "'";

    var data = {'obj': obj, 'funcao': 'getVListaConfRank'};
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
        data: data};

    var cellClass = function (row, datafields, value, cellText, rowData) {
        var v = cellText;

        if (v.equipes == 1) {
            return "azul";
        } else if (v.equipes == 2) {
            return "vermelho";
        } else if (v.equipes == 3) {
            return "verde";
        }
        // debugger;
    };

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaSeparacion3").jqxDataTable({
        width: '100%',
        height: 200,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        exportSettings: {
            fileName: "Lista Conferente"
        },
        columns: [
            {text: 'Nombre', datafield: 'nome', width: '30%', cellsAlign: 'left', align: 'center', cellClassName: cellClass},
            {text: 'T.Itens', datafield: 'itens', width: '25%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'I.Media', datafield: 'itens_hora', width: '25%', cellsAlign: 'center', align: 'center', cellClassName: cellClass},
            {text: 'Puntos', datafield: 'punto', width: '20%', cellsAlign: 'center', align: 'center', cellClassName: cellClass}
        ]
    });
};
jExpedicon.ListaSeparacion4 = function (data1, data2) {

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
        // debugger;
    };
    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaSeparacion4").jqxDataTable({
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

jExpedicon.ajax = function (obj, funcao) {                                                  // FUNÇÃO AJAX
    var data = {'obj': obj, 'funcao': funcao};                                             // SETA OS PARAMETROS
    var retorno;                                                                        // VAR DE RETORNO
    $.ajax({
        type: "POST",
        url: "../view/vExpedicion.php",
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

jExpedicon.start();