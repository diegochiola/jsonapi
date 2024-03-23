<?php

namespace Tests;
use Tests\MakeJsonApiRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakesJsonApiRequests;
   
}