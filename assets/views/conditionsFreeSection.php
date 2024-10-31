<?php
use ystp\AdminHelper;
$conditiosnKeys = AdminHelper::conditionsKeys();
$operators = array('is' => __('Is', YSTP_TEXT_DOMAIN));
$keys = array_keys($conditiosnKeys);
$fieldAttributes = array(
	'class' => 'ystp-condition-select js-ystp-select',
	'value' => ''
);
?>
<div class="ystp-bootstrap-wrapper ystp-conditions-free-section-wrapper">
	<div class="row">
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select Conditions', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox($conditiosnKeys, $keys[1], $fieldAttributes)?>
		</div>
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select Conditions', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox($operators, 'is', $fieldAttributes)?>
		</div>
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select user devices', YSTP_TEXT_DOMAIN);?></label></div>
			<input type="text" class="form-control" value="<?php _e('Select needed devices', YSTP_TEXT_DOMAIN); ?>">
		</div>
		<div class="col-md-3">
			<a href="<?php echo YSTP_PRO_URL; ?>" target="_blank" class="btn btn-warning btn-xs yst-conditions-pro-button" style="margin-top: 22px;">
				<?php _e('Permimum', YSTP_TEXT_DOMAIN); ?>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select Conditions', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox($conditiosnKeys, $keys[3], $fieldAttributes)?>
		</div>
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select Conditions', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox($operators, 'is', $fieldAttributes); ?>
		</div>
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select countries', YSTP_TEXT_DOMAIN);?></label></div>
			<input type="text" class="form-control" value="<?php _e('Select needed countries', YSTP_TEXT_DOMAIN); ?>">
		</div>
		<div class="col-md-3">
			<a href="<?php echo YSTP_PRO_URL; ?>" target="_blank" class="btn btn-warning btn-xs yst-conditions-pro-button" style="margin-top: 22px;">
				<?php _e('Permimum', YSTP_TEXT_DOMAIN); ?>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select Conditions', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox($conditiosnKeys, $keys[2], $fieldAttributes)?>
		</div>
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select Conditions', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox($operators, 'is', $fieldAttributes)?>
		</div>
		<div class="col-md-3">
			<div class="ystp-condition-header"><label><?php _e('Select user status', YSTP_TEXT_DOMAIN);?></label></div>
			<?php echo AdminHelper::selectBox(array('logged_in' => __('logged In', YSTP_TEXT_DOMAIN)), '', $fieldAttributes); ?>
		</div>
		<div class="col-md-3">
			<a href="<?php echo YSTP_PRO_URL; ?>" target="_blank" class="btn btn-warning btn-xs yst-conditions-pro-button" style="margin-top: 22px;">
				<?php _e('Permimum', YSTP_TEXT_DOMAIN); ?>
			</a>
		</div>
	</div>
	<div class="ystp-pro-options-restric">
	<div class="row">
		<div class="col-md-12">
		</div>
	</div>
</div>
</div>