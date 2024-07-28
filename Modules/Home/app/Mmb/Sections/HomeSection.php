<?php

namespace Modules\Home\Mmb\Sections;

use Mmb\Action\Section\Menu;
use Mmb\Action\Section\Section;
use Modules\Panel\Mmb\Sections\PanelSection;

class HomeSection extends Section
{

    public function main()
    {
        $this->menu('mainMenu')->response();
    }

    public function restore()
    {
        $this->menu('mainMenu')->response("به منوی قبلی بازگشتید:");
    }

    public function mainMenu(Menu $menu)
    {
        $menu
            ->schema([
                [ $menu->key("Hello World", fn () => $this->response("Salam Donya =D")) ],

                [ $menu->keyFor("پنل مدیریت", PanelSection::class, 'main')->ifAllowed() ],
            ])
            ->message("منوی اصلی:")
        ;
    }

}
