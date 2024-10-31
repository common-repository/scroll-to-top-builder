<div class="ystp-bootstrap-wrapper">
    <div class="yst-images-wrapper">
    <?php
        $imageURl = $this->getOptionValue('ystp-image-url');
    ?>
    <?php for($i = 1; $i <= YSTP_IMAGES_COUNT; ++$i): ?>
        <?php
        $selected = '';
        if ($imageURl == YSTP_IMG_URL.$i.'.png') {
            $selected = 'yst-active-gift';
        }
        ?>
        <div class="ystp-image-default ystp-image-default-<?php echo $i.' '.$selected; ?>" data-image-name="<?php echo $i; ?>.png" style="background-image: url('<?php echo YSTP_IMG_URL.$i; ?>.png);"></div>
    <?php endfor; ?>
    </div>
    <div class="ystp-picture-h">
        <h3><?php _e('Please choose your picture', YSTP_TEXT_DOMAIN);?></h3>
    </div>
    <div class="ystp-image-uploader-wrapper">
        <input class="input-width-static" id="js-upload-image" type="text" size="36" name="ystp-image-url" value="<?php echo esc_attr($this->getOptionValue('ystp-image-url')); ?>" required>
        <input id="js-upload-image-button" class="button" type="button" value="<?php _e('Select image', YSTP_TEXT_DOMAIN);?>">
    </div>
    <div class="ystp-show-image-container">
    </div>
</div>
