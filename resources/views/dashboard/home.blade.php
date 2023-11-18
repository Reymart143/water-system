@extends('layouts.dash')

@section('content')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script> --}}
<script src="{{asset('pluto/js/addJs/3.7.0-chart.min.js')}}"></script>

<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column1 mt-4">
            {{-- start --}}
            <div class="container">
                <div class="row ">
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-cherry">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-person"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0" style="color:white !important">Consumers</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" style="color:white !important">
                                         @php
                                                $total = DB::table('consumer_infos')->count();
                                                $allcustomer = DB::table('consumer_infos')->whereNot('status',2)->get();
                                                $totalConsumers = count($allcustomer);
                                                if ($total > 0) {
                                                    $percentageConsumer = ($totalConsumers / $total) * 100;
                                                } else {
                                                    $percentageConsumer = 0;
                                                }
                                                echo $totalConsumers; 
                                            @endphp
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right" style="flex: 1; white-space: nowrap;">
                                        <a href="/superAdmincustomer" class="details_link" style="margin-left:-50px">
                                            <i class="fa fa-arrow-circle-right animated-icon"></i>
                                            View Details
                                        </a><span >{{number_format($percentageConsumer)}}% <i class="fa fa-arrow-up"></i>
                                           
                                       </span>
                                        
                                    </div>
                                </div>
                                <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentageConsumer }}%"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-blue-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0" style="color:white !important"> Water Bill for the Month</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" style="color:white !important">
                                            &#8369;
                                            @php
                                            $currentMonthYear = date('Y-m');
                                        
                                            $totalAmountBill = DB::table('encoders')
                                                ->join('consumer_infos', 'consumer_infos.account_id', '=', 'encoders.account_id')
                                                ->whereRaw('DATE_FORMAT(encoders.from_reading_date, "%Y-%m") = ?', [$currentMonthYear])
                                                ->where('consumer_infos.status', '<>', 2)
                                                ->sum('encoders.amount_bill');
                                        
                                            $percentageBill = 0;
                                        
                                            if ($totalAmountBill > 0) {
                                                $percentageBill = ($totalAmountBill / 100);
                                            } else {
                                                $percentageBill = 0;
                                            }
                                        
                                            $totalAmountFormatted = number_format($totalAmountBill, 2);
                                            echo $totalAmountFormatted;
                                        @endphp
                                        

                                        
                                           
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="/monthly-billing-sum" class="details_link" style="margin-left:-50px">
                                            <i class="fa fa-arrow-circle-right animated-icon"></i>
                                            View Details
                                        </a>
                                        <span>{{number_format($percentageBill)}}% <i class="fa fa-arrow-up"></i></span>
                                    </div>
                                </div>
                                <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentageBill }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-green-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-tachometer"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0" style="color:white !important">Reading</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" style="color:white !important">
                                            @php
                                            $currentMonthYear = date('Y-m');
                                            
                                            $totalcollection = DB::table('encoders')
                                                
                                               ->whereRaw('DATE_FORMAT(from_reading_date, "%Y-%m") = ?', $currentMonthYear)
                                                ->select('current_reading')
                                                ->count('current_reading');
                                            
                                            $percentageReading = 0; 
                                            
                                            if ($totalcollection > 0) {
                                                $percentageReading = ($totalcollection / 100);
                                            }
                                            
                                            echo $totalcollection;
                                        @endphp
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="/reading" class="details_link" style="margin-left:-50px">
                                            <i class="fa fa-arrow-circle-right animated-icon"></i>
                                            View Details
                                        </a>
                                        <span>{{$percentageReading}}% <i class="fa fa-arrow-up"></i></span>
                                    </div>
                                </div>
                                <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentageReading}}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-orange-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0" style="color:white !important">Staff of Meedo</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" style="color:white !important">
                                            @php
                                            $total = DB::table('users')->count();
                                            $totalConsumers = DB::table('users')->where('status', 0)->count();
                                            
                                            if ($total > 0) {
                                                $percentageUsers = round(($totalConsumers / $total) * 100);
                                            } else {
                                                $percentageUsers = 0;
                                            }
                                            
                                            echo $totalConsumers; 
                                        @endphp
                                        
                                        
                                       
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="/user.superAdmin" class="details_link" style="margin-left:-50px">
                                            <i class="fa fa-arrow-circle-right animated-icon"></i>
                                            View Details
                                        </a>
                                        <span>{{$percentageUsers}}% <i class="fa fa-arrow-up"></i></span>
                                    </div>
                                </div>
                                <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percentageUsers }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .card {
                    background-color: #fff;
                    border-radius: 10px;
                    border: none;
                    position: relative;
                    margin-bottom: 30px;
                    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
                }
                .l-bg-cherry {
                    background: linear-gradient(to right, #493240, #f09) !important;
                    color: #fff;
                }

                .l-bg-blue-dark {
                    background: linear-gradient(to right, #373b44, #4286f4) !important;
                    color: #fff;
                }

                .l-bg-green-dark {
                    background: linear-gradient(to right, #0a504a, #38ef7d) !important;
                    color: #fff;
                }

                .l-bg-orange-dark {
                    background: linear-gradient(to right, #a86008, #ffba56) !important;
                    color: #fff;
                }

                .card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
                    font-size: 110px;
                }

                .card .card-statistic-3 .card-icon {
                    text-align: center;
                    line-height: 50px;
                    margin-left: 15px;
                    color: #000;
                    position: absolute;
                    right: -5px;
                    top: 20px;
                    opacity: 0.1;
                }

                .l-bg-cyan {
                    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
                    color: #fff;
                }

                .l-bg-green {
                    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
                    color: #fff;
                }

                .l-bg-orange {
                    background: linear-gradient(to right, #f9900e, #ffba56) !important;
                    color: #fff;
                }

                .l-bg-cyan {
                    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
                    color: #fff;
                }
            </style>
        {{-- end --}}
        </div>
      
        <!-- graph -->
        <div class="row column2 graph margin_bottom_30">
            <div class="col-md-l2 col-lg-12">
                <div class="white_shd full">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                        <h2>Bill and Collection for the Year</h2>
                        </div>
                    </div>
                    <div class="full graph_revenue">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <div class="area_chart">
                                    <canvas height="120" id="bar-graph"></canvas>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <script>
              function fetchData() {
                
                $.ajax({
                    url: '/get-chart-data',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var chartData = data.chart_report;

                        var labels = [];
                        var issuances = [];
                        var collections = [];

                        chartData.forEach(function (item) {
                            labels.push(item.month);
                            issuances.push(parseFloat(item.total_issuance));
                            collections.push(parseFloat(item.total_collection));
                        });

                        var ctx = document.getElementById('bar-graph').getContext('2d');
                        var chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Total Water Bill',
                                        data: issuances,
                                        backgroundColor: 'rgba(133, 250, 207)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Collection',
                                        data: collections,
                                        backgroundColor: 'rgba(133, 205, 250)', 
                                        borderColor: 'rgba(0, 0, 139, 0)', 
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            }

            $(document).ready(function () {
                fetchData();
            });

            </script>
            
            
        <!-- end graph -->
        <div class="row column3">
                  {{-- progress bar --}}
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30" >
                <div class="full graph_head" >
                    <div class="heading1 margin_0">
                    <h2>Consumer Status in Meedo Water</h2>
                    </div>
                </div>
                <div class="full progress_bar_inner">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="progress_bar">
                            <!-- Skill Bars -->
                            @php
                                $total = DB::table('consumer_infos')->count();
                                $connected = DB::table('consumer_infos')->where('status', 0)->count();

                                if ($total > 0) {
                                    $percentageConnected = ($connected / $total) * 100;
                                } else {
                                    $percentageConnected = 0;
                                }
                            @endphp

                            <span class="skill" style="width:{{ $percentageConnected }}%;">
                                <div style="flex: 1; white-space: nowrap;">Connected Consumers {{ $connected }}</div>
                            
                                <span class="info_valume">
                                    {{ number_format($percentageConnected, 2) }} %
                                </span>
                            </span>
                                          
                            <div class="progress skill-bar ">
                                
                                <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentageConnected }}%;">
                                </div>
                            </div>
                            @php
                            $total = DB::table('consumer_infos')->count();
                            $reconnected = DB::table('consumer_infos')->where('status', 1)->count();
                            
                            if ($total> 0)
                            {
                                $percentageReconnected = ($reconnected / max($total, 1)) * 100;
                            }else{
                                $percentageReconnected = 0;
                            }
                        @endphp
                            <span class="skill" style="width:{{ $percentageReconnected }}%;">
                                <div style="flex: 1; white-space: nowrap;">Reconnected Consumers {{ $reconnected }}</div>
                                <br>
                                <span class="info_valume">
                                    {{ number_format($percentageReconnected, 2) }} %
                                </span>
                            </span>

                                <div class="progress skill-bar ">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"  role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentageReconnected }}%;background-color: #42aad3">
                                    </div>
                                </div>
                                @php
                                $total = DB::table('consumer_infos')->count();
                                $disconnected = DB::table('consumer_infos')->where('status', 2)->count();
                             
                                if ($total> 0)
                                {
                                    $percentageDisconnected = ($disconnected / max($total, 2)) * 100;
                                }else{
                                    $percentageDisconnected = 0;
                                }
                            @endphp
                                <span class="skill" style="width:{{ $percentageDisconnected }}%;">
                                    <div style="flex: 1; white-space: nowrap;">Disconnected Consumers {{ $disconnected }}</div>
                                    <br>
                                    <span class="info_valume">
                                        {{ number_format($percentageDisconnected, 2) }} %
                                    </span>
                                </span>
                                                  
                                    <div class="progress skill-bar ">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped"  role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentageDisconnected }}%;background-color: red">
                                        </div>
                                    </div>
                          
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .progress.skill-bar {
            background: #e9ecef;
            border-radius: 0;
            height: 30px;
            margin-top: 2px;
            border-radius: 10px;
        }
        </style>
        <!-- testimonial -->
        {{-- <div class="col-md-6">
            <div class="dark_bg full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                    <h2>Testimonial</h2>
                    </div>
                </div>
                <div class="full graph_revenue">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="content testimonial">
                            <div id="testimonial_slider" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for carousel items -->
                                <div class="carousel-inner">
                                <div class="item carousel-item active">
                                    <div class="img-box"><img src="images/layout_img/user_img.jpg" alt=""></div>
                                    <p class="testimonial">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae..</p>
                                    <p class="overview"><b>Michael Stuart</b>Seo Founder</p>
                                </div>
                                <div class="item carousel-item">
                                    <div class="img-box"><img src="images/layout_img/user_img.jpg" alt=""></div>
                                    <p class="testimonial">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae..</p>
                                    <p class="overview"><b>Michael Stuart</b>Seo Founder</p>
                                </div>
                                <div class="item carousel-item">
                                    <div class="img-box"><img src="images/layout_img/user_img.jpg" alt=""></div>
                                    <p class="testimonial">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae..</p>
                                    <p class="overview"><b>Michael Stuart</b>Seo Founder</p>
                                </div>
                                </div>
                                <!-- Carousel controls -->
                                <a class="carousel-control left carousel-control-prev" href="#testimonial_slider" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="carousel-control right carousel-control-next" href="#testimonial_slider" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- end testimonial -->
        
        <!-- end progress bar -->
        </div>
        <div class="row column4 graph">
        <div class="col-md-12">
            <div class="dash_blog">
                <div class="dash_blog_inner">
                    <div class="dash_head">
                    <h3><span><i class="fa fa-calendar"></i> Upcoming Holidays</span><span class="plus_green_bt"><a href="/about-rate">+</a></span></h3>
                    </div>
                   
                    <div class="task_list_main">
                        <ul class="task_list">
                            @php
                                $currentDate = \Carbon\Carbon::now(); // Get the current date using the Carbon library
                                $nextHolidays = DB::table('holidays')
                                    ->select('holiday_name', 'holiday_date')
                                    ->where('holiday_date', '>', $currentDate)
                                    ->orderBy('holiday_date')
                                    ->take(5)
                                    ->get();
                            @endphp
                        
                            @foreach ($nextHolidays as $item)
                            <li>
                                <a href="#"><span style="color:green">{{ $item->holiday_name }}</span></a><br>
                                <strong>{{ \Carbon\Carbon::parse($item->holiday_date)->format('F d, Y') }}</strong>
                            </li>
                            @endforeach
                        </ul>
                        
                    </div>
                    {{-- <div class="read_more">
                    <div class="center"><a class="main_bt read_bt" href="#">View More</a></div>
                    </div> --}}
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="dash_blog">
                <div class="dash_blog_inner">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                           <h2>Calendar</h2>
                        </div>
                     </div>
                  
                    <div class="msg_list_main">
                        <div class="full padding_infor_info">
                            <div class="invoice_inner">
                               <div class="row">
                                  <div class="col-md-12">
                                     <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                         
                                        </div>
                                        <div class="full progress_bar_inner">
                                           <div class="row">
                                              <div class="col-md-12">
                                                 <div class="full">
                                                    <div class="ui calendar" id="example14"><div class="calendar" tabindex="0"><table class="ui celled center aligned unstackable table seven column day"><thead><tr><th colspan="7"><span class="link">November 2023</span><span class="prev link"><i class="chevron left icon"></i></span><span class="next link"><i class="chevron right icon"></i></span></th></tr><tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr></thead><tbody><tr><td class="link disabled">29</td><td class="link disabled">30</td><td class="link disabled">31</td><td class="link">1</td><td class="link focus">2</td><td class="link today">3</td><td class="link">4</td></tr><tr><td class="link">5</td><td class="link">6</td><td class="link">7</td><td class="link">8</td><td class="link">9</td><td class="link">10</td><td class="link">11</td></tr><tr><td class="link">12</td><td class="link">13</td><td class="link">14</td><td class="link">15</td><td class="link">16</td><td class="link">17</td><td class="link">18</td></tr><tr><td class="link">19</td><td class="link">20</td><td class="link">21</td><td class="link">22</td><td class="link">23</td><td class="link">24</td><td class="link">25</td></tr><tr><td class="link">26</td><td class="link">27</td><td class="link">28</td><td class="link">29</td><td class="link">30</td><td class="link disabled">1</td><td class="link disabled">2</td></tr><tr><td class="link disabled">3</td><td class="link disabled">4</td><td class="link disabled">5</td><td class="link disabled">6</td><td class="link disabled">7</td><td class="link disabled">8</td><td class="link disabled">9</td></tr></tbody></table></div></div>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                   
                    </div>
                    {{-- <div class="read_more">
                    <div class="center"><a class="main_bt read_bt" href="#">Read More</a></div>
                    </div> 
                </div>
            </div>
        </div> --}}
        </div>
    </div>
    <!-- footer -->
    <div class="container-fluid">
        <div class="footer">
        <p>Copyright ©2023 Project by MEEDO Naawan Water System. All rights reserved.
        </p>
        </div>
    </div>
</div>
@endsection