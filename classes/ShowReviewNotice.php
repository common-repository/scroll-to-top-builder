<?php
namespace ystp;
use \DateTime;

class YstpShowReviewNotice {

    public function __toString() {
        $content = '';
        $allowToShow = $this->allowToShowUsageDays();

        if(!$allowToShow) {
            return $content;
        }

        $content = $this->getReviewContent('usageDayes');

        return $content;
    }

    private function allowToShowUsageDays() {
        $shouldOpen = true;
        $dontShowAgain = get_option('YstpDontShowReviewNotice');

        if($dontShowAgain) {
            return !$shouldOpen;
        }
        $periodNextTime = get_option('YstpShowNextTime');

        // When period next time does not exits it means the user is old
        if(!$periodNextTime) {
            YstpShowReviewNotice::setInitialDates();

            return !$shouldOpen;
        }
        $currentData = new DateTime('now');
        $timeNow = $currentData->format('Y-m-d H:i:s');
        $timeNow = strtotime($timeNow);

        return $periodNextTime < $timeNow;
    }

    private function getReviewContent($type) {
        $content = $this->getMaxOpenDaysMessage($type);
        ob_start();
        ?>
        <div id="welcome-panel" class="welcome-panel ystp-review-block">
            <div class="welcome-panel-content">
                <?php echo $content; ?>
            </div>
        </div>
        <?php
        $reviewContent = ob_get_contents();
        ob_end_clean();

        return $reviewContent;
    }

    private function getMainTableCreationDate() {
        global $wpdb;

        $query = $wpdb->prepare('SELECT table_name, create_time FROM information_schema.tables WHERE table_schema="%s" AND  table_name="%s"', DB_NAME, $wpdb->prefix.'expm_maker');
        $results = $wpdb->get_results($query, ARRAY_A);

        if(empty($results)) {
            return 0;
        }

        $createTime = $results[0]['create_time'];
        $createTime = strtotime($createTime);
        update_option('YstpInstallDate', $createTime);
        $diff = time()-$createTime;
        $days  = floor($diff/(60*60*24));

        return $days;
    }

    private function getPopupUsageDays() {
        $installDate = get_option('YstpInstallDate');

        $timeDate = new DateTime('now');
        $timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));

        $diff = $timeNow-$installDate;

        $days  = floor($diff/(60*60*24));

        return $days;
    }

    private  function getMaxOpenDaysMessage($type) {
        $getUsageDays = $this->getPopupUsageDays();
        $firstHeader = '<h1 class="ystp-review-h1"><strong class="ystp-review-strong">Wow!</strong> You’ve been using Scroll to Top on your site for '.$getUsageDays.' days</h1>';
        $popupContent = $this->getMaxOepnContent($firstHeader, $type);

        $popupContent .= $this->showReviewBlockJs();

        return $popupContent;
    }

    private function getMaxOepnContent($firstHeader, $type) {
        $ajaxNonce = wp_create_nonce('ystpReviewNotice');

        ob_start();
        ?>
        <style>
            .ystp-buttons-wrapper .press{
                box-sizing:border-box;
                cursor:pointer;
                display:inline-block;
                font-size:1em;
                margin:0;
                padding:0.5em 0.75em;
                text-decoration:none;
                transition:background 0.15s linear
            }
            .ystp-buttons-wrapper .press-grey {
                background-color:#9E9E9E;
                border:2px solid #9E9E9E;
                color: #FFF;
            }
            .ystp-buttons-wrapper .press-lightblue {
                background-color:#03A9F4;
                border:2px solid #03A9F4;
                color: #FFF;
            }
            .ystp-review-wrapper{
                text-align: center;
                padding: 20px;
            }
            .ystp-review-wrapper p {
                color: black;
            }
            .ystp-review-h1 {
                font-size: 22px;
                font-weight: normal;
                line-height: 1.384;
            }
            .ystp-review-h2{
                font-size: 20px;
                font-weight: normal;
            }
            :root {
                --main-bg-color: #1ac6ff;
            }
            .ystp-review-strong{
                color: var(--main-bg-color);
            }
            .ystp-review-mt20{
                margin-top: 20px
            }
            .ystp-review-block {
                margin-right: 18px;
            }
        </style>
        <div class="ystp-review-wrapper">
            <div class="ystp-review-description">
                <?php echo $firstHeader; ?>
                <h2 class="ystp-review-h2">This is really great for your website score.</h2>
                <p class="ystp-review-mt20">Have your input in the development of our plugin, and we’ll provide better conversions for your site!<br /> Leave your 5-star positive review and help us go further to the perfection!</p>
            </div>
            <div class="ystp-buttons-wrapper">
                <button class="press press-grey ystp-button-1 ystp-already-did-review" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>">I already did</button>
                <button class="press press-lightblue ystp-button-3 ystp-already-did-review" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>" onclick="window.open('<?php echo YSTP_REVIEW_URL; ?>')">You worth it!</button>
                <button class="press press-grey ystp-button-2 ystp-show-popup-period" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>" data-message-type="<?php echo $type; ?>">Maybe later</button>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    private function showReviewBlockJs() {
        ob_start();
        ?>
        <script type="text/javascript">
            jQuery('.ystp-already-did-review').each(function () {
                jQuery(this).on('click', function () {
                    var ajaxNonce = jQuery(this).attr('data-ajaxnonce');

                    var data = {
                        action: 'ystp_dont_show_review_notice',
                        ajaxNonce: ajaxNonce
                    };
                    jQuery.post(ajaxurl, data, function(response,d) {
                        if(jQuery('.ystp-review-block').length) {
                            jQuery('.ystp-review-block').remove();
                        }
                    });
                });
            });

            jQuery('.ystp-show-popup-period').on('click', function () {
                var ajaxNonce = jQuery(this).attr('data-ajaxnonce');
                var messageType = jQuery(this).attr('data-message-type');

                var data = {
                    action: 'ystp_change_review_show_period',
                    messageType: messageType,
                    ajaxNonce: ajaxNonce
                };
                jQuery.post(ajaxurl, data, function(response,d) {
                    if(jQuery('.ystp-review-block').length) {
                        jQuery('.ystp-review-block').remove();
                    }
                });
            });
        </script>
        <?php
        $script = ob_get_contents();
        ob_end_clean();

        return $script;
    }

    public static function setInitialDates() {
        $usageDays = get_option('YstpUsageDays');
        if(!$usageDays) {
            update_option('YstpUsageDays', 0);

            $timeDate = new DateTime('now');
            $installTime = strtotime($timeDate->format('Y-m-d H:i:s'));
            update_option('YstpInstallDate', $installTime);
            $timeDate->modify('+'.YSTP_SHOW_REVIEW_PERIOD.' day');

            $timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
            update_option('YstpShowNextTime', $timeNow);
        }
    }

    public static function deleteInitialDates() {
        delete_option('YstpUsageDays');
        delete_option('YstpInstallDate');
        delete_option('YstpShowNextTime');
    }
}