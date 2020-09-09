function dateFormat(fecha) {
	const aux = fecha.split('-');
	return `${aux[2]}-${aux[1]}-${aux[0]}`;
}

function dateFormatPG(fecha) {
	var aux = fecha.split('+');
	return dateFormat(aux[0]) + ' | ' + aux[1];
}