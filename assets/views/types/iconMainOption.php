<?php
use ystp\AdminHelper;

$defaultData = AdminHelper::defaultData();
$savedButtonType = $this->getOptionValue('ystp-icon-type');
$isPro = '';
$proSpan = '';
if(YSTP_PKG_VERSION == YSTP_FREE_VERSION) {
    $isPro = '-pro';
    $proSpan = '<a class="ystp-pro-span" href="'.YSTP_PRO_URL.'" target="_blank">'.__('pro', YSTP_TEXT_DOMAIN).'</a>';
}
?>
<div class="ystp-bootstrap-wrapper">
    <div class="row form-group">
        <div class="col-md-8">
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ystp-button-text" class="ystp-label-of-select"><?php _e('Select icon type', YSTP_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-5 ystp-select-wrapper">
                    <?php echo AdminHelper::selectBox($defaultData['iconTypes'], esc_attr($savedButtonType), array('name' => 'ystp-icon-type', 'class' => 'js-ystp-select js-ystp-icon-types'));?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ystp-icon-font-size" class="ystp-label-of-input"><?php _e('Icon font size', YSTP_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="ystp-icon-font-size" name="ystp-icon-font-size" value="<?php echo esc_attr($this->getOptionValue('ystp-icon-font-size')); ?>">
                </div>
                <div class="col-md-1">
                    <span class="ystp-label-of-input">Px</span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ystp-icon-font-size" class="ystp-label-of-input"><?php _e('Color', YSTP_TEXT_DOMAIN);  echo $proSpan; ?></label>
                </div>
                <div class="col-md-4 ystp-option-wrapper<?php echo $isPro; ?>">
                    <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                        <input type="text" placeholder="<?php _e('Select color', YSTP_TEXT_DOMAIN)?>" name="ystp-icon-color" class="minicolors-input js-ystp-icon-color" value="<?php echo esc_attr($this->getOptionValue('ystp-icon-color')); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row form-group ystp-live-preview-wrapper">
                <h3 class="ystp-type-live-preview-text"><?php _e('Live Preview', YSTP_TEXT_DOMAIN)?></h3>
                <?php echo $this->getButton(); ?>
            </div>
        </div>
    </div>
</div>