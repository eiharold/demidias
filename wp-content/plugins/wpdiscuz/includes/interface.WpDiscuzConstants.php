<?php

if (!defined('ABSPATH')) {
    exit();
}

interface WpDiscuzConstants {
    /* === OPTIONS SLUGS === */
    const OPTION_SLUG_OPTIONS                         = 'wc_options';
    const OPTION_SLUG_VERSION                         = 'wc_plugin_version';
    const OPTION_SLUG_DEACTIVATION                    = 'wc_deactivation_modal_never_show';
    const OPTION_SLUG_SHOW_DEMO                       = 'wc_show_addons_demo';
    const OPTION_SLUG_HASH_KEY                        = 'wc_hash_key';
    /* === OPTIONS SLUGS === */
    const PAGE_SETTINGS                               = 'wpdiscuz_options_page';
    const PAGE_PHRASES                                = 'wpdiscuz_phrases_page';
    const PAGE_TOOLS                                  = 'wpdiscuz_tools_page';
    const PAGE_ADDONS                                 = 'wpdiscuz_addons_page'; 
    /* === META KEYS === */
    const META_KEY_CHILDREN                           = 'wpdiscuz_child_ids';
    const META_KEY_VOTES                              = 'wpdiscuz_votes';
    /* === SUBSCRIPTION TYPES === */
    const SUBSCRIPTION_POST                           = 'post';
    const SUBSCRIPTION_ALL_COMMENT                    = 'all_comment';
    const SUBSCRIPTION_COMMENT                        = 'comment';
    /* === POST ACTIONS === */
    const ACTION_FORM_NONCE                           = 'wpdiscuz_form_nonce_action';
    const ACTION_CAPTCHA_NONCE                        = 'wpdiscuz_captcha_nonce_action';
    /* === TRANSIENT KEYS === */
    const TRS_POSTS_AUTHORS                           = 'wpdiscuz_posts_authors';
    /* === COOKIES === */
    const COOKIE_LAST_VISIT                           = 'wordpress_last_visit';
    /* === CACHE === */
    const GRAVATARS_CACHE_DIR                         = '/wpdiscuz/cache/gravatars/';
    const GRAVATARS_CACHE_ADD_RECURRENCE              = 3;
    const GRAVATARS_CACHE_ADD_KEY_RECURRENCE          = 'wpdiscuz_cache_add_every_3h';
    const GRAVATARS_CACHE_ADD_ACTION                  = 'wpdiscuz_gravatars_cache_add';    
    const GRAVATARS_CACHE_DELETE_RECURRENCE           = 48;
    const GRAVATARS_CACHE_DELETE_KEY_RECURRENCE       = 'wpdiscuz_cache_delete_every_48h';
    const GRAVATARS_CACHE_DELETE_ACTION               = 'wpdiscuz_gravatars_cache_delete';
    /* === STICKY COMMENTS === */
    const WPDISCUZ_STICKY_COMMENT                     = 'wpdiscuz_sticky';
    /* === TOOLS === */
    const OPTIONS_DIR                                 = '/wpdiscuz/options/';
    const OPTIONS_FILENAME                            = 'wpdiscuz-options';
    /* === STATISTICS === */
    const POSTMETA_STATISTICS                         = '_wpdiscuz_statistics';
    const POSTMETA_THREADS                            = 'threads';
    const POSTMETA_REPLIES                            = 'replies';
    const POSTMETA_FOLLOWERS                          = 'followers';
    const POSTMETA_REACTED                            = 'reacted';
    const POSTMETA_HOTTEST                            = 'hottest';
    const POSTMETA_AUTHORS                            = 'authors';
    const POSTMETA_RECENT_AUTHORS                     = 'recent_authors';
    /* === USER CONTENT === */
    const TRS_USER_HASH                               = 'wpdiscuz_user_hash_';
}
