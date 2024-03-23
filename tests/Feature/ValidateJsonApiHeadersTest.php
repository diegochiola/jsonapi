<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;
 /** @test **/
    public function accept_header_must_be_present_in_all_requests(): void
    {
        //probar ruta que este utilizando middelware
        Route::get('test_route', function(){
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);
        $this->get('test_route')->assertStatus(406);
    }
}
