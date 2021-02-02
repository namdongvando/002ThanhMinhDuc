<?php

namespace PFBC\Element;

class Radio extends \PFBC\OptionElement {

    protected $_attributes = array("type" => "radio");
    protected $inline;

    public function render() {
//        $labelClass = $this->_attributes["type"];
        $this->_attributes["labelclass"] = isset($this->_attributes["labelclass"]) ? $this->_attributes["labelclass"] : "";
        $labelClass = $this->_attributes["labelclass"];
        unset($this->_attributes["labelclass"]);
        if (!empty($this->inline))
            $labelClass .= " inline";

        $count = 0;
        foreach ($this->options as $value => $text) {
            $value = $this->getOptionValue($value);

            echo '<label class="', $labelClass . '"> <input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked")), ' value="', $this->filter($value), '"';
            if (isset($this->_attributes["value"]) && $this->_attributes["value"] == $value)
                echo ' checked="checked"';
            echo '/> ', $text, ' </label> ';
            ++$count;
        }
    }

    public function renderHtml() {
//        $labelClass = $this->_attributes["type"];
        $labelClass = $this->_attributes["class"];
        unset($this->_attributes["class"]);
        if (!empty($this->inline))
            $labelClass .= " inline";
        $count = 0;
        $html = "";
        foreach ($this->options as $value => $text) {
            $value = $this->getOptionValue($value);
            $html .= '<label class="' . $labelClass . '"> <input id="' . $this->_attributes["id"] . '-' . $count . '"' . $this->getAttributes(array("id" . "value" . "checked")) . ' value="' . $this->filter($value) . '"';
            if (isset($this->_attributes["value"]) && $this->_attributes["value"] == $value)
                $html .= ' checked="checked"';
            $html .= '/> ' . $text . ' </label> ';
            ++$count;
        }
        return $html;
    }

}
