<?
//setlocale(LC_CTYPE, 'Hebrew');
//header('Content-Type: text/html; charset=utf-8');
/**
 * Split PDF file
 *
 * <p>Split all of the pages from a larger PDF files into
 * single-page PDF files.</p>
 *
 * @package FPDF required http://www.fpdf.org/
 * @package FPDI required http://www.setasign.de/products/pdf-php-solutions/fpdi/
 * @param string $filename The filename of the PDF to split
 * @param string $end_directory The end directory for split PDF (original PDF's directory by default)
 * @return void
 */
require_once('fpdf.php');
require_once('fpdi.php');
	
 class concat_pdf extends FPDI 
{
    var $files = array();
	var $datesArLinks = array();
	
    function setFiles($files) 
    {
        $this->files = $files;
    }

    function concat() 
    {
		global $datesAr;
		global $footerText;
		
		if (1||count($datesAr)>0) {
		
			$this->AddPage('P');
			$this->SetAlpha(1);
			//$this->SetAlpha(0.2);
//Add a logo for the PDF files:	
//$this->Image('images/students_logo.jpg',30,80);
			//$this->SetAlpha(1);
			
			$this->AddFont('arial','','arial.php'); 
			$this->SetFont('arial','',25); 
			$this->SetTextColor( 0, 0, 0 );
			
			$y_init=30;
			
			$mid_x = 105; // the middle of the "PDF screen", fixed by now.
			$texts = array_reverse(explode('  |  ',$this->heb($footerText)));
			foreach($texts as $key => $val) {
				$this->Text($mid_x - ($this->GetStringWidth($val) / 2), ($y_init + ($key*9)), $val);
			}
			
			

			 //write Page No 
			 //$this->SetX( 0 ); 
			 
			 //set font color to blue 
			 $x=0;
			 
			 if (count($datesAr) > 0) {
				 foreach ($datesAr as $key => $val) {
					 if ($val > 0) {
						if ($x === 0) {
							$this->AddPage('P');
							$this->SetAlpha(1);
							$this->AddFont('arial','','arial.php'); 
							$this->SetFont('arial','U',25); 
							$this->SetFillColor( 255, 255, 255 ); 
							$text = $this->heb('תוכן עניינים');
							$this->Text($mid_x - ($this->GetStringWidth($text) / 2), $y_init, $text);
						
							$this->SetFont('arial','',13); 
							$this->SetTextColor( 52, 98, 185 );
						}
						$x++;
						$this->SetY( $x*7 + $y_init); 
						$this->datesArLinks[($key+2)] = $this->AddLink();
						$textDate=gmdate("d/m/Y", $val+7*60*60);
						
						$str = $this->heb(($x).'. תאריך: '.$textDate);
						$dots=' ';
						for ($i=1;$i<=130-ceil(($this->GetStringWidth($str))*0.8);$i++) {
							$dots.='.';
						}
						if (($key+2) < 10) {$dots.='..';}
						$strEnd = $this->heb($dots.' עמוד '.($key+2));
						
						$this->Cell( 0, 5, $strEnd.$str, 0, 0, 'R',true ,$this->datesArLinks[($key+2)]); 
					 }
				 }
			}
			 
		 }
		 
        foreach($this->files AS $file) 
        {
            $pagecount = $this->setSourceFile($file);
			
            for($i = 1; $i <= $pagecount; $i++) 
            {
                $this->AddPage('P');
				
                $tplidx = $this->ImportPage($i);
                $this->useTemplate($tplidx);
            }
        }
    }
	


		function Footer() {        //move pionter at the bottom of the page 
		
		global $footerText;
		

         //set font to Arial, Bold, size 10 
		// $this->AddFont('Arial','I','arial.php');
		
		$this->AddFont('arial','','arial.php'); 
		$this->SetFont('arial','',10); 
         //$this->SetFont( 'Arial', 'B', 10 ); 

         
         if (array_key_exists($this->PageNo(),$this->datesArLinks)) {
			$this->SetLink($this->datesArLinks[$this->PageNo()],-1);
		 }

         //set font color to gray 
         
         $this->SetFillColor( 255, 255, 255 ); 

         //write Page No 
		 //$this->SetX( 0 ); 
		 
		 //set font color to blue
		 
		 if (false) { //Don't show Footer Texts
			 $this->SetY( -5 ); 
			 $this->SetTextColor( 52, 98, 185 ); 
			 $this->Cell( 0, 5, $this->heb('הסריקות בחסות "הבנק האקדמי", פרויקט של אגודת הסטודנטים אוניברסיטת תל אביב'), 0, 0, 'R',true,'http://www.taupdf.com' ); 
			 
			 $this->SetDrawColor(235, 235, 235);
			 $this->SetY( -10 ); 
			 $this->Cell( 0, 5, $this->heb($footerText), 'T', 0, 'R',true); 
			 
			 $this->SetY( -8 ); 
			 $this->SetTextColor( 0, 0, 0 ); 
			 $this->AliasNbPages('totalPages');
			 $this->Cell( 0, 5, $this->PageNo().' / totalPages '.$this->heb('עמוד'), 0, 0, 'L'); 
		   } 
		 }
		 
