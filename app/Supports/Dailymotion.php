<?php
/**
 * Created by PhpStorm.
 * User: PutriDamayanti
 * Date: 11/17/2018
 * Time: 7:47 AM
 */

namespace App\Supports;


use GuzzleHttp\Client;

class Dailymotion
{
    public function getVideo($url, $params) {
        $client = new Client();
        $request = $client->request('GET', $url.'/videos', ['query' => $params]);
        $result = json_decode($request->getBody()->getContents());

        return response()->json($result->list);
    }
}