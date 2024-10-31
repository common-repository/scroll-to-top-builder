function YstpScroll() {
	this.data = {};
	this.status = false;
}

YstpScroll.init = function() {
	var scrolls = jQuery('.ystp-content');

	if(!scrolls.length) {
		return false;
	}

	for(var i in scrolls) {
		var currentIndex = parseInt(i);
		if(scrolls.hasOwnProperty(currentIndex)) {
			var scroll = scrolls[currentIndex];
			var data = jQuery(scroll).data('options');
			var obj = new YstpScroll();
			obj.data = data;
			obj.currentElement = scroll;
			obj.id = jQuery(scroll).data('id');
			obj.start();
		}
	}
};

YstpScroll.prototype.ScrollCurrentPosition = function() {
	var scrollTop = jQuery(window).scrollTop();
	var docHeight = jQuery(document).height();
	var winHeight = jQuery(window).height();

	var scrollPercent = (scrollTop) / (docHeight - winHeight);
	var scrollPercentRounded = Math.round(scrollPercent*100);

	return scrollPercentRounded
};

YstpScroll.prototype.start = function() {
	var that = this;
	var allowToShow = this.allowToShow();

	if(allowToShow) {
		that.show();
	}

	jQuery(window).on('scroll', function() {

		var allowToShow = that.allowToShow();
		if(allowToShow && !that.status) {
			that.show();
		}
	});
};

YstpScroll.prototype.allowToShow = function() {
	var data = this.data;
	var type = data['ystp-scroll-show-after'];

	if (type == 'default') {
		var measure = data['ystp-show-after-measure'];
		var showAfter = data['ystp-show-after'];

		if(measure == '%') {
			var conditionValue = this.ScrollCurrentPosition();
		}
		else {
			var conditionValue = jQuery(window).scrollTop();
		}
		if(conditionValue < showAfter) {
			this.status = false;
			this.hide();
			return false;
		}
	}
	else if (type == 'toTarget') {
		var conditionValue = jQuery(window).scrollTop();
		var target = jQuery(data['ystp-show-after']).top();

		return (conditionValue > target);
	}

	return true;
};

YstpScroll.prototype.hide = function() {
	var current = this.currentElement;
    var data = this.data;
	var hideAttrStyles = jQuery(current).data('hide-str');
	jQuery(current).parent().first().attr('style', hideAttrStyles);
    jQuery('#ystp-content-wrapper-'+data['id']).removeClass(data['ystp-showing-animation']);
};

YstpScroll.prototype.getEndPosition = function() {
    var data = this.data;
    var behavior = data['ystp-scroll-behavior'];

    if(behavior == 'default') {
    	return 0;
	}
	if (behavior == 'toTarget') {
    	var target = jQuery(data['ystp-scroll-to-selector']);
    	return target.offset().top;
	}

	return 0;
};

YstpScroll.prototype.action = function() {
	var currentButton = jQuery('.ystp-content-'+this.id);
	var data = this.data;
	var easing = data['ystp-animation-behavior'];
	var scrollToTopPosition = this.getEndPosition();

	currentButton.bind('click', function() {
		jQuery('html, body').animate(
			{
				scrollTop: scrollToTopPosition
			},
			1000,
			easing
		);
	});
};

YstpScroll.prototype.show = function() {
	this.status = true;
    var data = this.data;
	this.action();
	var current = this.currentElement;
	var inlineStyles = jQuery(current).data('styles');
	jQuery(current).parent().first().attr('style', inlineStyles);
    jQuery('#ystp-content-wrapper-'+data['id']).addClass('ystp-animated '+data['ystp-showing-animation']);
};

jQuery(document).ready(function() {
	YstpScroll.init();
});