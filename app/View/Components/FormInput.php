<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    public $label;
    public $name;
    public $type;
    public $value;
    public $required;
    public $placeholder;
    public $class;

    public function __construct(
        $label,
        $name,
        $type = 'text',
        $value = '',
        $required = false,
        $placeholder = '',
        $class = ''
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.form-input');
    }
} 