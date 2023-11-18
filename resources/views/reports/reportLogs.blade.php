@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column1">
            <div class="col-md-2"></div>
                <div class="col-md-12 mt-4">
                    <div class="margin_bottom_30">
                        <div class="full graph_head" style="background: #fff; border-radius: 5px;">
                            <div class="card-body" style="padding: 20px; width: 100% !important;">
                                <div class="card-header mb-4" style="background-color: #fff;">
                                   <h2><i class="fa fa-file-archive-o green_color" style="margin-top:0px"></i> History logs</h2> 
                                   <div class="filter-controls" style="flex: 1%;display: inline-flex;margin-top:20px">
                                    <label for="filterMonthYear" style="margin-right:5px;color:black" >Select Month and Year: </label>
                                    <input type="month" id="filterMonthYear" style="width: 50%" class="form-control">
                                </div>
                                </div>
                                <div class="table-responsive">
                                <table class="display table table-bordered" id="reportTable" style="color: b    lack !important; width: 100% !important;">
                                    <thead style="background: #009688 !important;">
                                        <tr>
                                            <th class="header-table">Name</th>
                                            <th class="header-table">Position</th>
                                            <th class="header-table">Date</th>
                                            <th class="header-table">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $roleMapping = [
                                                0 => 'Superadmin',
                                                1 => 'Admin',
                                                2 => 'Treasurer',
                                                3 => 'Encoder',
                                                4 => 'Assessor',
                                            ];
                                      
                                        @endphp
                                          @foreach($reportLogs as $log)
                                          
                                          @if (auth()->user()->role == 0 && $log->user->role != 0)
                                          <!-- kita tanan except sa iya self nga superadmin -->
                                          <tr>
                                              <td>{{ $log->user->name ?? '' }}</td>
                                              <td>{{ optional($log->user)->role ? $roleMapping[$log->user->role] : '' }}</td>
                                              <td>Recently Login on <span style="color: rgb(0, 17, 248)">{{ $log->date ?? '' }}</span></td>
                                              <td> at <span style="color: rgb(248, 0, 0)">
                                                  {{ \Carbon\Carbon::parse($log->time)->timezone('America/Los_Angeles')->format('h:i A') }}
                                              </span></td>
                                          </tr>
                                          @elseif (auth()->user()->role == 1 && $log->user->role != 1)
                                          <!-- di makita ni Admin iyang self og si superadmin -->
                                          <tr>
                                              <td>{{ $log->user->name ?? '' }}</td>
                                              <td>{{ optional($log->user)->role ? $roleMapping[$log->user->role] : '' }}</td>
                                              <td>Recently Login on <span style="color: rgb(0, 17, 248)">{{ $log->date ?? '' }}</span></td>
                                              <td> at <span style="color: rgb(248, 0, 0)">
                                                  {{ \Carbon\Carbon::parse($log->time)->timezone('America/New_York')->format('h:i A') }}
                                              </span></td>
                                          </tr>
                                          @endif
                                          @endforeach
                                  
                                    </tbody>
                                </table>
                            </div>
                           
                                <script>
                                    $(document).ready(function() {
                                      
                                        var table = $('#reportTable').DataTable();

                                    
                                        $('#filterMonthYear').on('change', function() {
                                   
                                            var selectedDate = $(this).val();
                                            console.log(selectedDate);
                                            table.column(2).search(selectedDate).draw();
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>        
</div>

@endsection