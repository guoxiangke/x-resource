<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\Resource;

class ResourceController extends Controller
{
    public function __invoke($keyword){
	    $resource = app("App\Services\Resource");
	    return $resource->__invoke($keyword);
		// 最后一步
	    // TODO finalReply + AI 
    }
}
