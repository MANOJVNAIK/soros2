
<style type="text/css">

    .li-ul li{
     display: inline;
     list-style-type: none;
    }

    /* Abhinandan. Determine colored button size */
    li.sm {width:80px !important;}

    li.extrasm {width:40px !important;}

    .item {
	float:left;
	margin:5px;
	width:50px;
	height:50px;
	background:blue;
	}

</style>
<section class="main-section grid_8">
 <nav class="">
   <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
  <?php include_once(LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
 </nav>


<div class="main-content">
		<header>
		    <ul class="action-buttons clearfix">
			<li><a href="#" class="button" data-icon-primary="ui-icon-flag" >Reset to Factory Settings</a></li>
		    </ul>
		    <h2>
			<?php echo Yii::app()->name; ?>
		    </h2>
		</header>
		<section class="container_6 clearfix">
					<div class="grid_6 leading">
				<div class="portlet">
				    <header>
					<h2> <?php echo Yii::t('admin',"Control your Layout Settings");?> -<mark><?php echo Yii::t('admin',"Default-Layout");?></mark></h2>
				    </header>
				    <section>
					<div class="tabs">
					    <ul>
						<li id="portlet-pane-1-handle"><a href="#portlet-pane-1"><?php echo Yii::t('admin',"General");?></a></li>
						<!-- <li id="portlet-pane-2-handle"><a href="#portlet-pane-2">Layout</a></li> -->
					    </ul>
								<section class="container_6 clearfix">
						    <div class="grid_5" id="portlet-pane-1">
							<?php $this->renderPartial('_generalSettings'); ?>
						    </div>

					      <div class="grid_5" id="portlet-pane-2">

						    </div><!-- grid_5 portlet-pane-2 -->
					       </section>
					</div>
				    </section>
				</div>
			    </div>


		</section>
	    </div>