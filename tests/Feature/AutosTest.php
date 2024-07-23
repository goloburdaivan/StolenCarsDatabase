<?php

namespace Tests\Feature;

use App\Constants\App;
use App\Models\Auto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AutosTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexPagination(): void
    {
        Auto::factory(50)->create();

        $this->get(route('autos.index'))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', App::PER_PAGE)
                    ->etc();
            });
    }

    public function testSearchVinCode(): void
    {
        Auto::factory()->create([
            'vin_code' => '123123',
        ]);
        Auto::factory()->create([
            'vin_code' => 'test',
        ]);

        DB::commit();

        $this->get(route('autos.index', [
            'q' => 'test',
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 1)
                    ->etc();
            });

        Auto::truncate();
    }

    public function testSearchName(): void
    {
        Auto::factory()->create([
            'name' => '123123',
        ]);
        Auto::factory()->create([
            'name' => 'test',
        ]);

        DB::commit();

        $this->get(route('autos.index', [
            'q' => 'test',
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 1)
                    ->etc();
            });

        Auto::truncate();
    }

    public function testSearchPlateNumber(): void
    {
        Auto::factory()->create([
            'plate_number' => '123123',
        ]);
        Auto::factory()->create([
            'plate_number' => 'test',
        ]);

        DB::commit();

        $this->get(route('autos.index', [
            'q' => 'test',
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 1)
                    ->etc();
            });

        Auto::truncate();
    }

    public function testBrandFilter(): void
    {
        Auto::factory(4)->create([
            'brand' => 'test',
        ]);
        Auto::factory(4)->create([
            'brand' => 'test2',
        ]);
        Auto::factory(2)->create([
            'brand' => 'test1',
        ]);

        $this->get(route('autos.index', [
            'brand' => ['test', 'test2'],
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 8)
                    ->etc();
            });
    }

    public function testModelFilter(): void
    {
        Auto::factory(4)->create([
            'model' => 'test',
        ]);
        Auto::factory(4)->create([
            'model' => 'test2',
        ]);
        Auto::factory(2)->create([
            'model' => 'test1',
        ]);

        $this->get(route('autos.index', [
            'model' => ['test', 'test2'],
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 8)
                    ->etc();
            });
    }

    public function testYearFilter(): void
    {
        Auto::factory(4)->create([
            'year' => 2014,
        ]);
        Auto::factory(4)->create([
            'year' => 2015,
        ]);
        Auto::factory(2)->create([
            'year' => 2016,
        ]);

        $this->get(route('autos.index', [
            'year' => [2014, 2015],
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 8)
                    ->etc();
            });
    }

    public function testCombinedFilters(): void
    {
        Auto::factory(4)->create([
            'year' => 2014,
            'brand' => 'test',
            'model' => 'test2',
        ]);
        Auto::factory(4)->create([
            'year' => 2015,
            'model' => 'test2',
            'brand' => 'test',
        ]);
        Auto::factory(2)->create([
            'year' => 2016,
            'brand' => 'test',
            'model' => 'test1',
        ]);

        $this->get(route('autos.index', [
            'year' => [2014, 2015, 2016],
            'brand' => ['test'],
            'model' => ['test2', 'test1'],
        ]))
            ->assertJson(function (AssertableJson $json) {
                return $json->has('paginated', 10)
                    ->etc();
            });
    }

    public function testInvalidDataOnStore(): void
    {
        $this->postJson(route('autos.store'), [
            'test'
        ])
            ->assertUnprocessable();

        $this->assertDatabaseCount('autos', 0);
    }

    public function testStore(): void
    {
        Event::fake();

        $this->postJson(route('autos.store'), [
            'auto' => [
                'vin_code' => 'test',
                'plate_number' => 'test',
                'color' => 'test',
                'name' => 'test',
            ]
        ])
            ->assertCreated();

        $this->assertDatabaseCount('autos', 1);
        $this->assertDatabaseHas('autos', [
            'vin_code' => 'test',
            'plate_number' => 'test',
            'color' => 'test',
            'name' => 'test'
        ]);
    }

    public function testUpdate(): void
    {
        Event::fake();
        $auto = Auto::factory()->create([
            'vin_code' => 'test1',
        ]);

        $this->patchJson(route('autos.update', $auto), [
            'auto' => [
                'vin_code' => 'test',
            ]
        ])
            ->assertOk();

        $this->assertDatabaseCount('autos', 1);
        $this->assertDatabaseHas('autos', [
            'vin_code' => 'test',
        ]);
    }

    public function testDelete(): void
    {
        Event::fake();
        $auto = Auto::factory()->create([
            'vin_code' => 'test1',
        ]);

        $this->deleteJson(route('autos.destroy', $auto))
            ->assertOk();

        $this->assertDatabaseCount('autos', 0);
    }

    public function testDeleteNotFound(): void
    {
        Event::fake();
        $auto = Auto::factory()->create([
            'vin_code' => 'test1',
        ]);

        $this->deleteJson(route('autos.destroy', $auto))
            ->assertOk();

        $this->deleteJson(route('autos.destroy', $auto))
            ->assertNotFound();

        $this->assertDatabaseCount('autos', 0);
    }
}
