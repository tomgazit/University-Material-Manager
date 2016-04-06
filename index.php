<?
//phpinfo();
if ($_GET['lang'] == 'english') {
	include 'english.php';
}
else {
	include 'hebrew.php';
}
?>
<html>
<head>
	<title>בנק הסריקות</title>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

<link rel="stylesheet" href="themes/fontawesome-stars.css">
<script src="js/jquery.barrating.js"></script>


<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<!---<link rel="stylesheet" type="text/css" href="css/uploadify.css" />
<script type="text/javascript" src="js/jquery.uploadify.min.js"></script>------->
<script type="text/javascript" src="js/bootstrap-typeahead.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>



  
  <script type="text/javascript" src="js/noty/packaged/jquery.noty.packaged.min.js"></script>
  <script src="js/main.js"></script>
  <link rel="stylesheet" type="text/css" href="css/animate.css" />
<script src="js/jquery.shadow.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery.shadow.css">

 <script src="js/jquery-ui/datepicker-he.js"></script>
 <script src="js/jquery.pulse.min.js"></script>
 
 
<link rel="stylesheet" href="css/main.php?lang_dir=<?=$lang_dir;?>">


<script src="js/jquery-file-upload/vendor/jquery.ui.widget.js"></script>
<script src="js/jquery-file-upload/jquery.iframe-transport.js"></script>
<script src="js/jquery-file-upload/jquery.fileupload.js"></script>

<script src="js/jquery.lazyload.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>




<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">



 <meta name="viewport" content="width=device-width, initial-scale=0.75, user-scalable=0">
 </head>
<body>



<?
include 'db.php';

if ($lang_dir == 'rtl') {
	?>
	<link rel="stylesheet" href="css/bootstrap.rtl.min.css">
	<?
}
?>

<script>
$(document).ready(function() {
	refreshTooltips();
});
</script>

<style>

</style>

<center>

<div class="page-header" style="margin-top: 5px;">
  <h2>
  בנק הסריקות <a href="https://www.facebook.com/tomgazit"><img src="/images/facebook-icon.png" style="vertical-align: middle;"/></a>
  </h2>
</div>
	
	<div style="display: <?=$user_id>0?'block':'none';?>; margin-top: 10px;" class="loginDetails">
				<span class="glyphicon glyphicon-user"></span> <?=$lang['connectedAs'];?><span id="myName"><?=$user_name;?></span> (<span style="color: red; cursor: pointer;" id="logout"><?=$lang['disconnect'];?></span>)
			</div>
	
	<div id="indexTabs">
		<ul class="nav nav-tabs" data-tabs="tabs" style="direction: <?=$lang_dir;?>;">
			<li class="active" id="searchBtn"><a data-toggle="tab" href="#search"><span class="glyphicon glyphicon-search"></span> <?=$lang['search'];?></a></li>
			
			
			<li class="loginLi" style="display: <?=$user_id>0?'none':'block';?>;"><a data-toggle="tab" href="#login"><span class="glyphicon glyphicon-user" style="vertical-align: text-top;"></span> <?=$lang['login'];?></a></li>
			
			<li class="registerLi" style="display: <?=$user_id>0?'none':'block';?>;"><a data-toggle="tab" href="#register"><span class="glyphicon glyphicon-edit" style="vertical-align: text-top;"></span> <?=$lang['registration'];?></a></li>
			
			<li id="uploadFileTab" style="display: <?=$user_id>0?'block':'none';?>;"><a href="#uploadFile" data-toggle="tab"><span class="glyphicon glyphicon-plus" style="vertical-align: text-top;"></span> <?=$lang['uploadAFile'];?></a></li>
             
			<li id="listPanelTab" style="display: <?=$user_id>0?'block':'none';?>;"><a href="#listPanel" data-toggle="tab"><span class="glyphicon glyphicon-list gly-rotate-180" style="vertical-align: text-top;"></span> <?=$lang['listAdmin'];?></a></li>
			
			<li id="statsTab" style="display: <?=$user_id==1?'block':'none';?>;"><a href="#stats" data-toggle="tab"><span class="glyphicon glyphicon-stats" style="vertical-align: text-top;"></span> סטטיסטיקות</a></li>
			
			<?
			//if user == 1 show stats.php TAB
			?>
			
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="search">
				
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-5 col-xs-10">
					  <input type="text" class="form-control" id="str" style="margin-bottom: 10px;" placeholder="<?=$lang['tb_searchName'];?>..">
					</div>
					<div class="col-md-1 col-xs-2">
						<img src="images/load.gif" id="searchLoader" style="display: none; margin-top: 4px; margin-right: 6px;"/>
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-md-12 col-xs-12">
					  <div class="scroller_anchor"></div>
					  <div id="searchResults" style="margin-top: 5px;">
					  
					  </div>
					</div>
				  </div>
			
			</div>
			<div class="tab-pane fade" id="listPanel">
				<form class="form-horizontal" role="form" id="listForm">
				<div class="row" style="margin-top: 10px;">
				  <div class="col-md-12" id="listPanelTableDiv">
					  
					</div>
				</div>
				</form>
			</div>

			<div class="tab-pane fade" id="stats">
				<form class="form-horizontal" role="form" id="statsForm">
				<div class="row" style="margin-top: 10px;">
				  <div class="col-md-12" id="statsDiv">
					  
					</div>
				</div>
				</form>
			</div>

			<div class="tab-pane fade" id="uploadFile">
			 <center><h1 style="margin-top: 0;"><?=$lang['uploadAFile'];?></h1></center>
			<img src="images/load.gif" style="display: none;"/>
			<img src="images/pages.gif" style="display: none;"/>
			<form class="form-horizontal" role="form" id="uploadFormMain">

					<div class="form-group fileUploadDiv">
						<label for="inputFile" class="col-md-1 col-xs-4 control-label"><?=$lang['file'];?>:</label>
						<div class="col-md-5 col-xs-8 margin-bottom">
