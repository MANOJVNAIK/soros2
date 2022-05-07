    <?php
    
    
    $cs = Yii::app()->clientScript;
    

   
    ?>
    <tr>
    
    <?php $editLink = Yii::app()->createAbsoluteUrl('rawmix/settings',array('id'=>$data->product_id))?>
    
   
    <td><?php echo CHtml::link(CHtml::encode($data->product_id), array('view', 'id'=>$data->product_id)); ?></td>

   
    <td style="text-align: left ! important"><?php echo CHtml::encode($data->product_name); ?></td>
    <td style="text-align: left ! important"><?php echo CHtml::encode($data->profile_name); ?></td>

    <td> <?php echo $data->user_id ?></td>
    <td><?php echo CHtml::encode(sprintf("%s",date("m-d-Y h:i:s ",strtotime($data->updated_on)))); ?></td>
    <td><?php echo CHtml::encode(sprintf("%s",date("m-d-Y  h:i:s ",strtotime($data->created_on)))); ?></td>
    
    <th> 
        
      
    <div id='cssmenu' style="width: 55px; margin: auto;">

        <ul>
            <li class='has-sub last '><a  class="ui-state-default ui-corner-all" href='#'></a>
               <ul style="z-index: 9999999" class="ui-widget-content ui-corner-all">
               
                   <li class='last'><a href='#' onclick="return confirmDeleteProfileLog('<?php echo  $data->product_id?>')"><span>Delete</span></a></li>
                    <li class='last'><a href='#' onclick=" return confirmActivation('<?php echo  $data->product_id?>')"><span>Activate</span></a></li>
                   
               </ul>
            </li>
        </ul>
      

    </div>
    
    </th>
    
</tr>