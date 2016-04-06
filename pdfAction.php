<?
require_once('db.php');
require_once('fpdf.php');
require_once('fpdi.php');

include 'functions.php';

$uploadId = intval($_GET['uploadId']); //Prevent SQL Injections
$epoch = intval($_GET['epoch']);
$show = intval($_GET['show']);

$sqlCounter = mysql_query('select id, count(id) as counter from stats where upload_id='.$uploadId.' and ip=\''.$user_ip.'\'');
$rowCounter = mysql_fetch_assoc($sqlCounter);
if ($rowCounter['counter'] > 0) { 
	mysql_query('update stats set counter=counter+1 where id='.$rowCounter['id']);
}
else {
	mysql_query('insert into stats values(\'\','.$uploadId.',"'.$user_ip.'",'.time().')');
	mysql_query('update uploads set counter_unique=counter_unique+1 where id='.$uploadId);
}

mysql_query('update uploads set counter_all=counter_all+1 where id='.$uploadId);

$dir = getcwd()."/uploads/splitted/".$uploadId;
$filesPages=array();
if ($epoch > 0) {
	//Collect all pages of specific time
	$sql = mysql_query('select page from pages where upload_id='.$uploadId.' and date='.$epoch);
	while ($row = mysql_fetch_assoc($sql)) {
		$page=$row['page'];
		$filesPages[$page] = $page.'.pdf';
	}
}
else {
	//Collect all "catalogized" pages, and after that add the rest available files from the directory
	$datesAr=array();
	$pagesCount=0;
	$sql = mysql_query('select page,date from pages where upload_id='.$uploadId.' order by sort,date,id');
	while ($row = mysql_fetch_assoc($sql)) {
		$pageDate=$row['date'];
		//if ($pageDate > 0) {
			$pagesCount++;
			$page=$row['page'];
			$datesAr[$pagesCount]=$pageDate;
			$filesPages[$page] = $page.'.pdf';
		//}
	}
	
	$datesAr=array_unique($datesAr);

	//This is where we get the files from the directory
	$dh  = opendir($dir);
	$filesDir=array();
	while (false !== ($filename = readdir($dh))) {
		if ($filename == '.' || $filename == '..') continue;
		$key = basename($filename,'.pdf');
		if (!in_array($filename,$filesPages)) {
			$filesDir[$key] = $filename;
		}		
	}
	
	ksort($filesDir); //Sort the files (added from the directory) correctly

	//Add these "dir" files to the "catalogized" files
	foreach ($filesDir as $key => $val) {
		$filesPages[]=$val;
	}
	
}

$filesConcat=array();
foreach ($filesPages as $key => $val) {
	$filesConcat[]=$dir.'/'.$val;
}



$sql = mysql_query('select users.name as user_name, uploads.cont_name as cont_name, courses.name as name, teachers.name as teacher_name, uploads.type as type from uploads inner join courses on courses.id=uploads.course_id   inner join teachers on teachers.id=uploads.teacher_id inner join users on users.id=uploads.user_id where uploads.id=\''.$uploadId.'\'');

$row = mysql_fetch_assoc($sql);
$courseName = $row['name'];
$user_name = $row['user_name'];
$cont_name = $row['cont_name']!=''? $row['cont_name'] : 'לא ידוע';
$teacher_name = $row['teacher_name'];
$type = $row['type'];

switch ($type) {
	case '1': $typeName='הרצאות'; break;
	case '2': $typeName='תרגולים'; break;
	case '3': $typeName='הרצאות ותרגולים'; break;
	case '4': $typeName='דפי נוסחאות'; break;
	case '5': $typeName='חומר עזר'; break;
}

$extra='';
if ($epoch > 0) {
	$extra='_'.date('d.m.Y',$epoch);
	$extraFooter='  |  קובץ של תאריך: '.date('d/m/Y',$epoch);
}

$footerText='קורס: '.$courseName.' ('.$typeName.')  |  הועבר ע"י: '.$teacher_name.'  |  נתרם ע"י: '.$cont_name.$extraFooter;

$pdf = new concat_pdf();
$pdf->setFiles($filesConcat); //$files is an array with existing PDF files.
$pdf->concat();

/* 
$pdf->AliasNbPages();
$pdf->AliasNbPages('{totalPages}');
$pdf->Cell(0, 5, "Page " . $pdf->PageNo() . "/{totalPages}", 0, 1);

$pdf->Cell(40,10,'Hello World!'); */
$pdf->Output($courseName.'_'.$typeName.$extra.'.pdf', $show?'I':'D');
?>