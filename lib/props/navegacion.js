var site = null;
var backSite = null;

function linkTo(link = null) {
	wo();
	$("#content").empty();

	if (link != null) {
		$("#content").load("index.php/" + link);
		backSite = site;
		site = link;
		wc();
		return;
	}

	$("#content").load("index.php/" + site);
	wc();
}

function back() {
	linkTo(backSite);
}


$(".menu .link").click(function () {
	if (this.dataset.link == "") {
		linkTo("Admin/nopage");
	} else {

		linkTo(this.dataset.link);
	}
});

function wo(texto) {
	if (texto == "" || texto == null) {
		$("#waitingText").html("Cargando ...");
	} else {
		$("#waitingText").html(texto);
	}
	$("#waiting").fadeIn("slow");
}

function wc() {
	$("#waiting").fadeOut("slow");
}

var bak_icon = null;
var wait_icon = '<i class="fa fa-spinner fa-spin mr-1"></i>';
function wb(e) {
	const ban = $(e).prop("disabled");

	if (ban) {
		if ($(e).hasClass("fa")) {
			$(e).removeClass().addClass(bak_icon);
		} else {
			$(e).find("i").remove();
			$(e).prepend("<i class='" + bak_icon + "'></i>");
		}
	} else {
		if ($(e).hasClass("fa")) {
			bak_icon = $(e).attr("class");
			$(e).removeClass().addClass("fa fa-spinner fa-spin mr-1");
		} else {
			bak_icon = $(e).find("i").attr("class");
			$(e).find("i").remove();
			$(e).prepend(wait_icon);
		}
	}

	$(e).prop("disabled", !ban);
}

function reload(e = false, parametro = false) {
	if (e) {
		var link = false;

		if ($(e).hasClass("reload")) {
			link = $(e).attr("data-link");
		} else {
			link = $(e).closest(".reload").attr("data-link");
		}

		if (!link) {
			console.log("Falla al recargar el contenido");
			return;
		}

		$(e).html("Cargando...");
		$(e).load(link + (parametro ? "/" + parametro : ""));
	} else {
		return;
	}
}
