<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportLog;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('dashboard.home');
    }
    //encoder first view
    public function encoder_index()
    {
        
        return view('billing.encoder-billing');
    }
  
    public function getChartData(Request $request)
    {

        $currentYear = date('Y');
    
        $chartData = DB::table('consumer_ledgers')
            ->selectRaw('MONTH(transact_date) as month, SUM(issuance) as total_issuance, SUM(collection) as total_collection')
            ->whereYear('transact_date', $currentYear) 
            ->groupBy(DB::raw('MONTH(transact_date)'))
            ->orderBy(DB::raw('MONTH(transact_date)'))
            ->get();
    
        $dataByMonth = [];
    
        foreach ($chartData as $item) {
            $month = date('F', mktime(0, 0, 0, $item->month, 1));
            $dataByMonth[] = [
                'month' => $month,
                'total_issuance' => number_format($item->total_issuance, 2),
                'total_collection' => number_format($item->total_collection, 2),
            ];
        }
    
        return response()->json(['chart_report' => $dataByMonth]);
    }
    


// public function markNotificationsAsViewed()
// {
//     // Mark notifications as viewed
//     DB::table('account_receivables')
//         ->where('account_type', 'Penalty')
//         ->where('viewed', false)
//         ->update(['viewed' => true]);

//     return response()->json(['success' => true]);
// }

// public function getLatestNotificationCount()
// {
//     // Fetch the count of unseen notifications
//     $latestCount = DB::table('account_receivables')
//         ->where('account_type', 'Penalty')
//         ->where('viewed', false)
//         ->count();

//     return response()->json(['latestCount' => $latestCount]);
// }


    
}
