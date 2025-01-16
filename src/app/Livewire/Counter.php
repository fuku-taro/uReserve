<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    public $name = '';

    // render前に実行
    public function mount()
    {
        $this->name = 'mount';
    }

    public function updated()
    {
        $this->name = 'updated';
    }

    public function mouseOver()
    {
        $this->name = 'mouseover';
    }

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
