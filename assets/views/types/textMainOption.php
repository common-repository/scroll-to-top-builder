<?php
use ystp\AdminHelper;

$defaultData = AdminHelper::defaultData();
$isPro = '';
$proSpan = '';
if(YSTP_PKG_VERSION == YSTP_FREE_VERSION) {
    $isPro = '-pro';
    $proSpan = '<a class="ystp-pro-span" href="'.YSTP_PRO_URL.'" target="_blank">'.__('pro', YSTP_TEXT_DOMAIN).'</a>';
}
?>
<div class="ystp-bootstrap-wrapper">
	<div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-button-text" class="ystp-label-of-input"><?php _e('Text', YSTP_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" id="ystp-button-text" name="ystp-button-text" value="<?php echo esc_attr($this->getOptionValue('ystp-button-text')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-text-font-size" class="ystp-label-of-input"><?php _e('Font size', YSTP_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" id="ystp-text-font-size" name="ystp-text-font-size" value="<?php echo esc_attr($this->getOptionValue('ystp-text-font-size')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-text-font-size" class="ystp-label-of-input"><?php _e('Font weight', YSTP_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
            <?php echo AdminHelper::selectBox($defaultData['fontWeight'], esc_attr($this->getOptionValue('ystp-text-type-font-weight')), array('name' => 'ystp-text-type-font-weight', 'class' => 'js-ystp-select')); ?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-icon-font-family" class="ystp-label-of-input"><?php _e('Font family', YSTP_TEXT_DOMAIN);  echo $proSpan; ?></label>
        </div>
        <div class="col-md-5 ystp-option-wrapper<?php echo $isPro; ?>">
            <?php echo AdminHelper::selectBox($defaultData['textFontFamily'], esc_attr($this->getOptionValue('ystp-text-type-font-family')), array('name' => 'ystp-text-type-font-family', 'class' => 'js-ystp-select'));?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ystp-icon-font-size" class="ystp-label-of-input"><?php _e('Color', YSTP_TEXT_DOMAIN);  echo $proSpan; ?></label>
        </div>
        <div class="col-md-4 ystp-option-wrapper<?php echo $isPro; ?>">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" placeholder="<?php _e('Select color', YSTP_TEXT_DOMAIN)?>" name="ystp-text-type-color" class="minicolors-input js-ystp-text-type-color" value="<?php echo esc_attr($this->getOptionValue('ystp-text-type-color')); ?>">
            </div>
        </div>
    </div>
</div>