<?php
if ($data->default_profile) {
    $rowStyle = 'style="background:#C1FFC1;font-size:medium;"';
    $defProf = "<span style='font-weight:bold;'>Yes</span>";
} else {
    $defProf = "No";
}
?>
<tr <?php echo $rowStyle; ?>>

<?php $editLink = Yii::app()->createAbsoluteUrl('rawmix/settings', array('id' => $data->product_id)) ?>

    <td > <input type="checkbox" name="checkbox[]" value="<?php echo $data->product_id ?>"></td>
    <td><?php echo CHtml::link(CHtml::encode($data->product_id), array('view', 'id' => $data->product_id)); ?></td>

    <td><?php echo $defProf; ?></td>
    <td style="text-align: left ! important"><?php echo CHtml::encode($data->product_name); ?></td>
    <!--
        <td><?php echo CHtml::encode(sprintf("%4.2f", $data->target_flow)); ?></td>
        <td><?php echo CHtml::encode(sprintf("%4.2f", $data->max_flow_deviation)); ?></td>
    -->
    <td><?php echo CHtml::encode(sprintf("%s", date("m-d-Y", strtotime($data->updated_on)))); ?></td>
    <td><?php echo CHtml::encode(sprintf("%s", date("m-d-Y", strtotime($data->created_on)))); ?></td>

    <th>

        <a  href='<?php echo $editLink ?>' data-icon-only="true" data-icon-primary="ui-icon-pencil" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span><span class="ui-button-text">
                <span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
                <span class="ui-button-text"><?php Yii::t('app', 'Edit') ?>&nbsp;</span></span>
        </a>

    </th>

</tr>