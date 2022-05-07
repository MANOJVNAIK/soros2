    <div class="portlet">
	<header>
	    <h2><?php echo Yii::t('rm_settings',"Basic Layout Settings");?> </h2>
	</header>
	<section>
	    <form class="form has-validation" onsubmit="moveAhead('#portlet-pane-2','#portlet-pane-1'); return false;" >
		<div class="clearfix">
		    <label for="form-timezone" class="form-label">
			<?php echo Yii::t('rm_settings',"Default Language");?></label>
		    <div class="form-input">
			<div class="buttonset leading">
							<input type="radio" name="button-togglel" id="button-toggle-l1" value="1" style="left: 0px; top: 0px; height: 20px" onClick="changeLang('es','<?php echo Yii::app()->user->getId(); ?>'); return false;" /><label for="button-toggle-l1" aria-pressed="true" >English</label>
			    <input type="radio" name="button-togglel" id="button-toggle-l2" value="2"  onClick="changeLang('hind','<?php echo Yii::app()->user->getId(); ?>'); return false;" /><label for="button-toggle-l2">Hindi</label>
			    <input type="radio" name="button-togglel" id="button-toggle-l3" value="3"  onClick="changeLang('zh-cn','<?php echo Yii::app()->user->getId(); ?>'); return false;" /><label for="button-toggle-l3">Chinese</label>
			</div>
		    </div>
		</div>
		<div class="clearfix">
		    <label for="form-timezone" class="form-label"><?php echo Yii::t('rm_settings',"Layout Style");?> <small><?php echo Yii::t('rm_settings',"");?>Wide/Thin</small></label>
		    <div class="form-input">
			<div class="buttonset leading">
							<input type="radio" name="button-toggle" id="button-toggle-1" value="1" style="left: 0px; top: 0px; height: 20px" onClick="changeLayoutStyle('<?php echo Yii::app()->theme->baseUrl ."/css/cu_grid_";?>', 'thin','<?php echo Yii::app()->user->getId(); ?>'); return false;" /><label for="button-toggle-1" aria-pressed="false" ><?php echo Yii::t('rm_settings',"Thin");?></label>
			    <input type="radio" name="button-toggle" id="button-toggle-2" value="2"  onClick="changeLayoutStyle('<?php echo Yii::app()->theme->baseUrl ."/css/cu_grid_";?>', 'wide','<?php echo Yii::app()->user->getId(); ?>'); return false;"/><label for="button-toggle-2">Wide</label>
			</div>
			<fieldset class="ui-corner-all">
			    <legend><?php echo Yii::t('rm_settings',"Choose Wide or Thin");?></legend>
			    <section>
				<ul id="theme-layouts" class="clearfix">
				    <li><a href="#" style="background: transparent url(<?php echo Yii::app()->theme->baseUrl; ?>/images/layouts/layout_thin.png) repeat 0 0;" onClick="#"></a></li>
				    <li><a href="#" style="background: transparent url(<?php echo Yii::app()->theme->baseUrl; ?>/images/layouts/layout_wide.png) repeat 0 0;" onClick="#"></a></li>
				</ul>
			    </section>
			</fieldset>
		    </div>
		</div>
		<div class="clearfix">
		    <label for="form-email" class="form-label"><?php echo Yii::t('rm_settings',"Color Scheme");?><small><?php echo Yii::t('rm_settings',"Choose a dark shade");?></small></label>
		    <div class="form-input">
			<fieldset class="ui-corner-all">
			    <legend><?php echo Yii::t('rm_settings',"Pick a Color");?></legend>
			    <section>
				<ul id="theme-colorschemes" class="clearfix">
				    <li><a href="#" title="Glass" style="background-color: #d8d0ef;" rel="<?php echo Yii::app()->theme->baseUrl; ?>/css/ui/default-ui/colors/jquery.ui.colors." onClick="changeUicolor($(this).attr('rel'),'glass','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" title="Gray" style="background-color: #d4e4ef;" rel="<?php echo Yii::app()->theme->baseUrl; ?>/css/ui/default-ui/colors/jquery.ui.colors." onClick="changeUicolor($(this).attr('rel'),'gray','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" title="Blue" style="background-color: #60abf8;" rel="<?php echo Yii::app()->theme->baseUrl; ?>/css/ui/default-ui/colors/jquery.ui.colors." onClick="changeUicolor($(this).attr('rel'),'blue','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" title="Red" style="background-color: #8f0222;" rel="<?php echo Yii::app()->theme->baseUrl; ?>/css/ui/default-ui/colors/jquery.ui.colors." onClick="changeUicolor($(this).attr('rel'),'red','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" title="Default" style="background-color: #dfdfdf;" class="selectColor" rel="<?php echo Yii::app()->theme->baseUrl; ?>/css/ui/default-ui/colors/jquery.ui.colors." onClick="changeUicolor($(this).attr('rel'),'silver','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				</ul>
			    </section>
			</fieldset>
		    </div>
		</div>
		<div class="clearfix">
		    <label for="form-username" class="form-label"><?php echo Yii::t('rm_settings',"Pick a Theme");?><small><?php echo Yii::t('rm_settings',"Darker Theme is better");?></small></label>
		    <div class="form-input">
			<fieldset class="ui-corner-all leading">
			    <legend><?php echo Yii::t('rm_settings',"Background");?></legend>
			    <section>
				<ul id="theme-backgrounds" class="clearfix">
				    <li><a href="#" style="background: transparent url(../images/backgrounds/03.png) repeat 0 0;" onClick="changeBackground('bg','bg03-png','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" class="selectColor" style="background: transparent url(../images/backgrounds/02.png) repeat 0 0;" onClick="changeBackground('bg','bg02-png'); return false;"></a></li>
				    <li><a href="#" style="background: transparent url(../images/backgrounds/05.png) repeat 0 0;" onClick="changeBackground('bg','bg05-png','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" style="background: transparent url(../images/backgrounds/04.png) repeat 0 0;" onClick="changeBackground('bg','bg04-png','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				    <li><a href="#" style="background: transparent url(../images/backgrounds/01.png) repeat 0 0;" onClick="changeBackground('bg','bg01-png','<?php echo Yii::app()->user->getId(); ?>'); return false;"></a></li>
				</ul>
			    </section>
			</fieldset>
					</div>
		</div>
		<div class="clearfix">
		    <label for="form-updates" class="form-label"><?php echo Yii::t('rm_settings',"Apply for All users ?");?><small><?php echo Yii::t('rm_settings',"Uniform look");?>.</small></label>
		    <div class="form-input"><input type="checkbox" id="form-updates" value="1" /></div>
		</div>
		<div class="form-action clearfix">
		    <button class="button" type="submit" data-icon-primary="ui-icon-circle-check" name="goNextPanel" href="#portlet-pane-2" ><?php echo Yii::t('rm_settings',"Next");?></button>
		    <button class="button" type="reset"><?php echo Yii::t('rm_settings',"Reset");?></button>
		</div>
	    </form>
	</section>
    </div>