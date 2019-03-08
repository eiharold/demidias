<?php

class WpdiscuzOptions implements WpDiscuzConstants {

    private $optionsSerialized;
    private $dbManager;
    private $blogRoles;
    private $addons;
    private $tips;

    public function __construct($optionsSerialized, $dbManager) {
        $this->dbManager = $dbManager;
        $this->optionsSerialized = $optionsSerialized;
        $this->initAddons();
        $this->initTips();
    }

    public function mainOptionsForm() {
        if (isset($_POST['wc_submit_options'])) {

            if (function_exists('current_user_can') && !current_user_can('manage_options')) {
                die(_e('Hacker?', 'wpdiscuz'));
            }
            if (function_exists('check_admin_referer')) {
                check_admin_referer('wc_options_form');
            }
            $this->optionsSerialized->isEnableOnHome = isset($_POST['isEnableOnHome']) ? $_POST['isEnableOnHome'] : 0;
            $this->optionsSerialized->isQuickTagsEnabled = isset($_POST['wc_quick_tags']) ? $_POST['wc_quick_tags'] : 0;
            $this->optionsSerialized->commentListUpdateType = isset($_POST['wc_comment_list_update_type']) ? $_POST['wc_comment_list_update_type'] : 0;
            $this->optionsSerialized->commentListUpdateTimer = isset($_POST['wc_comment_list_update_timer']) ? $_POST['wc_comment_list_update_timer'] : 30;
            $this->optionsSerialized->liveUpdateGuests = isset($_POST['wc_live_update_guests']) ? $_POST['wc_live_update_guests'] : 0;
            $this->optionsSerialized->commentEditableTime = isset($_POST['wc_comment_editable_time']) ? $_POST['wc_comment_editable_time'] : 900;
            $this->optionsSerialized->redirectPage = isset($_POST['wpdiscuz_redirect_page']) ? $_POST['wpdiscuz_redirect_page'] : 0;
            $this->optionsSerialized->isGuestCanVote = isset($_POST['wc_is_guest_can_vote']) ? $_POST['wc_is_guest_can_vote'] : 0;
            $this->optionsSerialized->isLoadOnlyParentComments = isset($_POST['isLoadOnlyParentComments']) ? $_POST['isLoadOnlyParentComments'] : 0;
            $this->optionsSerialized->commentListLoadType = isset($_POST['commentListLoadType']) ? $_POST['commentListLoadType'] : 0;
            $this->optionsSerialized->votingButtonsShowHide = isset($_POST['wc_voting_buttons_show_hide']) ? $_POST['wc_voting_buttons_show_hide'] : 0;
            $this->optionsSerialized->votingButtonsStyle = isset($_POST['votingButtonsStyle']) ? $_POST['votingButtonsStyle'] : 0;
            $this->optionsSerialized->votingButtonsIcon = isset($_POST['votingButtonsIcon']) ? $_POST['votingButtonsIcon'] : 'fa-plus|fa-minus';
            $this->optionsSerialized->headerTextShowHide = isset($_POST['wc_header_text_show_hide']) ? $_POST['wc_header_text_show_hide'] : 0;
            $this->optionsSerialized->storeCommenterData = isset($_POST['storeCommenterData']) && (intval($_POST['storeCommenterData']) || $_POST['storeCommenterData'] == 0) ? $_POST['storeCommenterData'] : -1;
            $this->optionsSerialized->showHideLoggedInUsername = isset($_POST['wc_show_hide_loggedin_username']) ? $_POST['wc_show_hide_loggedin_username'] : 0;
            $this->optionsSerialized->hideLoginLinkForGuests = isset($_POST['hideLoginLinkForGuests']) ? $_POST['hideLoginLinkForGuests'] : 0;
            $this->optionsSerialized->hideUserSettingsButton = isset($_POST['hideUserSettingsButton']) ? $_POST['hideUserSettingsButton'] : 0;
            $this->optionsSerialized->hideDiscussionStat = isset($_POST['hideDiscussionStat']) ? $_POST['hideDiscussionStat'] : 0;
            $this->optionsSerialized->hideRecentAuthors = isset($_POST['hideRecentAuthors']) ? $_POST['hideRecentAuthors'] : 0;
            $this->optionsSerialized->displayAntispamNote = isset($_POST['displayAntispamNote']) ? $_POST['displayAntispamNote'] : 0;
            $this->optionsSerialized->authorTitlesShowHide = isset($_POST['wc_author_titles_show_hide']) ? $_POST['wc_author_titles_show_hide'] : 0;
            $this->optionsSerialized->simpleCommentDate = isset($_POST['wc_simple_comment_date']) ? $_POST['wc_simple_comment_date'] : 0;
            $this->optionsSerialized->subscriptionType = isset($_POST['subscriptionType']) ? $_POST['subscriptionType'] : 1;
            $this->optionsSerialized->showHideReplyCheckbox = isset($_POST['wc_show_hide_reply_checkbox']) ? $_POST['wc_show_hide_reply_checkbox'] : 0;
            $this->optionsSerialized->isReplyDefaultChecked = isset($_POST['isReplyDefaultChecked']) ? $_POST['isReplyDefaultChecked'] : 0;
            $this->optionsSerialized->showSortingButtons = isset($_POST['show_sorting_buttons']) ? $_POST['show_sorting_buttons'] : 0;
            $this->optionsSerialized->mostVotedByDefault = isset($_POST['mostVotedByDefault']) ? $_POST['mostVotedByDefault'] : 0;
            $this->optionsSerialized->usePostmaticForCommentNotification = isset($_POST['wc_use_postmatic_for_comment_notification']) ? $_POST['wc_use_postmatic_for_comment_notification'] : 0;
            $this->optionsSerialized->formBGColor = isset($_POST['wc_form_bg_color']) ? $_POST['wc_form_bg_color'] : '#f9f9f9';
            $this->optionsSerialized->commentTextSize = isset($_POST['wc_comment_text_size']) ? $_POST['wc_comment_text_size'] : '14px';
            $this->optionsSerialized->commentBGColor = isset($_POST['wc_comment_bg_color']) ? $_POST['wc_comment_bg_color'] : '#fefefe';
            $this->optionsSerialized->replyBGColor = isset($_POST['wc_reply_bg_color']) ? $_POST['wc_reply_bg_color'] : '#f8f8f8';
            $this->optionsSerialized->primaryColor = isset($_POST['wc_comment_username_color']) ? $_POST['wc_comment_username_color'] : '#00B38F';
            $this->optionsSerialized->ratingHoverColor = isset($_POST['wc_comment_rating_hover_color']) ? $_POST['wc_comment_rating_hover_color'] : '#FFED85';
            $this->optionsSerialized->ratingInactivColor = isset($_POST['wc_comment_rating_inactiv_color']) ? $_POST['wc_comment_rating_inactiv_color'] : '#DDDDDD';
            $this->optionsSerialized->ratingActivColor = isset($_POST['wc_comment_rating_activ_color']) ? $_POST['wc_comment_rating_activ_color'] : '#FFD700';
            $this->optionsSerialized->blogRoles = isset($_POST['wc_blog_roles']) ? wp_parse_args($_POST['wc_blog_roles'], $this->optionsSerialized->blogRoles) : $this->optionsSerialized->blogRoles;
            $this->optionsSerialized->buttonColor = isset($_POST['wc_link_button_color']) ? $_POST['wc_link_button_color'] : array('primary_button_bg' => '#555555', 'primary_button_color' => '#FFFFFF', 'secondary_button_color' => '#777777', 'secondary_button_border' => '#dddddd', 'vote_up_link_color' => '#999999', 'vote_down_link_color' => '#999999');
            $this->optionsSerialized->inputBorderColor = isset($_POST['wc_input_border_color']) ? $_POST['wc_input_border_color'] : '#d9d9d9';
            $this->optionsSerialized->newLoadedCommentBGColor = isset($_POST['wc_new_loaded_comment_bg_color']) ? $_POST['wc_new_loaded_comment_bg_color'] : '#FFFAD6';
            $this->optionsSerialized->disableFontAwesome = isset($_POST['disableFontAwesome']) ? $_POST['disableFontAwesome'] : 0;
            $this->optionsSerialized->disableTips = isset($_POST['disableTips']) ? $_POST['disableTips'] : 0;
            $this->optionsSerialized->disableProfileURLs = isset($_POST['disableProfileURLs']) ? $_POST['disableProfileURLs'] : 0;
            $this->optionsSerialized->displayRatingOnPost = isset($_POST['displayRatingOnPost']) ? $_POST['displayRatingOnPost'] : array();
            $this->optionsSerialized->ratingCssOnNoneSingular = isset($_POST['ratingCssOnNoneSingular']) ? $_POST['ratingCssOnNoneSingular'] : 0;
            $this->optionsSerialized->customCss = isset($_POST['wc_custom_css']) ? $_POST['wc_custom_css'] : '.comments-area{width:auto; margin: 0 auto;}';
            $this->optionsSerialized->showPluginPoweredByLink = isset($_POST['wc_show_plugin_powerid_by']) ? $_POST['wc_show_plugin_powerid_by'] : 0;
            $this->optionsSerialized->isUsePoMo = isset($_POST['wc_is_use_po_mo']) ? $_POST['wc_is_use_po_mo'] : 0;
            $this->optionsSerialized->disableMemberConfirm = isset($_POST['wc_disable_member_confirm']) ? $_POST['wc_disable_member_confirm'] : 0;
            $this->optionsSerialized->disableGuestsConfirm = isset($_POST['disableGuestsConfirm']) ? $_POST['disableGuestsConfirm'] : 0;
            $this->optionsSerialized->commentTextMinLength = (isset($_POST['wc_comment_text_min_length']) && intval($_POST['wc_comment_text_min_length']) > 0) ? intval($_POST['wc_comment_text_min_length']) : 1;
            $this->optionsSerialized->commentTextMaxLength = (isset($_POST['wc_comment_text_max_length']) && intval($_POST['wc_comment_text_max_length']) > 0) ? intval($_POST['wc_comment_text_max_length']) : '';
            $this->optionsSerialized->commentReadMoreLimit = (isset($_POST['commentWordsLimit']) && intval($_POST['commentWordsLimit']) >= 0) ? intval($_POST['commentWordsLimit']) : 100;
            $this->optionsSerialized->showHideCommentLink = isset($_POST['showHideCommentLink']) ? $_POST['showHideCommentLink'] : 0;
            $this->optionsSerialized->hideCommentDate = isset($_POST['hideCommentDate']) ? $_POST['hideCommentDate'] : 0;
            $this->optionsSerialized->enableImageConversion = isset($_POST['enableImageConversion']) ? $_POST['enableImageConversion'] : 0;
            $this->optionsSerialized->commentLinkFilter = isset($_POST['commentLinkFilter']) ? $_POST['commentLinkFilter'] : 1;
            $this->optionsSerialized->isCaptchaInSession = isset($_POST['isCaptchaInSession']) ? $_POST['isCaptchaInSession'] : 0;
            $this->optionsSerialized->isUserByEmail = isset($_POST['isUserByEmail']) ? $_POST['isUserByEmail'] : 0;
            $this->optionsSerialized->commenterNameMinLength = isset($_POST['commenterNameMinLength']) && intval($_POST['commenterNameMinLength']) >= 1 ? $_POST['commenterNameMinLength'] : 1;
            $this->optionsSerialized->commenterNameMaxLength = isset($_POST['commenterNameMaxLength']) && intval($_POST['commenterNameMaxLength']) >= 3 && intval($_POST['commenterNameMaxLength']) <= 50 ? $_POST['commenterNameMaxLength'] : 50;
            $this->optionsSerialized->isNotifyOnCommentApprove = isset($_POST['isNotifyOnCommentApprove']) ? $_POST['isNotifyOnCommentApprove'] : 0;
            $this->optionsSerialized->isGravatarCacheEnabled = isset($_POST['isGravatarCacheEnabled']) ? $_POST['isGravatarCacheEnabled'] : 0;
            $this->optionsSerialized->gravatarCacheMethod = isset($_POST['gravatarCacheMethod']) ? $_POST['gravatarCacheMethod'] : 'cronjob';
            $this->optionsSerialized->gravatarCacheTimeout = isset($_POST['gravatarCacheTimeout']) ? $_POST['gravatarCacheTimeout'] : 10;
            $this->optionsSerialized->theme = isset($_POST['theme']) ? $_POST['theme'] : 'wpd-default';
            $this->optionsSerialized->reverseChildren = isset($_POST['reverseChildren']) ? $_POST['reverseChildren'] : 0;
            $this->optionsSerialized->antispamKey = isset($_POST['antispamKey']) ? $_POST['antispamKey'] : '';
            //social 
            $this->optionsSerialized->socialLoginAgreementCheckbox = isset($_POST['socialLoginAgreementCheckbox']) ? $_POST['socialLoginAgreementCheckbox'] : 0;
            $this->optionsSerialized->socialLoginInSecondaryForm = isset($_POST['socialLoginInSecondaryForm']) ? $_POST['socialLoginInSecondaryForm'] : 0;
            // fb
            $this->optionsSerialized->enableFbLogin = isset($_POST['enableFbLogin']) ? $_POST['enableFbLogin'] : 0;
            $this->optionsSerialized->enableFbShare = isset($_POST['enableFbShare']) ? $_POST['enableFbShare'] : 0;
            $this->optionsSerialized->fbAppID = isset($_POST['fbAppID']) ? trim($_POST['fbAppID']) : '';
            $this->optionsSerialized->fbAppSecret = isset($_POST['fbAppSecret']) ? trim($_POST['fbAppSecret']) : '';
            $this->optionsSerialized->fbUseOAuth2 = isset($_POST['fbUseOAuth2']) ? $_POST['fbUseOAuth2'] : 0;
            // twitter
            $this->optionsSerialized->enableTwitterLogin = isset($_POST['enableTwitterLogin']) ? $_POST['enableTwitterLogin'] : 0;
            $this->optionsSerialized->enableTwitterShare = isset($_POST['enableTwitterShare']) ? $_POST['enableTwitterShare'] : 0;
            $this->optionsSerialized->twitterAppID = isset($_POST['twitterAppID']) ? trim($_POST['twitterAppID']) : '';
            $this->optionsSerialized->twitterAppSecret = isset($_POST['twitterAppSecret']) ? trim($_POST['twitterAppSecret']) : '';
            // google+
            $this->optionsSerialized->enableGoogleLogin = isset($_POST['enableGoogleLogin']) ? $_POST['enableGoogleLogin'] : 0;
            $this->optionsSerialized->enableGoogleShare = isset($_POST['enableGoogleShare']) ? $_POST['enableGoogleShare'] : 0;
            $this->optionsSerialized->googleAppID = isset($_POST['googleAppID']) ? trim($_POST['googleAppID']) : '';
            // ok
            $this->optionsSerialized->enableOkLogin = isset($_POST['enableOkLogin']) ? $_POST['enableOkLogin'] : 0;
            $this->optionsSerialized->enableOkShare = isset($_POST['enableOkShare']) ? $_POST['enableOkShare'] : 0;
            $this->optionsSerialized->okAppID = isset($_POST['okAppID']) ? trim($_POST['okAppID']) : '';
            $this->optionsSerialized->okAppKey = isset($_POST['okAppKey']) ? trim($_POST['okAppKey']) : '';
            $this->optionsSerialized->okAppSecret = isset($_POST['okAppSecret']) ? trim($_POST['okAppSecret']) : '';
            // vk
            $this->optionsSerialized->enableVkLogin = isset($_POST['enableVkLogin']) ? $_POST['enableVkLogin'] : 0;
            $this->optionsSerialized->enableVkShare = isset($_POST['enableVkShare']) ? $_POST['enableVkShare'] : 0;
            $this->optionsSerialized->vkAppID = isset($_POST['vkAppID']) ? trim($_POST['vkAppID']) : '';
            $this->optionsSerialized->vkAppSecret = isset($_POST['vkAppSecret']) ? trim($_POST['vkAppSecret']) : '';

            $this->optionsSerialized->isFollowActive = isset($_POST['isFollowActive']) ? intval($_POST['isFollowActive']) : 0;
            $this->optionsSerialized->disableFollowConfirmForUsers = isset($_POST['disableFollowConfirmForUsers']) ? intval($_POST['disableFollowConfirmForUsers']) : 0;
            $this->optionsSerialized->enableStickButton = isset($_POST['enableStickButton']) ? intval($_POST['enableStickButton']) : 0;
            $this->optionsSerialized->enableCloseButton = isset($_POST['enableCloseButton']) ? intval($_POST['enableCloseButton']) : 0;
            $this->optionsSerialized->enableDropAnimation = isset($_POST['enableDropAnimation']) ? intval($_POST['enableDropAnimation']) : 0;
            do_action('wpdiscuz_save_options', $_POST);
            $this->optionsSerialized->updateOptions();
            add_settings_error('wpdiscuz', 'settings_updated', __('Settings updated', 'wpdiscuz'), 'updated');
        }
        include_once 'html-options.php';
    }

