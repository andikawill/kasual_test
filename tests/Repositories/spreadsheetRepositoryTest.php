<?php namespace Tests\Repositories;

use App\Models\spreadsheet;
use App\Repositories\spreadsheetRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class spreadsheetRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var spreadsheetRepository
     */
    protected $spreadsheetRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->spreadsheetRepo = \App::make(spreadsheetRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->make()->toArray();

        $createdspreadsheet = $this->spreadsheetRepo->create($spreadsheet);

        $createdspreadsheet = $createdspreadsheet->toArray();
        $this->assertArrayHasKey('id', $createdspreadsheet);
        $this->assertNotNull($createdspreadsheet['id'], 'Created spreadsheet must have id specified');
        $this->assertNotNull(spreadsheet::find($createdspreadsheet['id']), 'spreadsheet with given id must be in DB');
        $this->assertModelData($spreadsheet, $createdspreadsheet);
    }

    /**
     * @test read
     */
    public function test_read_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->create();

        $dbspreadsheet = $this->spreadsheetRepo->find($spreadsheet->id);

        $dbspreadsheet = $dbspreadsheet->toArray();
        $this->assertModelData($spreadsheet->toArray(), $dbspreadsheet);
    }

    /**
     * @test update
     */
    public function test_update_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->create();
        $fakespreadsheet = spreadsheet::factory()->make()->toArray();

        $updatedspreadsheet = $this->spreadsheetRepo->update($fakespreadsheet, $spreadsheet->id);

        $this->assertModelData($fakespreadsheet, $updatedspreadsheet->toArray());
        $dbspreadsheet = $this->spreadsheetRepo->find($spreadsheet->id);
        $this->assertModelData($fakespreadsheet, $dbspreadsheet->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_spreadsheet()
    {
        $spreadsheet = spreadsheet::factory()->create();

        $resp = $this->spreadsheetRepo->delete($spreadsheet->id);

        $this->assertTrue($resp);
        $this->assertNull(spreadsheet::find($spreadsheet->id), 'spreadsheet should not exist in DB');
    }
}
