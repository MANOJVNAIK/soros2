<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$colorCodeLookUp = array(
	1 => 'INFO',
    2 => 'DEBUG',
    3 => 'WARN',
    4 => 'ERROR',
    5 => 'CRITICAL',
);
?>

<section class="ui-widget-content ui-corner-bottom form">


    <select id="filter-error-msg" onchange="filtermessages()">
	<option value="INFO"> <?php echo Yii::t('admin', "INFO"); ?> </option>
	<option value="DEBUG" ><?php echo Yii::t('admin', "DEBUG"); ?> </option>
	<option value="WARN"><?php echo Yii::t('admin', "WARN"); ?> </option>
	<option value="ERROR"> <?php echo Yii::t('admin', "ERROR"); ?></option>
	<option value="CRITICAL"> <?php echo Yii::t('admin', "CRITICAL"); ?></option>
	<option value="ALL" selected> <?php echo Yii::t('admin', "ALL"); ?></option>
    </select>
    <table class="full clearfix list-table">

	<thead>
	<th class="ui-state-default"><?php echo Yii::t('admin', "Message Level"); ?></th>
	<th class="ui-state-default" ><?php echo Yii::t('admin', "Log Message"); ?></th>
	<th class="ui-state-default" ><?php echo Yii::t('admin', "Value"); ?></th>
	<th class="ui-state-default"><?php echo Yii::t('admin', "Timestamp"); ?></th>
	</thead>

	<?php
	foreach ($model as $error):
			$msgTds = "";
	    $typeClass = $colorCodeLookUp[$error->msg_level];
	    $msgText   = str_replace("-------------------------------------","",$error->msg_text);
	    $msgText   = str_replace("\n","",$msgText);
	    $msgText   = str_replace("<br/>","",$msgText);
	    $msgText   = str_replace(":  => ",": => ",$msgText);
	    $msgText   = trim($msgText);
	    if(strpos($msgText,": => ")){
		list($msg,$val) = explode(": => ",$msgText);
		$msgTds = '<td style="text-align:left !important; padding-left:10px;">'.$msg.'</td>';
		$msgTds .= '<td style="text-align:left !important; padding-left:10px;">'.$val.'</td>';
	    }else {
		$msg = $msgText;
		$msgTds = '<td colspan="2" style="text-align:left !important; padding-left:10px;">'.$msg.'</td>';
	    }
	    ?>

	    <tr class="error-msg-row <?php echo $typeClass ?>">
		<td> <?php echo $error->msg_level ?></td>
		<?php echo $msgTds; ?>
		<td> <?php echo $error->msg_updated ?></td>

	    </tr>

    <?php
endforeach;
?>

    </table>



</section>


<style type="text/css">
    .INFO{background:grey ! important}
    .DEBUG{background: black ! important;color:white}
    .WARN{background:#FFFF99 ! important}
    .ERROR{background:#E7582C ! important}
    .CRITICAL{background:#B41017 ! important;color:white}
</style>

<script type="text/javascript">

    $(function() {
	$('.error-msg-row').show();
    });
    function filtermessages() {

	var value = $('#filter-error-msg').val();
	var selector = "." + value;

	$('.error-msg-row').show();

	if(value == 'DEBUG'){
		$('.INFO').hide();
	}else if(value == 'WARN'){
		$('.INFO').hide();
		$('.DEBUG').hide();
	}else if(value == 'ERROR'){
		$('.INFO').hide();
		$('.DEBUG').hide();
		$('.WARN').hide();
	}else if(value == 'CRITICAL'){
		$('.INFO').hide();
		$('.DEBUG').hide();
		$('.WARN').hide();
		$('.ERROR').hide();
	}
    }
</script>
