<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('Comment List Settings', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins wpdxb" style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width: 50%;">
                    <label for="isLoadOnlyParentComments"><?php _e('Display only parent comments and <u>view replies &or;</u> button', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc">
                        <?php _e('If this option is enabled only parent comment will be displayed. This increases page load speed and keeps pages light. If visitor wants to read replies he/she just need to click on [view replies (12)] button located on all parent comments which have replies.', 'wpdiscuz'); ?>
                    </p>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->isLoadOnlyParentComments == 1) ?> value="1" name="isLoadOnlyParentComments" id="isLoadOnlyParentComments" />
                    <label for="isLoadOnlyParentComments"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#view-replies" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="show_sorting_buttons"><?php _e('Show sorting buttons', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc"><?php _e('This option enables comment sorting buttons (newest | oldest | most voted). Sorting buttons are not available for the default comments pagination type [1][2][3]... It\'s only active for [Load more] and other AYAX pagination types.', 'wpdiscuz'); ?></p>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->showSortingButtons == 1) ?> value="1" name="show_sorting_buttons" id="show_sorting_buttons" />
                    <label for="show_sorting_buttons"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#sorting_buttons" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="mostVotedByDefault"><?php _e('Set comments ordering to "Most voted" by default ', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->mostVotedByDefault == 1) ?> value="1" name="mostVotedByDefault" id="mostVotedByDefault" />
                    <label for="mostVotedByDefault"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#Most_voted_by_default" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="reverseChildren"><?php _e('Reverse child comments order', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->reverseChildren == 1) ?> value="1" name="reverseChildren" id="reverseChildren" />
                    <label for="reverseChildren"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#reverse_child" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label><?php _e('Comments loading/pagination type', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc">
                        <?php _e('You can manage the number of comments for [Load more] option in Settings > Discussion page, using "Break comments into pages with [X] top level comments per page" option. To show the default Wordpress comment pagination you should enable the checkbox on bigining of the same option.', 'wpdiscuz'); ?>
                    </p>
                </th>
                <th>
                    <fieldset>
                        <?php $commentListLoadType = isset($this->optionsSerialized->commentListLoadType) ? $this->optionsSerialized->commentListLoadType : 0; ?>
                        <label title="<?php _e('[Load more] Button', 'wpdiscuz') ?>">
                            <input type="radio" value="0" <?php checked('0' == $commentListLoadType); ?> name="commentListLoadType" id="commentListLoadDefault" class="commentListLoadType"/> 
                            <span><?php _e('[Load more] Button', 'wpdiscuz') ?></span>
                        </label> &nbsp;<br/>
                        <label title="<?php _e('[Load rest of all comments] Button', 'wpdiscuz') ?>">
                            <input type="radio" value="1" <?php checked('1' == $commentListLoadType); ?> name="commentListLoadType" id="commentListLoadRest" class="commentListLoadType" /> 
                            <span><?php _e('[Load rest of all comments] Button', 'wpdiscuz') ?></span>
                        </label><br>
                        <label title="<?php _e('Load all comments', 'wpdiscuz') ?>">
                            <input type="radio" value="3" <?php checked('3' == $commentListLoadType); ?> name="commentListLoadType" id="commentListLoadAll" class="commentListLoadType" /> 
                            <span><?php _e('Load all comments', 'wpdiscuz') ?></span>
                        </label> &nbsp;<br/>
                        <label title="<?php _e('Lazy load comments on scrolling', 'wpdiscuz') ?>">
                            <input type="radio" value="2" <?php checked('2' == $commentListLoadType); ?> name="commentListLoadType" id="commentListLoadLazy" class="commentListLoadType commentListLoadLazy" /> 
                            <span><?php _e('Lazy load comments on scrolling', 'wpdiscuz') ?></span>
                        </label> &nbsp;<br/>
                    </fieldset>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#pagination" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>    
            <tr valign="top">
                <th scope="row">
                    <label for="commentWordsLimit"><?php _e('The number of words before breaking comment text and showing "Read more" link', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc">
                        <?php _e('Set this option value 0, to turn off comment text breaking function.', 'wpdiscuz'); ?>
                    </p>
                </th>
                <td>
                    <input type="number" value="<?php echo isset($this->optionsSerialized->commentReadMoreLimit) ? $this->optionsSerialized->commentReadMoreLimit : 100; ?>" name="commentWordsLimit" id="commentWordsLimit" style="width:100px;" />
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#read_more_link" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="show_sorting_buttons"><?php _e('Comment components', 'wpdiscuz'); ?></label>
                </th>
                <th>
                    <fieldset>
                        <div class="wpd-subopt">
                            <input type="checkbox" <?php checked($this->optionsSerialized->showHideCommentLink == 1) ?> value="1" name="showHideCommentLink" id="showHideCommentLink" /> <label for="showHideCommentLink"><?php _e('Hide comment link', 'wpdiscuz'); ?></label>
                        </div>
                        <div class="wpd-subopt">
                            <input type="checkbox" <?php checked($this->optionsSerialized->hideCommentDate == 1) ?> value="1" name="hideCommentDate" id="hideCommentDate" /> <label for="hideCommentDate"><?php _e('Hide comment date', 'wpdiscuz'); ?></label>
                        </div>
                        <div class="wpd-subopt">
                            <input type="checkbox" <?php checked($this->optionsSerialized->authorTitlesShowHide == 1) ?> value="1" name="wc_author_titles_show_hide" id="wc_author_titles_show_hide" /> <label for="wc_author_titles_show_hide"><?php _e('Hide Commenter Labels', 'wpdiscuz'); ?></label>
                        </div>
                        <div style="clear: both;"></div>
                    </fieldset>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#components" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label><?php _e('Hide Voting buttons', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->votingButtonsShowHide == 1) ?> value="1" name="wc_voting_buttons_show_hide" id="wc_voting_buttons_show_hide" /> <label for="wc_voting_buttons_show_hide"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#liking_buttons" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    &nbsp;<?php _e('Comment voting buttons icon', 'wpdiscuz'); ?>
                </th>
                <th>
                    <div class="wpd-switch-field">
                        <input type="radio" <?php checked($this->optionsSerialized->votingButtonsIcon == 'fa-plus|fa-minus') ?> value="fa-plus|fa-minus" name="votingButtonsIcon" id="votingButtonsIconPlusMinus" class="votingButtonsIconPlusMinus" style="vertical-align: bottom;"/>
                        <label for="votingButtonsIconPlusMinus" style="min-width:60px;">
                            <i class="fas fa-plus"></i> <i class="fas fa-minus"></i></label>
                        <input type="radio" <?php checked($this->optionsSerialized->votingButtonsIcon == 'fa-chevron-up|fa-chevron-down') ?> value="fa-chevron-up|fa-chevron-down" name="votingButtonsIcon" id="votingButtonsIconChevronUpDown" class="votingButtonsIconChevronUpDown" style="vertical-align: bottom;"/>
                        <label for="votingButtonsIconChevronUpDown" style="min-width:60px;"><i class="fas fa-chevron-up"></i> <i class="fas fa-chevron-down"></i></label>
                        <input type="radio" <?php checked($this->optionsSerialized->votingButtonsIcon == 'fa-thumbs-up|fa-thumbs-down') ?> value="fa-thumbs-up|fa-thumbs-down" name="votingButtonsIcon" id="votingButtonsIconThumbsUpDown" class="votingButtonsIconThumbsUpDown" style="vertical-align: bottom;"/>
                        <label for="votingButtonsIconThumbsUpDown" style="min-width:60px;"><i class="fas fa-thumbs-up"></i> <i class="fas fa-thumbs-down"></i></label>
                        <input type="radio" <?php checked($this->optionsSerialized->votingButtonsIcon == 'fa-smile|fa-frown') ?> value="fa-smile|fa-frown" name="votingButtonsIcon" id="votingButtonsIconSmileFrown" class="votingButtonsIconSmileFrown" style="vertical-align: bottom;"/>
                        <label for="votingButtonsIconSmileFrown" style="min-width:60px;"><i class="far fa-smile"></i> <i class="far fa-frown"></i></label>  
                    </div>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#liking_buttons" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row">
                    &nbsp;<?php _e('Comment voting statistic mode', 'wpdiscuz'); ?>
                </th>
                <th>
                    <div class="wpd-switch-field">
                        <input type="radio" <?php checked($this->optionsSerialized->votingButtonsStyle == 0) ?> value="0" name="votingButtonsStyle" id="votingButtonsStyleTotal" class="votingButtonsStyle"/><label for="votingButtonsStyleTotal"><?php _e('total count', 'wpdiscuz'); ?></label> &nbsp;
                        <input type="radio" <?php checked($this->optionsSerialized->votingButtonsStyle == 1) ?> value="1" name="votingButtonsStyle" id="votingButtonsStyleSeparate" class="votingButtonsStyle"/><label for="votingButtonsStyleSeparate"><?php _e('separate count', 'wpdiscuz'); ?></label>
                    </div>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#liking_buttons" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row" style="padding: 7px 0px;">
                    <label style="font-weight: normal; margin: 0px;" for="wc_is_guest_can_vote">&nbsp;&nbsp;<?php _e('Allow guests to vote on comments', 'wpdiscuz'); ?></label>
                </th>
                <td style="padding: 7px 5px;">
                    <input type="checkbox" <?php checked($this->optionsSerialized->isGuestCanVote == 1) ?> value="1" name="wc_is_guest_can_vote" id="wc_is_guest_can_vote" />
                    <label for="wc_is_guest_can_vote" ></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#liking_buttons" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label><?php _e('Display Ratings', 'wpdiscuz'); ?></label>
                </th>
                <th>
                    <fieldset>
                        <input type="checkbox" <?php checked(in_array('before', $this->optionsSerialized->displayRatingOnPost)) ?> value="before" name="displayRatingOnPost[]" id="displayRatingOnPostBefore" />
                        <label for="displayRatingOnPostBefore"><?php _e('Before Content', 'wpdiscuz'); ?></label> &nbsp;&nbsp;
                        <input type="checkbox" <?php checked(in_array('after', $this->optionsSerialized->displayRatingOnPost)) ?> value="after" name="displayRatingOnPost[]" id="displayRatingOnPostAfter" />
                        <label for="displayRatingOnPostAfter"><?php _e('After Content', 'wpdiscuz'); ?></label><br>
                        <input type="checkbox" <?php checked($this->optionsSerialized->ratingCssOnNoneSingular == 1) ?> value="1" name="ratingCssOnNoneSingular" id="ratingCssOnNoneSingular" /> <label for="ratingCssOnNoneSingular"><?php _e('Display ratings on none singular pages', 'wpdiscuz'); ?></label>
                    </fieldset>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#display_ratings" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="disableProfileURLs"><?php _e('Disable Profiles URL', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->disableProfileURLs == 1) ?> value="1" name="disableProfileURLs" id="disableProfileURLs" />
                    <label for="disableProfileURLs"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-list-settings/#disable_profiles_URL" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>

        </tbody>
    </table>
</div>