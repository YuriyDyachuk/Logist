<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order\Order;
use App\Services\GeoService;

use App\Models\OrderGeo;


class OptimizeGeoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function optimizageo(Request $request)
    {
        $order_id = 551;
        $orders = Order::where('user_id',131)->where('current_status_id',1)->whereNull('is_vat')->get();
        $new_array = [];
        foreach ($orders as $order)
        {
            if (!OrderGeo::where('order_id',$order->id)->first())
            {
                $new_array = GeoService::geoOptimize($order->id);
                $order_id = $order->id;
                $order->is_vat=0;
                $order->save();
                break;
            }
        }
        
        $count_beg = $order_id;
        $count_end = count($new_array);
        return view('testroute.index')
            ->with('geo',$new_array)
            ->with('count_beg',$count_beg)
            ->with('count_end',$count_end)
            ->with('directions',$order->directions);
    }
    public function optimizaGeoById($order_id)
    {
        GeoService::geoOptimize($order_id);
    }

    public function optimizaOnlineGeoById($order_id)
    {
        GeoService::geoOnlineOptimize($order_id);
    }
    public function optimizaTest()
    {
        $request = '{"data":[{"datetime":"2019-08-21 02:22:59","lat":49.6015298,"lng":25.5640687,"odometer":122.40512,"order_id":575,"speed":20.10000038147,"transport_id":0},{"datetime":"2019-08-21 02:23:00","lat":49.6015147,"lng":25.5643447,"odometer":122.42484,"order_id":575,"speed":19.870000839233,"transport_id":0},{"datetime":"2019-08-21 02:23:01","lat":49.6015024,"lng":25.5646194,"odometer":122.44439,"order_id":575,"speed":19.670000076294,"transport_id":0},{"datetime":"2019-08-21 02:23:10","lat":49.6014963,"lng":25.566957,"odometer":122.60798,"order_id":575,"speed":17.540000915527,"transport_id":0},{"datetime":"2019-08-21 02:23:11","lat":49.6015046,"lng":25.5671993,"odometer":122.62468,"order_id":575,"speed":17.190000534058,"transport_id":0},{"datetime":"2019-08-21 02:23:12","lat":49.601515,"lng":25.5674422,"odometer":122.641365,"order_id":575,"speed":17.530000686646,"transport_id":0},{"datetime":"2019-08-21 02:23:13","lat":49.6015255,"lng":25.5676695,"odometer":122.65696,"order_id":575,"speed":16.360000610352,"transport_id":0},{"datetime":"2019-08-21 02:23:14","lat":49.6015347,"lng":25.5678966,"odometer":122.67258,"order_id":575,"speed":16.340000152588,"transport_id":0},{"datetime":"2019-08-21 02:23:15","lat":49.6015432,"lng":25.5681114,"odometer":122.68736,"order_id":575,"speed":15.260000228882,"transport_id":0},{"datetime":"2019-08-21 03:23:17","lat":49.5397415,"lng":25.8017851,"odometer":140.80428,"order_id":575,"speed":12.260000228882,"transport_id":0},{"datetime":"2019-08-21 03:23:18","lat":49.5397218,"lng":25.8019516,"odometer":140.81647,"order_id":575,"speed":12.670000076294,"transport_id":0},{"datetime":"2019-08-21 03:23:19","lat":49.5396998,"lng":25.8021245,"odometer":140.82918,"order_id":575,"speed":12.430000305176,"transport_id":0},{"datetime":"2019-08-21 03:23:20","lat":49.5396741,"lng":25.8022976,"odometer":140.842,"order_id":575,"speed":13.140000343323,"transport_id":0},{"datetime":"2019-08-21 03:23:21","lat":49.5396518,"lng":25.8024797,"odometer":140.85536,"order_id":575,"speed":13.729999542236,"transport_id":0},{"datetime":"2019-08-21 03:23:22","lat":49.539637,"lng":25.8026519,"odometer":140.8678,"order_id":575,"speed":14.130000114441,"transport_id":0},{"datetime":"2019-08-21 03:23:23","lat":49.5396094,"lng":25.8028475,"odometer":140.88225,"order_id":575,"speed":14.869999885559,"transport_id":0},{"datetime":"2019-08-21 03:23:24","lat":49.5395854,"lng":25.8030482,"odometer":140.89696,"order_id":575,"speed":15,"transport_id":0},{"datetime":"2019-08-21 03:23:25","lat":49.5395588,"lng":25.8032567,"odometer":140.91228,"order_id":575,"speed":15.590000152588,"transport_id":0},{"datetime":"2019-08-21 03:23:26","lat":49.5395297,"lng":25.8034675,"odometer":140.92784,"order_id":575,"speed":15.859999656677,"transport_id":0},{"datetime":"2019-08-21 03:23:27","lat":49.5395021,"lng":25.803687,"odometer":140.94397,"order_id":575,"speed":15.89999961853,"transport_id":0},{"datetime":"2019-08-21 04:21:50","lat":49.5414763,"lng":25.8211749,"odometer":142.10268,"order_id":575,"speed":2.8599998950958,"transport_id":0},{"datetime":"2019-08-21 04:23:27","lat":49.5451598,"lng":25.8350452,"odometer":142.96046,"order_id":575,"speed":15.890000343323,"transport_id":0},{"datetime":"2019-08-21 04:23:28","lat":49.5451837,"lng":25.8352629,"odometer":142.97496,"order_id":575,"speed":15.880000114441,"transport_id":0},{"datetime":"2019-08-21 04:23:29","lat":49.5452036,"lng":25.8354827,"odometer":142.9897,"order_id":575,"speed":15.670000076294,"transport_id":0},{"datetime":"2019-08-21 04:23:30","lat":49.5452276,"lng":25.8356941,"odometer":143.00375,"order_id":575,"speed":15.75,"transport_id":0},{"datetime":"2019-08-21 04:23:31","lat":49.5452485,"lng":25.8359065,"odometer":143.01796,"order_id":575,"speed":15.770000457764,"transport_id":0},{"datetime":"2019-08-21 04:23:32","lat":49.5452673,"lng":25.8361196,"odometer":143.03227,"order_id":575,"speed":15.890000343323,"transport_id":0},{"datetime":"2019-08-21 04:23:33","lat":49.5452844,"lng":25.836332,"odometer":143.0466,"order_id":575,"speed":15.939999580383,"transport_id":0},{"datetime":"2019-08-21 04:23:34","lat":49.5453104,"lng":25.8365449,"odometer":143.06067,"order_id":575,"speed":16.059999465942,"transport_id":0},{"datetime":"2019-08-21 04:23:35","lat":49.545325,"lng":25.8367699,"odometer":143.07596,"order_id":575,"speed":15.829999923706,"transport_id":0},{"datetime":"2019-08-21 04:23:36","lat":49.5453382,"lng":25.8369904,"odometer":143.09096,"order_id":575,"speed":16.069999694824,"transport_id":0},{"datetime":"2019-08-21 04:23:37","lat":49.5453558,"lng":25.8372111,"odometer":143.10583,"order_id":575,"speed":15.930000305176,"transport_id":0},{"datetime":"2019-08-21 04:56:48","lat":49.512804,"lng":26.2015704,"odometer":169.52908,"order_id":575,"speed":17.75,"transport_id":0},{"datetime":"2019-08-21 05:20:23","lat":49.4817101,"lng":26.4812292,"odometer":190.01518,"order_id":575,"speed":18.25,"transport_id":0},{"datetime":"2019-08-21 05:23:46","lat":49.4669043,"lng":26.5244848,"odometer":193.45909,"order_id":575,"speed":18.879999160767,"transport_id":0},{"datetime":"2019-08-21 05:23:47","lat":49.4668702,"lng":26.5247414,"odometer":193.47806,"order_id":575,"speed":18.620000839233,"transport_id":0},{"datetime":"2019-08-21 05:23:48","lat":49.4668259,"lng":26.5249969,"odometer":193.49722,"order_id":575,"speed":18.879999160767,"transport_id":0},{"datetime":"2019-08-21 05:23:49","lat":49.466793,"lng":26.5252444,"odometer":193.5155,"order_id":575,"speed":18.489999771118,"transport_id":0},{"datetime":"2019-08-21 05:23:50","lat":49.4667494,"lng":26.5254946,"odometer":193.53429,"order_id":575,"speed":18.700000762939,"transport_id":0},{"datetime":"2019-08-21 05:23:51","lat":49.4666919,"lng":26.5257297,"odometer":193.55237,"order_id":575,"speed":18.479999542236,"transport_id":0},{"datetime":"2019-08-21 05:23:52","lat":49.4666325,"lng":26.5259652,"odometer":193.57054,"order_id":575,"speed":18.540000915527,"transport_id":0},{"datetime":"2019-08-21 05:23:53","lat":49.4665677,"lng":26.5262002,"odometer":193.58884,"order_id":575,"speed":18.64999961853,"transport_id":0},{"datetime":"2019-08-21 05:23:54","lat":49.4664936,"lng":26.5264234,"odometer":193.60657,"order_id":575,"speed":17.860000610352,"transport_id":0},{"datetime":"2019-08-21 05:39:02","lat":49.3969499,"lng":26.6954552,"odometer":207.45822,"order_id":575,"speed":21.540000915527,"transport_id":0},{"datetime":"2019-08-21 05:39:03","lat":49.3969276,"lng":26.6957425,"odometer":207.47897,"order_id":575,"speed":20.920000076294,"transport_id":0},{"datetime":"2019-08-21 05:39:04","lat":49.3969053,"lng":26.6960351,"odometer":207.50008,"order_id":575,"speed":21.60000038147,"transport_id":0},{"datetime":"2019-08-21 05:39:05","lat":49.3968843,"lng":26.6963311,"odometer":207.5214,"order_id":575,"speed":21.209999084473,"transport_id":0},{"datetime":"2019-08-21 05:39:06","lat":49.3968636,"lng":26.6966185,"odometer":207.5421,"order_id":575,"speed":21.209999084473,"transport_id":0},{"datetime":"2019-08-21 05:39:07","lat":49.3968431,"lng":26.6969174,"odometer":207.56361,"order_id":575,"speed":21.700000762939,"transport_id":0},{"datetime":"2019-08-21 05:39:08","lat":49.3968243,"lng":26.6972119,"odometer":207.58475,"order_id":575,"speed":21.540000915527,"transport_id":0},{"datetime":"2019-08-21 05:39:09","lat":49.3968008,"lng":26.6975061,"odometer":207.60602,"order_id":575,"speed":21.409999847412,"transport_id":0},{"datetime":"2019-08-21 05:39:10","lat":49.3967818,"lng":26.6978021,"odometer":207.62726,"order_id":575,"speed":21.510000228882,"transport_id":0},{"datetime":"2019-08-21 05:39:11","lat":49.3967643,"lng":26.6980985,"odometer":207.6485,"order_id":575,"speed":21.530000686646,"transport_id":0},{"datetime":"2019-08-21 05:39:12","lat":49.3967452,"lng":26.6983875,"odometer":207.66927,"order_id":575,"speed":21.280000686646,"transport_id":0},{"datetime":"2019-08-21 05:39:13","lat":49.3967234,"lng":26.6986736,"odometer":207.68991,"order_id":575,"speed":20.670000076294,"transport_id":0},{"datetime":"2019-08-21 05:39:14","lat":49.3967039,"lng":26.6989432,"odometer":207.70935,"order_id":575,"speed":19.469999313354,"transport_id":0},{"datetime":"2019-08-21 05:39:15","lat":49.3966893,"lng":26.6992195,"odometer":207.72908,"order_id":575,"speed":19.75,"transport_id":0},{"datetime":"2019-08-21 05:39:16","lat":49.3966763,"lng":26.6994943,"odometer":207.74867,"order_id":575,"speed":19.870000839233,"transport_id":0},{"datetime":"2019-08-21 05:39:17","lat":49.3966573,"lng":26.6997744,"odometer":207.76881,"order_id":575,"speed":20.239999771118,"transport_id":0},{"datetime":"2019-08-21 05:39:18","lat":49.3966397,"lng":26.7000484,"odometer":207.78848,"order_id":575,"speed":20.290000915527,"transport_id":0},{"datetime":"2019-08-21 05:39:19","lat":49.3966209,"lng":26.7003267,"odometer":207.8085,"order_id":575,"speed":20.549999237061,"transport_id":0},{"datetime":"2019-08-21 05:39:20","lat":49.3966012,"lng":26.7006145,"odometer":207.82921,"order_id":575,"speed":20.799999237061,"transport_id":0},{"datetime":"2019-08-21 05:39:21","lat":49.3965854,"lng":26.700902,"odometer":207.84976,"order_id":575,"speed":20.860000610352,"transport_id":0},{"datetime":"2019-08-21 05:39:22","lat":49.3965664,"lng":26.7011845,"odometer":207.87007,"order_id":575,"speed":20.799999237061,"transport_id":0},{"datetime":"2019-08-21 05:39:23","lat":49.3965486,"lng":26.7014697,"odometer":207.89055,"order_id":575,"speed":20.940000534058,"transport_id":0},{"datetime":"2019-08-21 05:39:24","lat":49.3965279,"lng":26.7017573,"odometer":207.91127,"order_id":575,"speed":20.940000534058,"transport_id":0},{"datetime":"2019-08-21 05:39:25","lat":49.3965082,"lng":26.7020414,"odometer":207.9317,"order_id":575,"speed":20.89999961853,"transport_id":0},{"datetime":"2019-08-21 05:39:26","lat":49.3964883,"lng":26.7023284,"odometer":207.95236,"order_id":575,"speed":20.979999542236,"transport_id":0},{"datetime":"2019-08-21 05:39:27","lat":49.3964666,"lng":26.702611,"odometer":207.97275,"order_id":575,"speed":21.020000457764,"transport_id":0},{"datetime":"2019-08-21 05:39:28","lat":49.3964432,"lng":26.7028928,"odometer":207.99315,"order_id":575,"speed":20.790000915527,"transport_id":0},{"datetime":"2019-08-21 05:39:29","lat":49.3964236,"lng":26.7031783,"odometer":208.01369,"order_id":575,"speed":20.889999389648,"transport_id":0},{"datetime":"2019-08-21 05:39:30","lat":49.3964011,"lng":26.7034638,"odometer":208.03432,"order_id":575,"speed":20.959999084473,"transport_id":0},{"datetime":"2019-08-21 05:39:31","lat":49.3963787,"lng":26.7037475,"odometer":208.05481,"order_id":575,"speed":20.879999160767,"transport_id":0},{"datetime":"2019-08-21 05:39:32","lat":49.3963562,"lng":26.7040318,"odometer":208.07536,"order_id":575,"speed":20.940000534058,"transport_id":0},{"datetime":"2019-08-21 05:39:33","lat":49.3963364,"lng":26.7043171,"odometer":208.09589,"order_id":575,"speed":20.959999084473,"transport_id":0},{"datetime":"2019-08-21 05:39:34","lat":49.396317,"lng":26.7046072,"odometer":208.11674,"order_id":575,"speed":21.159999847412,"transport_id":0},{"datetime":"2019-08-21 05:39:35","lat":49.3962965,"lng":26.7048873,"odometer":208.13693,"order_id":575,"speed":20.989999771118,"transport_id":0},{"datetime":"2019-08-21 05:39:36","lat":49.3962738,"lng":26.7051748,"odometer":208.1577,"order_id":575,"speed":20.940000534058,"transport_id":0},{"datetime":"2019-08-22 05:08:03","lat":49.4024515,"lng":27.0216488,"odometer":0.023635214,"order_id":613,"speed":0,"transport_id":128},{"datetime":"2019-08-22 05:08:04","lat":49.4024514,"lng":27.0216488,"odometer":0.023643704,"order_id":613,"speed":0,"transport_id":128},{"datetime":"2019-08-22 05:08:05","lat":49.4024513,"lng":27.0216488,"odometer":0.023652194,"order_id":613,"speed":0,"transport_id":128}]}';
        $request = json_decode($request);
        $old_lat = null; 
        $old_lng = null;
        foreach ($request->data as $geo) {
            $geo = (array)$geo; 
            if ($old_lat == null) {
                $old_lat = $geo['lat'];
                $old_lng = $geo['lng'];
                continue;
            }
            $dist = app_map_distance_coo($geo['lat'], $geo['lng'], $old_lat, $old_lng);
            if ($dist > 10) {
                print ($geo['datetime'].' '.$old_lat.':'.$old_lng.' '.$geo['lat'].':'.$geo['lng'].' '.$dist."\n");
                $old_lat = $geo['lat'];
                $old_lng = $geo['lng'];
            }

        }

    }

}
