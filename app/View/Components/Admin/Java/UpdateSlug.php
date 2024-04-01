<?php

namespace App\View\Components\Admin\Java;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpdateSlug extends Component {

    public $row;
    public $isactive;
    public $viewType;
    public $ar;
    public $en;


    public function __construct(
        $row = array(),
        $isactive = true,
        $viewType = null,
        $ar = true,
        $en = true,

    ) {
        $this->row = $row;
        $this->isactive = $isactive;
        $this->viewType = $viewType;
        $this->ar = $ar;
        $this->en = $en;

    }

    public function render(): View|Closure|string {
        return view('components.admin.java.update-slug');
    }
}