    public function phrasesOptionsForm() {

        if (isset($_POST['wc_submit_phrases'])) {
            if (function_exists('current_user_can') && !current_user_can('manage_options')) {
                die(_e('Hacker?', 'wpdiscuz'));
            }
            if (function_exists('check_admin_referer')) {
                check_admin_referer('wc_phrases_form');
            }
            $this->optionsSerialized->phrases['wc_be_the_first_text'] = esc_attr($_POST['wc_be_the_first_text']);
            $this->optionsSerialized->phrases['wc_comment_start_text'] = esc_attr($_POST['wc_comment_start_text']);
            $this->optionsSerialized->phrases['wc_comment_join_text'] = esc_attr($_POST['wc_comment_join_text']);
            $this->optionsSerialized->phrases['wc_content_and_settings'] = esc_attr($_POST['wc_content_and_settings']);
            $this->optionsSerialized->phrases['wc_comment_threads'] = esc_attr($_POST['wc_comment_threads']);
            $this->optionsSerialized->phrases['wc_thread_replies'] = esc_attr($_POST['wc_thread_replies']);
            $this->optionsSerialized->phrases['wc_followers'] = esc_attr($_POST['wc_followers']);
            $this->optionsSerialized->phrases['wc_most_reacted_comment'] = esc_attr($_POST['wc_most_reacted_comment']);
            $this->optionsSerialized->phrases['wc_hottest_comment_thread'] = esc_attr($_POST['wc_hottest_comment_thread']);
            $this->optionsSerialized->phrases['wc_comment_authors'] = esc_attr($_POST['wc_comment_authors']);
            $this->optionsSerialized->phrases['wc_recent_comment_authors'] = esc_attr($_POST['wc_recent_comment_authors']);
            $this->optionsSerialized->phrases['wc_email_text'] = esc_attr($_POST['wc_email_text']);
            $this->optionsSerialized->phrases['wc_subscribe_anchor'] = esc_attr($_POST['wc_subscribe_anchor']);
            $this->optionsSerialized->phrases['wc_notify_of'] = esc_attr($_POST['wc_notify_of']);
            $this->optionsSerialized->phrases['wc_notify_on_new_comment'] = esc_attr($_POST['wc_notify_on_new_comment']);
            $this->optionsSerialized->phrases['wc_notify_on_all_new_reply'] = esc_attr($_POST['wc_notify_on_all_new_reply']);
            $this->optionsSerialized->phrases['wc_notify_on_new_reply'] = esc_attr($_POST['wc_notify_on_new_reply']);
            $this->optionsSerialized->phrases['wc_sort_by'] = esc_attr($_POST['wc_sort_by']);
            $this->optionsSerialized->phrases['wc_newest'] = esc_attr($_POST['wc_newest']);
            $this->optionsSerialized->phrases['wc_oldest'] = esc_attr($_POST['wc_oldest']);
            $this->optionsSerialized->phrases['wc_most_voted'] = esc_attr($_POST['wc_most_voted']);
            $this->optionsSerialized->phrases['wc_load_more_submit_text'] = esc_attr($_POST['wc_load_more_submit_text']);
            $this->optionsSerialized->phrases['wc_load_rest_comments_submit_text'] = esc_attr($_POST['wc_load_rest_comments_submit_text']);
            $this->optionsSerialized->phrases['wc_reply_text'] = esc_attr($_POST['wc_reply_text']);
            $this->optionsSerialized->phrases['wc_share_text'] = esc_attr($_POST['wc_share_text']);
            $this->optionsSerialized->phrases['wc_edit_text'] = esc_attr($_POST['wc_edit_text']);
            $this->optionsSerialized->phrases['wc_share_facebook'] = esc_attr($_POST['wc_share_facebook']);
            $this->optionsSerialized->phrases['wc_share_twitter'] = esc_attr($_POST['wc_share_twitter']);
            $this->optionsSerialized->phrases['wc_share_google'] = esc_attr($_POST['wc_share_google']);
            $this->optionsSerialized->phrases['wc_share_vk'] = esc_attr($_POST['wc_share_vk']);
            $this->optionsSerialized->phrases['wc_share_ok'] = esc_attr($_POST['wc_share_ok']);
            $this->optionsSerialized->phrases['wc_hide_replies_text'] = esc_attr($_POST['wc_hide_replies_text']);
            $this->optionsSerialized->phrases['wc_show_replies_text'] = esc_attr($_POST['wc_show_replies_text']);
            $this->optionsSerialized->phrases['wc_email_subject'] = esc_attr($_POST['wc_email_subject']);
            $this->optionsSerialized->phrases['wc_email_message'] = wpautop($_POST['wc_email_message']);
            $this->optionsSerialized->phrases['wc_all_comment_new_reply_subject'] = esc_attr($_POST['wc_all_comment_new_reply_subject']);
            $this->optionsSerialized->phrases['wc_all_comment_new_reply_message'] = wpautop($_POST['wc_all_comment_new_reply_message']);
            $this->optionsSerialized->phrases['wc_new_reply_email_subject'] = esc_attr($_POST['wc_new_reply_email_subject']);
            $this->optionsSerialized->phrases['wc_new_reply_email_message'] = wpautop($_POST['wc_new_reply_email_message']);
            $this->optionsSerialized->phrases['wc_subscribed_on_comment'] = esc_attr($_POST['wc_subscribed_on_comment']);
            $this->optionsSerialized->phrases['wc_subscribed_on_all_comment'] = esc_attr($_POST['wc_subscribed_on_all_comment']);
            $this->optionsSerialized->phrases['wc_subscribed_on_post'] = esc_attr($_POST['wc_subscribed_on_post']);
            $this->optionsSerialized->phrases['wc_unsubscribe'] = esc_attr($_POST['wc_unsubscribe']);
            $this->optionsSerialized->phrases['wc_ignore_subscription'] = esc_attr($_POST['wc_ignore_subscription']);
            $this->optionsSerialized->phrases['wc_unsubscribe_message'] = esc_attr($_POST['wc_unsubscribe_message']);
            $this->optionsSerialized->phrases['wc_subscribe_message'] = esc_attr($_POST['wc_subscribe_message']);
            $this->optionsSerialized->phrases['wc_confirm_email'] = esc_attr($_POST['wc_confirm_email']);
            $this->optionsSerialized->phrases['wc_comfirm_success_message'] = esc_attr($_POST['wc_comfirm_success_message']);
            $this->optionsSerialized->phrases['wc_confirm_email_subject'] = esc_attr($_POST['wc_confirm_email_subject']);
            $this->optionsSerialized->phrases['wc_confirm_email_message'] = ($_POST['wc_confirm_email_message']);
            $this->optionsSerialized->phrases['wc_error_empty_text'] = esc_attr($_POST['wc_error_empty_text']);
            $this->optionsSerialized->phrases['wc_error_email_text'] = esc_attr($_POST['wc_error_email_text']);
            $this->optionsSerialized->phrases['wc_error_url_text'] = esc_attr($_POST['wc_error_url_text']);
            $this->optionsSerialized->phrases['wc_year_text'] = esc_attr($_POST['wc_year_text']);
            $this->optionsSerialized->phrases['wc_year_text_plural'] = esc_attr($_POST['wc_year_text_plural']);
            $this->optionsSerialized->phrases['wc_month_text'] = esc_attr($_POST['wc_month_text']);
            $this->optionsSerialized->phrases['wc_month_text_plural'] = esc_attr($_POST['wc_month_text_plural']);
            $this->optionsSerialized->phrases['wc_day_text'] = esc_attr($_POST['wc_day_text']);
            $this->optionsSerialized->phrases['wc_day_text_plural'] = esc_attr($_POST['wc_day_text_plural']);
            $this->optionsSerialized->phrases['wc_hour_text'] = esc_attr($_POST['wc_hour_text']);
            $this->optionsSerialized->phrases['wc_hour_text_plural'] = esc_attr($_POST['wc_hour_text_plural']);
            $this->optionsSerialized->phrases['wc_minute_text'] = esc_attr($_POST['wc_minute_text']);
            $this->optionsSerialized->phrases['wc_minute_text_plural'] = esc_attr($_POST['wc_minute_text_plural']);
            $this->optionsSerialized->phrases['wc_second_text'] = esc_attr($_POST['wc_second_text']);
            $this->optionsSerialized->phrases['wc_second_text_plural'] = esc_attr($_POST['wc_second_text_plural']);
            $this->optionsSerialized->phrases['wc_right_now_text'] = esc_attr($_POST['wc_right_now_text']);
            $this->optionsSerialized->phrases['wc_ago_text'] = esc_attr($_POST['wc_ago_text']);
            $this->optionsSerialized->phrases['wc_you_must_be_text'] = esc_attr($_POST['wc_you_must_be_text']);
            $this->optionsSerialized->phrases['wc_logged_in_as'] = esc_attr($_POST['wc_logged_in_as']);
            $this->optionsSerialized->phrases['wc_log_out'] = esc_attr($_POST['wc_log_out']);
            $this->optionsSerialized->phrases['wc_log_in'] = esc_attr($_POST['wc_log_in']);
            $this->optionsSerialized->phrases['wc_login_please'] = esc_attr($_POST['wc_login_please']);
            $this->optionsSerialized->phrases['wc_logged_in_text'] = esc_attr($_POST['wc_logged_in_text']);
            $this->optionsSerialized->phrases['wc_to_post_comment_text'] = esc_attr($_POST['wc_to_post_comment_text']);
            $this->optionsSerialized->phrases['wc_vote_counted'] = esc_attr($_POST['wc_vote_counted']);
            $this->optionsSerialized->phrases['wc_vote_up'] = esc_attr($_POST['wc_vote_up']);
            $this->optionsSerialized->phrases['wc_vote_down'] = esc_attr($_POST['wc_vote_down']);
            $this->optionsSerialized->phrases['wc_held_for_moderate'] = esc_attr($_POST['wc_held_for_moderate']);
            $this->optionsSerialized->phrases['wc_vote_only_one_time'] = esc_attr($_POST['wc_vote_only_one_time']);
            $this->optionsSerialized->phrases['wc_voting_error'] = esc_attr($_POST['wc_voting_error']);
            $this->optionsSerialized->phrases['wc_self_vote'] = esc_attr($_POST['wc_self_vote']);
            $this->optionsSerialized->phrases['wc_deny_voting_from_same_ip'] = esc_attr($_POST['wc_deny_voting_from_same_ip']);
            $this->optionsSerialized->phrases['wc_login_to_vote'] = esc_attr($_POST['wc_login_to_vote']);
            $this->optionsSerialized->phrases['wc_invalid_captcha'] = esc_attr($_POST['wc_invalid_captcha']);
            $this->optionsSerialized->phrases['wc_invalid_field'] = esc_attr($_POST['wc_invalid_field']);
            $this->optionsSerialized->phrases['wc_new_comment_button_text'] = esc_attr($_POST['wc_new_comment_button_text']);
            $this->optionsSerialized->phrases['wc_new_comments_button_text'] = esc_attr($_POST['wc_new_comments_button_text']);
            $this->optionsSerialized->phrases['wc_new_reply_button_text'] = esc_attr($_POST['wc_new_reply_button_text']);
            $this->optionsSerialized->phrases['wc_new_replies_button_text'] = esc_attr($_POST['wc_new_replies_button_text']);
            $this->optionsSerialized->phrases['wc_comment_not_updated'] = esc_attr($_POST['wc_comment_not_updated']);
            $this->optionsSerialized->phrases['wc_comment_edit_not_possible'] = esc_attr($_POST['wc_comment_edit_not_possible']);
            $this->optionsSerialized->phrases['wc_comment_not_edited'] = esc_attr($_POST['wc_comment_not_edited']);
            $this->optionsSerialized->phrases['wc_comment_edit_save_button'] = esc_attr($_POST['wc_comment_edit_save_button']);
            $this->optionsSerialized->phrases['wc_comment_edit_cancel_button'] = esc_attr($_POST['wc_comment_edit_cancel_button']);
            $this->optionsSerialized->phrases['wc_msg_input_min_length'] = esc_attr($_POST['wc_msg_input_min_length']);
            $this->optionsSerialized->phrases['wc_msg_input_max_length'] = esc_attr($_POST['wc_msg_input_max_length']);
            $this->optionsSerialized->phrases['wc_read_more'] = esc_attr($_POST['wc_read_more']);
            $this->optionsSerialized->phrases['wc_anonymous'] = esc_attr($_POST['wc_anonymous']);
            $this->optionsSerialized->phrases['wc_msg_required_fields'] = esc_attr($_POST['wc_msg_required_fields']);
            $this->optionsSerialized->phrases['wc_connect_with'] = esc_attr($_POST['wc_connect_with']);
            $this->optionsSerialized->phrases['wc_subscribed_to'] = esc_attr($_POST['wc_subscribed_to']);
            $this->optionsSerialized->phrases['wc_form_subscription_submit'] = esc_attr($_POST['wc_form_subscription_submit']);
            $this->optionsSerialized->phrases['wc_comment_approved_email_subject'] = esc_attr($_POST['wc_comment_approved_email_subject']);
            $this->optionsSerialized->phrases['wc_comment_approved_email_message'] = ($_POST['wc_comment_approved_email_message']);
            $this->optionsSerialized->phrases['wc_roles_cannot_comment_message'] = esc_attr($_POST['wc_roles_cannot_comment_message']);
            $this->optionsSerialized->phrases['wc_stick_comment_btn_title'] = esc_attr($_POST['wc_stick_comment_btn_title']);
            $this->optionsSerialized->phrases['wc_stick_comment'] = esc_attr($_POST['wc_stick_comment']);
            $this->optionsSerialized->phrases['wc_unstick_comment'] = esc_attr($_POST['wc_unstick_comment']);
            $this->optionsSerialized->phrases['wc_sticky_comment_icon_title'] = esc_attr($_POST['wc_sticky_comment_icon_title']);
            $this->optionsSerialized->phrases['wc_close_comment_btn_title'] = esc_attr($_POST['wc_close_comment_btn_title']);
            $this->optionsSerialized->phrases['wc_close_comment'] = esc_attr($_POST['wc_close_comment']);
            $this->optionsSerialized->phrases['wc_open_comment'] = esc_attr($_POST['wc_open_comment']);
            $this->optionsSerialized->phrases['wc_closed_comment_icon_title'] = esc_attr($_POST['wc_closed_comment_icon_title']);
            $this->optionsSerialized->phrases['wc_social_login_agreement_label'] = esc_attr($_POST['wc_social_login_agreement_label']);
            $this->optionsSerialized->phrases['wc_social_login_agreement_desc'] = esc_attr($_POST['wc_social_login_agreement_desc']);
            $this->optionsSerialized->phrases['wc_invisible_antispam_note'] = esc_attr($_POST['wc_invisible_antispam_note']);
            $this->optionsSerialized->phrases['wc_agreement_button_disagree'] = esc_attr($_POST['wc_agreement_button_disagree']);
            $this->optionsSerialized->phrases['wc_agreement_button_agree'] = esc_attr($_POST['wc_agreement_button_agree']);
            $this->optionsSerialized->phrases['wc_content_and_settings'] = esc_attr($_POST['wc_content_and_settings']);
            $this->optionsSerialized->phrases['wc_user_settings_activity'] = esc_attr($_POST['wc_user_settings_activity']);
            $this->optionsSerialized->phrases['wc_user_settings_subscriptions'] = esc_attr($_POST['wc_user_settings_subscriptions']);
            $this->optionsSerialized->phrases['wc_user_settings_follows'] = esc_attr($_POST['wc_user_settings_follows']);
            $this->optionsSerialized->phrases['wc_user_settings_response_to'] = esc_attr($_POST['wc_user_settings_response_to']);
            $this->optionsSerialized->phrases['wc_user_settings_email_me_delete_links'] = esc_attr($_POST['wc_user_settings_email_me_delete_links']);
            $this->optionsSerialized->phrases['wc_user_settings_email_me_delete_links_desc'] = esc_attr($_POST['wc_user_settings_email_me_delete_links_desc']);
            $this->optionsSerialized->phrases['wc_user_settings_no_data'] = esc_attr($_POST['wc_user_settings_no_data']);
            $this->optionsSerialized->phrases['wc_user_settings_request_deleting_comments'] = esc_attr($_POST['wc_user_settings_request_deleting_comments']);
            $this->optionsSerialized->phrases['wc_user_settings_cancel_subscriptions'] = esc_attr($_POST['wc_user_settings_cancel_subscriptions']);
            $this->optionsSerialized->phrases['wc_user_settings_clear_cookie'] = esc_attr($_POST['wc_user_settings_clear_cookie']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_links'] = esc_attr($_POST['wc_user_settings_delete_links']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_all_comments'] = esc_attr($_POST['wc_user_settings_delete_all_comments']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_all_comments_message'] = wpautop($_POST['wc_user_settings_delete_all_comments_message']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_all_subscriptions'] = esc_attr($_POST['wc_user_settings_delete_all_subscriptions']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_all_subscriptions_message'] = wpautop($_POST['wc_user_settings_delete_all_subscriptions_message']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_all_follows'] = esc_attr($_POST['wc_user_settings_delete_all_follows']);
            $this->optionsSerialized->phrases['wc_user_settings_delete_all_follows_message'] = wpautop($_POST['wc_user_settings_delete_all_follows_message']);
            $this->optionsSerialized->phrases['wc_user_settings_subscribed_to_replies'] = esc_attr($_POST['wc_user_settings_subscribed_to_replies']);
            $this->optionsSerialized->phrases['wc_user_settings_subscribed_to_replies_own'] = esc_attr($_POST['wc_user_settings_subscribed_to_replies_own']);
            $this->optionsSerialized->phrases['wc_user_settings_subscribed_to_all_comments'] = esc_attr($_POST['wc_user_settings_subscribed_to_all_comments']);
            $this->optionsSerialized->phrases['wc_user_settings_check_email'] = esc_attr($_POST['wc_user_settings_check_email']);
            $this->optionsSerialized->phrases['wc_user_settings_email_error'] = esc_attr($_POST['wc_user_settings_email_error']);
            $this->optionsSerialized->phrases['wc_confirm_comment_delete'] = esc_attr($_POST['wc_confirm_comment_delete']);
            $this->optionsSerialized->phrases['wc_confirm_cancel_subscription'] = esc_attr($_POST['wc_confirm_cancel_subscription']);
            $this->optionsSerialized->phrases['wc_confirm_cancel_follow'] = esc_attr($_POST['wc_confirm_cancel_follow']);
            $this->optionsSerialized->phrases['wc_follow_user'] = esc_attr($_POST['wc_follow_user']);
            $this->optionsSerialized->phrases['wc_unfollow_user'] = esc_attr($_POST['wc_unfollow_user']);
            $this->optionsSerialized->phrases['wc_follow_success'] = esc_attr($_POST['wc_follow_success']);
            $this->optionsSerialized->phrases['wc_follow_canceled'] = esc_attr($_POST['wc_follow_canceled']);
            $this->optionsSerialized->phrases['wc_follow_email_confirm'] = esc_attr($_POST['wc_follow_email_confirm']);
            $this->optionsSerialized->phrases['wc_follow_email_confirm_fail'] = esc_attr($_POST['wc_follow_email_confirm_fail']);
            $this->optionsSerialized->phrases['wc_follow_login_to_follow'] = esc_attr($_POST['wc_follow_login_to_follow']);
            $this->optionsSerialized->phrases['wc_follow_impossible'] = esc_attr($_POST['wc_follow_impossible']);
            $this->optionsSerialized->phrases['wc_follow_not_added'] = esc_attr($_POST['wc_follow_not_added']);
            $this->optionsSerialized->phrases['wc_follow_confirm'] = esc_attr($_POST['wc_follow_confirm']);
            $this->optionsSerialized->phrases['wc_follow_cancel'] = esc_attr($_POST['wc_follow_cancel']);
            $this->optionsSerialized->phrases['wc_follow_confirm_email_subject'] = esc_attr($_POST['wc_follow_confirm_email_subject']);
            $this->optionsSerialized->phrases['wc_follow_confirm_email_message'] = wpautop($_POST['wc_follow_confirm_email_message']);
            $this->optionsSerialized->phrases['wc_follow_email_subject'] = esc_attr($_POST['wc_follow_email_subject']);
            $this->optionsSerialized->phrases['wc_follow_email_message'] = wpautop($_POST['wc_follow_email_message']);

            if (class_exists('Prompt_Comment_Form_Handling') && $this->optionsSerialized->usePostmaticForCommentNotification) {
                $this->optionsSerialized->phrases['wc_postmatic_subscription_label'] = esc_attr($_POST['wc_postmatic_subscription_label']);
            }
            foreach ($this->optionsSerialized->blogRoles as $roleName => $roleVal) {
                $this->optionsSerialized->phrases['wc_blog_role_' . $roleName] = esc_attr($_POST['wc_blog_role_' . $roleName]);
            }
            $this->dbManager->updatePhrases($this->optionsSerialized->phrases);
            add_settings_error('wpdiscuz', 'phrases_updated', __('Phrases updated', 'wpdiscuz'), 'updated');
        }
        $this->optionsSerialized->initPhrasesOnLoad();

        include_once 'html-phrases.php';
    }

