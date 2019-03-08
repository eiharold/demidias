<?php

class WpdiscuzDBManager implements WpDiscuzConstants {

    private $db;
    private $dbprefix;
    private $users_voted;
    private $phrases;
    private $emailNotification;
    private $avatarsCache;
    private $followUsers;
    public $isMySQL57;
    public $isShowLoadMore = false;

    function __construct() {
        $this->initDB();
    }

    private function initDB() {
        global $wpdb;
        $this->db = $wpdb;
        $this->dbprefix = $wpdb->prefix;
        $this->users_voted = $this->dbprefix . 'wc_users_voted';
        $this->phrases = $this->dbprefix . 'wc_phrases';
        $this->emailNotification = $this->dbprefix . 'wc_comments_subscription';
        $this->avatarsCache = $this->dbprefix . 'wc_avatars_cache';
        $this->followUsers = $this->dbprefix . 'wc_follow_users';
        $this->isMySQL57 = version_compare($this->db->db_version(), '5.7', '>=') ? true : false;
    }

    /**
     * check if table exists in database
     * return true if exists false otherwise
     */
    public function isTableExists($tableName) {
        return $this->db->get_var("SHOW TABLES LIKE '$tableName'");
    }

    /**
     * create table in db on activation if not exists
     */
    public function dbCreateTables() {
        $this->initDB();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE `{$this->users_voted}`(`id` INT(11) NOT NULL AUTO_INCREMENT,`user_id` VARCHAR(255) NOT NULL, `comment_id` INT(11) NOT NULL, `vote_type` INT(11) DEFAULT NULL, `is_guest` TINYINT(1) DEFAULT 0, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), KEY `comment_id` (`comment_id`),  KEY `vote_type` (`vote_type`), KEY `is_guest` (`is_guest`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        maybe_create_table($this->users_voted, $sql);

        $sql = "CREATE TABLE `{$this->phrases}`(`id` INT(11) NOT NULL AUTO_INCREMENT, `phrase_key` VARCHAR(255) NOT NULL, `phrase_value` TEXT NOT NULL, PRIMARY KEY (`id`), KEY `phrase_key` (`phrase_key`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        maybe_create_table($this->phrases, $sql);

        $sql = "CREATE TABLE `{$this->emailNotification}`(`id` INT(11) NOT NULL AUTO_INCREMENT, `email` VARCHAR(255) NOT NULL, `subscribtion_id` INT(11) NOT NULL, `post_id` INT(11) NOT NULL, `subscribtion_type` VARCHAR(255) NOT NULL, `activation_key` VARCHAR(255) NOT NULL, `confirm` TINYINT DEFAULT 0, `subscription_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `subscribtion_id` (`subscribtion_id`), KEY `post_id` (`post_id`), KEY `confirm`(`confirm`), UNIQUE KEY `subscribe_unique_index` (`subscribtion_id`,`email`,`post_id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        maybe_create_table($this->emailNotification, $sql);

        $sql = "CREATE TABLE `{$this->avatarsCache}`(`id` INT(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT 0, `user_email` VARCHAR(255) NOT NULL, `url` VARCHAR(255) NOT NULL, `hash` VARCHAR(255) NOT NULL, `maketime` INT(11) NOT NULL DEFAULT 0, `cached` TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), UNIQUE KEY `user_email` (`user_email`), KEY `url` (`url`), KEY `hash` (`hash`), KEY `maketime` (`maketime`), KEY `cached` (`cached`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        maybe_create_table($this->avatarsCache, $sql);

        $sql = "CREATE TABLE `{$this->followUsers}` (`id` int(11) NOT NULL AUTO_INCREMENT, `post_id` int(11) NOT NULL DEFAULT '0', `user_id` int(11) NOT NULL DEFAULT '0', `user_email` varchar(125) NOT NULL, `user_name` varchar(255) NOT NULL, `follower_id` int(11) NOT NULL DEFAULT '0', `follower_email` varchar(125) NOT NULL, `follower_name` varchar(255) NOT NULL, `activation_key` varchar(32) NOT NULL, `confirm` tinyint(1) NOT NULL DEFAULT '0', `follow_timestamp` int(11) NOT NULL, `follow_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `post_id` (`post_id`), KEY `user_id` (`user_id`), KEY `user_email` (`user_email`), KEY `follower_id` (`follower_id`), KEY `follower_email` (`follower_email`), KEY `confirm` (`confirm`), KEY `follow_timestamp` (`follow_timestamp`), UNIQUE KEY `follow_unique_key` (`user_email`, `follower_email`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
        maybe_create_table($this->followUsers, $sql);
    }

    /**
     * creates subscription table if not exists 
     */
    public function createEmailNotificationTable() {
        $this->initDB();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE `{$this->emailNotification}`(`id` INT(11) NOT NULL AUTO_INCREMENT, `email` VARCHAR(255) NOT NULL, `subscribtion_id` INT(11) NOT NULL, `post_id` INT(11) NOT NULL, `subscribtion_type` VARCHAR(255) NOT NULL, `activation_key` VARCHAR(255) NOT NULL, `confirm` TINYINT DEFAULT 0, `subscription_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `subscribtion_id` (`subscribtion_id`), KEY `post_id` (`post_id`), KEY `confirm`(`confirm`), UNIQUE KEY `subscribe_unique_index` (`subscribtion_id`,`email`,`post_id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        maybe_create_table($this->emailNotification, $sql);
    }

    public function createAvatarsCacheTable() {
        $this->initDB();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE `{$this->avatarsCache}`(`id` INT(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT 0, `user_email` VARCHAR(255) NOT NULL, `url` VARCHAR(255) NOT NULL, `hash` VARCHAR(255) NOT NULL, `maketime` INT(11) NOT NULL DEFAULT 0, `cached` TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), UNIQUE KEY `user_email` (`user_email`), KEY `url` (`url`), KEY `hash` (`hash`), KEY `maketime` (`maketime`), KEY `cached` (`cached`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        maybe_create_table($this->avatarsCache, $sql);
    }

    public function createFollowUsersTable() {
        $this->initDB();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE `{$this->followUsers}` (`id` int(11) NOT NULL AUTO_INCREMENT, `post_id` int(11) NOT NULL DEFAULT '0', `user_id` int(11) NOT NULL DEFAULT '0', `user_email` varchar(125) NOT NULL, `user_name` varchar(255) NOT NULL, `follower_id` int(11) NOT NULL DEFAULT '0', `follower_email` varchar(125) NOT NULL, `follower_name` varchar(255) NOT NULL, `activation_key` varchar(32) NOT NULL, `confirm` tinyint(1) NOT NULL DEFAULT '0', `follow_timestamp` int(11) NOT NULL, `follow_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `post_id` (`post_id`), KEY `user_id` (`user_id`), KEY `user_email` (`user_email`), KEY `follower_id` (`follower_id`), KEY `follower_email` (`follower_email`), KEY `confirm` (`confirm`), KEY `follow_timestamp` (`follow_timestamp`), UNIQUE KEY `follow_unique_key` (`user_email`, `follower_email`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
        maybe_create_table($this->followUsers, $sql);
    }

    /**
     * add vote type
     */
    public function addVoteType($userId, $commentId, $voteType, $isUserLoggedIn) {
        $sql = $this->db->prepare("INSERT INTO `" . $this->users_voted . "`(`user_id`, `comment_id`, `vote_type`,`is_guest`)VALUES(%s,%d,%d,%d);", $userId, $commentId, $voteType, !$isUserLoggedIn);
        return $this->db->query($sql);
    }

    /**
     * update vote type
     */
    public function updateVoteType($user_id, $comment_id, $vote_type) {
        $sql = $this->db->prepare("UPDATE `" . $this->users_voted . "` SET `vote_type` = %d WHERE `user_id` = %s AND `comment_id` = %d", $vote_type, $user_id, $comment_id);
        return $this->db->query($sql);
    }

    /**
     * check if the user is already voted on comment or not by user id and comment id
     */
    public function isUserVoted($user_id, $comment_id) {
        $sql = $this->db->prepare("SELECT `vote_type` FROM `" . $this->users_voted . "` WHERE `user_id` = %s AND `comment_id` = %d;", $user_id, $comment_id);
        return $this->db->get_var($sql);
    }

    /**
     * update phrases
     */
    public function deletePhrases() {
        if ($this->isTableExists($this->phrases)) {
            return $this->db->query("TRUNCATE `{$this->phrases}`");
        }
    }

    /**
     * update phrases
     */
    public function updatePhrases($phrases) {
        if ($phrases) {
            foreach ($phrases as $key => $value) {
                $value = stripslashes($value);
                if ($this->isPhraseExists($key)) {
                    $sql = $this->db->prepare("UPDATE `" . $this->phrases . "` SET `phrase_value` = %s WHERE `phrase_key` = %s;", $value, $key);
                } else {
                    $sql = $this->db->prepare("INSERT INTO `" . $this->phrases . "`(`phrase_key`, `phrase_value`)VALUES(%s, %s);", $key, $value);
                }
                $this->db->query($sql);
            }
        }
    }

    /**
     * checks if the phrase key exists in database
     */
    public function isPhraseExists($phrase_key) {
        $sql = $this->db->prepare("SELECT `phrase_key` FROM `" . $this->phrases . "` WHERE `phrase_key` LIKE %s", $phrase_key);
        return $this->db->get_var($sql);
    }

    /**
     * get phrases from db
     */
    public function getPhrases() {
        $sql = "SELECT `phrase_key`, `phrase_value` FROM `" . $this->phrases . "`;";
        $phrases = $this->db->get_results($sql, ARRAY_A);
        $tmp_phrases = array();
        foreach ($phrases as $phrase) {
            $tmp_phrases[$phrase['phrase_key']] = $phrase['phrase_value'];
        }
        return $tmp_phrases;
    }

    /**
     * get last comment id from database
     * current post last comment id if post id was passed
     */
    public function getLastCommentId($args) {
        if ($args['post_id']) {
            $approved = '';
            if ($args['status'] != 'all') {
                $approved = " AND `comment_approved` = '1' ";
            }
            $sql = $this->db->prepare("SELECT MAX(`comment_ID`) FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d " . $approved . ";", $args['post_id']);
        } else {
            $sql = "SELECT MAX(`comment_ID`) FROM `" . $this->dbprefix . "comments`;";
        }
        return $this->db->get_var($sql);
    }

    /**
     * retrives new comment ids for live update (UA - Update Automatically)
     */
    public function getNewCommentIds($args, $loadLastCommentId, $email) {
        $approved = '';
        if ($args['status'] != 'all') {
            $approved = " AND `comment_approved` = '1' ";
        }
        $sqlCommentIds = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d AND `comment_ID` > %d AND `comment_author_email` != %s " . $approved . " ORDER BY `comment_date_gmt` ASC;", $args['post_id'], $loadLastCommentId, $email);
        return $this->db->get_col($sqlCommentIds);
    }

    /**
     * @param type $visibleCommentIds comment ids which is visible at the moment on front end
     * @param type $email the current user email
     * @return type array of author comment ids
     */
    public function getAuthorVisibleComments($args, $visibleCommentIds, $email) {
        $sql = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_approved` = '1' AND `comment_ID` IN($visibleCommentIds) AND `comment_author_email` = %s;", $email);
        return $this->db->get_col($sql);
    }

    public function getParentCommentsHavingReplies($postId) {
        $sql = $this->db->prepare("SELECT `c1`.`comment_ID` FROM `{$this->db->comments}` AS `c1` INNER JOIN  `{$this->db->comments}` AS `c2` ON `c1`.`comment_post_ID` = `c2`.`comment_post_ID` AND `c2`.`comment_parent` = `c1`.`comment_ID` WHERE `c1`.`comment_post_ID` = %d AND `c1`.`comment_parent` = 0 GROUP BY `c1`.`comment_ID` ORDER BY `c1`.`comment_date_gmt` DESC, `c1`.`comment_ID` DESC;", $postId);
        $data = $this->db->get_col($sql);
        return $data;
    }

    /**
     * get current post  parent comments by wordpress settings
     */
    public function getPostParentComments($args) {
        $commentParent = $args['is_threaded'] ? 'AND `comment_parent` = 0' : '';
        $typesNotIn = $this->getNotInCommentTypes($args);
        $condition = $this->getParentCommentsClauses($args);
        $limit = "";
        if (!$this->isMySQL57) {
            $limit = " LIMIT " . ($args['limit'] + 1);
        }
        if ($args['limit'] == 0) {
            $allParentCounts = count($this->getAllParentCommentCount($args['post_id'], $args['is_threaded']));
            $sqlComments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d  $condition $commentParent $typesNotIn ORDER BY `comment_date_gmt` {$args['order']} LIMIT %d OFFSET %d", $args['post_id'], $allParentCounts, $args['offset']);
        } else if ($args['last_parent_id']) {
            $operator = ($args['order'] == 'asc') ? '>' : '<';
            $sqlComments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d  $condition $commentParent $typesNotIn AND `comment_ID` $operator %d ORDER BY `comment_date_gmt` {$args['order']}, comment_ID {$args['order']} $limit", $args['post_id'], $args['last_parent_id']);
        } else {
            $sqlComments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d  $condition $commentParent $typesNotIn ORDER BY `comment_date_gmt` {$args['order']}, comment_ID {$args['order']} $limit", $args['post_id']);
        }
        $data = $this->db->get_col($sqlComments);
        if (isset($args['limit']) && $args['limit'] != 0) {
            if ($this->isMySQL57) {
                $data = array_slice($data, 0, $args['limit'] + 1);
            }
            if (count($data) > $args['limit']) {
                $data = array_slice($data, 0, $args['limit']);
                $this->isShowLoadMore = true;
            }
        }
        return $data;
    }

    /**
     * get comment list ordered by date or comments votes
     */
    public function getCommentList($args) {
        if ($args['orderby'] == 'by_vote') {
            $parentIds = $this->getPostVotedCommentIds($args);
        } else {
            $parentIds = $this->getPostParentComments($args);
        }
        return $parentIds;
    }

    /**
     * get post most voted comments
     * @param type $args['post_id'] the current post id
     * @param type $args['order'] data ordering asc / desc
     * @param type $args['limit'] how many rows select
     * @param type $args['offset'] rows offset
     * @return type array of comments
     */
    public function getPostVotedCommentIds($args) {
        $commentParent = $args['is_threaded'] ? 'AND `c`.`comment_parent` = 0' : '';
        $typesNotIn = $this->getNotInCommentTypes($args, '`c`.');
        $condition = $this->getParentCommentsClauses($args, '`c`.');
        if ($args['limit']) {
            $sqlPostVotedCommentIds = $this->db->prepare("SELECT `c`.`comment_ID` FROM `" . $this->dbprefix . "comments` AS `c` LEFT JOIN `" . $this->dbprefix . "commentmeta` AS `cm` ON `c`.`comment_ID` = `cm`.`comment_id` AND `cm`.`meta_key` = '" . self::META_KEY_VOTES . "'  WHERE  `c`.`comment_post_ID` = %d  $condition $commentParent $typesNotIn ORDER BY (`cm`.`meta_value`+0) desc, `c`.`comment_date_gmt` {$args['date_order']} LIMIT %d OFFSET %d", $args['post_id'], $args['limit'] + 1, $args['offset']);
        } else {
            $allParentCounts = count($this->getAllParentCommentCount($args['post_id'], $args['is_threaded']));
            $sqlPostVotedCommentIds = $this->db->prepare("SELECT `c`.`comment_ID` FROM `" . $this->dbprefix . "comments` AS `c` LEFT JOIN `" . $this->dbprefix . "commentmeta` AS `cm` ON `c`.`comment_ID` = `cm`.`comment_id` AND `cm`.`meta_key` = '" . self::META_KEY_VOTES . "'  WHERE  `c`.`comment_post_ID` = %d  $condition $commentParent $typesNotIn ORDER BY (`cm`.`meta_value`+0) desc, `c`.`comment_date_gmt` {$args['date_order']} LIMIT %d OFFSET %d", $args['post_id'], $allParentCounts, $args['offset']);
        }
        $data = $this->db->get_col($sqlPostVotedCommentIds);
        if (isset($args['limit']) && $args['limit'] != 0 && count($data) > $args['limit']) {
            $data = array_slice($data, 0, $args['limit']);
            $this->isShowLoadMore = true;
        }
        return $data;
    }

    public function getAllParentCommentCount($postId = 0, $isThreaded = 1) {
        $commentParent = $isThreaded ? '`comment_parent` = 0' : '1';
        if ($postId) {
            $sql_comments = $this->db->prepare("SELECT `comment_ID` FROM  `" . $this->dbprefix . "comments` WHERE $commentParent AND `comment_post_ID` = %d AND `comment_approved` = '1'", $postId);
        } else {
            $sql_comments = "SELECT `comment_ID` FROM  `" . $this->dbprefix . "comments` WHERE $commentParent";
        }
        return $this->db->get_col($sql_comments);
    }

    /**
     * get first level comments by parent comment id
     */
    public function getCommentsByParentId($commentId) {
        $sql_comments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_parent` = %d AND `comment_approved` = '1';", $commentId);
        return $this->db->get_col($sql_comments);
    }

    public function addEmailNotification($subsriptionId, $postId, $email, $subscriptionType, $confirm = 0) {
        if ($subscriptionType != self::SUBSCRIPTION_COMMENT) {
            $this->deleteCommentNotifications($subsriptionId, $email);
        }
        $activationKey = md5($email . uniqid() . time());
        $sql = $this->db->prepare("INSERT INTO `" . $this->emailNotification . "` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`,`confirm`) VALUES(%s, %d, %d, %s, %s, %d);", $email, $subsriptionId, $postId, $subscriptionType, $activationKey, $confirm);
        $this->db->query($sql);
        return $this->db->insert_id ? array('id' => $this->db->insert_id, 'activation_key' => $activationKey) : false;
    }

    public function getPostNewCommentNotification($post_id, $email) {
        $sql = $this->db->prepare("SELECT `id`, `email`, `activation_key` FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` = %s AND `confirm` = 1 AND `post_id` = %d  AND `email` != %s;", self::SUBSCRIPTION_POST, $post_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getAllNewCommentNotification($post_id, $email) {
        $sql = $this->db->prepare("SELECT `id`, `email`, `activation_key` FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` = %s AND `confirm` = 1 AND `post_id` = %d  AND `email` != %s;", self::SUBSCRIPTION_ALL_COMMENT, $post_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getNewReplyNotification($comment_id, $email) {
        $sql = $this->db->prepare("SELECT `id`, `email`, `activation_key` FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` = %s AND `confirm` = 1 AND `subscribtion_id` = %d  AND `email` != %s;", self::SUBSCRIPTION_COMMENT, $comment_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function hasSubscription($postId, $email) {
        $sql = $this->db->prepare("SELECT `subscribtion_type` as `type`, `confirm` FROM `" . $this->emailNotification . "` WHERE  `post_id` = %d AND `email` = %s;", $postId, $email);
        $result = $this->db->get_row($sql, ARRAY_A);
        return $result;
    }

    public function hasConfirmedSubscription($email) {
        $sql = "SELECT `subscribtion_type` as `type` FROM `" . $this->emailNotification . "` WHERE `email` = %s AND `confirm` = 1;";
        $sql = $this->db->prepare($sql, $email);
        return $this->db->get_var($sql);
    }

    public function hasConfirmedSubscriptionByID($subscribeID) {
        $sql = "SELECT `subscribtion_type` as `type` FROM `" . $this->emailNotification . "` WHERE `id` = %d AND `confirm` = 1;";
        $sql = $this->db->prepare($sql, $subscribeID);
        return $this->db->get_var($sql);
    }

    /**
     * delete comment thread subscriptions if new subscription type is post
     */
    public function deleteCommentNotifications($post_id, $email) {
        $sql = $this->db->prepare("DELETE FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` != %s AND `post_id` = %d AND `email` LIKE %s;", self::SUBSCRIPTION_POST, $post_id, $email);
        $this->db->query($sql);
    }

    /**
     * create unsubscribe link
     */
    public function unsubscribeLink($postID, $email) {
        global $wp_rewrite;
        $sql_subscriber_data = $this->db->prepare("SELECT `id`, `post_id`, `activation_key` FROM `" . $this->emailNotification . "` WHERE  `post_id` = %d  AND `email` LIKE %s", $postID, $email);
        $wc_unsubscribe = $this->db->get_row($sql_subscriber_data, ARRAY_A);
        $post_id = $wc_unsubscribe['post_id'];
        $wc_unsubscribe_link = !$wp_rewrite->using_permalinks() ? get_permalink($post_id) . "&" : get_permalink($post_id) . "?";
        $wc_unsubscribe_link .= "wpdiscuzUrlAnchor&wpdiscuzSubscribeID=" . $wc_unsubscribe['id'] . "&key=" . $wc_unsubscribe['activation_key'] . '&#wc_unsubscribe_message';
        return $wc_unsubscribe_link;
    }

    /**
     * generate confirm link
     */
    public function confirmLink($id, $activationKey, $postID) {
        global $wp_rewrite;
        $wc_confirm_link = !$wp_rewrite->using_permalinks() ? get_permalink($postID) . "&" : get_permalink($postID) . "?";
        $wc_confirm_link .= "wpdiscuzUrlAnchor&wpdiscuzConfirmID=$id&wpdiscuzConfirmKey=$activationKey&wpDiscuzComfirm=yes&#wc_unsubscribe_message";
        return $wc_confirm_link;
    }

    /**
     * Confirm  post or comment subscription
     */
    public function notificationConfirm($subscribe_id, $key) {
        $sql_confirm = $this->db->prepare("UPDATE `" . $this->emailNotification . "` SET `confirm` = 1 WHERE `id` = %d AND `activation_key` LIKE %s;", $subscribe_id, $key);
        return $this->db->query($sql_confirm);
    }

    /**
     * delete subscription
     */
    public function unsubscribe($id, $activation_key) {
        $sql_unsubscribe = $this->db->prepare("DELETE FROM `" . $this->emailNotification . "` WHERE `id` = %d AND `activation_key` LIKE %s", $id, $activation_key);
        return $this->db->query($sql_unsubscribe);
    }

    public function alterPhrasesTable() {
        $sql_alter = "ALTER TABLE `" . $this->phrases . "` MODIFY `phrase_value` TEXT NOT NULL;";
        $this->db->query($sql_alter);
    }

    public function alterVotingTable() {
        $sql_alter = "ALTER TABLE `" . $this->users_voted . "` MODIFY `user_id` VARCHAR(255) NOT NULL, ADD COLUMN `is_guest` TINYINT(1) DEFAULT 0, ADD INDEX `is_guest` (`is_guest`);";
        $this->db->query($sql_alter);
    }

    public function alterNotificationTable($version) {
        if (version_compare($version, '5.0.5', '<=') && version_compare($version, '1.0.0', '!=')) {
            $sql_alter = "ALTER TABLE `" . $this->emailNotification . "` DROP INDEX subscribe_unique_index, ADD UNIQUE KEY `subscribe_unique_index` (`subscribtion_id`,`email`, `post_id`);";
            $this->db->query($sql_alter);
        }
    }

    /**
     * return users id who have published posts
     */
    public function getPostsAuthors() {
        if (($postsAuthors = get_transient(self::TRS_POSTS_AUTHORS)) === false) {
            $sql = "SELECT `post_author` FROM `" . $this->dbprefix . "posts` WHERE `post_type` = 'post' AND `post_status` IN ('publish', 'private') GROUP BY `post_author`;";
            $postsAuthors = $this->db->get_col($sql);
            set_transient(self::TRS_POSTS_AUTHORS, $postsAuthors, 6 * HOUR_IN_SECONDS);
        }
        return $postsAuthors;
    }

    public function removeVotes() {
        $sqlTruncate = "TRUNCATE `{$this->users_voted}`;";
        $sqlDelete = "DELETE FROM `" . $this->dbprefix . "commentmeta` WHERE `meta_key` = '" . self::META_KEY_VOTES . "';";
        return $this->db->query($sqlTruncate) && $this->db->query($sqlDelete);
    }

    private function getParentCommentsClauses($args, $alias = '') {
        $s = ' AND ';
        $status = $args['status'];
        if ($status == 'all') {
            $s .= "($alias`comment_approved` = '0' OR $alias`comment_approved` = '1')";
        } else if ($status == 'hold') {
            $s .= "($alias`comment_approved` = '0')";
        } else {
            $condition = ' ';
            if (isset($args['include_unapproved']) && is_int($args['include_unapproved'][0])) {
                $condition .= " OR ($alias`comment_approved` = '0' AND $alias`user_id` = {$args['include_unapproved'][0] })";
            } elseif (isset($args['include_unapproved']) && $args['include_unapproved'][0]) {
                $condition .= " OR ($alias`comment_approved` = '0' AND $alias`comment_author_email` = '{$args['include_unapproved'][0]}')";
            }
            $s .= "($alias`comment_approved` = '1' $condition )";
        }
        return apply_filters('wpdiscuz_parent_comments_clauses', $s);
    }

    private function getNotInCommentTypes($args, $alias = '') {
        $commentTypesNotIn = array();
        $types = '';
        if (isset($args['type__not_in']) && is_array($args['type__not_in'])) {
            foreach ($args['type__not_in'] as $type) {
                $commentTypesNotIn[] = $this->db->prepare('%s', $type);
            }
            $types = implode(',', $commentTypesNotIn);
        }
        $typesNotIn = $types ? "AND $alias`comment_type` NOT IN ($types)" : "";
        return $typesNotIn;
    }

    public function getVotes($commentId) {
        $sql = "SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = 1 AND `comment_id` = %d UNION SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = -1 AND `comment_id` = %d";
        $sql = $this->db->prepare($sql, $commentId, $commentId);
        return $this->db->get_col($sql);
    }

    public function getLikeCount($commentId) {
        $sql = "SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = 1 AND `comment_id` = %d ";
        $sql = $this->db->prepare($sql, $commentId);
        return $this->db->get_var($sql);
    }

    public function getDislikeCount($commentId) {
        $sql = "SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = -1 AND `comment_id` = %d";
        $sql = $this->db->prepare($sql, $commentId);
        return $this->db->get_var($sql);
    }

    /* MULTI SITE */

    public function getBlogID() {
        return $this->db->blogid;
    }

    public function getBlogIDs() {
        return $this->db->get_col("SELECT blog_id FROM {$this->db->blogs}");
    }

    public function dropTables() {
        $this->initDB();
        $this->db->query("DROP TABLE IF EXISTS `{$this->emailNotification}`");
        $this->db->query("DROP TABLE IF EXISTS `{$this->phrases}`");
        $this->db->query("DROP TABLE IF EXISTS `{$this->users_voted}`");
        $this->db->query("DROP TABLE IF EXISTS `{$this->avatarsCache}`");
    }

    public function deleteSubscriptions($commnetId) {
        if ($cId = intval($commnetId)) {
            $sql = $this->db->prepare("DELETE FROM `{$this->emailNotification}` WHERE `subscribtion_id` = %d;", $cId);
            $this->db->query($sql);
        }
    }

    public function deleteVotes($commnetId) {
        if ($cId = intval($commnetId)) {
            $sql = $this->db->prepare("DELETE FROM `{$this->users_voted}` WHERE `comment_id` = %d;", $cId);
            $this->db->query($sql);
        }
    }

    /* === GRAVATARS CACHE === */

    public function addGravatars($gravatarsData) {
        if ($gravatarsData && is_array($gravatarsData)) {
            $sql = "INSERT INTO `{$this->avatarsCache}`(`user_id`, `user_email`, `url`, `hash`, `maketime`, `cached`) VALUES";
            $sqlValues = '';
            $makeTime = current_time('timestamp');
            foreach ($gravatarsData as $gravatarData) {
                $userId = intval($gravatarData['user_id']);
                $userEmail = str_rot13(trim($gravatarData['user_email']));
                $url = trim($gravatarData['url']);
                $hash = trim($gravatarData['hash']);
                $cached = intval($gravatarData['cached']);
                $sqlValues .= "($userId, '$userEmail', '$url', '$hash', '$makeTime', $cached),";
            }
            $sql .= rtrim($sqlValues, ',');
            $sql .= "ON DUPLICATE KEY UPDATE `user_id` = `user_id`, `user_email` = `user_email`, `url` = `url`, `hash` = `hash`, `maketime` = `maketime`, `cached` = `cached`;";
            $this->db->query($sql);
        }
    }

    public function getGravatars($limit = 10) {
        $data = array();
        $limit = apply_filters('wpdiscuz_gravatars_cache_limit', $limit);
        if ($l = intval($limit)) {
            $sql = $this->db->prepare("SELECT * FROM `{$this->avatarsCache}` WHERE `cached` = 0 LIMIT %d;", $l);
            $data = $this->db->get_results($sql, ARRAY_A);
        }
        return $data;
    }

    public function getExpiredGravatars($timeFrame) {
        $data = array();
        if ($timeFrame) {
            $currentTime = current_time('timestamp');
            $sql = $this->db->prepare("SELECT CONCAT(`hash`, '.gif') FROM `{$this->avatarsCache}` WHERE `maketime` + %d < %d", $timeFrame, $currentTime);
            $data = $this->db->get_col($sql);
        }
        return $data;
    }

    public function deleteExpiredGravatars($timeFrame) {
        if ($timeFrame) {
            $currentTime = current_time('timestamp');
            $sql = $this->db->prepare("DELETE FROM `{$this->avatarsCache}` WHERE `maketime` + %d < %d;", $timeFrame, $currentTime);
            $this->db->query($sql);
        }
    }

    public function deleteGravatars() {
        $this->db->query("TRUNCATE `{$this->avatarsCache}`;");
    }

    public function updateGravatarsStatus($cachedIds) {
        if ($cachedIds) {
            $makeTime = current_time('timestamp');
            $ids = implode(',', $cachedIds);
            $sql = "UPDATE `{$this->avatarsCache}` SET `maketime` = $makeTime, `cached` = 1 WHERE `id` IN ($ids);";
            $this->db->query($sql);
        }
    }

    /* === GRAVATARS CACHE === */

    /* === STCR SUBSCRIPTIONS === */

    public function getStcrAllSubscriptions() {
        $sql = "SELECT COUNT(*) FROM `{$this->dbprefix}postmeta` WHERE meta_key LIKE '%_stcr@%' AND SUBSTRING(meta_value, 21) IN ('Y', 'R');";
        return $this->db->get_var($sql);
    }

    public function getStcrSubscriptions($limit, $offset) {
        $data = array();
        if (intval($limit) && intval($offset) >= 0) {
            $sql = "SELECT `post_id`, SUBSTRING(`meta_key`, 8) AS `email`, SUBSTRING(meta_value, 1, 19) AS `date`, LOWER(SUBSTRING(meta_value, 21)) AS `subscription_type`, 1 AS `status` FROM `{$this->dbprefix}postmeta` WHERE meta_key LIKE '%_stcr@%' AND SUBSTRING(meta_value, 21) IN ('Y', 'R') ORDER BY SUBSTRING(meta_value, 1, 19) ASC LIMIT $offset, $limit;";
            $data = $this->db->get_results($sql, ARRAY_A);
        }
        return $data;
    }

    public function addStcrSubscriptions($subscriptions = array()) {

        foreach ($subscriptions as $subscription) {
            $email = $subscription['email'];
            $subscriptionId = $subscription['post_id'];
            $postId = $subscription['post_id'];
            $subscriptionType = $subscription['subscription_type'] == 'y' ? self::SUBSCRIPTION_POST : self::SUBSCRIPTION_ALL_COMMENT;
            $activationKey = md5($email . uniqid() . time());
            $subscriptionDate = $subscription['date'];
            $confirm = $subscription['status'];
            $userSubscription = $this->getUserSubscription($email, $postId);

            if ($userSubscription) {
                if ($userSubscription['type'] == self::SUBSCRIPTION_POST) {
                    continue;
                } else {
                    $sql = "UPDATE `$this->emailNotification` SET `subscribtion_id` = %d, `post_id` = %d, `subscribtion_type` = %s WHERE `id` = %d;";
                    $sql = $this->db->prepare($sql, $subscriptionId, $postId, $subscriptionType, $userSubscription['id']);
                    $this->db->query($sql);
                }
            } else {
                $sql = "INSERT INTO `$this->emailNotification` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`, `confirm`, `subscription_date`) VALUES (%s, %d, %d, %s, %s, %d, %s);";
                $sql = $this->db->prepare($sql, $email, $postId, $postId, $subscriptionType, $activationKey, $confirm, $subscriptionDate);
                $this->db->query($sql);
            }
        }
    }

    public function getUserSubscription($email, $postId) {
        $sql = "SELECT `id`, `subscribtion_type` as `type` FROM `" . $this->emailNotification . "` WHERE `email` = %s AND `post_id` = %d AND `confirm` = 1;";
        $sql = $this->db->prepare($sql, $email, $postId);
        return $this->db->get_row($sql, ARRAY_A);
    }

    /* === STCR SUBSCRIPTIONS === */

    /* === STATISTICS === */

    public function getThreadsCount($postId, $cache = true) {
        if ($cache) {
            $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
            if (!is_array($stat))
                $stat = array();
            if ($stat && isset($stat[self::POSTMETA_THREADS])) {
                $threads = intval($stat[self::POSTMETA_THREADS]);
            } else {
                $sql = $this->db->prepare("SELECT COUNT(*) FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_approved` = 1 AND `comment_parent` = 0;", $postId);
                $threads = intval($this->db->get_var($sql));
                $stat[self::POSTMETA_THREADS] = $threads;
                update_post_meta($postId, self::POSTMETA_STATISTICS, $stat);
            }
        } else {
            $sql = $this->db->prepare("SELECT COUNT(*) FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_approved` = 1 AND `comment_parent` = 0;", $postId);
            $threads = intval($this->db->get_var($sql));
        }
        return $threads;
    }

    public function getRepliesCount($postId, $cache = true) {
        if ($cache) {
            $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
            if (!is_array($stat))
                $stat = array();
            if ($stat && isset($stat[self::POSTMETA_REPLIES])) {
                $replies = intval($stat[self::POSTMETA_REPLIES]);
            } else {
                $sql = $this->db->prepare("SELECT COUNT(*) FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_approved` = 1 AND `comment_parent` != 0;", $postId);
                $replies = intval($this->db->get_var($sql));
                $stat[self::POSTMETA_REPLIES] = $replies;
                update_post_meta($postId, self::POSTMETA_STATISTICS, $stat);
            }
        } else {
            $sql = $this->db->prepare("SELECT COUNT(*) FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_approved` = 1 AND `comment_parent` != 0;", $postId);
            $replies = intval($this->db->get_var($sql));
        }
        return $replies;
    }

    public function getAllSubscriptionsCount($postId, $cache = true) {
        if ($cache) {
            $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
            if (!is_array($stat))
                $stat = array();
            if ($stat && isset($stat[self::POSTMETA_FOLLOWERS])) {
                $followers = intval($stat[self::POSTMETA_FOLLOWERS]);
            } else {
                $sql = $this->db->prepare("SELECT COUNT(DISTINCT `email`) FROM `$this->emailNotification` WHERE `post_id` = %d AND `confirm` = 1;", $postId);
                $followers = intval($this->db->get_var($sql));
                $stat[self::POSTMETA_FOLLOWERS] = $followers;
                update_post_meta($postId, self::POSTMETA_STATISTICS, $stat);
            }
        } else {
            $sql = $this->db->prepare("SELECT COUNT(DISTINCT `email`) FROM `$this->emailNotification` WHERE `post_id` = %d AND `confirm` = 1;", $postId);
            $followers = intval($this->db->get_var($sql));
        }
        return $followers;
    }

    public function getMostReactedCommentId($postId, $cache = true) {
        if ($cache) {
            $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
            if (!is_array($stat))
                $stat = array();
            if ($stat && isset($stat[self::POSTMETA_REACTED])) {
                $reacted = intval($stat[self::POSTMETA_REACTED]);
            } else {
                $sql = $this->db->prepare("SELECT v.`comment_id` FROM `$this->users_voted` AS `v` INNER JOIN `{$this->db->comments}` AS `c` ON `v`.`comment_id` = `c`.`comment_ID` WHERE `c`.`comment_post_ID`  = %d AND `c`.`comment_approved` = 1 GROUP BY `v`.`comment_id` ORDER BY COUNT(`v`.`comment_id`) DESC, `c`.`comment_date_gmt` DESC LIMIT 1;", $postId);
                $reacted = intval($this->db->get_var($sql));
                $stat[self::POSTMETA_REACTED] = $reacted;
                update_post_meta($postId, self::POSTMETA_STATISTICS, $stat);
            }
        } else {
            $sql = $this->db->prepare("SELECT v.`comment_id` FROM `$this->users_voted` AS `v` INNER JOIN `{$this->db->comments}` AS `c` ON `v`.`comment_id` = `c`.`comment_ID` WHERE `c`.`comment_post_ID`  = %d AND `c`.`comment_approved` = 1 GROUP BY `v`.`comment_id` ORDER BY COUNT(`v`.`comment_id`) DESC, `c`.`comment_date_gmt` DESC LIMIT 1;", $postId);
            $reacted = intval($this->db->get_var($sql));
        }
        return $reacted;
    }

    public function getHottestTree($commentId) {
        $sql = $this->db->prepare("SELECT * FROM (SELECT * FROM `{$this->db->comments}`) `c`,(SELECT @pv := %d) AS `init` WHERE FIND_IN_SET(`c`.`comment_parent`, @pv) AND LENGTH(@pv := CONCAT(@pv, ',', `c`.`comment_ID`))", $commentId);
        $data = $this->db->get_results($sql, ARRAY_A);
        return $data;
    }

    public function getAuthorsCount($postId, $cache = true) {
        if ($cache) {
            $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
            if (!is_array($stat))
                $stat = array();
            if ($stat && isset($stat[self::POSTMETA_AUTHORS])) {
                $authors = intval($stat[self::POSTMETA_AUTHORS]);
            } else {
                $sql = $this->db->prepare("SELECT COUNT(DISTINCT `comment_author_email`) FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_author_email` != '' AND `comment_approved` = 1;", $postId);
                $authors = intval($this->db->get_var($sql));
                $stat[self::POSTMETA_AUTHORS] = $authors;
                update_post_meta($postId, self::POSTMETA_STATISTICS, $stat);
            }
        } else {
            $sql = $this->db->prepare("SELECT COUNT(DISTINCT `comment_author_email`) FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_author_email` != '' AND `comment_approved` = 1;", $postId);
            $authors = intval($this->db->get_var($sql));
        }
        return $authors;
    }

    public function getRecentAuthors($postId, $limit = 5, $cache = true) {
        $limit = $limit ? $limit : 5;
        if ($cache) {
            $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
            if (!is_array($stat))
                $stat = array();
            if ($stat && isset($stat[self::POSTMETA_RECENT_AUTHORS])) {
                $recentAuthors = $stat[self::POSTMETA_RECENT_AUTHORS];
            } else {
                $sql = $this->db->prepare("SELECT DISTINCT `comment_author_email`, `comment_author`, user_id FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_approved` = 1 ORDER BY `comment_ID` DESC LIMIT %d;", $postId, $limit);
                $recentAuthors = $this->db->get_results($sql);
                $stat[self::POSTMETA_RECENT_AUTHORS] = $recentAuthors;
                update_post_meta($postId, self::POSTMETA_STATISTICS, $stat);
            }
        } else {
            $sql = $this->db->prepare("SELECT DISTINCT `comment_author_email`, `comment_author`, user_id FROM `{$this->db->comments}` WHERE `comment_post_ID` = %d AND `comment_approved` = 1 AND `comment_author_email` != '' ORDER BY `comment_ID` DESC LIMIT %d;", $postId, $limit);
            $recentAuthors = $this->db->get_results($sql);
        }
        return $recentAuthors;
    }

    public function deleteStatisticCaches() {
        $sql = "DELETE FROM `{$this->db->postmeta}` WHERE `meta_key` = '" . self::POSTMETA_STATISTICS . "';";
        $this->db->query($sql);
    }

    public function deleteOldStatisticCaches() {
        $sql = "DELETE FROM `{$this->db->options}` WHERE `option_name` LIKE '%wpdiscuz_threads_count_%' OR `option_name` LIKE '%wpdiscuz_replies_count_%' OR `option_name` LIKE '%wpdiscuz_followers_count_%' OR `option_name` LIKE '%wpdiscuz_most_reacted_%' OR `option_name` LIKE '%wpdiscuz_hottest_%' OR `option_name` LIKE '%wpdiscuz_authors_count_%' OR `option_name` LIKE '%wpdiscuz_recent_authors_%';";
        $this->db->query($sql);
    }

    /* === STATISTICS === */

    /* === MODAL === */

    public function getSubscriptionsCount($userEmail) {
        $sql = $this->db->prepare("SELECT COUNT(*) FROM `{$this->emailNotification}` WHERE `email` = %s;", trim($userEmail));
        $result = $this->db->get_var($sql);
        return $result;
    }

    public function getSubscriptions($userEmail, $limit, $offset) {
        $limitCondition = ($l = intval($limit)) > 0 ? "LIMIT $l OFFSET $offset" : "";
        $sql = $this->db->prepare("SELECT * FROM {$this->emailNotification} WHERE `email` = %s $limitCondition;", trim($userEmail));
        $result = $this->db->get_results($sql);
        return $result;
    }

    public function unsubscribeById($sId) {
        $sql = $this->db->prepare("DELETE FROM {$this->emailNotification} WHERE `id` = %d;", intval($sId));
        $this->db->query($sql);
    }

    public function unsubscribeByEmail($email) {
        $sql = $this->db->prepare("DELETE FROM {$this->emailNotification} WHERE `email` = %s;", trim($email));
        $this->db->query($sql);
    }

    // FOLLOWS
    public function getFollowsCount($userEmail) {
        $sql = $this->db->prepare("SELECT COUNT(*) FROM `{$this->followUsers}` WHERE `follower_email` = %s;", trim($userEmail));
        $result = $this->db->get_var($sql);
        return $result;
    }

    public function getFollows($userEmail, $limit, $offset) {
        $limitCondition = ($l = intval($limit)) > 0 ? "LIMIT $l OFFSET $offset" : "";
        $sql = $this->db->prepare("SELECT * FROM {$this->followUsers} WHERE `follower_email` = %s $limitCondition;", trim($userEmail));
        $result = $this->db->get_results($sql);
        return $result;
    }
    
    public function unfollowById($fId) {
        $sql = $this->db->prepare("DELETE FROM {$this->followUsers} WHERE `id` = %d;", intval($fId));
        $this->db->query($sql);
    }
    
    public function unfollowByEmail($email) {
        $sql = $this->db->prepare("DELETE FROM {$this->followUsers} WHERE `follower_email` = %s;", trim($email));
        $this->db->query($sql);
    }
    
    /**
     * remove user related follows
     * @param type $email the user email who other users following
     */
    public function deleteFollowsByEmail($email) {
        $sql = $this->db->prepare("DELETE FROM {$this->followUsers} WHERE `user_email` = %s;", trim($email));
        $this->db->query($sql);
    }

    /* === MODAL === */

    /* === VOTE IP HASH === */

    public function getNotHashedIpCount() {
        $sql = "SELECT COUNT(*) FROM `{$this->users_voted}` WHERE `user_id` LIKE '%.%' OR `user_id` LIKE '%:%';";
        return $this->db->get_var($sql);
    }

    public function getNotHashedStartId() {
        $sql = "SELECT `id` FROM `{$this->users_voted}` WHERE `user_id` LIKE '%.%' OR `user_id` LIKE '%:%' ORDER BY `id` LIMIT 1;";
        return $this->db->get_var($sql);
    }

    public function getNotHashedVoteData($startId, $limit) {
        $sql = $this->db->prepare("SELECT `id` FROM `{$this->users_voted}` WHERE `id` > %d ORDER BY `id` ASC LIMIT %d;", $startId, $limit);
        $data = $this->db->get_col($sql);
        return $data;
    }

    public function hashVoteIps($ids) {
        if ($ids && is_array($ids)) {
            $idsStr = implode(',', $ids);
            $sql = "UPDATE `{$this->users_voted}` SET `user_id` = MD5(`user_id`) WHERE `id` IN ($idsStr);";
            return $this->db->query($sql);
        }
    }

    /* === VOTE IP HASH === */

    /* === FOLLOW USER === */

    public function getUserFollows($followerEmail) {
        $follows = array();
        if ($followerEmail) {
            $sql = $this->db->prepare("SELECT `user_email` FROM `{$this->followUsers}` WHERE `confirm` = 1 AND `follower_email` = %s;", $followerEmail);
            $follows = $this->db->get_col($sql);
        }
        return $follows;
    }

    public function getUserFollowers($userEmail) {
        $followers = array();
        if ($userEmail) {
            $sql = $this->db->prepare("SELECT * FROM `{$this->followUsers}` WHERE `confirm` = 1 AND `user_email` = %s;", $userEmail);
            $followers = $this->db->get_results($sql, ARRAY_A);
        }
        return $followers;
    }

    public function isFollowExists($userEmail, $followerEmail) {
        $exists = false;
        if ($userEmail && $followerEmail) {
            $sql = $this->db->prepare("SELECT `id`, `activation_key`, `confirm` FROM `{$this->followUsers}` WHERE `user_email` = %s AND `follower_email` = %s LIMIT 1;", $userEmail, $followerEmail);
            $exists = $this->db->get_row($sql, ARRAY_A);
        }
        return $exists;
    }

    public function addNewFollow($args) {
        $data = false;
        $postId = isset($args['post_id']) ? intval($args['post_id']) : 0;
        $userId = isset($args['user_id']) ? intval($args['user_id']) : 0;
        $userEmail = isset($args['user_email']) ? trim($args['user_email']) : '';
        $userName = isset($args['user_name']) ? trim($args['user_name']) : '';
        $followerId = isset($args['follower_id']) ? intval($args['follower_id']) : 0;
        $followerEmail = isset($args['follower_email']) ? trim($args['follower_email']) : '';
        $followerName = isset($args['follower_name']) ? trim($args['follower_name']) : '';
        $confirm = isset($args['confirm']) ? intval($args['confirm']) : 0;

        if ($userEmail && $followerId && $followerEmail) {
            $currentDate = current_time('mysql');
            $currentTimestamp = strtotime($currentDate);
            $activationKey = md5($userEmail . $followerEmail . $currentTimestamp);
            $sql = $this->db->prepare("INSERT INTO `{$this->followUsers}` VALUES (NULL, %d, %d, %s, %s, %d, %s, %s, %s, %d, %d, %s);", $postId, $userId, $userEmail, $userName, $followerId, $followerEmail, $followerName, $activationKey, $confirm, $currentTimestamp, $currentDate);
            $this->db->query($sql);
            if ($this->db->insert_id) {
                $data = array('id' => $this->db->insert_id, 'activation_key' => $activationKey);
            }
        }
        return $data;
    }

    public function followConfirmLink($postId, $id, $key) {
        global $wp_rewrite;
        $confirmLink = !$wp_rewrite->using_permalinks() ? get_permalink($postId) . "&" : get_permalink($postId) . "?";
        $confirmLink .= "wpdiscuzUrlAnchor&wpdiscuzFollowID=$id&wpdiscuzFollowKey=$key&wpDiscuzComfirm=1&#wc_follow_message";
        return $confirmLink;
    }

    public function followCancelLink($postId, $id, $key) {
        global $wp_rewrite;
        $cancelLink = !$wp_rewrite->using_permalinks() ? get_permalink($postId) . "&" : get_permalink($postId) . "?";
        $cancelLink .= "wpdiscuzUrlAnchor&wpdiscuzFollowID=$id&wpdiscuzFollowKey=$key&wpDiscuzComfirm=0#wc_follow_message";
        return $cancelLink;
    }

    public function confirmFollow($id, $key) {
        $sql = $this->db->prepare("UPDATE `{$this->followUsers}` SET `confirm` = 1 WHERE `id` = %d AND `activation_key` = %s;", intval($id), trim($key));
        return $this->db->query($sql);
    }

    public function cancelFollow($id, $key) {
        $sql = $this->db->prepare("DELETE FROM `{$this->followUsers}` WHERE `id` = %d AND `activation_key` = %s", intval($id), trim($key));
        return $this->db->query($sql);
    }

    public function updateUserInfo($user, $oldUser) {
        $userNewEmail = trim($user->user_email);
        $userOldEmail = trim($oldUser->user_email);
        $userNewName = trim($user->display_name);
        $userOldName = trim($oldUser->display_name);
        if ($userNewEmail != $userOldEmail) {
            $sql = $this->db->prepare("UPDATE `{$this->followUsers}` SET `user_email` = %s WHERE `user_email` = %s AND `follower_email` != %s;", $userNewEmail, $userOldEmail, $userNewEmail);
            $this->db->query($sql);
            $sql = $this->db->prepare("UPDATE `{$this->followUsers}` SET `follower_email` = %s WHERE `follower_email` = %s AND `user_email` != %s;", $userNewEmail, $userOldEmail, $userNewEmail);
            $this->db->query($sql);
            $sql = $this->db->prepare("UPDATE `{$this->emailNotification}` SET `email` = %s WHERE `email` = %s;", $userNewEmail, $userOldEmail);
            $this->db->query($sql);
        }

        if ($userNewName != $userOldName) {
            $sql = $this->db->prepare("UPDATE `{$this->followUsers}` SET `user_name` = %s WHERE `user_name` = %s;", $userNewName, $userOldName);
            $this->db->query($sql);
            $sql = $this->db->prepare("UPDATE `{$this->followUsers}` SET `follower_name` = %s WHERE `follower_name` = %s;", $userNewName, $userOldName);
            $this->db->query($sql);
        }
    }

    /* === FOLLOW USER === */
}
