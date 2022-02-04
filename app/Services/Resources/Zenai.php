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

        $date = date('ymd');
        $res = [
            '喜乐灵程' =>[
                'text' => "https://d7jf0n9s4n8dc.cloudfront.net/html/tljd/tljd{$date}.html",
                'image' => 'https://img-1253798207.file.myqcloud.com/tljd.png',
                'audio' => "http://dailyaudio-1253798207.file.myqcloud.com/tljd{$date}.mp3"
            ],
            '灵程真言' =>[
                'text' => "https://d7jf0n9s4n8dc.cloudfront.net/html/tllczy/tllczy{$date}.html",
                'image' => 'https://img-1253798207.file.myqcloud.com/tllczy.png',
                'audio' => "http://dailyaudio-1253798207.file.myqcloud.com/tllczy{$date}.mp3"
            ],
            '真爱驻我家' =>[
                'text' => "https://d7jf0n9s4n8dc.cloudfront.net/html/tlsp/tlsp{$date}.html",
                'image' => 'https://img-1253798207.file.myqcloud.com/tltl.png',
                'audio' => "http://dailyaudio-1253798207.file.myqcloud.com/tlsp{$date}.mp3"
            ],
            '认识你真好' =>[
                'text' => "https://d7jf0n9s4n8dc.cloudfront.net/html/vof/vof{$date}.html",
                'image' => 'https://img-1253798207.file.myqcloud.com/vof.png',
                'audio' => "https://febc-1253798207.file.myqcloud.com/vof/vof{$date}.mp3"
            ],
        ];

        if(in_array($keyword, array_keys($res))){
            $res = $res[$keyword];
            return [
            	'type' => 'music',
            	"data"=> [
                    "url" => $res['audio'],
                    'title' => "【{$keyword}】{$date}",
                    'description' => '真爱驻我家',
                ],
                'addition' =>[
                    'type' => 'link',
                    'data' => [
                        'image' => $res['image'],
                        "url" => $res['text'],
                        'title' => "【{$keyword}】{$date}",
                        'description' => '节目文本 真爱驻我家',
                    ],
                ],
            ];
        }
        return null;
	}
}
