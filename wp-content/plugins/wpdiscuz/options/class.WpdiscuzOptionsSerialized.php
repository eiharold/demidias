<?php

class WpdiscuzOptionsSerialized implements WpDiscuzConstants {

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Enable wpdisucz on home page
     * Default Value - Unchecked
     */
    public $isEnableOnHome;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Enable quick tags
     * Default Value - Unchecked
     */
    public $isQuickTagsEnabled;

    /**
     * Type - Radio Button
     * Available Values - Disabled / Always updtae / Update if has new comments
     * Description - Updates comments list via ajax to show new comments
     * Default Value - Disabled
     */
    public $commentListUpdateType;

    /**
     * Type - Dropdown menu
     * Available Values - 10s, 20s, 30s, 60s(1 minute), 180s(3 minutes), 300s(5 minutes), 600s(10 minutes)
     * Description - Updates comments list every ... seconds
     * Default Value - Comment list update timer value
     */
    public $commentListUpdateTimer;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Allow live update for guests
     * Default Value - Checked
     */
    public $liveUpdateGuests;

    /**
     * Type - Dropdown menu
     * Available Values - Not Allow(0), 900s(15 minutes)  1800s(30 minutes), 3600s(1 hour), 10800s(3 hours), 86400(24 hours)
     * Description - Allow commnet editing after comment subimt
     * Default Value - Editable comment time value
     */
    public $commentEditableTime;

    /**
     * Type - Dropdown menu
     * Available Values - list of pages (ids)
     * Description - Redirect first commenter to the selected page
     * Default Value - 0
     */
    public $redirectPage;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Allow guests to vote on comments
     * Default Value - Checked
     */
    public $isGuestCanVote;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Load only parent comments
     * Default Value - Checked
     */
    public $isLoadOnlyParentComments;

    /**
     * Type - Radio Button
     * Available Values - 0 Default (Load More) / 1 Load Rest Of Comments / 2 Lazy Load comments on scrolling / 3 Load all comments
     * Description - Comment list load type
     * Default Value - Disabled
     */
    public $commentListLoadType;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Voting buttons
     * Default Value - Unchecked
     */
    public $votingButtonsShowHide;

    /**
     * Type - Radio
     * Available Values - total / separate
     * Description - Total shows sum of positive and negative votes or separate for positive and negative votes
     * Default Value - total
     */
    public $votingButtonsStyle;

    /**
     * Type - Radio
     * Available Values - font awesome icons
     * Description - Voting buttons icons
     * Default Value - total
     */
    public $votingButtonsIcon;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide header text
     * Default Value - Unchecked
     */
    public $headerTextShowHide;

    /**
     * Type - input
     * Available Values - 0 to unlimit
     * Description - If setted 0 commenter data will be stored for current session else days count
     * Default Value - Checked
     */
    public $storeCommenterData;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - If checked show logged-in user name top of the main form
     * Default Value - Checked
     */
    public $showHideLoggedInUsername;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show login link for guests
     * Default Value - Checked
     */
    public $hideLoginLinkForGuests;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Author Titles
     * Default Value - Unchecked
     */
    public $authorTitlesShowHide;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Comment date format - 20-01-2015
     * Default Value - Checked
     */
    public $simpleCommentDate;

    /**
     * Type - Radio
     * Available Values - Post/All comments/Both
     * Description - Show post/all comments or both subscription types in dropdown
     * Default Value - Checked
     */
    public $subscriptionType;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show new reply notification checkbox below the form
     * Default Value - Checked
     */
    public $showHideReplyCheckbox;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show new reply notification checkbox below the form
     * Default Value - Checked
     */
    public $isReplyDefaultChecked;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide comment sorting by votes on front-end
     * Default Value - Unchecked
     */
    public $showSortingButtons;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide comment sorting by votes on front-end
     * Default Value - Unchecked
     */
    public $mostVotedByDefault;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Use Postmatic plugin for comment notification
     * Default Value - Unchecked
     */
    public $usePostmaticForCommentNotification;

    /**
     * Type - Select
     * Available Values - 12px-16px
     * Description - Comment Text Size
     * Default Value - 14px
     */
    public $commentTextSize;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Form Background Color
     * Default Value - #F9F9F9
     */
    public $formBGColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Comment Background Color
     * Default Value - #FEFEFE
     */
    public $commentBGColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Reply Background Color
     * Default Value - #F8F8F8
     */
    public $replyBGColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Comment Username Color
     * Default Value - #00B38F
     */
    public $primaryColor;


    // == RATING == //

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Rating hover color
     * Default Value - #FFED85
     */
    public $ratingHoverColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Rating inactiv color
     * Default Value - #DDDDDD
     */
    public $ratingInactivColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Rating activ color
     * Default Value - #FFD700
     */
    public $ratingActivColor;

    /**
     * Type - Checkbox
     * Available Values - before , after
     * Description - Display ratings on page 
     * Default Value - after
     */
    public $displayRatingOnPost;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Display ratings on none single pages
     * Default Value - Unchecked
     */
    public $ratingCssOnNoneSingular;

    // == RATING == //

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Colors for blog users by roles 
     * Default Value - #00B38F
     */
    public $blogRoles;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Vote, Reply, Share, Edit - text colors
     * Default Value - #666666
     */
    public $buttonColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Form imput border olor
     * Default Value - #D9D9D9
     */
    public $inputBorderColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - New Comments background color
     * Default Value - #FFFAD6
     */
    public $newLoadedCommentBGColor;

    /**
     * Type - Checkbox
     * Available Values - checked / unchecked
     * Description - Disable loading font awesome css
     * Default Value - checked
     */
    public $disableFontAwesome;

    /**
     * Type - Textarea
     * Available Values - custom css code
     * Description - Custom css code
     * Default Value -
     */
    public $customCss;

    /**
     * Type - HTML elements array
     * Available Values - Text
     * Description - Phrases for form elements texts
     * Default Value -
     */
    public $phrases;

    /**
     * helper class for database operations
     */
    public $dbManager;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Hide plugin powerid by information
     * Default Value - Unchecked
     */
    public $showPluginPoweredByLink;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Use .PO/.MO files
     * Default Value - Unchecked
     */
    public $isUsePoMo;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Disable confirmation email for members
     * Default Value - Unchecked
     */
    public $disableMemberConfirm;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Disable confirmation email for members
     * Default Value - Unchecked
     */
    public $disableGuestsConfirm;

    /**
     * Type - Input
     * Available Values - Integer (comment text min length)
     * Description - Define comment text min length
     * Default Value - 1 character
     */
    public $commentTextMinLength;

    /**
     * Type - Input
     * Available Values - Integer (comment text length)
     * Description - Define comment text max length (leave blank for unlimit length)
     * Default Value - Unlimit
     */
    public $commentTextMaxLength;

    /**
     * Type - Input
     * Available Values - Integer (after the limit has been reached show read more link)
     * Description - Define words max count for read more link
     * Default Value - 100 words
     */
    public $commentReadMoreLimit;

    /**
     * Type - Radio
     * Available Values - Filesystem / session
     * Description - captcha generation type
     * Default Value - 0, which means captcha image will be stored in filesystem
     */
    public $isCaptchaInSession;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - get user / if checked by email else by id
     * Default Value - Unchecked
     */
    public $isUserByEmail;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Hide comment link if checked
     * Default Value - Unchecked
     */
    public $showHideCommentLink;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Hide comment date if checked
     * Default Value - Unchecked
     */
    public $hideCommentDate;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Enable automatic image URL to image HTML conversion
     * Default Value - Checked
     */
    public $enableImageConversion;

    /**
     * Type - Radio Button
     * Available Values - 1 Replace non-https content to simple link URLs  / 2 Just replace http protocols to https (https may not be supported by content provider) / 3 Ignore non-https content 
     * Description - This option detects images and other contents with non-https source URLs and fix according to your selected logic
     * Default Value - 1 Replace non-https content to simple link URLs
     */
    public $commentLinkFilter;

