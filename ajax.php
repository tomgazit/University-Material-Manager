<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { //Detect an AJAX request
	include 'db.php';
	include 'functions.php';

	$type = $_POST['type']; //Detect request type
	$typeGet = $_GET['type']; //Detect request type
		
	if ($type == 'register') {
		
		$code=rand_str(40);
		$email = mysql_real_escape_string($_POST['email']); //Prevent SQL Injections
		$password = md5($_POST['password']);
		$name = mysql_real_escape_string($_POST['name']);
		
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			echo "3";
		}
		elseif (disposableEmailCheck($email) === 1) {
			echo '4';
		}
		else
		{
			$sql = mysql_query('select id from users where email=\''.$email.'\'');
			$row = mysql_fetch_assoc($sql);
			$user_id = $row['id'];
			if ($user_id > 0) {
				echo '1';
			}
			else {
				$sql = mysql_query("insert into users values('','".$email."','".$password."','".$name."',".time().",0,'".$code."')") or die ("Error in query: $query. ".mysql_error());
				
				sendEmail('tauagudaacademicbank@gmail.com',$email,'תודה שנרשמת לבנק הסריקות :)','יש ללחוץ כאן על מנת להשלים את ההרשמה:<br/><a href="http://www.taupdf.com/index.php?email='.$email.'&amp;code='.$code.'">לחץ כאן</a>');
				
				echo '2';
			}
		}
	}
	elseif ($type == 'logout') {
		setcookie('bank_user', '', time() + (60*60*24), "/"); //60*60*24 = 1 Day
		$data=array('ok'=>1);
	}
	elseif ($type == 'login') {
		$email = mysql_real_escape_string($_POST['email']); //Prevent SQL Injections
		$password = md5($_POST['password']);

		$sql = mysql_query('select id,name from users where email=\''.$email.'\' and password=\''.$password.'\'');
		$row = mysql_fetch_assoc($sql);
		$user_id = $row['id'];
		$user_name = $row['name'];

		if ($user_id > 0) {
			setcookie('bank_user', $user_id.'_'.$password, time() + (60*60*24), "/"); //60*60*24 = 1 Day
			$data=array('ok'=>1,'id'=>$user_id,'name'=>$user_name);
		}
		else {
			$data=array('ok'=>0);
		}
		echo json_encode($data);
	}
	elseif ($typeGet == 'list') {
		$approvedList = array('departments','courses','teachers');
		$tbl = $_GET['tbl'];
		if (in_array($tbl,$approvedList)) {
			$rows=array();
			$sql = mysql_query('select id,name from '.$tbl);
			while ($row = mysql_fetch_assoc($sql)) {
				$rows[]=$row;
			}			
			die(json_encode($rows));
		}
	}
	elseif ($type == 'getRowData') {
		$uploadId = mysql_real_escape_string($_POST['uploadId']); //Prevent SQL Injections
		$rows=array();
		
		$sql = mysql_query('select page,date from pages where upload_id='.$uploadId.' order by date');
		while ($row = mysql_fetch_assoc($sql)) {
			$rows[]=intval($row['date']);
		}
		
		$rows=array_unique($rows);
		$uniqueRows=array();
		foreach ($rows as $val) {
			$uniqueRows['dates'][]=$val;
		}
		
		$size=foldersize(getcwd()."/uploads/splitted/".$uploadId)*1.05;
		$uniqueRows['filesize']=format_size($size);
		
		//Star Rating
		$countRating = countIt('ratings','upload_id='.$uploadId);
		$rating=0;
		if ($countRating > 0) {
			if ($user_id > 0) {
				$ipNoDots=$user_id; //use userid instead of his IP
			}
			else {
				$ipNoDots=str_replace('.','',getIp());
			}
					
			$sqlRating = mysql_query('select rating from ratingsStats where upload_id='.$uploadId.' and ip='.$ipNoDots);
			$ratingRow = mysql_fetch_assoc($sqlRating);
			$rating=$ratingRow['rating'];
		}
		$uniqueRows['rating']=round(6-$rating);
		
		die(json_encode($uniqueRows));
	}
	elseif ($type == 'getRowDataEdit') {
		$uploadId = mysql_real_escape_string($_POST['uploadId']); //Prevent SQL Injections
		$sql = mysql_query('select count(id) as counter from uploads where id=\''.$uploadId.'\' and user_id='.$user_id.'');
		$row = mysql_fetch_assoc($sql);
		$counter = $row['counter'];
		if ($counter == 1) {
			$sql='SELECT uploads.id as editId, uploads.url as inputExt,departments.name as inputDept, courses.name as inputCourse, teachers.name as inputTeacher, semester as inputSemester,study_year as inputStudyYear,type as filetype,upload_date,written_year as inputWrittenYear, uploads.cont_name as inputContName FROM uploads left join departments on departments.id=uploads.dept_id left join teachers on teachers.id=uploads.teacher_id left join courses on courses.id=uploads.course_id WHERE uploads.id='.$uploadId;
			$sql = mysql_query($sql);
			$rows = mysql_fetch_assoc($sql);
			$rows['status']=1;
		}
		else {
			$rows=array('status'=>0);
		}
		
		die(json_encode($rows));
	}
	elseif ($type == 'editRow') {
		
		foreach ($_POST as $key => $value) {
			$$key=mysql_real_escape_string($value);
		}

		$sql = mysql_query('select user_id from uploads where id=\''.$editId.'\'');
		$row = mysql_fetch_assoc($sql);
		if ($row['user_id'] != $user_id) {
			$rows=array('status'=>0);
		}		
		else {
			$sql = mysql_query('select id from departments where name=\''.$inputDept_edit.'\'');
			$row = mysql_fetch_assoc($sql);
			$inputDeptId = $row['id']>0?$row['id']:0;
			if ($inputDeptId === 0) {
				mysql_query('insert into departments values("","'.$inputDept_edit.'")');
				$inputDeptId=mysql_insert_id();
			}

			$sql = mysql_query('select id from teachers where name=\''.$inputTeacher_edit.'\'');
			$row = mysql_fetch_assoc($sql);
			$inputTeacherId = $row['id']>0?$row['id']:0;
			if ($inputTeacherId === 0) {
				mysql_query('insert into teachers values("","'.$inputTeacher_edit.'")');
				$inputTeacherId=mysql_insert_id();
			}

			$sql = mysql_query('select id from courses where name=\''.$inputCourse_edit.'\'');
			$row = mysql_fetch_assoc($sql);
			$inputCourseId = $row['id']>0?$row['id']:0;
			if ($inputCourseId === 0) {
				mysql_query('insert into courses values("","'.$inputCourse_edit.'")');
				$inputCourseId=mysql_insert_id();
			}

			mysql_query('update uploads set dept_id='.$inputDeptId.', course_id='.$inputCourseId.', teacher_id='.$inputTeacherId.', type='.$filetype_edit.', study_year='.$inputStudyYear_edit.', semester='.$inputSemester_edit.', written_year="'.$inputWrittenYear_edit.'", cont_name="'.$inputContName_edit.'", url="'.$inputExt_edit.'" where id='.$editId);
				
			$rows=array('status'=>1);
		}
		
		die(json_encode($rows));
	}
	elseif ($type == 'removePage') {
		
		$removeData = mysql_real_escape_string($_POST['removeData']); //Prevent SQL Injections
		$data = explode('_',$removeData);
		$uploadId = $data[1];
		$pageId = $data[2];
		
		$sql = mysql_query('select user_id from uploads where id=\''.$uploadId.'\'');
		$row = mysql_fetch_assoc($sql);
		if ($row['user_id'] != $user_id) {
			die('0');
		}
		
		$sql = mysql_query('select date from pages where upload_id='.$uploadId.' and page='.$pageId);
		$row = mysql_fetch_assoc($sql);
		$pageDate = $row['date'];

		mysql_query('delete from pages where upload_id='.$uploadId.' and page='.$pageId);
		if ($pageDate > 0) {
			mysql_query('update uploads set dated=dated-1 where id='.$uploadId);
		}
		unlink('uploads/splitted/'.$uploadId.'/'.$pageId.'.pdf');
		unlink('uploads/splitted_jpgs/'.$uploadId.'/'.$pageId.'.jpg');
		die($pageId);
		
	}
	elseif ($type == 'deleteAll') {
		$uploadId = mysql_real_escape_string($_POST['removeData']); //Prevent SQL Injections
		deleteAll($uploadId);
		die('1');
	}
	elseif ($type == 'date') {
		
		$uploadId = mysql_real_escape_string($_POST['uploadId']); //Prevent SQL Injections
		$pageId = mysql_real_escape_string($_POST['pageId']); //Prevent SQL Injections
		$epoch = mysql_real_escape_string($_POST['epoch']); //Prevent SQL Injections

		$sql = mysql_query('select count(id) as counter from uploads where id=\''.$uploadId.'\' and user_id='.$user_id.'');
		$row = mysql_fetch_assoc($sql);
		$counter = $row['counter'];
		
		if ($counter == 1) {
			
			$sql = mysql_query('select id from pages where upload_id=\''.$uploadId.'\' and page='.$pageId.'');
			$row = mysql_fetch_assoc($sql);
			$id = $row['id'];
			if ($id > 0) {
				mysql_query('update pages set date='.$epoch.' where id='.$id);
			}
			else {
				mysql_query('insert into pages values("",'.$uploadId.','.$pageId.','.$epoch.',0)');
			}
			
			$sql = mysql_query('select count(id) as counter from pages where upload_id=\''.$uploadId.'\' and date>0');
			$row = mysql_fetch_assoc($sql);
			$counter = $row['counter'];
			mysql_query('update uploads set dated='.$counter.' where id='.$uploadId);
			
			die('1');
		}
		die('0');
	}
	elseif ($type == 'sortUpload') {
		$uploadId = mysql_real_escape_string($_POST['uploadId']); //Prevent SQL Injections
		$data = $_POST['data'];
		
		$dataSort=Array();
		$i=0;
		foreach ($data as $value) {
			$i++;
			$value = mysql_real_escape_string($value); //Prevent SQL Injections
			$dataSort[str_replace('pdf_','',$value)]=$i;
		}

		$sql = mysql_query('select id,page from pages where upload_id='.$uploadId.' order by date');
		while ($row = mysql_fetch_assoc($sql)) {
			$id=$row['id'];
			$page=$row['page'];
			mysql_query('update pages set sort='.$dataSort[$page].' where id='.$id);
			unset($dataSort[$page]);
		}
		
		foreach ($dataSort as $key => $value) {
			mysql_query('insert into pages values("",'.$uploadId.','.$key.',0,'.$value.')');
		}
		
		die('1');
		
	}
	elseif ($type == 'rating') {
		$uploadId=intval($_POST['uploadid']);
		$ratingVal=6-intval($_POST['rating']);
		if ($user_id > 0) {
			$ipNoDots=$user_id; //use userid instead of his IP
		}
		else {
			$ipNoDots=str_replace('.','',getIp());
		}
		//Star Rating
		$countIp = countIt('ratingsStats','upload_id='.$uploadId.' and ip='.$ipNoDots);
		if ($countIp == 0) {
			mysql_query('insert into ratingsStats values("",'.$uploadId.','.$ipNoDots.','.$ratingVal.')');
		}
		else {
			mysql_query('update ratingsStats set rating='.$ratingVal.' where upload_id='.$uploadId.' and ip='.$ipNoDots);
		}
		
		$sqlRating = mysql_query('select avg(rating) as avgRating from ratingsStats where upload_id='.$uploadId);
		$ratingRow = mysql_fetch_assoc($sqlRating);
		$avgRating=$ratingRow['avgRating'];
		
		$ratingExist = countIt('ratings','upload_id='.$uploadId);
		if ($ratingExist > 0) {
			mysql_query('update ratings set rating='.$avgRating.' where upload_id='.$uploadId);
		}
		else {
			mysql_query('insert into ratings values("",'.$uploadId.','.$ratingVal.')');
		}	
	}
	else {
		die('Ajax Failed :D');
	}
}
?>