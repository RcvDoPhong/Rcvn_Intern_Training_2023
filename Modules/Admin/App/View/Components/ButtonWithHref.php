<?php

namespace Modules\Admin\App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ButtonWithHref extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $route,
        public string $icon,
        public string $type,
        public string $title
    ) {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('admin::components.buttonwithhref');
    }
}
