function YstpAdmin() {
}

YstpAdmin.prototype.init = function() {
	this.multipleChoiceButton();
	this.select2();
	this.opacity();
	this.switchStatus();

	this.switchIcon();
	this.changeFontSize();
	this.changeImage();
	this.changeGiftImage();
	this.editor();
	//this.changeAnimation();
};

YstpAdmin.prototype.opacity = function () {
	var opacity = jQuery('#ystp-scroll-opacity');

	if (!opacity.length) {
		return false;
	}

    jQuery('#ystp-scroll-opacity').ionRangeSlider({
        hide_min_max: true,
        keyboard: true,
        min: 0,
        max: 1,
        type: 'single',
        step: 0.01,
        prefix: '',
        grid: false
    });
};

YstpAdmin.prototype.editor = function() {
    (function($){
        $(function(){
            if( $('#ystp-edtitor-head').length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2
                    }
                );
                var editor = wp.codeEditor.initialize( $('#ystp-edtitor-head'), editorSettings );
            }

            if( $('#ystp-edtitor-js').length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'javascript',
                    }
                );
                var editor = wp.codeEditor.initialize( $('#ystp-edtitor-js'), editorSettings );
            }

            if( $('#ystp-edtitor-css').length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'css',
                    }
                );
                var editor = wp.codeEditor.initialize( $('#ystp-edtitor-css'), editorSettings );
            }
        });
    })(jQuery);
};

YstpAdmin.prototype.changeGiftImage = function()
{
    var giftIcon = jQuery('.ystp-image-default');

    if (!giftIcon.length) {
        return false;
    }

    giftIcon.bind('click', function() {
        giftIcon.removeClass('yst-active-gift');
        jQuery(this).addClass('yst-active-gift');

        var currentImage = jQuery(this).data('image-name');
        var currentImageURL = ystp_admin_localized.imageURL+currentImage;

        jQuery('.ystp-show-image-container').css({'background-image': 'url("' + currentImageURL + '")'});
        jQuery('.ystp-no-image').remove();
        jQuery('#js-upload-image').val(currentImageURL);
    });
};

YstpAdmin.prototype.multipleChoiceButton = function() {
	var choiceOptions = jQuery('.ystp-choice-option-wrapper input');
	if(!choiceOptions.length) {
		return false;
	}

	var that = this;

	choiceOptions.each(function() {

		if(jQuery(this).is(':checked')) {
			that.buildChoiceShowOption(jQuery(this));
		}

		jQuery(this).on('change', function() {
			that.hideAllChoiceWrapper(jQuery(this).parents('.ystp-multichoice-wrapper').first());
			that.buildChoiceShowOption(jQuery(this));
		});
	})
};

YstpAdmin.prototype.hideAllChoiceWrapper = function(choiceOptionsWrapper) {
	choiceOptionsWrapper.find('input').each(function() {
		var choiceInputWrapperId = jQuery(this).attr('data-attr-href');
		jQuery('#'+choiceInputWrapperId).addClass('ystp-hide');
	})
};

YstpAdmin.prototype.buildChoiceShowOption = function(currentRadioButton)  {
	var choiceOptions = currentRadioButton.attr('data-attr-href');
	var currentOptionWrapper = currentRadioButton.parents('.ystp-choice-wrapper').first();
	var choiceOptionWrapper = jQuery('#'+choiceOptions).removeClass('ystp-hide');
	currentOptionWrapper.after(choiceOptionWrapper);
};

YstpAdmin.prototype.animateCountdown = function () {
    var button = jQuery('.ystp-scroll-to-top-icon');

    var animations = jQuery('.ystp-showing-animation');

    button.removeClass(button.data('effect'));
    var speedValue = 1;
    var animationEffect = animations.val();
    setTimeout(function () {
        button.data('effect', animationEffect);
        button.css({'animationDuration' : parseInt(speedValue)*1000 + 'ms'});
        button.addClass('ystp-animated '+animationEffect);
    }, 0);
};

