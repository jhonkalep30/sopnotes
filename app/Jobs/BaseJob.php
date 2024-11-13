<?php

namespace App\Jobs;

use App\Models\JobTrace;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;
use Symfony\Component\Process\Process;
use Maatwebsite\Excel\Facades\Excel;

class BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    protected $trace,$params,$type,$className;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JobTrace $trace, $params, $type)
    {
        $this->trace = $trace;
        $this->params = $params;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $title = $this->trace->title;
            
            if($this->type == 'export'){
                $fileName = $title.' (@'.Carbon::now()->format('YmdHis').').xlsx';

                (new $this->trace->model($this->params))->store('public/exports/'.$fileName);

                $url = asset(Storage::url('public/exports/'.$fileName));

                clearstatcache();
    
                $this->trace->update([
                    'status' => JobTrace::SUCCESS,
                    'file_path' => $url,
                    'file_size' => filesize(public_path(Storage::url('public/exports/'.$fileName))),
                ]);
            }else{

                $exp = explode('imports/', $this->trace->file_path);

                Excel::import(new $this->trace->model, storage_path('app/public/imports/'.$exp[1]));

                $this->trace->update([
                    'status' => JobTrace::SUCCESS,
                ]);
            }


        }catch(\Exception $ex){
            $this->trace->update([
                'status' => JobTrace::FAILED,
                'logs' => $ex->getMessage(),
            ]);
        }
    }

    public function failed(\Exception $exception)
    {
        // Send user notification of failure, etc...
        $this->trace->update([
            'status' => JobTrace::FAILED,
            'logs' => $exception->getMessage(),
        ]);

        // File::deleteDirectory($this->trace->path, $this->trace->name);
    }
}
