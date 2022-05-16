/* global custom */

var jRankVenda = {};

jRankVenda.start = function () {
    
    

    $("#vendaInicio").jqxDateTimeInput({width: 200, height: 25, selectionMode: 'range'});

    var date1 = new Date();
    var ano = date1.getFullYear();
    var mm = date1.getMonth();
    date1.setFullYear(ano, mm, 1);

    var date2 = new Date();
    var ano2 = date2.getFullYear();
    var dd2 = date2.getDate();
    var mm2 = date2.getMonth();
    date2.setFullYear(ano2, mm2, dd2);

    $("#vendaInicio").jqxDateTimeInput('setRange', date1, date2);
    jRankVenda.RankVendedor(date2.toISOString().substring(0, 8) + '01', jRankVenda.data());
    /// jRankVenda.RankLucro(date2.toISOString().substring(0, 8) + '01', jRankVenda.data());
    //jRankVenda.RankDevolucao(date2.toISOString().substring(0, 8) + '01', jRankVenda.data());
    //jRankVenda.myFunction(date2.toISOString().substring(0, 8) + '01', jRankVenda.data());


};

$("#vendaInicio").on('change', function (event) {
    var selection = $("#vendaInicio").jqxDateTimeInput('getRange');
    if (selection.from !== null) {
        //console.info("<div>From: " + selection.from.toLocaleDateString() + " <br/>To: " + selection.to.toLocaleDateString() + "</div>");
        //var data1 = custom.convertDatePortuguestoSql(selection.from.toLocaleDateString());
        var data1 = custom.convertDatePortuguestoSql(window.fromText);
        //var data2 = custom.convertDatePortuguestoSql(selection.to.toLocaleDateString());
        var data2 = custom.convertDatePortuguestoSql(window.toText);

        jRankVenda.RankVendedor(data1, data2);


    }
});

jRankVenda.data = function () {
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


jRankVenda.RankVendedor = function (data1, data2) {
    
    $("#rankVendedor,#rankLucro,#rankDevolucao").empty();

    var obj = new Object();
    obj.data = "'" + data1 + "' and '" + data2 + "' and IDVENDEDOR not in(20,36) ";
    obj.campo = ",VENDEDOR,IDVENDEDOR,\n\
(SELECT SUM(c.subtotal)\n\
                    FROM COMPRA c\n\
                    WHERE c.codvendadev IS NOT NULL\n\
                    AND c.cancelada IS NULL\n\
                    AND c.data_nota BETWEEN '" + data1 + "' and '" + data2 + "' AND IDVENDEDOR=c.idfunc\n\
                ) AS devolucao";
    obj.and = 'group by VENDEDOR,IDVENDEDOR order by 1 DESC';
    var data = custom.ajax(obj, 'getListaVendaMargem', '../view/vGerenciar.php');
 
    var venda = '', lucro = '', devolucao = '';
    for (var i = 0; i < data.length; i++) {
        venda = "<label style='margin-top: 10px;'>" + data[i].nome + "</label>" +
                "<div style='overflow: hidden;' class='pro' id='v" + data[i].id + "'></div>";
        lucro = "<label style='margin-top: 10px;'>" + data[i].nome + "</label>" +
                "<div style='overflow: hidden;' class='pro' id='l" + data[i].id + "'></div>";
        devolucao = "<label style='margin-top: 10px;'>" + data[i].nome + "</label>" +
                "<div style='overflow: hidden;' class='pro' id='d" + data[i].id + "'></div>";
        console.log(venda);
        $("#rankVendedor").append(venda);
        $("#rankLucro").append(lucro);
        $("#rankDevolucao").append(devolucao);

        $('#v' + data[i].id).jqxProgressBar({value: data[i].t_margenTvenda, animationDuration: 3000, template: "primary"});
        $('#l' + data[i].id).jqxProgressBar({value: data[i].t_lucro, animationDuration: 3000, template: "success"});
        $('#d' + data[i].id).jqxProgressBar({value: data[i].t_devolucao, animationDuration: 3000, template: "danger"});

    }
    $(".pro").jqxProgressBar({
        showText: true, renderText: function (text, value)
        {
            if (value < 40)
            {
                return "<span class='jqx-rc-all' style='color: #333;'>" + text + "</span>";
            }

            return "<span class='jqx-rc-all' style='color: #fff;'>" + text + "</span>";
        },
        width: 300, height: 15
    });
};


/**
 * Sort object properties (only own properties will be sorted).
 * @param {object} obj object to sort properties
 * @param {bool} isNumericSort true - sort object properties as numeric value, false - sort as string value.
 * @returns {Array} array of items in [[key,value],[key,value],...] format.
 */
function sortProperties2(obj, isNumericSort)
{
	isNumericSort=isNumericSort || false; // by default text sort
	var sortable=[];
	for(var key in obj)
		if(obj.hasOwnProperty(key))
			sortable.push([key, obj[key]]);
	if(isNumericSort)
		sortable.sort(function(a, b)
		{
			return a[1]-b[1];
		});
	else
		sortable.sort(function(a, b)
		{
			var x=a[1].toLowerCase(),
				y=b[1].toLowerCase();
			return x<y ? -1 : x>y ? 1 : 0;
		});
	return sortable; // array in format [ [ key1, val1 ], [ key2, val2 ], ... ]
}


function sortObjects(objects) {

    var newObject = {};

    var sortedArray = sortProperties(objects, 'zindex', true, true);
    for (var i = 0; i < sortedArray.length; i++) {
        var key = sortedArray[i][0];
        var value = sortedArray[i][1];

        newObject[key] = value;

    }

    return newObject;

}

/*
 * Classificar propriedades do objeto (somente as propriedades próprias serão ordenadas).
 * @param {object} objeto obj para classificar propriedades
 * @param {string | int} sortedBy 1 - classifique propriedades do objeto por valor específico.
 * @param {bool} isNumericSort true - classifique as propriedades do objeto como valor numérico, false - classifique como valor da string.
 * @param {bool} reverso falso - classificação reversa.
 * @returns {Array} matriz de itens no formato [[chave, valor], [chave, valor], ...].
 */
function sortProperties(obj, sortedBy, isNumericSort, reverse) {


    sortedBy = sortedBy || 1; // by default first key
    isNumericSort = isNumericSort || false; // by default text sort
    reverse = reverse || false; // by default no reverse

    var reversed = (reverse) ? -1 : 1;

    var sortable = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            sortable.push([key, obj[key]]);
        }
    }
    if (isNumericSort)
        sortable.sort(function (a, b) {
            return reversed * (a[0][sortedBy] - b[0][sortedBy]);
        });
    else
        sortable.sort(function (a, b) {
            var x = a[1][sortedBy].toLowerCase(),
                    y = b[1][sortedBy].toLowerCase();
            return x < y ? reversed * -1 : x > y ? reversed : 0;
        });
    return sortable; // array in format [ [ key1, val1 ], [ key2, val2 ], ... ]
    //console.info(sortable);
}





