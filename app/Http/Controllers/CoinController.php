<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use App\Models\Coin;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('shiv');
        /*
        this function is used for retrieving coin list and insert in to mysql
        */
        $response = Http::get('https://api.coingecko.com/api/v3/coins/list'
        );
        $data = json_decode($response->body());
        // dd($data);
        /*
        check record is exist if exist then update otherwise create
        */
        foreach ($data as $coin_datas) {
          $coin_datas = (array)$coin_datas;
          Coin::updateOrCreate(
            ['coin_id' => $coin_datas['id']],
            [
              'coin_id' => $coin_datas['id'],
              'symbol' => $coin_datas['symbol'],
              'name' => $coin_datas['name']  
            ]

          );
        }

        $response = [
            'success' => true,
            'data'    => $coin_datas,
            'message' => "All Coins Stored And Retriev Successfully ",
        ];
        return response()->json($response, 200);
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
