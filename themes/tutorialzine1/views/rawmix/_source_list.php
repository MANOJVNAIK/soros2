	<table class="full list-table margin-top-20" >
        <thead>
        <tr><th class="ui-state-default ui-corner-top">
           <?php echo Yii::t('app','Source Name')?>      
        </th>
         <th class="ui-state-default ui-corner-top">
         <?php echo Yii::t('app','Source Status')?>      
        </th>
        <th class="ui-state-default ui-corner-top">
          <?php echo Yii::t('app','Source Delay')?>       
        </th>
        
        <th class="ui-state-default ui-corner-top">
           <?php echo Yii::t('app','Source Min Feed Rate')?>    
        </th>
        <th class="ui-state-default ui-corner-top">
          <?php echo Yii::t('app','Source Max Feed Rate')?>     
        </th>                
        <th class="ui-state-default ui-corner-top">
         <img width="30" src="<?php echo Yii::app()->theme->baseUrl?>/images/navicons/20.png">
        </th>
        </tr></thead>
        <tbody>
            
            <?php foreach ($dataList as $item ):?>
            <tr>
                <td><?php echo Yii::t('dash', $item->src_name); ?></td>
                <td><?php echo sprintf("%d", $item->src_status_mode); ?></td>
                <td><?php echo sprintf("%d", $item->src_delay); ?></td>
                 <td><?php echo sprintf("%2.2f", $item->src_min_feedrate * 100); ?> %</td>
                 <td><?php echo sprintf("%2.2f", $item->src_max_feedrate * 100); ?> %</td>
                <th>
                    <a onclick="return updateSource('<?php echo  $item->src_id?>')" data-icon-only="true" data-icon-primary="ui-icon-pencil" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" role="button">
                        <span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
                        <span class="ui-button-text"><?php echo Yii::t('app', "Edit Source"); ?> &nbsp;</span></a>
                    <a onclick="return deleteConfirm('source','<?php echo $item->src_id?>','<?php echo $item->src_name?>')" data-icon-only="true" data-icon-primary="ui-icon-trash" 
                       class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" 
                       role="button"><span class="ui-button-icon-primary ui-icon ui-icon-trash"></span><span class="ui-button-text"><?php echo Yii::t('app', "Delete Source"); ?>&nbsp;</span></a>
                </th>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
