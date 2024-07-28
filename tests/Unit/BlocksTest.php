<?php

namespace Tests\Unit;

use App\Models\BotUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Account\Models\Account;
use Tests\TestCase;

class BlocksTest extends TestCase
{
    use RefreshDatabase;

    public function test_blocks()
    {
        $user1 = BotUser::create([
            'id' => 100,
            'name' => 'A',
            'step' => '',
        ]);
        $user2 = BotUser::create([
            'id' => 200,
            'name' => 'B',
            'step' => '',
        ]);

        $a = $user1->account;
        $b = $user2->account;

        $a->blocks()->attach($b->id);

        $this->assertTrue($a->isBlocked($b));
        $this->assertFalse($a->isBlockedBy($b));

        $this->assertFalse($b->isBlocked($a));
        $this->assertTrue($b->isBlockedBy($a));
    }

    public function test_the_blocked_account_cannot_see_the_blocker()
    {
        $user1 = BotUser::create([
            'id' => 300,
            'name' => 'A',
            'step' => '',
        ]);
        $user2 = BotUser::create([
            'id' => 400,
            'name' => 'B',
            'step' => '',
        ]);

        $a = $user1->account;
        $b = $user2->account;

        $a->blocks()->attach($b->id);

        $accounts = Account::withoutBlocks($b)->get()->pluck('id');

        $this->assertNotContains($a->id, $accounts);
        $this->assertContains($b->id, $accounts);
    }

    public function test_the_account_cannot_see_the_blocked_accounts()
    {
        $user1 = BotUser::create([
            'id' => 300,
            'name' => 'A',
            'step' => '',
        ]);
        $user2 = BotUser::create([
            'id' => 400,
            'name' => 'B',
            'step' => '',
        ]);

        $a = $user1->account;
        $b = $user2->account;

        $a->blocks()->attach($b->id);

        $accounts = Account::withoutBlocks($a)->get()->pluck('id');

        $this->assertContains($a->id, $accounts);
        $this->assertNotContains($b->id, $accounts);
    }

}
