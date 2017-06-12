<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;

class PdfPlanillaNotasController extends PdfTemplateLanscapeLetterController
{
	//GENERA UN PDF DE UNA PLANILLA VACIO PARA UNA MATERIA 
	
    public function planillaNotas($datos){
    	
    	$this->cabeceraPlanilla($datos['cabecera']);
    	
    	
    	$this->cabeceraTabla();
    	
    	$this->pdf::setXY(10,48);
    	$this->pdf::SetFont('Arial','',9);
    	foreach($datos['alumnos'] as $alumno){
    	
    	
    		$this->addLinea($alumno);//array('numerolista'=>$i,'nombre'=>"Juan camilo Arguelo Prieto C"));
    	
    	
    	}
    	
    	///DATOS FINAL DE PLANILLA
    	
    	$this->datosFinalPlanilla($datos['cabecera'][0]->nombres. " " . $datos['cabecera'][0]->apellidos);
    	
    	$this->imprimirEstadisticas($datos);
    	
	}
	
	
	//////////////////////////////FUNCIONES AUXILIARES//////////////////////////
	
	public function datosFinalPlanilla($docente){
		
		
		$this->pdf::setY($this->pdf::getY()+25);
		
		$this->verificarNuevaLinea();
		$y=$this->pdf::getY();
		$x = 115;
		
		$this->pdf::setXY($x,$y);
		
		$this->pdf::SetFont('Arial','B',9);
		$this->pdf::Cell(60, 5,\App\Helpers::utf("FANNY EDILMA RIAÑO PEDRAZA"), 0, 0, "C"); //DATOS COORDINADOR
		
		$this->pdf::setXY($x,$y+5);
		$this->pdf::SetFont('Arial','',8);
		$this->pdf::Cell(60, 5,\App\Helpers::utf("Coordinadora General"), 0, 0, "C");
		
		$x+=80;
		
		$this->pdf::setXY($x,$y);
		$this->pdf::SetFont('Arial','B',9);
		$this->pdf::Cell(60, 5,strtoupper(Helpers::utf($docente)), 0, 0, "C");  /// DATOS DOCENTE
		
		$this->pdf::setXY($x,$y+5);
		$this->pdf::SetFont('Arial','',8);
		$this->pdf::Cell(60, 5,\App\Helpers::utf("Docente"), 0, 0, "C");
		
		
	}
	
	
	public function imprimirEstadisticas($datos){
		$y = $this->pdf::getY() - 10;
		
		$x = 20;
		
		$this->pdf::Rect($x-2,$y-2,57,21,'F');
		$this->pdf::SetFont('Arial','',8);
		$this->pdf::setXY($x,$y);
		$this->pdf::Cell(60, 5,"Promedio del grado 1er periodo: ", 0, 0, "L");
		$this->pdf::setXY($x,$y+4);
		$this->pdf::Cell(60, 5,"Promedio del grado 2do periodo: ", 0, 0, "L");
		$this->pdf::setXY($x,$y+8);
		$this->pdf::Cell(60, 5,"Promedio del grado 3er periodo: ", 0, 0, "L");
		$this->pdf::setXY($x,$y+12);
		$this->pdf::Cell(60, 5,"Promedio del grado 4to periodo: ", 0, 0, "L");
	}
	
	
	public function verificarNuevaLinea(){
		$distanciaPie=$this->pdf::GetPageHeight() - $this->pdf::getY();
		
		if($distanciaPie<35){
			$this->pdf::AddPage('L','letter');
			$this->Header();
			$this->Footer();
			$this->pdf::setXY(10,30);
			$this->cabeceraPlanilla();
			$this->cabeceraTabla();
			$this->pdf::setX(10);
			
		}else{
			$this->pdf::Ln();
		}
	}
	
