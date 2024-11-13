<?php

namespace App\Console\Commands;

use App\Models\NPS\StagingData;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;
use GuzzleHttp\Client;

class PublishSurvey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nps:publish-survey {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blast NPS Survey';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = StagingData::when(!$this->option('force'),function($q){
                                return $q->where('publish_time','<=',Carbon::now()->format('Y-m-d H:i:s'));
                            })
                            ->where('is_published',0)
                            ->get();

        foreach($data as $item){
    
            $encryptedId = Hashids::encode($item->id_transaksi);
            $item->is_published = 1;
            $item->url = route('nps.survey.view').'?id_transaksi='.$encryptedId;
            $item->save();

            // CHECK SETTING BLAST
            $checkEnvironment = @env('CRM_URL') && @env('CRM_TOKEN') && @env('CRM_APPS_URL'); 
            if((@setting('nps_blast_whatsapp') ?? true) && @$item->is_wa && @$item->nomor_hp && @$item->url && $checkEnvironment){
                
                // BLASTING WHATSAPP
                $client = new Client(['verify' => env('SSL_CHECK_DISABLED') ? false : true]);

                // SET URL
                $url = env('CRM_URL').'/whatsapp/broadcast-api/send?token='.env('CRM_TOKEN').'&url='.env('CRM_APPS_URL');

                // SET RECEIVER
                $receiver = $item->nomor_hp;
                if(@$item->nama_pasien) $receiver = ['name' => @$item->nama_pasien, 'number' => $item->nomor_hp];

                // SET BODY
                $params = [];
                $params['form_params'] = [
                    'to' => $receiver,
                    'context' => 'Net Promoter Scores',
                    'message' => "Halo ".@$item->nama_pasien.",\n\nTerima kasih Anda telah menggunakan Produk dan Layanan kami. Berikan Penilaian Anda untuk Kami lebih baik lagi, pada link dibawah ini :\n\n".$item->url,
                ];

                try{
                    $response = $client->request('POST', $url, $params);
                    $resultJson = json_decode($response->getBody()->getContents(), true);
                    // dd($resultJson);
                }catch(\Exception $e){
                    //
                }

            }
        }

        $this->info($data->count().' Survey Published!');
    }
}