<!---						   <input type="file" name="file_upload" id="file_upload" />-->
						   
							   <span class="btn btn-success fileinput-button" id="uploadBtnCont">
								<span><?=$lang['chooseAFile'];?> <span class="glyphicon glyphicon-plus"></span></span>
								<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload" type="file" name="files" multiple>
							  </span>
							  
							  
							
							<div id="files" class="files" style="margin-top: 5px;"></div>

							<!-- The global progress bar -->
							  <div id="progress" style="display: none; margin-top: 5px;" class="progress progress-striped">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
							</div>
							  
							</div>

					</div>
					
					
					
					 <div class="form-group" id="form_elementsURL">
						<label for="inputExt" class="col-md-1 col-sm-2 col-xs-4 control-label extUrl">URL:</label>
						<div class="col-md-3 col-sm-10 col-xs-8 margin-bottom extUrl">
							<div id="scrollable-dropdown-menu">
							  <input type="text" autocomplete="off" class="form-control typeahead phLTR" style="direction: ltr;" name="inputExt" id="inputExt" placeholder="http://...">
							  <input type="hidden" name="type" value="uploadURL"/>
							</div>
						</div>
					</div>
					<div class="form-group" id="form_elements">
						<label for="inputDept" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['department'];?>:</label>
						<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
							<div id="scrollable-dropdown-menu">
							  <input type="text" autocomplete="off" class="form-control typeahead" name="inputDept" id="inputDept" placeholder="<?=$lang['tb_department'];?>..">
							</div>
						</div>
						
						<label for="inputCourse" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['course'];?>:</label>
						<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
						  <input type="text" autocomplete="off" class="form-control typeahead" name="inputCourse" id="inputCourse" placeholder="<?=$lang['course'];?>..">
						</div>
						
						<label for="inputTeacher" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['lecturerEx'];?>:</label>
						<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
						  <input type="text" autocomplete="off" class="form-control typeahead" name="inputTeacher" id="inputTeacher" placeholder="<?=$lang['tb_lecturerEx'];?>">
						</div>
				  
					
					
					<label for="filetype" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['type'];?>:</label>
					<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
						<select class="form-control" name="filetype" id="filetype">
						  <option value="1"><?=$lang['tb_lectures'];?></option>
						  <option value="2"><?=$lang['tb_exs'];?></option>
						  <option value="3"><?=$lang['tb_lecturesANDEx'];?></option>
						  <option value="4"><?=$lang['tb_sheets'];?></option>
						  <option value="5"><?=$lang['tb_else'];?></option>
						</select>
					</div>
				 
					<label for="inputStudyYear" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['studyYear'];?>:</label>
					<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
						<select class="form-control" name="inputStudyYear" id="inputStudyYear">
						  <option value="1"><?=$lang['year1'];?></option>
						  <option value="2"><?=$lang['year2'];?></option>
						  <option value="3"><?=$lang['year3'];?></option>
						  <option value="4"><?=$lang['year4'];?></option>
						</select>
					</div>

				 	<label for="filetype" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['semester'];?>:</label>
					<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
					  <select class="form-control" name="inputSemester" id="inputSemester">
						  <option value="1"><?=$lang['semester1'];?></option>
						  <option value="2"><?=$lang['semester2'];?></option>
						  <option value="3"><?=$lang['semester3'];?></option>
						</select>
				    </div>
				 
					 <label for="inputWrittenYear" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['writeYear'];?>:</label>
					<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
					  <input type="text" autocomplete="off" class="form-control" name="inputWrittenYear" id="inputWrittenYear" placeholder="תרפ''א / תרפ''ט">
					</div>

					 <label for="inputContName" class="col-md-1 col-sm-2 col-xs-4 control-label"><?=$lang['contributer'];?>:</label>
					<div class="col-md-3 col-sm-4 col-xs-8 margin-bottom">
					  <input type="text" autocomplete="off" class="form-control" name="inputContName" id="inputContName" placeholder="<?=$lang['contributerName'];?>" value="<?=$user_name;?>">
					</div>
				  </div>
				  
				   <div class="form-group">
					<div class="col-md-offset-1 col-md-11 col-sm-offset-2 col-xs-offset-4">
					<div id="uploadBtnContainer">
					
					</div>
					  <button id="uploadBtn" class="btn btn-default"><?=$lang['upload'];?></button>
					</div>
				  </div>
				 
				  
				</form>
				
				
				 
				  <script>
					var tmpFileName='';
					
					$('#fileupload').fileupload({
						url: 'upload.php',
						dataType: 'json',
						autoUpload: false,
						add: function (e, data) {
						
							maxFileSize=200; //MB
							fileSizeMB=parseFloat(data.originalFiles[0]['size'])/1024/1000;
							var uploadErrors = [];
							var acceptFileTypes = /(\.|\/)(pdf|word|msword)/i; //msword = .doc  |  word = .docx
							if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
								uploadErrors.push('סוג הקובץ <b>'+data.originalFiles[0]['type']+'</b> אינו נתמך במערכת');
							}
							if(fileSizeMB > maxFileSize) {
								uploadErrors.push('קובץ גדול מדי<br/>ישנו מקסימום של '+maxFileSize+'MB');
							}
							if(uploadErrors.length > 0) {
								notify(uploadErrors.join("<br/><br/>"),'error',60000);
							} else {
								
								//$('.extUrl').slideUp();
								
								$('#inputExt').attr('disabled','disabled');
								
								$.each(data.files, function (index, file) {
									$('#files').html('<button type="button" class="btn btn-danger btn-xs removeFileBtn" id="removeFileBtn">הסר קובץ</button> ');
									$('#files').append(file.name);
									tmpFileName=file.name;
								});
								
								
								data.context = $('#uploadBtn').unbind('click').click(function () {
								  $('#uploadBtn').html('אנא המתן <img src="images/load.gif"/>').attr('disabled','disabled');
									$('#progress').fadeIn();
									$('#inputExt').html('');
									data.submit();
									return false;
								});
							}
							
							
						},
						done: function (e, data) {							
							$('#files').html('');
								if (data.result === 0) {
									notify('שגיאה! הקובץ<br/>'+tmpFileName+'<br/>לא הועלה בהצלחה :(<br/><br/>נסה לדחוס את הקובץ לפני ההעלאה באמצעות:<br/><a href="http://smallpdf.com/compress-pdf" target="_blank">אתר דחיסה</a>','error',60000);
								}
								else {
									notify('הקובץ<br/>'+tmpFileName+'<br/>הועלה בהצלחה','success',5000);
								}
							$('#progress').fadeOut(function() {
								$('#uploadBtnCont').removeAttr('disabled').fadeIn();
							});
							
							$('#uploadBtn').html('העלה קובץ').removeAttr('disabled');
						},
						progressall: function (e, data) {
							var progress = parseInt(data.loaded / data.total * 100, 10);
							$('#progress .progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
							if (progress == 100) {
								console.log('done!!');
								$('#uploadBtn').html('מפצל PDF לעמודים.. <img src="images/pages.gif"/>');
							}
						}
					}).on('fileuploadadd', function (e, data) {
						
					}).on('fileuploadstart', function (e) {
						$('#uploadBtnCont').hide().attr('disabled','disabled');
					});
					
					$(document).on('click','#removeFileBtn',function() {
						$('#inputExt').removeAttr('disabled');
						$('#files').html('');
						$('#uploadBtn').unbind('click').click(function () {
							submitData();
							return false;
						});
						//$('.extUrl').slideDown();
					});
					
					$(document).on('click','#uploadBtn',function() {
						submitData();
						return false;
					});
					
					function submitData() {
						$.ajax({
							type: "POST",
							url: "upload.php",
							data: $('#uploadFormMain').serialize(),
							success: function(data){
								var js = JSON.parse(data);
								if (js.result === 1) {
									//notify('שגיאה! הקובץ<br/>'+tmpFileName+'<br/>לא הועלה בהצלחה :(<br/><br/>נסה לדחוס את הקובץ לפני ההעלאה באמצעות:<br/><a href="http://smallpdf.com/compress-pdf" target="_blank">אתר דחיסה</a>','error',60000);
									notify('רשומה עודכנה בהצלחה!','success',5000);
								}
								else {
									
								}
							},
							error: function(){
								notify("failure",'error');
								$('#loginBtn').html('התחבר').removeAttr('disabled');
							}
						});
						
					}
					
					$(document).on('keyup','#inputExt',function() {
						if ($(this).val().length === 0) {
							//$('.fileUploadDiv').slideDown();
							$('#uploadBtnCont').removeAttr('disabled');
							$('#inputExt').parent().parent().removeClass('col-md-7').addClass('col-md-3');
						}
						else {
							//$('.fileUploadDiv').slideUp();
							$('#uploadBtnCont').attr('disabled','disabled');
							$('#inputExt').parent().parent().removeClass('col-md-3').addClass('col-md-7');
						}
					});
				</script>
				
				  
			</div>
			<div class="tab-pane fade" id="login">
				<center><h1 style="margin-top: 0;">התחברות</h1></center>
				<form class="form-horizontal" role="form" id="loginForm">
				  <div class="form-group">
				 
				  
					 <label for="inputEmail" class="col-md-1 col-xs-3 control-label">אימייל:</label>
					<div class="col-md-3 col-xs-9 margin-bottom">
					  <input type="email" class="form-control" id="inputEmail" style="direction: ltr;" placeholder="אימייל">
					</div>
					
				  </div>

				  <div class="form-group">
					<label for="inputPassword" class="col-md-1 col-xs-3 control-label">סיסמה:</label>
					<div class="col-md-3 col-xs-9 margin-bottom">
					  <input type="password" class="form-control" id="inputPassword" style="direction: ltr;" placeholder="סיסמה">
					</div>
					
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-1 col-md-11 col-xs-offset-3">
					  <button type="submit" id="loginBtn" class="btn btn-default">התחבר</button>
					</div>
				  </div>
				</form>
			</div>
			<div class="tab-pane fade" id="register">
				<center><h1 style="margin-top: 0;">הרשמה</h1></center>
				<form class="form-horizontal" role="form" id="registerForm">
				  <div class="form-group">
					
					 <label for="inputName" class="col-md-1 col-xs-3 control-label">שם מלא:</label>
					<div class="col-md-3 col-xs-9 margin-bottom">
					  <input type="text" class="form-control" id="inputName" placeholder="שם מלא">
					</div>
				  </div>
				   <div class="form-group">
				   	<label for="inputEmail" class="col-md-1 col-xs-3 control-label">אימייל:</label>
				  <div class="col-md-3 col-xs-9 margin-bottom">
					  <input type="email" class="form-control" id="inputEmail" style="direction: ltr;" placeholder="אימייל">
					</div>
					
				   </div>
				  <div class="form-group">
				  	<label for="inputPassword" class="col-md-1 col-xs-3 control-label">סיסמה:</label>
				  <div class="col-md-3 col-xs-9 margin-bottom">
					  <input type="password" class="form-control" id="inputPassword" style="direction: ltr;" placeholder="סיסמה">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-1 col-md-11 col-xs-offset-3">
					  <button type="submit" id="registerBtn" class="btn btn-default">הרשם</button>
					</div>
				  </div>
				  
				</form>
			</div>
		</div>
	</div>
