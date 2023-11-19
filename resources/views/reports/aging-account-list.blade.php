@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">Aging of Accounts Receivable</h2>
                              
                               
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
                            <div class="filter-container" style="margin-top:-10px;margin-bottom:8px">
                                <label for="customer-filter" style="color:rgb(0, 0, 0)">Leave the customer blank to view all</label>
                                <select id="customer-filter" class="form-control" style="width:40%">
                                    <option value="">All</option>
                                    @php
                                    $categories = DB::table('consumer_infos')->select('customerName')->get();
                                    @endphp
                                    @foreach ($categories as $category)
                                            <option value="{{ $category->customerName }}">{{ $category->customerName }}</option>
                                    @endforeach
                                </select>
                                <div style="margin-top:-30px;margin-left:90%">
                                    <button id="printButton" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                                <table id="aging_table" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th style="flex: 1; white-space: nowrap;">Consumer Name</th>
                                            <th style="flex: 1; white-space: nowrap;">Particular</th>
                                            <th>balance</th>
                                            <th>Within30days</th>
                                            <th>31to60days</th>
                                            <th>61to90days</th>
                                            <th>0ver90days</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td>Grand Total</td>
                                            <td></td>
                                            <td style="text-align: right">0.00</td>
                                            <td style="text-align: right">0.00</td>
                                            <td style="text-align: right">0.00</td>
                                            <td style="text-align: right">0.00</td>
                                            <td style="text-align: right">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- MODAL CONTENT --}}
                <script>
                $(document).ready(function() {
                    var AgingdataTable = $('#aging_table').DataTable({
                        responsive: true,
                        paging: true,
                        "lengthMenu": [[50, 100,500,1000], [50, 100,500,1000]],
                        "pageLength": 100, 
                        "processing": true,
                        "language": {
                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                        },
                        serverSide: true,
                        ajax: "/reports.aging-account-list",
                        columns: [
                            {
                                data: 'customerName',
                                name: 'customerName',
                                render: function(data, type, row, meta) {
                                    if (type === 'display') {
                                        
                                        if (meta.row === 0 || data !== AgingdataTable.cell({ row: meta.row - 1, column: meta.col }).data()) {
                                            return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                        } else {
                                            return ''; 
                                        }
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'particular',  
                                name: 'particular',
                                render: function(data) {
                                    return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                }
                            },
                            {
                                data: 'balance',  
                                name: 'balance',
                                render: function(data) {
                                    if(data){
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                    }else{
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">  </div>';
                                    }
                                    
                                }
                            },
                            {
                                data: 'within30days',  
                                name: 'within30days',
                                render: function(data) {
                                    if(data){
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                    }else{
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">  </div>';
                                    }
                                    
                                }
                            },
                            {
                                data: '31to60days',  
                                name: '31to60days',
                                render: function(data) {
                                    if(data){
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                    }else{
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">  </div>';
                                    }
                                    
                                }
                            },
                            {
                                data: '61to90days',  
                                name: '61to90days',
                                render: function(data) {
                                    if(data){
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                    }else{
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">  </div>';
                                    }
                                    
                                }
                            },
                            {
                                data: 'Over90days',
                                name: 'Over90days',
                                render: function(data) {
                                    if(data){
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                    }else{
                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">  </div>';
                                    }
                                    
                                }
                            }
                        ],
                        footerCallback: function (row, data, start, end, display) {
                            var api = this.api();

                         
                            var balanceTotal = sumColumn(api, 2);
                            var within30daysTotal = sumColumn(api, 3);
                            var days3160Total = sumColumn(api, 4);
                            var days6190Total = sumColumn(api, 5);
                            var over90daysTotal = sumColumn(api, 6);

                            
                            $(api.column(2).footer()).html(formatTotal(balanceTotal));
                            $(api.column(3).footer()).html(formatTotal(within30daysTotal));
                            $(api.column(4).footer()).html(formatTotal(days3160Total));
                            $(api.column(5).footer()).html(formatTotal(days6190Total));
                            $(api.column(6).footer()).html(formatTotal(over90daysTotal));
                        }
                    });
                    $('#customer-filter').on('change', function () {
                        const selectedCustomer = $(this).val();
                        AgingdataTable.column(0).search(selectedCustomer).draw();

                    });
                    new $.fn.dataTable.Buttons(AgingdataTable, {
                        buttons: [
                            {
                                extend: 'print',
                                title: function () {              
                                    return '<h1>Naawan Municipal Water System</h1><h2>Aging of Account Receivables</h2><h2>as of ' +  getCurrentDate()  + '</h2>' 
                                },
                                customize: function (win) {
                            
                                    var totalPages = $(win.document.body).find('div').length;

                                    $(win.document.body).find('div tfoot').remove();
                                    if (totalPages > 0) {
                                        var grandTotalFooter = $('#aging_table tfoot').clone();
                                        var grandTotalRow = '<table style="width:100%"><tr>';
                                        grandTotalRow += '<td>Grand Total</td>';
                                        grandTotalRow += '<td style="width:14%"></td>';
                                    
                                        grandTotalRow += '<td>' + grandTotalFooter.find('td').eq(2).text() + '</td>';
                                        grandTotalRow += '<td>' + grandTotalFooter.find('td').eq(3).text() + '</td>';
                                        grandTotalRow += '<td>' + grandTotalFooter.find('td').eq(4).text() + '</td>';
                                        grandTotalRow += '<td>' + grandTotalFooter.find('td').eq(5).text() + '</td>';
                                        grandTotalRow += '<td>' + grandTotalFooter.find('td').eq(6).text() + '</td>';
                                        grandTotalRow += '</tr></table>';
                                        $(win.document.body).find('div:last').append(grandTotalRow);
                                    }

                                }
                            }
                        ]
                    });


                    $('#printButton').on('click', function () {
                        AgingdataTable.buttons(0).trigger();
                    });


                    function getCurrentDate() {
                        var currentDate = new Date();
                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                        return currentDate.toLocaleDateString('en-US', options);
                    }
                });

                function sumColumn(api, columnIndex) {
                    return api.column(columnIndex, { page: 'current' }).data().reduce(function (accumulator, currentValue) {
                        if (!isNaN(parseFloat(currentValue))) {
                            return accumulator + parseFloat(currentValue);
                        }
                        return accumulator;
                    }, 0);
                }

                function formatTotal(total) {
                    return isNaN(total) ? 'NaN' : total.toFixed(2);
                }
          

                    </script>

        </div>        
    </div>
    <style>
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
@endsection