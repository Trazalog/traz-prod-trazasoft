function getJson2(id) {

	if(!$(id).hasClass('data-json')){
		id = $(id).closest('.data-json');

	}

	var data = $(id).attr("data-json");
	
	if (!data) return false;
	data = JSON.parse(data);

	if (!data) return false;
	return data;
}

function setJson(id, data) {
	if(!$(id).hasClass('data-json')){
		id = $(id).closest('.data-json');
	}
	$(id).attr("data-json", JSON.stringify(data));
}

function setAttr(id, nombre, data) {
	if(!$(id).hasClass('data-json')){
		id = $(id).closest('.data-json');
	}
	var json = getJson2(id);

	json[nombre] = data;
	setJson(id, json);
}