</center>

<script type="text/javascript">

$('.uploadPages').click(function() {
	return false;
});

$("#loginBtn").click(function(){
	$('#loginBtn').html('אנא המתן.. <img src="images/load.gif"/>').attr('disabled','disabled');
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: {type: 'login', email: $('#loginForm #inputEmail').val(), password: $('#loginForm #inputPassword').val()},
		success: function(data){
			var js = JSON.parse(data);
			if (js.ok == 1) {
				notify('התחברת בהצלחה','success');
				
				$('#myName').html(js.name);
				$('.registerLi, .loginLi').fadeOut(function() {
					$('#uploadFileTab ,#listPanelTab, .loginDetails').fadeIn();
					if (js.id == 1) {
						$('#statsTab').fadeIn();
					}
				});
				
				$('#listPanelTab a').trigger('click');
			}
			else {
				notify('שגיאה: אנא נסה שנית','error');
			}
			$('#loginBtn').html('התחבר').removeAttr('disabled');
		},
		error: function(){
			notify("failure",'error');
			$('#loginBtn').html('התחבר').removeAttr('disabled');
		}
	});
	return false;
});

$("#registerBtn").click(function(){

	$('#registerBtn').html('אנא המתן.. <img src="images/load.gif"/>').attr('disabled','disabled');
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: {type: 'register', name: $('#registerForm #inputName').val(),email: $('#registerForm #inputEmail').val(), password: $('#registerForm #inputPassword').val()},
		success: function(data){
			if (data == '1') {
				notify('אימייל זה כבר קיים במערכת','alert');
			}
			else if (data == '2') {
				notify('נרשמת בהצלחה!<br>קישור הפעלה נשלח לאימייל שלך :)','success');
			}
			else if (data == '3') {
				notify('אימייל אינו תקין','warning');
			}
			else {
				notify('נא השתמש באימייל של חברה מוכרת','alert');
			}
			$('#registerBtn').html('הרשם').removeAttr('disabled');
		},
		error: function(){
			notify("failure",'error');
			$('#registerBtn').html('הרשם').removeAttr('disabled');
		}
	});
	return false;
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  if ($(e.target).attr('href') == '#search') {
	$('#str').focus();
  }
});

