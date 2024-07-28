<?php

namespace App\Mmb\Admin\Areas;

use Mmb\Auth\Area;
use Modules\Panel\Mmb\Sections\PanelSection;

class AdminArea extends Area
{

    protected string $namespace = 'App\Mmb\Admin\Sections';

    public function boot()
    {
        // $this->auth('AccessPanel'); // todo
        $this->backUsing(PanelSection::class, 'main');
    }

}
