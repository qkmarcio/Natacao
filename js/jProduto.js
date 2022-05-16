var produto = {};
var usuario = $("#usuarioID").val();

produto.start = function () {
    var obj = new Object();
    obj.campo = "first 100 *";
    obj.where = "where disponivel='S' and ativo='N' order by descricao";
    produto.lista(obj);


    if (usuario == 5) { // verifica se o usuario tem permissao
        $(".prodmenu1").hide();
    }

};

produto.buscaProduto = function (value) {

    if (value === '') {
        var obj = new Object();
        obj.campo = "first 100 *";
        obj.where = "where disponivel='S' and ativo='N' order by descricao";
        produto.lista(obj);
    } else {
        var obj = new Object();
        obj.campo = "*";
        obj.where = "where descricao like '" + value + "%' or \n\
                (fabricante like '" + value + "%') or \n\
                (fabricante2 like '" + value + "%') or \n\
                (original like '" + value + "%') or \n\
                (original2 like '" + value + "%') or \n\
                (fornec_agreg1 like '" + value + "%') or \n\
                (fornec_agreg2 like '" + value + "%') or \n\
                (fornec_agreg3 like '" + value + "%') or \n\
                (fornec_agreg4 like '" + value + "%') order by fabricante";
        produto.lista(obj);
    }
};

produto.lista = function (obj) {
    var data = {'obj': obj, 'funcao': 'getListaProduto'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "posicao"},
            {name: "idproduto"},
            {name: "codigo"},
            {name: "descricao"},
            {name: "marca"},
            {name: "venda"},
            {name: "minimo"},
            {name: "custo"},
            {name: "estoque"},
            {name: "v6meses"},
            {name: "original"}
        ],
        id: 'id',
        url: '../view/vProduto.php',
        data: data
    };

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#listaProduto").jqxGrid({
        width: '100%',
        source: dataAdapter,
        sortable: true,
        rowsheight: 70,
        columns: [
            {
                text: 'Image', datafield: 'idproduto', width: 70, cellsrenderer: function (row, column, value) {
                    return '<img src="../Fotos/' + value + '.jpg" width="70" height="70" />';
                }
            },
            {text: 'Posicao', datafield: 'posicao', width: 100, cellsAlign: 'right'},
            {text: 'Codigo', datafield: 'codigo', width: 100, cellsAlign: 'right'},
            {text: 'Original', datafield: 'original', width: 100, cellsAlign: 'right'},
            {text: 'Marca', datafield: 'marca', width: 100, cellsAlign: 'right'},
            {text: 'Descrição', datafield: 'descricao', width: 320},
            {text: 'Stock', datafield: 'estoque', width: 80, cellsAlign: 'right'},
            {text: '6 Meses', datafield: 'v6meses', width: 80, cellsAlign: 'right'},
            {text: 'Custo', datafield: 'custo', width: 100, cellsAlign: 'right'},
            {text: 'P.Venda', datafield: 'venda', width: 100, cellsAlign: 'right'},
            {text: 'P.Minimo', datafield: 'minimo', width: 100, cellsAlign: 'right'}
        ]
    });
};

produto.historicoCompra = function (o) {
    var obj = new Object();
    obj.id = o;

    var data = {'obj': obj, 'funcao': 'getListaProdutoCompra'};
    var source = {
        type: "POST",
        datatype: "json",
        datafields: [
            {name: "compra"},
            {name: "nota"},
            {name: "data"},
            {name: "codigo"},
            {name: "qtd"},
            {name: "valor"},
            {name: "total"},
            {name: "moeda"},
            {name: "custo"},
            {name: "descricao"},
            {name: "fornecedor"},
            {name: "cambio"}

        ],
        id: 'id',
        url: '../view/vProduto.php',
        data: data
    };

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO

    $("#historicoCompra").jqxGrid({
        width: '100%',
        height: 200,
        source: dataAdapter,
        sortable: true,
        columns: [
            {text: 'Codigo', datafield: 'codigo', width: 80, cellsAlign: 'right'},
            {text: 'Nota', datafield: 'nota', width: 100, cellsAlign: 'right'},
            {text: 'Data', datafield: 'data', width: 90, cellsAlign: 'right'},
            {text: 'Qtd', datafield: 'qtd', width: 60, cellsAlign: 'right'},
            {text: 'Moeda', datafield: 'moeda', width: 50, cellsAlign: 'right'},
            {text: 'Valor', datafield: 'valor', width: 80, cellsAlign: 'right'},
            {text: 'Total', datafield: 'total', width: 100, cellsAlign: 'right'},
            {text: 'Outro Custo', datafield: 'custo', width: 120, cellsAlign: 'right'},
            {text: 'Cotação', datafield: 'cambio', width: 80, cellsAlign: 'right'},
            {text: 'Descricao', datafield: 'descricao', width: 320},
            {text: 'Fornecedor', datafield: 'fornecedor', width: 320},
            {text: 'Compra', datafield: 'compra', width: 80, cellsAlign: 'right'}

        ]
    });
};

produto.checkImagem = function (url) {
    $('#imgProduto').bind('error', function () {
        $('#imgProduto').attr('src', '../Fotos/error.jpg');
    });
};

produto.impEtiqueta = function () {
    $("#ProdEtiqueta").dialog({
        resizable: false,
        title: 'Selecione Etiqueta',
        width: 320, height: 100,
        modal: false,
        draggable: false,
        dialogClass: "no-close",
        closeOnEscape: false,
        buttons: {
            "Con Logo": function () {
                $(this).dialog("close");
            },
            "Si Logo": function () {
                $(this).dialog("close");
            },
            Cancela: function () {
                $(this).dialog("close");
            }
        }
    });
}
$('#ProdEtiquetaLogo').click(function () {

    var id = $("#listaProduto").jqxGrid('getselectedrowindex');
    var row = $('#listaProduto').jqxGrid('getrowdata', id);

    if (row == undefined) {
        alert('selecionar producto na Grid!');
    } else {
        window.open("../Relatorios/EtiquetaMercadoria.php?id=" + row.idproduto + "&rel=1");
    }
});
$('#ProdEtiquetaEuro').click(function () {

    var id = $("#listaProduto").jqxGrid('getselectedrowindex');
    var row = $('#listaProduto').jqxGrid('getrowdata', id);

    if (row == undefined) {
        alert('selecionar producto na Grid!');
    } else {
        window.open("../Relatorios/EtiquetaMercadoria.php?id=" + row.idproduto + "&rel=1");
    }
});

$('#ProdEtiquetaVal').click(function () {

    var id = $("#listaProduto").jqxGrid('getselectedrowindex');
    var row = $('#listaProduto').jqxGrid('getrowdata', id);

    if (row == undefined) {
        alert('selecionar producto na Grid!');
    } else {
        window.open("../Relatorios/EtiquetaMercadoria.php?id=" + row.idproduto + "&rel=2");
    }
});

$('#listaProduto').on('rowselect', function (event) {
    //console.info(event);
    var codigo = event.args.row.idproduto;
    $('#imgProduto').attr('src', '../Fotos/' + codigo + '.jpg');
    produto.checkImagem(codigo);
    if (usuario == 5) { // verifica se o usuario tem permissao
        $(".prodmenu1").hide();
    } else {
        produto.historicoCompra(codigo);
    }

});

produto.start();