    /**
     * Type - Input
     * Available Values - Integer (after the limit has been reached show read more link)
     * Description - Define words max count for read more link
     * Default Value - 100 words
     */
    public $commenterNameMinLength;

    /**
     * Type - Checkbox
     * Available Values - checked / unchecked
     * Description - Disable disable tips
     * Default Value - unchecked
     */
    public $disableTips;

    /**
     * Type - Checkbox
     * Available Values - checked / unchecked
     * Description - Disable profile urls
     * Default Value - unchecked
     */
    public $disableProfileURLs;

    /**
     * Type - Input
     * Available Values - Integer (after the limit has been reached show read more link)
     * Description - Define words max count for read more link
     * Default Value - 100 words
     */
    public $commenterNameMaxLength;
    public $isGoodbyeCaptchaActive;
    public $goodbyeCaptchaTocken;
    public $formContentTypeRel;
    public $formPostRel;
    public $guestCanComment;

    /**
     * Type - Checkbox
     * Available Values - checked / unchecked
     * Description - Notify comment author if comment was approved
     * Default Value - checked
     */
    public $isNotifyOnCommentApprove;

    /* === CACHE === */

    /**
     * Type - Select
     * Available Values - checked / unchecked
     * Description - Enable or disable gravatar caching
     * Default Value - checked
     */
    public $isGravatarCacheEnabled;

    /**
     * Type - Radio
     * Available Values - Runtime / Cron Job
     * Description - Set preffered method of avatars caching
     * Default Value - Cron Job
     */
    public $gravatarCacheMethod;

    /**
     * Type - Select
     * Available Values - int numbers
     * Description - Avatar caching time limit
     * Default Value - 7
     */
    public $gravatarCacheTimeout;
    public $isFileFunctionsExists;
    /* === CACHE === */

    /**
     * Type - Radio
     * Available Values - Default / Dark
     * Description - Comment form style - default or dark
     * Default Value - Default
     */
    public $theme;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description - Reverse replies on root comment or not
     * Default Value - Unchecked
     */
    public $reverseChildren;

    /**
     * Type - Input text
     * Available Values - random string (32 chars)
     * Description - Generating unique key for spam protection
     * Default Value - unique key
     */
    public $antispamKey;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description - Hide "My Content and Settings" button
     * Default Value - Unchecked
     */
    public $hideUserSettingsButton;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description -  Hide "Discussion Statistic" section
     * Default Value - Unchecked
     */
    public $hideDiscussionStat;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description - Hide "Recent Comment Authors" section
     * Default Value - Unchecked
     */
    public $hideRecentAuthors;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description - Display note about Invisible Spam Protection
     * Default Value - Checked
     */
    public $displayAntispamNote;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description - Hide stick comment button
     * Default Value - Unchecked
     */
    public $enableStickButton;

    /**
     * Type - Checkbox
     * Available Values - Checked / Unchecked
     * Description - Hide close comment button
     * Default Value - Unchecked
     */
    public $enableCloseButton;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Enable/disable form drop animation
     * Default Value - Checked
     */
    public $enableDropAnimation;

    /** == SOCIAL ==* */
    public $socialLoginAgreementCheckbox;
    public $socialLoginInSecondaryForm;
    //Facebook 
    public $enableFbLogin;
    public $enableFbShare;
    public $fbAppID;
    public $fbAppSecret;
    public $fbUseOAuth2;
    //Twitter
    public $enableTwitterLogin;
    public $enableTwitterShare;
    public $twitterAppID;
    public $twitterAppSecret;
    //Google
    public $enableGoogleLogin;
    public $enableGoogleShare;
    public $googleAppID;
    //OK
    public $enableOkLogin;
    public $enableOkShare;
    public $okAppID;
    public $okAppKey;
    public $okAppSecret;
    //VK
    public $enableVkLogin;
    public $enableVkShare;
    public $vkAppID;
    public $vkAppSecret;

    /** == USERS FOLLOW ==* */
    public $isFollowActive;
    public $disableFollowConfirmForUsers;

    /**
     * wordpress options
     */
    public $wordpressDateFormat;
    public $wordpressTimeFormat;
    public $wordpressThreadComments;
    public $wordpressThreadCommentsDepth;
    public $wordpressIsPaginate;
    public $wordpressCommentOrder;
    public $wordpressDefaultCommentsPage;
    public $wordpressCommentPerPage;
    public $wordpressShowAvatars;

    function __construct($dbmanager) {
        $this->dbManager = $dbmanager;
        add_option(self::OPTION_SLUG_HASH_KEY, md5(time() . uniqid()), '', 'no');
        $this->initPhrases();
        $this->addOptions();
        $this->initOptions(get_option(self::OPTION_SLUG_OPTIONS));
        $this->wordpressDateFormat = get_option('date_format');
        $this->wordpressTimeFormat = get_option('time_format');
        $this->wordpressThreadComments = get_option('thread_comments');
        $this->wordpressThreadCommentsDepth = get_option('thread_comments_depth');
        $this->wordpressIsPaginate = get_option('page_comments');
        $this->wordpressCommentOrder = get_option('comment_order');
        $this->wordpressCommentPerPage = get_option('comments_per_page');
        $this->wordpressShowAvatars = get_option('show_avatars');
        $this->wordpressDefaultCommentsPage = get_option('default_comments_page');
        $this->isFileFunctionsExists = function_exists('file_get_contents') && function_exists('file_put_contents');
        $this->initFormRelations();
        $this->initGoodbyeCaptchaField();
        add_action('init', array(&$this, 'initPhrasesOnLoad'), 2126);
    }

