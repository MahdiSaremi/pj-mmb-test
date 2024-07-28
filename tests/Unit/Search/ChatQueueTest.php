<?php

namespace Tests\Unit\Search;

use App\Models\BotUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Chat\Enums\ChatCategoryEnum;
use Modules\Queue\Enums\GenderEnum;
use Tests\TestCase;

class ChatQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_match()
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

        $queue1 = ChatQueue::create([
            'account_id' => $user1->account->id,
            'category' => ChatCategoryEnum::Global,
            'filter_gender' => null,
        ]);
        $queue2 = ChatQueue::create([
            'account_id' => $user2->account->id,
            'category' => ChatCategoryEnum::Global,
            'filter_gender' => null,
        ]);

        $this->assertTrue($queue1->findMatch()?->is($queue2), "Chat queue matching failed");
    }

    public function test_find_filtered_match()
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
        $user1->account->gender = GenderEnum::Male;
        $user1->push();
        $user2->account->gender = GenderEnum::Female;
        $user2->push();

        $queue1 = ChatQueue::create([
            'account_id' => $user1->account->id,
            'category' => ChatCategoryEnum::Global,
            'filter_gender' => null,
        ]);
        $queue2 = ChatQueue::create([
            'account_id' => $user2->account->id,
            'category' => ChatCategoryEnum::Global,
            'filter_gender' => null,
        ]);

        $queue1->filter_gender = GenderEnum::Female;
        $queue2->filter_gender = GenderEnum::Male;
        $queue1->save();
        $queue2->save();
        $this->assertTrue($queue1->findMatch()?->is($queue2), "Chat queue matching failed");
        $this->assertTrue($queue2->findMatch()?->is($queue1), "Chat queue matching failed");

        $queue1->filter_gender = GenderEnum::Female;
        $queue2->filter_gender = null;
        $queue1->save();
        $queue2->save();
        $this->assertTrue($queue1->findMatch()?->is($queue2), "Chat queue matching failed");
        $this->assertTrue($queue2->findMatch()?->is($queue1), "Chat queue matching failed");

        $queue1->filter_gender = null;
        $queue2->filter_gender = GenderEnum::Male;
        $queue1->save();
        $queue2->save();
        $this->assertTrue($queue1->findMatch()?->is($queue2), "Chat queue matching failed");
        $this->assertTrue($queue2->findMatch()?->is($queue1), "Chat queue matching failed");

        $queue1->filter_gender = GenderEnum::Male;
        $queue2->filter_gender = GenderEnum::Female;
        $queue1->save();
        $queue2->save();
        $this->assertNull($queue1->findMatch(), "Chat queue matching failed");
        $this->assertNull($queue2->findMatch(), "Chat queue matching failed");

        $queue1->filter_gender = null;
        $queue2->filter_gender = GenderEnum::Female;
        $queue1->save();
        $queue2->save();
        $this->assertNull($queue1->findMatch(), "Chat queue matching failed");
        $this->assertNull($queue2->findMatch(), "Chat queue matching failed");

        $queue1->filter_gender = GenderEnum::Male;
        $queue2->filter_gender = null;
        $queue1->save();
        $queue2->save();
        $this->assertNull($queue1->findMatch(), "Chat queue matching failed");
        $this->assertNull($queue2->findMatch(), "Chat queue matching failed");
    }

}
