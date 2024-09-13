<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller class that other controllers extend from.
 * Includes authorization and validation traits.
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}