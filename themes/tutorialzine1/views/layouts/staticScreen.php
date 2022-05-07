<!DOCTYPE html><html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo CHtml::encode($this->pageTitle); ?>!</title>
<?php 
	$tu = Yii::app()->theme->baseUrl;
	$cs = Yii::app()->getClientScript();

	$cs->registerCssFile($tu.'/css/font.css');
	$cs->registerCssFile($tu.'/css/font_l.css');
	$cs->registerCssFile($tu.'/css/cu_reset.css');
	$cs->registerCssFile($tu.'/css/cu_grid_' . Yii::app()->params['screen_resolution'] .'.css');
	$cs->registerCssFile($tu.'/css/cu_style.css');
	$cs->registerCssFile($tu.'/css/cu_elfinder.css');
	$cs->registerCssFile($tu.'/css/jquery.ui.datatables.css');
	$cs->registerCssFile($tu.'/css/jquery.slidernav.css');
	$cs->registerCssFile($tu.'/css/ui/winglobal/ui.css');
	$cs->registerCssFile($tu.'/css/ui/winglobal/portlet.css');
	$cs->registerCssFile($tu.'/css/ui/winglobal/jquery.ui.uniform.css');
	$cs->registerCssFile($tu.'/css/ui/winglobal/colors/jquery.ui.colors.default.css');
	$cs->registerCssFile($tu.'/css/cu_forms.css');
	$cs->registerCssFile($tu.'/css/cu_prettify.css');
	$cs->registerCssFile($tu.'/css/anim.css');
	$cs->registerCssFile($tu.'/css/jquery.time.slider.css');
	$cs->registerCssFile($tu.'/css/table_style.css');
	
?>
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href='<?php echo Yii::app()->theme->baseUrl .'/css/cu_ie.css';?>'/>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/html5.js'; ?>" ></script>
	<![endif]-->
<?php
		$cs->registerScriptFile($tu.'/js/jquery.min.js');
		$cs->registerScriptFile($tu.'/js/jquery.selectors.js');
		$cs->registerScriptFile($tu.'/js/jquery.easing.js');
		$cs->registerScriptFile($tu.'/js/jquery.cookie.js');
		$cs->registerScriptFile($tu.'/js/jquery.hoverIntent.js');
		$cs->registerScriptFile($tu.'/js/jquery.tools.min.js');
		$cs->registerScriptFile($tu.'/js/overlay.apple.js');

		$cs->registerScriptFile($tu.'/js/jquery.ui.min.js');
		$cs->registerScriptFile($tu.'/js/jquery.uniform.min.js');
		$cs->registerScriptFile($tu.'/js/jquery.dataTables.min.js');
		$cs->registerScriptFile($tu.'/js/jquery.slidernav.js');
		$cs->registerScriptFile($tu.'/js/jquery.isotope.min.js');
		$cs->registerScriptFile($tu.'/js/jquery.supersubs.js');
		$cs->registerScriptFile($tu.'/js/jquery.elfinder.full.js');
		$cs->registerScriptFile($tu.'/js/prettify/prettify.js');
		$cs->registerScriptFile($tu.'/js/global.js');
		$cs->registerScriptFile($tu.'/js/selectivizr.js');
		$cs->registerScriptFile($tu.'/js/jquery.time.slider.js');
