<?php

namespace Tests\Unit\Http\Requests;

use App\Domain\Models\Ad;
use Illuminate\Support\Str;
use Tests\RequestTest;

class AdStoreRequestTest extends RequestTest
{
    protected $url = '/api/v1/ad';
    protected $model = Ad::class;
    protected $method = 'post';

    /** @test */
    public function validate_name_required()
    {
        $this->assertPost('name', null);
    }

    /** @test */
    public function validate_name_max_length()
    {
        $this->assertPost('name', Str::random(201));
    }

    /** @test */
    public function validate_name_min_length()
    {
        $this->assertPost('name', Str::random(4));
    }

    /** @test */
    public function validate_description_max_length()
    {
        $this->assertPost('description', Str::random(1001));
    }

    /** @test */
    public function validate_price_required()
    {
        $this->assertPost('price', null);
    }

    /** @test */
    public function validate_price_is_numeric()
    {
        $this->assertPost('price', 's');
    }


    /** @test */
    public function validate_photo_is_array()
    {
        $this->assertPost('photo', '');
    }

    /** @test */
    public function validate_photo_array_max_length()
    {
        $this->assertPost('photo', [1, 1, 1, 1]);
    }

    /** @test */
    public function validate_photo_is_url()
    {
        $this->assertPost('photo.0.url', [['url' => 1]]);
    }

    /** @test */
    public function validate_photo_url_is_distinct()
    {
        $this->assertPost(
            'photo',
            [['url' => 'https://url.ru'], ['url' => 'https://url.ru']],
            'photo.0.url'
        );
    }
}
