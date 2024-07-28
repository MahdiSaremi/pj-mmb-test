<?php

namespace Modules\Panel\Mmb\Sections;

use App\Mmb\Admin\Sections\Panel\ChatResourceSection;
use App\Models\BotUser;
use Mmb\Action\Section\Attributes\WithBack;
use Mmb\Action\Section\Menu;
use Mmb\Action\Section\Section;
use Modules\Home\Mmb\Sections\HomeSection;

class PanelSection extends Section
{

    public function main()
    {
        $this->menu('mainMenu')->response();
    }

    #[WithBack]
    public function mainMenu(Menu $menu)
    {
        $menu
            ->message("وارد پنل مدیریت شدید")
            ->schema([
                [$menu->key("📊 آمار ربات", 'statistics')],
                [$menu->keyFor("👤 کاربران", UserResourceSection::class)],
                [$menu->keyFor("💬 چت ها", ChatResourceSection::class)],
            ])
        ;
    }

    public function statistics()
    {
        $this->response(sprintf(
            <<<TEXT
            📊 آمار کاربران


            👤 کاربران : %s

            TEXT,
            BotUser::count(),
        ));
    }

    public function back()
    {
        HomeSection::invokes('main');
    }

}
