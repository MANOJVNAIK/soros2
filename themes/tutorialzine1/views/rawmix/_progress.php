<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$uiState = '';
if ($progress <= 25) {

    $uiState = 'ui-state-error';
} else if ($progress <= 50) {

    $uiState = 'ui-state-error';
} else if ($progress <= 75) {

    $uiState = 'ui-state-highlight';
} else if ($progress <= 100) {

    $uiState = 'ui-state-success';
} else if ($progress >= 100) {

    $uiState = 'ui-state-success';
}
?>


<div data-show-value="true" data-value="10" class="progress ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10">
    <div class="ui-progressbar-value <?php echo $uiState ?> ui-corner-left" style="width: <?php echo $progress . '%' ?>;"><b><?php echo $progress . '%' ?></b></div>
</div>