<!DOCTYPE html><html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo CHtml::encode($this->pageTitle); ?>!</title>
<?php
	$tu = Yii::app()->theme->baseUrl;
	$cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->baseUrl;

	$cs->registerCssFile($tu.'/css/font.css');
	$cs->registerCssFile($tu.'/css/font_l.css');
	$cs->registerCssFile($tu.'/css/cu_reset.css');
	$cs->registerCssFile($tu.'/css/cu_grid_' . Yii::app()->params['screen_resolution'] .'.css');
	$cs->registerCssFile($tu.'/css/cu_style.css');
	$cs->registerCssFile($tu.'/css/cu_elfinder.css');
	$cs->registerCssFile($tu.'/css/jquery.ui.datatables.css');
	$cs->registerCssFile($tu.'/css/jquery.dataTables.css');
	$cs->registerCssFile($tu.'/css/dataTables.tableTools.css');
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
		$cs->registerScriptFile($tu.'/js/jquery.tools.min_o.js');
		$cs->registerScriptFile($tu.'/js/overlay.apple.js');

		$cs->registerScriptFile($tu.'/js/jquery.ui.min.js');
		$cs->registerScriptFile($tu.'/js/jquery.uniform.min_o.js');
		//$cs->registerScriptFile($tu.'/js/jquery.dataTables.min.js');
		//$cs->registerScriptFile($tu.'/js/dataTables.tableTools.js');
		$cs->registerScriptFile($tu.'/js/jquery.slidernav.js');
		//$cs->registerScriptFile($tu.'/js/jquery.isotope.min_o.js');
		$cs->registerScriptFile($tu.'/js/jquery.supersubs.js');
		$cs->registerScriptFile($tu.'/js/jquery.elfinder.full.js');
		//$cs->registerScriptFile($tu.'/js/prettify/prettify.js');
		$cs->registerScriptFile($tu.'/js/global.js');
		$cs->registerScriptFile($tu.'/js/selectivizr.js');
		$cs->registerScriptFile($tu.'/js/jquery.time.slider.js');
                $cs->registerScriptFile($baseUrl.'/js/sweetalert.min.js');

    $cid = Yii::app()->controller->getAction()->getId();
        $ccid = Yii::app()->controller->id;
        if (($ccid == "monitor") && ($cid == "dash")) { ?>
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/highcharts_new.js'; ?>" ></script>       	
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/highcharts-3d.js'; ?>" ></script>       	
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/modules/cylinder.js'; ?>" ></script>       	
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/modules/funnel3d.js'; ?>" ></script>       	
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/modules/pyramid3d.js'; ?>" ></script>       	
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/modules/exporting.js'; ?>" ></script>       	
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/js/highCharts/modules/export-data.js'; ?>" ></script>       	
        <?php } 
    
                
        $refTime = 600000;
        if (($cid == "dash")) {
            if (isset($_REQUEST['refTime']) && ($_REQUEST['refTime'] > 30)) {
                $refTime = $_REQUEST['refTime'];

                echo '
				<script type="text/javascript">
				function ReloadPage() {
				   location.reload();
				};

				$(document).ready(function() {
				  setTimeout("ReloadPage()", ' . $refTime . '000);
				});
				</script>';
            } 
            else {
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
            
	}elseif($ccid == 'tagSettings' || $ccid == 'tagGroup'){
            $refTime = 900000000;
        }
    ?>
	<script type="text/javascript">
	$(window).load(function(){
            
            setTimeout(function(){ window.location = ""; }, <?php echo $refTime ?>);
	    $("#loading").fadeOut(function(){
			$(this).remove();
			$('body').removeAttr('style');
	    });
	    //$("nav").removeClass('collapsed');
	});
	</script>

	<style type = "text/css">
	#container {position: absolute; top:50%; left:50%;}
	#contentLoad {width:800px; text-align:center; margin-left: -400px; height:50px; margin-top:-25px; line-height: 50px;}
	#contentLoad {font-family: "Helvetica", "Arial", sans-serif; font-size: 18px; color: black; text-shadow: 0px 1px 0px white; }
	#loadinggraphic {margin-right: 0.2em; margin-bottom:-2px;}
	#loading {background-color: transparent; overflow:hidden; width:100%; height:100%; position: absolute; top: 0; left: 0; z-index: 9999;}
	</style>

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
<header class="container_8 clearfix" style="margin-bottom:02px !important;">
    <div class="grid_8">
	 <h1 style="padding-top:0px;margin-top:0px;height:36px;">
	 <img src="<?php echo Yii::app()->baseUrl; ?>/themes/tutorialzine1/images/SABIA_Logo.png" height="37" width="103">
	</h1>
	<nav>
                        <?php
                        $baseUrl = Yii::app()->basePath;

                        $menuFile = $baseUrl . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "themes" . DIRECTORY_SEPARATOR . "tutorialzine1" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "pageDefaults" . DIRECTORY_SEPARATOR . "authMainMenu.php";
                        include_once($menuFile);
                        ?>
	</nav>
    </div>
            </header>
            <section>
    <div class="container_8 clearfix">
	<!-- Main Section -->
                    <?php echo $content; ?>
                </div>

<footer>
<div id="footer-inner" class="container_8 clearfix">
    <div class="grid_8">
	<span class="fr">
	    <?php echo date('Y');?> &copy; 
            <?php echo Yii::t('core', 'Sabia Inc. v1.7') ?> &nbsp;|&nbsp;
            <?php echo Yii::t('core', 'All rights reserved.') ; ?>
	</span>
    </div>

    <?php
	$actionId 	= $this->action->Id;
	$controllerId 	= $this->Id;

//submitPr

	$includeJs = true;

	if($controllerId == 'rawmix' && $actionId == 'settings' ){
	    $includeJs = false;
	}

	if($controllerId == 'rawmix' && $actionId == 'submitPr' ){
	    $includeJs = false;
	}

        if($controllerId == 'dash' && $actionId == 'create' ){
	    $includeJs = false;
	}

	if($includeJs):

    ?>

		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.min.js'; ?>" ></script>

		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.isotope.min.js'; ?>" ></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl .'/js/jquery.ui.min_old.js'; ?>" ></script>
       <?php endif;?>
		<script type="text/javascript">



	    $("#vSlider").change(function(){
		    $("#alertVal").html($(this).val());
		});

		$('input[name=dashboardview]').change(function(){
			var base = this;
			setTimeout(function(){$('.isotope-container').isotope({ filter: $(base).val() });},500);
		});
	    $('.isotope-container').isotope({ filter: $('input[name=dashboardview]:checked').val() });

		$( ".selectorAc" ).accordion({ autoHeight: false });
		$(".tabs").tabs();




	    $('.isotope-container2').isotope({ filter: $('input[name=dashboardview2]:checked').val() });

		$('input[name=dashboardview2]').change(function(){
				var base = this;
				setTimeout(function(){$('.isotope-container2').isotope({ filter: $(base).val() });},500);
		});



                    </script>

                    <?php
                    $controllerId = Yii::app()->getController()->getAction()->controller->id;
                    if ('rawmix' === strtolower($controllerId)) {
		$this->renderPartial('_dgrids/_d_abar');
	}
                    ?>
                    <!-- LOADING SCRIPT END -->
	<script type="text/javascript">
                        $(document).ready(function () {

			var activeId = $("#headerMainMenu >li[title=\"active\"]").attr("id");
                            $("#" + activeId).attr("class", "active");


                            var mId = <?php echo'"' . Yii::app()->controller->id . '"'; ?>;                       //Old..returns dash everytime..

			//Abhinandan. July3rd 2013: Set the appropriate '<li>' id equal to whichever actionX (ie actionDash, actionCreate) was invoked: To be used for highlighting the current left menu button..
		    var lId = <?php
                    if ((Yii::app()->controller->getAction()->getId() == "dash")) {
		     echo '"dash"';
                    } else if ((Yii::app()->controller->getAction()->getId() == "create")) {
		     echo '"settings"';      //Made the same for when user clicks on 'Layouts' @ left menu..
                    } else if ((Yii::app()->controller->getAction()->getId() == "theme")) {
		     echo '"theme"';
                    } else {
		     echo "mId";
		    }
		?>;

			//alert('<?php echo Yii::app()->controller->getAction()->getId(); ?>');
                            if (lId == 'settings' || lId == 'theme')
			{
		       $('li').remove('#menuItemLayouts');  //Remove Layouts for Create page only..
		    }

			/*Highlight Main Menu classes */
			//$("#headerMainMenu").find("*").removeClass("active");
			//$("#menuItem"+mId).addClass("active");     //Old..commented out to prevent 'Dashboard' up top from being selected (active) upon page load..

			/*Highlight Left Menu classes */
			//$("#bodyLeftMenu").find("*").removeClass("current");
			//$("#leftMenuItem"+lId).addClass("current");
		});
	</script>
</footer>
</body>
</html>
