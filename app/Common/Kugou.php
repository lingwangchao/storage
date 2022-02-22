<?php

namespace App\Common;

use Illuminate\Support\Facades\Http;

class Kugou
{
    public static function search($keyword)
    {
        return Http::get('http://msearchcdn.kugou.com/api/v3/search/song', [
            'pagesize' => '1',
            'keyword' => $keyword,
        ]);
    }

    public static function music_info($hash)
    {
        $results = Http::get('https://m.kugou.com/api/v1/song/get_song_info_v2', [
            'cmd' => 'playInfo',
            'hash' => $hash,
            'mid' => 1,
        ]);
        return [
            'name' => $results['data']['songName'],
            'author_name' => $results['data']['author_name'],
            'img' => str_replace('{size}','400',$results['data']['album_img']),
            'author_img' => str_replace('{size}','400',$results['data']['imgUrl']),
            '128hash' => $results['data']['extra']['128hash'],
            '320hash' => $results['data']['extra']['320hash'],
            'sqhash' => $results['data']['extra']['sqhash'],
            'backup_url' => $results['data']['backup_url'],
        ];
    }

    private static function send($url)
    {
        return Tool::Guzzle_request($url);
    }
}
