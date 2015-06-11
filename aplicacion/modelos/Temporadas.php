<?php
    /*
     * CLASE MODELO TEMPORADAS
     */
    class Temporadas extends CActiveRecord {
        
        protected function fijarNombre() {
            return 'temporada';
        }
        
        protected function fijarTabla(){
            return "temporadas";
        }
        
        protected function fijarID(){
            return "cod_temporada";
        }
        
        protected function fijarAtributos() {
            return array("cod_temporada", "nombre",
                            "fecha_inicio", "fecha_fin");
        }
        protected function fijarDescripciones() {
            return array("cod_temporada" => "Código temporada:",
                            "nombre"=>"Nombre:",
                            "fecha_inicio"=>"Fecha de inicio:",
                            "fecha_fin"=>"Fecha de finalización:");
        }
        protected function fijarRestricciones() {
            Return array(array("ATRI"=>"cod_temporada","TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"cod_temporada","TIPO"=>"ENTERO","MIN"=>0, "MENSAJE"=>"El código de la temporada debe ser positivo", "DEFECTO"=>0),
                         array("ATRI"=>"nombre","TIPO"=>"CADENA","TAMANIO"=>50, "MENSAJE"=>"El tamaño del nombre no debe superar los 50 caracteres"),
                         array("ATRI"=>"nombre","TIPO"=>"FUNCION","FUNCION"=>"convertirMayuscula"),
                         array("ATRI"=>"fecha_inicio","TIPO"=>"FECHA"),
                         array("ATRI"=>"fecha_inicio", "TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"fecha_inicio","TIPO"=>"FUNCTION","FUNCTION"=>"validaFechaInicio"),
                         array("ATRI"=>"fecha_fin","TIPO"=>"FECHA"),
                         array("ATRI"=>"fecha_fin","TIPO"=>"REQUERIDO"),
                         array("ATRI"=>"fecha_fin","TIPO"=>"FUNCTION", "FUNCTION"=>"validaFechaFin"));
                                
        }
        protected function afterCreate() {
            $this -> cod_temporada = 1;
            $this -> nombre = "";
            
            $fech = new DateTime();
            $fecha = $fech->format("d/m/Y");
            $this -> fecha_inicio = $fecha;
            $this -> fecha_fin = $fecha;
        }
        
        protected function afterBuscar(){        
            $fecha=$this->fecha_inicio;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_inicio=$fecha;        
        
            $fecha=$this->fecha_fin;
            $fecha=CGeneral::fechaMysqlANormal($fecha);
            $this->fecha_fin=$fecha;
        } 
        
        protected function convertirMayuscula(){        
            $cadena=strtoupper($this->nombre);
            $this->nombre=$cadena;        
        }
        
        protected function validaFechaInicio(){
            
            $fecha1=DateTime::createFromFormat('d/m/Y',$this->fecha_inicio);
            
            $fecha2 = new DateTime();
            $fecha2= $fecha2->format("d/m/Y");
            if ($fecha1<$fecha2){
                $this->setError("fecha_inicio","La fecha de inicio debe ser posterior a ");
            }
        }
        
        protected function validaFechaFin(){
            
            $fecha1=DateTime::createFromFormat('d/m/Y',$this->fecha_fin);
            $fecha2=DateTime::createFromFormat('d/m/Y',$this->fecha_inicio);
            if ($fecha1<$fecha2){
                $this->setError("fecha_fin","La fecha de finalización debe ser posterior a ".$fecha2);
            }
        }
        
        protected function fijarSentenciaInsert(){
            $nombre=CGeneral::addSlashes($this->nombre);
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            return "insert into temporadas (".
                    " nombre, fecha_inicio, fecha_fin ".
                    " ) values ( ".
                    " '$nombre', '$fecha_inicio', ".
                    " '$fecha_fin' ".
                    " ) " ;
        }
        
        protected function fijarSentenciaUpdate(){
            $nombre=CGeneral::addSlashes($this->nombre);
            $fecha_inicio=CGeneral::fechaNormalAMysql($this->fecha_inicio);
            $fecha_fin=CGeneral::fechaNormalAMysql($this->fecha_fin);
            return "update temporadas set ".
                    " nombre='$nombre', ".
                    " fecha_inicio='$fecha_inicio', ".
                    " fecha_fin='$fecha_fin' ".
                    " where cod_temporada={$this->cod_temporada} ";
        }
        
        public static function listaTemporadas($codigo=null){
            
            $temporadas = new Temporadas();
            if ($codigo == null) {
                        
                $lista = array();
                foreach($temporadas->buscarTodos() as $temporada)
                    $lista[$temporada["cod_temporada"]] = $temporada["nombre"];
                
                return $lista;
            }
            
            if ($temporadas->buscarPorId($codigo))
            return $temporadas->nombre;
            
            return null;
            
        }
		
		public static function listaTemporadasProximas(){
			$temporadas=new Temporadas();
			$listaTemporadas=$temporadas->buscarTodos(array("where"=>" t.fecha_fin>='".date("Y-m-d")."'"));
			if($listaTemporadas){
				foreach ($listaTemporadas as $temporada) 
					$lista[$temporada["cod_temporada"]] = $temporada["nombre"];
                
           		return $lista;	
			}
			return null;
			
		}
        
    }
