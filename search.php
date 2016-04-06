<?
include 'db.php';
$search = trim(mysql_real_escape_string($_POST['search']));
$results=0;

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
?>

<div class="scroller">
	<div class="row">
		<div class="col-md-2 col-sm-2 col-xs-4"><i class="fa fa-eye"></i> - הרצאות</div>
		<div class="col-md-2 col-sm-2 col-xs-4"><i class="fa fa-pencil"></i> - תרגולים</div>
		<div class="col-md-2 col-sm-2 col-xs-4"><i class="fa fa-flask"></i> - דפי נוסחאות</div>
		<div class="col-md-2 col-sm-2 col-xs-4"><i class="fa fa-check-square-o"></i> - תרגילים פתורים</div>
		<div class="col-md-2 col-sm-2 col-xs-4"><i class="fa fa-leaf"></i> - אחר</div>
		<div class="col-md-2 col-sm-2 col-xs-4"><i class="fa fa-calendar"></i> - מקוטלג תאריכים</div>
	</div>
</div>

<div class="table-responsive">
	<table class="table table-striped table-hover">
	  <?
	  if ($search != '') {
		  //$sql='SELECT uploads.id as id, uploads.url as url, uploads.counter_unique, uploads.counter_all, departments.name as dept_name, courses.name as course_name, teachers.name as teacher_name, semester,dated,study_year,type,upload_date,written_year,cont_name 				   FROM uploads left join departments on departments.id=uploads.dept_id left join teachers on teachers.id=uploads.teacher_id left join courses on courses.id=uploads.course_id 													 WHERE courses.name like "%'.$search.'%" or teachers.name like "%'.$search.'%" or departments.name like "%'.$search.'%" order by ratings.rating desc,uploads.dated desc';
		  
		  $sql='SELECT uploads.id as id, uploads.url as url, uploads.counter_unique, uploads.counter_all, departments.name as dept_name, courses.name as course_name, teachers.name as teacher_name, semester,dated,study_year,type,upload_date,written_year,cont_name, ratings.rating FROM uploads left join departments on departments.id=uploads.dept_id left join teachers on teachers.id=uploads.teacher_id left join courses on courses.id=uploads.course_id left join ratings on ratings.upload_id=uploads.id WHERE courses.name like "%'.$search.'%" or teachers.name like "%'.$search.'%" or departments.name like "%'.$search.'%" order by ratings.rating desc,uploads.dated desc';
		  
		  $sql = mysql_query($sql);
		  while ($row = mysql_fetch_assoc($sql)) {
		  $results++;
		  if ($results == 1) {
			?>
			<tr class="table-header">
				<!--<td>מחלקה</td>-->
				<td>קורס</td>
				<td>מידע</td>
				<!--<td class="center">סמסטר</td>-->
				<!--<td class="center">מקוטלג תאריכים</td>-->
				<!--<td class="center">שנה בתואר</td>-->
				<!--<td class="center">תאריך העלאה</td>-->
				<!--<td class="center">שנת כתיבה</td>-->
				<!--<td class="center">עמודים</td>-->
			</tr>
			<?
		  }
			extract($row);
			
			if ($url == '') {
				$fi = new FilesystemIterator('uploads/splitted/'.$id, FilesystemIterator::SKIP_DOTS);
				$pages_count=iterator_count($fi);
				$percent=round($dated/$pages_count*100).'%';
			}
			else {
				$pages_count='-';
				$percent='-';
			}
			
			echo '<tr style="cursor: pointer;" class="uploadRow" id="row_'.$id.'">';
			//echo '<td>'.$id.'</td>';
			//echo '<td>'.$dept_name.'</td>';
			echo '<td class="courseNameRow">';
			
			
				
			echo $course_name.'<br/>';
			
			
			switch ($type) {
				case '1': echo '<i class="fa fa-eye"></i>'; break;
				case '2': echo '<i class="fa fa-pencil"></i>'; break;
				case '3': echo '<i class="fa fa-pencil"></i> <i class="fa fa-eye"></i>'; break;
				case '4': echo '<i class="fa fa-flask"></i>'; break;
				case '5': echo '<i class="fa fa-check-square-o"></i>'; break;
				case '6': echo '<i class="fa fa-leaf"></i>'; break;
			}
			
			if ($dated > 0) {
				echo ' <i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" style="margin-right: 5px;" title="'.$percent.'"></i>';
			}
			
			echo '</td>';
			echo '<td>הועבר ע"י: '.$teacher_name.'<br/>';
			
			echo 'שנה: '.$written_year;
			
			echo '<br/>סמסטר: ';
			
			switch ($semester) {
				case '1': echo 'א\''; break;
				case '2': echo 'ב\''; break;
				case '3': echo 'קיץ'; break;
			}
			
			echo '<br/>';
			for ($i=1;$i<=$rating;$i++) {
				echo '<i class="icon-star" style="color: #ffdf88;"></i>';
			}
			for ($i=$rating;$i<5;$i++) {
				echo '<i class="icon-star" style="color: #dddddd;"></i>';
			}		
		
			echo '<div style="display: none;" class="ratingNum">'.$rating.'</div>';
			echo '<div style="display: none;" class="catalogPerRow">'.$percent.'</div>';
			
			echo '</td>';
			
			
			//echo '<td class="center catalogPerRow">'.$percent.'</td>';
			//echo '<td class="center">'.$study_year.'</td>';
			//echo '<td class="center">'.date('d/m/Y', $upload_date).'</td>';
			//echo '<td class="center">'.$written_year.'</td>';
			//echo '<td class="center">'.$pages_count.'</td>';
			echo '<td style="display: none;"><input type="hidden" class="extUrl" value="'.$url.'"><input type="hidden" class="contName" value="'.$cont_name.'"><input type="hidden" class="extUnique" value="'.$counter_unique.'"><input type="hidden" class="extAll" value="'.$counter_all.'"></td>';
			echo '</tr>';
		  }
		  
		  if ($results == 0) {
			$errorTxt='לא נמצאו תוצאות עבור <b>"'.$search.'"</b>';
		  }
	  }
	  else {
		$errorTxt='יש להקיש מילת חיפוש';
	  }
	  
	  if ($errorTxt != '') {
		?>
		<tr>
			<td colspan="10" style="text-align: center; padding: 10px;"><?=$errorTxt;?></td>
		</tr>
		<?
	  }
	  ?>
	  
	   
	</table>
