<div class="ystp-bootstrap-wrapper">
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-scroll-class-name" for="ystp-scroll-class-name"><?php _e('Custom class name', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
			<input type="text" name="ystp-scroll-class-name" id="ystp-scroll-class-name" class="form-control" placeholder="<?php _e('Custom class name', YSTP_TEXT_DOMAIN); ?>" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-scroll-class-name')); ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div>
				<label for="ycd-edtitor-css" class="ystp-label-of-switch"><?php _e('Custom CSS', YSTP_TEXT_DOMAIN); ?></label>
			</div>
			<textarea id="ystp-edtitor-css" rows="5" name="ystp-custom-css" class="widefat textarea"><?php echo esc_attr($typeObj->getOptionValue('ystp-custom-css')); ?></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div>
				<label for="ycd-edtitor-js" class="ystp-label-of-switch"><?php _e('Custom JS', YSTP_TEXT_DOMAIN); ?></label>
			</div>
			<textarea id="ystp-edtitor-js" rows="5" name="ystp-custom-js" class="widefat textarea"><?php echo esc_attr($typeObj->getOptionValue('ystp-custom-js')); ?></textarea>
		</div>
	</div>
</div>