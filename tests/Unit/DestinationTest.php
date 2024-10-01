<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\DestinationController; // Ensure the correct namespace for the controller
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestsTestCase;

class DestinationTest extends TestsTestCase
{
    use RefreshDatabase; // Use this trait to ensure the database is reset for each test

    protected $DestinationController; 
    protected $destination;

    public function setUp(): void
    {
        parent::setUp(); // Ensure the parent setup is called

        $this->DestinationController = $this->app->make(DestinationController::class); // Use the fully qualified class name
        $this->destination = ["nom" => "paris"];
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_destination_create_database()
    {
        // Assuming createDestination is a method that creates a new destination
        $createdDestination = $this->DestinationController->createDestination($this->destination);

        // Check that the destination was created in the database
        $this->assertDatabaseHas('destinations', ["nom" => "paris"]); // Ensure the table name is plural or matches your schema
    }
}