YstpAdmin.prototype.changeAnimation = function() {
    var previewIcon = jQuery('.ystp-preview-icon');

    if(!previewIcon.length) {
        return false;
    }
    var that = this;
    var animations = jQuery('.ystp-showing-animation');

    previewIcon.bind('click', function() {
        that.animateCountdown();
    });

    animations.bind('change', function () {
        that.animateCountdown();
    });
};


YstpAdmin.prototype.changeImage = function() {
    var supportedImageTypes = ['image/bmp', 'image/png', 'image/jpeg', 'image/jpg', 'image/ico', 'image/gif'];
    var custom_uploader;
    if(jQuery('#js-upload-image').val()) {
        jQuery('.ystp-show-image-container').css({'background-image': 'url("' +jQuery('#js-upload-image').val() + '")'});
    }
    jQuery('#js-upload-image-button').click(function(e) {
        e.preventDefault();

		/* Extend the wp.media object */
        custom_uploader = wp.media.frames.file_frame = wp.media({
            titleFF: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });
		/* When a file is selected, grab the URL and set it as the text field's value */
        custom_uploader.on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            if (supportedImageTypes.indexOf(attachment.mime) === -1) {
                return;
            }
            jQuery(".ystp-show-image-container").css({'background-image': 'url("' + attachment.url + '")'});
            jQuery(".ystp-show-image-container").html("");
            jQuery('#js-upload-image').val(attachment.url);
        });
		/* If the uploader object has already been created, reopen the dialog */
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
    });
};

YstpAdmin.prototype.changeFontSize = function() {
	var fontSize = jQuery('#ystp-icon-font-size');

	if(!fontSize.length) {
		return false;
	}

	fontSize.bind('change', function() {
		var val = jQuery(this).val();
		val = parseInt(val)+'px';
		jQuery('#icon-font-size').remove();
		jQuery('body').append('<style id="icon-font-size">.ystp-scroll-to-top-icon:before {font-size: '+val+' !important; }</style>')
	});
};

YstpAdmin.prototype.switchIcon = function() {
	var switchSelect = jQuery('.js-ystp-icon-types');

	if(!switchSelect.length) {
		return false;
	}

	var defaultSelected = jQuery('option:selected', switchSelect);

	switchSelect.bind('change', function() {
		var currentValue = jQuery('option:selected', this).val();
		jQuery('.ystp-scroll-to-top-icon').removeClass('ystp-'+defaultSelected).addClass('ystp-'+currentValue);
		defaultSelected = currentValue;
	});
};

YstpAdmin.prototype.switchStatus = function() {
	var switchStatus = jQuery('.ystp-accordion-checkbox');

	if(!switchStatus.length) {
		return false;
	}

	switchStatus.each(function() {
		jQuery(this).bind('change', function() {
			var data = {
				action: 'ystp-switch',
				nonce: ystp_admin_localized.nonce,
				id: jQuery(this).data('id'),
				checked: jQuery(this).is(':checked')
			};

			jQuery.post(ajaxurl, data, function() {

			});
		})
	});
};

YstpAdmin.prototype.select2 = function() {
	var select2 = jQuery('.ystp-conditions-wrapper .js-ystp-select');

	if(!select2.length) {
		return false;
	}
	select2.each(function() {
		var type = jQuery(this).data('select-type');

		var options = {
			width: '100%'
		};
		
		if (type == 'ajax') {
			options = jQuery.extend(options, {
				minimumInputLength: 1,
				ajax: {
						url: ajaxurl,
						dataType: 'json',
						delay: 250,
						type: "POST",
						data: function(params) {

								var searchKey = jQuery(this).attr('data-value-param');

								return {
										action: 'ystp_select2_search_data',
										nonce_ajax: ystp_admin_localized.nonce,
										searchTerm: params.term,
										searchKey: searchKey
								};
						},
						processResults: function(data) {
								return {
										results: jQuery.map(data.items, function(item) {

												return {
														text: item.text,
														id: item.id
												}

										})
								};
						}
				}
			});
		}

		jQuery(this).select2(options);
	});
};

jQuery(document).ready(function() {
	var obj = new YstpAdmin();
	obj.init();
});