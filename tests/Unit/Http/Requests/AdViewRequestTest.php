<?php

namespace Http\Requests;

use Tests\RequestTest;
use Tests\util\BrokeValidationTrait;

class AdViewRequestTest extends RequestTest
{
    use BrokeValidationTrait;

    protected $url = '/api/v1/ads';
    protected $method = 'get';
    protected $data = [
        'sortBy' => 'price',
        'descending' => false
    ];

    /** @test */
    public function validate_sortBy_in_array()
    {
        $this->assertGet('sortBy', 'test');
    }
}
