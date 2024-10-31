<?php
namespace ystp;
use \WP_Query;

class AdminHelper {

    public static function buildCreateCountdownUrl($type) {
        $isAvailable = $type->isAvailable();
        $name = $type->getName();

        $url = YSTP_ADMIN_URL.'post-new.php?post_type='.YSTP_POST_TYPE.'&ystp_type='.$name;

        if (!$isAvailable) {
            $url = YSTP_PRO_URL;
        }

        return $url;
    }

    public static function buildCreateScrollAttrs($type) {
    	$attrStr = '';
	    $isAvailable = $type->isAvailable();

	    if (!$isAvailable) {
	    	$args = array(
				'target' => '_blank'
		    );
		    $attrStr = self::createAttrs($args);
	    }

	    return $attrStr;
    }

    public static function getScrollThumbClass($type) {
        $isAvailable = $type->isAvailable();
        $name = $type->getName();

        $typeClassName = $name.'-scroll';

        if (!$isAvailable) {
            $typeClassName .= '-pro ystp-pro-version';
        }

        return $typeClassName;
    }
    
    public static function defaultData() {

        $data = array();
	
	    $data['showAfter'] = array(
	        'px' => __('px', YSTP_TEXT_DOMAIN),
	        '%' => __('%', YSTP_TEXT_DOMAIN)
	    );
	    
	    $animationBehavior = array(
	        'linear' => __('Linear', YSTP_TEXT_DOMAIN),
	        'swing' => __('Swing', YSTP_TEXT_DOMAIN),
	        'easeInQuad' => __('Ease In Quad', YSTP_TEXT_DOMAIN),
            'easeOutQuad' => __('Ease Out Quad', YSTP_TEXT_DOMAIN),
            'easeInOutQuad' => __('Ease In Out Quad', YSTP_TEXT_DOMAIN),
            'easeInCubic' => __('Ease In Cubic', YSTP_TEXT_DOMAIN),
            'easeOutCubic' => __('Ease Out Cubic', YSTP_TEXT_DOMAIN),
            'easeInOutCubic' => __('Ease In Out Cubic', YSTP_TEXT_DOMAIN),
            'easeInQuart' => __('Ease In Quart', YSTP_TEXT_DOMAIN),
            'easeOutQuart' => __('Ease Out Quart', YSTP_TEXT_DOMAIN),
            'easeInOutQuart' => __('Ease In Out Quart', YSTP_TEXT_DOMAIN),
            'easeInQuint' => __('Ease In Quint', YSTP_TEXT_DOMAIN),
            'easeOutQuint' => __('Ease Out Quint', YSTP_TEXT_DOMAIN),
            'easeInOutQuint' => __('Ease In Out Quint', YSTP_TEXT_DOMAIN),
            'easeInExpo' => __('Ease In Expo', YSTP_TEXT_DOMAIN),
            'easeOutExpo' => __('Eas\'Ease Out Expo\'e In Out Cubic', YSTP_TEXT_DOMAIN),
            'easeInOutExpo' => __('Ease In Out Expo', YSTP_TEXT_DOMAIN),
            'easeInSine' => __('Ease In Sine', YSTP_TEXT_DOMAIN),
            'easeOutSine' => __('Ease Out Sine', YSTP_TEXT_DOMAIN),
            'easeInOutSine' => __('Ease In Out Sine', YSTP_TEXT_DOMAIN),
            'easeInCirc' => __('Ease In Circ', YSTP_TEXT_DOMAIN),
            'easeOutCirc' => __('Ease Out Circ', YSTP_TEXT_DOMAIN),
            'easeInOutCirc' => __('Ease In Out Circ', YSTP_TEXT_DOMAIN),
            'easeInElastic' => __('Ease In Elastic', YSTP_TEXT_DOMAIN),
            'easeOutElastic' => __('Ease Out Elastic', YSTP_TEXT_DOMAIN),
            'easeInOutElastic' => __('Ease In Out Elastic', YSTP_TEXT_DOMAIN),
            'easeInBack' => __('Ease In Back', YSTP_TEXT_DOMAIN),
            'easeOutBack' => __('Ease Out Back', YSTP_TEXT_DOMAIN),
            'easeInOutBack' => __('Ease In Out Back', YSTP_TEXT_DOMAIN),
            'easeInBounce' => __('Ease In Bounce', YSTP_TEXT_DOMAIN),
            'easeOutBounce' => __('Ease Out Bounce', YSTP_TEXT_DOMAIN),
            'easeInOutBounce' => __('Ease In Out Bounce', YSTP_TEXT_DOMAIN)
	    );
	    $data['animationBehavior'] = apply_filters('ystpAnimationBehavior', $animationBehavior);
	    $iconTypes = array(
	        'arrow1' => __('Icon 1', YSTP_TEXT_DOMAIN),
	        'arrow2' => __('Icon 2', YSTP_TEXT_DOMAIN),
	        'arrow3' => __('Icon 3', YSTP_TEXT_DOMAIN),
	        'arrow4' => __('Icon 4', YSTP_TEXT_DOMAIN),
	        'arrow5' => __('Icon 5', YSTP_TEXT_DOMAIN),
	        'arrow6' => __('Icon 6', YSTP_TEXT_DOMAIN),
	        'arrow7' => __('Icon 7', YSTP_TEXT_DOMAIN),
	        'arrow8' => __('Icon 8', YSTP_TEXT_DOMAIN),
	        'arrow9' => __('Icon 9', YSTP_TEXT_DOMAIN),
	        'arrow10' => __('Icon 10', YSTP_TEXT_DOMAIN),
	        'arrow11' => __('Icon 11', YSTP_TEXT_DOMAIN)
	    );

	    $data['location'] = array(
			'bottom-right' => __('Bottom right', YSTP_TEXT_DOMAIN),
			'bottom-left' => __('Bottom left', YSTP_TEXT_DOMAIN),
			'top-right' => __('Top right', YSTP_TEXT_DOMAIN),
			'top-left' => __('Top left', YSTP_TEXT_DOMAIN)
		);

	    $data['animationEffects'] = array(
            '' => 'No effect',
            'ystp-flash' => 'Flash',
            'ystp-pulse' => 'Pulse',
            'ystp-rubberBand' => 'RubberBand',
            'ystp-shake' => 'Shake',
            'ystp-tada' => 'Tada',
            'ystp-jello' => 'Jello'
        );

	    $data['textFontFamily'] = array(
            'Arial' => 'Arial',
            'Diplomata SC' => 'Diplomata SC',
            'flavors'=>'Flavors',
            'Open Sans'=> 'Open Sans',
            'Droid Sans'=>'Droid Sans',
            'Droid Serif'=>'Droid Serif',
            'chewy'=>'Chewy',
            'oswald' => 'Oswald',
            'Dancing Script'=> 'Dancing Script',
            'Merriweather'=>'Merriweather',
            'Roboto Condensed'=>'Roboto Condensed',
            'Oswald'=>'Oswald',
            'PT Sans'=>'PT Sans',
            'Montserrat'=>'Montserrat',
            'customFont' => 'Custom font'
        );

        $data['startAfter'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-2 ystp-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ystp-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ystp-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ystp-scroll-show-after',
						'class' => 'ystp-scroll-behavior',
						'data-attr-href' => 'ystp-show-after-default',
						'value' => 'default'
					),
					'label' => array(
						'name' => __('After Scroll', YSTP_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ystp-scroll-show-after',
						'class' => 'ystp-flip-countdown-hide-behavior',
						'data-attr-href' => 'ystp-show-after-target',
						'value' => 'toTarget'
					),
					'label' => array(
						'name' => __('After Element', YSTP_TEXT_DOMAIN)
					)
				)
			)
		);
        
        $data['buttonActionBehavior'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-2 ystp-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ystp-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ystp-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ystp-scroll-behavior',
						'class' => 'ystp-scroll-behavior',
						'data-attr-href' => 'ystp-flip-countdown-default-behavior',
						'value' => 'default'
					),
					'label' => array(
						'name' => __('Scroll to Top', YSTP_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ystp-scroll-behavior',
						'class' => 'ystp-flip-countdown-hide-behavior',
						'data-attr-href' => 'ystp-to-target',
						'value' => 'toTarget'
					),
					'label' => array(
						'name' => __('Scroll to Element', YSTP_TEXT_DOMAIN)
					)
				)
			)
		);

	    $data['iconTypes'] = apply_filters('ystpIconTypes', $iconTypes);
	
	    $data['fontWeight'] = array(
		    'normal' => __('Normal', YSTP_TEXT_DOMAIN),
		    'bold' => __('Bold', YSTP_TEXT_DOMAIN),
		    'bolder' => __('Bolder', YSTP_TEXT_DOMAIN),
		    'lighter' => __('Lighter', YSTP_TEXT_DOMAIN),
		    '100' => __('100', YSTP_TEXT_DOMAIN),
		    '200' => __('200', YSTP_TEXT_DOMAIN),
		    '300' => __('300', YSTP_TEXT_DOMAIN),
		    '400' => __('400', YSTP_TEXT_DOMAIN),
		    '500' => __('500', YSTP_TEXT_DOMAIN),
		    '600' => __('600', YSTP_TEXT_DOMAIN),
		    '700' => __('700', YSTP_TEXT_DOMAIN),
		    '800' => __('800', YSTP_TEXT_DOMAIN),
		    '900' => __('900', YSTP_TEXT_DOMAIN),
		    'initial' => __('Initial', YSTP_TEXT_DOMAIN),
		    'inherit' => __('Inherit', YSTP_TEXT_DOMAIN)
	    );
	    
	    return apply_filters('ystpDefaults', $data);
    }
    

    public static function selectBox($data, $selectedValue, $attrs) {

        $attrString = '';
        $selected = '';

        if(!empty($attrs) && isset($attrs)) {

            foreach ($attrs as $attrName => $attrValue) {
                $attrString .= ''.$attrName.'="'.$attrValue.'" ';
            }
        }

        $selectBox = '<select '.$attrString.'>';

        foreach ($data as $value => $label) {

            /*When is multiselect*/
            if(is_array($selectedValue)) {
                $isSelected = in_array($value, $selectedValue);
                if($isSelected) {
                    $selected = 'selected';
                }
            }
            else if($selectedValue == $value) {
                $selected = 'selected';
            }
            else if(is_array($value) && in_array($selectedValue, $value)) {
                $selected = 'selected';
            }

            $selectBox .= '<option value="'.esc_attr($value).'" '.$selected.'>'.$label.'</option>';
            $selected = '';
        }

        $selectBox .= '</select>';

        return $selectBox;
    }

	/**
	 * Create html attrs
	 *
	 * @since 1.0.9
	 *
	 * @param array $attrs
	 *
	 * @return string $attrStr
	 */
	public static function createAttrs($attrs)
	{
		$attrStr = '';

		if (empty($attrs)) {
			return $attrStr;
		}

		foreach ($attrs as $attrKey => $attrValue) {
			$attrStr .= $attrKey.'="'.$attrValue.'" ';
		}

		return $attrStr;
	}
	
	public static function createStyleAttrs($attrs)
	{
		$attrStr = '';
		
		if (empty($attrs)) {
			return $attrStr;
		}
		
		foreach ($attrs as $attrKey => $attrValue) {
			$attrStr .= $attrKey.": $attrValue; ";
		}
		
		return $attrStr;
	}

	/**
	 * Create Radio buttons
	 *
	 * @since 1.0.9
	 *
	 * @param array $data
	 * @param string $savedValue
	 * @param array $attrs
	 *
	 * @return string
	 */
	public static function createRadioButtons($data, $savedValue, $attrs = array()) {

		$attrString = '';
		$selected = '';

		if(!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$radioButtons = '';

		foreach($data as $value) {

			$checked = '';
			if($value == $savedValue) {
				$checked = 'checked';
			}

			$radioButtons .= "<input type=\"radio\" value=\"$value\" $attrString  $checked>";
		}

		return $radioButtons;
	}

	public static function getCurrentPostType() {
		global $post, $typenow, $current_screen;
		
		//we have a post so we can just get the post type from that
		if ($post && $post->post_type) {
			return $post->post_type;
		}
		//check the global $typenow - set in admin.php
		elseif($typenow) {
			return $typenow;
		}
		//check the global $current_screen object - set in sceen.php
		elseif($current_screen && $current_screen->post_type) {
			return $current_screen->post_type;
		}
		//lastly check the post_type querystring
		elseif(isset($_REQUEST['post_type'])) {
			return sanitize_key($_REQUEST['post_type']);
		}
		
		//we do not know the post type!
		return null;
	}

	public static function getPostTypeData($args = array())
	{
		$query = self::getQueryDataByArgs($args);

		$posts = array();
		foreach ($query->posts as $post) {
			$posts[$post->ID] = $post->post_title;
		}

		return $posts;
	}

	public static function getQueryDataByArgs($args = array())
	{
		$defaultArgs = array(
			'offset'           =>  0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_status'      => 'publish',
			'suppress_filters' => true,
			'post_type'        => 'post',
			'posts_per_page'   => 1000
		);

		$args = wp_parse_args($args, $defaultArgs);
		$query = new WP_Query($args);

		return $query;
	}

	public static function conditionsKeys() {
		$keys = array(
			'select_settings' => __('Select settings', YSTP_TEXT_DOMAIN),
			'devices' => __('Devices', YSTP_TEXT_DOMAIN),
			'user_status' => __('User status', YSTP_TEXT_DOMAIN),
			'countries' => __('Countries', YSTP_TEXT_DOMAIN)
		);

		return $keys;
	}
	
	public static function getPluginActivationUrl($key) {
		$action = 'install-plugin';
		$contactFormUrl = wp_nonce_url(
			add_query_arg(
				array(
					'action' => $action,
					'plugin' => $key
				),
				admin_url( 'update.php' )
			),
			$action.'_'.$key
		);
		
		return $contactFormUrl;
	}
	
	public static function upgradeButton() {
		$button = '<button class="ystp-upgrade-button-orange ystp-link-button" onclick=\'window.open("'.YSTP_PRO_URL.'");\'>
						<b class="h2">Upgrade</b><br><span class="h5">to PRO version</span>
					</button>';
		
		return $button;
	}
}