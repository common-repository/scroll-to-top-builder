<?php
use ystp\AdminHelper;
use ystp\MultipleChoiceButton;
$defaultData = AdminHelper::defaultData();
?>

<div class="ystp-bootstrap-wrapper">
    
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-animation-speed" class="ystp-label-of-input"><?php _e('Show Button', YSTP_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
        </div>
    </div>
    <div class="ystp-sub-options-wrapper">
        <div class="ystp-multichoice-wrapper">
            <?php
            $multipleChoiceButton = new MultipleChoiceButton($defaultData['startAfter'], esc_attr($typeObj->getOptionValue('ystp-scroll-show-after')));
            echo $multipleChoiceButton;
            ?>
        </div>
        <div id="ystp-show-after-default" class="ystp-hide">
            <div class="ystp-sub-sub-options-wrapper">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ystp-show-after" class="ystp-label-of-input"><?php _e('Show after', YSTP_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" id="ystp-show-after" name="ystp-show-after" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-show-after')); ?>">
                    </div>
                    <div class="col-md-2">
			            <?php echo AdminHelper::selectBox($defaultData['showAfter'], esc_attr($typeObj->getOptionValue('ystp-show-after-measure')), array('name' => 'ystp-show-after-measure', 'class' => 'js-ystp-select')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="ystp-show-after-target" class="ystp-hide">
            <div class="ystp-sub-sub-options-wrapper">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ystp-show-after-selector" class="ystp-label-of-input"><?php _e('CSS Selector', YSTP_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="ystp-show-after-selector" placeholder="Ex: #myDivID, .myDivClass" name="ystp-show-after-selector" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-show-after-selector')); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-animation-speed" class="ystp-label-of-input"><?php _e('Button Action', YSTP_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
        </div>
    </div>
    <div class="ystp-sub-options-wrapper">
        <div class="ystp-multichoice-wrapper">
            <?php
                $multipleChoiceButton = new MultipleChoiceButton($defaultData['buttonActionBehavior'], esc_attr($typeObj->getOptionValue('ystp-scroll-behavior')));
                echo $multipleChoiceButton;
            ?>
        </div>
    </div>
	<div id="ystp-to-target" class="ystp-hide">
        <div class="ystp-sub-sub-options-wrapper">
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ystp-scroll-to-selector" class="ystp-label-of-input"><?php _e('CSS Selector', YSTP_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="ystp-scroll-to-selector" placeholder="Ex: #myDivID, .myDivClass" name="ystp-scroll-to-selector" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-scroll-to-selector')); ?>">
                </div>
            </div>
        </div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ystp-animation-speed" class="ystp-label-of-input"><?php _e('Animation speed', YSTP_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
			<input type="number" class="form-control" id="ystp-animation-speed" name="ystp-animation-speed" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-animation-speed')); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select"><?php _e('Animation behavior', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
			<?php echo AdminHelper::selectBox($defaultData['animationBehavior'], esc_attr($typeObj->getOptionValue('ystp-animation-behavior')), array('name' => 'ystp-animation-behavior', 'class' => 'js-ystp-select')); ?>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select"><?php _e('Location', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
			<?php echo AdminHelper::selectBox($defaultData['location'], esc_attr($typeObj->getOptionValue('ystp-button-position')), array('name' => 'ystp-button-position', 'class' => 'js-ystp-select')); ?>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select" for="ystp-margin-x"><?php _e('Margin X', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-4">
			<input type="text" name="ystp-margin-x" id="ystp-margin-x" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-margin-x')); ?>">
		</div>
		<div class="col-md-1">
			<span class="ystp-label-of-input"><?php _e('Px', YSTP_TEXT_DOMAIN)?></span>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select" for="ystp-margin-y"><?php _e('Margin Y', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-4">
			<input type="text" name="ystp-margin-y" id="ystp-margin-y" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-margin-y')); ?>">
		</div>
		<div class="col-md-1">
			<span class="ystp-label-of-input"><?php _e('Px', YSTP_TEXT_DOMAIN)?></span>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select ystp-range-slider-wrapper" for="ystp-scroll-opacity""><?php _e('Opacity', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
			<input type="text" name="ystp-scroll-opacity" id="ystp-scroll-opacity"" class="form-control " value="<?php echo esc_attr($typeObj->getOptionValue('ystp-scroll-opacity')); ?>">
		</div>
	</div>
    <div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select" for="ystp-z-index"><?php _e('Z index', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
			<input type="text" name="ystp-z-index" id="ystp-z-index" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-z-index')); ?>">
		</div>
	</div>
    <div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-scroll-title" for="ystp-scroll-title"><?php _e('Title', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
			<input type="text" name="ystp-scroll-title" id="ystp-scroll-title" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ystp-scroll-title')); ?>">
		</div>
	</div>
    <div class="row form-group">
		<div class="col-md-6">
			<label class="ystp-label-of-select"><?php _e('Showing animation', YSTP_TEXT_DOMAIN); ?>:</label>
		</div>
		<div class="col-md-5">
            <?php echo AdminHelper::selectBox($defaultData['animationEffects'], esc_attr($typeObj->getOptionValue('ystp-showing-animation')), array('name' => 'ystp-showing-animation', 'class' => 'js-ystp-select ystp-showing-animation')); ?>
		</div>
	</div>
</div>