    public function initOptions($serialize_options) {
        $options = maybe_unserialize($serialize_options);
        $this->isEnableOnHome = isset($options['isEnableOnHome']) ? $options['isEnableOnHome'] : 0;
        $this->isQuickTagsEnabled = isset($options['wc_quick_tags']) ? $options['wc_quick_tags'] : 0;
        $this->commentListUpdateType = isset($options['wc_comment_list_update_type']) ? $options['wc_comment_list_update_type'] : 0;
        $this->commentListUpdateTimer = isset($options['wc_comment_list_update_timer']) ? $options['wc_comment_list_update_timer'] : 30;
        $this->liveUpdateGuests = isset($options['wc_live_update_guests']) ? $options['wc_live_update_guests'] : 1;
        $this->commentEditableTime = isset($options['wc_comment_editable_time']) ? $options['wc_comment_editable_time'] : 900;
        $this->redirectPage = isset($options['wpdiscuz_redirect_page']) ? $options['wpdiscuz_redirect_page'] : 0;
        $this->isGuestCanVote = isset($options['wc_is_guest_can_vote']) ? $options['wc_is_guest_can_vote'] : 0;
        $this->isLoadOnlyParentComments = isset($options['isLoadOnlyParentComments']) ? $options['isLoadOnlyParentComments'] : 0;
        $this->commentListLoadType = isset($options['commentListLoadType']) ? $options['commentListLoadType'] : 0;
        $this->votingButtonsShowHide = isset($options['wc_voting_buttons_show_hide']) ? $options['wc_voting_buttons_show_hide'] : 0;
        $this->votingButtonsStyle = isset($options['votingButtonsStyle']) ? $options['votingButtonsStyle'] : 0;
        $this->votingButtonsIcon = isset($options['votingButtonsIcon']) ? $options['votingButtonsIcon'] : 'fa-plus|fa-minus';
        $this->headerTextShowHide = isset($options['wc_header_text_show_hide']) ? $options['wc_header_text_show_hide'] : 0;
        $this->storeCommenterData = isset($options['storeCommenterData']) ? $options['storeCommenterData'] : 0;
        $this->showHideLoggedInUsername = isset($options['wc_show_hide_loggedin_username']) ? $options['wc_show_hide_loggedin_username'] : 0;
        $this->hideLoginLinkForGuests = isset($options['hideLoginLinkForGuests']) ? $options['hideLoginLinkForGuests'] : 1;
        $this->hideUserSettingsButton = isset($options['hideUserSettingsButton']) ? $options['hideUserSettingsButton'] : 0;
        $this->hideDiscussionStat = isset($options['hideDiscussionStat']) ? $options['hideDiscussionStat'] : 0;
        $this->hideRecentAuthors = isset($options['hideRecentAuthors']) ? $options['hideRecentAuthors'] : 0;
        $this->displayAntispamNote = isset($options['displayAntispamNote']) ? $options['displayAntispamNote'] : 0;
        $this->authorTitlesShowHide = isset($options['wc_author_titles_show_hide']) ? $options['wc_author_titles_show_hide'] : 0;
        $this->simpleCommentDate = isset($options['wc_simple_comment_date']) ? $options['wc_simple_comment_date'] : 0;
        $this->subscriptionType = isset($options['subscriptionType']) ? $options['subscriptionType'] : 1;
        $this->showHideReplyCheckbox = isset($options['wc_show_hide_reply_checkbox']) ? $options['wc_show_hide_reply_checkbox'] : 0;
        $this->isReplyDefaultChecked = isset($options['isReplyDefaultChecked']) ? $options['isReplyDefaultChecked'] : 0;
        $this->showSortingButtons = isset($options['show_sorting_buttons']) ? $options['show_sorting_buttons'] : 1;
        $this->mostVotedByDefault = isset($options['mostVotedByDefault']) ? $options['mostVotedByDefault'] : 0;
        $this->usePostmaticForCommentNotification = isset($options['wc_use_postmatic_for_comment_notification']) ? $options['wc_use_postmatic_for_comment_notification'] : 0;
        $this->commentTextSize = isset($options['wc_comment_text_size']) ? $options['wc_comment_text_size'] : '14px';
        $this->formBGColor = isset($options['wc_form_bg_color']) ? $options['wc_form_bg_color'] : '#F9F9F9';
        $this->commentBGColor = isset($options['wc_comment_bg_color']) ? $options['wc_comment_bg_color'] : '#FEFEFE';
        $this->replyBGColor = isset($options['wc_reply_bg_color']) ? $options['wc_reply_bg_color'] : '#F8F8F8';
        $this->primaryColor = isset($options['wc_comment_username_color']) ? $options['wc_comment_username_color'] : '#00B38F';
        $this->ratingHoverColor = isset($options['wc_comment_rating_hover_color']) ? $options['wc_comment_rating_hover_color'] : '#FFED85';
        $this->ratingInactivColor = isset($options['wc_comment_rating_inactiv_color']) ? $options['wc_comment_rating_inactiv_color'] : '#DDDDDD';
        $this->ratingActivColor = isset($options['wc_comment_rating_activ_color']) ? $options['wc_comment_rating_activ_color'] : '#FFD700';
        $this->blogRoles = isset($options['wc_blog_roles']) ? $options['wc_blog_roles'] : array();
        $this->buttonColor = isset($options['wc_link_button_color']) ? $options['wc_link_button_color'] : array('primary_button_bg' => '#555555', 'primary_button_color' => '#FFFFFF', 'secondary_button_color' => '#777777', 'secondary_button_border' => '#dddddd', 'vote_up_link_color' => '#999999', 'vote_down_link_color' => '#999999');
        $this->inputBorderColor = isset($options['wc_input_border_color']) ? $options['wc_input_border_color'] : "#D9D9D9";
        $this->newLoadedCommentBGColor = isset($options['wc_new_loaded_comment_bg_color']) ? $options['wc_new_loaded_comment_bg_color'] : '#FFFAD6';
        $this->disableFontAwesome = isset($options['disableFontAwesome']) ? $options['disableFontAwesome'] : 0;
        $this->disableTips = isset($options['disableTips']) ? $options['disableTips'] : 0;
        $this->disableProfileURLs = isset($options['disableProfileURLs']) ? $options['disableProfileURLs'] : 0;
        $this->displayRatingOnPost = isset($options['displayRatingOnPost']) ? $options['displayRatingOnPost'] : array();
        $this->ratingCssOnNoneSingular = isset($options['ratingCssOnNoneSingular']) ? $options['ratingCssOnNoneSingular'] : 0;
        $this->customCss = isset($options['wc_custom_css']) ? $options['wc_custom_css'] : '.comments-area{width:auto; margin: 0 auto;}';
        $this->showPluginPoweredByLink = isset($options['wc_show_plugin_powerid_by']) ? $options['wc_show_plugin_powerid_by'] : 0;
        $this->isUsePoMo = isset($options['wc_is_use_po_mo']) ? $options['wc_is_use_po_mo'] : 0;
        $this->disableMemberConfirm = isset($options['wc_disable_member_confirm']) ? $options['wc_disable_member_confirm'] : 0;
        $this->disableGuestsConfirm = isset($options['disableGuestsConfirm']) ? $options['disableGuestsConfirm'] : 0;
        $this->commentTextMinLength = isset($options['wc_comment_text_min_length']) ? $options['wc_comment_text_min_length'] : 1;
        $this->commentTextMaxLength = isset($options['wc_comment_text_max_length']) ? $options['wc_comment_text_max_length'] : '';
        $this->commentReadMoreLimit = isset($options['commentWordsLimit']) ? $options['commentWordsLimit'] : 100;
        $this->showHideCommentLink = isset($options['showHideCommentLink']) ? $options['showHideCommentLink'] : 0;
        $this->hideCommentDate = isset($options['hideCommentDate']) ? $options['hideCommentDate'] : 0;
        $this->enableImageConversion = isset($options['enableImageConversion']) ? $options['enableImageConversion'] : 1;
        $this->commentLinkFilter = isset($options['commentLinkFilter']) ? $options['commentLinkFilter'] : 1;
        $this->isCaptchaInSession = isset($options['isCaptchaInSession']) ? $options['isCaptchaInSession'] : 0;
        $this->isUserByEmail = isset($options['isUserByEmail']) ? $options['isUserByEmail'] : 0;
        $this->commenterNameMinLength = isset($options['commenterNameMinLength']) ? $options['commenterNameMinLength'] : 1;
        $this->commenterNameMaxLength = isset($options['commenterNameMaxLength']) ? $options['commenterNameMaxLength'] : 50;
        $this->isNotifyOnCommentApprove = isset($options['isNotifyOnCommentApprove']) ? $options['isNotifyOnCommentApprove'] : 0;
        $this->isGravatarCacheEnabled = isset($options['isGravatarCacheEnabled']) ? $options['isGravatarCacheEnabled'] : 0;
        $this->gravatarCacheMethod = isset($options['gravatarCacheMethod']) ? $options['gravatarCacheMethod'] : 'cronjob';
        $this->gravatarCacheTimeout = isset($options['gravatarCacheTimeout']) ? $options['gravatarCacheTimeout'] : 10;
        $this->theme = isset($options['theme']) ? $options['theme'] : 'wpd-default';
        $this->reverseChildren = isset($options['reverseChildren']) ? $options['reverseChildren'] : 0;
        $this->antispamKey = isset($options['antispamKey']) ? $options['antispamKey'] : '';
        //social 
        // fb
        $this->socialLoginAgreementCheckbox = isset($options['socialLoginAgreementCheckbox']) ? $options['socialLoginAgreementCheckbox'] : 0;
        $this->socialLoginInSecondaryForm = isset($options['socialLoginInSecondaryForm']) ? $options['socialLoginInSecondaryForm'] : 0;

        $this->enableFbLogin = isset($options['enableFbLogin']) ? $options['enableFbLogin'] : 0;
        $this->enableFbShare = isset($options['enableFbShare']) ? $options['enableFbShare'] : 0;
        $this->fbAppID = isset($options['fbAppID']) ? $options['fbAppID'] : '';
        $this->fbAppSecret = isset($options['fbAppSecret']) ? $options['fbAppSecret'] : '';
        $this->fbUseOAuth2 = isset($options['fbUseOAuth2']) ? $options['fbUseOAuth2'] : 0;
        // twitter
        $this->enableTwitterLogin = isset($options['enableTwitterLogin']) ? $options['enableTwitterLogin'] : 0;
        $this->enableTwitterShare = isset($options['enableTwitterShare']) ? $options['enableTwitterShare'] : 0;
        $this->twitterAppID = isset($options['twitterAppID']) ? $options['twitterAppID'] : '';
        $this->twitterAppSecret = isset($options['twitterAppSecret']) ? $options['twitterAppSecret'] : '';
        // google+
        $this->enableGoogleLogin = isset($options['enableGoogleLogin']) ? $options['enableGoogleLogin'] : 0;
        $this->enableGoogleShare = isset($options['enableGoogleShare']) ? $options['enableGoogleShare'] : 0;
        $this->googleAppID = isset($options['googleAppID']) ? $options['googleAppID'] : '';
        // ok
        $this->enableOkLogin = isset($options['enableOkLogin']) ? $options['enableOkLogin'] : 0;
        $this->enableOkShare = isset($options['enableOkShare']) ? $options['enableOkShare'] : 0;
        $this->okAppID = isset($options['okAppID']) ? $options['okAppID'] : '';
        $this->okAppKey = isset($options['okAppKey']) ? $options['okAppKey'] : '';
        $this->okAppSecret = isset($options['okAppSecret']) ? $options['okAppSecret'] : '';
        // vk
        $this->enableVkLogin = isset($options['enableVkLogin']) ? $options['enableVkLogin'] : 0;
        $this->enableVkShare = isset($options['enableVkShare']) ? $options['enableVkShare'] : 0;
        $this->vkAppID = isset($options['vkAppID']) ? $options['vkAppID'] : '';
        $this->vkAppSecret = isset($options['vkAppSecret']) ? $options['vkAppSecret'] : '';

        $this->isFollowActive = isset($options['isFollowActive']) ? $options['isFollowActive'] : 0;
        $this->disableFollowConfirmForUsers = isset($options['disableFollowConfirmForUsers']) ? $options['disableFollowConfirmForUsers'] : 0;
        $this->enableStickButton = isset($options['enableStickButton']) ? $options['enableStickButton'] : 0;
        $this->enableCloseButton = isset($options['enableCloseButton']) ? $options['enableCloseButton'] : 0;
        $this->enableDropAnimation = isset($options['enableDropAnimation']) ? $options['enableDropAnimation'] : 0;
        do_action('wpdiscuz_init_options', $this);
    }

