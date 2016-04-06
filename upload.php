<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination

include 'db.php';
include 'functions.php';

foreach ($_POST as $key => $value) {
	$$key=mysql_real_escape_string($value);
}

if ($type == 'pages') {
	
	$sql = mysql_query('select user_id from uploads where id=\''.$uploadId.'\'');
	$row = mysql_fetch_assoc($sql);
	if ($row['user_id'] != $user_id) {
		die('0');
	}
	
	$dir = getcwd()."/uploads/originals/".$uploadId;
	$dh  = opendir($dir);
	
	while (false !== ($fn = readdir($dh))) {
		if ($fn == '.' || $fn == '..') continue;
		$key = basename($fn,'.pdf');
		$files[$key] = $fn;
	}

	ksort($files);
	$tmpName = basename(end($files),'.pdf');
	$tmpName++;
	//$tmpName='tmp'.time();
	
	$fileParts = pathinfo($_FILES['files']['name']);
	
	
	if ($fileParts['extension'] == 'doc' || $fileParts['extension'] == 'docx' || $fileParts['extension'] == 'pdf') {
	
		
		$filename = $tmpName.'.'.$fileParts['extension'];
		$filenamePDF = $tmpName.'.pdf';
		
		$folder='uploads';
		
		$targetFolder = '/'.$folder.'/originals/'.$uploadId; // Relative to the root


		
		error_reporting(E_ALL | E_STRICT);
		require('UploadHandler.php');
		$options = array('upload_dir'=>'uploads/originals/'.$uploadId.'/', 'upload_url'=>'uploads/originals/'.$uploadId.'/','renameTo'=>$filename,'print_response'=>false);
		$upload_handler = new UploadHandler($options);


		if (!empty($_FILES)) {
			
			//die('wow');
			//$tempFile = $_FILES['Filedata']['tmp_name'];
		//	$targetPath = getcwd() . $targetFolder;
			
			// Validate the file type
			//$fileTypes = array('pdf'); // File extensions
			//$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			//if (in_array($fileParts['extension'],$fileTypes)) {

				//$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				//move_uploaded_file($tempFile,$targetFile);
				
				$dir = getcwd()."/uploads/splitted/".$uploadId;
				$dh  = opendir($dir);
				while (false !== ($fn = readdir($dh))) {
					if ($fn == '.' || $fn == '..') continue;
					$key = basename($fn,'.pdf');
					$files[$key] = $fn;
				}

				ksort($files);
				
				$lastFile = basename(end($files),'.pdf');
				
				$lastFile++;
				
				
				
				if ($fileParts['extension'] == 'doc' || $fileParts['extension'] == 'docx') {
					exec('/usr/bin/libreoffice --headless --convert-to pdf --outdir '.getcwd().'/uploads/originals/'.$uploadId.' '.getcwd().'/uploads/originals/'.$uploadId.'/'.$filename);
					unlink(getcwd().'/uploads/originals/'.$uploadId.'/'.$filename);
				}
				
				
				//Compress PDF
				exec('/usr/bin/gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/default -dNOPAUSE -dBATCH -dQUIET -sOutputFile='.getcwd().'/uploads/originals/'.$uploadId.'/'.$tmpName.'_comp.pdf '.getcwd().'/uploads/originals/'.$uploadId.'/'.$filenamePDF);
				
				unlink(getcwd().'/uploads/originals/'.$uploadId.'/'.$filenamePDF);
				rename(getcwd().'/uploads/originals/'.$uploadId.'/'.$tmpName.'_comp.pdf',getcwd().'/uploads/originals/'.$uploadId.'/'.$filenamePDF);
				
				
				split_pdf(getcwd().'/uploads/originals/'.$uploadId.'/'.$filenamePDF, getcwd().'/uploads/splitted/'.$uploadId.'/',$lastFile,$uploadId,false,getcwd().'/uploads/splitted_jpgs/'.$uploadId); //dont stop on error
				die('1');
				//echo $siteUrl.'/taupdf.com/'.$folder.'/originals/'.$filename;
				
		}
	}	
}
else {
	$sql = mysql_query('select id from departments where name=\''.$inputDept.'\'');
	$row = mysql_fetch_assoc($sql);
	$inputDeptId = $row['id']>0?$row['id']:0;
	if ($inputDeptId === 0) {
		mysql_query('insert into departments values("","'.$inputDept.'")');
		$inputDeptId=mysql_insert_id();
	}

	$sql = mysql_query('select id from teachers where name=\''.$inputTeacher.'\'');
	$row = mysql_fetch_assoc($sql);
	$inputTeacherId = $row['id']>0?$row['id']:0;
	if ($inputTeacherId === 0) {
		mysql_query('insert into teachers values("","'.$inputTeacher.'")');
		$inputTeacherId=mysql_insert_id();
	}

	$sql = mysql_query('select id from courses where name=\''.$inputCourse.'\'');
	$row = mysql_fetch_assoc($sql);
	$inputCourseId = $row['id']>0?$row['id']:0;
	if ($inputCourseId === 0) {
		mysql_query('insert into courses values("","'.$inputCourse.'")');
		$inputCourseId=mysql_insert_id();
	}

	mysql_query("insert into uploads values('',".$user_id.",".$inputDeptId.",'".$filetype."',".$inputTeacherId.",".$inputCourseId.",".$inputSemester.",'".$inputWrittenYear."',".$inputStudyYear.",".time().",0,'".$inputContName."','".$inputExt."',0,0)");
	$lastId = mysql_insert_id();

	if ($inputExt == '') {
		$fileParts = pathinfo($_FILES['files']['name']);
		
		$filename = '1.'.$fileParts['extension'];
		$filenamePDF = '1.pdf';

		$folder='uploads';

		if (!file_exists(getcwd().'/'.$folder.'/originals/'.$lastId)) {
			mkdir(getcwd().'/'.$folder.'/originals/'.$lastId, 0777, true);
		}

		$targetFolder = '/'.$folder.'/originals/'.$lastId; // Relative to the root

		//error_reporting(E_ALL | E_STRICT);
		require('UploadHandler.php');
		$options = array('upload_dir'=>getcwd().'/uploads/originals/'.$lastId.'/', 'upload_url'=>'uploads/originals/'.$uploadId.'/','renameTo'=>$filename,'print_response'=>false);
		$upload_handler = new UploadHandler($options);
		
		if (!empty($_FILES)) {
			//$tmpName='tmp'.time();
			
			//$tempFile = $_FILES['Filedata']['tmp_name'];
			//$targetPath = getcwd() . $targetFolder;
			
			// Validate the file type
		//	$fileTypes = array('pdf'); // File extensions
			//$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			//if (in_array($fileParts['extension'],$fileTypes)) {

				//$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				//move_uploaded_file($tempFile,$targetFile);
				if ($fileParts['extension'] == 'doc' || $fileParts['extension'] == 'docx') {
					//die('/usr/bin/libreoffice --headless --convert-to pdf --outdir '.getcwd().'/uploads/originals/'.$lastId.' '.getcwd().'/uploads/originals/'.$lastId.'/'.$filename);
					exec('/usr/bin/libreoffice --headless --convert-to pdf --outdir '.getcwd().'/uploads/originals/'.$lastId.' '.getcwd().'/uploads/originals/'.$lastId.'/'.$filename);
					unlink(getcwd().'/uploads/originals/'.$lastId.'/'.$filename);
				} 
				
				
				//Compress PDF
				 //die('gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/default -dNOPAUSE -dBATCH -dQUIET -sOutputFile='.getcwd().'/uploads/originals/'.$lastId.'/1_comp.pdf '.getcwd().'/uploads/originals/'.$lastId.'/'.$filenamePDF);
				//exec('gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/default -dNOPAUSE -dBATCH -dQUIET -sOutputFile='.getcwd().'/uploads/originals/'.$lastId.'/1_comp.pdf '.getcwd().'/uploads/originals/'.$lastId.'/'.$filenamePDF, $output, $return);
				//echo var_dump($output).'...'.$return;
				
				//exec('my command'/, $output, $return);
				//die('.');
				//chdir("somedir");
				exec('/usr/bin/gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/default -dNOPAUSE -dBATCH -sOutputFile=uploads/originals/'.$lastId.'/1_comp.pdf uploads/originals/'.$lastId.'/'.$filenamePDF);
				//exec('gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/default -dNOPAUSE -dBATCH -dQUIET -sOutputFile='.getcwd().'/uploads/originals/'.$lastId.'/1_comp.pdf '.getcwd().'/uploads/originals/'.$lastId.'/'.$filenamePDF);
				//echo shell_exec('ls'); 
				
				//die('a');
				unlink(getcwd().'/uploads/originals/'.$lastId.'/'.$filenamePDF);
			
			rename(getcwd().'/uploads/originals/'.$lastId.'/1_comp.pdf',getcwd().'/uploads/originals/'.$lastId.'/'.$filenamePDF);				
				
				split_pdf(getcwd().'/uploads/originals/'.$lastId.'/'.$filenamePDF, getcwd().'/uploads/splitted/'.$lastId.'/',1,$lastId, true, getcwd().'/uploads/splitted_jpgs/'.$lastId);

				//echo $siteUrl.'/taupdf.com/'.$folder.'/originals/'.$lastId.'/'.$filename;
					
			//} else {
				//echo 'Invalid file type.';
			}
		}
		die('{"result": 1}');
	}

?>