		 function heb($str) {
			//return utf8_encode($str);
			return hebrevc(iconv('UTF-8', 'cp1255', ($str)));
		 }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 var $extgstates;

    function AlphaPDF($orientation='P', $unit='mm', $format='A4')
    {
        parent::FPDF($orientation, $unit, $format);
        $this->extgstates = array();
    }

    // alpha: real value from 0 (transparent) to 1 (opaque)
    // bm:    blend mode, one of the following:
    //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn, 
    //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
    function SetAlpha($alpha, $bm='Normal')
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
        $this->SetExtGState($gs);
    }

    function AddExtGState($parms)
    {
        $n = count($this->extgstates)+1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc()
    {
        if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
            $this->PDFVersion='1.4';
        parent::_enddoc();
    }

    function _putextgstates()
    {
        for ($i = 1; $i <= count($this->extgstates); $i++)
        {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_out('<</Type /ExtGState');
            foreach ($this->extgstates[$i]['parms'] as $k=>$v)
                $this->_out('/'.$k.' '.$v);
            $this->_out('>>');
            $this->_out('endobj');
        }
    }

    function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_out('/ExtGState <<');
        foreach($this->extgstates as $k=>$extgstate)
            $this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
        $this->_out('>>');
    }

    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
}

/* require('makefont.php');

MakeFont('font/arial.ttf','font/Arial.afm','cp1255');
 */
 
function split_pdf($filename, $end_directory = false, $startFrom=1, $uploadId, $stopOnError = true, $jpgsDir)
{
	
	
	$end_directory = $end_directory ? $end_directory : './';
	$new_path = preg_replace('/[\/]+/', '/', $end_directory.'/'.substr($filename, 0, strrpos($filename, '/')));
	
	$pdf = new FPDI();
	$pagecount = $pdf->setSourceFile($filename); // How many pages?
	$pdf->SetCompression(false);
	// Split each page into a new PDF
	$sameSizeCount=0;
	for ($i = 1; $i <= $pagecount; $i++) {
		$new_pdf = new FPDI();
		$new_pdf->AddPage();
		$new_pdf->setSourceFile($filename);
		$new_pdf->useTemplate($new_pdf->importPage($i));
		$new_pdf->SetCompression(false);
		try {
			
			if (!is_dir($end_directory))
			{
				mkdir($end_directory, 0777, true);
			}
			if (!is_dir($jpgsDir))
			{
				mkdir($jpgsDir, 0777, true);
			}
			
			$new_filename = $end_directory.($i+$startFrom-1).".pdf";
			$new_pdf->Output($new_filename, "F");
			
			$comm='convert -flatten '.$new_filename.' -resample 80 '.$jpgsDir.'/'.($i+$startFrom-1).'.jpg';
			exec($comm);
			
			//echo "Page ".($i+$startFrom-1)." split into ".$new_filename." (new is ".filesize($new_filename)." old os ".filesize($filename).")<br />\n";
			
			if ($i > 1 && $stopOnError && filesize($new_filename) == $oldSize) {
				$sameSizeCount++;
				if ($sameSizeCount > 4) {
					deleteAll($uploadId);
					die('0');
					break;
				}
			}
			else {
				$sameSizeCount=0;
			}
			$oldSize=filesize($new_filename);
			
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			die('0');
		}
	}
	
	die('1');
	//$pdf->Close();
}

