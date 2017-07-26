<?php

namespace App\PDF;
use DB;
require('fpdf.php');

class QuotationPDFNoPrezzi extends FPDF
{
	private $quotation;
	private $ente;
	function __construct($preventivo, $ente, $ente_DA, $orientation='P', $unit='mm', $size='A4') {
		parent::__construct($orientation,$unit,$size);
		
		$this->quotation = $preventivo;
		$this->ente = $ente;
		$this->ente_DA = $ente_DA;
		$this->responsabile = DB::table('users')
									->where('name', $this->ente->responsabilelanga)
									->first();
		$corpopreventivo = DB::table('optional_preventivi')
                    ->where('id_preventivo', $this->quotation->id)
					->orderBy('ordine', 'asc')
                    ->get();
		foreach($corpopreventivo as $cp) {
			$cp->prezzounitario = 0;
			$cp->totale = 0;
		}
		
		$this->corpofattura = json_decode(json_encode($corpopreventivo), true);
		$dipartimento = DB::table('departments')
					->where('id', $this->quotation->dipartimento)
					->first();
		$this->quotation->subtotale = 0;
		$this->quotation->totale = 0;
		$this->quotation->totaledapagare = 0;
		$this->quotation->scontoagente = 0;
		$this->quotation->scontobonus = 0;
		$this->index = array(
			'qta',
			'oggetto',
			'descrizione',
			'prezzounitario',
			'totale',
		);
		$this->SetTitle(':' . $this->quotation->id . '/' . $this->quotation->anno . '_' . $this->quotation->oggetto . '_' . $this->ente->nomeazienda . '_' . $dipartimento->nomedipartimento);
		$this->init();
		$this->AliasNbPages();
	    $this->AddPage();
		$this->writePdf();
		$this->Output($this->quotation->id . '-' . $this->quotation->anno . '_' . $this->quotation->oggetto . '_' . $this->ente->nomeazienda . '_' . $dipartimento->nomedipartimento . '.pdf', 'I');
	}
	const HEADER_HEIGTH = 20;
	const HEADER_MARGIN = 2;
	const GREY_STRIPE_HEIGHT = 10;

	const SUBHEADER_MARGIN = 15;

	const CONTENT_MARGIN = 17;
	
	const CONSIDERAZIONI_WIDTH = 106;
	
	const LOGO = 'storage/app/pdf/LOGO PREVENTIVO_LANGA.png';
	const HEADER_ICON = 'storage/app/pdf/BANDA HEADER_LANGA.png';
	const CAMION = 'storage/app/pdf/CAMION_LANGA.png';
	const FOOTER_ICON = 'storage/app/pdf/BANDA FOOTER_LANGA.png';
	
	const ORANGE_COLOR_R = 243;
	const ORANGE_COLOR_G = 127;
	const ORANGE_COLOR_B = 13;

	const STRONG_ORANGE_COLOR_R = 188;
	const STRONG_ORANGE_COLOR_G = 93;
	const STRONG_ORANGE_COLOR_B = 0;

	const GREY_COLOR_R = 56;
	const GREY_COLOR_G = 60;
	const GREY_COLOR_B = 61;
	
	const GREEN_COLOR_R = 90;
	const GREEN_COLOR_G = 184;
	const GREEN_COLOR_B = 91;

	const FONT_NAME = "Nexa";
	const FONT_SIZE = 10;
	
	const DATE_LEFT_MARGIN = 99;
	
	const BORDER4DEV = 0;
	
	private $itemsHeaders;
	private $itemsWidths;
	private $itemsDrawed = false;
	
	private $datiAziendaYStart = 0;
	private $datiAziendaYEnd = 0;
	
	private $considerazioniYStart = 0;
	
	private $tempoDiLavorazioneYEnd = 0;

	public function setObject($quotation){
		$this->quotation = $quotation;
	}

	public function init(){
		$this->AddFont('Nexa','','NexaLight.php');
		$this->AddFont('Nexa','B','NexaBold.php');
		
		$this->SetMargins(self::HEADER_MARGIN, self::HEADER_MARGIN);
		$this->SetFont(self::FONT_NAME,'',self::FONT_SIZE);
		
		$this->SetAutoPageBreak(true,10);
		
		$thMini = 12;
		$thSmall = 18;
		$thMedium = 35;
		$this->itemsHeaders = array('Q.ta\'', 'OGGETTO', 'DESCRIZIONE', 'PREZZO UNITARIO', 'TOTALE');
		$this->itemsWidths = array(
				$thMini, 
				$thMedium, 
				$this->GetPageWidth()-2*self::CONTENT_MARGIN-$thMini-$thSmall-2*$thMedium, 
				$thMedium,
				$thSmall);
	}

