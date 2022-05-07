<!DOCTYPE html> <!-- The new doctype -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link rel="stylesheet" type="text/css" href='<?php echo Yii::app()->theme->baseUrl .'/css/font.css';?>'/>
		<link rel="stylesheet" type="text/css" href='<?php echo Yii::app()->theme->baseUrl .'/css/font_l.css';?>'/>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/cu_reset.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/cu_grid.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/cu_style.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/ui/winglobal/ui.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/ui/winglobal/portlet.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/ui/winglobal/jquery.ui.uniform.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/ui/winglobal/colors/jquery.ui.colors.default.css';?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/cu_forms.css';?>" />
		<!--[if lt IE 9]>
			<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl .'/css/cu_ie.css';?>" />
			<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/html5.js'; ?>" />
		<![endif]-->	

		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.min.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.cookie.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.tools.min.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.ui.min.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.uniform.min.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/global.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/selectivizr.js'; ?>" ></script>
		<!--[if lt IE 9]>
			<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .Yii::app()->theme->baseUrl .'/js/ie.js'; ?>" ></script>
		<![endif]-->	
				
		<script type="text/javascript"> 
		$(document).ready(function(){
		    $.tools.validator.fn("#username", function(input, value) {
		        return value!='Username' ? true : {     
		            en: "Please complete this mandatory field"
		        };
		    });
		    
		    $.tools.validator.fn("#password", function(input, value) {
		        return value!='Password' ? true : {     
		            en: "Please complete this mandatory field"
		        };
		    });
		
		    var form = $("#form").validator({ 
		    	position: 'bottom left', 
		    	offset: [5, 0],
		    	messageClass:'form-error',
		    	message: '<div><em/></div>' // em element is the arrow
		    }).attr('novalidate', 'novalidate');
		});
		</script>
		
		<style type = "text/css">
		    body{overflow: hidden;}
		    #container {position: absolute; top:50%; left:50%;}

		    #contentLog {width:800px; text-align:center; margin-left: -400px; height:50px; margin-top:-25px; line-height: 50px;}
		    #contentLog {font-family: "Helvetica", "Arial", sans-serif; font-size: 18px; color: black; text-shadow: 0px 1px 0px white; }
		</style> 
		<!-- LOADING SCRIPT END -->
    </head>
	<body class="login">
		<?php echo $content; ?>
	</body>
	</html>