$(document).ready(function() {

$('#str').focus();
	
<?
if (isset($_GET['email']) && isset($_GET['code'])) {
	$email = mysql_real_escape_string($_GET['email']);
	$code = mysql_real_escape_string($_GET['code']);
	$sql = mysql_query('select id from users where email=\''.$email.'\' and code=\''.$code.'\' and verified=0');
	$row = mysql_fetch_assoc($sql);
	$id = $row['id'];
	if ($id > 0) {
		mysql_query('update users set verified=1 where id='.$id);
		?>
		notify('הפעלת את חשבונך בהצלחה!','success');
		<?
	}
	else {
		?>
		notify('אימייל כבר הופעל במערכת','alert');
		<?
	}
	
}
?>
});

$('#inputDept').typeahead({
    ajax: {
		url: 'ajax.php?type=list&tbl=departments',
		loadingClass: "loading-circle"
	},
	onSelect: function(item) {
		$('#inputDeptId').val(item.value);
        return item;
    }
});

$('#inputCourse').typeahead({
    ajax: {
		url: 'ajax.php?type=list&tbl=courses',
		loadingClass: "loading-circle"
	},
	onSelect: function(item) {
		$('#inputCourseId').val(item.value);
        return item;
    }
});
 
$('#inputTeacher').typeahead({
    ajax: {
		url: 'ajax.php?type=list&tbl=teachers',
		loadingClass: "loading-circle"
	},
	onSelect: function(item) {
		$('#inputTeacherId').val(item.value);
        return item;
    }
});

$(document).on('click','#listPanelTab',function() {
	//var ref = $(this).attr('href').replace('#','');
	loadTables();
});

$(document).on('click','#statsTab',function() {
	//var ref = $(this).attr('href').replace('#','');
	loadStats();
});

