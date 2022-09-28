<?php

namespace App\Services\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use voku\helper\HtmlDomParser;

final class Kr{
    public function __invoke($keyword)
    {
        // 互联网人的资讯早餐（音频版）周1-5
        if($keyword == "8点1氪"){
            $date = date('ymd');
            $cacheKey = "xbot.keyword.kr";
            $data = Cache::get($cacheKey, false);
            if(!$data){
                $response = Http::get("https://36kr.com/column/491522785281");
                $html = $response->body();
                $htmlTmp = HtmlDomParser::str_get_html($html);
                $mp3 =  $htmlTmp->getElementByTagName('audio')->getAttribute('src');
                $title =  $htmlTmp->getElementByTagName('audio-title')->text();


                $data =[
                    "url" => $mp3,
                    'title' => "【8点1氪】{$date}",
                    'description' => $title,
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