    /**
     * initialize default phrases
     */
    public function initPhrases() {
        $this->phrases = array(
            'wc_be_the_first_text' => __('Be the First to Comment!', 'wpdiscuz'),
            'wc_comment_start_text' => __('Start the discussion', 'wpdiscuz'),
            'wc_comment_join_text' => __('Join the discussion', 'wpdiscuz'),
            'wc_comment_threads' => __('Comment threads', 'wpdiscuz'),
            'wc_thread_replies' => __('Thread replies', 'wpdiscuz'),
            'wc_followers' => __('Followers', 'wpdiscuz'),
            'wc_most_reacted_comment' => __('Most reacted comment', 'wpdiscuz'),
            'wc_hottest_comment_thread' => __('Hottest comment thread', 'wpdiscuz'),
            'wc_comment_authors' => __('Comment authors', 'wpdiscuz'),
            'wc_recent_comment_authors' => __('Recent comment authors', 'wpdiscuz'),
            'wc_email_text' => __('Email', 'wpdiscuz'),
            'wc_subscribe_anchor' => __('Subscribe', 'wpdiscuz'),
            'wc_notify_of' => __('Notify of', 'wpdiscuz'),
            'wc_notify_on_new_comment' => __('new follow-up comments', 'wpdiscuz'),
            'wc_notify_on_all_new_reply' => __('new replies to my comments', 'wpdiscuz'),
            'wc_notify_on_new_reply' => __('Notify of new replies to this comment', 'wpdiscuz'),
            'wc_sort_by' => __('Sort by', 'wpdiscuz'),
            'wc_newest' => __('newest', 'wpdiscuz'),
            'wc_oldest' => __('oldest', 'wpdiscuz'),
            'wc_most_voted' => __('most voted', 'wpdiscuz'),
            'wc_load_more_submit_text' => __('Load More Comments', 'wpdiscuz'),
            'wc_load_rest_comments_submit_text' => __('Load Rest of Comments', 'wpdiscuz'),
            'wc_reply_text' => __('Reply', 'wpdiscuz'),
            'wc_share_text' => __('Share', 'wpdiscuz'),
            'wc_edit_text' => __('Edit', 'wpdiscuz'),
            'wc_share_facebook' => __('Share On Facebook', 'wpdiscuz'),
            'wc_share_twitter' => __('Share On Twitter', 'wpdiscuz'),
            'wc_share_google' => __('Share On Google', 'wpdiscuz'),
            'wc_share_vk' => __('Share On VKontakte', 'wpdiscuz'),
            'wc_share_ok' => __('Share On Odnoklassniki', 'wpdiscuz'),
            'wc_hide_replies_text' => __('Hide Replies', 'wpdiscuz'),
            'wc_show_replies_text' => __('View Replies', 'wpdiscuz'),
            'wc_email_subject' => __('New Comment', 'wpdiscuz'),
            'wc_email_message' => __('Hi [SUBSCRIBER_NAME],<br/><br/>new comment on the discussion section you\'ve been interested in<br/><br/><a href="[COMMENT_URL]">[COMMENT_URL]</a><br/><br/>[COMMENT_CONTENT]<br/><br/><a href="[UNSUBSCRIBE_URL]">' . __('Unsubscribe', 'wpdiscuz') . '</a>', 'wpdiscuz'),
            'wc_all_comment_new_reply_subject' => __('New Reply', 'wpdiscuz'),
            'wc_all_comment_new_reply_message' => __('Hi [SUBSCRIBER_NAME],<br/><br/>new reply on the discussion section you\'ve been interested in<br/><br/><a href="[COMMENT_URL]">[COMMENT_URL]</a><br/><br/>[COMMENT_CONTENT]<br/><br/><a href="[UNSUBSCRIBE_URL]">' . __('Unsubscribe', 'wpdiscuz') . '</a>', 'wpdiscuz'),
            'wc_new_reply_email_subject' => __('New Reply', 'wpdiscuz'),
            'wc_new_reply_email_message' => __('Hi [COMMENT_AUTHOR],<br/><br/>new reply on the discussion section you\'ve been interested in<br/><br/><a href="[COMMENT_URL]">[COMMENT_URL]</a><br/><br/>[COMMENT_CONTENT]<br/><br/><a href="[UNSUBSCRIBE_URL]">' . __('Unsubscribe', 'wpdiscuz') . '</a>', 'wpdiscuz'),
            'wc_subscribed_on_comment' => __('You\'re subscribed for new replies on this comment', 'wpdiscuz'),
            'wc_subscribed_on_all_comment' => __('You\'re subscribed for new replies on all your comments', 'wpdiscuz'),
            'wc_subscribed_on_post' => __('You\'re subscribed for new follow-up comments on this post', 'wpdiscuz'),
            'wc_unsubscribe' => __('Unsubscribe', 'wpdiscuz'),
            'wc_ignore_subscription' => __('Cancel subscription', 'wpdiscuz'),
            'wc_unsubscribe_message' => __('You\'ve successfully unsubscribed.', 'wpdiscuz'),
            'wc_subscribe_message' => __('You\'ve successfully subscribed.', 'wpdiscuz'),
            'wc_confirm_email' => __('Confirm your subscription', 'wpdiscuz'),
            'wc_comfirm_success_message' => __('You\'ve successfully confirmed your subscription.', 'wpdiscuz'),
            'wc_confirm_email_subject' => __('Subscription Confirmation', 'wpdiscuz'),
            'wc_confirm_email_message' => __('Hi, <br/> You just subscribed for new comments on our website. This means you will receive an email when new comments are posted according to subscription option you\'ve chosen. <br/> To activate, click confirm below. If you believe this is an error, ignore this message and we\'ll never bother you again. <br/><br/><a href="[POST_URL]">[POST_TITLE]</a><br/><br/><a href="[CONFIRM_URL]">' . __('Confirm Your Subscrption', 'wpdiscuz') . '</a><br/><br/><a href="[CANCEL_URL]">' . __('Cancel Subscription', 'wpdiscuz') . '</a>', 'wpdiscuz'),
            'wc_error_empty_text' => __('please fill out this field to comment', 'wpdiscuz'),
            'wc_error_email_text' => __('email address is invalid', 'wpdiscuz'),
            'wc_error_url_text' => __('url is invalid', 'wpdiscuz'),
            'wc_year_text' => __('year', 'wpdiscuz'),
            'wc_year_text_plural' => __('years', 'wpdiscuz'), // PLURAL
            'wc_month_text' => __('month', 'wpdiscuz'),
            'wc_month_text_plural' => __('months', 'wpdiscuz'), // PLURAL
            'wc_day_text' => __('day', 'wpdiscuz'),
            'wc_day_text_plural' => __('days', 'wpdiscuz'), // PLURAL
            'wc_hour_text' => __('hour', 'wpdiscuz'),
            'wc_hour_text_plural' => __('hours', 'wpdiscuz'), // PLURAL
            'wc_minute_text' => __('minute', 'wpdiscuz'),
            'wc_minute_text_plural' => __('minutes', 'wpdiscuz'), // PLURAL
            'wc_second_text' => __('second', 'wpdiscuz'),
            'wc_second_text_plural' => __('seconds', 'wpdiscuz'), // PLURAL
            'wc_right_now_text' => __('right now', 'wpdiscuz'),
            'wc_ago_text' => __('ago', 'wpdiscuz'),
            'wc_you_must_be_text' => __('You must be', 'wpdiscuz'),
            'wc_logged_in_as' => __('You are logged in as', 'wpdiscuz'),
            'wc_log_in' => __('Login', 'wpdiscuz'),
            'wc_login_please' => __('Please %s to comment', 'wpdiscuz'),
            'wc_log_out' => __('Log out', 'wpdiscuz'),
            'wc_logged_in_text' => __('logged in', 'wpdiscuz'),
            'wc_to_post_comment_text' => __('to post a comment.', 'wpdiscuz'),
            'wc_vote_up' => __('Vote Up', 'wpdiscuz'),
            'wc_vote_down' => __('Vote Down', 'wpdiscuz'),
            'wc_vote_counted' => __('Vote Counted', 'wpdiscuz'),
            'wc_vote_only_one_time' => __("You've already voted for this comment", 'wpdiscuz'),
            'wc_voting_error' => __('Voting Error', 'wpdiscuz'),
            'wc_login_to_vote' => __('You Must Be Logged In To Vote', 'wpdiscuz'),
            'wc_self_vote' => __('You cannot vote for your comment', 'wpdiscuz'),
            'wc_deny_voting_from_same_ip' => __('You are not allowed to vote for this comment', 'wpdiscuz'),
            'wc_invalid_captcha' => __('Invalid Captcha Code', 'wpdiscuz'),
            'wc_invalid_field' => __('Some of field value is invalid', 'wpdiscuz'),
            'wc_new_comment_button_text' => __('new comment', 'wpdiscuz'),
            'wc_new_comments_button_text' => __('new comments', 'wpdiscuz'), // PLURAL
            'wc_held_for_moderate' => __('Comment awaiting moderation', 'wpdiscuz'),
            'wc_new_reply_button_text' => __('new reply on your comment', 'wpdiscuz'),
            'wc_new_replies_button_text' => __('new replies on your comments', 'wpdiscuz'), // PLURAL            
            'wc_comment_not_updated' => __('Sorry, the comment was not updated', 'wpdiscuz'),
            'wc_comment_edit_not_possible' => __('Sorry, this comment no longer possible to edit', 'wpdiscuz'),
            'wc_comment_not_edited' => __('You\'ve not made any changes', 'wpdiscuz'),
            'wc_comment_edit_save_button' => __('Save', 'wpdiscuz'),
            'wc_comment_edit_cancel_button' => __('Cancel', 'wpdiscuz'),
            'wc_msg_input_min_length' => __('Input is too short', 'wpdiscuz'),
            'wc_msg_input_max_length' => __('Input is too long', 'wpdiscuz'),
            'wc_read_more' => __('Read more &raquo;', 'wpdiscuz'),
            'wc_anonymous' => __('Anonymous', 'wpdiscuz'),
            'wc_msg_required_fields' => __('Please fill out required fields', 'wpdiscuz'),
            'wc_connect_with' => __('Connect with', 'wpdiscuz'),
            'wc_subscribed_to' => __('You\'re subscribed to', 'wpdiscuz'),
            'wc_postmatic_subscription_label' => __('Participate in this discussion via email', 'wpdiscuz'),
            'wc_form_subscription_submit' => __('&rsaquo;', 'wpdiscuz'),
            'wc_comment_approved_email_subject' => __('Your comment is approved!', 'wpdiscuz'),
            'wc_comment_approved_email_message' => __('Hi [COMMENT_AUTHOR],<br/><br/>your comment was approved.<br/><br/><a href="[COMMENT_URL]">[COMMENT_URL]</a><br/><br/>[COMMENT_CONTENT]', 'wpdiscuz'),
            'wc_roles_cannot_comment_message' => __('Comments are closed.', 'wpdiscuz'),
            'wc_stick_comment_btn_title' => __('Stick this comment', 'wpdiscuz'),
            'wc_stick_comment' => __('Stick', 'wpdiscuz'),
            'wc_unstick_comment' => __('Unstick', 'wpdiscuz'),
            'wc_sticky_comment_icon_title' => __('Sticky comment thread', 'wpdiscuz'),
            'wc_close_comment_btn_title' => __('Close this thread', 'wpdiscuz'),
            'wc_close_comment' => __('Close', 'wpdiscuz'),
            'wc_open_comment' => __('Open', 'wpdiscuz'),
            'wc_closed_comment_icon_title' => __('Closed comment thread', 'wpdiscuz'),
            'wc_social_login_agreement_label' => __('I allow to create an account', 'wpdiscuz'),
            'wc_social_login_agreement_desc' => __('When you login first time using a Social Login button, we collect your account public profile information shared by Social Login provider, based on your privacy settings. We also get your email address to automatically create an account for you in our website. Once your account is created, you\'ll be logged-in to this account.', 'wpdiscuz'),
            'wc_invisible_antispam_note' => __('This comment form is under antispam protection', 'wpdiscuz'),
            'wc_agreement_button_disagree' => __('Disagree', 'wpdiscuz'),
            'wc_agreement_button_agree' => __('Agree', 'wpdiscuz'),
            'wc_content_and_settings' => __('My content and settings', 'wpdiscuz'),
            'wc_user_settings_activity' => __('Activity', 'wpdiscuz'),
            'wc_user_settings_subscriptions' => __('Subscriptions', 'wpdiscuz'),
            'wc_user_settings_follows' => __('Follows', 'wpdiscuz'),
            'wc_user_settings_response_to' => __('In response to:', 'wpdiscuz'),
            'wc_user_settings_email_me_delete_links' => __('Bulk management via email', 'wpdiscuz'),
            'wc_user_settings_email_me_delete_links_desc' => __('Click the button above to get an email with bulk delete and unsubscribe links.', 'wpdiscuz'),
            'wc_user_settings_no_data' => __('No data found!', 'wpdiscuz'),
            'wc_user_settings_request_deleting_comments' => __('Delete all my comments', 'wpdiscuz'),
            'wc_user_settings_cancel_subscriptions' => __('Cancel all comment subscriptions', 'wpdiscuz'),
            'wc_user_settings_clear_cookie' => __('Clear cookies with my personal data', 'wpdiscuz'),
            'wc_user_settings_delete_links' => __('Bulk management via email', 'wpdiscuz'),
            'wc_user_settings_delete_all_comments' => __('Delete all my comments', 'wpdiscuz'),
            'wc_user_settings_delete_all_comments_message' => __('Please use this link to delete all your comments. Please note, that this action cannot be undone.<br/><br/><a href="[DELETE_COMMENTS_URL]" target="_blank">Delete all my comments</a><br/><br/>', 'wpdiscuz'),
            'wc_user_settings_delete_all_subscriptions' => __('Delete all my subscriptions', 'wpdiscuz'),
            'wc_user_settings_delete_all_subscriptions_message' => __('Please use this link to cancel all subscriptions for new comments. Please note, that this action cannot be undone.<br/><br/><a href="[DELETE_SUBSCRIPTIONS_URL]" target="_blank">Delete all my subscriptions</a><br/><br/>', 'wpdiscuz'),
            'wc_user_settings_delete_all_follows' => __('Delete all my follows', 'wpdiscuz'),
            'wc_user_settings_delete_all_follows_message' => __('Please use this link to cancel all follows for new comments. Please note, that this action cannot be undone.<br/><br/><a href="[DELETE_FOLLOWS_URL]" target="_blank">Delete all my follows</a><br/><br/>', 'wpdiscuz'),
            'wc_user_settings_subscribed_to_replies' => __('subscribed to this comment', 'wpdiscuz'),
            'wc_user_settings_subscribed_to_replies_own' => __('subscribed to my comments', 'wpdiscuz'),
            'wc_user_settings_subscribed_to_all_comments' => __('subscribed to all follow-up comments of this post', 'wpdiscuz'),
            'wc_user_settings_check_email' => __('Please check your email.'),
            'wc_user_settings_email_error' => __('Error : Can\'t send email.', 'wpdiscuz'),
            'wc_confirm_comment_delete' => __('Are you sure you want to delete this comment?', 'wpdiscuz'),
            'wc_confirm_cancel_subscription' => __('Are you sure you want to cancel this subscription?', 'wpdiscuz'),
            'wc_confirm_cancel_follow' => __('Are you sure you want to cancel this follow?', 'wpdiscuz'),
            'wc_follow_user' => __('Follow this user', 'wpdiscuz'),
            'wc_unfollow_user' => __('Unfollow this user', 'wpdiscuz'),
            'wc_follow_success' => __('You started following this comment author', 'wpdiscuz'),
            'wc_follow_canceled' => __('You stopped following this comment author.', 'wpdiscuz'),
            'wc_follow_email_confirm' => __('Please check your email and confirm the user following request.', 'wpdiscuz'),
            'wc_follow_email_confirm_fail' => __('Sorry, we couldn\'t send confirmation email.', 'wpdiscuz'),
            'wc_follow_login_to_follow' => __('Please login to follow users.', 'wpdiscuz'),
            'wc_follow_impossible' => __('We are sorry, but you can\'t follow this user.', 'wpdiscuz'),
            'wc_follow_not_added' => __('Following failed. Please try again later.', 'wpdiscuz'),
            'wc_follow_confirm' => __('Confirm user following request', 'wpdiscuz'),
            'wc_follow_cancel' => __('Cancel user following request', 'wpdiscuz'),
            'wc_follow_confirm_email_subject' => __('User Following Confirmation', 'wpdiscuz'),
            'wc_follow_confirm_email_message' => __('Hi, <br/> You just started following a new user. You\'ll get email notification once new comment is posted by this user. <br/> Please click on "user following confirmation" link to confirm your request. If you believe this is an error, ignore this message and we\'ll never bother you again. <br/><br/><a href="[POST_URL]">[POST_TITLE]</a><br/><br/><a href="[CONFIRM_URL]">' . __('Confirm Follow', 'wpdiscuz') . '</a><br/><br/><a href="[CANCEL_URL]">' . __('Cancel Follow', 'wpdiscuz') . '</a>', 'wpdiscuz'),
            'wc_follow_email_subject' => __('New Comment', 'wpdiscuz'),
            'wc_follow_email_message' => __('Hi [FOLLOWER_NAME],<br/><br/>new comment have been posted by the user you are following<br/><br/><a href="[COMMENT_URL]">[COMMENT_URL]</a><br/><br/>[COMMENT_CONTENT]<br/><br/><a href="[CANCEL_URL]">' . __('Cancel Follow', 'wpdiscuz') . '</a>', 'wpdiscuz'),
        );
    }

