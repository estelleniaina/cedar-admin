<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSimple extends Component
{
    protected $thead;
    protected $data;

    /**
     * TableSimple constructor.
     * @param $thead
     * @param $data
     */
    public function __construct($thead, $data)
    {
        $this->thead = $thead;
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.simple', [
            'thead' => $this->thead,
            'data' => $this->data,
        ]);
    }
}
