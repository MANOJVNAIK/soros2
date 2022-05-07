<?php
    function readCalibEntry() {
        require_once 'configfile.php';
                
        $config = new ConfigFile();
        $config->load("/usr/local/sabia-ck/cal_adjust/cal_adjust.cfg", false);
        $config->setPath("/STDCAL");
        $calProfileName = $config->readEntry('std_display_list');
        $config->flush();
        
        return $calProfileName;
    }
    
    function getRMSettingsVal($key) {
        $squery =  "SELECT varValue from rm_settings where varName='{$key}'";
        $settingValue = Yii::app()->db->createCommand($squery)->queryScalar();
	return $settingValue;
    }

$curpage = Yii::app()->getController()->getAction()->controller->id;
$curpage .= '/' . Yii::app()->getController()->getAction()->controller->action->id;

 
$controlId = Yii::app()->getController()->getId();
 $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => "<i class='icon-user'></i><span class='username'>".Yii::t('dash_menu', 'Analyzer')."</span> <i class='icon-angle-down'></i>",
                        'url' => Yii::app()->baseUrl.'/dash',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            ),
                        
                        'visible' => isModuleVisible('analysis'),
                   
                    ),
                       array(
                        'label' => "<i class='icon-user'></i><span class='username'>".Yii::t('dash_menu', 'SOROS')."</span> <i class='icon-angle-down'></i>",
                        'url' => Yii::app()->baseUrl.'/monitor/dash',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            ),
                        
                         'visible' => isModuleVisible('soros'),
                   
                    ),
                    array(
                        'label' => "<i class='icon-truck'></i><span class='username'>".Yii::t('dash_menu', 'RFID')."</span> <i class='icon-angle-down'></i>",
                        'url' => Yii::app()->baseUrl.'/truckInfo/admin',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            ),
                        
                         'visible' => isModuleVisible('soros'),
                   
                    ),
                    array(
                        'label' => "<i class='icon-user'></i><span class='username'>".Yii::t('dash_menu', 'Feed-Rates')."</span> <i class='icon-angle-down'></i>",
                        'url' => Yii::app()->baseUrl.'/dash2/dash',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            ),
                        
                         'visible' => isModuleVisible('feedrate'),
                   
                    ),
                     array(
                        'label' => "<i class='icon-user'></i><span class='username'>".Yii::t('dash_menu', 'RawMix')."</span> <i class='icon-angle-down'></i>",
                        'url' => Yii::app()->baseUrl.'/rawmix/dash',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            ),
                         
                          'visible' => isModuleVisible('rawmix'),
                   
                    ),
                    array(
                        'label' => "<i class='icon-user'></i><span class='username'>".Yii::t('app', 'Lab-Link')."</span> <i class='icon-angle-down'></i>",
                        'url' => Yii::app()->baseUrl.'/labdata/index	',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            ),
                        
                         'visible' => isModuleVisible('lab_link'),
                   
                    ),
                    
                      array(
                        'label' => "<span id='rawMixBadger'></span>
                        <img width='48' height='48' src='".Yii::app()->theme->baseUrl."/images/navicons/09.png' >",
                        'url' => '#',
                        'linkOptions'=> array(
                            'class' => 'arrow-down sf-with-ul',
                            'data-toggle' => 'dropdown',
                            'id' => 'rawMixBadgerLi'
                            ),
                          
                          'visible' => isModuleVisible('rawmix'),
                   
                    ),
                    
                    //class="fr" id="menuItemuser"
                      array(
                        'label' => "<a href='#' class='arrow-down sf-with-ul'>".Yii::app()->user->name."<span class='sf-sub-indicator'>»</span></a>",
                        'url' => Yii::app()->baseUrl.'/labdata/index	',
                           'itemOptions' => array('class' => 'fr',  'id'=> 'menuItemuser'),
                        'linkOptions'=> array(
                            'class' => 'fr',
                          
                            ),
                               'items' => array(
                            array(
                                'label' => Yii::t('dash_menu', 'Account'),
                                'url' => Yii::app()->baseUrl.'/mportal'
                            ),
                            array(
                                'label' => Yii::t('dash_menu', 'Logout'),
                                'url' =>  Yii::app()->baseUrl.'/site/logout',
                            ),
                        
                        )
                   
                    ),
                          array(
                        'label' =>Yii::t('dash_menu', 'Refresh') .'<span class="sf-sub-indicator">»</span>',
                        'url' => '#',
                         'itemOptions' => array('class' => 'fr', 'id' => 'menuItemuser'),    
			                        'visible' => isModuleVisible('rawmix'), 
                        'linkOptions'=> array(
                            'class' => 'fr',
                            'data-toggle' => 'dropdown',
                            'id'=> 'menuItemuser',
                           
                            ),
                               'items' => array(
                            array(
                                'label' => "01 M",
                                'url' => Yii::app()->createAbsoluteUrl('rawmix',array('refTime' => '60'))
                            ),
                                array(
                                'label' => "05 M",
                                'url' => Yii::app()->createAbsoluteUrl('rawmix',array('refTime' => '300'))
                            ),
                        
                        ),
                    ),
                     array(
                        'label' =>date('Y-m-d H:i').'<span class="sf-sub-indicator">»</span>',
                        'url' => '#',
                         'itemOptions' => array('class' => 'fr', 'id' => 'menuItemuser'),                             
                    ),
		    array(
            
                        //'label' =>'<span style="color:blue;"> '. getRMSettingsVal("CAL_PROFILE_ACTIVE") .'</span>',
                        'label' =>'<span style="color:blue;display:none"> '. readCalibEntry() .'</span>',
                        'url' => '#',
                         'itemOptions' => array('class' => 'fr', 'id' => 'menuItemuser'),                             
                    ),

                    
                    
                 
                    
                ), ///Item list end 
                'encodeLabel' => false,
                'htmlOptions' => array(
                    'class'=>'sf-menu clearfix',
                    'id' => 'headerMainMenu'
                        ),
                'submenuHtmlOptions' => array(
                    'class' => 'dropdown-menu',
                )
            ));
 

 function isModuleVisible($module){
     
     $product      = Yii::app()->params['productProfileName'];
     $moduleList =Yii::app()->params['modulesVisible'];
     $moduleVisible = $moduleList[$product];
     
     

    $isVisible =  isset($moduleVisible[$module]) ?  $moduleVisible[$module]  :  false;
     return $isVisible;
     
     
 }
 
 
 
 
 ?>


<script type="text/javascript">

    var dashObj = {
        grabDashboardLayout: function (lay_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->baseUrl; ?>/dash/GrabdashboardLayout',
                data: {'lay_id': lay_id},
                success: function (msg) {
                    document.location.reload(true);
                }
            }); //end ajax..
        } //grabDashboardLayout..
    };


</script>
  

<style type="text/css">

    a.longSize {width:810px !important; margin-left:5px;}

    li.selected {
        background:orange !important;
        font-color:red !important;
        border:red 2px solid !important;
    }
    .badge {
        font-family: "Open Sans",sans-serif;
        position: absolute;
        right: 20px;
        top: 10px;
        font-weight: 300;
        height: 18px;
        text-shadow: none !important;
        background-color: #D64635;
        color: #FFFFFF;
        box-sizing: border-box;
        border-radius: 12px !important;
        color: #FFFFFF;
        display: inline-block;
        font-size: 14px !important;
        font-weight: 700;
        line-height: 1;
        min-width: 10px;
        padding: 3px 6px;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
    }

</style>