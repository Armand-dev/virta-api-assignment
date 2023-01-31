<?php

namespace Tests\Feature\Controllers;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_stations()
    {
        $response = $this->get('/api/stations');

        $response->assertStatus(200);
    }

    public function test_can_get_specific_station()
    {
        $response = $this->get('/api/stations/1');

        $response->assertStatus(200);
    }

    public function test_can_create_station()
    {
        $response = $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response = $this->post('/api/stations', [
            'name' => 'My new station',
            'latitude' => 12.11231231,
            'longitude' => 12.11231231,
            'company_id' => 1,
            'address' => 'some address',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_station()
    {
        $response = $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response = $this->post('/api/stations', [
            'name' => 'My new station',
            'latitude' => 12.11231231,
            'longitude' => 12.11231231,
            'company_id' => 1,
            'address' => 'some address',
        ]);

        $response = $this->put('/api/stations/1', [
            'name' => 'My new station updated',
            'latitude' => 12.11231231,
            'longitude' => 12.11231231,
            'company_id' => 1,
            'address' => 'some address updated',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_delete_station()
    {
        $response = $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response = $this->post('/api/stations', [
            'name' => 'My new station',
            'latitude' => 12.11231231,
            'longitude' => 12.11231231,
            'company_id' => 1,
            'address' => 'some address',
        ]);

        $response = $this->delete('/api/stations/1');

        $response->assertStatus(200);
    }

    public function test_can_get_stations_in_area()
    {
        $response = $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response = $this->post('/api/stations', [
            'name' => 'My new station',
            'latitude' => 12.11231231,
            'longitude' => 12.11231231,
            'company_id' => 1,
            'address' => 'some address',
        ]);

        $response = $this->post('/api/stations', [
            'name' => 'My new station',
            'latitude' => 59.11231231,
            'longitude' => 90.11231231,
            'company_id' => 1,
            'address' => 'some address',
        ]);

        $response = $this->post('/api/getStationsInArea', [
            'latitude' => 12.100,
            'longitude' => 12.100,
            'distance' => 100,
            'unit' => 'km',
            'company_id' => 1
        ]);

        $response->assertJsonCount(1);
    }
}
