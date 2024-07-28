<?php

namespace Modules\Panel\Mmb\Areas;

use Mmb\Auth\Area;
use Modules\Panel\Mmb\Sections\PanelSection;

abstract class AdminBaseArea extends Area
{

    public function boot()
    {
        // $this->auth('AccessPanel'); // todo
        $this->backUsing(PanelSection::class, 'main');
    }

}
