<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function userCanRegister()
    {
        $this->assertDatabaseHas('users', [
            'email' => $this->user->email
        ]);
    }

    /** @test */
    public function registeredUserCanLogin()
    {
        Auth::loginUsingId($this->user->id);
        $this->assertEquals($this->user->id, Auth::user()->id);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function userCannotRegisterWithoutCorrectData()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => null,
            'password' => null,
            'remember_token' => null,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function userEmailMustBeUnique()
    {
        $user = User::create([
            'name' => 'Another User',
            'email' => $this->user->email,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret,
            'remember_token' => str_random(10),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
    }
}
