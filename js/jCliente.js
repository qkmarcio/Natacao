var cliente = {};

cliente.start = function () {
    cliente.lista();
};
cliente.lista = function () {
   // $("#TchequeVGuarani,#TchequeVReal,#TchequeVDolar").html('0');

    //var dia = gerenciar.data();
    var obj = new Object();
        obj.campo = "";
    var data = {'obj': obj, 'funcao': 'getListaCliente'};
    var source = {type: "POST", datatype: "json", datafields: [
                {name: "idcliente"}, 
                {name: "cliente"}, 
                {name: "fantasia"},
                {name: "credito", type: 'float'}
            ],
        id: 'id',
        url: '../view/vCliente.php',
        data: data};

    var dataAdapter = new $.jqx.dataAdapter(source); // VAR DE RETORNO
    
    $("#listaCliente").jqxDataTable({
        width: '100%',
        height: 500,
        filterable: true,
        source: dataAdapter,
        altRows: true,
        sortable: true,
        pageSize: 15,
        pageable: true,
        pagerButtonsCount: 10,
        filterMode: 'advanced',
        exportSettings: {
        fileName: "Lista de Cliente"
    },
        columns: [
            {text: 'Codigo', datafield: 'idcliente', width: 100},
            {text: 'Nome', datafield: 'cliente', width: 300},
            {text: 'Nome Fantasia', datafield: 'fantasia', width: 300},
            {text: 'Limit Credito', datafield: 'credito', width: 200, cellsAlign: 'right', align: 'right', cellsformat: 'd'}
            
        ]
    });

};
cliente.start();