<?php

namespace Modules\Panel\Mmb\Sections;

use App\Models\BotUser;
use Mmb\Action\Section\Menu;
use Mmb\Action\Section\Resource\ResourceDeleteModule;
use Mmb\Action\Section\Resource\ResourceEditModule;
use Mmb\Action\Section\Resource\ResourceInfoModule;
use Mmb\Action\Section\Resource\ResourceListModule;
use Mmb\Action\Section\Resource\ResourceSearchModule;
use Mmb\Action\Section\ResourceMaker;
use Mmb\Action\Section\ResourceSection;

class UserResourceSection extends ResourceSection
{

    protected $for = BotUser::class;

    public function resource(ResourceMaker $maker)
    {
        $this->list($maker->list());

        $this->info($maker->info());
    }

    public function list(ResourceListModule $list)
    {
        $list
            ->label(fn (BotUser $record) => "👤 " . $record->id . " - " . $record->name)
            ->searchable($this->search(...))
            ->orderable()
        ;
    }

    public function info(ResourceInfoModule $info)
    {
        $info
            ->message(fn (BotUser $record) => "👤 " . $record->id)
            ->editable($this->edit(...))
            ->editableSingle("نام", 'name', left: true)
            ->editableSingle("سکه", 'coin', left: true)
            ->deletable($this->delete(...))
            ->schema(fn (Menu $menu, BotUser $record) => [
                // [$menu->key("")]
            ])
        ;
    }

    public function edit(ResourceEditModule $edit)
    {
        $edit
            ->textSingleLine('name', "نام کاربر را وارد کنید:")
        ;
    }

    public function delete(ResourceDeleteModule $delete)
    {
        $delete

        ;
    }

    public function search(ResourceSearchModule $search)
    {
        $search
            ->by('id')
            ->message("شناسه عددی کاربر را وارد کنید:")
            ->enableAllKey() // todo
            ->keyLabelSearching(fn ($query) => "جستجو [$query]") // todo
        ;
    }

}
