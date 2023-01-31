<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_companies()
    {
        $response = $this->get('/api/companies');

        $response->assertStatus(200);
    }

    public function test_can_get_specific_company()
    {
        $response = $this->get('/api/companies/1');

        $response->assertStatus(200);
    }

    public function test_can_create_company()
    {
        $response = $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_company()
    {
        $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response = $this->patch('/api/companies/1', [
            'name' => 'My new company updated'
        ]);

        $response->assertStatus(201);
    }

    public function test_can_delete_company()
    {
        $response = $this->post('/api/companies', [
            'name' => 'My new company'
        ]);

        $response = $this->delete('/api/companies/1');

        $response->assertStatus(200);
    }
}
