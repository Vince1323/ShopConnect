<?php

class FormContainer
{
    private $elements = [];
    private $html = '';
    private $breadcrumbSeparator = ' &gt; '; // Flèche de fil d'Ariane par défaut

    public function setBreadcrumbSeparator($separator)
    {
        $this->breadcrumbSeparator = $separator;
    }

    public function addMainTitle($text)
    {
        $this->elements[] = ['maintitle', $text];
    }

    public function addSubTitle($text)
    {
        $this->elements[] = ['subtitle', $text];
    }

    public function addDescription($text)
    {
        $this->elements[] = ['description', $text];
    }

    public function addBreadcrumb($text, $link = null)
    {
        if ($link) {
            $this->elements[] = ['breadcrumb', [$text, $link]];
        } else {
            $this->elements[] = ['breadcrumb', $text];
        }
    }

    public function addElement($title, $content)
    {
        $this->elements[] = ['element', [$title, $content]];
    }

    public function addField($name, $type, $label, $value = '', $attributes = [])
    {
        $field = [
            'name' => $name,
            'type' => $type,
            'label' => $label,
            'value' => $value,
            'attributes' => $attributes
        ];
        $this->elements[] = ['field', $field];
    }

    public function addButton($type, $text, $attributes = [])
    {
        $button = [
            'type' => $type,
            'text' => $text,
            'attributes' => $attributes
        ];
        $this->elements[] = ['button', $button];
    }

    private function addOpeningTag($tag, $class = '')
    {
        $this->html .= "<$tag";
        if (!empty($class)) {
            $this->html .= " class='$class'";
        }
        $this->html .= ">\n";
    }

    private function addClosingTag($tag)
    {
        $this->html .= "</$tag>\n";
    }

    private function renderAttributes($attributes)
    {
        $attrString = '';
        foreach ($attributes as $key => $value) {
            $attrString .= " $key='$value'";
        }
        return $attrString;
    }

    public function render()
    {
        $this->html = ''; // Reset HTML before rendering

        $this->addOpeningTag('div', 'container mt-5'); // Ajoute une marge supérieure
        $this->addOpeningTag('div', 'row');
        $this->addOpeningTag('div', 'col');
        $this->addOpeningTag('main');

        // Ajouter le fil d'Ariane avant le titre principal
        $breadcrumb = '';
        foreach ($this->elements as $element) {
            $type = $element[0];
            $content = $element[1];

            if ($type === 'breadcrumb') {
                if (is_array($content)) {
                    $breadcrumb .= "<a href='{$content[1]}'>{$content[0]}</a>{$this->breadcrumbSeparator}";
                } else {
                    $breadcrumb .= "$content{$this->breadcrumbSeparator}";
                }
            } else {
                break; // Arrêter dès qu'on rencontre autre chose que le fil d'Ariane
            }
        }

        // Supprimer le dernier séparateur du fil d'Ariane
        $breadcrumb = rtrim($breadcrumb, $this->breadcrumbSeparator);

        // Ajouter le fil d'Ariane dans une seule ligne
        if (!empty($breadcrumb)) {
            $this->html .= "<nav aria-label='breadcrumb'><ol class='breadcrumb'>$breadcrumb</ol></nav>\n";
        }

        // Ajouter le titre principal après le fil d'Ariane
        foreach ($this->elements as $element) {
            $type = $element[0];
            $content = $element[1];

            if ($type === 'maintitle') {
                $this->html .= "<h2>$content</h2>\n";
                break; // Arrêt du titre principal
            }
        }

        // Ajouter les sous-titres et autres éléments
        $subtitleAdded = false;
        foreach ($this->elements as $element) {
            $type = $element[0];
            $content = $element[1];

            if ($type === 'maintitle' || $type === 'breadcrumb') {
                continue; // Ne pas répéter le titre principal ni le fil d'Ariane
            }

            switch ($type) {
                case 'subtitle':
                    if ($subtitleAdded) {
                        $this->html .= "<hr>"; // Ajout d'une séparation entre les sous-titres
                    }
                    $subtitleAdded = true;
                    $this->html .= "<h3>$content</h3>\n";
                    break;
                case 'description':
                    $this->html .= "<p>$content</p>\n";
                    break;
                case 'element':
                    $title = $content[0];
                    $content = $content[1];
                    $this->html .= "<h4>$title</h4>\n<p>$content</p>\n";
                    break;
                case 'field':
                    $label = $content['label'];
                    $name = $content['name'];
                    $type = $content['type'];
                    $value = $content['value'];
                    $attributes = $this->renderAttributes($content['attributes']);
                    $this->html .= "<div class='form-group'><label for='$name'>$label</label><input type='$type' name='$name' id='$name' value='$value' $attributes class='form-control'></div>\n";
                    break;
                case 'button':
                    $text = $content['text'];
                    $type = $content['type'];
                    $attributes = $this->renderAttributes($content['attributes']);
                    $this->html .= "<button type='$type' $attributes class='btn btn-primary'>$text</button>\n";
                    break;
            }
        }

        $this->addClosingTag('main');
        $this->addClosingTag('div'); // .col
        $this->addClosingTag('div'); // .row
        $this->addClosingTag('div'); // .container

        return $this->html;
    }
}