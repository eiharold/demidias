<?php
if (!defined('ABSPATH')) {
    exit();
}

if ($pageCount && $pageCount > 1) {    
    if (isset($page)) {
        $start = $page - $lrItemsCount > 0 ? $page - $lrItemsCount : 0;
        $start = (($page + $lrItemsCount) >= $pageCount) ? ($pageCount - (2 * $lrItemsCount + 1)) : $start;
        $start = $start > 0 ? $start : 0;
        $end = $page + $lrItemsCount < $pageCount ? $page + $lrItemsCount : $pageCount;
        $end = $end < 2 * $lrItemsCount ? 2 * $lrItemsCount : $end;
        $end = $end < $pageCount - 1 ? $end : $pageCount - 1;
    } else {
        $start = 0;
        $end = $pageCount < (2 * $lrItemsCount) ? $pageCount - 1 : 2 * $lrItemsCount;
    }
    ?>
    <div class='wpd-pagination'>
        <?php
        if ($page - $lrItemsCount > 0) {
            $phrasePaginationFirst = __('&laquo;', 'wpdiscuz');
            ?>
            <a href='#0' class='wpd-page-link wpd-not-clicked' data-wpd-page='0'><?php echo $phrasePaginationFirst; ?></a>
            <?php
        }
        if ($page > 0) {
            $phrasePaginationPrevious = __('&lsaquo;', 'wpdiscuz');
            ?>
            <a href='#<?php echo $page - 1; ?>' class='wpd-page-link wpd-not-clicked' data-wpd-page='<?php echo $page - 1; ?>'><?php echo $phrasePaginationPrevious; ?></a>
            <?php
        }
        for ($i = $start; $i <= $end; $i++) {
            $pageText = intval($i + 1);
            if ($i < $pageCount) {
                if ($i == $page) {
                    ?>
                    <span style="background: <?php echo $this->optionsSerialized->primaryColor; ?>;" class='wpd-page-link wpd-current-page' data-wpd-page='<?php echo $i; ?>'><?php echo $pageText; ?></span>
                <?php } else { ?>
                    <a href='#<?php echo $i; ?>' class='wpd-page-link wpd-not-clicked' data-wpd-page='<?php echo $i; ?>'><?php echo $pageText; ?></a>
                    <?php
                }
            }
        }
        if ($page < $pageCount - 1) {
            $phrasePaginationNext = __('&rsaquo;', 'wpdiscuz');
            ?>
            <a href='#<?php echo $page + 1; ?>' class='wpd-page-link wpd-not-clicked' data-wpd-page='<?php echo $page + 1; ?>'><?php echo $phrasePaginationNext; ?></a>
            <?php
        }
        if ($page + $lrItemsCount < $pageCount - 1) {
            $phrasePaginationLast = __('&raquo;', 'wpdiscuz');
            ?>
            <a href='#<?php echo intval($pageCount) - 1; ?>' class='wpd-page-link wpd-not-clicked' data-wpd-page='<?php echo intval($pageCount) - 1; ?>'><?php echo $phrasePaginationLast; ?></a>
            <?php
        }
        ?>                    
        <input type='hidden' class='wpd-action' value='<?php echo $action; ?>'/>
        <div class="clear"></div>
    </div>
    <?php
}