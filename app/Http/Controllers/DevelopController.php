<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DevelopController extends Controller
{

    public function index(Request $request)
    {
        $filePath = '/home/nifler/dev.nifler.com/www/public/small.pdf';

        $headers = [
            "content-disposition" => "attachment;filename=\"pdf.pdf\";filename*=UTF-8''pdf.pdf",
            "content-type" => "application/pdf"
        ];

        return response()->download($filePath, 'test', $headers);
        die('asd');


        $client = new Client(['base_uri' => 'https://api.box.com']);

        $res = $client->request('GET', '/2.0/files/256355413868/content', [
            'headers' => [
                'Authorization' => 'Bearer RCUbJN5aLUTGnLT5z5e48SGoxAUNprM9'
            ]
        ]);
        dd($res->getBody()->getContents());
    }


}