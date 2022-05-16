/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var jListaProduto = {};


jListaProduto.start = function () {
    jListaProduto.ListaDashboard();
}
jListaProduto.ajax = function (obj, funcao) {                                   // FUNÇÃO AJAX
    var data = {'obj': obj, 'funcao': funcao};                                  // SETA OS PARAMETROS
    var retorno;                                                                // VAR DE RETORNO
    $.ajax({
        type: "POST",
        url: "../view/vProduto.php",
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
    });                                                                         // FIM DO AJAX        
    return retorno;                                                             // RETORNO DA FUNÇÃO
};

jListaProduto.ListaDashboard = function (data1, data2) {
    
    var obj = new Object();
    obj.data = "'" + data1 + "' and '" + data2 + "'";
    var data = {'obj': obj, 'funcao': 'getItensVendido'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "PRO_ID"},
            {name: "T_CUSTO"},
            {name: "T_VENDA"},
            {name: "CODIGO"},
            {name: "MARGEM"},
            {name: "DESGRICAO"},
            {name: "QTD_VENDA"},
            {name: "ESTOQUE"},
            {name: "PEDIDO"},
            {name: "JAN"},{name: "JAN_MARGEM"},
            {name: "FEV"},{name: "FEV_MARGEM"},
            {name: "MAR"},{name: "MAR_MARGEM"},
            {name: "ABR"},{name: "ABR_MARGEM"},
            {name: "MAI"},{name: "MAI_MARGEM"},
            {name: "JUN"},{name: "JUN_MARGEM"},
            {name: "JUL"},{name: "JUL_MARGEM"},
            {name: "AGO"},{name: "AGO_MARGEM"},
            {name: "SET"},{name: "SET_MARGEM"},
            {name: "OUT"},{name: "OUT_MARGEM"},
            {name: "NOV"},{name: "NOV_MARGEM"},
            {name: "DEZ"},{name: "DEZ_MARGEM"},
        ],
        id: 'id',
        url: '../view/vProduto.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaProduto").jqxDataTable({
        width: '100%',
        height: 345,
        source: dataAdapter,
        altRows: true,
        sortable: true,
//      exportSettings: {fileName: "Lista PRODUTO"},
        columns: [
            {text: 'Codigo', datafield: 'CODIGO', width: 100, cellsAlign: 'right',align: 'center'},
            {text: 'Venda', datafield: 'QTD_VENDA', width: 60, cellsAlign: 'right', align: 'center'},
            {text: 'Estock', datafield: 'ESTOQUE', width: 60, cellsAlign: 'right', align: 'center'},
            {text: 'Custo', datafield: 'T_CUSTO', width: 100, cellsAlign: 'right', align: 'center'},
            {text: 'Valor', datafield: 'T_VENDA', width: 100, cellsAlign: 'right', align: 'center'},
            {text: 'Pedido', datafield: 'PEDIDO', width: 55, cellsAlign: 'right', align: 'center'},
            {text: 'JAN', datafield: 'JAN', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'JAN%', datafield: 'JAN_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'FEV', datafield: 'FEV', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'FEV%', datafield: 'FEV_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'MAR', datafield: 'MAR', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'MAR%', datafield: 'MAR_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'ABR', datafield: 'ABR', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'ABR%', datafield: 'ABR_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'MAI', datafield: 'MAI', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'MAI%', datafield: 'MAI_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'JUN', datafield: 'JUN', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'JUN%', datafield: 'JUN_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'JUL', datafield: 'JUL', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'JUL%', datafield: 'JUL_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'AGO', datafield: 'AGO', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'AGO%', datafield: 'AGO_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'SET', datafield: 'SET', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'SET%', datafield: 'SET_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'OUT', datafield: 'OUT', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'OUT%', datafield: 'OUT_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'NOV', datafield: 'NOV', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'NOV%', datafield: 'NOV_MARGEM', width: 50, cellsAlign: 'right', align: 'center'},
            {text: 'DEZ', datafield: 'DEZ', width: 40, cellsAlign: 'right', align: 'center'},
            {text: 'DEZ%', datafield: 'DEZ_MARGEM', width: 50, cellsAlign: 'right', align: 'center'}
        ]
    });
};
jListaProduto.start();