jRankVenda.RankLucro = function (data1, data2) {
    $("#rankLucro").empty();

    var obj = new Object();
    obj.data = "'" + data1 + "' and '" + data2 + "' and IDVENDEDOR not in(20,36) ";
    obj.campo = ",VENDEDOR,IDVENDEDOR";
    obj.and = 'group by VENDEDOR,IDVENDEDOR order by 1 DESC';
    var data = custom.ajax(obj, 'getListaVendaMargem', '../view/vGerenciar.php');

    var shtml = '', div = '';
    for (var i = 0; i < data.length; i++) {
        shtml = "<label style='margin-top: 10px;'>" + data[i].nome + "</label>" +
                "<div style='overflow: hidden;' class='pro' id='l" + data[i].id + "'></div>";
        $("#rankLucro").append(shtml);

        $('#l' + data[i].id).jqxProgressBar({value: data[i].t_margenTvenda, animationDuration: 3000, template: "primary"});

    }
    $(".pro").jqxProgressBar({
        showText: true, renderText: function (text, value)
        {
            if (value < 40)
            {
                return "<span class='jqx-rc-all' style='color: #333;'>" + text + "</span>";
            }

            return "<span class='jqx-rc-all' style='color: #fff;'>" + text + "</span>";
        },
        width: 500, height: 15
    });


};

jRankVenda.RankDevolucao = function (data1, data2) {
    $("#rankDevolucao").empty();

    var obj = new Object();
    obj.data = "'" + data1 + "' and '" + data2 + "' and IDVENDEDOR not in(20,36) ";
    obj.campo = ",VENDEDOR,IDVENDEDOR";
    obj.and = 'group by VENDEDOR,IDVENDEDOR order by 1 DESC';
    var data = custom.ajax(obj, 'getListaVendaMargem', '../view/vGerenciar.php');

    var shtml = '', div = '';
    for (var i = 0; i < data.length; i++) {
        shtml = "<label style='margin-top: 10px;'>" + data[i].nome + "</label>" +
                "<div style='overflow: hidden;' class='pro' id='d" + data[i].id + "'></div>";
        $("#rankDevolucao").append(shtml);

        $('#d' + data[i].id).jqxProgressBar({value: data[i].t_margenTvenda, animationDuration: 3000, template: "primary"});

    }
    $(".pro").jqxProgressBar({
        showText: true, renderText: function (text, value)
        {
            if (value < 40)
            {
                return "<span class='jqx-rc-all' style='color: #333;'>" + text + "</span>";
            }

            return "<span class='jqx-rc-all' style='color: #fff;'>" + text + "</span>";
        },
        width: 500, height: 15
    });


};

//jRankVenda.myFunction = function (data1, data2) {
//    setInterval(function () {
//        jRankVenda.RankVendedor(data1, data2);
//    }, 60000);
//};

jRankVenda.start();