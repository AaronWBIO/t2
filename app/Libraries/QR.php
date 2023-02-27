<?php
namespace App\Libraries;
include_once APPPATH.'/ThirdParty/j/j.func.php';

use App\Libraries\Endroid\QrCode\Color\Color;
use App\Libraries\Endroid\QrCode\Encoding\Encoding;
use App\Libraries\Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use App\Libraries\Endroid\QrCode\QrCode;
use App\Libraries\Endroid\QrCode\Label\Label;
use App\Libraries\Endroid\QrCode\Logo\Logo;
use App\Libraries\Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use App\Libraries\Endroid\QrCode\Writer\PngWriter;


class QR {


	public function generate($data,$file){
		$writer = new PngWriter();

		// Create QR code
		$qrCode = QrCode::create($data)
		    ->setEncoding(new Encoding('UTF-8'))
		    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
		    ->setSize(500)
		    ->setMargin(10)
		    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
		    ->setForegroundColor(new Color(0, 0, 0))
		    ->setBackgroundColor(new Color(255, 255, 255));

		// echo ROOTPATH;
		// Create generic logo
		$logo = Logo::create(ROOTPATH .'public/assets/images/centroQR.png')
		    ->setResizeToWidth(80);

		// Create generic label
		$label = Label::create('Verifica el informe aquí')
		    ->setTextColor(new Color(255, 0, 0));

		$result = $writer->write($qrCode,$logo,$label);
		// header('Content-Type: '.$result->getMimeType());
		// echo $result->getString();

		// Save it to a file
		$result->saveToFile(WRITEPATH.'/cache/'.$file);

		// // Generate a data URI to include image data inline (i.e. inside an <img> tag)
		// $dataUri = $result->getDataUri();
		// echo $dataUri;

		return $result;


	}

}