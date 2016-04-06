<?
include 'db.php';
if ($user_id == 1 || $user_id == 81) {
?>

<div class="alert alert-info" role="alert" style="margin-bottom: 10px;">מספר העלאות לפי פקולטה:</div>

<div class="table-responsive">
	<table class="table table-condensed table-striped table-hover">
	  <tr class="table-header">
		<td>פקולטה</td>
		<td>מספר העלאות</td>
		<td>מספר צפיות בחומרים</td>
      </tr>
	  
		
<?
$sql = mysql_query('SELECT name,(select count(id) from uploads where departments.id=uploads.dept_id) as counter,(select sum(counter_all) from uploads where departments.id=uploads.dept_id) counterAll FROM departments order by counter desc');
while ($row = mysql_fetch_assoc($sql)) {
	echo '<tr class="listRow">';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['counter'].'</td>';
	echo '<td>'.$row['counterAll'].'</td>';
	echo '</tr>';
}
?>
	</table>
</div>
<?
}
?>