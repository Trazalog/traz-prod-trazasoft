function dateFormat(fecha) {
	const aux = fecha.split('-');
	return `${aux[2]}-${aux[1]}-${aux[0]}`;
}