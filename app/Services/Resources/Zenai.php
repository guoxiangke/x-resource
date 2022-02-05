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
            '喜乐灵程' =>[ // 1-7
                'imageCode' => 'tljd',
                'code' => "tljd",
                'textCode' => "tljd",
            ],
            '灵程真言' =>[ // 1 - 7
                'imageCode' => 'tllczy',
                'image' => 'https://img-1253798207.file.myqcloud.com/tllczy.png',
                'code' => "tllczy",
                'textCode' => "tllczy",
            ],
            '真爱驻我家' =>[ // 1 - 5
                'imageCode' => 'tltl',
                'code' => "tlsp",
                'textCode' => "tlsp",
            ],
            '认识你真好' =>[
                'imageCode' => 'vof',
                'code' => "vof",
                'textCode' => "vof",
            ],
        ];

        if(in_array($keyword, array_keys($res))){
            $res = $res[$keyword];
            $url = "http://dailyaudio-1253798207.file.myqcloud.com/{$res['code']}{$date}.mp3";
            if($keyword == '认识你真好')
                $url = "https://febc-1253798207.file.myqcloud.com/vof/{$res['code']}{$date}.mp3";
            if(date('N')>5 && $keyword == '真爱驻我家') return null;
            return [
            	'type' => 'music',
            	"data"=> [
                    "url" => $url,
                    'title' => "【{$keyword}】{$date}",
                    'description' => '真爱驻我家',
                ],
                'addition' =>[
                    'type' => 'link',
                    'data' => [
                        'image' => "https://img-1253798207.file.myqcloud.com/{$res['imageCode']}.png",
                        "url" => "https://d7jf0n9s4n8dc.cloudfront.net/html/{$res['textCode']}/{$res['textCode']}{$date}.html",
                        'title' => "【{$keyword}】{$date}",
                        'description' => '节目文本 真爱驻我家',
                    ],
                ],
            ];
        }
        return null;
	}
}
