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
                'image' => 'https://img-1253798207.file.myqcloud.com/tljd.png',
                'code' => "tljd"
            ],
            '灵程真言' =>[
                'image' => 'https://img-1253798207.file.myqcloud.com/tllczy.png',
                'code' => "tllczy"
            ],
            '真爱驻我家' =>[
                'image' => 'https://img-1253798207.file.myqcloud.com/tltl.png',
                'code' => "tlsp"
            ],
            '认识你真好' =>[
                'image' => 'https://img-1253798207.file.myqcloud.com/tltl.png',
                'code' => "vof"
            ],
        ];

        if(in_array($keyword, array_keys($res))){
            $res = $res[$keyword];
            return [
            	'type' => 'music',
            	"data"=> [
                    "url" => "http://cdnapi.yongbuzhixi.com/{$res['code']}{$date}.mp3",
                    'title' => "【{$keyword}】{$date}",
                    'description' => '真爱驻我家',
                ],
                'addition' =>[
                    'type' => 'link',
                    'data' => [
                        'image' => $res['image'],
                        "url" => "https://d7jf0n9s4n8dc.cloudfront.net/html/{$res['code']}/{$res['code']}{$date}.html",
                        'title' => "【{$keyword}】{$date}",
                        'description' => '节目文本 真爱驻我家',
                    ],
                ],
            ];
        }
        return null;
	}
}
