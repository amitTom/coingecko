<?php

namespace App\Console\Commands;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Coin;

class InsertAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:coin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Api Data ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         // dd('shiv');
        /*
        this function is used for retrieving coin list and insert in to mysql
        */
        $response = Http::get('https://api.coingecko.com/api/v3/coins/list?include_platform=true'
        );
        $data = json_decode($response->getBody()->getContents(),true);
        // dd($data);
        /*
        check record is exist if exist then update otherwise create
        */
        foreach ($data as $coin_datas) {
          // $coin_datas = (array)$coin_datas;
          Coin::updateOrCreate(
            ['coin_id' => $coin_datas['id']],
            [
              'coin_id' => $coin_datas['id'],
              'symbol' => $coin_datas['symbol'],
              'name' => $coin_datas['name'],
              'platforms'=>json_encode($coin_datas['platforms']),

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
}