function loadStats() {
	$('#statsDiv').load('stats.php');
}


$(document).ready(function() {
	
	
	
	
});

var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$(document).on('keyup','#str',function() {
    
	$('#searchLoader').hide();
	if ($('#str').val().length > 0) {
		$('#searchLoader').show();
	}
	delay(function(){
		if ($('#str').val().length > 0) {
			  
			  $.ajax({
				type: "POST",
				url: "search.php",
				data: {search: $('#str').val()},
				success: function(data){
					$('#searchLoader').fadeOut(200);
					$('#searchResults').html(data);
					refreshTooltips();
				},
				error: function(){
					$('#searchLoader').fadeOut(200);
					notify("failure",'error');
					//$('#registerBtn').html('הרשם').removeAttr('disabled');
				}
			});
		}
    }, 1000 );
	
	
});

$(document).on('click','.percentBtn',function() {
	var id = $(this).attr('id').replace('percent_','');
	$( "#iframeInModal" ).load( "iframe.php?id="+id, function() {
		$('#largeModal').modal('show');
		refreshTooltips();
	});
});

$(document).on('hide.bs.modal','#largeModal', function () {
  loadTables();
});

$(document).on('click','#editBtn',function() {
	//var id = $(this).attr('id').replace('percent_','');
	$('#editBtn').html('אנא המתן <img src="images/load.gif"/>').attr('disabled','disabled');
	
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: $('#EditModalForm').serialize(),
		success: function(data){
			var js = JSON.parse(data);
			if (js.status === 1) {
				notify('רשומה נערכה בהצלחה','success',5000);
				$('#largeModalEdit').modal('hide');
				loadTables();
			}
			else {
				notify('שגיאה - בעיה בטעינת הנתונים','error',5000);
			}
			$('#editBtn').html('ערוך').removeAttr('disabled');
		},
		error: function(){
			notify("failure",'error');
			$('#editBtn').html('ערוך').removeAttr('disabled');
		}
	});
	
	return false;
});



$(document).on('click','.editAllId',function() {
	var id = $(this).attr('id').replace('editAllId_','');
	$('#EditModalDivLoad').show();
	$('#EditModalDiv').hide();
	$('#largeModalEdit').modal('show');
	 $.ajax({
				type: "POST",
				url: "ajax.php",
				data: {type: 'getRowDataEdit', uploadId: id},
				success: function(data){
					var js = JSON.parse(data);
					
					if (js.status === 1) {
					
						$('#EditModalDivLoad').hide();
						$('#EditModalDiv').show();
		
						$('#EditModalDiv').html($('#form_elementsURL').clone());
						if (js['inputExt'].length > 0) {
							$('#EditModalDiv').append($('#form_elements').clone());
						}
						else {
							$('#EditModalDiv').html($('#form_elements').clone());
						}
						
						
						$('#EditModalDiv').append('<div class="form-group"><div class="col-md-offset-1 col-md-11 col-sm-offset-2 col-xs-offset-4"><input type="hidden" name="editId" id="editId" value=""/><input type="hidden" name="type" id="type" value=""/><button type="submit" id="editBtn" class="btn btn-success">ערוך</button></div></div>');
						
						$.each($('#largeModalEdit .modal-body input, #largeModalEdit .modal-body select'),function(i) {
							$(this).val(js[$(this).attr('id')]);
							$(this).attr('id',$(this).attr('id')+'_edit');
							$(this).attr('name',$(this).attr('name')+'_edit');
						});
						
						$('#type_edit').attr('name','type').attr('id','type').val('editRow');
						$('#editId_edit').attr('name','editId').attr('id','editId');
						
						$('#inputDept_edit').typeahead({
							ajax: {
								url: 'ajax.php?type=list&tbl=departments',
								loadingClass: "loading-circle"
							}
						});

						$('#inputCourse_edit').typeahead({
							ajax: {
								url: 'ajax.php?type=list&tbl=courses',
								loadingClass: "loading-circle"
							}
						});
						 
						$('#inputTeacher_edit').typeahead({
							ajax: {
								url: 'ajax.php?type=list&tbl=teachers',
								loadingClass: "loading-circle"
							}
						});
					}
					else {
						notify('שגיאה - בעיה בטעינת הנתונים','error',5000);
						$('#largeModalEdit').modal('hide');
					}
	
				},
				error: function(){
					$('#searchLoader').fadeOut(200);
					notify("failure",'error');
					//$('#registerBtn').html('הרשם').removeAttr('disabled');
				}
			});
			
	
});

