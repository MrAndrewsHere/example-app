<?php

namespace Http\Requests;

use App\Domain\Models\Ad;
use Illuminate\Support\Arr;
use Tests\RequestTest;
use Tests\util\BrokeValidationTrait;

class AdGetOneRequestTest extends RequestTest
{
    use BrokeValidationTrait;

    protected $url = '/api/v1/ad';

    protected $method = 'get';

    protected $data = [
        'id' => 1,
        'fields' => ['photo', 'description'],
    ];

    /** @test */
    public function validate_id_required()
    {
        $this->assertGet('id', null);
    }

    /** @test */
    public function validate_id_exist()
    {
        $this->assertGet('id', 0);
    }

    /** @test */
    public function validate_extra_is_array()
    {
        Arr::set($this->data, 'id', Ad::factory()->create()->id);
        $this->assertGet('fields', '');
    }

    /** @test */
    public function validate_extras_in_array()
    {
        Arr::set($this->data, 'id', Ad::factory()->create()->id);
        $this->assertGet('fields', ['photo', 'password'], 'fields.1');
    }
}
