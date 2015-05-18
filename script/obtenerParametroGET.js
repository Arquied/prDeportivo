function $_GET(param){
	/* Obtener la url completa */
	url = document.URL;
	/* Buscar a partir del signo de interrogación ? */
	url = String(url.match(/\?+.+/));
	/* limpiar la cadena quitándole el signo ? */
	url = url.replace("?", "");
	/* Crear un array con parametro=valor */
	url = url.split("&");
	 
	/* 
	Recorrer el array url
	obtener el valor y dividirlo en dos partes a través del signo = 
	0 = parametro
	1 = valor
	Si el parámetro existe devolver su valor
	*/
	x = 0;
	while (x < url.length){
		p = url[x].split("=");
		if (p[0] == param){
			var expReg=/#$/;
			if(expReg.test(p[1])){
				p[1]=p[1].substr(0, p[1].length-1);
			}
			return decodeURIComponent(p[1]);
		}
		x++;
	}
}
