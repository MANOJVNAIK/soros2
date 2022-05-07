
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
    
            <!--LR 03/19/2014-->
                <section class="container_6 " style="padding-top:0px !important;">
					<div class="grid_6 leading">
                                <div class="portlet">
                                    <section>
                                        <div class="tabs">
                                            <ul>
                                                <li id="portlet-pane-1-handle"><a href="#portlet-pane-1">General</a></li>
                                                <li id="portlet-pane-2-handle"><a href="#portlet-pane-2">Database</a></li>
                                                <li id="portlet-pane-3-handle"><a href="#portlet-pane-3">Data</a></li>
                                            </ul>
					                        <section class="container_6 clearfix">
	                                            <div class="grid_5" id="portlet-pane-1">
	                                                <?php $this->renderPartial('_generalSettings'); ?>
	                                            </div>
	                                            
                                              <div class="grid_6" id="portlet-pane-2"> 
	                                                <?php $this->renderPartial('_databaseSettings'); ?>
	                                            </div><!-- grid_5 portlet-pane-2 -->
                                                    
                                                    <div class="grid_6" id="portlet-pane-3"> 
	                                                <?php $this->renderPartial('_datasettings',array('mainDB'=>$mainDB)); ?>
	                                            </div>
	                                       </section>
                                        </div>
                                    </section>
                                </div>
                            </div>

                   
                </section>
            </div>