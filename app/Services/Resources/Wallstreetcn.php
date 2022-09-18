<?php

namespace App\Services\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class Wallstreetcn{
	public function __invoke($keyword) {
        if($keyword == "华尔街见闻早餐"){
            $date = date('ymd');
            $cacheKey = "xbot.keyword.Wallstreetcn";
            $data = Cache::get($cacheKey, false);
            if(!$data){
                $response = Http::get("https://api-one-wscn.awtmt.com/apiv1/search/article?query=华尔街见闻早餐&cursor=&limit=1&vip_type=");
                $json =$response->json();
                $id = $json['data']['items'][0]['id'];


                $response = Http::get("https://api-one-wscn.awtmt.com/apiv1/content/articles/{$id}?extract=0");
                $json =$response->json();
                $mp3 =  $json['data']['audio_uri'];

                $title = "华尔街见闻早餐:{$date}";
				$desc = "市场有风险，投资需谨慎。本文不构成个人投资建议";
                $data =[
                    "url" => $mp3,
                    'title' => $title,
                    'description' => $desc,
                ];
                Cache::put($cacheKey, $data, strtotime('tomorrow') - time());
            }
            return [
                'type' => 'music',
                "data"=> $data,
            ];
        }
	}
}
