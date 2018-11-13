<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

      public function log($text)
    {
        fwrite(STDOUT, "\n \033[32m".'|=> '.$text."\n \033[0m");
    }
    public function noCsrf()
    {
    	return $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }
}