	public function writePdf(){
		// DA
		$owner = DB::table('departments')
					->where('id', $this->quotation->dipartimento)
					->first();
		// A
		$target = $this->ente;
		$this->writeMasterDataView("DA", $owner, 0, 0);
		$this->writeMasterDataView("A", $target, 1, 1);
		$this->Cell(0,3,"",self::BORDER4DEV,1);
		
		//ITEMS
		$this->writeQuotationItemsView(DB::table('optional_preventivi')
											->where('id_preventivo', $this->quotation->id)
											->get());

		//Considerazioni preventivo
		$this->writeConsiderazioniPreventivo($this->quotation, $this->quotation->considerazioni, $this->quotation->noteimportanti);
		
		//Modalità di pagamento
		$this->writeModalitaPagamento($this->quotation->metodo);
		
		//Maggiori informazioni
		$this->writeMaggioriInfo($this->responsabile);
		
		//Valenza preventivo
		$this->writeValenzaPreventivo($this->quotation->valenza);
		
		//Tempo di lavorazione
		$this->writeTempoDiLavorazione($this->quotation->finelavori);
		
		//TOTALI
		$this->writeTotali($this->quotation);
	}
	
	
	
	private function writeTotali($quotation) {
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE);
		$leftMargin = 0.05*($this->GetPageWidth()-self::CONSIDERAZIONI_WIDTH);
		$y = $this->tempoDiLavorazioneYEnd+2;
		$x = self::CONTENT_MARGIN + self::CONSIDERAZIONI_WIDTH + $leftMargin;
		$this->SetXY($x,$y);
		
