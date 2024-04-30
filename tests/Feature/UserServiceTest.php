<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp():void 
    {
        parent::setUp();

        DB::delete("delete from users");


        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        self::assertTrue($this->userService->login("farel@localhost", "rahasia"));
    }

    public function testLoginUserNotFound()
    {
        self::assertTrue($this->userService->login("farel", "farel"));
    }

    public function testLoginWrongPassword()
    {
        self::assertTrue($this->userService->login("farel", "salah"));

    }
}
