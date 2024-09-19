<?php
   
namespace App\Http\Controllers\API\V1;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseAPIController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
   
class BidAPIController extends BaseAPIController
{
    public function index(Request $request)
    {
        return $this->sendResponse(null, 'Hello world on not authenticated route.');
    }

    public function store(Request $request)
    {
        return $this->sendResponse($request, 'Hello world on route that requires token.'); 
    }
}