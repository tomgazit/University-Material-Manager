<?
header("Content-type: text/css");
$lang_dir=$_GET['lang_dir'];
?>
.phLTR:-moz-placeholder{direction: ltr; text-align: left !important;}.phLTR::-moz-placeholder{direction: ltr; text-align: left !important;}.phLTR:-ms-input-placeholder{direction: ltr; text-align: left !important;}.phLTR::-webkit-input-placeholder{direction: ltr; text-align: left !important;}

.loading-circle {
	background: url("../images/load.gif") no-repeat 2px 4px;
}

.glyphicon {
	font-size: 16px;
}

#myName {
	font-weight: bold;
}

iframe {
	border: none;
}

#ui-datepicker-div {
	z-index: 9999 !important;
}

.tt-dropdown-menu .tt-suggestion p {
	margin-bottom: 1px;
	padding: 3px;
}

.tt-dropdown-menu .tt-suggestion:hover,.tt-dropdown-menu .tt-cursor {
	background: #428BCA;
	cursor: pointer;
}

.tt-dropdown-menu .tt-suggestion {
	padding-<?=$lang_dir=='rtl'?'right':'left';?>: 5px;
}

.form-control::-webkit-input-placeholder { text-align: <?=$lang_dir=='rtl'?'right':'left';?>; }



#scrollable-dropdown-menu .tt-dropdown-menu {
  max-height: 150px;
  overflow-y: auto;
}

.tt-dropdown-menu {
z-index: 999999;
width: 222px;
margin-top: 12px;
padding: 8px 0;
background-color: #fff;
border: 1px solid #ccc;
border: 1px solid rgba(0, 0, 0, 0.2);
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.center {
	text-align: center;
}

.table-header td {
	font-weight: bold;
}


body {
	direction: <?=$lang_dir;?>;
}

.tab-pane {
	text-align: <?=$lang_dir=='rtl'?'right':'left';?>;
	direction: <?=$lang_dir;?>;
}

input {
	direction: <?=$lang_dir;?>;
}

li a {
	cursor: pointer !important;
}

.nav-tabs>li {
	float: <?=$lang_dir=='rtl'?'right':'left';?>;
}

#indexTabs .nav-tabs, #indexTabs .tab-content {
	width: 95%;
	padding-<?=$lang_dir=='rtl'?'right':'left';?>: 0;
}

.littleFix {
	margin-<?=$lang_dir=='rtl'?'right':'left';?>: 10px;
}

.noty_message {
	text-align: <?=$lang_dir=='rtl'?'right':'left';?> !important;
}

#adminTabs .nav-tabs, #adminTabs .tab-content {
	width: 800px;
	padding-<?=$lang_dir=='rtl'?'right':'left';?>: 0;
}

.nav-tabs {
	margin-top: 20px;
}



#loginForm {
	margin-top: 0;
}



.dropDownMenu {
	width: 100px;
	text-align: <?=$lang_dir=='rtl'?'right':'left';?>;
}

.dropdown-menu>li>a {
	text-align: <?=$lang_dir=='rtl'?'right':'left';?>;
}

.row {
	margin-bottom: 5px;
}

.imgDiv {
	float: <?=$lang_dir=='rtl'?'right':'left';?>;
	
}

.imgDiv img {
	width: 100px;
	margin: 5px;
	
}

#file_upload_logo object {
	left: 0;
}

.menuLink {
	margin: 0 5px 0 5px;
}

.ui-pnotify-title {
	height: 15px;
}

.margin-bottom {
	margin-bottom: 10px;
}

.form-horizontal .control-label, #largeModalEdit label {
	font-size: 13px;
}

.form-group {
	margin-bottom: 0px;
}

.gly-rotate-180 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
}

@media only screen and (max-device-width: 480px) {
	.uploadRow td, .listRow td {
		padding: 15px !important;
	}
}

.zoom:after {
	content: '';
	display: block;
	width: 33px;
	height: 33px;
	position: absolute;
	top: 0;
	<?=$lang_dir=='rtl'?'right':'left';?>: 0;
	background: url(../images/zoom.png);
}

.container{}
.test_content{}
.scroller_anchor{height:0px;}
.scroller{z-index:100; background: white;}
.ui-loader-default {display: none !important;}

#courseNameModal {
	float: right;
	margin-right: 10px;
}

#catalogHTML {
	float: right;
	margin-right: 10px;
}

#ratingModal,#ratingTextModal {
	float: right;
	margin-right: 10px;
}

.br-widget {
	padding-top: 4px;
	
}

.modal-header {
	height: 50px;
}