	public function addLinea($row){
		
		$this->verificarNuevaLinea();
		
		$h = 5;
		
		$this->pdf::Cell(10, $h,$row->codigolista ,1 , 0, "C"); //Codigo lista
		$this->pdf::Cell(81, $h,Helpers::utf($row->nombres." ".$row->apellidos),1 , 0, "L"); //nombre
		$this->pdf::Cell(10, $h,(isset($row['notasacar'])?$row['notasacar']:'') ,1 , 0, "C",1); //nota a sacar
		
		$this->pdf::setX($this->pdf::getX()+1); //ESPACION EN BLANCO
		for($i = 1; $i<=4;$i++){
			$this->pdf::Cell(6, $h,(isset($row['fallas'.$i.'p'])?$row['fallas'.$i.'p']:''),1 , 0, "C"); //Fallas 1P
		}
		
		
		$this->pdf::Cell(6, $h,(isset($row['tf'])?$row['tf']:''),1 , 0, "L",1); //TF
		
		$this->pdf::setX($this->pdf::getX()+1); //ESPACION EN BLANCO
		
		for($i=1;$i<=4;$i++){
			$this->pdf::Cell(10, $h,(isset($row['notas'.$i.'p'][0])?$row['notas'.$i.'p'][0]->nota:''),1 , 0, "C"); //NOTAS 1P
		}
		
		
		$this->pdf::setX($this->pdf::getX()+1); //ESPACION EN BLANCO
		
		
		
		
		$this->pdf::Cell(10, $h,(sizeof($row['DF Cognitivo'])>0?number_format($row['DF Cognitivo'][0]->promedio,2):''),1 , 0, "L",1); //COGMITIGO
		
		$this->pdf::Cell(10, $h,(sizeof($row['DF Procedimental'])>0?number_format($row['DF Procedimental'][0]->promedio,2):''),1 , 0, "L",1); //PROCEDIMENTAL
		
		$this->pdf::Cell(10, $h,(sizeof($row['DF Actitudinal'])>0?number_format($row['DF Actitudinal'][0]->promedio,2):''),1 , 0, "L",1); //ACTITUDINAL
		
		
		$this->pdf::setX($this->pdf::getX()+2); //DOBLE ESPACION EN BLANCO
		
		$this->pdf::Cell(10, $h,(sizeof($row['Preparatorio'])>0?number_format($row['Preparatorio'][0]->promedio,2):''),1 , 0, "L"); //PREPARATORIO
		
		$this->pdf::Cell(10, $h,(sizeof($row['Examen Asignatura'])>0?number_format($row['Examen Asignatura'][0]->promedio,2):''),1 , 0, "L"); //FINAL ASIGNATURA
		
		if(sizeof($row['Examen 4° Periodo'])>0){
			$this->pdf::Cell(10, $h,number_format($row['Examen 4° Periodo'][0]->promedio,2),1 , 0, "L"); //EXAMEN 4P
		}
		
		$this->pdf::Cell(10, $h,(sizeof($row['Examen Final'])>0?number_format($row['Examen Final'][0]->promedio,2):''),1 , 0, "L"); //EXAMEN FINAL
		
		$this->pdf::setX($this->pdf::getX()+2); //DOBLE ESPACION EN BLANCO
		
		$this->pdf::Cell(10, $h,(isset($row['nf'])?$row['nf']:''),1 , 0, "C",1); //NOTA FINAL
		
		
	}
	
	public function cabeceraPlanilla($datos){
		
		$this->pdf::setX(10);
		$this->pdf::Rect($this->pdf::getX(),$this->pdf::getY(),$this->pdf::GetPageWidth()-20,10,'F');
		
		$this->pdf::SetFont('Arial','B',10);
		$text = "Planilla de Notas / ".Helpers::getParametros()['periodo']. " / ".Helpers::getParametros()['anio'];
		$this->pdf::Cell(85, 10,Helpers::utf($text), 0, 0, "L");
		
		$this->pdf::setX(95);
		$this->pdf::SetFont('Arial','',10);
		$this->pdf::Cell(70, 10,Helpers::utf("Docente: ". $datos[0]->nombres . " " . $datos[0]->apellidos), 0, 0, "l");
		$this->pdf::Cell(55, 10,Helpers::utf("Asignatura: ". $datos[0]->nombremateria), 0, 0, "l");
		$this->pdf::Cell(53,10,HElpers::utf("Grado: ". $datos[0]->nombrecurso), 0, 0, "l");
	}
	