    public function tools() {
        if (current_user_can('manage_options')) {

            $wpUploadsDir = wp_upload_dir();
            $wpdiscuzOptionsDir = $wpUploadsDir['basedir'] . self::OPTIONS_DIR;
            $wpdiscuzOptionsUrl = $wpUploadsDir['baseurl'] . self::OPTIONS_DIR;

            if (isset($_POST['tools-action'])) {

                $action = $_POST['tools-action'];

                if ($action == 'export-options') {

                    check_admin_referer('wc_tools_form');

                    wp_mkdir_p($wpdiscuzOptionsDir);
                    $options = @maybe_unserialize(get_option(self::OPTION_SLUG_OPTIONS));
                    if ($options) {
                        $json = json_encode($options);
                        if (file_put_contents($wpdiscuzOptionsDir . self::OPTIONS_FILENAME . '.txt', $json)) {
                            add_settings_error('wpdiscuz', 'settings_updated', __('Options were backed up!', 'wpdiscuz'), 'updated');
                        } else {
                            add_settings_error('wpdiscuz', 'settings_updated', __('Cannot back up the options!', 'wpdiscuz'), 'error');
                        }
                    }
                } else if ($action == 'import-options') {
                    check_admin_referer('wc_tools_form');
                    $file = isset($_FILES['wpdiscuz-options-file']) ? $_FILES['wpdiscuz-options-file'] : "";
                    if ($file && is_array($file) && isset($file['tmp_name'])) {
                        if ($data = file_get_contents($file['tmp_name'])) {
                            $options = json_decode($data, true);
                            if ($options && is_array($options)) {
                                update_option(self::OPTION_SLUG_OPTIONS, @maybe_serialize($options));
                                add_settings_error('wpdiscuz', 'settings_updated', __('Options Imported Successfully!', 'wpdiscuz'), 'updated');
                            } else {
                                add_settings_error('wpdiscuz', 'settings_error', __('Error occured! File content is empty or data is not valid!', 'wpdiscuz'), 'error');
                            }
                        } else {
                            add_settings_error('wpdiscuz', 'settings_error', __('Error occured! Can not get file content!', 'wpdiscuz'), 'error');
                        }
                    } else {
                        add_settings_error('wpdiscuz', 'settings_error', __('Error occured! Please choose file!', 'wpdiscuz'), 'error');
                    }
                }
            }
        } else {
            die(_e('Hacker?', 'wpdiscuz'));
        }
        include_once 'html-tools.php';
    }

