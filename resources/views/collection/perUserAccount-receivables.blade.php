@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row">
                <div>
                    <ul style="margin-top: 18px;">
                        <li><a class="tab1" href="/treasurer-account-receivables">Consumer List</a> / <a class="tab2" href="">Account Receivable</a></li>
                    </ul>
                </div>
                </div>
                <div class="row column1">
                    <div class="col-md-2"></div>
                        <div class="col-md-12 mt-4">
                            <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            
                                

                                <div class="full graph_head" style="background: #007bff; border-radius: 5px;">
                                
                                    <h2 class="mt-1" style="color: white !important;" >{{ $user->customerName }}</h2>
                                    <h4 class="mt-3" style="color: white !important;">{{ $user->account_id }}</h4>
                                   
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
                                <div class="row">
                                    <div class="col-md-6" style="text-align: center">
                                        <label for="paid"><i class="fa fa-check-circle" style="color: green"></i> Paid</label>
                                        <div class="card-body white_shd full margin_bottom_30" style="background-color:green; color:white;font-weight:bold;width:100%;font-size:10mm;text-align:center">{{$totalIsPaid}}
                                       </div>
                                    </div>
                                    <div class="col-md-6" style="text-align: center">
                                        <label for="unpaid"><i class="fa fa-exclamation-triangle" style="color: red"></i> Unpaid</label>
                                        <div class="card-body white_shd full margin_bottom_30" style="background-color:red; color:white;font-weight:bold;width:100%;font-size:10mm;text-align:center">{{$totalIsNotPaid}}</div>
                                    </div>
                                </div>
                                <table id="consumerledger_table" class="display table table-bordered" style="color: black !important; width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Status</th>
                                            <th>Account Date</th>
                                            <th>Account type name</th>
                                            <th>Item name</th>
                                            <th >Amount</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ledgerConsumer as $item)
                                        <tr>
                                            <td style="text-align: center"> 
                                                @if($item->isPaid == 3)
                                                    <span class="badge badge-info" style="width:50%;padding:5%"><i class="fa fa-check"></i> Partial Paid</span>
                                                    @else
                                                    @if ($item->isPaid == 0)
                                                        <span class="badge badge-danger" style="width:50%;padding:5%"><i class="fa fa-exclamation-triangle"></i> Unpaid</span>
                                                    @else
                                                        <span class="badge badge-success" style="width:50%;padding:5%"><i class="fa fa-check-circle"></i> Paid</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ date('F j, Y', strtotime($item->date)) }}</td>
                                            <td>{{ $item->account_type }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td style="text-align: right">{{ $item->balance }}</td>
                                         
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td style="background-color: #007bff;color:white">Grand total Balance </td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td style="background-color: #007bff;color:white;text-align: right;font-size:bold">{{number_format($grandTotalBalance,2)}}</td>
                                    </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
     
            <script>
              
                $(document).ready(function() {
                    const ledge = $('#consumerledger_table').DataTable({
                        "order": [[0, "desc"]],
                    });

                    $('.fetch-details').on('click', function(e) {
                        e.preventDefault();
                        
                        var accountId = $(this).data('account-id');
                        console.log(accountId);
            
                        $.ajax({
                            url: '/collection.perUserAccount-receivables/' + accountId, 
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