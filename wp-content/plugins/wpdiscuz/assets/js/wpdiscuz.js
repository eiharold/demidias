;
jQuery(document).ready(function ($) {
    $('body').addClass('wpdiscuz_' + wpdiscuzAjaxObj.wpdiscuz_options.version);
    var isUserLoggedIn = wpdiscuzAjaxObj.wpdiscuz_options.is_user_logged_in;
    var isShowCaptchaForGuests = wpdiscuzAjaxObj.wpdiscuz_options.wc_captcha_show_for_guest == 1 && !isUserLoggedIn;
    var isShowCaptchaForMembers = wpdiscuzAjaxObj.wpdiscuz_options.wc_captcha_show_for_members == 1 && isUserLoggedIn;
    var isCaptchaInSession = wpdiscuzAjaxObj.wpdiscuz_options.isCaptchaInSession;
    var wpdiscuzRecaptcha = wpdiscuzAjaxObj.wpdiscuz_options.wpDiscuzReCaptcha;
    var isGoodbyeCaptchaActive = wpdiscuzAjaxObj.wpdiscuz_options.isGoodbyeCaptchaActive;
    var commentListLoadType = wpdiscuzAjaxObj.wpdiscuz_options.commentListLoadType;
    var wordpressIsPaginate = wpdiscuzAjaxObj.wpdiscuz_options.wordpressIsPaginate;
    var wpdiscuzPostId = wpdiscuzAjaxObj.wpdiscuz_options.wc_post_id;
    var commentListUpdateType = wpdiscuzAjaxObj.wpdiscuz_options.commentListUpdateType;
    var commentListUpdateTimer = wpdiscuzAjaxObj.wpdiscuz_options.commentListUpdateTimer;
    var disableGuestsLiveUpdate = wpdiscuzAjaxObj.wpdiscuz_options.liveUpdateGuests;
    var loadLastCommentId = wpdiscuzAjaxObj.wpdiscuz_options.loadLastCommentId;
    var wpdiscuzCommentOrder = wpdiscuzAjaxObj.wpdiscuz_options.wordpress_comment_order;
    var commentsVoteOrder = wpdiscuzAjaxObj.wpdiscuz_options.commentsVoteOrder;
    var storeCommenterData = wpdiscuzAjaxObj.wpdiscuz_options.storeCommenterData;
    var wpdiscuzLoadCount = 1;
    var wpdiscuzCommentOrderBy = 'comment_date_gmt';
    var wpdiscuzReplyArray = [];
    var wpdiscuzCommentArray = [];
    var wpdiscuzUploader = wpdiscuzAjaxObj.wpdiscuz_options.uploader;
    var commentTextMaxLength = wpdiscuzAjaxObj.wpdiscuz_options.commentTextMaxLength;
    var wpdGoogleRecaptchaValid = true;
    var wpdiscuzReplyButton = '';
    var isCookiesEnabled = wpdiscuzAjaxObj.wpdiscuz_options.isCookiesEnabled;
    var wpdCookiesConsent = true;
    var wpdiscuzCookiehash = wpdiscuzAjaxObj.wpdiscuz_options.cookiehash;
    var isLoadOnlyParentComments = wpdiscuzAjaxObj.wpdiscuz_options.isLoadOnlyParentComments;
    var enableDropAnimation = wpdiscuzAjaxObj.wpdiscuz_options.enableDropAnimation ? 500 : 0;
    var wpdiscuzAgreementFields = [];
    loginButtonsClone();

    if (!wpdiscuzAjaxObj.wpdiscuz_options.wordpressIsPaginate && isCookiesEnabled) {
        var wpdiscuzLastVisitKey = wpdiscuzAjaxObj.wpdiscuz_options.lastVisitKey;
        var wpdiscuzLastVisit = wpdiscuzAjaxObj.wpdiscuz_options.lastVisitCookie;
        var wpdiscuzLastVisitExpires = wpdiscuzAjaxObj.wpdiscuz_options.lastVisitExpires;
        Cookies.set(wpdiscuzLastVisitKey, (JSON.stringify(wpdiscuzLastVisit)), {expires: wpdiscuzLastVisitExpires, path: window.location});
    }

    if (commentsVoteOrder) {
        $('.wpdiscuz-vote-sort-up').addClass('wpdiscuz-sort-button-active');
        wpdiscuzCommentOrderBy = 'by_vote';
    } else {
        $('.wpdiscuz-date-sort-' + wpdiscuzCommentOrder).addClass('wpdiscuz-sort-button-active');
    }
    $('#wc_unsubscribe_message, #wc_delete_content_message, #wc_follow_message').delay(3000).fadeOut(1500, function () {
        $(this).remove();
        location.href = location.href.substring(0, location.href.indexOf('wpdiscuzUrlAnchor') - 1);
    });

    if ($('.wc_main_comm_form').length) {
        //wpdiscuzReplaceValidationUI($('.wc_main_comm_form')[0]);
    }
    $(document).delegate('.wc-reply-button', 'click', function () {
        wpdiscuzReplyButton = $(this);
        if ($(this).hasClass('wpdiscuz-clonned')) {
            $('#wc-secondary-form-wrapper-' + getUniqueID($(this), 0)).slideToggle(enableDropAnimation);
        } else {
            cloneSecondaryForm($(this));
        }
        $(this).toggleClass('wc-cta-active');
    });

    $(document).delegate('.wc-comment-img-link', 'click', function () {
        $(this).parents('.wc-comment-img-link-wrap').find('span').toggleClass('wc-comment-img-link-show');
    });

    $(document).delegate('textarea.wc_comment', 'focus', function () {
        var parent = $(this).parents('.wc-form-wrapper');
        $('.commentTextMaxLength', parent).show();
        $('.wc-form-footer', parent).slideDown(enableDropAnimation);
    });

    $(document).delegate('#wpcomm textarea', 'focus', function () {
        if (!($(this).next('.autogrow-textarea-mirror').length)) {
            $(this).autoGrow();
        }
    });

    $(document).delegate('textarea.wc_comment', 'blur', function () {
        var parent = $(this).parents('.wc-form-wrapper');
        $('.commentTextMaxLength', parent).hide();
    });

    $(document).delegate('textarea.wc_comment', 'keyup', function () {
        setTextareaCharCount($(this), commentTextMaxLength);
    });

    $.each($('textarea.wc_comment'), function () {
        setTextareaCharCount($(this), commentTextMaxLength);
    });

    $(document).delegate('.wpdiscuz-nofollow,.wc_captcha_refresh_img,.wc-toggle,.wc-load-more-link', 'click', function (e) {
        e.preventDefault();
    });

    $(document).delegate('.wc-toggle', 'click', function (e) {
        var uniqueID = getUniqueID($(this), 0);
        var toggle = $(this);
        var icon = $('.fas', toggle);
        if (icon.hasClass('wpdiscuz-show-replies') && isLoadOnlyParentComments) {
            wpdiscuzShowReplies(uniqueID);
        } else {
            $('#wc-comm-' + uniqueID + '> .wc-reply').slideToggle(700, function () {
                if ($(this).is(':hidden')) {
                    icon.removeClass('fa-chevron-up');
                    icon.addClass('fa-chevron-down');
                    icon.attr('title', wpdiscuzAjaxObj.wpdiscuz_options.wc_show_replies_text);
                    $('.wpdiscuz-children-button-text', toggle).text(wpdiscuzAjaxObj.wpdiscuz_options.wc_show_replies_text);
                } else {
                    icon.removeClass('fa-chevron-down');
                    icon.addClass('fa-chevron-up');
                    icon.attr('title', wpdiscuzAjaxObj.wpdiscuz_options.wc_hide_replies_text);
                    $('.wpdiscuz-children-button-text', toggle).text(wpdiscuzAjaxObj.wpdiscuz_options.wc_hide_replies_text);
                }
            });
            $('.wpdiscuz-children', toggle).toggleClass('wpdiscuz-hidden');
            if ($('.wpdiscuz-children-count', toggle).length) {
                var replies = $('#wc-comm-' + uniqueID + ' .wc-reply');
                $('.wpdiscuz-children-count', toggle).html(replies.length);
            }
        }
    });

    $(document).delegate('.wc-new-loaded-comment', 'mouseenter', function () {
        if ($(this).hasClass('wc-reply')) {
            $('>.wc-comment-right', this).css('backgroundColor', wpdiscuzAjaxObj.wpdiscuz_options.wc_reply_bg_color);
        } else {
            $('>.wc-comment-right', this).css('backgroundColor', wpdiscuzAjaxObj.wpdiscuz_options.wc_comment_bg_color);
        }
    });

    $(document).delegate('.wpdiscuz-sbs-wrap', 'click', function () {
        $('.wpdiscuz-subscribe-bar').slideToggle(enableDropAnimation);
    });
    //============================== CAPTCHA ============================== //
    $(document).delegate('.wc_captcha_refresh_img', 'click', function (e) {
        e.preventDefault();
        changeCaptchaImage($(this));
    });
    function changeCaptchaImage(reloadImage) {
        if (!wpdiscuzRecaptcha && !isGoodbyeCaptchaActive && (isShowCaptchaForGuests || isShowCaptchaForMembers)) {
            var form = reloadImage.parents('.wc-form-wrapper');
            var keyField = $('.wpdiscuz-cnonce', form);
            if (isCaptchaInSession) {
                var uuId = getUUID();
                var captchaImg = $(reloadImage).prev().children('.wc_captcha_img');
                var src = captchaImg.attr('src');
                var fileUrl = src.substring(0, src.indexOf('=') + 1);
                captchaImg.attr('src', fileUrl + uuId + '&r=' + Math.random());
                keyField.attr('id', uuId);
                keyField.attr('value', uuId);
            } else {
                var data = new FormData();
                data.append('action', 'generateCaptcha');
                var isMain = form.hasClass('wc-secondary-form-wrapper') ? 0 : 1;
                var uniqueId = getUniqueID(reloadImage, isMain);
                data.append('wpdiscuz_unique_id', uniqueId);
                var ajaxObject = getAjaxObj(true, data);
                ajaxObject.done(function (response) {
                    try {
                        var obj = $.parseJSON(response);
                        if (obj.code == 1) {
                            var captchaImg = $(reloadImage).prev().children('.wc_captcha_img');
                            var src = captchaImg.attr('src');
                            var lastSlashIndex = src.lastIndexOf('/') + 1;
                            var newSrc = src.substring(0, lastSlashIndex) + obj.message;
                            captchaImg.attr('src', newSrc);
                            keyField.attr('id', obj.key);
                            keyField.attr('value', obj.key);
                        }
                    } catch (e) {
                        console.log(e);
                    }
                    $('.wpdiscuz-loading-bar').fadeOut(250);
                });
            }
        }
    }

    function getUUID() {
        var chars = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var uuId = 'c';
        for (i = 0; i < 13; i++) {
            uuId += chars[Math.floor(Math.random() * (chars.length - 1) + 1)];
        }
        return uuId;
    }
//============================== CAPTCHA ============================== //
//============================== ADD COMMENT FUNCTION ============================== // 

    $(document).delegate('.wc_comm_submit.wc_not_clicked', 'click', function () {
        var currentSubmitBtn = $(this);
        var depth = 1;
        var wcForm = $(this).parents('form');
        if (!wcForm.hasClass('wc_main_comm_form')) {
            depth = getCommentDepth($(this).parents('.wc-comment'));
        }

        wpdGoogleRecaptchaValid = true;
        wpdValidateFieldRequired(wcForm);
        wcForm.submit(function (event) {
            event.preventDefault();
        });
        if (wcForm[0].checkValidity() && wpdGoogleRecaptchaValid) {
            addAgreementInCookie(wcForm);
            $(currentSubmitBtn).removeClass('wc_not_clicked');
            var data = new FormData();
            data.append('action', 'addComment');
            data.append('ahk', wpdiscuzAjaxObj.wpdiscuz_options.ahk);
            var inputs = $(":input", wcForm);
            inputs.each(function () {
                if (this.name != '' && this.type != 'checkbox' && this.type != 'radio') {
                    data.append(this.name + '', $(this).val());
                }
                if (this.type == 'checkbox' || this.type == 'radio') {
                    if ($(this).is(':checked')) {
                        data.append(this.name + '', $(this).val());
                    }
                }
            });

            data.append('wc_comment_depth', depth);

            if (wpdiscuzUploader == 1) {
                var images = $(wcForm).find('input.wmu-image');
                var videos = $(wcForm).find('input.wmu-video');
                var files = $(wcForm).find('input.wmu-file');
                if (images.length > 0) {
                    $.each($(images), function (i, imageFile) {
                        if (imageFile.files.length > 0) {
                            $.each(imageFile.files, function (j, imageObj) {
                                data.append('wmu_images[' + i + ']', imageObj);
                            });
                        }
                    });
                }

                if (videos.length > 0) {
                    $.each($(videos), function (i, videoFile) {
                        if (videoFile.files.length > 0) {
                            $.each(videoFile.files, function (j, videoObj) {
                                data.append('wmu_videos[' + i + ']', videoObj);
                            });
                        }
                    });
                }

                if (files.length > 0) {
                    $.each($(files), function (i, file) {
                        if (file.files.length > 0) {
                            $.each(file.files, function (j, fileObj) {
                                data.append('wmu_files[' + i + ']', fileObj);
                            });
                        }
                    });
                }
            }

            if (!wpdiscuzRecaptcha && !isGoodbyeCaptchaActive && (isShowCaptchaForGuests || isShowCaptchaForMembers) && !isCaptchaInSession) {
                var image = $('.wc_captcha_img', wcForm);
                var src = image.attr('src');
                var lastIndex = src.lastIndexOf('/') + 1;
                var fileName = src.substring(lastIndex);
                data.append('fileName', fileName);
            }

            if (wpdiscuzAjaxObj.wpdiscuz_options.wpdiscuz_zs) {
                data.append('wpdiscuz_zs', wpdiscuzAjaxObj.wpdiscuz_options.wpdiscuz_zs);
            }

            if ($('.wpd-cookies-checkbox', wcForm).length && !$('.wpd-cookies-checkbox', wcForm).prop("checked")) {
                wpdCookiesConsent = false;
            }

            getAjaxObj(true, data).done(function (response) {
                $(currentSubmitBtn).addClass('wc_not_clicked');
                var messageKey = '';
                var message = '';
                try {
                    var obj = $.parseJSON(response);
                    messageKey = obj.code;
                    if (parseInt(messageKey) >= 0) {
                        var isMain = obj.is_main;
                        message = obj.message;
                        $('.wpd-cc-value').html(obj.wc_all_comments_count_new);
                        if ($('.wpd-stat-threads-count').length) {
                            $('.wpd-stat-threads-count').html(obj.threadsCount);
                        }
                        if ($('.wpd-stat-replies-count').length) {
                            $('.wpd-stat-replies-count').html(obj.repliesCount);
                        }
                        if ($('.wpd-stat-authors-count').length) {
                            $('.wpd-stat-authors-count').html(obj.authorsCount);
                        }
                        if (isMain) {
                            $('.wc-thread-wrapper').prepend(message);
                        } else {
                            $('#wc-secondary-form-wrapper-' + messageKey).slideToggle(700);
                            if (obj.is_in_same_container == 1) {
                                $('#wc-secondary-form-wrapper-' + messageKey).after(message);
                            } else {
                                $('#wc-secondary-form-wrapper-' + messageKey).after(message.replace('wc-reply', 'wc-reply wc-no-left-margin'));
                            }
                        }
                        if (obj.held_moderate && isCookiesEnabled) {
                            var moderateCommentTime = 30 * 24 * 60 * 60;
                            var moderateComments = '';
                            if (Cookies.get('wc_moderate_comments_' + wpdiscuzPostId)) {
                                moderateComments = Cookies.get('wc_moderate_comments_' + wpdiscuzPostId);
                            }
                            moderateComments += obj.new_comment_id + ',';
                            Cookies.set('wc_moderate_comments_' + wpdiscuzPostId, moderateComments, {expires: moderateCommentTime, path: '/'});
                        }
                        notifySubscribers(obj);
                        wpdiscuzRedirect(obj);
                        if (isCookiesEnabled && wpdCookiesConsent) {
                            addCookie(wcForm, obj);
                        } else if (!wpdCookiesConsent) {
                            $('.wpd-cookies-checkbox').removeAttr('checked');
                        }
                        wcForm.get(0).reset();
                        setCookieInForm(obj);
                        var currTArea = $('.wc_comment', wcForm);
                        currTArea.css('height', '72px');
                        setTextareaCharCount(currTArea, commentTextMaxLength);
                        $('.wmu-preview-wrap', wcForm).remove();
                        if (wpdiscuzReplyButton.length) {
                            wpdiscuzReplyButton.removeClass('wc-cta-active');
                        }
                        deleteAgreementFields();
                    } else {
                        message = wpdiscuzAjaxObj.wpdiscuz_options[messageKey];
                        if (obj.typeError != 'undefined' && obj.typeError != null) {
                            message += ' ' + obj.typeError;
                        }
                        wpdiscuzAjaxObj.setCommentMessage(wcForm, messageKey, message, true);
                    }
                    if (obj.callbackFunctions != null && obj.callbackFunctions != 'undefined' && obj.callbackFunctions.length) {
                        $.each(obj.callbackFunctions, function (i) {
                            if (typeof wpdiscuzAjaxObj[obj.callbackFunctions[i]] === "function") {
                                wpdiscuzAjaxObj[obj.callbackFunctions[i]](messageKey, wcForm);
                            } else {
                                console.log(obj.callbackFunctions[i] + " is not a function");
                            }
                        });
                    }
                } catch (e) {
                    if (response.indexOf('<') >= 0 && response.indexOf('>') >= 0) {
                        message = e;
                    } else {
                        message = response;
                    }
                    wpdiscuzAjaxObj.setCommentMessage(wcForm, 'wc_invalid_field', message, true);
                }
                $('.wpdiscuz-loading-bar').fadeOut(250);
            });
        }
        changeCaptchaImage($('.wc_captcha_refresh_img', wcForm));
        wpdiscuzReset();
    });

    function notifySubscribers(obj) {
        if (!obj.held_moderate) {
            var data = new FormData();
            data.append('action', 'checkNotificationType');
            data.append('comment_id', obj.new_comment_id);
            data.append('email', obj.comment_author_email);
            data.append('isParent', obj.is_main);
            var ajaxObject = getAjaxObj(true, data);
            ajaxObject.done(function (response) {
                try {
                    obj = $.parseJSON(response);
                } catch (e) {
                    console.log(e);
                }
            });
        }
    }

    function wpdiscuzRedirect(obj) {
        if (obj.redirect > 0 && obj.new_comment_id) {
            var data = new FormData();
            data.append('action', 'redirect');
            data.append('commentId', obj.new_comment_id);
            var ajaxObject = getAjaxObj(true, data);
            ajaxObject.done(function (response) {
                obj = $.parseJSON(response);
                if (obj.code == 1) {
                    setTimeout(function () {
                        window.location.href = obj.redirect_to;
                    }, 5000);
                }
            });
        }
    }

    function setCookieInForm(obj) {
        $('.wc_comm_form .wc_name').val(obj.comment_author);
        if (obj.comment_author_email.indexOf('@example.com') < 0) {
            $('.wc_comm_form .wc_email').val(obj.comment_author_email);
        }
        if (obj.comment_author_url) {
            $('.wc_comm_form .wc_website').val(obj.comment_author_url);
        }
    }

    function addCookie(wcForm, obj) {
        var email = obj.comment_author_email;
        var name = obj.comment_author;
        var weburl = obj.comment_author_url;
        if (storeCommenterData == null) {
            Cookies.set('comment_author_email_' + wpdiscuzCookiehash, email);
            Cookies.set('comment_author_' + wpdiscuzCookiehash, name);
            if (weburl.length) {
                Cookies.set('comment_author_url_' + wpdiscuzCookiehash, weburl);
            }
        } else {
            storeCommenterData = parseInt(storeCommenterData);
            Cookies.set('comment_author_email_' + wpdiscuzCookiehash, email, {expires: storeCommenterData, path: '/'});
            Cookies.set('comment_author_' + wpdiscuzCookiehash, name, {expires: storeCommenterData, path: '/'});
            if (weburl.length) {
                Cookies.set('comment_author_url_' + wpdiscuzCookiehash, weburl, {expires: storeCommenterData, path: '/'});
            }
        }
        if ($('.wpd-cookies-checkbox').length) {
            $('.wpd-cookies-checkbox').attr('checked', 'checked');
        }
    }
//============================== ADD COMMENT FUNCTION ============================== // 
//============================== EDIT COMMENT FUNCTION ============================== // 
    var wcCommentTextBeforeEditing;

    $(document).delegate('.wc_editable_comment', 'click', function () {
        var uniqueID = getUniqueID($(this), 0);
        var commentID = getCommentID(uniqueID);
        var editButton = $(this);
        var data = new FormData();
        data.append('action', 'editComment');
        data.append('commentId', commentID);
        var wcCommentTextBeforeEditingTop = $('#wc-comm-' + uniqueID + ' .wpd-top-custom-fields');
        var wcCommentTextBeforeEditingBottom = $('#wc-comm-' + uniqueID + ' .wpd-bottom-custom-fields');
        wcCommentTextBeforeEditing = wcCommentTextBeforeEditingTop.length ? '<div class="wpd-top-custom-fields">' + wcCommentTextBeforeEditingTop.html() + '</div>' : '';
        wcCommentTextBeforeEditing += '<div class="wc-comment-text">' + $('#wc-comm-' + uniqueID + ' .wc-comment-text').html() + '</div>';
        wcCommentTextBeforeEditing += wcCommentTextBeforeEditingBottom.length ? '<div class="wpd-bottom-custom-fields">' + $('#wc-comm-' + uniqueID + ' .wpd-bottom-custom-fields').html() + '</div>' : '';
        console.log(wcCommentTextBeforeEditing);
        getAjaxObj(true, data).done(function (response) {
            try {
                var obj = $.parseJSON(response);
                var message = '';
                var messageKey = obj.code;
                if (parseInt(messageKey) >= 0) {
                    $('#wc-comm-' + uniqueID + ' .wpd-top-custom-fields').remove();
                    $('#wc-comm-' + uniqueID + ' .wpd-bottom-custom-fields').remove();
                    $('#wc-comm-' + uniqueID + ' > .wc-comment-right .wc-comment-text').replaceWith(obj.message);
                    $('#wc-comm-' + uniqueID + ' > .wc-comment-right .wc-comment-footer .wc_editable_comment').hide();
                    $('#wc-comm-' + uniqueID + ' > .wc-comment-right .wc-comment-footer .wc_cancel_edit').css('display', 'inline-block');
                    var editForm = $('#wc-comm-' + uniqueID + ' > .wc-comment-right #wpdiscuz-edit-form');
                    //wpdiscuzReplaceValidationUI(editForm[0]);
                } else {
                    message = wpdiscuzAjaxObj.wpdiscuz_options[messageKey];
                    wpdiscuzAjaxObj.setCommentMessage(editButton, messageKey, message, false);
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });

    $(document).delegate('.wc_save_edited_comment', 'click', function () {
        var uniqueID = getUniqueID($(this));
        var commentID = getCommentID(uniqueID);
        var editCommentForm = $('#wc-comm-' + uniqueID + ' #wpdiscuz-edit-form');
        var saveButton = $(this);
        wpdValidateFieldRequired(editCommentForm);
        editCommentForm.submit(function (event) {
            event.preventDefault();
        });

        if (editCommentForm[0].checkValidity()) {
            var data = new FormData();
            data.append('action', 'saveEditedComment');
            data.append('wpdiscuz_unique_id', uniqueID);
            data.append('commentId', commentID);
            var inputs = $(":input", editCommentForm);
            inputs.each(function () {
                if ($(this).is(':visible') && this.name != '' && this.type != 'checkbox' && this.type != 'radio') {
                    data.append(this.name + '', $(this).val());
                }
                if (this.type == 'checkbox' || this.type == 'radio') {
                    if ($(this).is(':checked')) {
                        data.append(this.name + '', $(this).val());
                    }
                }
            });

            getAjaxObj(true, data).done(function (response) {
                try {
                    var obj = $.parseJSON(response);
                    var messageKey = obj.code;
                    var message = '';
                    if (parseInt(messageKey) >= 0) {
                        wcCancelOrSave(uniqueID, obj.message);
                    } else {
                        message = wpdiscuzAjaxObj.wpdiscuz_options[messageKey];
                        wpdiscuzAjaxObj.setCommentMessage(saveButton, messageKey, message, false);
                    }
                    if (obj.callbackFunctions != null && obj.callbackFunctions != 'undefined' && obj.callbackFunctions.length) {
                        $.each(obj.callbackFunctions, function (i) {
                            if (typeof wpdiscuzAjaxObj[obj.callbackFunctions[i]] === "function") {
                                wpdiscuzAjaxObj[obj.callbackFunctions[i]](messageKey, commentID, commentContent);
                            } else {
                                console.log(obj.callbackFunctions[i] + " is not a function");
                            }
                        });
                    }
                } catch (e) {
                    if (response.indexOf('<') >= 0 && response.indexOf('>') >= 0) {
                        message = e;
                    } else {
                        message = response;
                    }
                    wpdiscuzAjaxObj.setCommentMessage(saveButton, 'wc_invalid_field', message, false);
                }
                $('.wpdiscuz-loading-bar').fadeOut(250);
            });
        }
    });

    $(document).delegate('.wc_cancel_edit', 'click', function () {
        var uniqueID = getUniqueID($(this));
        wcCancelOrSave(uniqueID, wcCommentTextBeforeEditing);
    });

    function wcCancelOrSave(uniqueID, content) {
        $('#wc-comm-' + uniqueID + ' > .wc-comment-right .wc-comment-footer .wc_editable_comment').show();
        $('#wc-comm-' + uniqueID + ' > .wc-comment-right .wc-comment-footer .wc_cancel_edit').hide();
        $('#wc-comm-' + uniqueID + ' .wpdiscuz-edit-form-wrap').replaceWith(content);
    }

    function nl2br(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';
        var string = (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        return string.replace('<br><br>', '<br/>');
    }
//============================== EDIT COMMENT FUNCTION ============================== // 
//============================== LOAD MORE ============================== // 
    $(document).delegate('.wc-load-more-submit', 'click', function () {
        var loadButton = $(this);
        var loaded = 'wc-loaded';
        var loading = 'wc-loading';
        if (loadButton.hasClass(loaded)) {
            wpdiscuzLoadComments(loadButton, loaded, loading);
        }
    });

    var isRun = false;
    if (commentListLoadType == 2 && !wordpressIsPaginate) {
        $('.wc-load-more-submit').parents('.wpdiscuz-comment-pagination').hide();
        wpdiscuzScrollEvents();
        $(window).scroll(function () {
            wpdiscuzScrollEvents();
        });
    }

    function wpdiscuzScrollEvents() {
        var wpdiscuzHasMoreComments = $('#wpdiscuzHasMoreComments').val();
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if (scrollHeight && scrollPosition) {
            var scrollPercent = scrollPosition * 100 / scrollHeight;
            if (scrollPercent >= 80 && isRun === false && wpdiscuzHasMoreComments == 1) {
                isRun = true;
                wpdiscuzLoadComments($('.wc-load-more-submit'));
            }
        }
    }

    function wpdiscuzLoadComments(loadButton, loaded, loading) {
        loadButton.toggleClass(loaded);
        loadButton.toggleClass(loading);
        var data = new FormData();
        data.append('action', 'loadMoreComments');
        data.append('offset', wpdiscuzLoadCount);
        data.append('orderBy', wpdiscuzCommentOrderBy);
        data.append('order', wpdiscuzCommentOrder);
        data.append('lastParentId', getLastParentID());
        data.append(wpdiscuzLastVisitKey, Cookies.get(wpdiscuzLastVisitKey));
        wpdiscuzLoadCount++;
        getAjaxObj(true, data).done(function (response) {
            try {
                var obj = $.parseJSON(response);
                $('.wpdiscuz-comment-pagination').before(obj.comment_list);
                setLoadMoreVisibility(obj);
                $('.wpdiscuz_single').remove();
                isRun = false;
                loadLastCommentId = obj.loadLastCommentId;
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
            $('.wc-load-more-submit').blur();
            loadButton.toggleClass(loaded);
            loadButton.toggleClass(loading);
        });
    }

    function setLoadMoreVisibility(obj) {
        if (obj.is_show_load_more == false) {
            $('#wpdiscuzHasMoreComments').val(0);
            $('.wc-load-more-submit').parents('.wpdiscuz-comment-pagination').hide();
        } else {
            setLastParentID(obj.last_parent_id);
            $('#wpdiscuzHasMoreComments').val(1);
        }

        if (obj.callbackFunctions != null && obj.callbackFunctions != 'undefined' && obj.callbackFunctions.length) {
            $.each(obj.callbackFunctions, function (i) {
                if (typeof wpdiscuzAjaxObj[obj.callbackFunctions[i]] === "function") {
                    wpdiscuzAjaxObj[obj.callbackFunctions[i]]();
                } else {
                    console.log(obj.callbackFunctions[i] + " is not a function");
                }
            });
        }
    }

//============================== LOAD MORE ============================== // 
//============================== VOTE  ============================== // 
    $(document).delegate('.wc_vote.wc_not_clicked', 'click', function () {
        var currentVoteBtn = $(this);
        $(currentVoteBtn).removeClass('wc_not_clicked');
        var messageKey = '';
        var message = '';
        var commentID = $(this).parents('.wc-comment-right').attr('id');
        commentID = commentID.substring(commentID.lastIndexOf('-') + 1);
        var voteType;
        if ($(this).hasClass('wc-up')) {
            voteType = 1;
        } else {
            voteType = -1;
        }

        var data = new FormData();
        data.append('action', 'voteOnComment');
        data.append('commentId', commentID);
        data.append('voteType', voteType);
        getAjaxObj(true, data).done(function (response) {
            $(currentVoteBtn).addClass('wc_not_clicked');
            try {
                var obj = $.parseJSON(response);
                messageKey = obj.code;
                if (parseInt(messageKey) >= 0) {
                    if (obj.buttonsStyle == 'total') {
                        var voteCountDiv = $('.wc-comment-footer .wc-vote-result', $('#comment-' + commentID));
                        voteCountDiv.text(parseInt(voteCountDiv.text()) + voteType);
                    } else {
                        var likeCountDiv = $('.wc-comment-footer .wc-vote-result-like', $('#comment-' + commentID));
                        var dislikeCountDiv = $('.wc-comment-footer .wc-vote-result-dislike', $('#comment-' + commentID));
                        likeCountDiv.text(obj.likeCount);
                        dislikeCountDiv.text(obj.dislikeCount);
                        parseInt(obj.likeCount) > 0 ? likeCountDiv.addClass('wc-positive') : likeCountDiv.removeClass('wc-positive');
                        parseInt(obj.dislikeCount) < 0 ? dislikeCountDiv.addClass('wc-negative') : dislikeCountDiv.removeClass('wc-negative');
                    }
                } else {
                    message = wpdiscuzAjaxObj.wpdiscuz_options[messageKey];
                    wpdiscuzAjaxObj.setCommentMessage(currentVoteBtn, messageKey, message, false);
                }
                if (obj.callbackFunctions != null && obj.callbackFunctions != 'undefined' && obj.callbackFunctions.length) {
                    $.each(obj.callbackFunctions, function (i) {
                        if (typeof wpdiscuzAjaxObj[obj.callbackFunctions[i]] === "function") {
                            wpdiscuzAjaxObj[obj.callbackFunctions[i]](messageKey, commentID, voteType);
                        } else {
                            console.log(obj.callbackFunctions[i] + " is not a function");
                        }
                    });
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });
//============================== VOTE ============================== //
//============================== SORTING ============================== //
    $(document).delegate('.wpdiscuz-sort-button', 'click', function () {
        if (!($(this).hasClass('wpdiscuz-sort-button-active'))) {
            var clickedBtn = $(this);
            if ($(this).hasClass('wpdiscuz-vote-sort-up')) {
                wpdiscuzCommentOrderBy = 'by_vote';
                wpdiscuzCommentOrder = 'desc';
            } else {
                wpdiscuzCommentOrderBy = 'comment_date_gmt';
                wpdiscuzCommentOrder = $(this).hasClass('wpdiscuz-date-sort-desc') ? 'desc' : 'asc';
            }
            var data = new FormData();
            data.append('action', 'wpdiscuzSorting');
            data.append('orderBy', wpdiscuzCommentOrderBy);
            data.append('order', wpdiscuzCommentOrder);
            data.append('order', wpdiscuzCommentOrder);

            var messageKey = '';
            var message = '';
            getAjaxObj(true, data).done(function (response) {
                try {
                    var obj = $.parseJSON(response);
                    messageKey = obj.code;
                    message = obj.message;
                    if (parseInt(messageKey) > 0) {
                        $('#wpcomm .wc-thread-wrapper .wc-comment').each(function () {
                            $(this).remove();
                        });
                        $('#wpcomm .wc-thread-wrapper').prepend(message);
                        wpdiscuzLoadCount = parseInt(obj.loadCount);
                    } else {
                    }
                    setActiveButton(clickedBtn);
                    setLoadMoreVisibility(obj);
                } catch (e) {
                    console.log(e);
                }
                $('.wpdiscuz-loading-bar').fadeOut(250);
            });
        }
    });

    function setActiveButton(clickedBtn) {
        $('.wpdiscuz-sort-buttons .wpdiscuz-sort-button').each(function () {
            $(this).removeClass('wpdiscuz-sort-button-active');
        });
        clickedBtn.addClass('wpdiscuz-sort-button-active');
    }

//============================== SORTING ============================== // 
//============================== SINGLE COMMENT ============================== // 
    function getSingleComment() {
        var loc = location.href;
        var matches = loc.match(/#comment\-(\d+)/);
        if (matches !== null) {
            var commentId = matches[1];
            if (!$('#comment-' + commentId).length) {
                var data = new FormData();
                data.append('action', 'getSingleComment');
                data.append('commentId', commentId);
                var ajaxObject = getAjaxObj(true, data);
                ajaxObject.done(function (response) {
                    try {
                        var obj = $.parseJSON(response);
                        var scrollToSelector = '.wc-thread-wrapper';
                        if ($('#comment-' + obj.parentCommentID).length) {
                            var parentComment = $('#comment-' + obj.parentCommentID);
                            $('.wc-toggle', parentComment).trigger('click');
                            scrollToSelector = '#comment-' + obj.parentCommentID;
                        } else {
                            $('.wc-thread-wrapper').prepend(obj.message);
                        }
                        $('html, body').animate({
                            scrollTop: $(scrollToSelector).offset().top - 32
                        }, 1000);
                    } catch (e) {
                        console.log(e);
                    }
                    $('.wpdiscuz-loading-bar').fadeOut(250);
                });
            }
        }
    }
    getSingleComment();
//============================== SINGLE COMMENT ============================== //
//============================== LIVE UPDATE ============================== // 
    if (commentListUpdateType && loadLastCommentId && (isUserLoggedIn || (!isUserLoggedIn && !disableGuestsLiveUpdate))) {
        setInterval(liveUpdate, parseInt(commentListUpdateTimer) * 1000);
    }

    function liveUpdate() {
        var visibleCommentIds = getVisibleCommentIds();
        var email = (Cookies.get('comment_author_email_' + wpdiscuzCookiehash) != undefined && Cookies.get('comment_author_email_' + wpdiscuzCookiehash) != '') ? Cookies.get('comment_author_email_' + wpdiscuzCookiehash) : '';
        var data = new FormData();
        data.append('action', 'updateAutomatically');
        data.append('loadLastCommentId', loadLastCommentId);
        data.append('visibleCommentIds', visibleCommentIds);
        data.append('email', email);
        var ajaxObject = getAjaxObj(false, data);
        ajaxObject.done(function (response) {
            try {
                var obj = $.parseJSON(response);
                if (obj.code == 1) {
                    if (commentListUpdateType == 1) {
                        liveUpdateImmediately(obj);
                    } else {
                        wpdiscuzCommentArray = wpdiscuzCommentArray.concat(obj.message.comments);
                        wpdiscuzReplyArray = wpdiscuzReplyArray.concat(obj.message.author_replies);
                        var newCommentArrayLength = wpdiscuzCommentArray.length;
                        var newRepliesArrayLength = wpdiscuzReplyArray.length;
                        if (newCommentArrayLength > 0) {
                            var newCommentText = newCommentArrayLength + ' ';
                            newCommentText += newCommentArrayLength > 1 ? wpdiscuzAjaxObj.wpdiscuz_options.wc_new_comments_button_text : wpdiscuzAjaxObj.wpdiscuz_options.wc_new_comment_button_text;
                            $('.wc_new_comment').html(newCommentText).show();
                        } else {
                            $('.wc_new_comment').hide();
                        }
                        if (newRepliesArrayLength > 0) {
                            var newReplyText = newRepliesArrayLength + ' ';
                            newReplyText += newRepliesArrayLength > 1 ? wpdiscuzAjaxObj.wpdiscuz_options.wc_new_replies_button_text : wpdiscuzAjaxObj.wpdiscuz_options.wc_new_reply_button_text;
                            $('.wc_new_reply').html(newReplyText).show();
                        } else {
                            $('.wc_new_reply').hide();
                        }
                    }
                    $('.wpd-cc-value').html(obj.wc_all_comments_count_new);
                    loadLastCommentId = obj.loadLastCommentId;
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    }

    function liveUpdateImmediately(obj) {
        if (obj.message !== undefined) {
            var commentObject;
            var message = obj.message;
            for (var i = 0; i < message.length; i++) {
                commentObject = message[i];
                addCommentToTree(commentObject.comment_parent, commentObject.comment_html);
            }
        }
    }

    $(document).delegate('.wc-update-on-click', 'click', function () {
        var data = new FormData();
        data.append('action', 'updateOnClick');
        var clickedButton = $(this);
        if (clickedButton.hasClass('wc_new_comment')) {
            data.append('newCommentIds', wpdiscuzCommentArray.join());
        } else {
            data.append('newCommentIds', wpdiscuzReplyArray.join());
        }

        getAjaxObj(true, data).done(function (response) {
            try {
                var obj = $.parseJSON(response);
                liveUpdateImmediately(obj);
                if (clickedButton.hasClass('wc_new_comment')) {
                    wpdiscuzCommentArray = [];
                    $('.wc_new_comment').hide();
                } else {
                    wpdiscuzReplyArray = [];
                    $('.wc_new_reply').hide();
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });
//============================== LIVE UPDATE ============================== // 
//============================== READ MORE ============================== // 
    $(document).delegate('.wpdiscuz-readmore', 'click', function () {
        var uniqueId = getUniqueID($(this));
        var commentId = getCommentID(uniqueId);
        var data = new FormData();
        data.append('action', 'readMore');
        data.append('commentId', commentId);
        getAjaxObj(true, data).done(function (response) {
            try {
                var obj = $.parseJSON(response);
                if (obj.code) {
                    $('#comment-' + commentId + ' .wc-comment-text').html(' ' + obj.message);
                    $('#wpdiscuz-readmore-' + uniqueId).remove();
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });
//============================== READ MORE ============================== // 

//============================== FUNCTIONS ============================== //
    /**
     * field - the clicked element
     * messagekey - the key for adding class on message container
     * message - the message to add
     * isformerror - whether the error is form or not
     */
    wpdiscuzAjaxObj.setCommentMessage = function (field, messageKey, message, isFormError) {
        var msgContainer;
        var parentContainer;
        if (isFormError) {
            parentContainer = field.parents('.wc-form-wrapper');
        } else {
            parentContainer = field.closest('.wc-comment');
        }
        msgContainer = parentContainer.children('.wpdiscuz-comment-message');
        msgContainer.removeClass();
        msgContainer.addClass('wpdiscuz-comment-message');
        msgContainer.addClass(messageKey);
        msgContainer.html(message);
        msgContainer.show().delay(4000).fadeOut(1000, function () {
            msgContainer.removeClass();
            msgContainer.addClass('wpdiscuz-comment-message');
            msgContainer.html('');
        });

    }

    function cloneSecondaryForm(field) {
        var uniqueId = getUniqueID(field, 0);
        $('#wpdiscuz_form_anchor-' + uniqueId).before(replaceUniqueId(uniqueId));
        var secondaryFormWrapper = $('#wc-secondary-form-wrapper-' + uniqueId);
        //wpdiscuzReplaceValidationUI($('.wc_comm_form', secondaryFormWrapper)[0]);
        secondaryFormWrapper.slideToggle(enableDropAnimation, function () {
            field.addClass('wpdiscuz-clonned');
        });
        changeCaptchaImage($('.wc_captcha_refresh_img', secondaryFormWrapper));
    }

    function replaceUniqueId(uniqueId) {
        var secondaryForm = $('#wpdiscuz_hidden_secondary_form').html();
        return secondaryForm.replace(/wpdiscuzuniqueid/g, uniqueId);
    }

    function getUniqueID(field, isMain) {
        var fieldID = '';
        if (isMain) {
            fieldID = field.parents('.wc-main-form-wrapper').attr('id');
        } else {
            fieldID = field.parents('.wc-comment').attr('id');
        }
        var uniqueID = fieldID.substring(fieldID.lastIndexOf('-') + 1);
        return uniqueID;
    }

    function getCommentID(uniqueID) {
        return uniqueID.substring(0, uniqueID.indexOf('_'));
    }

    function getLastParentID() {
        return $('.wc-load-more-link').attr("data-lastparentid");
    }

    function setLastParentID(lastParentID) {
        $('.wc-load-more-link').attr("data-lastparentid", lastParentID);
        if (commentListLoadType != 2) {
            $('.wpdiscuz-comment-pagination').show();
        }
    }


    function getCommentDepth(field) {
        var fieldClasses = field.attr('class');
        var classesArray = fieldClasses.split(' ');
        var depth = '';
        $.each(classesArray, function (index, value) {
            if ('wc_comment_level' === getParentDepth(value, false)) {
                depth = getParentDepth(value, true);
            }
        });
        return parseInt(depth) + 1;
    }

    function getParentDepth(depthValue, isNumberPart) {
        var depth = '';
        if (isNumberPart) {
            depth = depthValue.substring(depthValue.indexOf('-') + 1);
        } else {
            depth = depthValue.substring(0, depthValue.indexOf('-'));
        }
        return depth;
    }

    function addCommentToTree(parentId, comment) {
        if (parentId == 0) {
            $('.wc-thread-wrapper').prepend(comment);
        } else {
            var parentUniqueId = getUniqueID($('#comment-' + parentId), 0);
            $('#wpdiscuz_form_anchor-' + parentUniqueId).after(comment);
        }
    }

    function getVisibleCommentIds() {
        var uniqueId;
        var commentId;
        var visibleCommentIds = '';
        $('.wc-comment-right').each(function () {
            uniqueId = getUniqueID($(this), 0);
            commentId = getCommentID(uniqueId);
            visibleCommentIds += commentId + ',';
        });
        return visibleCommentIds;
    }

    function loginButtonsClone() {
        if ($('.wc_social_plugin_wrapper .wp-social-login-provider-list').length) {
            $('.wc_social_plugin_wrapper .wp-social-login-provider-list').clone().prependTo('#wpdiscuz_hidden_secondary_form > .wc-form-wrapper >  .wc-secondary-forms-social-content');
        } else if ($('.wc_social_plugin_wrapper .the_champ_login_container').length) {
            $('.wc_social_plugin_wrapper .the_champ_login_container').clone().prependTo('#wpdiscuz_hidden_secondary_form > .wc-form-wrapper >  .wc-secondary-forms-social-content');
        } else if ($('.wc_social_plugin_wrapper .social_connect_form').length) {
            $('.wc_social_plugin_wrapper .social_connect_form').clone().prependTo('#wpdiscuz_hidden_secondary_form > .wc-form-wrapper >  .wc-secondary-forms-social-content');
        } else if ($('.wc_social_plugin_wrapper .oneall_social_login_providers').length) {
            $('.wc_social_plugin_wrapper .oneall_social_login .oneall_social_login_providers').clone().prependTo('#wpdiscuz_hidden_secondary_form > .wc-form-wrapper >  .wc-secondary-forms-social-content');
        }
    }

    function displayShowHideReplies() {
        $('#wcThreadWrapper .wc-comment').each(function (i) {
            if ($('> .wc-reply', this).length || $(this).hasClass('wpdiscuz-root-comment')) {
                var toggle = $('> .wc-comment-right .wc-comment-footer .wc-toggle', this);
                toggle.removeClass('wpdiscuz-hidden');
            }
        });
    }

    function wpdiscuzReset() {
        $('.wpdiscuz_reset').val("");
    }

    function setTextareaCharCount(elem, count) {
        if (commentTextMaxLength != null) {
            var currLength = elem.val().length;
            var textareaWrap = elem.parents('.wc_comm_form');
            var charCountDiv = $('.commentTextMaxLength', textareaWrap);
            var left = commentTextMaxLength - currLength;
            if (left <= 10) {
                charCountDiv.addClass('left10');
            } else {
                charCountDiv.removeClass('left10');
            }
            charCountDiv.html(left);
        }
    }

    function wpdValidateFieldRequired(form) {
        var fieldsGroup = form.find('.wpd-required-group');
        $.each(fieldsGroup, function () {
            $('input', this).removeAttr('required');
            var checkedFields = $('input:checked', this);
            if (checkedFields.length === 0) {
                $('input', $(this)).attr('required', 'required');
            } else {
                $('.wpd-field-invalid', this).remove();
            }
        });

        if (wpdiscuzRecaptcha && $('input[name=wpdiscuz_recaptcha]', form).length && !$('input[name=wpdiscuz_recaptcha]', form).val().length) {
            wpdGoogleRecaptchaValid = false;
            $('.wpdiscuz-recaptcha', form).css('border', '1px solid red');
        } else if (wpdiscuzRecaptcha) {
            $('.wpdiscuz-recaptcha', form).css('border', 'none');
        }
    }

    //============================== FUNCTIONS ============================== // 

    //=================== FORM VALIDATION ================================//
    /* function wpdiscuzReplaceValidationUI(form) {
     form.addEventListener("invalid", function (event) {
     event.preventDefault();
     }, true);
     form.addEventListener("submit", function (event) {
     if (!this.checkValidity()) {
     event.preventDefault();
     }
     });
     }
     
     $(document).delegate('.wc_comm_submit, .wc_save_edited_comment', 'click', function () {
     var curentForm = $(this).parents('form');
     var invalidFields = $(':invalid', curentForm),
     errorMessages = $('.error-message', curentForm),
     parent;
     
     for (var i = 0; i < errorMessages.length; i++) {
     errorMessages[ i ].parentNode.removeChild(errorMessages[ i ]);
     }
     for (var i = 0; i < invalidFields.length; i++) {
     parent = invalidFields[ i ].parentNode;
     var oldMsg = parent.querySelector('.wpd-field-invalid');
     if (oldMsg) {
     parent.removeChild(oldMsg);
     }
     if (invalidFields[ i ].validationMessage !== '') {
     parent.insertAdjacentHTML("beforeend", "<div class='wpd-field-invalid'><span>" +
     invalidFields[ i ].validationMessage +
     "</span></div>");
     }
     }
     });
     
     function wpdiscuzRemoveError(field) {
     var wpdiscuzErrorDiv = $(field).parents('div.wpdiscuz-item').find('.wpd-field-invalid');
     if (wpdiscuzErrorDiv) {
     wpdiscuzErrorDiv.remove();
     }
     }
     $(document).delegate('.wpdiscuz-item input,.wpdiscuz-item textarea,.wpdiscuz-item select', 'click', function () {
     wpdiscuzRemoveError($(this));
     });
     
     $(document).delegate('.wpdiscuz-item input,.wpdiscuz-item textarea,.wpdiscuz-item select', 'focus', function () {
     wpdiscuzRemoveError($(this));
     });*/

    $(document).delegate('.wpd-required-group', 'change', function () {
        if ($('input:checked', this).length !== 0) {
            //$('.wpd-field-invalid', this).remove();
            $('input', $(this)).removeAttr('required');
        } else {
            $('input', $(this)).attr('required', 'required');
        }
    });

    /* SPOILER */
    $(document).delegate('.wpdiscuz-spoiler', 'click', function () {
        $(this).next().slideToggle();
        if ($(this).hasClass('wpdiscuz-spoiler-closed')) {
            $(this).parents('.wpdiscuz-spoiler-wrap').find('.fa-plus').removeClass('fa-plus').addClass('fa-minus');
        } else {
            $(this).parents('.wpdiscuz-spoiler-wrap').find('.fa-minus').removeClass('fa-minus').addClass('fa-plus');
        }
        $(this).toggleClass('wpdiscuz-spoiler-closed');
    });

    function wpdiscuzShowReplies(uniqueId) {
        var commentId = getCommentID(uniqueId);
        var data = new FormData();
        data.append('action', 'wpdiscuzShowReplies');
        data.append('commentId', commentId);
        var ajax = getAjaxObj(true, data);
        ajax.done(function (response) {
            try {
                var obj = $.parseJSON(response);
                if (obj.code == 1) {
                    $('#wc-comm-' + uniqueId).replaceWith(obj.data);
                    $('#wc-comm-' + uniqueId + ' .wc-toggle .fas').removeClass('fa-chevron-down').addClass('fa-chevron-up').removeClass('wpdiscuz-show-replies').attr('title', wpdiscuzAjaxObj.wpdiscuz_options.wc_hide_replies_text);
                    var toggle = $('#wc-comm-' + uniqueId + ' .wc-toggle');
                    $('.wpdiscuz-children-button-text', toggle).text(wpdiscuzAjaxObj.wpdiscuz_options.wc_hide_replies_text);
                    if (obj.callbackFunctions != null && obj.callbackFunctions != 'undefined' && obj.callbackFunctions.length) {
                        $.each(obj.callbackFunctions, function (i) {
                            if (typeof wpdiscuzAjaxObj[obj.callbackFunctions[i]] === "function") {
                                wpdiscuzAjaxObj[obj.callbackFunctions[i]]();
                            } else {
                                console.log(obj.callbackFunctions[i] + " is not a function");
                            }
                        });
                    }
                } else {
                    console.log('Unknown error occured');
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    }

    $(document).delegate('.wc_stick_btn', 'click', function () {
        var btn = $(this);
        var uniqueId = getUniqueID(btn, 0);
        var commentId = getCommentID(uniqueId);
        var data = new FormData();
        data.append('action', 'wpdStickComment');
        data.append('commentId', commentId);
        var ajax = getAjaxObj(true, data);
        ajax.done(function (response) {
            try {
                var obj = $.parseJSON(response);
                if (obj.code == 1) {
                    $('.wc_stick_text', btn).text(obj.data);
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000);
                } else {
                    console.log('Comment not updated');
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });

    $(document).delegate('.wc_close_btn', 'click', function () {
        var btn = $(this);
        var uniqueId = getUniqueID(btn, 0);
        var commentId = getCommentID(uniqueId);
        var data = new FormData();
        data.append('action', 'wpdCloseThread');
        data.append('commentId', commentId);
        var ajax = getAjaxObj(true, data);
        ajax.done(function (response) {
            try {
                var obj = $.parseJSON(response);
                if (obj.code == 1) {
                    $('.wc_close_btn', btn).text(obj.data);
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000);
                } else {
                    console.log('Comment not updated');
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });


    $(document).delegate('.wc_main_comm_form .wc_comment', 'focus', function () {
        $(this).parents('.wpdiscuz-textarea-wrap').find('.wc-field-avatararea').hide('fast');
        $(this).animate({'padding': '15px', 'font-size': '14px'}, 'fast');
    });

    $(document).delegate('.wc_main_comm_form .wc_comment', 'blur', function () {
        if (!$(this).val()) {
            $(this).removeAttr("style");
            $(this).parents('.wpdiscuz-textarea-wrap').find('.wc-field-avatararea').show("fast");
        }
    });

    $(document).delegate('.wpd-stat-reacted', 'click', function () {
        var btn = $(this);
        $('.fas', btn).addClass('fa-pulse fa-spinner');
        var data = new FormData();
        data.append('action', 'wpdMostReactedComment');
//        data.append('action', 'wpdMostReacted');
        var ajax = getCustomAjaxObj(false, data);
//        var ajax = getAjaxObj(false, data);

        ajax.done(function (response) {
            try {
                $('.fas', btn).removeClass('fa-pulse fa-spinner');
                var r = $.parseJSON(response);
                if (r.code) {
                    var scrollToSelector = '.wc-thread-wrapper';
                    if ($('#comment-' + r.commentId).length) {
                        scrollToSelector = '#comment-' + r.commentId;
                    } else if ($('#comment-' + r.parentCommentID).length) {
                        var parentComment = $('#comment-' + r.parentCommentID);
                        $('.wc-toggle', parentComment).trigger('click');
                    } else {
                        $('.wc-thread-wrapper').prepend(r.message);
                        scrollToSelector = '#comment-' + r.commentId;
                    }

                    $('html, body').animate({
                        scrollTop: $(scrollToSelector).offset().top - 32
                    }, 1000);
                } else {

                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });


    $(document).delegate('.wpd-stat-hot', 'click', function () {
        var btn = $(this);
        $('.fab', btn).addClass('fas fa-pulse fa-spinner');
        var data = new FormData();
        data.append('action', 'wpdMostActiveThread');
//        data.append('action', 'wpdHottest');
        var ajax = getCustomAjaxObj(false, data);
//        var ajax = getAjaxObj(false, data);

        ajax.done(function (response) {
            try {
                $('.fab', btn).removeClass('fas fa-pulse fa-spinner');
                var r = $.parseJSON(response);
                if (r.code) {
                    var scrollToSelector = '.wc-thread-wrapper';
                    if ($('#comment-' + r.commentId).length) {
                        scrollToSelector = '#comment-' + r.commentId;
                    } else {
                        $('.wc-thread-wrapper').prepend(r.message);
                        scrollToSelector = '#comment-' + r.commentId;
                    }

                    var comment = $('#comment-' + r.commentId);
                    var toggle = $('.wc-toggle', comment);
                    var icon = $('.fas', toggle);
                    if (icon.hasClass('wpdiscuz-show-replies') && isLoadOnlyParentComments) {
                        toggle.trigger('click');
                    }

                    $('html, body').animate({
                        scrollTop: $(scrollToSelector).offset().top - 32
                    }, 1000);
                } else {

                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
    });

    function addAgreementInCookie(wcForm) {
        $('.wpd-agreement-checkbox', wcForm).each(function () {
            if ($(this).hasClass('wpd_agreement_hide') && isCookiesEnabled && $(this).prop('checked')) {
                Cookies.set($(this).attr('name') + '_' + wpdiscuzCookiehash, 1, {expires: 30, path: '/'});
                $('input[name=' + $(this).attr('name') + ']').each(function () {
                    wpdiscuzAgreementFields.push($(this));
                });
            }
        });
    }

    function deleteAgreementFields() {
        if (wpdiscuzAgreementFields.length) {
            wpdiscuzAgreementFields.forEach(function (item) {
                item.parents('.wpd-field-checkbox').remove();
            });
            wpdiscuzAgreementFields = [];
        }
    }

    $(document).delegate('.wc-follow-link.wc_not_clicked', 'click', function () {
        var btn = $(this);
        btn.removeClass('wc_not_clicked');
        $('.fas', btn).addClass('fa-pulse fa-spinner');
        var uniqueId = getUniqueID(btn, 0);
        var commentId = getCommentID(uniqueId);
        var data = new FormData();
        data.append('action', 'wpdFollowUser');
        data.append('commentId', commentId);
        var ajax = getAjaxObj(false, data);

        ajax.done(function (response) {
            btn.addClass('wc_not_clicked');
            if (response.length) {
                try {
                    var r = $.parseJSON(response);
                    if (r.code !== '') {
                        var message = wpdiscuzAjaxObj.wpdiscuz_options[r.code];
                        wpdiscuzAjaxObj.setCommentMessage(btn, r.code, message, false);
                        btn.removeClass('wc-follow-active');
                        if (r.data.followTip) {
                            $('wpdtip', btn).html(r.data.followTip);
                        }
                        if (r.data && r.data.followClass) {
                            btn.addClass(r.data.followClass);
                        }
                    }
                } catch (e) {
                    console.log(e);
                }
            }
            $('.fas', btn).removeClass('fa-pulse fa-spinner');
        });
    });

    /**
     * @param {type} action the action key 
     * @param {type} data the request properties
     * @returns {jqXHR}
     */
    function getAjaxObj(isShowTopLoading, data) {
        if (isShowTopLoading) {
            $('.wpdiscuz-loading-bar').show();
        }
        data.append('postId', wpdiscuzPostId);
        return $.ajax({
            type: 'POST',
            url: wpdiscuzAjaxObj.url,
            data: data,
            contentType: false,
            processData: false,
        });
    }

    /**
     * @param {type} action the action key 
     * @param {type} data the request properties
     * @returns {jqXHR}
     */
    function getCustomAjaxObj(isShowTopLoading, data) {
        if (isShowTopLoading) {
            $('.wpdiscuz-loading-bar').show();
        }
        data.append('postId', wpdiscuzPostId);
        return $.ajax({
            type: 'POST',
            url: wpdiscuzAjaxObj.customAjaxUrl,
            data: data,
            contentType: false,
            processData: false,
        });
    }

});