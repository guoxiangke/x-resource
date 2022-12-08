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
        $content = "=====节目分组1=====\n【701】灵程真言\n【702】喜乐灵程\n【703】认识你真好 \n【704】真爱驻我家\n【705】尔道自建\n【706】旷野吗哪\n【707】真道分解\n【708】馒头的对话\n【709】拥抱每一天\n【710】星动一刻";
        return [
            'type' => 'text',
            'data' => ['content' => $content]
        ];
    }
// https://depk9mke9ym92.cloudfront.net/tllczy/tllczy221203.mp3
        $res = [
            // https://d3pc7cwodb2h3p.cloudfront.net/all_tllczy_songs.json
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
                'mp3Code' => "tlgr",
                // https://depk9mke9ym92.cloudfront.net/tltl/tlgr221203.mp3
            ],
            '705' =>[
                'title' => '尔道自建',
                'code' => "edzj",
            ],
            '706' =>[
                'title' => '旷野吗哪',
                'code' => "mw",
            ],
            '707' =>[
                'title' => '真道分解',
                'code' => "be",
            ],
            '708' =>[
                'title' => '馒头的对话',
                'code' => "mn",
            ],
            '709' =>[
                'title' => '拥抱每一天',
                'code' => "ee",
            ],
            '710' =>[
                'title' => '星动一刻',
                'code' => "hp",
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

                $mp3 = "https://depk9mke9ym92.cloudfront.net/{$res['code']}/".($res['mp3Code']??$res['code']).substr($jdata['time'],2).".mp3";//$jdata['path']

                // https://d7jf0n9s4n8dc.cloudfront.net/html/tlgr/tlgr221203.html
                $data = [
                    'type' => 'music',
                    "data"=> [
                        "url" => $mp3,
                        'title' => $title,
                        'description' => $jdata['title'],
                        'image' => $image,
                    ],
                ];
                if($jdata['hasArtistHtml']){
                    $weekCode=['ht',1,'tl','ms','pc','sp','gr'];//0-6
                    if($res['code'] == 'tltl'){
                        // 20220910
                        $d = DateTime::createFromFormat('Ymd', $jdata['time']);
                        $dayOfWeek = $d->format('w');
                        if($dayOfWeek==1) return;//周一没有
                        $res['code'] = 'tl' . $weekCode[$dayOfWeek];
                        $res['mp3Code'] = 'tl' . $weekCode[$dayOfWeek];
                    }
                    $addition = [
                        'type' => 'link',
                        'data' => [
                            'image' => $image,
                            "url" => "https://d7jf0n9s4n8dc.cloudfront.net/html/".($res['mp3Code']??$res['code'])."/".($res['mp3Code']??$res['code'])."".substr($jdata['time'],2).".html",
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
