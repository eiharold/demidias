jQuery(document).ready(function ($) {

    var doingAjax = false;

    if (location.href.indexOf('wpdiscuz_options_page') >= 0) {
        $('.wpdiscuz-color-picker').colorPicker();

        if (!$('ul.wpdiscuz-addons-options').html().trim()) {
            $('#wpdiscuz-addons-options').remove();
        }
    }

    $('#wc_share_button_fb').click(function () {
        if ($(this).is(':checked')) {
            $('#wpc-fb-api-cont').attr('style', '');
        } else {
            $('#wpc-fb-api-cont').attr('style', 'display:none');
        }
    });

    $('#wpdiscuz-reset-options').click(function (e) {
        if (!confirm(wpdiscuzObj.msgConfirmResetOptions)) {
            e.preventDefault();
            return false;
        }
    });

    $('#wpdiscuz-remove-votes').click(function (e) {
        if (!confirm(wpdiscuzObj.msgConfirmRemoveVotes)) {
            e.preventDefault();
            return false;
        }
    });

    $('#wpdiscuz-reset-phrases').click(function (e) {
        if (!confirm(wpdiscuzObj.msgConfirmResetPhrases)) {
            e.preventDefault();
            return false;
        }
    });

    $('#wpdiscuz-purge-gravatars-cache').click(function (e) {
        if (!confirm(wpdiscuzObj.msgConfirmPurgeGravatarsCache)) {
            e.preventDefault();
            return false;
        }
    });

    $('#wpdiscuz-purge-statistics-cache').click(function (e) {
        if (!confirm(wpdiscuzObj.msgConfirmPurgeStatisticsCache)) {
            e.preventDefault();
            return false;
        }
    });

    $(document).delegate('.wc_stick_btn', 'click', function (e) {
        var btn = $(this);
        $('.fas', btn).addClass('fa-pulse fa-spinner');
        var commentId = btn.data('comment');
        var postId = btn.data('post');
        var data = new FormData();
        data.append('action', 'wpdStickComment');
        data.append('commentId', commentId);
        data.append('postId', postId);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            contentType: false,
            processData: false,
        }).done(function (response) {
            try {
                $('.fas', btn).removeClass('fa-pulse fa-spinner');
                var resp = $.parseJSON(response);
                if (resp.code == 1) {
                    $('.wc_stick_text', btn).text(resp.data);
                } else {
                    console.log('Comment not updated');
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
        e.preventDefault();
        return false;
    });

    $(document).delegate('.wc_close_btn', 'click', function (e) {
        var btn = $(this);
        $('.fas', btn).addClass('fa-pulse fa-spinner');
        var commentId = btn.data('comment');
        var postId = btn.data('post');
        var data = new FormData();
        data.append('action', 'wpdCloseThread');
        data.append('commentId', commentId);
        data.append('postId', postId);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            contentType: false,
            processData: false,
        }).done(function (response) {
            try {
                $('.fas', btn).removeClass('fa-pulse fa-spinner');
                var resp = $.parseJSON(response);
                if (resp.code == 1) {
                    $('.wc_close_text', btn).text(resp.data);
                    $('.fas', btn).removeClass('fa-lock fa-unlock');
                    $('.fas', btn).addClass(resp.icon);
                } else {
                    console.log('Comment not updated');
                }
            } catch (e) {
                console.log(e);
            }
            $('.wpdiscuz-loading-bar').fadeOut(250);
        });
        e.preventDefault();
        return false;
    });

    $(document).delegate('.import-stcr', 'click', function (e) {
        e.preventDefault();
        var btn = $(this);
        btn.attr('disabled', 'disabled');
        $('.fas', btn).addClass('fa-pulse fa-spinner').removeClass('wc-hidden');
        importSTCR(btn);

    });

    function importSTCR(btn) {
        doingAjax = true;
        var data = btn.parents('.wc-form').serialize();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {stcrData: data, 'action': 'wpdImportSTCR'}
        }).done(function (response) {
            try {
                var resp = $.parseJSON(response);
                console.log(resp.progress);
                $('.stcr-step').val(resp.step);

                if (resp.progress < 100) {
                    importSTCR(btn);
                } else {
                    btn.removeAttr('disabled');
                    $('.fas', btn).removeClass('fa-pulse fa-spinner').addClass('wc-hidden');
                }


                if (resp.progress <= 3) {
                    $('.import-progress').text(3 + '%');
                } else {
                    if (resp.progress < 100) {
                        $('.import-progress').text(resp.progress + '%');
                    } else {
                        $('.import-progress').css({'color': '#10b493'});
                        $('.import-progress').text(resp.progress + '% Done');
                        $('.stcr-step').val(0);
                        doingAjax = false;
                    }
                }

            } catch (e) {
                console.log(e);
            }
        });
    }

    $('#wpd-disable-addons').click(function () {
        location.href = $('#wpd-disable-addons-action').val();
    });

    $('#generateAntispamKey').click(function () {
        $('#antispamKey').val(uniqueKey(32));
    });

    function uniqueKey(length) {
        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-=";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }


    $('.hashing-step').val(0);
    $(document).delegate('.update-not-hashed-ips', 'click', function (e) {
        e.preventDefault();
        if ($('.not-hashed-start-id').val() >= 0) {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('.fas', btn).addClass('fa-pulse fa-spinner').removeClass('wc-hidden');
            updateNotHashedIps(btn);
        }

    });

    function updateNotHashedIps(btn) {
        doingAjax = true;
        var data = btn.parents('.wc-form').serialize();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {notHashedData: data, action: 'wpdHashVoteIps'}
        }).done(function (response) {
            try {
                var resp = $.parseJSON(response);
                $('.hashing-step').val(resp.step);
                $('.not-hashed-start-id').val(resp.startId);

                if (resp.progress < 100) {
                    updateNotHashedIps(btn);
                } else {
                    btn.removeAttr('disabled');
                    $('.fas', btn).removeClass('fa-pulse fa-spinner').addClass('wc-hidden');
                }


                if (resp.progress <= 3) {
                    $('.import-progress').text(3 + '%');
                } else {
                    if (resp.progress < 100) {
                        $('.import-progress').text(resp.progress + '%');
                    } else {
                        $('.update-not-hashed-ips').attr('disabled', 'disabled');
                        $('.import-progress').css({'color': '#10b493'});
                        $('.import-progress').text(resp.progress + '% Done');
                        $('.not-hashed-count').val(0);
                        $('.hashing-step').val(0);
                        $('.not-hashed-start-id').val(0);
                        doingAjax = false;
                    }
                }

            } catch (e) {
                console.log(e);
            }
        });
    }

    window.onbeforeunload = confirmExit;
    function confirmExit() {
        if (doingAjax) {
            return "You have attempted to leave this page while background task is running. Are you sure?";
        }
    }


});