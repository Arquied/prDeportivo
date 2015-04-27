<?php

echo CHTML::dibujaEtiqueta("div",array("id"=>"myCarousel","class"=>"carousel slide", "data-ride"=>"carousel"));

// Indicadores
echo CHTML::dibujaEtiqueta("ol",array("class"=>"carousel-indicators"));

for ($cont=0;$cont<count($filas);$cont++){
	echo CHTML::dibujaEtiqueta("li",array("data-target"=>"#myCarousel","data-slide-to"=>$cont,"",true));
}

echo CHTML::dibujaEtiquetaCierre("ol");

// cada hoja de la caroucel
echo CHTML::dibujaEtiqueta("div",array("class"=>"carousel-inner","role"=>"listbox"));

for ($cont=0;$cont<count($filas);$cont++){
	if ($cont==0){
		echo CHTML::dibujaEtiqueta("div",array("class"=>"item active"));
	}
	else{
		echo CHTML::dibujaEtiqueta("div",array("class"=>"item"));
	}
	echo CHTML::dibujaEtiqueta("img",array("class"=>"first-slide","src"=>$filas[$cont]["imagen"],"alt"=>"First slide"),"",true);
	echo CHTML::dibujaEtiqueta("div",array("class"=>"container"));
	echo CHTML::dibujaEtiqueta("div",array("class"=>"carousel-caption"));
	echo CHTML::dibujaEtiqueta("h1",array(),$filas[$cont]["nombre"],true);
	echo CHTML::dibujaEtiqueta("p",array(),$filas[$cont]["mini_descripcion"],true);
	echo CHTML::dibujaEtiqueta("p",array());
	echo CHTML::dibujaEtiqueta("a",array("class"=>"btn btn-lg btn-primary","href"=>"","role"=>"button"),"Apuntate",true);
	echo CHTML::dibujaEtiquetaCierre("p");
	echo CHTML::dibujaEtiquetaCierre("div");
	echo CHTML::dibujaEtiquetaCierre("div"); 
	echo CHTML::dibujaEtiquetaCierre("div");
}

// Anterior
echo CHTML::dibujaEtiqueta("a",array("class"=>"left carousel-control","href"=>"#myCarousel","role"=>"button","data-slide"=>"prev"));
echo CHTML::dibujaEtiqueta("span",array("class"=>"glyphicon glyphicon-chevron-left","aria-hidden"=>true),"",true);
echo CHTML::dibujaEtiqueta("span",array("class"=>"sr-only"),"Previous",true);
echo CHTML::dibujaEtiquetaCierre("a");

//Siguiente
echo CHTML::dibujaEtiqueta("a",array("class"=>"right carousel-control","href"=>"#myCarousel","role"=>"button","data-slide"=>"next"));
echo CHTML::dibujaEtiqueta("span",array("class"=>"glyphicon glyphicon-chevron-right","aria-hidden"=>true),"",true);
echo CHTML::dibujaEtiqueta("span",array("class"=>"sr-only"),"Next",true);
echo CHTML::dibujaEtiquetaCierre("a");
echo CHTML::dibujaEtiquetaCierre("div");
