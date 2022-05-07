<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php 
$curpage 	 = Yii::app()->getController()->getAction()->controller->id;
$curpage 	.= '/'.Yii::app()->getController()->getAction()->controller->action->id;

$menuArray = array("dash/dash"			=>	0,
				   "dash2/dash"			=>	0,
				   "dash3/dash"			=>	0,
				   "rawmix/dash"		=>	0,
				   "rawmix/settings"	=>	0,
				   "mportal"			=>	0);
foreach($menuArray as $key=>$val)
{				   
	if($curpage == $key)
		$menuArray[$key] = 1;			   
}

$baseUrl = Yii::app()->baseUrl.'/';;

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- Pre loader -->
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap/css/customboot.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap/css/silo_css.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />      
        <!--<link href="<?php echo $baseUrl ?>/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo $baseUrl ?>res/met/css/plugins/react-select.css" rel="stylesheet" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-tour/build/css/bootstrap-tour.min.css" rel="stylesheet" />

        <link href="<?php echo $baseUrl ?>res/met/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />

        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->

        <link href="<?php echo $baseUrl ?>res/met/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo $baseUrl ?>res/met/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?php echo $baseUrl ?>/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />-->
        <link href="<?php echo $baseUrl ?>res/met/layouts/layout2/css/themes/grey.min.css" rel="stylesheet" type="text/css"  />
        <link href="<?php echo $baseUrl ?>res/met/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/js/plugins/p-loading-master/dist/css/p-loading.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/semantic/table.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo $baseUrl ?>/favicon.ico" /> 
        <!-- BEGIN CORE PLUGINS -->
        <link href="<?php echo $baseUrl ?>res/met/global/plugins/jquery-toogle/candlestick.min.css" rel="stylesheet" type="text/css" />

        <!-- END HEAD -->
        <!-- WebT Css Starts Here -->
        <link href="<?php echo $baseUrl ?>res/met/css/google-font.css" rel="stylesheet" />
        <link href="<?php echo $baseUrl ?>res/met/layouts/layout2/css/custom-style.css" rel="stylesheet" type="text/css" />


        <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery.min.js" type="text/javascript"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-boxed">


        <div id="loader-wrapper">
            <div id="loader"></div>

            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

        </div>
        <?php if (1) { ?>
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner container">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="">
                            <!--Helios-->
                            <img src="<?php echo $baseUrl ?>res/met/global/img/small-logo.png" alt="logo" class="logo-default"  alt="Sabia Dashboard"/> 
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->

                    <!-- BEGIN PAGE TOP -->
                    <div class="page-top">
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="hor-menu hidden-sm hidden-xs">
                            <ul class="nav navbar-nav">
                                <!-- DOC: Remove data-hover="megamenu-dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
                               
							   
							   
	<li class="mega-menu-dropdown hormenuItem" <?php if($menuArray["dash/dash"]) echo 'title="active"'; ?>  id="menuItemdash">
		<a href="<?php echo Yii::app()->baseUrl; ?>/dash" ><?php echo Yii::t('dash_menu','Analyzer')?><!--<span class="sf-sub-indicator">»</span>--></a>	
	</li>

	<li class="mega-menu-dropdown hormenuItem" <?php if($menuArray["dash2/dash"]) echo 'title="active"'; ?>  id="menuItemdash1">
		<a href="<?php echo Yii::app()->baseUrl; ?>/dash2/dash" class="arrow-down sf-with-ul"><?php echo Yii::t('dash_menu','Feed-Rates')?></a>	
	</li>
<!--
	<li <?php if($menuArray["dash3/dash"]) echo 'title="active"'; ?>  id="menuItemdash2">
		<a href="<?php echo Yii::app()->baseUrl; ?>/dash3/dash" class="arrow-down sf-with-ul">Layout-2</a>	
	</li>
-->
	 <li class="mega-menu-dropdown hormenuItem " <?php if($menuArray["rawmix/dash"]) echo 'title="active"'; if($menuArray["rawmix/settings"]) echo 'title="active"';?> id="rawMixItemDash"><a href="<?php echo Yii::app()->baseUrl; ?>/rawmix/dash" class=" sf-with-ul">
        <?php echo Yii::t('dash_menu','RawMix')?> <!--<span class="sf-sub-indicator">»</span> --></a>
<!--	    <ul>
	        <li><a href="<?php echo Yii::app()->baseUrl; ?>/rawmix/settings" class="sf-with-ul">
	        	Settings
	        	</a>
	        </li>
	    </ul> -->
	</li>				   
                                <li class="mega-menu-dropdown hormenuItem active" aria-haspopup="true" id="laMenuItem">
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/labdata/index'); ?>" class="dropdown-toggle" data-hover="megamenu-dropdown" data-close-others="true"> 
					<?php echo Yii::t('app' ,'Lab-Link');?>
                                        <span class="selected"> </span>
                                    </a>
                                </li>
	 <?php 
	
		$ssql = "SELECT * FROM `rm_settings` where varName IN ('constFeeders' , 'AUTOMODE', 'MASTER_CONTROL_MODE' ,'STARVATION','shutdown_msg')";
		$scommand = Yii::app()->db->createCommand($ssql);
		$sresult = $scommand->query()->readAll();
		$masValHid = 0;
		$autoModeVar = 0;
		foreach ($sresult as $rowRes) {

			if($rowRes["varName"] == "AUTOMODE" && $rowRes["varValue"]) {
				$autoModeVar = $rowRes["varValue"];
			} else if($rowRes["varName"] == "MASTER_CONTROL_MODE" && $rowRes["varValue"]) {
				$masValHid = 1;			
			}//else
		}//foreach
		
		if($masValHid && $autoModeVar) {
			$statColor = "#7ec554";
		}
		else 
			$statColor = "#D64635";
	 ?>
	<li><div>
		<a class="btn btn-circle btn-icon-only" data-icon-primary="ui-icon-power" style="margin-top:8px;margin-left:20px;background:<?php echo $statColor; ?> !important;">
			<i class="fa fa fa-power-off"></i>
		</a>
		</div>
	</li>
                            </ul>
                        </div>
                        <div class="top-menu">
                            <ul class="nav navbar-nav pull-right">

                                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                                    <a href="javascript:;" class="dropdown-toggle" 
                                       data-toggle="dropdown" 
                                       data-hover="dropdown" 
                                       data-close-others="true">
                                           <?php echo date("Y-m-d H:i:s") ?>
                                    </a>
                                </li>


                                <!-- END INBOX DROPDOWN -->

                                <!-- BEGIN USER LOGIN DROPDOWN -->
                                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                <li class="dropdown dropdown-user">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <span class="username username-hide-on-mobile font-blue"> 

                                            <b> <?php echo isset(Yii::app()->user->id) ? Yii::app()->user->name : 'Guest' ?> </b>


                                        </span>
                                        <i class="fa fa-angle-down font-blue"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-default font-blue">
									
									 <li>
                                            <a class="font-blue e disabled hide" href="">
                                                <i class="icon-user font-blue"></i> My Profile </a>
                                        </li>
									
     <!--                                   <li>
                                            <a class="font-blue e disabled hide" href="">
                                                <i class="icon-user font-blue"></i><?php echo Yii::t('menu', "My Profile"); ?>  </a>
                                        </li>
                                        <li class="divider hide"> </li>


-->
                                        <li class="font-white">
                                            <a href="<?php echo Yii::app()->createAbsoluteUrl('/site/logout') ?>" class=" btn blue font-white">
                                                Logout <i class="fa fa-sign-out font-white"></i>
                                            </a>

                                        </li>



                                    </ul>


                                </li>
                                <!-- END USER LOGIN DROPDOWN -->
                                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                <!--                                                            <li class="dropdown dropdown-extended quick-sidebar-toggler">
                                                                                                <span class="sr-only">Toggle Quick Sidebar</span>
                                                                                                <i class="icon-user"></i>
                                                                                            </li>-->
                                <!-- END QUICK SIDEBAR TOGGLER -->
                            </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                    <!-- END PAGE TOP -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
        <?php } ?>
	<div class="container">
            <!-- BEGIN CONTAINER -->  

			<?php echo $content ?>

            <!-- END CONTAINER -->  
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner" style="color:white;float:right;"> 
            <?php echo date('Y');?> &copy; 
            <?php echo Yii::t('core', 'Sabia Inc. v1.7') ?> &nbsp;|&nbsp;
            <?php echo Yii::t('core', 'All rights reserved.') ; ?>
        </div>  
    </div>

	</div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->

    <!-- END QUICK NAV -->
    <!--[if lt IE 9]>
            <script src="<?php echo $baseUrl ?>res/met/global/pluginsrespond.min.js"></script>
            <script src="<?php echo $baseUrl ?>res/met/global/plugins/excanvas.min.js"></script> 
            <script src="<?php echo $baseUrl ?>res/met/global/plugins/ie8.fix.min.js"></script> 
            <![endif]-->



    <script src="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/isotope/isotope.pkgd.min.js" type="text/javascript"></script>

    <!-- END CORE PLUGINS -->


    <!-- BEGIN THEME GLOBAL SCRIPTS -->


    <script src="<?php echo $baseUrl ?>res/met/global/scripts/app.js" type="text/javascript"></script>

    <script src="<?php echo $baseUrl ?>res/met/global/scripts/globalConfig.js" type="text/javascript"></script>


    <!-- END THEME GLOBAL SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>    
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>		
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

    <script src="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>


