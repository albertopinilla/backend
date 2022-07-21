<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;
use App\Jobs\EmailAlertSotck;
use App\Models\User;

class NitificationAlertSotck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'El comando se encarga de validar el stock de todos los productos y envia una notificación en caso de esten por debajo de lo establecido.';

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
     * @return int
     */
    public function handle()
    {
        // Busca todos los prodcutos que tengan un stock igual a menor a lo que se halla definido
        $data = DB::table('products')
            ->where('stock', '<=', config('app.time_alert_stock'))->get();
        
        if(count($data) > 0)
        {
            $emails = User::role(['Administrador','Vendedor'])->pluck('email');
            foreach ($emails as $key => $email) {

                EmailAlertSotck::dispatch( config('mail.from.name'), $email,$data);

            }
        }
      
    }
}
