<?php

namespace App\View\Components;

use Closure;
use App\Models\Bounty;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class BountyCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Bounty $bounty)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bounty-card');
    }
}