?>
	<!--[if lt IE 8]>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/ie.js'; ?>" ></script>
	<![endif]-->	
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/selectivizr.js'; ?>" ></script>
	<![endif]-->	
	<!-- LOADING SCRIPT -->
    <?php
    if( (Yii::app()->controller->getAction()->getId() == "dash") )
    {
	    if(isset($_REQUEST['refTime']) && ($_REQUEST['refTime'] > 30))
	    {
	    	$refTime = $_REQUEST['refTime'];
			
			echo '
				<script type="text/javascript">
				function ReloadPage() { 
				   location.reload();
				};
				
				$(document).ready(function() {
				  setTimeout("ReloadPage()", '. $refTime .'000);
				});
				</script>';
	    }
	    else
	    {
			echo '
				<script type="text/javascript">
				function ReloadPage() { 
				   location.reload();
				};
				
				$(document).ready(function() {
				  setTimeout("ReloadPage()", 90000);
				});
				</script>';
	    }
	}
    ?>

	<script type="text/javascript">
	$(window).load(function(){		
	    $("#loading").fadeOut(function(){
			$(this).remove();
			$('body').removeAttr('style');
	    });
	    $("nav").removeClass('collapsed');
	});
	</script>
	
	<style type = "text/css">
	#container {position: absolute; top:50%; left:50%;}
	#contentLoad {width:800px; text-align:center; margin-left: -400px; height:50px; margin-top:-25px; line-height: 50px;}
	#contentLoad {font-family: "Helvetica", "Arial", sans-serif; font-size: 18px; color: black; text-shadow: 0px 1px 0px white; }
	#loadinggraphic {margin-right: 0.2em; margin-bottom:-2px;}
	#loading {background-color: transparent; overflow:hidden; width:100%; height:100%; position: absolute; top: 0; left: 0; z-index: 9999;}
	</style> 
	<!-- LOADING SCRIPT END -->
	<script type="text/javascript">
		$(document).ready(function() {
			var mId = <?php echo'"'. Yii::app()->controller->id .'"';?>;                       //Old..returns dash everytime..
			
			//var lId = <?php if ((Yii::app()->controller->id =="dash")&&(Yii::app()->controller->getAction()->getId() =="create")) echo'"'. Yii::app()->controller->getAction()->getId() .'"'; else echo "mId"; ?>;
			
			//Abhinandan. July3rd 2013: Set the appropriate '<li>' id equal to whichever actionX (ie actionDash, actionCreate) was invoked: To be used for highlighting the current left menu button..
      		var lId = <?php 
                    if( (Yii::app()->controller->getAction()->getId() == "dash") ) 
                    {
                     echo '"dash"';
                    }
                    else if( (Yii::app()->controller->getAction()->getId() == "create") )
                    {
                     echo '"settings"';      //Made the same for when user clicks on 'Layouts' @ left menu..
                    }
                    else if( (Yii::app()->controller->getAction()->getId() == "theme") )
                    {
                     echo '"theme"';
                    } 
                    else{
                     echo "mId";
                    }  
                ?>;
			
			//alert('<?php echo Yii::app()->controller->getAction()->getId(); ?>');
			if(lId == 'settings' || lId == 'theme')
			{
		       $('li').remove('#menuItemLayouts');  //Remove Layouts for Create page only..
		    }
      
			/*Highlight Main Menu classes */
			//$("#headerMainMenu").find("*").removeClass("active");
			//$("#menuItem"+mId).addClass("active");     //Old..commented out to prevent 'Dashboard' up top from being selected (active) upon page load..
			
			/*Highlight Left Menu classes */
			$("#bodyLeftMenu").find("*").removeClass("current");
			$("#leftMenuItem"+lId).addClass("current"); 
		});
	</script>
</head>
<body style="overflow: hidden;" class="bg05-png" >
<div id="loading"> 
<script type = "text/javascript"> 
    document.write("<div id='container'><p id='contentLoad'>" +
                   "<img id='loadinggraphic' width='16' height='16' src='<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader-eeeeee.gif' /> " +
                   "Loading...</p></div>");
</script> 
</div> 
<div id="wrapper" class="clearfix">
	<header class="container_8 clearfix">
	    <div class="grid_8">
	         <h1 style="padding-top:0px;margin-top:0px;height:36px;">
	         <img src="<?php echo Yii::app()->baseUrl; ?>/themes/tutorialzine1/images/SABIA_Logo.png" height="37" width="103">
	        </h1>
	        <nav>
	        	<?php include_once( LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authMainMenu.php")); ?>
	        </nav>
	    </div>
	</header>
	<section >
		<div class="container_8 clearfix">
			<div id="content">
				<section class="main-section grid_8">
					 <nav class="">
					   <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
					  <?php include_once(LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
					 </nav>
					 
					 <div class="main-content">
					  <header>
						<?php echo $content;?>   
					  </header>
					 </div>
				</section>
			</div>
		</div>
	</section>
</div>	
<footer>
<div id="footer-inner" class="container_8 clearfix">
    <div class="grid_8">
        <span class="fr">&copy; 2014 Sabia Inc. All rights reserved.</span>
    </div>
</div>
</footer>
<script type="text/javascript">
	$( ".selectorAc" ).accordion({ autoHeight: false });	
</script>
</body>
</html>