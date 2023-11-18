@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #4caf50; border-radius: 5px;">
                                <h3 class="mt-1" style="color: white !important;">ABSTRACT OF COLLECTION </h3>
                             
                                
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="row column1">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                        {{-- TABLE --}}
                        <div class="card-body mt-4" style="padding: 20px;" style="width: 100% !important;">
                            {{-- <div class="filter-controls" style="margin-top:-20px; margin-right: 55%;display: flex;" >
                                <label for="RangeDateMonthYear" style="margin-right:5px;color:rgb(255, 255, 255)" >From: </label>
                                <input type="date" id="fromfilterDateMonthYear" style="width: 50%" class="form-control">
                                 <label for="RangeDateMonthYear" style="margin-right:5px;color:rgb(255, 255, 255)" >Up to: </label>
                                <input type="date" id="UptoDateMonthYear" style="width: 50%" class="form-control">
                            </div>
                            <button class="btn btn-secondary mt-4" id="SubmitFilterRange">Filter</button> --}}
                            
                                <table border="0" cellspacing="5" cellpadding="5" style="margin-bottom:10px">
                                    <tbody>
                                        <tr>
                                            <td style="color:black;width:100px">Date From : </td>
                                            <td><input type="date" id="min" name="min" class="form-control" style="width: 200px"></td>
                                        </tr>
                                        <tr>
                                            <td style="color:black;width:100px">Date To : </td>
                                            <td><input type="date" id="max" name="max" class="form-control mt-1 mb-2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            <div style="display: flex;" class="mt-4">
                                <div class="filter-controls" style="margin-top:-20px; margin-right: 55%;display: flex;">
                                    <label for="collector-filter" style="color:rgb(0, 0, 0);width: 103px" >Collector: </label>
                                    <select id="collector-filter" class="form-control" style="width: 196px">
                                        <option value="">All</option>
                                        @php
                                        $categories = DB::table('libraries')->get();
                                        @endphp
                                        @foreach ($categories as $category)
                                            @if ($category->category === 'Collector')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                             
                            </div>
                                <div style="display: flex;margin-bottom:10px" class="mt-4">
                                    <div class="filter-controls" style="margin-top:-20px; margin-right: 55%;display: flex;">
                                        <label for="stub-filter" style="color:rgb(0, 0, 0);width:100px" >Stub No: </label>
                                        <input type="text"  id="stub-filter" class="form-control" style="width:200px">
                                    </div>
                                 
                                </div>
                                <table id="AbstractCollection_table" class="display table table-bordered" style="color:black !important; width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th>Payor Name</th>
                                            <th>Receipt Date</th>
                                            <th>OR No.</th>
                                            <th style="width:180px">Amount</th>
                                            <th style="display:none">Collector</th>
                                            <th style="display:none">stub no</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total amount : </td>
                                        </tr>
                                      
                                    </tfoot>
                                </table>
                                
                                <script>
                                    $(document).ready(function () {
                                        var AbstractCollectiondataTable = $('#AbstractCollection_table').DataTable({
                                            "order": [[1, "asc"]],
                                            "processing": true,
                                            "language": {
                                                processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                                            },
                                            serverSide: true,
                                      
                                            ajax: "/collection.AbstractCollection",
                                            columns: [
                                                
                                                {
                                                    data: 'customerName',
                                                    name: 'customerName'
                                                },
                                                {
                                                        data: 'transact_date',
                                                        name: 'transact_date',
                                                        render: function (data) {
                                                        
                                                            var date = new Date(data);

                                                        
                                                            var options = { year: 'numeric', month: 'long', day: 'numeric' };
                                                            return date.toLocaleDateString(undefined, options);
                                                        }
                                                    },
                                                {
                                                    data: 'or_no',
                                                    name: 'or_no'
                                                },
                                               
                                                {
                                                    data: 'collection',
                                                    name: 'collection',
                                                    className: 'text-right' 
                                                },
                                               
                                                {
                                                    data: 'collector',
                                                    name: 'collector',
                                                    visible: false 
                                                },
                                                {
                                                    data: 'stub_no',
                                                    name: 'stub_no',
                                                    visible: false 
                                                }
                                            ],
                                            footer: true,
                                           
                                       
                                            
                        
                                        });
                                

                                        $('#min, #max').on('change', function () {
                                            var minDate = $('#min').val();
                                            var maxDate = $('#max').val();
                                            AbstractCollectiondataTable.columns(1).search(minDate + '|' + maxDate, true, false).draw();
                                        });

                                        $('#collector-filter').on('change', function () {
                                            var selectedCollector = $(this).val();
                                            AbstractCollectiondataTable.column('4').search(selectedCollector).draw();
                                        });
                                        $('#stub-filter').on('change', function () {
                                            var selectedStub = $(this).val();
                                            AbstractCollectiondataTable.column('5').search(selectedStub).draw();
                                        });

                                       
                                        
                                        function updateTotal() {
                                            var totalAmount = 0;
                                            var totalCustomers = AbstractCollectiondataTable.page.info().recordsDisplay;

                                            AbstractCollectiondataTable.data().each(function (data) {
                                                totalAmount += parseFloat(data.collection);
                                            });

                                            
                                            $('#AbstractCollection_table tfoot td:eq(3)').text('Total amount: ' + totalAmount.toFixed(2));
                                        }

                                        $('#min, #max, #collector-filter, #stub-filter').on('change', function () {
                                            AbstractCollectiondataTable.draw();
                                        });

                                        AbstractCollectiondataTable.on('draw', function () {
                                            updateTotal();
                                        });

                                        AbstractCollectiondataTable.buttons().container().appendTo($('#AbstractCollection_table_wrapper .dataTables_filter'));

                                    var buttons = new $.fn.dataTable.Buttons(AbstractCollectiondataTable, {
                                        buttons: [
                                            {
                                                extend: 'print',
                                                title: function () {
                                                    var fromDate = new Date($('#min').val());
                                                    var toDate = new Date($('#max').val());
                                                    var selectedCollector = $('#collector-filter').val();
                                                    
                                                    var fromDateStr = fromDate.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
                                                    var toDateStr = toDate.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });

                                                    return '<h1>Republic of the Philippines</h1><h2>Municipality of Naawan</h2><h2>Abstract of Collection</h2><h2>Between ' + fromDateStr + ' and ' + toDateStr + '</h2><h3 style="font-weight:normal !important;font-size:6mm;margin-bot:20px">Collector : ' + selectedCollector + '</h3>';
                                                },
                                                customize: function (win) {
                                                    
                                                    $(win.document.body).find('table thead th:nth-child(5), table thead th:nth-child(6)').hide();
                                                    $(win.document.body).find('table tbody td:nth-child(5), table tbody td:nth-child(6)').hide();

                                                  
                                                    $(win.document.body).find('table').append($('#AbstractCollection_table tfoot').clone());
                                                }
                                            }
                                        ]
                                    });
                                    buttons.container().appendTo($('#AbstractCollection_table_wrapper .dataTables_filter'));
                                        updateTotal();

                                    });
                                </script>
                                <style>
                                    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
                                        margin-top:10px;
                                        margin-right:400px;
                                        background-color: #007bff !important;
                                        color: white;
                                        padding-left: 40px;
                                        background-size: 30px;
                                        background-image: url("/image/print.png");
                                        background-repeat: no-repeat;
                                        background-position: 10px center;
                                    }

                                    h1 {
                                            font-size: 24px;
                                            font-weight: bold;
                                            text-align: center;
                                        }

                                    h2 {
                                        font-size: 18px;
                                        font-weight: normal;
                                        text-align: center;
                                        margin-bottom:20px;
                                    }
                                        
                                </style>
                                
        </div>        
    </div>
@endsection