<!--<script src="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>-->

    <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

    <script src="<?php echo $baseUrl ?>res/met/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/bootstrap-tour/build/js/bootstrap-tour.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


    <!--<script src="<?php echo $baseUrl ?>/global/plugins/ionSlider/js/ion.rangeSlider.min.js" type="text/javascript"></script>-->
    <!--<script src="<?php echo $baseUrl ?>/global/plugins/nouislider/nouislider.min.js" type="text/javascript"></script>-->


    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo $baseUrl ?>res/js/site/form-wizard.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/js/site/table-datatables-managed.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/js/site/swapBackground.js" type="text/javascript"></script>
    <!-- <script src="<?php echo $baseUrl ?>res/js/site/todo-2.min.js" type="text/javascript"></script> 
    <script src="<?php echo $baseUrl ?>res/met/global/scripts/components-select2.min.js"></script>-->
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->

    <script src="<?php echo $baseUrl ?>res/met/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/layouts/layout2/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/layouts/layout2/scripts/quick-nav.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/js/plugins/p-loading-master/dist/js/p-loading.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/js/plugins/axios.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/js/plugins/icheck.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/jquery-toogle/candlestick.min.js" type="text/javascript"></script>

    <script src="<?php echo $baseUrl ?>res/met/global/plugins/highcharts/highstock.js"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/highcharts/exporting.js"></script>
    <script src="<?php echo $baseUrl ?>res/met/global/plugins/highcharts/export-data.js"></script>

    <script src="<?php echo $baseUrl ?>res/met/global/plugins/multi-state-toggle/js/tsb.js"></script>

    <script src="<?php echo $baseUrl ?>res/react/react_bundle.js" type="text/javascript"></script> 
    <!-- END THEME LAYOUT SCRIPTS -->
    
    <!-- End -->
    <script>
        $(document).ready(function () {
     $('.table').on('draw.dt', function () {
               // alert('Table redrawn');
               
               datatableLoaded();
            });
            $(".export-xl").on('click', function (e) {

//                    console.log(this);

                var startTime = $(this).attr('data-start');
                var endTime = $(this).attr('data-end');
                var id = $(this).attr('data-id');
                var type = $(this).attr('data-type');


                var exportLink = '<?php echo Yii::app()->createAbsoluteUrl('/export-table/index') ?>' + '?startTime=' + startTime + ' &id=' + id + '&endTime=' + endTime + '&type=' + type;


                window.location = exportLink;

            });



            // Close pre loader     
            setTimeout(function () {
                $('body').addClass('loaded');
            }, 300);

            $("[data-key='action']").prop('width', '210px');

            $("[data-key='action']").prop('text-align', 'center ! important');

            //pawan deleted
        })


        function datatableLoaded() {


            $(".datatable-export-xl").on('click', function (e) {

                console.log(this);

                var title = $(this).attr('title');

                var ar = title.split('##');
                var startTime = ar[0];//$(this).attr('data-start');
                var endTime = ar[1];
                var id = 1;
                var type = ar[2];


                var exportLink = '<?php echo Yii::app()->createAbsoluteUrl('/export-table/index') ?>' + '?startTime=' + startTime + ' &id=' + id + '&endTime=' + endTime + '&type=' + type;


                window.location = exportLink;

            });
        }
    </script>

</body>

</body>
</html>