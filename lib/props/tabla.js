function armaTabla(idtabla, idrecipiente, json, lenguaje, acciones = "") {
	json1 = JSON.parse(json)[0];
	var hasOwn = Object.prototype.hasOwnProperty;
	var keys = [],
		name;
	for (name in json1) {
		if (hasOwn.call(json1, name)) {
			keys.push(name);
		}
	}
	var jsontrarr = [];
	json = JSON.parse(json);
	// for (j = 0; j < json.length; j++) {
	//     jsontr = {};
	//     for (i = 0; i < keys.length; i++) {
	//         jsontr[lenguaje[keys[i]]] = json[j][keys[i]];
	//     }
	//     jsontrarr.push(jsontr);
	// }

	// json = JSON.stringify(jsontrarr);

	$.ajax({
		type: "POST",
		data: { json: json, idtabla: idtabla, acciones: acciones },
		url: "traz-comp/Tabla/armaTabla",
		async: true,
		success: function (result) {
			document.getElementById(idrecipiente).innerHTML = "";
			document.getElementById(idrecipiente).innerHTML = result;
			$("#" + idtabla).DataTable({});
		},
	});
}

function insertaFila(idtabla, idrecipiente, json, acciones = "") {
	$.ajax({
		type: "POST",
		data: { json: json, idtabla: idtabla, acciones: acciones },
		url: "traz-comp/Tabla/insertaFila",
		async: true,
		success: function (result) {
			$("#" + idtabla + " tbody").append(result);
			tabla = document.getElementById(idtabla).innerHTML;
			tabla =
				'<table id="' +
				idtabla +
				'" class="table table-bordered table-hover">' +
				tabla +
				"</table>";
			$("#" + idtabla)
				.dataTable()
				.fnDestroy();
			document.getElementById(idrecipiente).innerHTML = tabla;
			$("#" + idtabla).DataTable({});
		},
	});
}

function remover(event) {
	console.log(event);
	id = $(this).closest("tr").attr("id");
	$(this).closest("tr").remove();
	tabla = document.getElementById(event.data.idtabla).innerHTML;
	tabla =
		'<table id="' +
		event.data.idtabla +
		'" class="table table-bordered table-hover">' +
		tabla +
		"</table>";
	$("#" + event.data.idtabla)
		.dataTable()
		.fnDestroy();
	document.getElementById(event.data.idrecipiente).innerHTML = tabla;
	$("#" + event.data.idtabla).DataTable({});
	if ($(this).closest("tbody").children().length == 1) {
		document.getElementById(event.data.idrecipiente).innerHTML = "";
		document.getElementById(event.data.idbandera).value = "no";
	}
}

function DataTable(tabla, acciones = true) {
	var accion = [
		{
			targets: [0],
			searchable: false,
		},
		{
			targets: [0],
			orderable: false,
		},
		{ targets: [1], type: 'natural' }
	];

	$(tabla).DataTable({
		aLengthMenu: [10, 25, 50, 100],
		columnDefs: acciones ? accion : [{ targets: [1], type: 'natural' }],
		order: [],
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ningún dato disponible en esta tabla",
			sInfo:
				"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
			sInfoPostFix: "",
			sSearch: "Buscar:",
			sUrl: "",
			sInfoThousands: ",",
			sLoadingRecords: "Cargando...",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Último",
				sNext: "Siguiente",
				sPrevious: "Anterior",
			},
			oAria: {
				sSortAscending:
					": Activar para ordenar la columna de manera ascendente",
				sSortDescending:
					": Activar para ordenar la columna de manera descendente",
			},
		},
	});
}

function ajustarTabla(tabla) {
	$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
}

function existFunction(nombre, paramentro = false) {
	var fn = window[nombre];
	if (typeof fn === "function") {
		if (paramentro) fn(paramentro);
		else fn();
		return true;
	} else return false;
}