var courseName='';
var curUpload='';
function loadTables() {
	$( "#listPanelTableDiv" ).html('<center><img src="images/ajaxload.gif"/></center>');
	$( "#listPanelTableDiv" ).load( "listPanel.php", function() {
		
		$.each($('.percentBtn'),function() {
		
			if ($(this).html().indexOf('-') > -1) {
				$(this).attr('disabled','disabled').html('קובץ חיצוני');
			}
		});
		
		refreshTooltips();

				//UPLOAD PAGES
				$('.uploadPages').fileupload({
						url: 'upload.php',
						dataType: 'json',
						autoUpload: false,
						done: function (e, data) {
								if (data.result === 0) {
									notify('שגיאה! הקובץ<br/>'+tmpFileName+'<br/>לא הועלה בהצלחה :(<br/><br/>נסה לדחוס את הקובץ לפני ההעלאה באמצעות:<br/><a href="http://smallpdf.com/compress-pdf" target="_blank">אתר דחיסה</a>','error',60000);
								}
								else {
									notify('הקובץ<br/>'+tmpFileName+'<br/>הועלה בהצלחה','success',5000);
									loadTables();
								}
							$(this).parent().parent().find('.progress').fadeOut(function() {
								$(this).parent().removeAttr('disabled').fadeIn();
							});
							
						},
						progressall: function (e, data) {
							var progress = parseInt(data.loaded / data.total * 100, 10);
							$(this).parent().parent().find('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
							console.log("progress: " + progress);
						}
					}).on('fileuploadadd', function (e, data) {
					
					
						
						maxFileSize=200; //MB
							fileSizeMB=parseFloat(data.originalFiles[0]['size'])/1024/1000;
							var uploadErrors = [];
							var acceptFileTypes = /(\.|\/)(pdf|word|msword)/i; //msword = .doc  |  word = .docx
							if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
								uploadErrors.push('סוג הקובץ <b>'+data.originalFiles[0]['type']+'</b> אינו נתמך במערכת');
							}
							if(fileSizeMB > maxFileSize) {
								uploadErrors.push('קובץ גדול מדי<br/>ישנו מקסימום של '+maxFileSize+'MB');
							}
							if(uploadErrors.length > 0) {
								notify(uploadErrors.join("<br/><br/>"),'error',60000);
							} else {
								$.each(data.files, function (index, file) {
									tmpFileName=file.name;
								});
						
								
							data.submit();
							$(this).parent().hide().attr('disabled','disabled');
							$(this).parent().parent().find('.progress').fadeIn();
						}
					});
					


		
	});
}

var initDP=false;

var modalId=0;
$(document).on('click','.uploadRow',function() {
	var id = $(this).attr('id').replace('row_','');
	var extUrl = $(this).find('.extUrl').val();
	var contName = $(this).find('.contName').val();
	var extUnique = $(this).find('.extUnique').val();
	var extAll = $(this).find('.extAll').val();
	var rating = $(this).find('.ratingNum').html();
	
	modalId=id;
	$('#modalUploadId').html(id);
	$('#modalUploadExtUrl').html(extUrl);
	$('#urlData').html('<br/>נתרם ע"י: <b>'+contName+'</b>');
	$('#views').html('צפיות: <b>'+extAll+'</b>');
	
	
	var ratingHtml = "";
	for (i=1;i<=rating;i++) {		
		ratingHtml += '<i class="icon-star" style="color: #ffdf88; font-size: 25px; vertical-align: sub; margin: 0 1px 0 1px;"></i>';
	}
	for (i=rating;i<5;i++) {
		ratingHtml += '<i class="icon-star" style="color: #dddddd; font-size: 25px; vertical-align: sub; margin: 0 1px 0 1px;"></i>';
	}
				
	$('#rating').html('דירוג הגולשים: '+ratingHtml);

				
	var course = $(this).find('.courseNameRow').html();
	$('#courseNameModal').html(course);
	
	var rating = '<select id="rating_'+id+'">'+
		  '<option value="1">1</option>'+
		  '<option value="2">2</option>'+
		  '<option value="3">3</option>'+
		  '<option value="4">4</option>'+
		  '<option value="5">5</option>'+
		'</select>';
	$('#ratingModal').html(rating);

	
	
	var catalogPer = $(this).find('.catalogPerRow').html();
	$('#catalogPer').html(catalogPer);
	
	$('#uploadModalDiv').hide();
	$('#uploadModalDivLoad').show();
	
	$('#myModal').modal('show');
	
	$('#fullFileTab').trigger('click');
	
	if (extUrl.length === 0) {
		
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: {type: 'getRowData', uploadId: id},
			success: function(data){
				var rows = jQuery.parseJSON( data );
				$('#uniqueDateTab').show();
				$('#uploadModalDivLoad').hide();
				$('#uploadModalDiv').show();
				$('#openURLBtn').hide();
				$('#downloadAllBtn').show();
				$('#showAllBtn').show();
				$('#catalogHTML').show();
				$('#uploadFileSize').html('גודל הקובץ כ-<b>'+rows.filesize+'</b>');
				
				$('#rating_'+id).barrating({
					initialRating: rows.rating,
					//initialRating: 6,
					//showValues: true,
					reverse: true,
					theme: 'fontawesome-stars',
					
					
					
					onSelect: function(value, text, event) {
						if (typeof(event) !== 'undefined') {
						  // rating was selected by a user
						  ratingVal = $(event.target).attr('data-rating-value');
							  $.ajax({
								type: "POST",
								url: "ajax.php",
								data: {type: 'rating', uploadid: id, rating: ratingVal},
								success: function(data){
									//$('.loginLi a').trigger('click');
									//$('#uploadFileTab, #listPanelTab, .loginDetails').fadeOut(function() {
									//	$('.registerLi, .loginLi').fadeIn();
									//});
									notify('דירוג התקבל בהצלחה','success',3000);
								},
								error: function(){
									//$('#searchLoader').fadeOut(200);
									notify("failure",'error');
								}
							});
						} else {
						  // rating was selected programmatically
						  // by calling `set` method
						}
					}
					
					
					
				  });	
				
				
				if (initDP) {
					$('#uniDate').datepicker('destroy');
				}
				initDP=true;
				$('#uniDate').datepicker({
					regional: 'he',
					dateFormat: 'dd/mm/y',
					defaultDate: $.datepicker.parseDate('@', rows.dates[rows.dates.length-1]*1000),
					beforeShowDay: function(date) {
					var epoch = $.datepicker.formatDate('@', date) / 1000;
					if (rows.dates.indexOf(epoch) > -1) {
						return [true, 'css-class-to-highlight', ''];
					  } 
					  return true;
				   },
				   onSelect: function(date) {
						var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
						$('#downloadDateBtn').hide().fadeIn(250).html('הורד את תאריך זה');
						$('#showDateBtn').hide().fadeIn(250).html('צפה בתאריך זה');
						$('#datesText').hide().fadeIn(250).html($(this).datepicker().val());
						//window.open('pdfAction.php?uploadId='+id+'&epoch='+epoch,'_self');
					}
				});
					
			
				
			},
			error: function(){
				notify("failure",'error');
				//$('#registerBtn').html('הרשם').removeAttr('disabled');
			}
		});
		
		}
		else {
			
			$('#uniqueDateTab').hide();
			$('#catalogHTML').hide();
			$('#uploadModalDivLoad').hide();
			$('#uploadModalDiv').show();
			$('#openURLBtn').show();
			$('#downloadAllBtn').hide();
			$('#showAllBtn').hide();
			$('#uploadFileSize').html('');
		}	
});
 
 $(document).on('click','#openURLBtn',function() {
	var url = $('#modalUploadExtUrl').html().replace(/&amp;/g, "&");
	window.open(url,'_blank');
 });
 
  $(document).on('click','#downloadAllBtn',function() {
	var id = $('#modalUploadId').html();
	window.open('pdfAction.php?uploadId='+id,'_blank');
 });
 
  $(document).on('click','#showAllBtn',function() {
	var id = $('#modalUploadId').html();
	window.open('pdfAction.php?uploadId='+id+'&show=1','_blank');
 });
 
