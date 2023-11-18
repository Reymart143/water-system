@extends('layouts.dash')

@section('content')

<div class="loader-overlay" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
      <label for="" style="color:white;margin-left:20%;flex: 1; white-space: nowrap;">Saving .....  Please Wait for a moment!</label>
    </div>
  </div>
  
  <style>
  .loader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5); 
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999; 
  backdrop-filter: blur(5px); 
}

  .loader-container {
    text-align: center;
  }
  
  .spinner {
    margin-top: 30%;
    margin-left: 50%;
   width: 72px;
   height: 72px;
   display: grid;
   border-radius: 50%;
   -webkit-mask: radial-gradient(farthest-side,#0000 40%,#0f13ec 41%);
   background: linear-gradient(0deg ,rgba(15,19,236,0.5) 50%,rgba(15,19,236,1) 0) center/5.8px 100%,
        linear-gradient(90deg,rgba(15,19,236,0.25) 50%,rgba(15,19,236,0.75) 0) center/100% 5.8px;
   background-repeat: no-repeat;
   animation: spinner-d3o0rx 1s infinite steps(12);
}

.spinner::before,
.spinner::after {
   content: "";
   grid-area: 1/1;
   border-radius: 50%;
   background: inherit;
   opacity: 0.915;
   transform: rotate(30deg);
}

.spinner::after {
   opacity: 0.83;
   transform: rotate(60deg);
}

@keyframes spinner-d3o0rx {
   100% {
      transform: rotate(1turn);
   }
}
  </style>
  
  
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-2">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="background: #007bff; border-radius: 5px;">
                                <h5 class="mt-1" style="color: white !important;"><i class=" fa fa-file-code-o fa-1x" style="margin-right:-10px; color:#3a4a5a"></i><i class="fa fa-pencil"></i>  INPUT READING FOR THE MONTH</h5>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="row column1">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                        <div class="card-body mt-4" style="padding: 20px; width: 100% !important;">
                            <table id="encoder_reading_table" class="display table table-bordered" style="background-color:#009688;color:rgb(255, 255, 255) !important;width: 100% !important;font-size:3mm;" >
                                <div class="filter-container" style="margin-top: 0px; display: flex; align-items: center;margin-bottom:10px">
                                    <div class="col-md-5">
                                        <label for="cluster-filter" style="color: rgb(10, 10, 10);font-weight:bold">Select Cluster input reading:</label>
                                        <select id="cluster-filter" id="cluster" name="cluster" class="form-control" style="width: 170px">
                                            <option value="">All</option>
                                            @php
                                            $categories = DB::table('libraries')->get();
                                            @endphp
                                            @foreach ($categories as $category)
                                            @if ($category->category === 'Cluster')
                                            <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                        <div class="col-md-2" style="margin-left: 20px;">
                                        <label for="input" style="color: rgb(8, 8, 8);font-weight:bold">Reader: </label>
                                        <select id="Reader" name="Reader" class="form-control" style="width: 150px">
                                            <option value="">Select Reader</option>
                                            @php
                                            $categories = DB::table('libraries')->get();
                                            @endphp
                                            @foreach ($categories as $category)
                                            @if ($category->category === 'Reader')
                                            <option value="{{ $category->categoryaddedName }}" id="reader_btn">{{ $category->categoryaddedName }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="margin-left: 20px;">
                                        <div class="filter-controls">
                                            <label for="from_reading_date" style="color: rgb(0, 0, 0); font-weight: bold">Date Reading:</label>
                                            <input type="date" id="from_reading_date" value="{{ date('Y-m-d') }}" name="from_reading_date" style="width: 150px" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="margin-left: 20px;">
                                        <div class="filter-controls">
                                            <label for="date_delivered" style="color: rgb(5, 5, 5); font-weight: bold">Date Delivery:</label>
                                            <input type="date" id="date_delivered" value="{{ date('Y-m-d') }}" name="date_delivered" style="width: 150px" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            
                                            var fromReadingDate = document.getElementById("from_reading_date");
                                            var dateDelivered = document.getElementById("date_delivered");

                                            fromReadingDate.min = "2008-01-01";
                                            dateDelivered.min = "2008-01-01";
                                    
                                            var currentDate = new Date();
                                            var currentYear = currentDate.getFullYear();
                                            var currentMonth = currentDate.getMonth();
                                            var lastDay = new Date(currentYear, currentMonth + 1, 0);
                                    
                                            
                                            fromReadingDate.max = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${lastDay.getDate()}`;
                                            dateDelivered.max = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${lastDay.getDate()}`;
                                    
                                            
                                            // fromReadingDate.value = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${currentDate.getDate()}`;
                                            // dateDelivered.value = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${currentDate.getDate()}`;
                                        });
                                    </script>
                                    
                                    
                                </div>
                                <thead>
                                    <tr>
                                        
                                        <th style="color: white">Acc No.</th>
                                        <th style="color: white">Connection Name</th>
                                        <th style="color: white">Reading</th>
                                        <th style="color: white">Date Reading</th>
                                        <th style="color: white">Date Delivery</th>
                                        <th style="text-align: center;color: white  ">Cluster</th>
                                        <th style="text-align: center;color: white;">Reader</th>
                                        <th style="display:none">Cluster</th>
                                        <th style="display:none">Rate Case</th>
                                        <th style="display:none">watershed</th>
                                        <th style="display:none">cubicMeter</th>
                                        {{-- <th style="color: white">Volume</th>
                                        <th style="flex: 1; white-space: nowrap;color: white">Amount bill</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($consumerData as $v)
                                    <tr>
                                    
                                    <td style="flex: 1; white-space: nowrap;">{{$v->account_id}}</td>
                                    <td style="flex: 1; white-space: nowrap;">{{$v->customerName}}</td>
                                    <td><input type="string" id="current_reading" name="current_reading" class="form-control" style="flex: 1; white-space: nowrap;width:90px" oninput="formatCurrentReading(this)"></td>
                                    <td><input type="date" id="from_reading_date" class="form-control" style="font-size:11px;width:99px;" value="{{ date('Y-m-d') }}" name="from_reading_date" readonly></td>
                                    <td><input type="date" id="date_delivered" class="form-control" style="font-size:11px;width:99px;" value="{{ date('Y-m-d') }}"  name="date_delivered" readonly></td>
                                    <td style="flex: 1; white-space: nowrap;"><input type="text" id="cluster" name="cluster" value="{{$v->cluster}}" style="width:100px;font-size:11px" class="form-control" readonly></td>
                                    <td><input type="text" id="Reader" class="form-control" name="Reader" readonly style="width:140px;font-size:11px"></td>
                                    <td style="display:none">{{$v->classification}}</td>
                                    <td style="display:none">{{$v->rate_case}}</td>
                                    <td style="display:none">{{$v->watershed}}</td>
                                    <td style="display:none">{{$v->cubicMeter}}</td>
                                    {{-- <td><input type="text" id="volume" class="form-control" name="volume" ></td>
                                    <td><input type="text" id="amount_bill" class="form-control" name="amount_bill" ></td>--}}
                            
                                </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                            <div class="col-md-4 mb-4 mx-auto" >
                                <button type="button" class="main_bt" id="encode_btn" style="width: 38.7%">Save</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
               
        </div> 
        
       {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
       <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
    <script>
        
        function formatCurrentReading(input) {
            let value = parseInt(input.value);

                if (!isNaN(value) && value >= 0) {
                    value = value.toString().padStart(5, '0');
                    input.value = value;

                    var cluster = $("#cluster-filter").val();
                    var reader = $("#Reader").val();
                    var fromReadingDate = $("#from_reading_date").val();
                    var dateDelivered = $("#date_delivered").val();

                    if (cluster === "" || reader === "" || fromReadingDate === "" || dateDelivered === "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Missing Information',
                            text: 'Please select Cluster, Reader, Date Reading, and Date Delivered before entering Current Reading.',
                        });
                        input.value = '';
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Input',
                        text: 'Please enter a valid positive number for Current Reading.',
                    });
                    input.value = '';
                }
            }
                $(document).ready(function () {
                    
                    const readinglistTable = $('#encoder_reading_table').DataTable({
                        "lengthMenu": [[10, 25, 50, 100, 500, 10000], [10, 25, 50, 100, 500, 10000]],
                        "pageLength": 10000,
                        "lengthChange": false, // Disable the page length change feature
                        "searching": false 
                    });

                    
                    $('#cluster-filter').on('change', function () {
                            const selectedCluster = $(this).val();
                        
                            $('#encoder_reading_table tbody tr').each(function () {
                                const $row = $(this);
                                const clusterInputValue = $row.find('input[name="cluster"]').val();
                                
                
                                if (clusterInputValue === selectedCluster) {
                                
                                    $row.show(); 
                                } else {
                                    $row.hide(); 
                                }
                            });

                            updateRowNumbers();
                        });
                    $('#from_reading_date, #date_delivered').on('change', function () {
                        const fromDateValue = $('#from_reading_date').val();
                        const deliveredDateValue = $('#date_delivered').val();

                        $('#encoder_reading_table tbody tr:visible').find('td:eq(3) input').val(fromDateValue);
                        $('#encoder_reading_table tbody tr:visible').find('td:eq(4) input').val(deliveredDateValue);
                    });
                    $('#Reader').on('change', function () {
                
                        const selectedReader = $(this).val();
                        $('#encoder_reading_table tbody tr:visible').find('td:eq(6) input').val(selectedReader);
                    });

                    function updateRowNumbers() {
                        let rowNumber = 1;
                        $('#encoder_reading_table tbody tr').each(function () {
                            const $row = $(this);
                            if ($row.is(':visible')) {
                                $row.find('td.row-number').text(rowNumber++);
                            } else {
                                $row.find('td.row-number').text('');
                            }
                        });
                    }

                    function updateReaderInput(selectedCluster) {
                        
                        const selectedReader = $('#Reader').val();
                        $('#encoder_reading_table tbody tr:visible').each(function () {
                            const $row = $(this);
                            const clusterValue = $row.find('td:eq(5)').text();
                            if (clusterValue === selectedCluster) {
                                $row.find('td:eq(6) input').val(selectedReader);
                            }
                        });
                    }
            

                });
                $('#encode_btn').on('click', function (e) {
    e.preventDefault();

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var selectedCluster = $('#cluster-filter').val();
    var successCount = 0;
    var totalRowCount = 0;
    var loader = $('.loader-overlay');

    loader.show();

    $('#encoder_reading_table tbody tr').each(function () {
        totalRowCount++;
    });

    const requests = [];

    $('#encoder_reading_table tbody tr').each(function () {
        var $row = $(this);
        var clusterInputValue = $row.find('input[name="cluster"]').val();
        var classificationValue = $row.find('td:eq(7)').text();
        var ratecaseValue = $row.find('td:eq(8)').text();
        var watershedValue = $row.find('td:eq(9)').text();
        var cubicMeterValue = $row.find('td:eq(10)').text();

        if (clusterInputValue === selectedCluster) {
            var currentRead = {
                'customer_id': $row.find('td:eq(0)').text(),
                'cluster': clusterInputValue,
                'customerName': $row.find('td:eq(1)').text(),
                'Reader': $('#Reader').val(),
                'account_id': $row.find('td:eq(0)').text(),
                'from_reading_date': $row.find('td:eq(3) input').val(),
                'date_delivered': $row.find('td:eq(4) input').val(),
                'current_reading': $row.find('td:eq(2) input').val(),
                'previous_reading': $('#previous_reading').val(),
                'classification': classificationValue,
                'rate_case': ratecaseValue,
                'watershed': watershedValue,
                'cubicMeter': cubicMeterValue,
            };

            const request = new Promise(function (resolve, reject) {
                $.ajax({
                    type: 'GET',
                    url: '/input',
                    data: currentRead,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#Reader').val('');
                        $row.find('td:eq(2) input').val('');
                        $row.find('td:eq(6) input').val('');
                        successCount++;
                        resolve(data); 
                    },
                    error: function (data) {
                        successCount++;
                        resolve(data); 
                    }
                });
            });

            requests.push(request);
        }
    });

    Promise.all(requests)
        .then(function (responses) {
            loader.hide();

            let successMessage = 'Successfully submit reading, you can now check it in the reading list';
            let hasError = false;

            let errorMessages = [];
            for (const response of responses) {
                if (response.status === 400) {
                    hasError = true;
                    errorMessages.push(response.responseJSON ? response.responseJSON.message : 'Date Reading and delivered with the same month and year already exists.');
                }
            }

            if (hasError) {
               
                for (const errorMessage of errorMessages) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Successfully Saved',
                        text: errorMessage
                    });
                }
            } else {
               
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Saved',
                    text: successMessage
                });
            }
        });
});





    </script>
    <style>
        #encoder_reading_table {
            font-size:13px; 
            
        }
    </style>
     
@endsection