		$tableWidth = $this->GetPageWidth() - self::CONSIDERAZIONI_WIDTH - $leftMargin - 2*self::CONTENT_MARGIN;
		$this->fontColor('white');
		$this->fillColor('orange');
		$this->drawColor('strong-orange');
		$this->Cell($tableWidth, 10, "TOTALE DOVUTO ", self::BORDER4DEV, 1, "R", true);
		$this->SetFont(self::FONT_NAME,'', self::FONT_SIZE);
		//subtotal
		$subTotal = $quotation->subtotale;
		$subTotal = chr(128)." ".number_format($subTotal, 2)." ";
		//discount perc
		$ownerDiscountPercs = $this->quotation->scontoagente;
		$ownerDiscountPercsString = "";
		//discount value
		$ownerDiscount = $quotation->scontoagente;
		$ownerDiscountNumber = $ownerDiscount;
		$ownerDiscount =  chr(128)." ".number_format($ownerDiscount, 2)." ";
		//total
		$total = $quotation->totale;
		$total = chr(128)." ".number_format($total,2)." ";
		//
		$daPagare = $quotation->totaledapagare;
		$daPagare = chr(128)." ".number_format($daPagare,2)." + IVA ";
		$valoresconto1 = $quotation->subtotale * $quotation->scontoagente / 100;
		$valoresconto2 = ($quotation->subtotale - $valoresconto1) * $quotation->scontobonus / 100;
		$sconto = $quotation->scontoagente . '% + ' . $quotation->scontobonus . '% ( ' . chr(128) . ' ' . $valoresconto1 . ' + ' . chr(128) . ' ' . $valoresconto2 . ' )'." ";
		$data = array(
			array("label"=>"TOTALE", "value"=>$subTotal),
			array("label"=>"SCONTO", "value"=>$sconto),
			array("label"=>"TOTALE SCONTATO", "value"=>chr(128) . ' ' . number_format($quotation->subtotale-$valoresconto1-$valoresconto2,2)." "),
			array("label"=>"TOTALE DA PAGARE", "value"=>$daPagare)
		);
		$texts = array("label", "value");
		$widths = array($tableWidth*1/3, $tableWidth*2/3);
		$aligns = array("R","R");
		$this->fontColor("black");
		$this->fillColor('soft-grey');
		$this->drawColor('black');
		$this->SetLineWidth("");
		$i = 0;
		foreach($data as $row){
			$this->SetX($x);
			$this->Row($row, $texts, $widths, $aligns, $i, 1);
			$i++;
		}
	}
	
	private function writeTempoDiLavorazione($workingTime){
		$this->SetFont(self::FONT_NAME,'', self::FONT_SIZE);

		$leftMargin = 0.05*($this->GetPageWidth()-self::CONSIDERAZIONI_WIDTH);
		$y = $this->considerazioniYStart;
		$x = self::CONTENT_MARGIN + self::CONSIDERAZIONI_WIDTH + $leftMargin;
		$this->SetXY($x,$y);
		
		//per i rettangoli
		$this->SetLineWidth(0.5);
		
		$squareWidth = 21;
		$squareHeight = $squareWidth-0.1*$squareWidth;
		$squareLRPadding = 1;
		$labelsLength = $squareWidth-2*$squareLRPadding;
		$labelsHeight = 3;
		$this->tempoDiLavorazioneYEnd = $this->GetY()+$squareHeight;
		
		//Quadrato 1
		$q1XSet = $x+$squareLRPadding;
		$q1FirstLabelY = $this->GetY()+($squareHeight-3*$labelsHeight)/2;
		$this->SetXY($this->GetX()+$squareLRPadding,$q1FirstLabelY);
		$this->SetFontSize(self::FONT_SIZE-2.8);
		$this->fontColor('grey');
		$this->Cell($labelsLength, $labelsHeight, "TERMINE", self::BORDER4DEV, 1, "C");
		$this->SetX($q1XSet);
		$q1SecondLabelY = $this->GetY();
		$this->Cell($labelsLength, $labelsHeight, "PRESUNTO", self::BORDER4DEV, 1, "C");
		$this->SetX($q1XSet);
		$this->Cell($labelsLength, $labelsHeight, "DEI LAVORI", self::BORDER4DEV, 1, "C");
		//	il rettangolo
		$this->drawColor('grey');
		$this->Rect($x, $y, $squareWidth, $squareHeight ,"D");
		
		//Camion
		$camionSize = 0.55*$squareWidth;
		$camionLeftMargin = 0.05*$squareWidth;
		$camionX = $x+$squareWidth+$camionLeftMargin;
		$this->Image(self::CAMION,$camionX,$q1FirstLabelY,$camionSize);
		
		//Quadrato 2
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE);
		$this->fontColor('black');
		$q2FirstLabelY = $q1SecondLabelY;
		$this->SetXY($camionX + $camionLeftMargin + $camionSize + $squareLRPadding, $q2FirstLabelY);
		$this->SetFont(self::FONT_NAME,'B', 8);
		$this->MultiCell($labelsLength, $labelsHeight, $workingTime, self::BORDER4DEV, "C");
		$this->SetFont(self::FONT_NAME,'', self::FONT_SIZE);
		
		//	il rettangolo
		$this->drawColor('green');
		$this->Rect($camionX + $camionLeftMargin + $camionSize, $y, $squareWidth, $squareHeight ,"D");
		//la spunta arancio (check)
		$freacciaVerdeUrl = "storage/app/pdf/CHECK_LANGA.png";
		$freacciaVerdeWidth = 4;
		$this->Image($freacciaVerdeUrl, $camionX + $camionLeftMargin + $camionSize + $squareWidth - ($freacciaVerdeWidth/2), $y - ($freacciaVerdeWidth/2), $freacciaVerdeWidth);
	}
	
	private function writeValenzaPreventivo($validity){
		//var_dump($validity);
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE);
		$this->fontColor('black');
		$this->Cell(self::CONSIDERAZIONI_WIDTH, 8, "VALENZA PREVENTIVO > ".$validity, self::BORDER4DEV, 1, "C");
		for($i = 0; $i < $this->quotation->lineebianche; $i++)
			$this->Cell(0, 8, "______________________________________________________________________________________________________", self::BORDER4DEV, 1, "C");
	}
	
	private function writeMaggioriInfo($masterData){
		$this->fontColor('black');
		$this->Cell(self::CONSIDERAZIONI_WIDTH, 5, "Per maggiori informazioni tecniche o di dettaglio fiscale:", self::BORDER4DEV, 1, "C");
		$this->Cell((self::CONSIDERAZIONI_WIDTH*7/15)-2, 5, "RESPONSABILE LANGA: ", self::BORDER4DEV, 0, "JF" );
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE);
		$tel = $masterData->cellulare;
		$this->Cell((self::CONSIDERAZIONI_WIDTH*8/15)+2, 5, $masterData->name."   |   ".$tel, self::BORDER4DEV, 1, "L");
	}
	
	private function writeModalitaPagamento($paymentMethod){
		$this->SetFont(self::FONT_NAME,'', self::FONT_SIZE);
		$this->fontColor('orange');
		$this->MultiCell(self::CONSIDERAZIONI_WIDTH, 10, "MODALITA' DI PAGAMENTO: ".$paymentMethod, self::BORDER4DEV, "C");
	}
	
	private function writeConsiderazioniPreventivo($target, $notes, $importantNotes){
		$this->Ln();
		//$this->Rect($this->GetX(),$this->GetY(), 20, 60, "DF");
		$minHeigth = 60;
		$height = 0.0;
		
		$targetNameText = "CONSIDERAZIONI : ". $this->quotation->id . '/' .$this->quotation->anno . ' | ' . $this->ente->nomeazienda;
		$height+=$this->NbLines(self::CONSIDERAZIONI_WIDTH, $targetNameText)*10;
		$height+=$this->NbLines(self::CONSIDERAZIONI_WIDTH, $notes)*10;
		$height+=$this->NbLines(self::CONSIDERAZIONI_WIDTH, $importantNotes)*10;
		
		//var_dump($height);
		if($height<$minHeigth)
			$height = $minHeigth;
		
		
		if($this->h-$this->GetY()<$height)
 			$this->AddPage();
		$this->considerazioniYStart = $this->GetY();
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE);
		$this->MultiCell(self::CONSIDERAZIONI_WIDTH, 4.5, $targetNameText, self::BORDER4DEV, "L");
		$this->SetFont(self::FONT_NAME,'', self::FONT_SIZE-3);
		//var_dump($this->GetY());
		$this->MultiCell(self::CONSIDERAZIONI_WIDTH,4.5,$notes,self::BORDER4DEV, "L");
