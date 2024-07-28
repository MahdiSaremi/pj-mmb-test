<?php

namespace App\Mmb\Areas;

use Mmb\Auth\Area;
use Modules\Home\Mmb\Sections\HomeSection;

class GlobalArea extends Area
{

    protected string $namespace = 'Modules';

    public function boot()
    {
        $this->backUsing(HomeSection::class, 'main');
    }

}