	public function cabeceraTabla(){
		$x = 10;
		$y= 42;
		$this->lineheight = 15;
		$this->pdf::setXY($x,$y);
		
		$this->pdf::SetFont('Arial','',10);
		
		$this->pdf::Cell(10, $this->lineheight,"#" ,1 , 0, "C");
		
		$x+=50;
		
		$this->pdf::Cell(81, $this->lineheight,"Nombres y Apellidos" ,1 , 0, "C");
		
		
		$this->pdf::SetFont('Arial','',8);
		
		$x+= 41;
		
		$this->pdf::SetFont('Arial','',10);
		
		$this->pdf::setXY($x,$y+15);
		$this->Rotate(90);
		
		$this->pdf::Cell( 15, 5,"Nota a" ,0 , 0, "L",1);
		$this->Rotate(0);
		
		$this->pdf::setXY($x+5,$y+15);
		$this->Rotate(90);
		$this->pdf::SetFont('Arial','',10);
		$this->pdf::Cell( 15, 5,"sacar" ,0 , 0, "L",1);
		$this->Rotate(0);
		$this->pdf::Rect($x, $y, 10, 15,'C');
		
		///FALLAS
		
		$x+=5;
		for($i = 1; $i<=4;$i++){
			$x+=6;
			
			$this->pdf::setXY($x,$y+15);
			$this->Rotate(90);
			$this->pdf::Cell( 15, 6,"Fallas ".$i ,1 , 0, "L",0);
			$this->Rotate(0);
			//$this->pdf::Rect($x, $y-15, 5, 15,'C');
		}
		
		//TOTAL FALLAS
		$x+=6;
		$this->pdf::setXY($x,$y+15);
		$this->Rotate(90);
		$this->pdf::SetFont('Arial','B',10);
		$this->pdf::Cell( 15, 6,"TF" ,1 , 0, "C",1);
		$this->Rotate(0);
		
		$this->pdf::SetFont('Arial','',9);
		
		
		$x-=3;
		///NOTAS
		for($i = 1; $i<=4;$i++){
			$x+=10;
			
			$this->pdf::setXY($x,$y+15);
			$this->Rotate(90);
			$this->pdf::Cell( 15, 10,"Notas ".$i."P" ,1 , 0, "L",0);
			$this->Rotate(0);
		}
		
		//COMPONENTES
		$componentes = ['Cognitivo','Procedim', 'Actitudinal'];
		///NOTAS
		$x+=1;
		$this->pdf::SetFont('Arial','',8);
		foreach ($componentes as $componente){
			$x+=10;
			
			$this->pdf::setXY($x,$y+15);
			$this->Rotate(90);
			$this->pdf::Cell( 15, 10,$componente ,1 , 0, "L",1);
			$this->Rotate(0);

		}
		
		//EVALUACIONES FINALES
		$componentes = ['Preparator',
						'Final Asig', 
						//'Exam 4 pe',  ///EXAMEN 4 periodo
						'Exam final'];
		///NOTAS
		$x+=2;
		foreach ($componentes as $componente){
			$x+=10;
			
			$this->pdf::setXY($x,$y+15);
			$this->Rotate(90);
			$this->pdf::Cell( 15, 10,$componente ,1 , 0, "L");
			$this->Rotate(0);
		}
		
		$x+=12;
		$this->pdf::SetFont('Arial','B',10);
		$this->pdf::setXY($x,$y+15);
		$this->Rotate(90);
		$this->pdf::Cell( 15, 10,"NF" ,1 , 0, "C",1);
		$this->Rotate(0);
		
		
	}
	
}