// 		var_dump($this->GetY());
// 		var_dump($this -> h);
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE);
		$this->SetFont(self::FONT_NAME,'B', self::FONT_SIZE-3);
		$this->MultiCell(self::CONSIDERAZIONI_WIDTH,4.5,$importantNotes,self::BORDER4DEV, "L");
		
	}
	
	private function writeNumeroPreventivo($code){
		$this->SetY($this->datiAziendaYStart);
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN-5);
		$numeroPreventivoLabelFontSize = 17;
		$this->Cell(42+6,2,"", self::BORDER4DEV);
		$numeroPreventivoFontSize = 28;
		$this->SetFontSize($numeroPreventivoFontSize);
		$this->fontColor('orange');
		$this->Cell(0,12,$code, self::BORDER4DEV, 1);
		$imageY = $this->GetY();
		$this->Image(
				"storage/app/pdf/FUMETTO_LANGA.png", 
				self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN, 
				$imageY,
				$this->w-2*self::SUBHEADER_MARGIN-self::DATE_LEFT_MARGIN-1
		);
		$this->SetY($this->GetY());
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN);
		$this->SetFont(self::FONT_NAME,'', 8);
		$this->fontColor('black');
		
		
		$cell1width = 79.7;
		$cell1height = 5.30;
		$yInit = $this->GetY();
		
		// Agente / Rivenditore: Simone Manenti
		// Contatti: Numero Manenti / Email Manenti
		
		
		
		// per centrare verticalemente
		$this->Cell($cell1width,$cell1height/2,"", self::BORDER4DEV, 1, "C");
		$this->SetFont(self::FONT_NAME,'', self::FONT_SIZE-2);
		$informazioni_ente = "Agente / Rivenditore: " . $this->ente_DA->nomereferente;
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN+3);
		$this->Cell($cell1width,$cell1height,$informazioni_ente, self::BORDER4DEV, 1, "L");
		
		$informazioni_ente = "Contatti: " . $this->ente_DA->cellulareazienda . ' / ' . $this->ente_DA->email;
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN+3);
		$this->Cell($cell1width,$cell1height,$informazioni_ente, self::BORDER4DEV, 1, "L");
		
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN);		
		$this->SetFont(self::FONT_NAME,'',$numeroPreventivoLabelFontSize);
		
		//$this->SetFontSize($numeroPreventivoLabelFontSize);
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN);
		$this->SetY($this->datiAziendaYStart+2);
		$this->SetX(self::SUBHEADER_MARGIN+self::DATE_LEFT_MARGIN);
		$this->Cell(42,10,"PREVENTIVO", self::BORDER4DEV);
		//$this->SetFont(self::FONT_NAME,'B',$numeroPreventivoLabelFontSize);
		//$this->Cell(6,10,":", self::BORDER4DEV);
					
		$this->SetY(68.5);
		$this->Cell(0,10);//subito dopo c'è 1 in più...
	}
	
	public function stampaTesto($x, $y, $testo, $larghezza, $allineamento, $spessore, $family, $type, $size)
	{
		$this->SetFont($family, $type, $size);
		$array = explode("\n", $testo);
		
		for($i = 0; $i < count($array); $i++) {
			$this->SetXY($x, $y + $i * $spessore);
			$this->Cell($larghezza, 0, $array[$i], 0, 1, $allineamento);
		}
	}
	
	private function writeDatiAzienda($user){
		$contact = "contatto";
		$this->SetFont(self::FONT_NAME,'B',self::FONT_SIZE);
		// nome ente
		$userDescription = $this->ente_DA->nomereferente;
		$userDescriptionWidth = $this->GetStringWidth($userDescription);
		$this->Cell($userDescriptionWidth,-7.5,$userDescription, self::BORDER4DEV);
		$datiAziendaFontSize = 7;
		$this->SetFont(self::FONT_NAME,'',self::FONT_SIZE);
		$this->Cell(self::DATE_LEFT_MARGIN,-7.5," di " . $this->ente_DA->nomeazienda, self::BORDER4DEV, 1);
		$this->SetFont(self::FONT_NAME,'',$datiAziendaFontSize);
		// sede legale ente
		$this->stampaTesto(15, 45, $this->ente_DA->sedelegale, 50, 'L', 3.8, 'Nexa', '', 8);
	}
	
	private function writeDate($date){
		$this->SetFontSize(self::FONT_SIZE);
		$this->Cell(self::DATE_LEFT_MARGIN, 6, "", self::BORDER4DEV);
		$this->Cell(0,6,$date, self::BORDER4DEV, 1);
		
	}

	private function writeMasterDataView($label, $object, $ln, $leftMargin){
		$this->SetFont(self::FONT_NAME,'',self::FONT_SIZE);

		$initialY = $this->GetY();
		$initialX = $this->GetX()+$leftMargin;

		//$this->SetX($leftMargin);

		$this->fontColor('white');
		$this->fillColor('grey');

		$this->SetX($initialX);

		//TITLE
		$titleWidth = ($this->GetPageWidth()/2)-self::CONTENT_MARGIN-$leftMargin/2;
		$this->SetFont('Nexa', 'B', 14);
		$this->Cell($titleWidth,self::GREY_STRIPE_HEIGHT," ".$label,self::BORDER4DEV,1,"L",true);
		$this->SetFont('Nexa', '', 14);
		$titleFinalY = $this->GetY();
		$this->setX($initialX);

		$contentMarginTop = 3;
		//LOGO
		$logoMarginTop = $contentMarginTop;
		$logoMarginLeft = 5;
		$logoUrl = "no logo";
		//var_dump(getcwd());
			$logoUrl = "http://easy.langa.tv/storage/app/images/".$object->logo;

		$logoMaxWidth = 17;
		$logoMaxHeight = 17;
		
			
			
			//  Get image dimensions
			$size = getimagesize($logoUrl);
			if( $size===false )
				die('Image does not exist.');
			
			$wImg = $size[0];
			$hImg = $size[1];
			
			//  Convert pixel units to user units
			$wImg  /= $this->k;
			$hImg /= $this->k;
		
			$DwImgLogoMaxWidth = $logoMaxWidth - $wImg; //se negativo esce fuori
			$DhImgLogoMaxHeight = $logoMaxHeight - $hImg; //se negativo esce fuori
			
			$logoWidth = 0;
			$logoHeight = 0;
			//esce solo in larghezza
			if($DwImgLogoMaxWidth<0 && $DhImgLogoMaxHeight>0){
				$logoWidth = $logoMaxWidth;
				$logoHeight = $hImg*$logoMaxWidth/$wImg;
			}
			//esce solo in altezza
			else if($DhImgLogoMaxHeight<0 && $DwImgLogoMaxWidth>0){
				$logoWidth = $wImg*$logoMaxHeight/$hImg;
				$logoHeight = $logoMaxHeight;
			}
			//esce in larghezza e altezza
			else if($DhImgLogoMaxHeight<0 && $DwImgLogoMaxWidth<0){
				
				if($DhImgLogoMaxHeight<$DwImgLogoMaxWidth){
					$logoWidth = $wImg*$logoMaxHeight/$hImg;
					$logoHeight = $logoMaxHeight;
				}
				else{
					//echo $logoMaxWidth/$wImg."<br/>";
					$logoWidth = $logoMaxWidth;
					$logoHeight = $hImg*$logoMaxWidth/$wImg;
				}
			}
		
			$centerVerticallyOffset = (27-$logoHeight)/2; 
			$centerHorizontallyOffset = ($logoMaxWidth-$logoWidth)/2;
			
			$imageX = $this->GetX()+$logoMarginLeft+$centerHorizontallyOffset;
			$imageY = $titleFinalY+$contentMarginTop+$centerVerticallyOffset;
			$this->Image($logoUrl, $imageX, $imageY, $logoWidth, $logoHeight);
			//$this->Rect($this->GetX()+$logoMarginLeft, $this->GetY()+$logoMarginTop, $logoWidth, $logoWidth, "F");
			//$this->drawColor("soft-grey");
			$this->SetDrawColor(200);
			$this->DashedRect(
					$this->GetX()+$logoMarginLeft,
					$titleFinalY+$contentMarginTop+(27-$logoMaxHeight)/2,
					$this->GetX()+$logoMarginLeft+$logoMaxWidth, 
					$titleFinalY+$contentMarginTop+(27-$logoMaxHeight)/2+$logoMaxHeight,
					0.2,
					10
			);
		
		//else
		//	$this->Rect($this->GetX()+$logoMarginLeft, $this->GetY()+$logoMarginTop, $logoWidth, $logoWidth, "F");

		//CONTENT
		$this->SetY($titleFinalY+$contentMarginTop);
		$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
		$this->SetFontSize(self::FONT_SIZE-3);
		$this->fontColor('grey');
		$this->fillColor('soft-grey');
		$contentRowsWidth = $titleWidth-2*$logoMarginLeft-$logoMaxWidth;
		$contentRowsWHeight=5;
		if($ln == 0) {
			//- nome referente
			$this->Cell($contentRowsWidth,$contentRowsWHeight,'Responsabile Easy LANGA: ' .$object->nomereferente,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			//- nome dipartimento
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$object->nomedipartimento,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			// indirizzo
			$address = (string)$object->indirizzo;
			$string = (strlen($address) > 47) ? substr($address,0,47).'...' : $address;
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$string,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			//- telefono dipartimento
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$object->telefonodipartimento . ' / ' . $object->cellularedipartimento,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			//- email
			$telText = $object->email . ' / ' . $object->emailsecondaria;
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$telText,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
		} else {
			//- nome referente
			$this->Cell($contentRowsWidth,$contentRowsWHeight,'Referente: ' .$object->nomereferente,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			//- nome dipartimento
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$object->nomeazienda,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			// indirizzo
			$address = (string)$object->indirizzo;
			$string = (strlen($address) > 47) ? substr($address,0,47).'...' : $address;
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$string,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			//- telefono dipartimento
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$object->telefonoazienda . ' / ' . $object->cellulareazienda,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
			//- email
			$telText = $object->email;
			$this->Cell($contentRowsWidth,$contentRowsWHeight,$telText,self::BORDER4DEV, 1, "L", true);
			$this->Cell($contentRowsWidth,0.1*$contentRowsWHeight,"",self::BORDER4DEV, 1);
			$this->setX($initialX+$logoMaxWidth+2*$logoMarginLeft);
		}
		
		if($ln==0){
			$this->SetY($initialY);
			$this->SetX($initialX+$titleWidth);
		}else{
			$this->Ln();
			$this->SetX($initialX);
		}

	}

	//Computes the number of lines a MultiCell of width w will take
	function NbLines($w,$txt)
	{
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
				$sep=-1;
				$i=0;
				$j=0;
				$l=0;
				$nl=1;
				while($i<$nb)
				{
					$c=$s[$i];
					if($c=="\n")
					{
						$i++;
						$sep=-1;
						$j=$i;
						$l=0;
						$nl++;
						continue;
					}
					if($c==' ')
						$sep=$i;
						$l+=$cw[$c];
						if($l>$wmax)
						{
							if($sep==-1)
							{
								if($i==$j)
									$i++;
							}
							else
								$i=$sep+1;
								$sep=-1;
								$j=$i;
								$l=0;
								$nl++;
						}
						else
							$i++;
				}
				return $nl;
	}
	
	private function writeQuotationItemsHeaders(){
		$this->fillColor("grey");
		$this->fontColor('white');
		for($i=0;$i<count($this->itemsHeaders);$i++)
			$this->Cell($this->itemsWidths[$i],self::GREY_STRIPE_HEIGHT,$this->itemsHeaders[$i],self::BORDER4DEV,0,'C',true);
			$this->Ln();
	}

	// Colored table
	private function writeQuotationItemsView($data)
	{
		$this->writeQuotationItemsHeaders();
		
		$this->setFontForQuotationItems();
		
		$initialY = $this->GetY();
		$initialX = $this->GetX();

		// Column headings
		$prezzoTextFunction = function($row){
			$priceText = $row["pricevalue"]!=null ? chr(128)." ".number_format($row["pricevalue"], 2) : "";
			//pricerepeatdays
			if($row["pricevalue"]!=null){
				if($row['pricerepeatdays'])
					$priceText.=" ogni ".$row['pricerepeatdays']." giorni";
				//pricerepeatstart
				if($row['pricerepeatstart'])
					$priceText.=" dal giorno ".$row['pricerepeatstart']."";
				//pricerepeatend
				if($row['pricerepeatend'])
					$priceText.=" al giorno ".$row['pricerepeatend']."";
					
				if($row['pricerepeatstart'] || $row['pricerepeatend'])
					$priceText.=" dalla partenza del accordo";
			}
			return $priceText;
		};
		$totaleTextFunction = function($row){
			if($row["group"])
				return "*";
			$total = QuotationBusinessService::getItemTotal($row);
			if(!is_string($total))
				$total = chr(128)." ".number_format($total, 2);
			return $total;
		};
		$texts = array('quantity', 'title', 'description', $prezzoTextFunction, $totaleTextFunction);

		// Colors, line width and bold font
		$this->SetLineWidth(.1);
		
		// Header
		$a = array('C', 'L', 'L', 'C', 'C');
		$i = 0;
		foreach($data as $id=>$row){
			$this->Row($row, $texts, $this->itemsWidths, $a, $i, 0);
			$i++;
		}
		$this->itemsDrawed = true;
	}
	
	private function setFontForQuotationItems(){
		$this->SetFont(self::FONT_NAME,'',self::FONT_SIZE);
		$this->fontColor('black');
	}

	function Row($data, $texts, $widths, $aligns, $k, $totale)
	{
		$rowMarginTop = 3;
		+$rowMarginLeft = 0;
		$rowFontSize = 8;
		$this->SetFontSize($rowFontSize);

		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($widths);$i++){
			$nb=max($nb,$this->NbLines($widths[$i],($totale == 0) ? $this->corpofattura[$k][$this->index[$i]] : $data[$texts[$i]]));
		}
		$h=5*$nb;
		//Issue a page break first if needed
		$pageBreaked = $this->CheckPageBreak($h);
		if($pageBreaked){
			$this->writeQuotationItemsHeaders();
			$this->setFontForQuotationItems();
			$this->SetFontSize($rowFontSize);
		}
		//Draw the cells of the row
		$margin = 1.5;
		for($i=0;$i<count($widths);$i++)
		{
			$currentPageNumber = $this->PageNo()*1;
			$width=$widths[$i];
			$a=isset($aligns[$i]) ? $aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->fillColor("soft-grey");
			$rectHeight = $h-$margin/2;
			$this->Rect($x+$margin/2,$y+$margin/2,$width-$margin/2,$rectHeight, "F");
			//Print the text centered vertically on the rect
			if($totale == 0) {
				if($this->index[$i] == "totale" && $this->corpofattura[$k]["asterisca"] == 1) {
					$text = '*';
				} else {
					if($this->index[$i] == "totale" || $this->index[$i] == "prezzounitario") {
						$text = number_format($this->corpofattura[$k][$this->index[$i]], 2);
					} else {
						$text = $this->corpofattura[$k][$this->index[$i]];
					}
					if($text == 0 && ($this->index[$i] == "totale" || $this->index[$i] == "prezzounitario"))
						$text = "";
				}
				
			} else {
				$text = $data[$texts[$i]];
			}
			
			$numberOfLines = $this->NbLines($widths[$i],$text);
			$cellHeight = 5*$numberOfLines;
			$this->SetXY($x+$margin/2, $y+$margin/2 + ($rectHeight-$cellHeight)/2);
			$this->MultiCell($width-$rowMarginLeft,5,$text,0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$width+$rowMarginLeft,$y+$rowMarginLeft);
		}
		//Go to the next line
		$this->Ln($h);
	}

	private function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger){
			$this->AddPage($this->CurOrientation);
			return true;
		}
		return false;
	}

	private function fillColor($color){
		if($color=='orange'){
			$this->SetFillColor(self::ORANGE_COLOR_R,self::ORANGE_COLOR_G,self::ORANGE_COLOR_B);
		}
		else if($color=='grey'){
			$this->SetFillColor(self::GREY_COLOR_R,self::GREY_COLOR_G,self::GREY_COLOR_B);
		}
		else if($color=='soft-grey'){
			$this->SetFillColor(246,244,244);
		}
		else if($color == 'white'){
			$this->SetFillColor(255,255,255);
		} else{
			$this->SetFillColor(255);
		}
	}

	private function fontColor($color){
		if($color=='white'){
			$this->SetTextColor(255);//white
		}
		else if($color=='grey'){
			$this->SetTextColor(self::GREY_COLOR_R,self::GREY_COLOR_G,self::GREY_COLOR_B);//white
		}
		else if($color=='orange'){
			$this->SetTextColor(self::ORANGE_COLOR_R,self::ORANGE_COLOR_G,self::ORANGE_COLOR_B);//white
		}
		else{
			$this->SetTextColor(0);//black
		}
	}
	
	private function drawColor($color){
		if($color=='white'){
			$this->SetDrawColor(255);//white
		}
		else if($color=='grey'){
			$this->SetDrawColor(self::GREY_COLOR_R,self::GREY_COLOR_G,self::GREY_COLOR_B);//white
		}
		else if($color=='orange'){
			$this->SetDrawColor(self::ORANGE_COLOR_R,self::ORANGE_COLOR_G,self::ORANGE_COLOR_B);//white
		}
		else if($color=='strong-orange'){
			$this->SetDrawColor(self::STRONG_ORANGE_COLOR_R,self::STRONG_ORANGE_COLOR_G,self::STRONG_ORANGE_COLOR_B);//white
		}
		else if($color=='grey'){
			$this->SetDrawColor(self::GREEN_COLOR_R,self::GREEN_COLOR_G,self::GREEN_COLOR_B);//white
		}
		else{
			$this->SetDrawColor(0);//black
		}
	}
	
	// Page header
	function Header()
	{
		$height =  self::HEADER_HEIGTH;
		$border = 0;
		
		$this->fillColor('orange');
		$this->Cell(0, $height, "", $border, 1, "L",true);
		$this->Image(self::LOGO,13,4.6,30);

		//OGGETTO
		$this->Image(self::HEADER_ICON, $this->getX(), $this->getY(), $this->GetPageWidth()+19);
		$title = $this->quotation->oggetto;
		$this->SetFont(self::FONT_NAME,'',7);
		$this->fontColor('white');
		$this->Cell(192,self::GREY_STRIPE_HEIGHT-20,"Timbro / Firma per accettazione: ______________________________________",$border,0,"R");
		$this->fontColor('white');
		$this->fillColor('grey');
		$this->SetFont(self::FONT_NAME,'B',10);
		$this->SetX(22);
		$this->Cell(75,self::GREY_STRIPE_HEIGHT,"OGGETTO:",$border,0,"R");
		$this->SetFont(self::FONT_NAME,'',10);
		$this->Cell(0,self::GREY_STRIPE_HEIGHT,$title,$border,1,"L");
		
		$this->SetMargins(self::SUBHEADER_MARGIN, 2);
		$this->Cell(0,4,'',0, 1);//Serve questa, non capisco perhè, ma la prima cella dopo il set margins sembra prende solo il margine destro
		
		$this->fontColor('black');
		//DATA
		$this->writeDate('Data: ' . $this->quotation->data);
		
		//Dati azienda
		$this->datiAziendaYStart = $this->GetY();
		//var_dump($_SESSION[USER_SESSION_KEY]);
		//var_dump($this->quotation->user->masterdata);
		$this->writeDatiAzienda($this->ente);
		$this->datiAziendaYEnd = $this->GetY();
		
		//Numero Preventivo
		//Tolgo il # perchè è messo sul pdf
		$this->writeNumeroPreventivo(':' . $this->quotation->id . '/' . $this->quotation->anno);
		
		//Piccola riduzione margini
		$this->SetMargins(self::CONTENT_MARGIN, 0);
		$this->Cell(0,6,'',self::BORDER4DEV, 1);//Serve questa, non apisco perhè, ma la prima cella dopo il set margins sembra prende solo il margine destro
		
		if($this->itemsDrawed==true){
			$this->Ln();
		}
	}

	// Page footer
	function Footer()
	{
		$this->SetMargins(self::HEADER_MARGIN, self::HEADER_MARGIN);
		$this->SetFont(self::FONT_NAME,'',self::FONT_SIZE);
		
		// Position at 1.5 cm from bottom
		$this->SetY(-10);
		$x = $this->GetX();
		$y = $this->GetY();
		//$this->Cell(0,10,"",self::BORDER4DEV,0,"C",true);
		$this->Image(self::FOOTER_ICON, $x, $y, $this->GetPageWidth()-4);
		
		$this->fontColor("white");
		// Page number
		$this->SetY($this->GetY()-0.3);
		$this->SetX(94);
		$this->SetFontSize(4);
		$x = $this->GetX();
		$y = $this->GetY();
		$this->MultiCell(100, 3, "MATERIALE SOTTOPOSTO PROTETTO DA COPYRIGHT LANGA Group. FIRMANDO QUESTO DOCUMENTO SI ACCETTA/AUTORIZZA LANGA WEB INFORMATICA AD INIZIARE I PROCESSI TECNICI / AMMINISTRATIVI / COMMERCIALI APPLICANDO I METODI DI LAVORO LANGA. METODI DI PAGAMENTO STANDARD 30% 30% SALDO (COSTO 10%) o 50% SALDO (COSTO 5%) o ANTICIPATO (SCONTO 10%) INFO SU WWW.LANGA.TV", self::BORDER4DEV, "R");
		$this->SetY($y);
		$this->SetX($x+100);
		$this->SetFontSize(10);
		$this->Cell(0,8, $this->PageNo().'/{nb}',self::BORDER4DEV,0,'R');
		
		
	}
	
	function DashedRect($x1, $y1, $x2, $y2, $width=1, $nb=15)
	{
		$this->SetLineWidth($width);
		$longueur=abs($x1-$x2);
		$hauteur=abs($y1-$y2);
		if($longueur>$hauteur) {
			$Pointilles=($longueur/$nb)/2; // length of dashes
		}
		else {
			$Pointilles=($hauteur/$nb)/2;
		}
		for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
			for($j=$i;$j<=($i+$Pointilles);$j++) {
				if($j<=($x2-1)) {
					$this->Line($j,$y1,$j+1,$y1); // upper dashes
					$this->Line($j,$y2,$j+1,$y2); // lower dashes
				}
			}
		}
		for($i=$y1;$i<=$y2;$i+=$Pointilles+$Pointilles) {
			for($j=$i;$j<=($i+$Pointilles);$j++) {
				if($j<=($y2-1)) {
					$this->Line($x1,$j,$x1,$j+1); // left dashes
					$this->Line($x2,$j,$x2,$j+1); // right dashes
				}
			}
		}
	}
}
