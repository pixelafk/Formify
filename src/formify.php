<?php declare(strict_types=1);

namespace polarnix\Formify;

use DOMDocument;
use DOMElement;
use polarnix\Formify\Field\Field;

class Form {
    private $action;
    private $method;
    private $enctype;
    private $fields;

    public function __construct(array $config = []) {
        $this->action = isset($config['action']) ? $config['action'] : '';
        $this->method = isset($config['method']) ? strtoupper($config['method']) : 'POST';
        $this->enctype = isset($config['enctype']) ? $config['enctype'] : 'multipart/form-data';
        $this->fields = [];
    }

    public function field(array $attr): Field {
        $field = new Field($attr);
        return $field;
    }

    public function render(): DOMElement {
        $doc = new DOMDocument();
        $html = $doc->createElement('form');

        $attributes = [
            'action' => $this->action,
            'method' => $this->method,
            'enctype' => $this->enctype
        ];

        foreach($attributes as $name => $value) {
            $html->setAttribute($name, $value);
        }

        foreach($this->fields as $field) {
            $input = $field->render();
            $html->appendChild($input);
        }

        return $html;
    }
}