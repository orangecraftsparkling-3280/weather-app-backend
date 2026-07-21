<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_api_ping()
    {
        $response = $this->getJson('/api/locations');
        $response->assertStatus(200);
    }

    public function test_can_store_and_retrieve_location()
    {
        $locationData = [
            'city_name' => 'Tokyo',
            'country_code' => 'JP',
            'latitude' => 35.6762,
            'longitude' => 139.6503,
        ];

        // 1. データの保存 (POST)
        $postResponse = $this->postJson('/api/locations', $locationData);
        $postResponse->assertStatus(201);

        // 2. データベースに保存されていることの検証
        $this->assertDatabaseHas('locations', $locationData);

        // 3. データの取得 (GET)
        $getResponse = $this->getJson('/api/locations');
        $getResponse->assertStatus(200);
        $getResponse->assertJsonFragment($locationData);
    }

    public function test_prevents_duplicate_location_registration()
    {
        $locationData = [
            'city_name' => 'Tokyo',
            'country_code' => 'JP',
            'latitude' => 35.6762,
            'longitude' => 139.6503,
        ];

        // 1回目の登録
        $this->postJson('/api/locations', $locationData)->assertSuccessful();

        // 同じデータをもう一度登録
        $secondResponse = $this->postJson('/api/locations', $locationData);
        $secondResponse->assertSuccessful();

        // データベース側のレコード数が「1件」のままであることの検証
        $this->assertDatabaseCount('locations', 1);
    }

    public function test_cannot_store_location_with_invalid_coordinates()
    {
        $invalidData = [
            'city_name' => 'Tokyo',
            'country_code' => 'JP',
            'latitude' => 999.99, // あり得ない緯度
            'longitude' => 139.6503,
        ];

        $response = $this->postJson('/api/locations', $invalidData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['latitude']);
    }
}
