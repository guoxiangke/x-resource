<?php

namespace App\Services\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use voku\helper\HtmlDomParser;

final class Zenai {
	public function __invoke($keyword) {
        if($keyword == "喜乐灵程"){
            $date = date('ymd');
            return [
            	'type' => 'music',
            	"data"=> [
                    "url" => "http://dailyaudio-1253798207.file.myqcloud.com/tljd{$date}.mp3",
                    'title' => "【喜乐灵程】{$date}",
                    'description' => '真爱驻我家',
                ],
                'addition' =>[
                    'type' => 'link',
                    'data' => [
                        'image' => 'https://img-1253798207.file.myqcloud.com/tljd.png',
                        "url" => "https://d7jf0n9s4n8dc.cloudfront.net/html/tljd/tljd{$date}.html",
                        'title' => "【喜乐灵程】{$date}",
                        'description' => '节目文本',
                    ],
                ],
            ];
        }
        return null;
	}
}
