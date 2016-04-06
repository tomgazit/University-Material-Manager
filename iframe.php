<?
include 'db.php';
include 'functions.php';
$uploadId=$_GET['id'];

	$sql = mysql_query('select user_id from uploads where id=\''.$uploadId.'\'');
	$row = mysql_fetch_assoc($sql);
	if ($row['user_id'] != $user_id) {
		die('0');
	}
?>

  
  <script>

	  
	  
/* 	  $(document).on('click','#date_1',function() {
		$("#datepicker").datepicker('show');
	  }); */
	  
	 
	  
/* 	  $(document).on('click','.leftArrow',function() {
		curDate=$(this).closest('.pdf').find('.datepicker').val();
		if ($(this).closest('.pdf').prev('.pdf').length > 0) {
			$(this).closest('.pdf').prev('.pdf').find('.datepicker').val(curDate);
		}
	  }); */
	  
  </script>
<center>
<div id="uploadIdIframe" style="display: none;"><?=$uploadId;?></div>
<div id="sortit">
<?

$pagesDates=array();
$pagesSort=array();
$sorted=false;
$sql = mysql_query('select page,date,sort from pages where upload_id=\''.$uploadId.'\' order by sort');
while ($row = mysql_fetch_assoc($sql)) {
	if ($row['sort'] > 0) {
		$sorted=true;
	}
	$pageDate=$row['date'];
	//if ($pageDate > 0) {
		 $pagesDates[$row['page']]=$pageDate;
		 $pagesSort[$row['page']]=$row['page'].'.jpg';
	//}
}

$dir = "/uploads/splitted_jpgs/".$uploadId;
if ($dh  = opendir(getcwd().$dir)) {
	//die($dir);
}
else {
	die('error');
}
//die(getcwd().$dir);
while (false !== ($filename = readdir($dh))) {
	if ($filename == '.' || $filename == '..') continue;
	$key = basename($filename,'.jpg');
    $files[$key] = $filename;
}
/* echo '<pre>';
var_dump($pagesSort);
echo '</pre>';
 */
if (!$sorted) {
	ksort($files);
}
else {
	$files=$pagesSort;
}

$i=0;
foreach ($files as $key => $val) {
$i++;
$pageNumber=$key;
?>
<div class="pdf" id="pdf_<?=$pageNumber;?>" style="margin: 5px; position: relative; width: 360px; background: white; padding: 5px;">
	
	<div style="float: left; padding: 5px;">
		<span class="badge">#<?=$i;?></span>
	</div>
	<div style="margin: 0px; margin-bottom: 5px; float: right;">
		
		<form class="form-inline">
		  <div class="form-group">
			<label class="sr-only" for="exampleInputAmount">בחר תאריך</label>
			<div class="input-group" style="direction: ltr;">
			  <div class="input-group-addon" style="background: whitesmoke">
				<i class="fa fa-calendar" id="date_<?=$pageNumber;?>" style="font-size: 15px;"></i>
			  </div>
			  <input type="text" class="form-control input-sm dp datepicker" id="datepicker_<?=$pageNumber;?>" placeholder="בחר תאריך">
			  <div id="pageNumber_<?=$pageNumber;?>" class="pageNumber" style="display: none;"><?=$i;?></div>
			  <div class="input-group-addon rightArrow" style="background: whitesmoke; padding: 0;">
				<i class="fa fa-arrow-circle-right" style="font-size: 15px; padding: 5px; width: 30px; height: 28px;" data-toggle="tooltip" data-placement="bottom" title="העתק&nbsp;תאריך&nbsp;ימינה"></i>
			  </div>
			</div>
		  </div>
		</form>
		
	</div>
	<div class="iframeDiv">
		<?
		$init='class="lazy" data-original';
		if ($i <= 3) {
			$init='src';
		}
		?>
		<div id="prev_<?=$uploadId;?>_<?=$i;?>" class="zoom" style="width: 350px; height:370px;">
			<img <?=$init;?>="uploads/splitted_jpgs/<?=$uploadId;?>/<?=$val;?><?='?'.time();?>" style="width: 350px; height:470px;"/>
			::after
		</div>
		<div style="position: absolute; left: 30px; bottom: 50px;">
		<button type="button" class="removeIcon btn btn-danger" style="display: none; cursor: pointer;" id="remove_<?=$uploadId;?>_<?=$key;?>">מחיקה</button>
		</div>
	</div>
	<script type="text/javascript">
$(function() {
	$('#prev_<?=$uploadId;?>_<?=$i;?>').zoom({url: 'uploads/splitted_jpgs/<?=$uploadId;?>/<?=$val;?><?='?'.time();?>'});
});
</script>
</div>

<?
}
?>
</div>

<style>
#sortit { list-style-type: none; margin: 0; padding: 0;  }
  #sortit .pdf {  float: left; text-align: center;  }
  #sortit .ui-state-highlight { width: 360px; height: 434px; float: left; margin: 5px; padding: 5px; margin-bottom: 0px;}
  

  
</style>

<script type="text/javascript">
$(function() {
		


		$('#sortit').sortable(
			{ 
				placeholder: "ui-state-highlight",
				tolerance: "pointer",
				revert: true,
				update: function (event, ui) {
					var data = $(this).sortable('toArray');
					
					data.forEach(function(entry) {
						console.log(entry);
					});
					
					// POST to server using $.post or $.ajax
					var uploadId = $('#uploadIdIframe').html();
					$.ajax({
						//data: data,
						data: { type: "sortUpload", data: data, uploadId: uploadId },
						type: 'POST',
						url: 'ajax.php'
					}).done(function( msg ) {
						if (msg == '1') {
							notify('סידור העמודים עודכן בהצלחה','success',2000,'topLeft');
						}
						else {
							notify('שגיאה','error',2000,'topLeft');
						}
					  });
				}
			}
		);

		 $("img.lazy").lazyload({
			container: $("#largeModal"),
			threshold : 200
		 });
		
		$( ".dp" ).datepicker({
			showAnim: 'drop',
			regional: 'he',
			dateFormat: 'dd/mm/yy',
			onSelect: function(date) {
				var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
				var pageId = $(this).attr('id').replace('datepicker_','');
				var pageNumber = $(this).parent().find('.pageNumber').html();
				var uploadId = $('#uploadIdIframe').html();
				updatePageDate(uploadId,pageId,epoch,pageNumber);
			}
		});
		
		<?
		foreach ($pagesDates as $key => $val) {
			if ($val > 0) {
			?>
				$("#datepicker_<?=$key;?>").datepicker('setDate', '<?=date('d/m/Y',$val);?>');
			<?
			}
		}
		?>
	
	
	
	  });
	  
	  function updatePageDate(uploadId,pageId,epoch,pageNumber) {
		$.ajax({
			  type: "POST",
			  url: "ajax.php",
			  data: { type: "date", uploadId: uploadId, pageId: pageId, epoch: epoch }
			})
		  .done(function( msg ) {
			if (msg == '1') {
				notify('תאריך עודכן בהצלחה לעמוד '+pageNumber,'success',2000,'topLeft');
			}
			else {
				notify('שגיאה','error',2000,'topLeft');
			}
		  });
	  }
	  
	  


</script>