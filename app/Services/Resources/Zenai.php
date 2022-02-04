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
                'code' => "tljd"
            ],
            '灵程真言' =>[
                'text' => "https://d7jf0n9s4n8dc.cloudfront.net/html/tllczy/tllczy{$date}.html",
                'image' => 'https://img-1253798207.file.myqcloud.com/tllczy.png',
                'code' => "tllczy"
            ],
            '真爱驻我家' =>[
                'text' => "https://d7jf0n9s4n8dc.cloudfront.net/html/tlsp/tlsp{$date}.html",
                'image' => 'https://img-1253798207.file.myqcloud.com/tltl.png',
                'code' => "tlsp"
            ]
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