$(document).on('click','#logout',function() {
	 $.ajax({
		type: "POST",
		url: "ajax.php",
		data: {type: 'logout'},
		success: function(data){
			$('.loginLi a').trigger('click');
			moreTxt='';
			if($('#statsTab:visible').length == 1) {
				moreTxt=', #statsTab';
			}

			$('#uploadFileTab, #listPanelTab, .loginDetails'+moreTxt).fadeOut(function() {
				$('.registerLi, .loginLi').fadeIn();
			});
			notify('התנתקת בהצלחה!','success',3000);
		},
		error: function(){
			//$('#searchLoader').fadeOut(200);
			notify("failure",'error');
		}
	});
 });
 
 
 //IFRAME
 $(document).on('mouseenter','.iframeDiv',function() {
	$(this).find('.removeIcon').fadeIn(100);
});

$(document).on('mouseleave','.iframeDiv',function() {
	$(this).find('.removeIcon').fadeOut(100);

});

$(document).on('click','.removeIcon',function() {
	var id=$(this).attr('id');
	$.ajax({
	  type: "POST",
	  url: "ajax.php",
	  data: { type: "removePage", removeData: id }
	})
  .done(function( msg ) {
	if (msg == '0') {
		notify('שגיאה','error',2000);
	}
	else {
		notify('דף נמחק','success',2000);
		loadTables();
		$('#pdf_'+msg).fadeOut(100);
	}
  });
});

$('.pdf').shadow('lifted');

$(document).on('click','.rightArrow',function() {
	curDate=$(this).closest('.pdf').find('.datepicker').val();
	if ($(this).closest('.pdf').next().length > 0) {
		var dp = $(this).closest('.pdf').next().find('.datepicker')
		dp.val(curDate);
		var epoch = $.datepicker.formatDate('@', $(dp).datepicker('getDate')) / 1000;
		var pageId = $(dp).attr('id').replace('datepicker_','');
		var pageNumber = $(dp).parent().find('.pageNumber').html();

		var uploadId = $('#uploadIdIframe').html();
		updatePageDate(uploadId,pageId,epoch,pageNumber);
	}
});
  
$(document).on('click','#showDateBtn',function() {
	var epoch = $.datepicker.formatDate('@', $('#uniDate').datepicker('getDate')) / 1000;
	window.open('pdfAction.php?uploadId='+modalId+'&epoch='+epoch+'&show=1','_blank');
});

$(document).on('click','#downloadDateBtn',function() {
	var epoch = $.datepicker.formatDate('@', $('#uniDate').datepicker('getDate')) / 1000;
	window.open('pdfAction.php?uploadId='+modalId+'&epoch='+epoch,'_self');
});

