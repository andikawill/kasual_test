<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\spreadsheet;

class spreadsheetApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/spreadsheets', $spreadsheet
        );

        $this->assertApiResponse($spreadsheet);
    }

    /**
     * @test
     */
    public function test_read_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/spreadsheets/'.$spreadsheet->id
        );

        $this->assertApiResponse($spreadsheet->toArray());
    }

    /**
     * @test
     */
    public function test_update_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->create();
        $editedspreadsheet = spreadsheet::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/spreadsheets/'.$spreadsheet->id,
            $editedspreadsheet
        );

        $this->assertApiResponse($editedspreadsheet);
    }

    /**
     * @test
     */
    public function test_delete_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/spreadsheets/'.$spreadsheet->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/spreadsheets/'.$spreadsheet->id
        );

        $this->response->assertStatus(404);
    }
}