    public function toArray() {
        $options = array(
            'isEnableOnHome' => $this->isEnableOnHome,
            'wc_quick_tags' => $this->isQuickTagsEnabled,
            'wc_comment_list_update_type' => $this->commentListUpdateType,
            'wc_comment_list_update_timer' => $this->commentListUpdateTimer,
            'wc_live_update_guests' => $this->liveUpdateGuests,
            'wc_comment_editable_time' => $this->commentEditableTime,
            'wpdiscuz_redirect_page' => $this->redirectPage,
            'wc_is_guest_can_vote' => $this->isGuestCanVote,
            'isLoadOnlyParentComments' => $this->isLoadOnlyParentComments,
            'commentListLoadType' => $this->commentListLoadType,
            'wc_voting_buttons_show_hide' => $this->votingButtonsShowHide,
            'votingButtonsStyle' => $this->votingButtonsStyle,
            'votingButtonsIcon' => $this->votingButtonsIcon,
            'wc_header_text_show_hide' => $this->headerTextShowHide,
            'storeCommenterData' => $this->storeCommenterData,
            'wc_show_hide_loggedin_username' => $this->showHideLoggedInUsername,
            'hideLoginLinkForGuests' => $this->hideLoginLinkForGuests,
            'hideUserSettingsButton' => $this->hideUserSettingsButton,
            'hideDiscussionStat' => $this->hideDiscussionStat,
            'hideRecentAuthors' => $this->hideRecentAuthors,
            'displayAntispamNote' => $this->displayAntispamNote,
            'wc_author_titles_show_hide' => $this->authorTitlesShowHide,
            'wc_simple_comment_date' => $this->simpleCommentDate,
            'subscriptionType' => $this->subscriptionType,
            'wc_show_hide_reply_checkbox' => $this->showHideReplyCheckbox,
            'isReplyDefaultChecked' => $this->isReplyDefaultChecked,
            'show_sorting_buttons' => $this->showSortingButtons,
            'mostVotedByDefault' => $this->mostVotedByDefault,
            'wc_use_postmatic_for_comment_notification' => $this->usePostmaticForCommentNotification,
            'wc_comment_text_size' => $this->commentTextSize,
            'wc_form_bg_color' => $this->formBGColor,
            'wc_comment_bg_color' => $this->commentBGColor,
            'wc_reply_bg_color' => $this->replyBGColor,
            'wc_comment_username_color' => $this->primaryColor,
            'wc_comment_rating_hover_color' => $this->ratingHoverColor,
            'wc_comment_rating_inactiv_color' => $this->ratingInactivColor,
            'wc_comment_rating_activ_color' => $this->ratingActivColor,
            'wc_blog_roles' => $this->blogRoles,
            'wc_link_button_color' => $this->buttonColor,
            'wc_input_border_color' => $this->inputBorderColor,
            'wc_new_loaded_comment_bg_color' => $this->newLoadedCommentBGColor,
            'disableFontAwesome' => $this->disableFontAwesome,
            'disableTips' => $this->disableTips,
            'disableProfileURLs' => $this->disableProfileURLs,
            'displayRatingOnPost' => $this->displayRatingOnPost,
            'ratingCssOnNoneSingular' => $this->ratingCssOnNoneSingular,
            'wc_custom_css' => $this->customCss,
            'wc_show_plugin_powerid_by' => $this->showPluginPoweredByLink,
            'wc_is_use_po_mo' => $this->isUsePoMo,
            'wc_disable_member_confirm' => $this->disableMemberConfirm,
            'disableGuestsConfirm' => $this->disableGuestsConfirm,
            'wc_comment_text_min_length' => $this->commentTextMinLength,
            'wc_comment_text_max_length' => $this->commentTextMaxLength,
            'commentWordsLimit' => $this->commentReadMoreLimit,
            'showHideCommentLink' => $this->showHideCommentLink,
            'hideCommentDate' => $this->hideCommentDate,
            'enableImageConversion' => $this->enableImageConversion,
            'commentLinkFilter' => $this->commentLinkFilter,
            'isCaptchaInSession' => $this->isCaptchaInSession,
            'isUserByEmail' => $this->isUserByEmail,
            'commenterNameMinLength' => $this->commenterNameMinLength,
            'commenterNameMaxLength' => $this->commenterNameMaxLength,
            'isNotifyOnCommentApprove' => $this->isNotifyOnCommentApprove,
            'isGravatarCacheEnabled' => $this->isGravatarCacheEnabled,
            'gravatarCacheMethod' => $this->gravatarCacheMethod,
            'gravatarCacheTimeout' => $this->gravatarCacheTimeout,
            'theme' => $this->theme,
            'reverseChildren' => $this->reverseChildren,
            'antispamKey' => $this->antispamKey,
            //social  
            'socialLoginAgreementCheckbox' => $this->socialLoginAgreementCheckbox,
            'socialLoginInSecondaryForm' => $this->socialLoginInSecondaryForm,
            // fb
            'enableFbLogin' => $this->enableFbLogin,
            'enableFbShare' => $this->enableFbShare,
            'fbAppID' => $this->fbAppID,
            'fbAppSecret' => $this->fbAppSecret,
            'fbUseOAuth2' => $this->fbUseOAuth2,
            // twitter
            'enableTwitterLogin' => $this->enableTwitterLogin,
            'enableTwitterShare' => $this->enableTwitterShare,
            'twitterAppID' => $this->twitterAppID,
            'twitterAppSecret' => $this->twitterAppSecret,
            // google+
            'enableGoogleLogin' => $this->enableGoogleLogin,
            'enableGoogleShare' => $this->enableGoogleShare,
            'googleAppID' => $this->googleAppID,
            // ok
            'enableOkLogin' => $this->enableOkLogin,
            'enableOkShare' => $this->enableOkShare,
            'okAppID' => $this->okAppID,
            'okAppKey' => $this->okAppKey,
            'okAppSecret' => $this->okAppSecret,
            // vk
            'enableVkLogin' => $this->enableVkLogin,
            'enableVkShare' => $this->enableVkShare,
            'vkAppID' => $this->vkAppID,
            'vkAppSecret' => $this->vkAppSecret,
            'isFollowActive' => $this->isFollowActive,
            'disableFollowConfirmForUsers' => $this->disableFollowConfirmForUsers,
            'enableStickButton' => $this->enableStickButton,
            'enableCloseButton' => $this->enableCloseButton,
            'enableDropAnimation' => $this->enableDropAnimation,
        );
        return $options;
    }

