<?php
namespace App\Google\Facades;

use Illuminate\Support\Facades\Facade;
use App\Google\GoogleClient;

class Google extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GoogleClient::class;
    }
}