function disposableEmailCheck($email) {
	$blacklist = array(
	"0815.ru0clickemail.com",
	"0wnd.net",
	"0wnd.org",
	"10minutemail.com",
	"20minutemail.com",
	"2prong.com",
	"3d-painting.com",
	"4warding.com",
	"4warding.net",
	"4warding.org",
	"9ox.net",
	"a-bc.net",
	"amilegit.com",
	"anonbox.net",
	"anonymbox.com",
	"antichef.com",
	"antichef.net",
	"antispam.de",
	"baxomale.ht.cx",
	"beefmilk.com",
	"binkmail.com",
	"bio-muesli.net",
	"bobmail.info",
	"bodhi.lawlita.com",
	"bofthew.com",
	"brefmail.com",
	"bsnow.net",
	"bugmenot.com",
	"bumpymail.com",
	"casualdx.com",
	"chogmail.com",
	"cool.fr.nf",
	"correo.blogos.net",
	"cosmorph.com",
	"courriel.fr.nf",
	"courrieltemporaire.com",
	"curryworld.de",
	"cust.in",
	"dacoolest.com",
	"dandikmail.com",
	"deadaddress.com",
	"despam.it",
	"devnullmail.com",
	"dfgh.net",
	"digitalsanctuary.com",
	"discardmail.com",
	"discardmail.de",
	"disposableaddress.com",
	"disposemail.com",
	"dispostable.com",
	"dm.w3internet.co.uk example.com",
	"dodgeit.com",
	"dodgit.com",
	"dodgit.org",
	"dontreg.com",
	"dontsendmespam.de",
	"dump-email.info",
	"dumpyemail.com",
	"e4ward.com",
	"email60.com",
	"emailias.com",
	"emailinfive.com",
	"emailmiser.com",
	"emailtemporario.com.br",
	"emailwarden.com",
	"ephemail.net",
	"explodemail.com",
	"fakeinbox.com",
	"fakeinformation.com",
	"fastacura.com",
	"filzmail.com",
	"fizmail.com",
	"frapmail.com",
	"garliclife.com",
	"get1mail.com",
	"getonemail.com",
	"getonemail.net",
	"girlsundertheinfluence.com",
	"gishpuppy.com",
	"great-host.in",
	"gsrv.co.uk",
	"guerillamail.biz",
	"guerillamail.com",
	"guerillamail.net",
	"guerillamail.org",
	"guerrillamail.com",
	"guerrillamailblock.com",
	"haltospam.com",
	"hotpop.com",
	"ieatspam.eu",
	"ieatspam.info",
	"ihateyoualot.info",
	"imails.info",
	"inboxclean.com",
	"inboxclean.org",
	"incognitomail.com",
	"incognitomail.net",
	"ipoo.org",
	"irish2me.com",
	"jetable.com",
	"jetable.fr.nf",
	"jetable.net",
	"jetable.org",
	"junk1e.com",
	"kaspop.com",
	"kulturbetrieb.info",
	"kurzepost.de",
	"lifebyfood.com",
	"link2mail.net",
	"litedrop.com",
	"lookugly.com",
	"lopl.co.cc",
	"lr78.com",
	"maboard.com",
	"mail.by",
	"mail.mezimages.net",
	"mail4trash.com",
	"mailbidon.com",
	"mailcatch.com",
	"maileater.com",
	"mailexpire.com",
	"mailin8r.com",
	"mailinator.com",
	"mailinator.net",
	"mailinator2.com",
	"mailincubator.com",
	"mailme.lv",
	"mailnator.com",
	"mailnull.com",
	"mailzilla.org",
	"mbx.cc",
	"mega.zik.dj",
	"meltmail.com",
	"mierdamail.com",
	"mintemail.com",
	"moncourrier.fr.nf",
	"monemail.fr.nf",
	"monmail.fr.nf",
	"mt2009.com",
	"mx0.wwwnew.eu",
	"mycleaninbox.net",
	"mytrashmail.com",
	"neverbox.com",
	"nobulk.com",
	"noclickemail.com",
	"nogmailspam.info",
	"nomail.xl.cx",
	"nomail2me.com",
	"no-spam.ws",
	"nospam.ze.tc",
	"nospam4.us",
	"nospamfor.us",
	"nowmymail.com",
	"objectmail.com",
	"obobbo.com",
	"onewaymail.com",
	"ordinaryamerican.net",
	"owlpic.com",
	"pookmail.com",
	"proxymail.eu",
	"punkass.com",
	"putthisinyourspamdatabase.com",
	"quickinbox.com",
	"rcpt.at",
	"recode.me",
	"recursor.net",
	"regbypass.comsafe-mail.net",
	"safetymail.info",
	"sandelf.de",
	"saynotospams.com",
	"selfdestructingmail.com",
	"sendspamhere.com",
	"shiftmail.com",
	"****mail.me",
	"skeefmail.com",
	"slopsbox.com",
	"smellfear.com",
	"snakemail.com",
	"sneakemail.com",
	"sofort-mail.de",
	"sogetthis.com",
	"soodonims.com",
	"spam.la",
	"spamavert.com",
	"spambob.net",
	"spambob.org",
	"spambog.com",
	"spambog.de",
	"spambog.ru",
	"spambox.info",
	"spambox.us",
	"spamcannon.com",
	"spamcannon.net",
	"spamcero.com",
	"spamcorptastic.com",
	"spamcowboy.com",
	"spamcowboy.net",
	"spamcowboy.org",
	"spamday.com",
	"spamex.com",
	"spamfree24.com",
	"spamfree24.de",
	"spamfree24.eu",
	"spamfree24.info",
	"spamfree24.net",
	"spamfree24.org",
	"spamgourmet.com",
	"spamgourmet.net",
	"spamgourmet.org",
	"spamherelots.com",
	"spamhereplease.com",
	"spamhole.com",
	"spamify.com",
	"spaminator.de",
	"spamkill.info",
	"spaml.com",
	"spaml.de",
	"spammotel.com",
	"spamobox.com",
	"spamspot.com",
	"spamthis.co.uk",
	"spamthisplease.com",
	"speed.1s.fr",
	"suremail.info",
	"tempalias.com",
	"tempemail.biz",
	"tempemail.com",
	"tempe-mail.com",
	"tempemail.net",
	"tempinbox.co.uk",
	"tempinbox.com",
	"tempomail.fr",
	"temporaryemail.net",
	"temporaryinbox.com",
	"thankyou2010.com",
	"thisisnotmyrealemail.com",
	"throwawayemailaddress.com",
	"tilien.com",
	"tmailinator.com",
	"tradermail.info",
	"trash2009.com",
	"trash-amil.com",
	"trashmail.at",
	"trash-mail.at",
	"trashmail.com",
	"trash-mail.com",
	"trash-mail.de",
	"trashmail.me",
	"trashmail.net",
	"trashymail.com",
	"trashymail.net",
	"tyldd.com",
	"uggsrock.com",
	"wegwerfmail.de",
	"wegwerfmail.net",
	"wegwerfmail.org",
	"wh4f.org",
	"whyspam.me",
	"willselfdestruct.com",
	"winemaven.info",
	"wronghead.com",
	"wuzupmail.net",
	"xoxy.net",
	"yogamaven.com",
	"yopmail.com",
	"yopmail.fr",
	"yopmail.net",
	"yuurok.com",
	"zippymail.info",
	"jnxjn.com",
	"trashmailer.com",
	"klzlk.com",
	);

	$email_split = explode('@', $email);
	$email_domain = $email_split[1];

	if (in_array($email_domain, $blacklist)) {
		//Return 1, disposable email detected
		return 1;
	}
	else {
		//Return 0, no match found
		return 0;
	}
}

