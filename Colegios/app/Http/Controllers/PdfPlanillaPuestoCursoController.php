<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;

class PdfPlanillaPuestoCursoController extends PdfTemplatePortrailLetterController
{
	//GENERA UN PDF DE UNA PLANILLA VACIO PARA UNA MATERIA 
	
    public function getPlanillaPuestoCurso($datos){
    	
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
		
		$this->pdf::Cell(10, $h,$row->codigolista ,1 , 0, "L"); //Codigo lista
		$this->pdf::Cell(81, $h,Helpers::utf($row->nombres." ".$row->apellidos),1 , 0, "L"); //nombre
		$this->pdf::Cell(25, $h,(isset($row['promedio'])?number_format($row['promedio'],2):'') ,1 , 0, "C",1); //promedio
		$this->pdf::Cell(25, $h,(isset($row['puestocurso'])?$row['puestocurso']:'') ,1 , 0, "C",1); //puesto en el curso
		$this->pdf::Cell(25, $h,(isset($row['puestocolegio'])?$row['puestocolegio']:'') ,1 , 0, "C",1); //puesto en el curso
		
		
		
		
	}
	
	public function cabeceraPlanilla($datos){
		
		$this->pdf::setX(10);
		$this->pdf::Rect($this->pdf::getX(),$this->pdf::getY(),$this->pdf::GetPageWidth()-20,10,'F');
		
		$this->pdf::SetFont('Arial','B',10);
		$text = "Reporte de Notas y Puesto / ".Helpers::getParametros()['periodo']. " / ".Helpers::getParametros()['anio'];
		$this->pdf::Cell(100, 10,Helpers::utf($text), 0, 0, "L");
		
		$this->pdf::setX(105);
		$this->pdf::SetFont('Arial','B',10);
		$this->pdf::Cell(40,10,Helpers::utf("Grado: ". $datos['nombrecurso']), 0, 0, "l");
		$this->pdf::Cell(40,10,Helpers::utf("Promedio del Curso: ". $datos['promediocurso']), 0, 0, "l");
	}
	
	public function cabeceraTabla(){
		$x = 10;
		$y= 47;
		$this->lineheight = 8;
		$this->pdf::setXY($x,$y);
		
		$this->pdf::SetFont('Arial','',10);
		
		$this->pdf::Cell(10, $this->lineheight,"#" ,1 , 0, "C");
		
		$x+=50;
		
		$this->pdf::Cell(81, $this->lineheight,"Nombres y Apellidos" ,1 , 0, "C");
		
		$this->pdf::Cell(25	, $this->lineheight,"Promedio" ,1 , 0, "C");
		$this->pdf::Cell(25	, $this->lineheight,"Puesto Curso" ,1 , 0, "C");
		$this->pdf::Cell(25	, $this->lineheight,"Puesto Colegio" ,1 , 0, "C");
		
		$this->pdf::SetFont('Arial','',8);
		
		$x+= 41;
		
		$this->pdf::SetFont('Arial','',10);
		
		
		
	}
	
}
