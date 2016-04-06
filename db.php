<?
$link = mysql_connect('localhost', 'sql_user', 'sql_pass');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('soft_taupdf',$link);

mysql_query ( "set character_set_client='utf8'" );
mysql_query ( "set character_set_results='utf8'" );
mysql_query ( "set collation_connection='utf8_general_ci'" );

$user_ip=$_SERVER['REMOTE_ADDR'];

if ($_COOKIE['bank_user'] > 0) {
	$user = explode('_',mysql_real_escape_string($_COOKIE['bank_user']));
	$user_id_temp = $user[0];
	$user_pass_temp = $user[1];
	$sql = mysql_query('select id,name from users where id=\''.$user_id_temp.'\' and password=\''.$user_pass_temp.'\'');
	$row = mysql_fetch_assoc($sql);
	$user_id = $row['id'];	
	//$user_email = $row['email'];	
	$user_name = $row['name'];	
}
?>