<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    protected $thread;
    protected $owner;

    public function setUp()
    {
        parent::setUp();

        $this->owner = factory(User::class)->create();
        $this->thread = factory(Thread::class)->create([
            'user_id' => $this->owner->id
        ]);
    }

    /** @test */
    public function aThreadHasCreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }
    
    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function createThreadWithoutOwner()
    {
        $thread = factory(Thread::class)->create([
            'user_id' => null,
        ]);

        $this->assertDatabaseHas('threads', [
            'id' => $thread->id
        ]);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function createThreadWithoutTitle()
    {
        $thread = factory(Thread::class)->create([
            'title' => null,
        ]);

        $this->assertDatabaseHas('threads', [
            'id' => $thread->id
        ]);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function createThreadWithoutBody()
    {
        $thread = factory(Thread::class)->create([
            'body' => null,
        ]);

        $this->assertDatabaseHas('threads', [
            'id' => $thread->id
        ]);
    }

    /** @test */
    public function createThread()
    {
        $thread = factory(Thread::class)->create();

        $this->assertDatabaseHas('threads', [
            'id' => $thread->id
        ]);
    }

    /** @test */
    public function aThreadHasPath()
    {
        $this->assertEquals('http://localhost/threads/' . $this->thread->id, $this->thread->path());
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function aThreadDoesNotHasPath()
    {
        $thread = new Thread();

        $this->assertEquals('http://localhost/threads/' . $thread->id, $thread->path());
    }

    /**
     * @test
     */
    public function aThreadCanAddReply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
