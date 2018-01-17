<?php

namespace App\Http\Controllers;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class StripeController extends Controller
{

    protected function storageClear()
    {
        $files = \File::allFiles(storage_path('user_uploads'));
        foreach ($files as $file) {
            //dd(\File::lastModified($file), time()+15, \File::lastModified($file) < time()-15);
            if (\File::lastModified($file) < time()-15) {
                \File::delete((string)$file);
            }
        }
    }

    public function index()
    {
        $storage = \Storage::disk('user_uploads');
        $storage->put('./' . 'hello'.time(), 'hello'.time());
        $path = ( storage_path('user_uploads')."/hello".time());
        $this->storageClear();
        dd($path,'end');

        return view('Stripe.iframe');
        phpinfo();
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "https://api.box.com".'/2.0/files/' . '259992740947' . '/content');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_VERBOSE, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization: Bearer J4z3GdpIAnWlY9oMeu7jnN8WPQ4jyPzm'
//        ));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//        $header = substr($output, 0, $header_size);
//        $body = substr($output, $header_size);
//        dd($header_size, $header, $body);
//
//        dd('a');
        $client = new Client(['base_uri' => 'https://api.box.com']);
        $downloadFileUrl = '/2.0/files/' . '259992740947' . '/content';

        $res = $client->request('GET', $downloadFileUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . 'J4z3GdpIAnWlY9oMeu7jnN8WPQ4jyPzm',
                'Connection' => 'keep-alive'
            ],
            RequestOptions::ALLOW_REDIRECTS => false
        ]);
        dd($res->getStatusCode(),$res->getHeaders());
        dd($res->getHeaderLine('Location'));
        $storage = \Storage::disk('user_uploads');
       // $storage->put('./' . $fileName, $res->getBody()->getContents());
        $path = ( storage_path('user_uploads')."/$fileName");
        return $path;

        return view('Stripe.iframe');
    }

    public function store(Request $request)
    {
        dd($request->all());
        return view('Stripe.form');
    }


}