<?php 


$this->beginContent('/layouts/metronic'); 

$activeController = Yii::app()->controller->id;

$labActive = '';
$calibActive = '';


if(strtolower($activeController) == 'calib'){
	
	$calibActive = 'active';
	
	
}else{
	$labActive = 'active';
}

?>
  <div class="page-container" >
            		
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- END SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        
                        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                            <li class="nav-item 0SideMenuItem <?php echo $labActive?>"><a href="<?php echo Yii::app()->createAbsoluteUrl('labdata#data-history')?>"> <i class="fa fa-file-excel-o"></i><span class="title">
                                        
                                        
                                       <?php echo Yii::t('app','Lab-Data History');?> 
                                    
                                    </span>
                            <span class="selected"></span>
                            <span class="arrow open"></span></a></li>
                            <li class="nav-item 1SideMenuItem <?php echo $calibActive?>"><a href="<?php echo Yii::app()->createAbsoluteUrl('calib/view')?>">
                                    <i class="fa fa-pencil-square"></i><span class="title">
                                              <?php echo Yii::t('app','Calibration');?> 
                                      
                                    
                                    </span>
                            <span class="selected"></span>
                            <span class="arrow open"></span></a></li></ul>
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <!-- END SIDEBAR MENU -->
                                      
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->

            <div class="page-content-wrapper " >
                <div class="page-content" >

                    <?php echo $content ?>
                </div>
            </div>
            <!-- END CONTENT BODY -->
        </div>
      
<?php $this->endContent(); ?>