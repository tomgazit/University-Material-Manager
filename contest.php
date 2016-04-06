<?
include 'db.php';
if ($user_id == 1 || $user_id == 81) {
?>

<div class="alert alert-info" role="alert" style="margin-bottom: 10px;">העלאות מתחילת סמסטר ב':</div>

<div class="table-responsive">
	<table class="table table-condensed table-striped table-hover">
	  <tr class="table-header">
		<td>תורם</td>
		<td>מספר העלאות</td>
		<td>הועלה ע"י</td>
      </tr>
	  
		
<?
$sql = mysql_query('select cont_name, count(cont_name) as counter, courses.name , users.name from uploads left join courses on courses.id=uploads.course_id left join users on users.id=uploads.user_id where upload_date >= 1425686400 and uploads.url=\'\' group by cont_name order by counter desc, cont_name');
while ($row = mysql_fetch_assoc($sql)) {
	echo '<tr class="listRow">';
	echo '<td>'.$row['cont_name'].'</td>';
	echo '<td>'.$row['counter'].'</td>';
	echo '<td>'.$row['name'].'</td>';
	echo '</tr>';
}
?>
	</table>
</div>
<?
}
?>