$(document).on('click','.deleteAllId',function() {
	var id = $(this).attr('id').replace('deleteAllId_','');
	$('#rowList_'+id).pulse({opacity: 0.5}, {duration : 500, pulses : 50});
	
	noty({
        text: '<b>האם אתה בטוח שברצונך למחוק את <span style="font-family: arial; color: red; font-weight: bolder;">כל הדפים</span> של השורה המהבהבת?</b>',
        type: 'confirm',
		theme: 'relax',
		layout: 'top',
        buttons: [
           {
               addClass: 'btn btn-danger', text: 'כן, מחק!', onClick: function ($noty) {
                   $noty.close();
                   $('#rowList_'+id).pulse('destroy');
				   $.ajax({
					  type: "POST",
					  url: "ajax.php",
					  data: { type: "deleteAll", removeData: id }
					})
				  .done(function( msg ) {
					
					if (msg == '0') {
						notify('שגיאה','error',2000);
					}
					else {
						notify('הרשומה נמחקה','success',2000);
						$('#rowList_'+id).fadeOut(500);
					}
				  });
				   
               }
           },
		   {
               addClass: 'btn btn-primary littleFix', text: 'לא, בטל', onClick: function ($noty) {
                   $noty.close();
				   $('#rowList_'+id).pulse('destroy');
               }
           }
           
        ]
    });
});
</script>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
	   <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span id="courseNameModal"></span> <span id="catalogHTML">(<span id="catalogPer"></span> מקוטלג)</span> <span id="ratingTextModal">- בחר דירוג: </span><span id="ratingModal"></span></h4>
      </div>
      <div class="modal-body">
       
     
	  <div id="uploadModalDivLoad" style="display: block;">
		<img src="images/load.gif"/> טוען..
	  </div>
	  <div id="uploadModalDiv">
		  <ul class="nav nav-tabs" data-tabs="tabs" style="direction: <?=$lang_dir;?>; margin-top: 0px;">
				<li class="active"><a data-toggle="tab" href="#all" id="fullFileTab"><span class="glyphicon glyphicon-ok"></span> כל הקובץ</a></li>
				<li id="uniqueDateTab"><a data-toggle="tab" href="#uni"><span class="glyphicon glyphicon-file"></span> בודדים לפי תאריך</a></li>
			</ul>
		  
		  <div class="tab-content">
				<div class="tab-pane fade in active" id="all">
					<br/>
					
					<button type="button" class="btn btn-primary btn-lg" id="openURLBtn">עבור אל הקובץ <span class="glyphicon glyphicon-link"></span></button>
					<button type="button" class="btn btn-success btn-lg" id="downloadAllBtn">הורד את הקובץ</button>
					<button type="button" class="btn btn-success btn-lg" id="showAllBtn">צפה בקובץ</button>
					
					<div id="urlData"></div>
					<div id="views" style="margin-top: 5px;"></div>
					<div id="rating" style="margin-top: 5px;"></div>
					<div id="uploadFileSize" style="margin-top: 5px;"></div>
					
					<div style="display: none;" id="modalUploadId"></div>
					<div style="display: none;" id="modalUploadExtUrl"></div>
				</div>
				<div class="tab-pane fade" id="uni" style="overflow: auto; padding: 10px;">
					<div id="uniDate" style="float: right;"></div>
					<div style="text-align: center;">
						<span id="datesText" style="font-size: 35px;"></span>
						
						<br><br>
						<button type="button" style="display: none;" class="btn btn-success btn-lg" id="showDateBtn">צפה בקובץ</button>
						
						<br><br>
						<button type="button" style="display: none;" class="btn btn-success btn-lg" id="downloadDateBtn">הורד את הקובץ</button>
					</div>
				</div>
			</div>
		</div>
	   </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 1190px;">
    <div class="modal-content">
	
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">קיטלוג <span id="courseNameModal"></span></h4>
      </div>
      <div class="modal-body">
	  
		  <div id="iframeInModal" style="overflow:auto;">
		  
		  </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" id="largeModalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 95%;">
    <div class="modal-content">
	
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">עריכת רשומה</h4>
      </div>
      <div class="modal-body" style="overflow:auto; height: 50%;">
		  <div id="EditModalDivLoad" style="display: block;">
			<img src="images/load.gif"/> טוען..
		  </div>
		  <form id="EditModalForm">
			  <div id="EditModalDiv">
				
			  </div>
		  </form>
      </div>
    </div>
  </div>
</div>

<?
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(1||preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
?>
<script>
// This function will be executed when the user scrolls the page.
$(window).on('scroll',function(e) {
    // Get the position of the location where the scroller starts.
    var scroller_anchor = $(".scroller_anchor").offset().top;
     
    // Check if the user has scrolled and the current position is after the scroller start location and if its not already fixed at the top 
    if ($(this).scrollTop() >= scroller_anchor && $('.scroller').css('position') != 'fixed') 
    {    // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
        $('.scroller').css({
            'position': 'fixed',
            'top': '0px',
            'borderBottom': '1px solid black',
			'width': $('#searchResults').width(),
			'paddingTop': '5px'
        });
        // Changing the height of the scroller anchor to that of scroller so that there is no change in the overall height of the page.
        $('.scroller_anchor').css('height', '50px');
    } 
    else if ($(this).scrollTop() < scroller_anchor && $('.scroller').css('position') != 'relative') 
    {    // If the user has scrolled back to the location above the scroller anchor place it back into the content.
         
        // Change the height of the scroller anchor to 0 and now we will be adding the scroller back to the content.
        $('.scroller_anchor').css('height', '0px');
         
        // Change the CSS and put it back to its original position.
        $('.scroller').css({
            'position': 'relative',
			'paddingTop': '0px',
			'width': '100%',
			'borderBottom': '0px solid black'
        });
    }
});
</script>
<?}?>
</body>
</html>
