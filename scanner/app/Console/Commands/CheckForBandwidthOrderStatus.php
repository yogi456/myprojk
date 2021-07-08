<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Bandwidth\BandwidthOrderModel;
use App\Http\Controllers\Bandwidth\Bandwidth;
use DB;
use App\Helpers\CustomLog;


class CheckForBandwidthOrderStatus extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of the bandwidth order status for number';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $date_now  = date('Y-m-d H:i:s');
        $receivedOrders = BandwidthOrderModel::where('order_status','RECEIVED')->get();
        foreach ($receivedOrders as $order) {
            //echo $order->logged_user . PHP_EOL;
            $bandwidth = new Bandwidth();
            $numbers = $bandwidth->checkOrderStatusFromCronOrAjax($order->bandwidth_order_id, $order->logged_user);
        }
        echo 'executed handel';
    }

}
