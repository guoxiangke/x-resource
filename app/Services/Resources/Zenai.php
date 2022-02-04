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
                'cdn' => 'cdnapi',
            ],
            '灵程真言' =>[ // 1 - 7
                'imageCode' => 'tllczy',
                'image' => 'https://img-1253798207.file.myqcloud.com/tllczy.png',
                'code' => "tllczy",
                'textCode' => "tllczy",
                'cdn' => 'cdnapi',
            ],
            '真爱驻我家' =>[
                'imageCode' => 'tltl',
                'code' => "tlsp",
                'textCode' => "tlsp",
                'cdn' => 'cdnapi',
            ],
            '认识你真好' =>[
                'imageCode' => 'vof',
                'code' => "vof",
                'textCode' => "vof",
                'cdn' => 'silk',
            ],
        ];

        if(in_array($keyword, array_keys($res))){
            $res = $res[$keyword];
            return [
            	'type' => 'music',
            	"data"=> [
                    "url" => "http://{$res['silk']}.yongbuzhixi.com/{$res['code']}{$date}.mp3",
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