    public function updateOptions() {
        update_option(self::OPTION_SLUG_OPTIONS, serialize($this->toArray()));
    }

    public function addOptions() {
        $options = array(
            'isEnableOnHome' => '1',
            'wc_quick_tags' => '0',
            'wc_comment_list_update_type' => '0',
            'wc_comment_list_update_timer' => '30',
            'wc_live_update_guests' => '1',
            'wc_comment_editable_time' => '900',
            'wpdiscuz_redirect_page' => '0',
            'wc_is_guest_can_vote' => '1',
            'commentsLoadType' => '0',
            'isLoadOnlyParentComments' => '0',
            'commentListLoadType' => '0',
            'wc_voting_buttons_show_hide' => '0',
            'votingButtonsStyle' => '0',
            'votingButtonsIcon' => 'fa-plus|fa-minus',
            'wc_header_text_show_hide' => '0',
            'wc_avatar_show_hide' => '0',
            'wc_is_name_field_required' => '1',
            'wc_is_email_field_required' => '1',
            'storeCommenterData' => '-1',
            'wc_show_hide_loggedin_username' => '1',
            'hideUserSettingsButton' => '0',
            'hideDiscussionStat' => '0',
            'hideRecentAuthors' => '0',
            'displayAntispamNote' => '1',
            'wc_author_titles_show_hide' => '0',
            'wc_simple_comment_date' => '0',
            'show_subscription_bar' => '1',
            'subscriptionType' => '1',
            'show_sorting_buttons' => '1',
            'mostVotedByDefault' => '0',
            'wc_show_hide_reply_checkbox' => '1',
            'isReplyDefaultChecked' => '0',
            'wc_use_postmatic_for_comment_notification' => '0',
            'wc_comment_text_size' => '14px',
            'wc_form_bg_color' => '#F9F9F9',
            'wc_comment_bg_color' => '#FEFEFE',
            'wc_reply_bg_color' => '#F8F8F8',
            'wc_comment_username_color' => '#00B38F',
            'wc_comment_rating_hover_color' => '#FFED85',
            'wc_comment_rating_inactiv_color' => '#DDDDDD',
            'wc_comment_rating_activ_color' => '#FFD700',
            'wc_blog_roles' => $this->blogRoles,
            'wc_link_button_color' => array('primary_button_bg' => '#555555', 'primary_button_color' => '#FFFFFF', 'secondary_button_color' => '#777777', 'secondary_button_border' => '#dddddd', 'vote_up_link_color' => '#999999', 'vote_down_link_color' => '#999999'),
            'wc_input_border_color' => '#D9D9D9',
            'wc_new_loaded_comment_bg_color' => '#FFFAD6',
            'disableFontAwesome' => '0',
            'disableTips' => '0',
            'disableProfileURLs' => '0',
            'displayRatingOnPost' => array('after'),
            'ratingCssOnNoneSingular' => 0,
            'wc_custom_css' => '.comments-area{width:auto;}',
            'wc_show_plugin_powerid_by' => '0',
            'wc_is_use_po_mo' => '0',
            'wc_disable_member_confirm' => '1',
            'disableGuestsConfirm' => '1',
            'wc_comment_text_min_length' => '1',
            'wc_comment_text_max_length' => '',
            'commentWordsLimit' => '100',
            'showHideCommentLink' => '0',
            'hideCommentDate' => '0',
            'enableImageConversion' => '1',
            'commentLinkFilter' => '1',
            'isCaptchaInSession' => '1',
            'isUserByEmail' => '0',
            'commenterNameMinLength' => '3',
            'commenterNameMaxLength' => '50',
            'isNotifyOnCommentApprove' => '1',
            'isGravatarCacheEnabled' => '1',
            'gravatarCacheMethod' => 'cronjob',
            'gravatarCacheTimeout' => '10',
            'hideLoginLinkForGuests' => '1',
            'theme' => 'wpd-default',
            'reverseChildren' => 0,
            'antispamKey' => $this->generateUniqueKey(),
            'wcf_google_map_api_key' => '',
            //social 
            'socialLoginAgreementCheckbox' => '1',
            'socialLoginInSecondaryForm' => '0',
            // fb
            'enableFbLogin' => '0',
            'enableFbShare' => '0',
            'fbAppID' => '',
            'fbAppSecret' => '',
            'fbUseOAuth2' => 0,
            // twitter
            'enableTwitterLogin' => '0',
            'enableTwitterShare' => '1',
            'twitterAppID' => '',
            'twitterAppSecret' => '',
            // google+
            'enableGoogleLogin' => '0',
            'enableGoogleShare' => '1',
            'googleAppID' => '',
            // ok
            'enableOkLogin' => '0',
            'enableOkShare' => '1',
            'okAppID' => '',
            'okAppKey' => '',
            'okAppSecret' => '',
            // vk
            'enableVkLogin' => '0',
            'enableVkShare' => '1',
            'vkAppID' => '',
            'vkAppSecret' => '',
            'isFollowActive' => 1,
            'disableFollowConfirmForUsers' => 1,
            'enableStickButton' => 1,
            'enableCloseButton' => 1,
            'enableDropAnimation' => 1,
        );
        add_option(self::OPTION_SLUG_OPTIONS, serialize($options));
    }