function sendEmail($from,$to,$subject,$body) {
	require_once 'classes/phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	$mail->From = $from;
	$mail->FromName = '';
	$mail->addAddress($to);
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->send();
}

function rand_str($size)
{
   $feed = "0123456789abcdefghijklmnopqrstuvwxyz";
   for ($i=0; $i < $size; $i++)
   {
	   $rand_str .= substr($feed, rand(0, strlen($feed)-1), 1);
   }
   return $rand_str;
}

function deleteDir($dirPath) {
	if (! is_dir($dirPath)) {
		die('0');
	}
	if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') { //Just in Case :)
		$dirPath .= '/';
	}
	$files = glob($dirPath . '*', GLOB_MARK);
	foreach ($files as $file) {
		if (is_dir($file)) {
			deleteDir($file);
		} else {
			unlink($file);
		}
	}
	rmdir($dirPath);
}

function deleteAll($uploadId) {
	global $user_id;
	$sql = mysql_query('select user_id,url from uploads where id=\''.$uploadId.'\'');
	$row = mysql_fetch_assoc($sql);
	if ($row['user_id'] != $user_id) {
		die('0');
	}

	mysql_query('delete from pages where upload_id='.$uploadId);
	mysql_query('delete from uploads where id='.$uploadId);
	
	
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/splitted/'.$uploadId)) {
		deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/splitted/'.$uploadId.'/');
		deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/originals/'.$uploadId.'/');
		deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/splitted_jpgs/'.$uploadId.'/');
	}
}

function format_size($size) {
    $units = explode(' ', 'B KB MB GB TB PB');

    $mod = 1024;

    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    $endIndex = strpos($size, ".")+3;

    return substr( $size, 0, $endIndex).''.strtolower($units[$i]);
}

function foldersize($path) {
    $total_size = 0;
    $files = scandir($path);
    $cleanPath = rtrim($path, '/'). '/';

    foreach($files as $t) {
        if ($t<>"." && $t<>"..") {
            $currentFile = $cleanPath . $t;
            if (is_dir($currentFile)) {
                $size = foldersize($currentFile);
                $total_size += $size;
            }
            else {
                $size = filesize($currentFile);
                $total_size += $size;
            }
        }   
    }

    return $total_size;
}

function countIt($table,$condition) {
	$sql="select count(*) as countJoker from $table where $condition";
	$result = mysql_query($sql); // Run the $sql query;
	$count = mysql_fetch_array($result);
	return $count['countJoker'];
}

function getIp()
{
	if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
	{
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		return $_SERVER['REMOTE_ADDR'];
	}
}
?>
