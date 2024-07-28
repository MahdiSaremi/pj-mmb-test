<?php

namespace App\Mmb\Main\Sections;

use Mmb\Action\Section\Controllers\Attributes\OnCallback;
use Mmb\Action\Section\Controllers\CallbackControl;
use Mmb\Action\Section\Section;

class NoneSection extends Section
{
    use CallbackControl;

    #[OnCallback('none', true)]
    public function none()
    {
        if ($this->update->callbackQuery)
        {
            $this->tell();
        }
    }

}
