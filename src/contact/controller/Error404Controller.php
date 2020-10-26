<?php
include_once SRC_PATH.'controller/Layout.php';


class Error404Controller extends Layout
{
    public function process()
    {
        return $this->getView('Error404', [
            'redirect' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'
        ]);
    }
}
