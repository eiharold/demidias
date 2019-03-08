<?php

/** COMMENTS WALKER */
class WpdiscuzWalker extends Walker_Comment implements WpDiscuzConstants {

    public $tree_type = 'comment';
    public $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');
    private $helper;
    private $helperOptimization;
    private $dbManager;
    private $optionsSerialized;
    private $users;

    public function __construct($helper, $helperOptimization, $dbManager, $optionsSerialized) {
        $this->helper = $helper;
        $this->helperOptimization = $helperOptimization;
        $this->dbManager = $dbManager;
        $this->optionsSerialized = $optionsSerialized;
        $this->users = array();
    }

    /** START_EL */
    public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        // BEGIN
        $currentUser = $args['current_user'];
        $depth = isset($args['addComment']) ? $args['addComment'] : $depth;
        $uniqueId = $comment->comment_ID . '_' . $comment->comment_parent;
        $commentContent = $comment->comment_content;
        $commentWrapperClass = array();
        $isSticky = $comment->comment_type == self::WPDISCUZ_STICKY_COMMENT;
        $isClosed = $comment->comment_karma;
        if ($isSticky) {
            $commentWrapperClass[] = 'wc-sticky-comment';
        }

        if ($isClosed) {
            $commentWrapperClass[] = 'wc-closed-comment';
        }

        $commentContent = apply_filters('wpdiscuz_before_comment_text', $commentContent, $comment);
        if ($this->optionsSerialized->enableImageConversion) {
            $commentContent = $this->helper->makeClickable($commentContent);
        }

        $commentContent = apply_filters('comment_text', $commentContent, $comment, $args);
        $commentReadMoreLimit = $this->optionsSerialized->commentReadMoreLimit;
        if (strstr($commentContent, '[/spoiler]')) {
            $commentReadMoreLimit = 0;
            $commentContent = $this->helper->spoiler($commentContent);
        }
        if ($commentReadMoreLimit && count(explode(' ', strip_tags($commentContent))) > $commentReadMoreLimit) {
            $commentContent = $this->helper->getCommentExcerpt($commentContent, $uniqueId);
        }
        $commentContent .= $comment->comment_approved == 0 ? '<p class="wc_held_for_moderate">' . $this->optionsSerialized->phrases['wc_held_for_moderate'] . '</p>' : '';
        $hideAvatarStyle = '';
        if (!$this->optionsSerialized->wordpressShowAvatars) {
            if ($args['is_rtl']) {
                $hideAvatarStyle = 'style = "margin-right : 0;"';
            } else {
                $hideAvatarStyle = 'style = "margin-left : 0;"';
            }
        }

        if ($this->optionsSerialized->wordpressIsPaginate && $comment->comment_parent) {
            $rootComment = $this->helperOptimization->getCommentRoot($comment->comment_parent);
        }
        if (isset($args['new_loaded_class'])) {
            $commentWrapperClass[] = $args['new_loaded_class'];
            if ($args['isSingle']) {
                $commentWrapperClass[] = 'wpdiscuz_single';
            } else {
                $depth = $this->helperOptimization->getCommentDepth($comment->comment_ID);
            }
        }

        if (!$this->optionsSerialized->wordpressIsPaginate && isset($args[self::COOKIE_LAST_VISIT])) {
            $blogId = WpdiscuzCore::$CURRENT_BLOG_ID;
            $lastVisit = json_decode(stripslashes($args[self::COOKIE_LAST_VISIT]), true);
            $lastVisitForPost = isset($lastVisit[$blogId][$comment->comment_post_ID]) ? $lastVisit[$blogId][$comment->comment_post_ID] : 0;
            if (isset($args['comment_author_email'])) {
                $storedCookieEmail = $args['comment_author_email'];
            } else {
                $storedCookieEmail = isset($_COOKIE['comment_author_email_' . COOKIEHASH]) ? $_COOKIE['comment_author_email_' . COOKIEHASH] : '';
            }

            $commentTime = strtotime($comment->comment_date);
            if ($lastVisitForPost && $commentTime > $lastVisitForPost && $storedCookieEmail != $comment->comment_author_email) {
                $commentWrapperClass[] = 'wc-new-loaded-comment';
            }
        }

