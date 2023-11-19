@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row">
                <div>
                    <ul style="margin-top: 18px;">
                        <li><a class="tab1" href="/consumer-ledger">Consumer List</a> / <a class="tab2" href="">Consumers Ledger</a></li>
                    </ul>
                </div>
                </div>
                <div class="row column1">
                    <div class="col-md-2"></div>
                        <div class="col-md-12 mt-4">
                            <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                                <div class="full graph_head" style="flex: 1; white-space: nowrap;background: #007bff; border-radius: 5px;">
                                    <h2 class="mt-1" style="color: white !important;" >{{ $user->customerName }}</h2>
                                    <h4 class="mt-3" style="color: white !important;">{{ $user->account_id }}</h4>
                                    <div style="margin-left:90%;margin-top:-50px">
                                        <button class="btn btn-success" id="print_consumer_ledger"><i class="fa fa-print"></i> Print</button>
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
                            <table id="consumerledger_table" class="display table table-bordered" style="color: black !important; width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th >Transact Date</th>
                                        <th >Particular</th>
                                        <th>OR NO</th>
                                        <th>Issuance</th>
                                        <th>Collection</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                              
                                </tbody>
                                <tfoot>
                                    <tr >
                                        <td>Grand Total</td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right">{{ number_format($grand_total_issuance[0]->total_issuance, 2) }}</td>
                                        <td style="text-align: right">{{ number_format($grand_total_collection[0]->total_collection, 2) }}</td>
                                        <td style="text-align: right">{{ number_format($grand_total_balance, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                           
                            <script>
                               $(document).ready(function () {

                                    const consumerTable = $('#consumerledger_table').DataTable({
                                        
                                        "processing": true,
                                        "language": {
                                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                                        },
                                        serverSide: true,
                                        "order": [[0, "asc"]],
                                        columns: [
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
                                                data: 'particular',
                                                name: 'particular'
                                            },
                                            {
                                                data: 'or_no',
                                                name: 'or_no',
                                                render: function(data) {
                                                    if(data){
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                                    }else{
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right"></div>';
                                                    }
                                                }
                                            },
                                            {
                                                data: 'issuance',
                                                name: 'issuance',
                                                render: function (data, type, row) {
                                                    if (row.particular && row.particular.startsWith('Discount - ')) {
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + '(' + parseFloat(data).toFixed(2) + ')' + '</div>';
                                                    }
                                                    if(data){
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                                    }else{
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right"></div>';
                                                    }
                                                    
                                                }
                                            },
                                            {
                                                data: 'collection',
                                                name: 'collection',
                                                render: function (data, type, row) {
                                                   
                                                    if(data){
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                                    }else{
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right"></div>';
                                                    }
                                                }
                                            },
                                            {
                                                data: 'generated_balance',
                                                name: 'generated_balance',
                                                render: function (data, type, row) {
                                                    if (typeof data === 'number') {
                                                        return data.toFixed(2);
                                                    }
                                                    if(data){
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right">' + data + '</div>';
                                                    }else{
                                                        return '<div style="flex: 1; white-space: nowrap;text-align:right"></div>';
                                                    }
                                                }
                                            }
                                        ]
                                       
                                    });
                          
                                    $('#min, #max').on('change', function () {
                                        var minDate = $('#min').val();  
                                        var maxDate = $('#max').val();
                                     
                                        consumerTable.columns(0).search(minDate + '|' + maxDate, true, false).draw();
                                     
                                    });
                            
                                  
                              
                                });
                                $('#print_consumer_ledger').on('click', function () {
                                        printConsumerLedger();
                                    });

                                    function printConsumerLedger() {
                                        var printWindow = window.open('', '', 'width=800,height=600');
                                        var tableContent = document.getElementById('consumerledger_table').outerHTML;
                                        var customStyles = `
                                        <style>
                                            #consumerledger_table {
                                               
                                                border-collapse: collapse;
                                                width: 100%;
                                                border: 1px solid black;
                                            }

                                            #consumerledger_table th,
                                            #consumerledger_table td {
                                                border: 1px solid black; 
                                                padding:3px;
                                            }

                                            #consumerledger_table td.issuance,
                                            #consumerledger_table td.or_no,
                                            #consumerledger_table td.collection,
                                            #consumerledger_table td.balance,
                                            #consumerledger_table td.transact,
                                            #consumerledger_table td.particular {
                                                text-align: center;
                                            }

                                            #consumerledger_table th.transact,
                                            #consumerledger_table th.particular {
                                                text-align: left;
                                            }

                                            h2 {
                                                margin-right: 20px;
                                                padding-right: 20px;
                                            }

                                            h4 {
                                                padding-bottom: 10px;
                                            }

                                            tfoot td {
                                                border-top: 1px solid black;
                                                text-align: right !important;
                                            }

                                            #consumerledger_table tbody {
                                               
                                                margin-left: 50px;
                                            }
                                        </style>

                                    `;

                                        printWindow.document.write('<html><head style="text-align:left"><title >Water Consumer Ledger</title>');
                                        printWindow.document.write(customStyles);
                                        printWindow.document.write('</head><body>');
                                        printWindow.document.write('<h2>{{ $user->customerName }} ({{ $user->account_id }})</h2>');
                                        printWindow.document.write(tableContent);
                                        printWindow.document.write('</body></html>');

                                        printWindow.document.close();
                                        printWindow.print();
                                    }
   
                            </script>
                            
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <style>
             
                #consumerledger_table td.issuance,
                #consumerledger_table td.collection,
                #consumerledger_table td.balance,
                #consumerledger_table td.transact,
                #consumerledger_table td.particular {
                    text-align: center;
                }
            
              
                #consumerledger_table {
                    color: black !important;
                    width: 100% !important;
                }
            
                
                @media print {
                    #consumerledger_table td.issuance,
                    #consumerledger_table td.collection,
                    #consumerledger_table td.balance {
                        text-align: right !important;
                    }
                }
            </style>
            
            <script>

                  
                $(document).ready(function() {
                  

                    $('.fetch-details').on('click', function(e) {
                        e.preventDefault();
                        
                        var accountId = $(this).data('account-id');
                        console.log(accountId);
            
                        $.ajax({
                            url: '/collection.perConsumer-ledger/' + accountId, 
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log('AJAX response:', response);
                                if (response.user) {
                                    $('#customer-name').text(response.user.customerName);
                                    $('#account-id').text(response.user.account_id);
                                }
                            },
                            error: function(error) {
                                console.log('AJAX error:', error);
                            }
                        });
                    });

                 

                });
            </script>
            
@endsection