    public function addons() {
        include_once 'html-addons.php';
    }

    private function initAddons() {
        $this->addons = array(
            'emoticons' => array('version' => '1.1.1', 'requires' => '4.0.0', 'class' => 'wpDiscuzSmile', 'title' => 'Emoticons', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'emoticons' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Brings an ocean of emotions to your comments. It comes with an awesome smile package.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-emoticons/'),
            'author-info' => array('version' => '1.0.0', 'requires' => '4.0.6', 'class' => 'WpdiscuzCommentAuthorInfo', 'title' => 'Comment Author Info', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'author-info' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Extended information about comment author with Profile, Activity, Votes and Subscriptions Tabs on pop-up window.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-comment-author-info/'),
            'online-users' => array('version' => '1.0.0', 'requires' => '4.1.0', 'class' => 'WpdiscuzOnlineUsers', 'title' => 'Online Users', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'online-users' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Real-time online user checking, pop-up notification of new online users and online/offline badges.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-online-users/'),
            'private' => array('version' => '1.0.0', 'requires' => '5.0.0', 'class' => 'wpDiscuzPrivateComment', 'title' => 'Private Comments', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'private' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Allows to create private comment threads. Rich management options in dashboard by user roles.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-private-comments/'),
            'subscriptions' => array('version' => '1.0.0', 'requires' => '4.0.4', 'class' => 'wpdSubscribeManager', 'title' => 'Subscription Manager', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'subscriptions' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Total control over comment subscriptions. Full list, monitor, manage, filter, unsubscribe, confirm...', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-subscribe-manager/'),
            'ads-manager' => array('version' => '1.0.0', 'requires' => '4.0.0', 'class' => 'WpdiscuzAdsManager', 'title' => 'Ads Manager', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'ads-manager' . WPDISCUZ_DS . 'header.png'), 'desc' => __('A full-fledged tool-kit for advertising in comment section of your website. Separate banner and ad managment.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-ads-manager/'),
            'user-mention' => array('version' => '1.0.0', 'requires' => '4.0.0', 'class' => 'Wpdiscuz_UCM', 'title' => 'User &amp; Comment Mentioning', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'user-mention' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Allows to mention comments and users in comment text using #comment-id and @username tags.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-user-comment-mentioning/'),
            'likers' => array('version' => '1.0.0', 'requires' => '4.0.0', 'class' => 'WpdiscuzVoters', 'title' => 'Advanced Likers', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'likers' . WPDISCUZ_DS . 'header.png'), 'desc' => __('See comment likers and voters of each comment. Adds user reputation and badges based on received likes.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-advanced-likers/'),
            'report-flagging' => array('version' => '1.1.5', 'requires' => '4.0.0', 'class' => 'wpDiscuzFlagComment', 'title' => 'Report and Flagging', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'report' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Comment reporting tools. Auto-moderates comments based on number of flags and dislikes.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-report-flagging/'),
            'translate' => array('version' => '1.0.3', 'requires' => '4.0.0', 'class' => 'WpDiscuzTranslate', 'title' => 'Comment Translate', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'translate' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Adds a smart and intuitive AJAX "Translate" button with 60 language options. Uses free translation API.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-comment-translation/'),
            'search' => array('version' => '1.1.0', 'requires' => '4.0.0', 'class' => 'wpDiscuzCommentSearch', 'title' => 'Comment Search', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'search' . WPDISCUZ_DS . 'header.png'), 'desc' => __('AJAX powered front-end comment search. It starts searching while you type search words. ', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-comment-search/'),
            'widgets' => array('version' => '1.0.7', 'requires' => '4.0.0', 'class' => 'wpDiscuzWidgets', 'title' => 'wpDiscuz Widgets', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'widgets' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Most voted comments, Active comment threads, Most commented posts, Active comment authors', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-widgets/'),
            'frontend-moderation' => array('version' => '1.0.4', 'requires' => '4.0.0', 'class' => 'frontEndModeration', 'title' => 'Front-end Moderation', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'frontend-moderation' . WPDISCUZ_DS . 'header.png'), 'desc' => __('All in one powerful yet simple admin toolkit to moderate comments on front-end.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-frontend-moderation/'),
            'uploader' => array('version' => '1.1.0', 'requires' => '4.0.0', 'class' => 'WpdiscuzMediaUploader', 'title' => 'Media Uploader', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'uploader' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Extended comment attachment system. Allows to upload images, videos, audios and other file types.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-media-uploader/'),
            'recaptcha' => array('version' => '1.0.5', 'requires' => '4.0.0', 'class' => 'WpdiscuzRecaptcha', 'title' => 'Google ReCaptcha', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'recaptcha' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Adds No CAPTCHA on all comment forms. Stops spam and bot comments with Google reCAPTCHA', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-recaptcha/'),
            'mycred' => array('version' => '1.0.5', 'requires' => '4.0.0', 'class' => 'myCRED_Hook_wpDiscuz_Vote', 'title' => 'myCRED Integration', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'mycred' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Integrates myCRED Badges and Ranks. Converts wpDiscuz comment votes/likes to myCRED points. ', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/wpdiscuz-mycred/'),
            'censure' => array('version' => '1.0.2', 'requires' => '4.0.0', 'class' => 'CommentCensure', 'title' => 'Comment Censure', 'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'censure' . WPDISCUZ_DS . 'header.png'), 'desc' => __('Allows censoring comment words. Filters comments and replaces those phrases with custom words.', 'wpdiscuz'), 'url' => 'https://gvectors.com/product/comments-censure-pro/'),
        );
    }

    private function initTips() {
        $this->tips = array(
            'custom-form' => array('title' => __('Custom Comment Forms', 'wpdiscuz'),
                'text' => __('You can create custom comment forms with wpDiscuz. wpDiscuz 4 comes with custom comment forms and fields. You can create custom comment forms for each post type, each form can beceated with different form fields, for eaxample: text, dropdown, rating, checkboxes, etc...', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'img' . WPDISCUZ_DS . 'tips' . WPDISCUZ_DS . 'custom-form.png'),
                'url' => admin_url() . 'edit.php?post_type=wpdiscuz_form'),
            'emoticons' => array('title' => __('Emoticons', 'wpdiscuz'),
                'text' => __('You can add more emotions to your comments using wpDiscuz Emoticons addon.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'emoticons' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-emoticons/'),
            'ads-manager' => array('title' => __('Ads Manager', 'wpdiscuz'),
                'text' => __('Increase your income using ad banners. Comment area is the most active sections for advertising. wpDiscuz Ads Manager addon is designed to help you add banners and control ads in this section.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'ads-manager' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-ads-manager/'),
            'user-mention' => array('title' => __('User and Comment Mentioning', 'wpdiscuz'),
                'text' => __('Using wpDiscuz User &amp; Comment Mentioning addon you can allow commenters mention comments and users in comment text using #comment-id and @username tags.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'user-mention' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-user-comment-mentioning/'),
            'likers' => array('title' => __('Advanced Likers', 'wpdiscuz'),
                'text' => __('wpDiscuz Advanced Likers addon displays likers and voters of each comment. Adds user reputation and badges based on received likes.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'likers' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-advanced-likers/'),
            'report-flagging' => array('title' => __('Report and Flagging', 'wpdiscuz'),
                'text' => __('Let your commenters help you to determine and remove spam comments. wpDiscuz Report and Flagging addon comes with comment reporting tools. Automaticaly auto-moderates comments based on number of flags and dislikes.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'report' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-report-flagging/'),
            'translate' => array('title' => __('Comment Translate', 'wpdiscuz'),
                'text' => __('In most cases the big part of your visitors are not a native speakers of your language. Make your comments comprehensible for all visitors using wpDiscuz Comment Translation addon. It adds smart and intuitive AJAX "Translate" button with 60 language translation options. Uses free translation API.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'translate' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-comment-translation/'),
            'search' => array('title' => __('Comment Search', 'wpdiscuz'),
                'text' => __('You can let website visitor search in comments. It\'s always more attractive to find a comment about something that interest you. Using wpDiscuz Comment Search addon you\'ll get a nice, AJAX powered front-end comment search form above comment list.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'search' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-comment-search/'),
            'widgets' => array('title' => __('wpDiscuz Widgets', 'wpdiscuz'),
                'text' => __('More Comment Widgets! Most voted comments, Active comment threads, Most commented posts, Active comment authors widgets are available in wpDiscuz Widgets Addon', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'widgets' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-widgets/'),
            'frontend-moderation' => array('title' => __('Front-end Moderation', 'wpdiscuz'),
                'text' => __('You can moderate comments on front-end using all in one powerful yet simple wpDiscuz Frontend Moderation addon.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'frontend-moderation' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-frontend-moderation/'),
            'uploader' => array('title' => __('Media Uploader', 'wpdiscuz'),
                'text' => __('You can let website visitors attach images and files to comments and embed video/audio content using wpDiscuz Media Uploader addon.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'uploader' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-media-uploader/'),
            'recaptcha' => array('title' => __('Google ReCaptcha', 'wpdiscuz'),
                'text' => __('Advanced spam protection with wpDiscuz Google reCAPTCHA addon. This addon adds No-CAPTCHA reCAPTCHA on all comment forms. Stops spam and bot comments.', 'wpdiscuz'),
                'thumb' => plugins_url(WPDISCUZ_DIR_NAME . WPDISCUZ_DS . 'assets' . WPDISCUZ_DS . 'addons' . WPDISCUZ_DS . 'recaptcha' . WPDISCUZ_DS . 'header.png'),
                'url' => 'https://gvectors.com/product/wpdiscuz-recaptcha/'),
        );
    }

    public function addonNote() {

        $lastHash = get_option('wpdiscuz-addon-note-dismissed');
        if (!$lastHash)
            return false;
        $lastHashArray = explode(',', $lastHash);
        $currentHash = $this->addonHash();
        if ($lastHash != $currentHash) {
            ?>
            <div class="updated notice wpdiscuz_addon_note is-dismissible" style="margin-top:10px;">
                <p style="font-weight:normal; font-size:15px; border-bottom:1px dotted #DCDCDC; padding-bottom:10px; width:95%;"><?php _e('New Addons are available for wpDiscuz Comments Plugin'); ?></p>
                <div style="font-size:14px;">
                    <?php
                    foreach ($this->addons as $key => $addon) {
                        if (in_array($addon['title'], $lastHashArray))
                            continue;
                        ?>
                        <div style="display:inline-block; min-width:27%; padding-right:10px; margin-bottom:10px;"><img src="<?php echo $addon['thumb'] ?>" style="height:40px; width:auto; vertical-align:middle; margin:0px 10px; text-decoration:none;" />  <a href="<?php echo admin_url('edit-comments.php?page=' . self::PAGE_ADDONS) ?>" style="color:#444; text-decoration:none;" title="<?php _e('Go to wpDiscuz Addons subMenu'); ?>"><?php echo $addon['title']; ?></a></div>
                        <?php
                    }
                    ?>
                    <div style="clear:both;"></div>
                </div>
                <p>&nbsp;&nbsp;&nbsp;<a href="<?php echo admin_url('edit-comments.php?page=' . self::PAGE_ADDONS) ?>"><?php _e('Go to wpDiscuz Addons subMenu'); ?> &raquo;</a></p>
            </div>
            <?php
        }
    }

    public function tipNote() {
        if (isset($this->optionsSerialized->disableTips) && $this->optionsSerialized->disableTips) {
            return false;
        }
        if (strpos($_SERVER['REQUEST_URI'], 'edit-comments.php?') === FALSE && strpos($_SERVER['REQUEST_URI'], 'edit.php?post_type=wpdiscuz_form') === FALSE) {
            return false;
        } else {
            $show = mt_rand(1, 5);
            if ($show != 1)
                return false;
        }
        $lastHash = get_option('wpdiscuz-tip-note-dismissed');
        $lastHashArray = explode(',', $lastHash);
        $currentHash = $this->tipHash();
        if ($lastHash != $currentHash) {
            foreach ($this->tips as $key => $tip) {
                if (in_array($tip['title'], $lastHashArray)) {
                    continue;
                }
                $notDisplayedTips[] = $tip;
            }
            if (empty($notDisplayedTips)) {
                return false;
            }
            ?>
            <div class="updated notice wpdiscuz_tip_note is-dismissible" style="margin-top:10px;">
                <p style="font-weight: 600; font-size:15px; border-bottom:1px dotted #DCDCDC; padding-bottom:10px; width:95%;"><?php _e('Do you know?', 'wpdiscuz'); ?></p>
                <div style="font-size:14px;">
                    <?php
                    $cTipKey = array_rand($notDisplayedTips, 1);
                    $cTip = $notDisplayedTips[$cTipKey];
                    ?>
                    <div style="display:inline-block; width:100%; padding-right:10px; margin-bottom:10px;">
                        <input type="hidden" value="<?php echo esc_attr($cTip['title']) ?>" name="wpdiscuz_tip_note_value" id="wpdiscuz_tip_note_value" />
                        <table style="width:100%" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="width:50px; vertical-align:middle; text-align:center;"><img src="<?php echo esc_url($cTip['thumb']) ?>" style="height:45px; width:auto; vertical-align:middle; margin:0px 10px; text-decoration:none;" /></td>
                                    <td style="vertical-align:middle;"><?php echo $cTip['text']; ?></td>
                                    <td style="width:100px; text-align:center; vertical-align:middle;"><a href="<?php echo esc_url($cTip['url']); ?>" class="button button-primary button-large" target="_blank"><?php _e('More info', 'wpdiscuz') ?></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <?php
        }
    }

    public function dismissAddonNote() {
        $hash = $this->addonHash();
        update_option('wpdiscuz-addon-note-dismissed', $hash);
        exit();
    }

    public function dismissTipNote() {
        //$hash = $this->tipDisplayed();
        $hash = $this->tipHash();
        update_option('wpdiscuz-tip-note-dismissed', $hash);
        exit();
    }

    public function dismissAddonNoteOnPage() {
        $hash = $this->addonHash();
        update_option('wpdiscuz-addon-note-dismissed', $hash);
    }

    public function addonHash() {
        $viewed = '';
        foreach ($this->addons as $key => $addon) {
            $viewed .= $addon['title'] . ',';
        }
        $hash = $viewed;
        return $hash;
    }

    public function tipHash() {
        $viewed = '';
        foreach ($this->tips as $key => $tip) {
            $viewed .= $tip['title'] . ',';
        }
        $hash = $viewed;
        return $hash;
    }

    public function tipDisplayed() {
        $tipTtile = substr(strip_tags($_GET['tip']), 0, 100);
        $lastHash = get_option('wpdiscuz-tip-note-dismissed');
        if ($lastHash) {
            $lastHashArray = explode(',', $lastHash);
        } else {
            $lastHashArray = array();
        }
        $lastHashArray[] = $tipTtile;
        $hash = implode(',', $lastHashArray);
        return $hash;
    }

    public function refreshAddonPage() {
        $lastHash = get_option('wpdiscuz-addon-note-dismissed');
        $currentHash = $this->addonHash();
        if ($lastHash != $currentHash) {
            ?>
            <script language="javascript">jQuery(document).ready(function () {
                    location.reload();
                });</script>
            <?php
        }
    }

}
