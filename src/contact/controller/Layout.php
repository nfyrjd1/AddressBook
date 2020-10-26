<?php

class Layout{

    public function getView($template, $variables = null) {
        ob_start();
        $this->includeTemplate($template, $variables);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    private function includeTemplate($name, $variables = null) {
        if ($variables) {
            extract($variables);
        }
        include SRC_PATH.'view/'.$name.'View.php';
    }
}