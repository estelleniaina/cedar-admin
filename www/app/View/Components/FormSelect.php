<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormSelect extends Component
{
    private $data;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select', [
            'data' => $this->data
        ]);
    }
}
