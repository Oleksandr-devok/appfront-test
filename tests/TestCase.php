<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase;
    public $user;
    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
       
    
    }
}
