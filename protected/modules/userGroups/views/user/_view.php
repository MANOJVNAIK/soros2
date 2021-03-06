<div class="grid_2">
        <div class="clearfix " style="padding:5px;font-size:12px !important;">

            <label class="form-label" for="form-name"><?php echo "Group"; ?>:</label>

            <div class="form-label "  >

                <?php echo CHtml::encode($data->relUserGroupsGroup->groupname); ?><br/>
            </div>

        </div>
        <div class="clearfix " style="padding:5px;font-size:12px !important;">
<?php if (Yii::app()->user->id === $data->id || Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin')): ?>
            <label class="form-label" for="form-name">
			
			<?php echo "Email"; ?>:
			</label>

            <div class="form-label">
				<?php echo CHtml::encode($data->email); ?>
            </div>
			<?php endif; ?>

        </div>
        <div class="clearfix " style="padding:5px;font-size:12px !important;">

            <label class="form-label" for="form-name">
			<?php echo "Home-Page"; ?>
			</label>

            <div class="form-label">
				<?php echo $data->readable_home; ?>
            </div>

        </div>
        <div class="clearfix " style="padding:5px;font-size:12px !important;">
		<?php if (Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin') || Yii::app()->user->id === $data->id): ?>
            <label class="form-label" for="form-name">
			
			<?php echo "Status"; ?>:
			</label>

            <div class="form-label">
				<?php echo CHtml::encode(UserGroupsLookup::resolve('status', $data->status)); ?>
            </div>
			<?php endif; ?>
        </div>
</div>


<?php #form for user approval ?>
<?php if ((Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin')) && (int)$data->status === UserGroupsUser::WAITING_APPROVAL) : ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-groups-approval-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->baseUrl.'/userGroups/user/approve',
)); ?>
<div class="row buttons">
	<?php echo CHtml::hiddenField('UserGroupsApprove[id]', $data->id); ?>
	<?php echo CHtml::submitButton(Yii::t('userGroupsModule.general','Approve Registration'), array('onclick' => 'js: if(confirm("'. Yii::t('userGroupsModule.admin', 'Do you really want to approve {who} registration?', array('{who}' => $data->username)).'")) {return true;}else{return false;}')); ?>
</div>
<?php $this->endWidget(); ?>
<?php endif; ?>

<?php #form used to ban user ?>
<?php if ((Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin')) && (int)$data->status === UserGroupsUser::ACTIVE && $data->relUserGroupsGroup->level < Yii::app()->user->level) : ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-groups-ban-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->baseUrl.'/userGroups/user/ban',
)); ?>
<div class="row buttons">
	<?php echo CHtml::hiddenField('UserGroupsBan[id]', $data->id); ?>
	<?php echo CHtml::label(Yii::t('userGroupsModule.admin','Ban Reason'), 'UserGroupsBan_reason'); ?> 
	<?php echo CHtml::textField('UserGroupsBan[reason]'); ?>
	<?php echo CHtml::label(Yii::t('userGroupsModule.admin','Ban Period'), 'UserGroupsBan_period'); ?>
	<?php 
	$ban_periods = array(
		1 => Yii::t('userGroupsModule.admin','{n} Day|{n} Days', array(1)), 
		3 => Yii::t('userGroupsModule.admin','{n} Day|{n} Days', array(3)), 
		5 => Yii::t('userGroupsModule.admin','{n} Day|{n} Days', array(5)),
		7 => Yii::t('userGroupsModule.admin','{n} Day|{n} Days', array(7)),
		14 => Yii::t('userGroupsModule.admin','{n} Week|{n} Weeks', array(2)), 
		28 => Yii::t('userGroupsModule.admin','{n} Month|{n} Months', array(1)), 
		56 => Yii::t('userGroupsModule.admin','{n} Month|{n} Months', array(2)),
		84 => Yii::t('userGroupsModule.admin','{n} Month|{n} Months', array(3)),
		400 => Yii::t('userGroupsModule.admin','Forever'),
	);
	?> 
	<?php echo CHtml::dropDownList('UserGroupsBan[period]', NULL, $ban_periods); ?>
	<?php echo CHtml::submitButton(Yii::t('userGroupsModule.general','Ban User'), array('onclick' => 'js: if(confirm("'. Yii::t('userGroupsModule.admin', 'Do you really want to ban {who}?', array('{who}' => $data->username)).'")) {return true;}else{return false;}')); ?>
</div>
<?php $this->endWidget(); ?>
<?php endif; ?>