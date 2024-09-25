<?php

class FormView {
    private $action;
    private $fields = [];
    private $buttons = []; // Initialisation de la propriété buttons
    private $submitLabel;

    public function __construct($action, $submitLabel = 'Soumettre') {
        $this->action = $action;
        $this->submitLabel = $submitLabel;
    }

    public function addField($id, $name, $type, $label, $value = '') {
        $this->fields[] = [
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'label' => $label,
            'value' => $value,
            'options' => []  // Utilisé uniquement pour les champs de type 'select'
        ];
        return $this;
    }

    public function addSelectField($id, $name, $label, $options, $selectedValue = '') {
        $this->fields[] = [
            'id' => $id,
            'name' => $name,
            'type' => 'select',
            'label' => $label,
            'value' => $selectedValue,
            'options' => $options
        ];
        return $this;
    }

    public function addButton($type, $label, $attributes = []) {
        $this->buttons[] = [
            'type' => $type,
            'label' => $label,
            'attributes' => $attributes
        ];
        return $this;
    }

    public function build() {
        $formHtml = "<form action='{$this->action}' method='post' class='form-container'>";

        foreach ($this->fields as $field) {
            $formHtml .= "<div class='form-group'>";
            $formHtml .= "<label for='{$field['id']}'>{$field['label']}</label>";

            if ($field['type'] === 'select') {
                $formHtml .= "<select class='form-control' id='{$field['id']}' name='{$field['name']}'>";
                foreach ($field['options'] as $optionValue => $optionLabel) {
                    $selected = $field['value'] == $optionValue ? 'selected' : '';
                    $formHtml .= "<option value='{$optionValue}' {$selected}>{$optionLabel}</option>";
                }
                $formHtml .= "</select>";
            } else {
                $formHtml .= "<input class='form-control' type='{$field['type']}' id='{$field['id']}' name='{$field['name']}' value='{$field['value']}'>";
            }

            $formHtml .= "</div>";
        }

        foreach ($this->buttons as $button) {
            $attributes = '';
            foreach ($button['attributes'] as $attr => $value) {
                $attributes .= " {$attr}=\"{$value}\"";
            }
            $formHtml .= "<button type='{$button['type']}' class='btn btn-primary'{$attributes}>{$button['label']}</button>";
        }

        $formHtml .= "</form>";
        return $formHtml;
    }
}
