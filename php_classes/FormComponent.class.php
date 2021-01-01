<?php
class FormComponent {

// START:   CLASS - PROPERTIES

    public $form_group;
    public $header;
    public $label;
    public $id;
    public $class;
    public $tag;
    public $placeholder;
    public $value;
    public $name;
    public $style = array();
    public $attribute_list = array();


// END:     CLASS - PROPERTIES

// START:   CLASS CONSTRUCTOR(S)
    function __construct($header, $label, $id, $class, $placeholder, $value, $name, $style = array(), $attribute_list = array()) {
        $this->header = $header;
        $this->label = $label;
        $this->id = $id;
        $this->class = $class;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->name = $name;
        $this->style = $style;
        $this->attribute_list = $attribute_list;
    }
// END:     CLASS CONSTRUCTOR(S)

// START:   CLASS - METHODS

    // START:   CLASS - SETTERS & GETTERS
        // START:   SETTERS
            function set_label($label) {
                $this->label = $label;
            }
            function set_placeholder($placeholder) {
                $this->placeholder = $placeholder;
            }
            function set_value($value) {
                $this->value = $value;
            }
            function set_name($name) {
                $this->name = $name;
            }
            function set_select_options($select_options) {
                $this->select_options = $select_options;
            }
            function set_selected_option($selected_option) {
                $this->selected_option = $selected_option;
            }
        // END:     SETTERS
        // START:   GETTERS
            function get_label() {
                return $this->label;
            }
            function get_placeholder() {
                return $this->placeholder;
            }
            function get_value() {
                return $this->value;
            }
            function get_name() {
                return $this->name;
            }
            function get_select_options() {
                return $this->select_options;
            }
            function get_selected_option() {
                return $this->selected_option;
            }
        // END:     GETTERS
    // END:     CLASS - SETTERS & GETTERS

// END:     CLASS - METHODS


}
?>