<?php

namespace PFBC\Element;

class Textbox extends \PFBC\Element {

    protected $_attributes = array("type" => "text");
    protected $prepend;
    protected $append;

    public function render() {
        $addons = array();
        if (!empty($this->prepend))
            $addons[] = "input-prepend";
        if (!empty($this->append))
            $addons[] = "input-append";
        if (!empty($addons))
            echo '<div class="' . implode(" " . $addons) . '">';

        $this->renderAddOn("prepend");
        parent::render();
        $this->renderAddOn("append");

        if (!empty($addons))
            echo '</div>';
    }

    public function renderHTML() {
        $label = $this->getLabel();
        $htmlTemplate = <<<HTML
                <div class="form-group">
                                    <label >$label</label>
HTML;

        echo $htmlTemplate;
        parent::render();
        echo "</div>";
    }

    public function renderDateHTML() {
        $label = $this->getLabel();
        $htmlTemplate = <<<HTML
                <label >$label</label>
                <div class="input-group date">
HTML;
        echo $htmlTemplate;
        parent::render();
        echo '<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span></div>';
    }

    protected function renderAddOn($type = "prepend") {
        $html = "";
        if (!empty($this->$type)) {
            $span = true;
            if (strpos($this->$type . "<button") !== false)
                $span = false;

            if ($span)
                echo '<span class="add-on">';

            echo $this->$type;

            if ($span)
                echo '</span>';
        }
    }

    protected function renderAddOnHtml($type = "prepend") {
        $html = "";
        if (!empty($this->$type)) {
            $span = true;
            if (strpos($this->$type . "<button") !== false)
                $span = false;

            if ($span)
                $html .= '<span class="add-on">';

            echo $this->$type;

            if ($span)
                $html .= '</span>';
        }
    }

}
