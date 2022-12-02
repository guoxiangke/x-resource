<?php

namespace App\Services\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class Zenai {
	public function __invoke($keyword) {

    if($keyword == 700){
        $content = "=====节目分组1=====\n【701】灵程真言\n【702】喜乐灵程\n【703】认识你真好 \n【704】真爱驻我家\n【705】尔道自建\n=====节目分组2=====\n【698】馒头的对话\n【619】拥抱每一天\n【610】星动一刻\n【621】真道分解\n【620】旷野吗哪";
        return [
            'type' => 'text',
            'data' => ['content' => $content]
        ];
    }

        $res = [
            // https://d3pc7cwodb2h3p.cloudfront.net/all_vof_songs.json
            '701' =>[ // 1 - 7
                'title' => '灵程真言',
                'code' => "tllczy",
            ],
            '702' =>[ // 1-7
                'title' => '喜乐灵程',
                'code' => "tljd",
            ],
            '703' =>[//1-7
                'title' => '认识你真好',
                'code' => "vof",
            ],
            '704' =>[ // 1 - 5 真爱驻我家 是周一休息
                'title' => '真爱驻我家',
                'code' => "tltl",
            ],
            '705' =>[
                'title' => '尔道自建',
                'code' => "edzj",
            ],
        ];

        if(in_array($keyword, array_keys($res))){
            $cacheKey = "xbot.700.{$keyword}";
            $data = Cache::get($cacheKey, false);
            if($data) return $data;

            if(!$data){
                $res = $res[$keyword];
                $response = Http::get("https://d3pc7cwodb2h3p.cloudfront.net/all_{$res['code']}_songs.json");
                $json =$response->json();
                $jdata = last($json);
                $title = "【{$keyword}】{$res['title']}-".substr($jdata['time'],2);
                $image = "https://d33tzbj8j46khy.cloudfront.net/{$res['code']}.png";
                $data = [
                    'type' => 'music',
                    "data"=> [
                        "url" => $jdata['path'],
                        'title' => $title,
                        'description' => $jdata['title'],
                        'image' => $image,
                    ],
                ];
                if($jdata['hasArtistHtml']){
                    $addition = [
                        'type' => 'link',
                        'data' => [
                            'image' => $image,
                            "url" => "https://d7jf0n9s4n8dc.cloudfront.net/html/{$res['code']}/{$res['code']}".substr($jdata['time'],2).".html",
                            'title' => $title,
                            'description' => '节目文本-'. $jdata['title'],
                        ],
                    ];
                    $data = array_merge($data,['addition'=>$addition]);
                    Cache::put($cacheKey, $data, strtotime('tomorrow') - time());
                    return $data;
                }
                Cache::put($cacheKey, $data, strtotime('tomorrow') - time());
                return $data;
            }
        }
        return null;
	}
}
