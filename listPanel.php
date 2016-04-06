<?
include 'db.php';
if ($user_id > 0) {
?>
<div class="table-responsive">
	<table class="table table-condensed table-striped table-hover">
	  <tr class="table-header">
		<td>מחלקה</td>
		<td>קורס</td>
		<td>מרצה/מתרגל</td>
		<td class="center">סמסטר</td>
		<td class="center">מקוטלג תאריכים</td>
		<td class="center">שנה בתואר</td>
		<td class="center">סוג</td>
		<td class="center">תאריך העלאה</td>
		<td class="center">שנה מקורית</td>
		<td class="center">עמודים</td>
		<td class="center">הוסף עמודים</td>
		<td class="center">עריכה</td>
		<td class="center">מחיקה</td>
	  </tr>
	  
	  <?
	  
	  $sql='SELECT uploads.id as id, uploads.url as url,departments.name as dept_name, courses.name as course_name, teachers.name as teacher_name, semester,dated,study_year,type,upload_date,written_year FROM uploads left join departments on departments.id=uploads.dept_id left join teachers on teachers.id=uploads.teacher_id left join courses on courses.id=uploads.course_id WHERE user_id='.$user_id.' order by id desc';
	  $sql = mysql_query($sql);
	  $results=0;
	  while ($row = mysql_fetch_assoc($sql)) {
		extract($row);
		$results++;
		
		if ($url == '') {
			$fi = new FilesystemIterator(getcwd().'/uploads/splitted/'.$id, FilesystemIterator::SKIP_DOTS);
			$pages_count=iterator_count($fi);
			$percent=round($dated/$pages_count*100).'%';
		}
		else {
			$pages_count='-';
			$percent='-';
		}
		
		echo '<tr id="rowList_'.$id.'" class="listRow">';
		//echo '<td>'.$id.'</td>';
		echo '<td>'.$dept_name.'</td>';
		echo '<td class="courseName">'.$course_name.'</td>';
		echo '<td>'.$teacher_name.'</td>';
		echo '<td class="center">';
		switch ($semester) {
			case '1': echo 'א\''; break;
			case '2': echo 'ב\''; break;
			case '3': echo 'ג\''; break;
			case '4': echo 'ד\''; break;
		}
		echo '</td>';
		
		echo '<td class="center">
			
			<button type="button" id="percent_'.$id.'" class="percentBtn btn btn-primary" autocomplete="off">
			  '.$percent.'
			</button>
			</td>';
		echo '<td class="center">'.$study_year.'</td>';
		echo '<td class="center">';
		switch ($type) {
			case '1': echo '<span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="left" title="הרצאות"></span>'; break;
			case '2': echo '<span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="תרגולים"></span>'; break;
			case '3': echo '<span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="הרצאות ותרגולים"></span><span class="glyphicon glyphicon-eye-open"></span>'; break;
			case '4': echo '<i class="fa fa-flask" data-toggle="tooltip" data-placement="left" title="דפי נוסחאות"></i>'; break;
			case '5': echo '<span class="glyphicon glyphicon-leaf" data-toggle="tooltip" data-placement="left" title="אחר"></span>'; break;
		}
		echo '</td>';
		echo '<td class="center">'.date('d/m/Y', $upload_date).'</td>';
		echo '<td class="center">'.$written_year.'</td>';
		
		echo '<td class="center">'.$pages_count.'</td>';
		//<span class="glyphicon glyphicon-circle-arrow-up uploadPages" id="uploadPages_'.$id.'" style="font-size: 20px;"></span>
		echo '<td class="center" id="addPages_'.$id.'">
		<form class="form-horizontal" role="form" id="uploadForm" style="margin-bottom: 0;">
						<span class="btn btn-primary fileinput-button" '.($url==''?'':'disabled=disabled').'>
						
								<span>'.($url==''?'בחר קובץ <span class="glyphicon glyphicon-plus"></span>':'קובץ חיצוני').'</span>
								<!-- The file input field used as target for the file upload widget -->
								<input id="uploadPages_'.$id.'" class="uploadPages" type="file" name="files" multiple>
							  </span>
							  
							   <div id="progress_'.$id.'" style="display: none; margin-top: 5px;" class="progress progress-striped">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
							</div>
							<input type="hidden" name="uploadId" id="uploadId_'.$id.'" value="'.$id.'"/>
							<input type="hidden" name="type" value="pages"/>
							</form>
							  </td>';
		echo '<td class="center"><button type="button" class="btn btn-success editAllId" id="editAllId_'.$id.'">עריכה</button></td>';
		echo '<td class="center"><button type="button" class="btn btn-danger deleteAllId" id="deleteAllId_'.$id.'">מחיקה</button></td>';
		echo '</tr>';
	  }
	  
	  if ($results == 0) {
		?>
		<tr>
			<td colspan="12" style="text-align: center; padding: 10px;">לא הועלו קבצים</td>
		</tr>
		<?
	  }
	  ?>
	  
	   
	</table>
</div>
<?
}
?>
