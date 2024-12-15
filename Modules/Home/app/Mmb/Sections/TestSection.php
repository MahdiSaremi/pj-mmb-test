<?php

namespace Modules\Home\Mmb\Sections;

use Mmb\Action\Section\Section;

class TestSection extends Section
{

    public function denied403()
    {
        $this->response("دسترسی ندارید!");
    }

    public function main()
    {
        abort(403);
    }

}
