<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    protected $thread;
    protected $threadOwner;
    protected $replyOwner;
    protected $reply;

    public function setUp()
    {
        parent::setUp();
        $this->threadOwner = factory(User::class)->create();
        $this->thread = factory(Thread::class)->create([
            'user_id' => $this->threadOwner->id
        ]);
        $this->replyOwner = factory(User::class)->create();
        $this->reply = factory(Reply::class)->create([
            'thread_id' => $this->thread->id,
            'user_id' => $this->replyOwner->id,
        ]);
    }

    /** @test */
    public function replyHasCreator()
    {
        $this->assertInstanceOf(User::class, $this->reply->creator);
    }
}