        $commentAuthorUrl = ('http://' == $comment->comment_author_url) ? '' : $comment->comment_author_url;
        $commentAuthorUrl = esc_url($commentAuthorUrl, array('http', 'https'));
        $commentAuthorUrl = apply_filters('get_comment_author_url', $commentAuthorUrl, $comment->comment_ID, $comment);

        $userKey = $comment->user_id . '_' . $comment->comment_author_email;
        if (isset($this->users[$userKey])) {
            $user = $this->users[$userKey];
        } else {
            if ($this->optionsSerialized->isUserByEmail) {
                $user = get_user_by('email', $comment->comment_author_email);
            } else {
                $user = $comment->user_id ? get_user_by('id', $comment->user_id) : '';
            }
            $this->users[$userKey] = $user;
        }

        if ($user) {
            $authorName = $user->display_name ? $user->display_name : $comment->comment_author;
            $authorAvatarField = $user->ID;
            $gravatarUserId = $user->ID;
            $gravatarUserEmail = $user->user_email;
            $profileUrl = in_array($user->ID, $args['posts_authors']) ? get_author_posts_url($user->ID) : '';
            $commentAuthorUrl = $commentAuthorUrl ? $commentAuthorUrl : $user->user_url;
            if ($user->ID == $args['post_author']) {
                $authorClass = 'wc-blog-user wc-blog-post_author';
                $author_title = $this->optionsSerialized->phrases['wc_blog_role_post_author'];
            } else {
                $authorClass = 'wc-blog-guest';
                $author_title = $this->optionsSerialized->phrases['wc_blog_role_guest'];
                $blogRoles = $this->optionsSerialized->blogRoles;
                if ($blogRoles) {
                    if ($user->roles && is_array($user->roles)) {
                        foreach ($user->roles as $role) {
                            if (array_key_exists($role, $blogRoles)) {
                                $authorClass = 'wc-blog-user wc-blog-' . $role;
                                $rolePhrase = isset($this->optionsSerialized->phrases['wc_blog_role_' . $role]) ? $this->optionsSerialized->phrases['wc_blog_role_' . $role] : '';
                                $author_title = apply_filters('wpdiscuz_user_label', $rolePhrase, $user);
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            $authorName = $comment->comment_author ? $comment->comment_author : $this->optionsSerialized->phrases['wc_anonymous'];
            $authorAvatarField = $comment->comment_author_email;
            $gravatarUserId = 0;
            $gravatarUserEmail = $comment->comment_author_email;
            $profileUrl = '';
            $authorClass = 'wc-blog-guest';
            $author_title = $this->optionsSerialized->phrases['wc_blog_role_guest'];
        }

        $postedDate = '';
        if (!$this->optionsSerialized->hideCommentDate) {
            if ($this->optionsSerialized->simpleCommentDate) {
                $dateFormat = $this->optionsSerialized->wordpressDateFormat;
                $timeFormat = $this->optionsSerialized->wordpressTimeFormat;
                $postedDate = get_comment_date($dateFormat . ' ' . $timeFormat, $comment->comment_ID);
            } else {
                $postedDate = $this->helper->dateDiff($comment->comment_date_gmt);
            }
        }

        $replyText = $this->optionsSerialized->phrases['wc_reply_text'];
        $shareText = $this->optionsSerialized->phrases['wc_share_text'];
        if (isset($rootComment) && $rootComment->comment_approved != 1) {
            $commentWrapperClass[] = 'wc-comment';
        } else {
            $commentWrapperClass[] = ($comment->comment_parent && $this->optionsSerialized->wordpressThreadComments) ? 'wc-comment wc-reply' : 'wc-comment';
        }

        $authorName = apply_filters('wpdiscuz_comment_author', $authorName, $comment);
        $profileUrl = apply_filters('wpdiscuz_profile_url', $profileUrl, $user);
        $authorAvatarField = apply_filters('wpdiscuz_author_avatar_field', $authorAvatarField, $comment, $user, $profileUrl);

        $gravatarSize = apply_filters('wpdiscuz_gravatar_size', 64);
        $gravatarArgs = array(
            'wpdiscuz_gravatar_field' => $authorAvatarField,
            'wpdiscuz_gravatar_size' => $gravatarSize,
            'wpdiscuz_gravatar_user_id' => $gravatarUserId,
            'wpdiscuz_gravatar_user_email' => $gravatarUserEmail,
        );
        $authorAvatar = $this->optionsSerialized->wordpressShowAvatars ? get_avatar($authorAvatarField, $gravatarSize, '', $authorName, $gravatarArgs) : '';
        $trackOrPingback = $comment->comment_type == 'pingback' || $comment->comment_type == 'trackback' ? true : false;
        if ($trackOrPingback) {
            $authorAvatar = '<img class="avatar avatar-' . $gravatarSize . ' photo" width="' . $gravatarSize . '" height="' . $gravatarSize . '" src="' . $args['avatar_trackback'] . '" alt="trackback">';
        }

        if ($profileUrl && !$this->optionsSerialized->disableProfileURLs) {
            $attributes = apply_filters('wpdiscuz_avatar_link_attributes', array('href' => $profileUrl, 'target' => '_blank'));
            if ($attributes && is_array($attributes)) {
                $attributesHtml = "";
                foreach ($attributes as $attribute => $value) {
                    $attributesHtml .= "$attribute='{$value}' ";
                }
                $attributesHtml = trim($attributesHtml);
                $commentAuthorAvatar = "<a $attributesHtml>$authorAvatar</a>";
            } else {
                $commentAuthorAvatar = "<a href='$profileUrl' target='_blank'>$authorAvatar</a>";
            }
        } else {
            $commentAuthorAvatar = $authorAvatar;
        }

        if (!$this->optionsSerialized->disableProfileURLs) {
            if ($commentAuthorUrl) {
                $attributes = apply_filters('wpdiscuz_author_link_attributes', array('href' => $commentAuthorUrl, 'rel' => 'nofollow', 'target' => '_blank'));
                if ($attributes && is_array($attributes)) {
                    $attributesHtml = "";
                    foreach ($attributes as $attribute => $value) {
                        $attributesHtml .= "$attribute='{$value}' ";
                    }
                    $attributesHtml = trim($attributesHtml);
                    $authorName = "<a $attributesHtml>$authorName</a>";
                } else {
                    $authorName = "<a rel='nofollow' href='$commentAuthorUrl' target='_blank'>$authorName</a>";
                }
            } else if ($profileUrl) {
                $attributes = apply_filters('wpdiscuz_author_link_attributes', array('href' => $profileUrl, 'rel' => 'nofollow', 'target' => '_blank'));

                if ($attributes && is_array($attributes)) {
                    $attributesHtml = "";
                    foreach ($attributes as $attribute => $value) {
                        $attributesHtml .= "$attribute='{$value}' ";
                    }
                    $attributesHtml = trim($attributesHtml);
                    $authorName = "<a $attributesHtml>$authorName</a>";
                } else {
                    $authorName = "<a rel='nofollow' href='$profileUrl' target='_blank'>$authorName</a>";
                }
            }
        }

        if (!$this->optionsSerialized->isGuestCanVote && !$currentUser->ID) {
            $voteClass = '';
            $voteTitleText = $this->optionsSerialized->phrases['wc_login_to_vote'];
            $voteUp = $voteTitleText;
            $voteDown = $voteTitleText;
        } else {
            $voteClass = ' wc_vote wc_not_clicked';
            $voteUp = $this->optionsSerialized->phrases['wc_vote_up'];
            $voteDown = $this->optionsSerialized->phrases['wc_vote_down'];
        }

        $hasChildren = isset($args['wpdiscuz_root_comment_' . $comment->comment_ID]) ? $args['wpdiscuz_root_comment_' . $comment->comment_ID] : '';
        if ($hasChildren) {
            $commentWrapperClass[] = $hasChildren;
        }
        $commentWrapperClass[] = $authorClass;
        $commentWrapperClass[] = 'wc_comment_level-' . $depth;
        $commentWrapperClass = apply_filters('wpdiscuz_comment_wrap_classes', $commentWrapperClass, $comment);
        $wrapperClass = implode(' ', $commentWrapperClass);

        $commentContentClass = '';
        // begin printing comment template
        $output .= '<div id="wc-comm-' . $uniqueId . '" class="' . $wrapperClass . '">';
        if ($this->optionsSerialized->wordpressShowAvatars) {
            $commentLeftClass = apply_filters('wpdiscuz_comment_left_class', '');
            $output .= '<div class="wc-comment-left ' . $commentLeftClass . '"><div class="wpd-xborder"></div>' . $commentAuthorAvatar;
            if (!$this->optionsSerialized->authorTitlesShowHide && !$trackOrPingback) {
                $author_title = apply_filters('wpdiscuz_author_title', $author_title, $comment);
                $output .= '<div class="' . $authorClass . ' wc-comment-label">' . '<span>' . $author_title . '</span>' . '</div>';
            }
            $afterLabelHtml = apply_filters('wpdiscuz_after_label', $afterLabelHtml = '', $comment);
            $output .= $afterLabelHtml;
            $output .= '</div>';
        }

        $commentLink = get_comment_link($comment);
        $output .= '<div id="comment-' . $comment->comment_ID . '" class="wc-comment-right ' . $commentContentClass . '" ' . $hideAvatarStyle . '>';
        $output .= '<div class="wc-comment-header">';
        $uNameClasses = apply_filters('wpdiscuz_username_classes', '');
        $afterCommentAuthorName = apply_filters('wpdiscuz_after_comment_author', '', $comment, $user);

        $output .= '<div class="wc-comment-author ' . $uNameClasses . '">' . $authorName . $afterCommentAuthorName . '</div>';
        if ($this->optionsSerialized->isFollowActive && $args['is_user_logged_in'] && (isset($args['current_user_email'])) && $args['current_user_email'] && $args['current_user_email'] != $comment->comment_author_email) {
            if (isset($args['user_follows']) && is_array($args['user_follows']) && in_array($comment->comment_author_email, $args['user_follows'])) {
                $followClass = 'wc-unfollow wc-follow-active';
                $followTip = $this->optionsSerialized->phrases['wc_unfollow_user'];
            } else {
                $followClass = 'wc-follow';
                $followTip = $this->optionsSerialized->phrases['wc_follow_user'];
            }
            $output .= '<div class="wc-follow-link wpd-tooltip-right wc_not_clicked ' . $followClass . '">';
            $output .= '<i class="fas fa-rss" aria-hidden="true"></i>';
            $output .= '<wpdtip>' . $followTip . '</wpdtip>';
            $output .= '</div>';
        }

        $output .= '<div class="wc-comment-link">';
        if ($isSticky) {
            $output .= '<i class="fas fa-thumbtack wpd-sticky" aria-hidden="true" title="' . $this->optionsSerialized->phrases['wc_sticky_comment_icon_title'] . '"></i>';
        }

        if ($isClosed) {
            $output .= '<i class="fas fa-lock wpd-closed" aria-hidden="true" title="' . $this->optionsSerialized->phrases['wc_closed_comment_icon_title'] . '"></i>';
        }

        $output .= apply_filters('wpdiscuz_comment_type_icon', '', $comment, $user, $currentUser);

        if ($this->optionsSerialized->isEnabledShare()) {
            $output .= '<div class="wc-share-link wpf-cta wpd-tooltip-right"><i class="fas fa-share-alt" aria-hidden="true" title="' . esc_attr($shareText) . '" ></i>';
            $commentLinkLength = strlen($commentLink);
            if ($commentLinkLength < 110) {
                $twitt_content = mb_substr(esc_attr(strip_tags($commentContent)), 0, 135 - $commentLinkLength) . '... ';
            } else {
                $twitt_content = '';
            }
            $postLink = get_permalink($comment->comment_post_ID);
            $twitt_content = urlencode($twitt_content);
            $twCommentLink = urlencode($commentLink);
            $output .= '<wpdtip>';
            $output .= ( $this->optionsSerialized->enableFbShare && $this->optionsSerialized->fbAppID) ? '<span class="wc_fb"><i class="fab fa-facebook-f wpf-cta" aria-hidden="true" title="' . $this->optionsSerialized->phrases['wc_share_facebook'] . '"></i></span>' : '';
            $output .= $this->optionsSerialized->enableTwitterShare ? '<a class="wc_tw" target="_blank" href="https://twitter.com/intent/tweet?text=' . $twitt_content . '&url=' . $twCommentLink . '" title="' . $this->optionsSerialized->phrases['wc_share_twitter'] . '"><i class="fab fa-twitter wpf-cta" aria-hidden="true"></i></a>' : '';
            $output .= $this->optionsSerialized->enableGoogleShare ? '<a class="wc_go" target="_blank" href="https://plus.google.com/share?url=' . $postLink . '" title="' . $this->optionsSerialized->phrases['wc_share_google'] . '"><i class="fab fa-google wpf-cta" aria-hidden="true"></i></a>' : '';
            $output .= $this->optionsSerialized->enableVkShare ? '<a class="wc_vk" target="_blank" href="http://vk.com/share.php?url=' . $postLink . '" title="' . $this->optionsSerialized->phrases['wc_share_vk'] . '"><i class="fab fa-vk wpf-cta" aria-hidden="true"></i></a>' : '';
            $output .= $this->optionsSerialized->enableOkShare ? '<a class="wc_ok" target="_blank" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' . $postLink . '" title=""><i class="fab fa-odnoklassniki wpf-cta" aria-hidden="true"></i></a>' : '';
            $output .= '</wpdtip></div>';
        }

        $output = apply_filters('wpdiscuz_before_comment_link', $output, $comment, $user, $currentUser);

        if (!$this->optionsSerialized->showHideCommentLink) {
            $commentLinkImg = '<span class="wc-comment-img-link-wrap"><i class="fas fa-link wc-comment-img-link wpf-cta" aria-hidden="true"/></i><span><input type="text" class="wc-comment-link-input" value="' . $commentLink . '" /></span></span>';
            $output .= apply_filters('wpdiscuz_comment_link_img', $commentLinkImg, $comment);
        }

        $output = apply_filters('wpdiscuz_after_comment_link', $output, $comment, $user, $currentUser);

        $output .= '</div>';
        $output .= '<div class="wpdiscuz_clear"></div>';
        $output .= '</div>';

        $output .= apply_filters('wpdiscuz_comment_text', '<div class="wc-comment-text">' . $commentContent . '</div>', $comment, $args);
        $output = apply_filters('wpdiscuz_after_comment_text', $output, $comment);
        if (isset($args['comment_status']) && is_array($args['comment_status']) && in_array($comment->comment_approved, $args['comment_status'])) {
            $output .= '<div class="wc-comment-footer">';
            $output .= '<div class="wc-footer-left">';
            if (!$this->optionsSerialized->votingButtonsShowHide) {
                if ($this->optionsSerialized->votingButtonsStyle) {
                    $votesArr = $this->dbManager->getVotes($comment->comment_ID);
                    if ($votesArr && count($votesArr) == 1) {
                        $like = 0;
                        $dislike = 0;
                    } else {
                        $like = isset($votesArr[0]) ? intval($votesArr[0]) : 0;
                        $dislike = isset($votesArr[1]) ? intval($votesArr[1]) : 0;
                    }
                    $output .= '<span class="wc-vote-link wc-up wc-separate ' . $voteClass . '">';
                    $voteFaUpImg = '<i class="fas ' . $args['voting_icons']['like'] . ' wc-vote-img-up"></i><span>' . $voteUp . '</span>';
                    $output .= apply_filters('wpdiscuz_vote_up_icon', $voteFaUpImg, $comment, $currentUser);
                    $output .= '</span>';
                    $output .= '<span class="wc-vote-result wc-vote-result-like' . (($like) ? ' wc-positive' : '') . '">' . $like . '</span>';
                    $output .= '<span class="wc-vote-result wc-vote-result-dislike' . (($dislike) ? ' wc-negative' : '') . '">' . $dislike . '</span>';
                    $output .= '<span class="wc-vote-link wc-down wc-separate' . $voteClass . '">';
                    $voteFaDownImg = '<i class="fas ' . $args['voting_icons']['dislike'] . ' wc-vote-img-down"></i><span>' . $voteDown . '</span>';
                    $output .= apply_filters('wpdiscuz_vote_down_icon', $voteFaDownImg, $comment, $currentUser);
                    $output .= '</span>';
                    $output = apply_filters('wpdiscuz_voters', $output, $uniqueId, $comment, $user, $currentUser);
                } else {
                    $voteCount = get_comment_meta($comment->comment_ID, WpdiscuzCore::META_KEY_VOTES, true);
                    $output = apply_filters('wpdiscuz_voters', $output, $uniqueId, $comment, $user, $currentUser);
                    $output .= '<span class="wc-vote-link wc-up ' . $voteClass . '">';
                    $voteFaUpImg = '<i class="fas ' . $args['voting_icons']['like'] . ' wc-vote-img-up"></i><span>' . $voteUp . '</span>';
                    $output .= apply_filters('wpdiscuz_vote_up_icon', $voteFaUpImg, $comment, $currentUser);
                    $output .= '</span>';
                    $output .= '<span class="wc-vote-result">' . intval($voteCount) . '</span>';
                    $output .= '<span class="wc-vote-link wc-down ' . $voteClass . '">';
                    $voteFaDownImg = '<i class="fas ' . $args['voting_icons']['dislike'] . ' wc-vote-img-down"></i><span>' . $voteDown . '</span>';
                    $output .= apply_filters('wpdiscuz_vote_down_icon', $voteFaDownImg, $comment, $currentUser);
                    $output .= '</span>&nbsp;';
                }
            }

            if (!$isClosed && isset($args['comments_open']) && $args['comments_open'] &&
                    $this->optionsSerialized->wordpressThreadComments &&
                    ((isset($args['can_user_comment']) && $args['can_user_comment']) ||
                    (isset($args['high_level_user']) && $args['high_level_user']))
            ) {
                $output .= '<span class="wc-reply-button wc-cta-button" title="' . $replyText . '">' . '<i class="far fa-comments" aria-hidden="true"></i> ' . $replyText . '</span>';
            }


            if (!$isClosed && ((isset($args['high_level_user']) && $args['high_level_user']) || ($this->helper->isCommentEditable($comment) && $this->helper->canUserEditComment($comment, $currentUser, $args)) )) {
                $output .= '<span class="wc_editable_comment wc-cta-button"><i class="fas fa-pencil-alt" aria-hidden="true"></i> ' . $this->optionsSerialized->phrases['wc_edit_text'] . '</span>';
                $output .= '<span class="wc_cancel_edit wc-cta-button-x"><i class="fas fa-ban" aria-hidden="true"></i> ' . $this->optionsSerialized->phrases['wc_comment_edit_cancel_button'] . '</span>';
            }

            $output = apply_filters('wpdiscuz_comment_buttons', $output, $comment, $user, $currentUser);

            if (!$comment->comment_parent &&
                    ((isset($args['high_level_user']) && $args['high_level_user']) ||
                    (isset($args['can_stick_or_close']) && $args['can_stick_or_close']))) {
                if ($this->optionsSerialized->enableStickButton) {
                    $stickText = $isSticky ? $this->optionsSerialized->phrases['wc_unstick_comment'] : $this->optionsSerialized->phrases['wc_stick_comment'];
                    $output .= '<span class="wc_stick_btn wc-cta-button"><i class="fas fa-thumbtack"></i><span class="wc_stick_text">' . $stickText . '</span></span>';
                }
                if ($this->optionsSerialized->enableCloseButton) {
                    $closeText = $isClosed ? $this->optionsSerialized->phrases['wc_open_comment'] : $this->optionsSerialized->phrases['wc_close_comment'];
                    $output .= '<span class="wc_close_btn wc-cta-button"><i class="far fa-comments"></i><span class="wc_close_text">' . $closeText . '</span></span>';
                }
            }
            $output .= '</div>';
            $output .= '<div class="wc-footer-right">';

            if (!$this->optionsSerialized->hideCommentDate) {
                $output .= '<div class="wc-comment-date"><i class="far fa-clock" aria-hidden="true"></i>' . $postedDate . '</div>';
            }
            if ($depth < $this->optionsSerialized->wordpressThreadCommentsDepth && $this->optionsSerialized->wordpressThreadComments) {
                $chevron = '';
                $output .= '<div class="wc-toggle">';
                if ($hasChildren) {
                    $countChildren = isset($args['wpdiscuz_child_count_' . $comment->comment_ID]) ? $args['wpdiscuz_child_count_' . $comment->comment_ID] : 0;
                    $hideChildCountClass = isset($args['wpdiscuz_hide_child_count_' . $comment->comment_ID]) ? $args['wpdiscuz_hide_child_count_' . $comment->comment_ID] : '';
                    if ($countChildren) {
                        $chevron = '<a href="#" title="' . $this->optionsSerialized->phrases['wc_show_replies_text'] . '">';
                        $chevron .= '<span class="wcsep">|</span> <span class="wpdiscuz-children ' . $hideChildCountClass . '"><span class="wpdiscuz-children-button-text">' . $this->optionsSerialized->phrases['wc_show_replies_text'] . '</span> (<span class="wpdiscuz-children-count">' . $countChildren . '</span>)</span> ';
                        $chevron .= '<i class="fas fa-chevron-down wpdiscuz-show-replies"></i>';
                        $chevron .= '</a>';
                    } else {
                        $chevron = '<i class="fas fa-chevron-up" title="' . $this->optionsSerialized->phrases['wc_hide_replies_text'] . '"></i>';
                    }
                } else {
                    $commentChildren = $comment->get_children();
                    $chevron = $commentChildren ? '<i class="fas fa-chevron-up" title="' . $this->optionsSerialized->phrases['wc_hide_replies_text'] . '"></i>' : '';
                }
                $output .= $chevron;
                $output .= '</div>';
            }
            $output .= '</div>';
            $output .= '<div class="wpdiscuz_clear"></div>';
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '<div class="wpdiscuz-comment-message"></div>';
        $output .= '<div id="wpdiscuz_form_anchor-' . $uniqueId . '"  style="clear:both"></div>';
        $output = apply_filters('wpdiscuz_comment_end', $output, $comment, $depth, $args);
    }

    public function end_el(&$output, $comment, $depth = 0, $args = array()) {
        $output = apply_filters('wpdiscuz_thread_end', $output, $comment, $depth, $args);
        $output .= '</div>';
        return $output;
    }

}
