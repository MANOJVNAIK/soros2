               <a class="chevron" href="#">»</a>
                <?php
                
                $action = strtolower($actionID = Yii::app()->controller->action->id);
                
                $dashActive = $action === 'dash' ? 'current' : '';
                $configActive = $action === 'admin' ? 'current' : '';
                $historyActive = $action === 'history' ? 'current' : '';
                $lmessagesActive = $action === 'lmessages' ? 'current' : '';
                $iohistoryActive = $action === 'iohistory' ? 'current' : '';
                $rmsettingsActive = $action === 'rmsettings' ? 'current' : '';
                
                   
                 $li_arr = array(
                
				               0 => array(
				                      'id'     => "leftMenuItemdash",
				                      'title'  => "",
				                      'class'  => $dashActive,
				                      'a_href' => array(
					     	                            'path'  => "/rawmix/dash",
						                                'class' => "navicon-house"
						                                
						                  ),
						 
						                  'name'   => Yii::t('leftmenu',"Dashboard")
				               ),
				  
				               1 => array(
				                      'id'     => "leftMenuItemsettings",
				                      'title'  => "",
				                      'class'  => $configActive,
				                      'a_href' => array(
					     	                            'path'  => "/rawmix/admin",
						                                'class' => "navicon-cabinet"
						                                
						                  ),
						 
						                  'name'   => Yii::t('leftmenu','Configure') 
				               ),
	                 			2 => array(
				                      'id'     => "leftMenuItemtheme",
				                      'title'  => "",
				                      'class'  => $historyActive,
				                      'a_href' => array(
					     	                            'path'  => "/rawmix/history",
						                                'class' => "navicon-photos"
						                                
						                  ),
						 
						                  'name'   => Yii::t('leftmenu','History')
				               ),
				               				               
				               3 => array(
				                      'id'     => "calibration",
				                      'title'  => "Calibration",
				                      'class'  => $lmessagesActive,
				                      'a_href' => array(
					     	                            'path'  => "/rawmix/lmessages",
						                                'class' => "navicon-ekg"
						                                
						                  ),
						                  'name'   => Yii::t('leftmenu','Logs')
				               ),
				                4 => array(
				                      'id'     => "rmSettings",
				                      'title'  => "rmSettings",
				                      'class'  => $rmsettingsActive,
				                      'a_href' => array(
					     	                            'path'  => "/rawmix/rmsettings",
						                                'class' => "navicon-gear-1"
						                                
						                  ),
						                  'name'   => Yii::t('leftmenu','Settings')
				               ),					               
			               				               
				               5 => array(
				                      'id'     => "simulateRun",
				                      'title'  => "Simulate RHEA",
				                      'class'  => $iohistoryActive,
				                      'a_href' => array(
					     	                            'path'  => "/rawmix/iohistory",
						                                'class' => "navicon-gear-2"
						                                
						                  ),
						                  'name'   => Yii::t('leftmenu','RM-History')
				               ),						   
			               				               
				               				               
				  
	             );			
				   
                ?>
                
                
                <!-- LR 03/10/2013. This is what renders the Left Side Bar Menu -->
                
                 <?php 
                       //Abhinandan. Redirect to login screen if the user = guest..
                       if( Yii::app()->user->isGuest):
                        $this->redirect(Yii::app()->createUrl('/userGroups/user/login'));
                       endif;

		     //AB42819 BEGIN:ADDING USER RBAC 
		     $cur_ul    = Yii::app()->user->id;
		     $usRBACArr = array(2=>array(4),3=>array(1,4));
		     foreach($usRBACArr as $ulId=>$uresAr) {
			if($cur_ul == $ulId) {				
				foreach($uresAr as $subMId) {
				    if(isset($li_arr[$subMId]))
					 unset($li_arr[$subMId]);
				}
			}//if
		     }//foreach
		     //AB42819 END:ADDING USER RBAC 

                 ?>
                
                  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>array(),
                        'htmlOptions' => array('class'=>'nav nav-list','id'=>'bodyLeftMenu')
			));?>
                <ul id="bodyLeftMenu" > 
                
                
                 <?php foreach($li_arr as $k1 => $v1): ?>
                  <?php if( $v1['a_href']['path'] != "#" ): ?>
                   <?php       $full_path = Yii::app()->baseUrl . $v1['a_href']['path']; ?>
                   <?php else: $full_path = $v1['a_href']['path']; ?>
                  <?php endif; ?>
                  <li id="<?php echo $v1['id']; ?>" title="<?php echo $v1['title']; ?>" class="<?php echo $v1['class']; ?>" >
                   <a href="<?php echo $full_path ?>" class="<?php echo $v1['a_href']['class']; ?>" >
                    <?php echo $v1['name']; ?>
                   </a>
                   <?php if( isset($v1['userIndex']) ): ?>
                   	<ul class="<?php echo $v1['userIndex']['ul_class']; ?>">
                   	 <?php foreach($v1['userIndex']['sub_li_arr'] as $k_1 => $v_1 ): ?>
                   	  <li>
                   	   <a href="<?php echo Yii::app()->baseUrl . $v_1['a_href']; ?>" class="<?php echo $v_1['class']; ?>" ><?php echo $v_1['subname']; ?></a>
                   	  </li> 
                   	 <?php endforeach; ?>	
                   	</ul>
                   <?php endif; ?>
                  </li>
                 <?php endforeach; ?>
                </ul>                 
