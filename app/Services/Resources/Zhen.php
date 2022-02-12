<?php

namespace App\Services\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use voku\helper\HtmlDomParser;

final class Zan{
	public function __invoke($keyword)
	{
        if($keyword == '说真的'){
            // 真爱驻我家 是周日周一休息
            if((date('N')==1 || date('N')==7)) return null;

            $url = 'https://abp-1253798207.file.myqcloud.com/all_tltl_songs.json';
            $json = Http::get($url)->json();
            $count = count($json);
            $item = last($json);
            return [
                'type' => 'music',
                "data"=> [
                    "url" => $item['path'],
                    'title' => "【说真的】" . $item['time'],
                    'description' => $item['title'],
                ],
            ];
        }
        return null;
	}
}