</div>


<?
}
else {
?>
<div class="scroller">
	<div class="row" style="text-align: left; margin-left: 10px;">
		<i style="margin-right: 20px;" class="fa fa-eye"></i> - הרצאות
		<i style="margin-right: 20px;" class="fa fa-pencil"></i> - תרגולים
		<i style="margin-right: 20px;" class="fa fa-flask"></i> - דפי נוסחאות
		<i style="margin-right: 20px;" class="fa fa-check-square-o"></i> - תרגילים פתורים
		<i style="margin-right: 20px;" class="fa fa-leaf"></i> - אחר
	</div>
</div>

<div class="table-responsive">
	<table class="table table-striped table-hover ">
	  <?
	  if ($search != '') {
		  //$sql='SELECT uploads.id as id,uploads.url as url,uploads.counter_unique,uploads.counter_all,departments.name as dept_name, courses.name as course_name, teachers.name as teacher_name, semester,dated,study_year,type,upload_date,written_year,cont_name FROM uploads left join departments on departments.id=uploads.dept_id left join teachers on teachers.id=uploads.teacher_id left join courses on courses.id=uploads.course_id WHERE courses.name like "%'.$search.'%" or teachers.name like "%'.$search.'%" or departments.name like "%'.$search.'%" order by uploads.dated desc';
		  $sql='SELECT uploads.id as id,uploads.url as url,uploads.counter_unique,uploads.counter_all,departments.name as dept_name, courses.name as course_name, teachers.name as teacher_name, semester,dated,study_year,type,upload_date,written_year,cont_name, ratings.rating FROM uploads left join departments on departments.id=uploads.dept_id left join teachers on teachers.id=uploads.teacher_id left join courses on courses.id=uploads.course_id left join ratings on ratings.upload_id=uploads.id WHERE courses.name like "%'.$search.'%" or teachers.name like "%'.$search.'%" or departments.name like "%'.$search.'%" order by ratings.rating desc,uploads.dated desc';
		  $sql = mysql_query($sql);
		  while ($row = mysql_fetch_assoc($sql)) {
		  $results++;
		  if ($results == 1) {
			?>
			<tr class="table-header">
				<td>מחלקה</td>
				<td>קורס</td>
				<td>מרצה/מתרגל</td>
				<td class="center">סמסטר</td>
				<!--<td class="center">מקוטלג תאריכים</td>-->
				<td class="center">שנה בתואר</td>
				<td class="center">תאריך העלאה</td>
				<td class="center">שנה מקורית</td>
				<td class="center">עמודים</td>
				<td class="center">דירוג</td>
			</tr>
			<?
		  }
			extract($row);
			
			$badNow=false;
			if ($url == '') {
				try {
				$fi = new FilesystemIterator('uploads/splitted/'.$id, FilesystemIterator::SKIP_DOTS);
				$pages_count=iterator_count($fi);
				}
				catch (UnexpectedValueException $e) {
					//printf("Directory [%s] contained a directory we can not recurse into", $directory);
					//echo $course_name.'<br>';
					$badNow=true;
				}
				$percent=round($dated/$pages_count*100).'%';
				
				
			}
			else {
				$pages_count='-';
				$percent='-';
			}
			
			echo '<tr style="cursor: pointer;" class="uploadRow" id="row_'.$id.'">';
			//echo '<td>'.$id.'</td>';
			echo '<td>'.$dept_name.' '.($badNow?'BAD!':'').'</td>';
			echo '<td class="courseNameRow">';
			
			switch ($type) {
				case '1': echo '<span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="הרצאות"></span>'; break;
				case '2': echo '<span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="תרגולים"></span>'; break;
				case '3': echo '<span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="הרצאות ותרגולים"></span><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="הרצאות ותרגולים"></span>'; break;
				case '4': echo '<i class="fa fa-flask" data-toggle="tooltip" data-placement="top" title="דפי נוסחאות"></i>'; break;
				case '5': echo '<span class="glyphicon glyphicon-leaf" data-toggle="tooltip" data-placement="top" title="אחר"></span>'; break;
			}
			
			echo ' '.$course_name.'</td>';
			echo '<td>'.$teacher_name.'</td>';
			echo '<td class="center">';
			switch ($semester) {
				case '1': echo 'א\''; break;
				case '2': echo 'ב\''; break;
				case '3': echo 'ג\''; break;
				case '4': echo 'ד\''; break;
			}
			echo '</td>';
			
			//echo '<td class="center catalogPerRow">'.$percent.'</td>';
			echo '<td class="center">'.$study_year.'</td>';
			echo '<td class="center">'.date('d/m/Y', $upload_date).'</td>';
			echo '<td class="center">'.$written_year.'</td>';
			echo '<td class="center">'.$pages_count.'</td>';
			echo '<td style="display: none;"><input type="hidden" class="extUrl" value="'.$url.'"><input type="hidden" class="contName" value="'.$cont_name.'"><input type="hidden" class="extUnique" value="'.$counter_unique.'"><input type="hidden" class="extAll" value="'.$counter_all.'"></td>';
			echo '<td class="center"><div style="display: none;" class="ratingNum">'.$rating.'</div>';
			echo '<div style="display: none;" class="catalogPerRow">'.$percent.'</div>';
				for ($i=1;$i<=$rating;$i++) {
					echo '<i class="icon-star" style="color: #ffdf88;"></i>';
				}
				for ($i=$rating;$i<5;$i++) {
					echo '<i class="icon-star" style="color: #dddddd;"></i>';
				}
			echo '</td>';
			echo '</tr>';
		  }
		  
		  if ($results == 0) {
			$errorTxt='לא נמצאו תוצאות עבור <b>"'.$search.'"</b>';
		  }
	  }
	  else {
		$errorTxt='יש להקיש מילת חיפוש';
	  }
	  
	  if ($errorTxt != '') {
		?>
		<tr>
			<td colspan="10" style="text-align: center; padding: 10px;"><?=$errorTxt;?></td>
		</tr>
		<?
	  }
	  ?>
	  
	   
	</table>
</div>
<?
}
?>