    public function initPhrasesOnLoad() {
        if (!$this->isUsePoMo && $this->dbManager->isPhraseExists('wc_be_the_first_text')) {
            $this->phrases = $this->dbManager->getPhrases();
        } else {
            $this->initPhrases();
        }
    }

    private function initFormRelations() {
        $this->formContentTypeRel = get_option('wpdiscuz_form_content_type_rel', array());
        $this->formPostRel = get_option('wpdiscuz_form_post_rel', array());
    }

    public function isEnabledShare() {
        return ($this->enableFbShare || $this->enableTwitterShare || $this->enableGoogleShare || $this->enableVkShare || $this->enableOkShare);
    }

    public function getOptionsForJs() {
        $js_options = array();
        $js_options['wc_hide_replies_text'] = $this->phrases['wc_hide_replies_text'];
        $js_options['wc_show_replies_text'] = $this->phrases['wc_show_replies_text'];
        $js_options['wc_msg_required_fields'] = $this->phrases['wc_msg_required_fields'];
        $js_options['wc_invalid_field'] = $this->phrases['wc_invalid_field'];
        $js_options['wc_error_empty_text'] = $this->phrases['wc_error_empty_text'];
        $js_options['wc_error_url_text'] = $this->phrases['wc_error_url_text'];
        $js_options['wc_error_email_text'] = $this->phrases['wc_error_email_text'];
        $js_options['wc_invalid_captcha'] = $this->phrases['wc_invalid_captcha'];
        $js_options['wc_login_to_vote'] = $this->phrases['wc_login_to_vote'];
        $js_options['wc_deny_voting_from_same_ip'] = $this->phrases['wc_deny_voting_from_same_ip'];
        $js_options['wc_self_vote'] = $this->phrases['wc_self_vote'];
        $js_options['wc_vote_only_one_time'] = $this->phrases['wc_vote_only_one_time'];
        $js_options['wc_voting_error'] = $this->phrases['wc_voting_error'];
        $js_options['wc_held_for_moderate'] = $this->phrases['wc_held_for_moderate'];
        $js_options['wc_comment_edit_not_possible'] = $this->phrases['wc_comment_edit_not_possible'];
        $js_options['wc_comment_not_updated'] = $this->phrases['wc_comment_not_updated'];
        $js_options['wc_comment_not_edited'] = $this->phrases['wc_comment_not_edited'];
        $js_options['wc_new_comment_button_text'] = $this->phrases['wc_new_comment_button_text'];
        $js_options['wc_new_comments_button_text'] = $this->phrases['wc_new_comments_button_text'];
        $js_options['wc_new_reply_button_text'] = $this->phrases['wc_new_reply_button_text'];
        $js_options['wc_new_replies_button_text'] = $this->phrases['wc_new_replies_button_text'];
        $js_options['wc_msg_input_min_length'] = $this->phrases['wc_msg_input_min_length'];
        $js_options['wc_msg_input_max_length'] = $this->phrases['wc_msg_input_max_length'];
        //<!-- follow phrases
        $js_options['wc_follow_user'] = $this->phrases['wc_follow_user'];
        $js_options['wc_unfollow_user'] = $this->phrases['wc_unfollow_user'];
        $js_options['wc_follow_success'] = $this->phrases['wc_follow_success'];
        $js_options['wc_follow_canceled'] = $this->phrases['wc_follow_canceled'];
        $js_options['wc_follow_email_confirm'] = $this->phrases['wc_follow_email_confirm'];
        $js_options['wc_follow_email_confirm_fail'] = $this->phrases['wc_follow_email_confirm_fail'];
        $js_options['wc_follow_login_to_follow'] = $this->phrases['wc_follow_login_to_follow'];
        $js_options['wc_follow_impossible'] = $this->phrases['wc_follow_impossible'];
        $js_options['wc_follow_not_added'] = $this->phrases['wc_follow_not_added'];
        //follow phrases -->
        $js_options['is_user_logged_in'] = is_user_logged_in();
        $js_options['commentListLoadType'] = $this->commentListLoadType;
        $js_options['commentListUpdateType'] = $this->commentListUpdateType;
        $js_options['commentListUpdateTimer'] = $this->commentListUpdateTimer;
        $js_options['liveUpdateGuests'] = $this->liveUpdateGuests;
        $js_options['wc_comment_bg_color'] = $this->commentBGColor;
        $js_options['wc_reply_bg_color'] = $this->replyBGColor;
        $js_options['wordpress_comment_order'] = $this->wordpressCommentOrder;
        $js_options['commentsVoteOrder'] = $this->showSortingButtons && $this->mostVotedByDefault;
        $js_options['wordpressThreadCommentsDepth'] = $this->wordpressThreadCommentsDepth;
        $js_options['wordpressIsPaginate'] = $this->wordpressIsPaginate;
        $js_options['commentTextMaxLength'] = $this->commentTextMaxLength ? $this->commentTextMaxLength : null;
        $js_options['wordpressIsPaginate'] = $this->wordpressIsPaginate;
        if ($this->storeCommenterData < 0) {
            $js_options['storeCommenterData'] = 100000;
        } else if ($this->storeCommenterData == 0) {
            $js_options['storeCommenterData'] = null;
        } else {
            $js_options['storeCommenterData'] = $this->storeCommenterData;
        }
        if (function_exists('zerospam_get_key')) {
            $js_options['wpdiscuz_zs'] = md5(zerospam_get_key());
        }
        $js_options['isCaptchaInSession'] = (boolean) $this->isCaptchaInSession;
        $js_options['isGoodbyeCaptchaActive'] = (boolean) $this->isGoodbyeCaptchaActive;
        $js_options['socialLoginAgreementCheckbox'] = $this->socialLoginAgreementCheckbox;
        $js_options['enableFbLogin'] = $this->enableFbLogin;
        $js_options['enableFbShare'] = $this->enableFbShare;
        $js_options['facebookAppID'] = $this->fbAppID;
        $js_options['facebookUseOAuth2'] = $this->fbUseOAuth2;
        $js_options['enableGoogleLogin'] = $this->enableGoogleLogin;
        $js_options['googleAppID'] = $this->googleAppID;
        $js_options['cookiehash'] = COOKIEHASH;
        $js_options['isLoadOnlyParentComments'] = $this->isLoadOnlyParentComments;
        $js_options['ahk'] = $this->antispamKey;
        $js_options['enableDropAnimation'] = $this->enableDropAnimation;
        return $js_options;
    }

    private function initGoodbyeCaptchaField() {
        $this->isGoodbyeCaptchaActive = is_callable(array('GdbcWordPressPublicModule', 'isCommentsProtectionActivated')) && GdbcWordPressPublicModule::isCommentsProtectionActivated();
        if ($this->isGoodbyeCaptchaActive) {
            $this->goodbyeCaptchaTocken = GdbcWordPressPublicModule::getInstance()->getTokenFieldHtml();
        }
    }

    public function generateUniqueKey($length = 32) {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-=';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $randomString;
    }

}
