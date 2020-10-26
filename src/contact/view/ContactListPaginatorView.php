<?php
if (!empty($paginator) || is_array($paginator) || count($paginator) > 0) {
    echo '<nav>';
    echo '<ul class="paginator-list">';

    foreach ($paginator as $item) {
        if (!is_array($item)) continue;

        if ($item[2]) echo '<li class="paginator-item paginator-item-current">';
        else echo '<li class="paginator-item">';

        echo '<a href="' . $item[0] . '">' . $item[1] . '</a>';
        echo '</li>';
    }
    echo '</nav>';
    echo '</ul>';
}
