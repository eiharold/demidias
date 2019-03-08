<?php
if (!defined('ABSPATH')) {
    exit();
}

class WpdiscuzCss {

    private $optionsSerialized;
    private $helper;

    function __construct($optionsSerialized, $helper) {
        $this->optionsSerialized = $optionsSerialized;
        $this->helper = $helper;
    }

    /**
     * init wpdiscuz styles
     */
    public function initCustomCss() {
        global $post;
        if ($this->helper->isLoadWpdiscuz($post)) {
            ?>
            <style>
                #wpcomm .wc_new_comment{background:<?php echo $this->optionsSerialized->primaryColor; ?>;}
                #wpcomm .wc_new_reply{background:<?php echo $this->optionsSerialized->primaryColor; ?>;}
                #wpcomm .wc-form-wrapper{ background:none; } /* ->formBGColor */
                #wpcomm .wpdiscuz-front-actions{background:<?php echo isset($this->optionsSerialized->formBGColor) ? $this->optionsSerialized->formBGColor : '#f9f9f9'; ?>;}
                #wpcomm .wpdiscuz-subscribe-bar{background:<?php echo isset($this->optionsSerialized->formBGColor) ? $this->optionsSerialized->formBGColor : '#f9f9f9'; ?>;}
                #wpcomm select,
                #wpcomm input[type="text"],
                #wpcomm input[type="email"],
                #wpcomm input[type="url"],
                #wpcomm input[type="date"],
                #wpcomm input[type="color"]{border:<?php echo $this->optionsSerialized->inputBorderColor; ?> 1px solid;}
                #wpcomm .wc-comment .wc-comment-right{background:<?php echo $this->optionsSerialized->commentBGColor; ?>;}
                #wpcomm .wc-reply .wc-comment-right{background:<?php echo $this->optionsSerialized->replyBGColor; ?>;}
                #wpcomm .wc-comment-right .wc-comment-text, 
                #wpcomm .wc-comment-right .wc-comment-text *{
                    font-size:<?php echo isset($this->optionsSerialized->commentTextSize) ? $this->optionsSerialized->commentTextSize : '14px'; ?>;
                }
                <?php
                $blogRoles = $this->optionsSerialized->blogRoles;
                if (!$blogRoles) {
                    echo '.wc-comment-author a{color:#00B38F;} .wc-comment-label{background:#00B38F;}';
                }
                foreach ($blogRoles as $role => $color) {
                    echo '#wpcomm .wc-blog-' . $role . ' > .wc-comment-right .wc-comment-author, #wpcomm .wc-blog-' . $role . ' > .wc-comment-right .wc-comment-author a{color:' . $color . ';}';
                    echo '#wpcomm .wc-blog-' . $role . ' > .wc-comment-left .wc-comment-label{color:' . $color . '; border:none; border-bottom: 1px solid #dddddd; }';
                }
                ?>
                #wpcomm .wc-comment .wc-comment-left .wc-comment-label{ background: #ffffff;}
                #wpcomm .wc-comment-left .wc-follow-user{color:<?php echo $this->optionsSerialized->primaryColor; ?>;}
                #wpcomm .wc-load-more-submit{border:1px solid <?php echo $this->optionsSerialized->inputBorderColor; ?>;}
                #wpcomm .wc-new-loaded-comment > .wc-comment-right{background:<?php echo $this->optionsSerialized->newLoadedCommentBGColor; ?>;}
                #wpcomm .wpdiscuz-subscribe-bar{color:#777;}
                #wpcomm .wpdiscuz-front-actions .wpdiscuz-sbs-wrap span{color: #777;}
                #wpcomm .page-numbers{color:#555;border:#555 1px solid;}
                #wpcomm span.current{background:#555;}
                #wpcomm .wpdiscuz-readmore{cursor:pointer;color:<?php echo $this->optionsSerialized->primaryColor; ?>;}
                #wpcomm .wpdiscuz-textarea-wrap{border:<?php echo $this->optionsSerialized->inputBorderColor; ?> 1px solid;} .wpd-custom-field .wcf-pasiv-star, #wpcomm .wpdiscuz-item .wpdiscuz-rating > label {color: <?php echo $this->optionsSerialized->ratingInactivColor; ?>;}
                #wpcomm .wpdiscuz-item .wpdiscuz-rating:not(:checked) > label:hover,.wpdiscuz-rating:not(:checked) > label:hover ~ label {   }#wpcomm .wpdiscuz-item .wpdiscuz-rating > input ~ label:hover, #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:not(:checked) ~ label:hover ~ label, #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:not(:checked) ~ label:hover ~ label{color: <?php echo $this->optionsSerialized->ratingHoverColor; ?>;} 
                #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:checked ~ label:hover, #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:checked ~ label:hover, #wpcomm .wpdiscuz-item .wpdiscuz-rating > label:hover ~ input:checked ~ label, #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:checked + label:hover ~ label, #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:checked ~ label:hover ~ label, .wpd-custom-field .wcf-activ-star, #wpcomm .wpdiscuz-item .wpdiscuz-rating > input:checked ~ label{ color:<?php echo $this->optionsSerialized->ratingActivColor; ?>;}
                #wpcomm .wc-comment-header{border-top: 1px solid #dedede;}
                #wpcomm .wc-reply .wc-comment-header{border-top: 1px solid #dedede;}
                /* Buttons */
                #wpcomm button, 
                #wpcomm input[type="button"], 
                #wpcomm input[type="reset"], 
                #wpcomm input[type="submit"]{ border: 1px solid <?php echo $this->optionsSerialized->buttonColor['primary_button_bg'] ?>; color: <?php echo $this->optionsSerialized->buttonColor['primary_button_color'] ?>; background-color: <?php echo $this->optionsSerialized->buttonColor['primary_button_bg'] ?>; }
                #wpcomm button:hover, 
                #wpcomm button:focus,
                #wpcomm input[type="button"]:hover, 
                #wpcomm input[type="button"]:focus, 
                #wpcomm input[type="reset"]:hover, 
                #wpcomm input[type="reset"]:focus, 
                #wpcomm input[type="submit"]:hover, 
                #wpcomm input[type="submit"]:focus{ border: 1px solid #333333; background-color: #333333;  }
                #wpcomm .wpdiscuz-sort-buttons{color:#777777;}
                #wpcomm .wpdiscuz-sort-button{color:<?php echo $this->optionsSerialized->buttonColor['secondary_button_color'] ?>; cursor:pointer;}
                #wpcomm .wpdiscuz-sort-button:hover{color:<?php echo $this->optionsSerialized->primaryColor; ?>!important;cursor:pointer;}
                #wpcomm .wpdiscuz-sort-button-active{color:<?php echo $this->optionsSerialized->primaryColor; ?>!important;cursor:default!important;}
                #wpcomm .wc-cta-button, 
                #wpcomm .wc-cta-button-x{color:<?php echo $this->optionsSerialized->buttonColor['secondary_button_color'] ?>; }
                #wpcomm .wc-vote-link.wc-up{color:<?php echo $this->optionsSerialized->buttonColor['vote_up_link_color'] ?>;}
                #wpcomm .wc-vote-link.wc-down{color:<?php echo $this->optionsSerialized->buttonColor['vote_down_link_color'] ?>;}
                #wpcomm .wc-vote-result{color:#999999;}
                #wpcomm .wpf-cta{color:#999999; }
                #wpcomm .wc-comment-link .wc-share-link .wpf-cta{color:#eeeeee;}
                #wpcomm .wc-footer-left .wc-reply-button{border:1px solid <?php echo $this->optionsSerialized->primaryColor; ?>!important; color: <?php echo $this->optionsSerialized->primaryColor; ?>;}
                #wpcomm .wpf-cta:hover{background:<?php echo $this->optionsSerialized->primaryColor; ?>!important; color:#FFFFFF;}
                #wpcomm .wc-footer-left .wc-reply-button.wc-cta-active, #wpcomm .wc-cta-active{background:<?php echo $this->optionsSerialized->primaryColor; ?>!important; color:#FFFFFF;}
                #wpcomm .wc-cta-button:hover{background:<?php echo $this->optionsSerialized->primaryColor; ?>!important; color:#FFFFFF;}
                #wpcomm .wc-footer-right .wc-toggle,
                #wpcomm .wc-footer-right .wc-toggle a,
                #wpcomm .wc-footer-right .wc-toggle i{color:<?php echo $this->optionsSerialized->primaryColor; ?>;}
                /* STICKY COMMENT HEADER */
                #wpcomm .wc-sticky-comment.wc-comment .wc-comment-header{}
                #wpcomm .wc-sticky-comment.wc-comment .wc-comment-header .wpd-sticky{background: #1ecea8; color: #ffffff; }
                #wpcomm .wc-closed-comment.wc-comment .wc-comment-header{}
                #wpcomm .wc-closed-comment.wc-comment .wc-comment-header .wpd-closed{background: #aaaaaa; color: #ffffff;}
                /* PRIVATE COMMENT HEADER */
                #wpcomm .wc-private-comment.wc-comment .wc-comment-header{}
                #wpcomm .wc-private-comment.wc-comment .wc-comment-header .wpd-private{background: #999999; color: #ffffff;}
                /* FOLLOW LINK */

                #wpcomm .wc-follow{color:<?php echo $this->optionsSerialized->buttonColor['secondary_button_color'] ?>;}
                #wpcomm .wc-follow-active{color:#ff7a00;}
                #wpcomm .wc-follow:hover i,
                #wpcomm .wc-unfollow:hover i,
                #wpcomm .wc-follow-active:hover i{color:<?php echo $this->optionsSerialized->primaryColor; ?>;}
                <?php if ($this->optionsSerialized->theme == 'wpd-dark') { ?>
                    #comments{ background: url(<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/dark.png') ?>) #222222; padding: 3%; box-sizing: border-box; } #respond{background: url(<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/dark.png') ?>) #222222; padding: 3%; box-sizing: border-box;} .comments-area{background: url(<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/dark.png') ?>) #222222; padding: 3%; box-sizing: border-box; ba}
                <?php } ?>
                .wpd-wrapper .wpd-list-item.wpd-active{border-top: 3px solid <?php echo $this->optionsSerialized->primaryColor; ?>;}
                <?php do_action('wpdiscuz_dynamic_css'); ?>
                <?php echo stripslashes($this->optionsSerialized->customCss); ?>

            </style>
            <?php
        }
    }

}
?>