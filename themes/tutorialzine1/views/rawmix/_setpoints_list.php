<div id="set-point-list">
   

        <table class="full margin-top-20 list-table" >
                                  
    <thead>
                                    <tr>
                                     <th class="ui-state-default ui-corner-top">
                                     <?php echo Yii::t('app','Set-Point Name')?>   
                                    </th>
                                     <th class="ui-state-default ui-corner-top">
                                          <?php echo Yii::t('app','Set-Point Active')?>   
                                    </th>
                                     <th class="ui-state-default ui-corner-top">
                                           <?php echo Yii::t('app','Set-Point Value')?>   
                                    </th>
                                    <th class="ui-state-default ui-corner-top">
                                          <?php echo Yii::t('app','Set-Point Tolerance (+-)')?>     
                                    </th>
                                    <th class="ui-state-default ui-corner-top">
                                         <?php echo Yii::t('app','Priority')?>    
                                    </th>
                                    <th class="ui-state-default ui-corner-top">
                                    
                                        <img width="30" src="<?php echo Yii::app()->theme->baseUrl?>/images/navicons/20.png">
                                        
                                    </th>
                                    </tr>
    </thead>
                                    <tbody >
                                        
                                        <?php foreach ($dataList as $item ):?>
                                        <tr>
                                            <td><?php echo $item->sp_name?></td>
											<td><?php echo sprintf("%d", $item->sp_status	); ?></td>
											<td><?php echo sprintf("%04.2f", $item->sp_value_num); ?></td>
											<td><?php echo sprintf("%04.2f", $item->sp_tolerance_ulevel) ?></td>
											<td><?php echo sprintf("%04.2f", $item->sp_priority) ?></td>
                                            <th>
                                                <a onclick="return updateSetPoint('<?php echo  $item->sp_id?>')" data-icon-only="true" data-icon-primary="ui-icon-pencil" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" role="button">
                                                    <span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
                                                    <span class="ui-button-text"> <?php echo Yii::t('app', "Edit Set Point"); ?>&nbsp;</span></a>
                                                <a onclick="return setpointDeleteConfirm('<?php echo $item->sp_id?>','<?php echo $item->sp_name?>')" data-icon-only="true" data-icon-primary="ui-icon-trash" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-trash"></span><span class="ui-button-text">
                                                        <?php echo Yii::t('app', "Delete Set Point"); ?>&nbsp;</span></a>
                                            </th>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table> 
</div>
