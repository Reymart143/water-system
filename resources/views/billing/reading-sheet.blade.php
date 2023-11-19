@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;"><i class="fa fa-tachometer"></i> Reading Sheet</h2>
                                <div style="display: flex;">
                                    <div class="filter-controls" style="margin-top:20px; margin-right: 50%;">
                                        <label for="filterMonthYear" style="margin-right:5px;color:rgb(255, 255, 255)" >Select Month and Year: </label>
                                        <input type="month" value="{{ date('Y-m')}}" id="filterMonthYear" style="width: 100%" class="form-control">
                                    </div>
                                    <div class="filter-container" style="margin-top:20px;margin-left:10%">
                                        <label for="cluster-filter" style="color:white">Select Cluster:</label>
                                        <select id="cluster-filter" class="form-control" style="width:100%">
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
                                </div>
                                
                               
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="row column1">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                        <div class="card-body mt-4" style="padding: 20px;" style="width: 100% !important;">
                            <table id="sheetTable" class="display table table-bordered" style="color:black !important;width: 100% !important;font-size:3mm; margin-left:-20px;">
                                <thead>
                                    <tr>
                                       <th>No.</th>
                                        <th style="flex: 1; white-space: nowrap;">Customer Name</th>
                                        <th>Current</th>
                                        <th style="flex: 1; white-space: nowrap;">Previous</th>
                                        <th style="flex: 1; white-space: nowrap;">Case</th>
                                        <th style="flex: 1; white-space: nowrap;">Class</th>
                                        <th style="flex: 1; white-space: nowrap;">Location</th>
                                        <th>Remarks</th>
                                        <th style="display: none;">Cluster</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sheet as $s)
                                    <tr>
                                        <td class="row-number">{{ $s->id}}</td>
                                        <td style="flex: 1; white-space: nowrap;">{{ $s->customerName}}</td>
                                        <td><input type="text" style="border:none; border-bottom:1px solid black;width:50px"></td>
                                        <td style="flex: 1; white-space: nowrap;">@if($s->current_reading == null)
                                            no reading
                                        @else
                                            {{ $s->current_reading }}
                                        
                                        @endif
                                           </td>
                                        <td style="flex: 1; white-space: nowrap;">{{ $s->rate_case}}</td>    
                                        <td style="flex: 1; white-space: nowrap;">{{ $s->classification}}</td>
                                        <td style="flex: 1; white-space: nowrap;">{{ $s->location}}</td>
                                        <td><input type="text" style="width:60px;border-top:none;border-left:none;border-right:none"></td>
                                        <td style="display: none">{{ $s->cluster}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         
            {{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
            <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
    </div> 
    <script>
     
        $(document).ready(function () {
            
            const sheetlistTable = $('#sheetTable').DataTable({
            
                    
            
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-copy enlarge-on-hover'
                    },
                    // {
                    //     extend: 'csv',
                    //     text: '<i class="fas fa-file-csv"></i> CSV',
                    //     className: 'btn btn-csv enlarge-on-hover'
                    // },
                    // {
                    //     extend: 'excel',
                    //     text: '<i class="fas fa-file-excel"></i> Excel',
                    //     className: 'btn btn-excel enlarge-on-hover'
                    // },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-file-pdf"></i> PDF | <i class="fas fa-print"></i> Print',
                        className: 'btn btn-print enlarge-on-hover',
                        customize: function (win) {
                            const selectedCluster = $('#cluster-filter').val();
                          
                            var date = new Date($('#filterMonthYear').val());

                             var date = date.toLocaleDateString(undefined, { year: 'numeric', month: 'long' });
                                                                           
                            $(win.document.body).css({
                                'margin': '0',
                                'width': '100%'
                            });

                        
                            var style = document.createElement('style');
                            style.type = 'text/css';
                            style.innerHTML = `
                                @media print {
                                    @page {
                                        margin: 0;
                                    }
                                    body {
                                        margin: 0 !important;
                                    }
                                    table {
                                        margin: 0 !important;
                                        width: 100% !important;
                                        font-size: 4mm !important;
                                    }
                                    .title {
                                       display : none;
                                    }
                                }
                            `;
                            win.document.head.appendChild(style);
                            
                            $(win.document.body).prepend('<h3 style="text-align:center; margin-top:-80px;margin-bottom:40px;">Reading Sheet</h3>');
                            $(win.document.body).prepend('<div style="display: flex; justify-content: space-between; margin-top: 60px; font-size: 4mm; color: black !important;">' +
                                '<div>Month: ' + date + '&nbsp;&nbsp;&nbsp;Cluster: ' + selectedCluster + '</div>' +
                                '<div>Reader: <input type="text" style="border:none; border-bottom:1px solid black; margin-right:40px; text-align:center;width:120px"></div>' +
                                '<div>Date: <input type="text" style="border:none; border-bottom:1px solid black; margin-right:30px; text-align:center;width:200px"></div>' +
                                '</div>');
                                let rowNumber = 1;
                                $(win.document.body).find('table tbody tr').each(function () {
                                    const $row = $(this);
                                    if ($row.find('td:nth-child(9)').text() === selectedCluster) {
                                        $row.find('td:first').text(rowNumber++);
                                    }
                                });

                            $(win.document.body).find('table th:eq(8)').remove();
                            $(win.document.body).find('table tbody tr').each(function () {
                                $(this).find('td:eq(8)').remove();
                                var rateCell = $(this).find('td:eq(4)');
                                var currentCell = $(this).find('td:eq(2)');
                                var remarksCell = $(this).find('td:eq(7)');
                                var nameCell = $(this).find('td:eq(1)');
                                var previousCell = $(this).find('td:eq(3)');
                                var locationCell = $(this).find('td:eq(6)');
                                currentCell.html('<div></div>' + currentCell.html() + '<div><input type="text" style="border:none; border-bottom:1px solid black; text-align:center;margin-top:10px;width:90px"></div>');
                                remarksCell.html('<div></div>' + remarksCell.html() + '<div><input type="text" style="border:none; border-bottom:1px solid black; text-align:center;margin-top:15px;width:120px"></div>'); 
                                rateCell.css({
                                    'flex': '1',
                                    'white-space': 'nowrap'
                                });
                                nameCell.css({
                                    'flex': '1',
                                    'white-space': 'nowrap'
                                });
                                previousCell.css({
                                    'flex': '1',
                                    'white-space': 'nowrap'
                                });
                                locationCell.css({
                                    'flex': '1',
                                    'white-space': 'nowrap'
                                });
                            });

                            $(win.document.body).find('table tbody tr:first td:eq(5)').css({
                                'flex': '1',
                                'white-space': 'nowrap'
                            });

                            sheetlistTable.page.len(55).draw();
                        },
                        exportOptions: {
                            modifier: {
                                page: 'current',
                                scale: 0.5 
                            }
                        }
                    }

                ],
                responsive: true,
                paging: true,
                "lengthMenu": [[50, 100,500,1000], [50, 100,500,1000]],
                "pageLength": 100, 
                language: {
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        page: "%index%"
                    }
                }
            });

            $('#cluster-filter').on('change', function () {
                    const selectedCluster = $(this).val();
                    sheetlistTable.column(8).search(selectedCluster).draw();

                
                    updateRowNumbers();
                });

               
                function updateRowNumbers() {
                    let rowNumber = 1;
                    $('#sheetTable tbody tr').each(function () {
                        const $row = $(this);
                        if ($row.find('td:nth-child(9)').text() === $('#cluster-filter').val()) {
                            $row.find('td.row-number').text(rowNumber++);
                        } else {
                            $row.find('td.row-number').text('');
                        }
                    });
                }

        });
   

            $('#filterMonthYear').on('change', function() {
                var selectedDate = $(this).val();

           
            var dateParts = selectedDate.split('-');
            var year = dateParts[0];
            var month = dateParts[1];
            var monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var formattedDate = monthNames[parseInt(month) - 1] + ' ' + year;
                sheetlistTable.column(2).search(selectedDate).draw();
            });
      
    </script>
 
@endsection