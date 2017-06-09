<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fpdf;
use \App\Helpers;

class PdfTemplateLanscapeLetterController extends Controller
{
	public $pdf;
	public $linewidth = 279;
	public $lineheight;
	public $angle = 0; 
	
	function __construct(){
		$this->pdf = new Fpdf();
		$this->pdf::AliasNbPages();
		$this->pdf::SetTopMargin(30);
		$this->pdf::SetFillColor(230);
		$this->pdf::SetAutoPageBreak(true,10);
		
		$this->pdf::AddPage('L','letter');
		
		
		$this->Header();
		
		$this->Footer();
		$this->pdf::SetXY(0, 30);
		
		//parent::__construct();
	}

	public function __destruct() {
		$this->pdf::Output();
		exit;
	}
	
	public function Header($linewidth = 279,$lineheight=10){
		$x = 25;
		
		$this->pdf::Image('images/logo.png',10,8,10);
		$this->pdf::Image('images/logo.jpg',252,10,15);
		
		$this->pdf::SetXY($x, 10);
		$this->pdf::SetFont('Arial','B',12);
		$this->pdf::Cell(120, $lineheight, Helpers::utf("DIOCESIS DE GIRARDOT"), 0, 0, "l");
		
		$this->pdf::SetXY($x, 15);
		$this->pdf::SetFont('Arial','',9);
		$this->pdf::Cell(120, $lineheight,Helpers::utf("FAMILIA DIOCESANA \"HACIA UNA COMUNIDAD DE COMUNIDADES\""), 0, 0, "l");
		
		
		
		$this->pdf::SetXY($x+105, 10);
		$this->pdf::SetFont('Arial','B',11);
		$this->pdf::Cell(140, $lineheight,Helpers::utf("COLEGIO PARROQUIAL INTEGRADO SANTA CRUZ"), 0, 0, "C");
		
		
		$this->pdf::SetXY($x + 105, 15);
		$this->pdf::SetFont('Arial','B',10);
		$this->pdf::Cell(140, $lineheight,Helpers::utf("2017 \"FAMILIA: SÉ FRATERNA, VIVE EN COMUNIÓN\""), 0, 0, "C");
		
		
		$this->pdf::SetXY($x + 105,20);
		$this->pdf::SetFont('Arial','',8);
		$this->pdf::Cell(140, $lineheight,Helpers::utf('Nit. 832010437-6 / RESOLUCIÓN DE APROBACIÓN 000640 VI-18/9'), 0, 0, "C");
	
		//$this->pdf::Line(0,28,280,28);
		
		
	}
	
	public function Footer($linewidth =279,$lineheight=10){
		$x=0;
		$this->pdf::setXY($x,190);
		$this->pdf::SetFont('Arial','B',10);
		$this->pdf::Cell($linewidth, $lineheight,Helpers::utf('Educamos evangelizando y evangelizamos educando'), 0, 0, "C");
		
		$this->pdf::setXY($x,195);
		$this->pdf::SetFont('Arial','',8);
		$this->pdf::Cell($linewidth, $lineheight,Helpers::utf('Carrera 3ra A # 4 - 52 Cachipay Cundunamarca / Teléfono: 311 279 6440 / E-mail: colparrosantacruz@yahoo.com'), 0, 0, "C");
		
		$this->pdf::setXY(230,193);
		$this->pdf::SetFont('Arial','B',8);
		$this->pdf::Cell(30, 7,\App\Helpers::utf("Página ".$this->pdf::PageNo()." de {nb}"), 0, 0, "C");
	}
	
	
	function Rotate($angle,$x=-1,$y=-1) {
		
		if($x==-1)
			$x=$this->pdf::getX();
			if($y==-1)
				$y=$this->pdf::getY();
				if($this->angle!=0)
					$this->pdf::_out('Q');
					$this->angle=$angle;
					if($angle!=0)
					
					{
						$angle*=M_PI/180;
						$c=cos($angle);
						$s=sin($angle);
						$cx=$x*$this->pdf::getK();
						$cy=($this->pdf::GetPageHeight()-$y)*$this->pdf::getK();
						
						$this->pdf::_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
					}
	}
	
	
}
