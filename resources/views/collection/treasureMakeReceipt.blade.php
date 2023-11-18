@extends('layouts.dash')

@section('content')

{{-- <div id="loading-overlay">
    <div class="loading-text" style="color: white; font-weight: bold;">
        <span style="color: white;">Checking ...</span>
        <img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="spinning-image" style="width: 50px; height: 50px;" />
        
    </div>
</div> --}}


    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row">
           
                <div class="col-md-12" id="receiptColumn">
                    <style>
                       
                        .custom-width {
                            width: 1000px; 
                        }
                    </style>
                    <ul style="margin-top: 18px;">
                        <li><a class="tab1" href="/collection.treasurer-receipt">Consumer List</a> / <a class="tab2" href="">Receipt</a></li>
                    </ul>
        
                    <div class="row column1" style="margin-top: -6px;">
                        <div class="col-md-12 mt-4 mx-auto" style="margin-left: 0% !important;">
                            <div class="black_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                                <div class="full graph_head" style="background: #4caf50; border-radius: 5px;width:90%;margin-left:40px">
                                    <h2 class="mt-1" style="color: white !important;">Receipt</h2>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row column1 ">
                      
                        <div class="col-md-15 mx-auto">
                            <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                                <div class="card-body mt-4" style="padding: 20px;" style="width: 100% !important;">
                                    <!-- CONTENT -->
                                    <div class="row">
        
                                <div class="col-md-8">
                                    <div class="form-group" > 
                                        <label for="payorName" >Payor Name :</label>
                                        <input type="hidden" name="account_id" id="account_id" value="{{$user->account_id}}">
                                        <input type="text" class="form-control" id="customerName" name="customerName" value="{{$user->customerName}}  ({{$user->account_id}})">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="receiptID">Receipt No :</label>
                                        <input type="text" class="form-control" id="receiptID" name="receiptID">
                                    </div>
                                    
                                    <script>
                                       
                                      
                                            var receiptCounter = localStorage.getItem('receiptCounter');

                                        if (receiptCounter === null) {
                                            
                                            receiptCounter = 1;
                                        } else {
                                       
                                            receiptCounter = parseInt(receiptCounter);
                                        }

                            
                                        $('#receiptID').val(receiptCounter);
                                    </script>
                                    
                                </div> --}}
                            </div>    
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="receiptdate">Date:</label>
                                        <input type="date" class="form-control" id="receiptcurrentDate" name="receiptcurrentDate">
                                        <script>
                                            
                                            const currentDateInput = document.getElementById('receiptcurrentDate');
                                        
                                            
                                            const today = new Date();
                                        
                                            
                                            const yyyy = today.getFullYear();
                                            const mm = String(today.getMonth() + 1).padStart(2, '0'); 
                                            const dd = String(today.getDate()).padStart(2, '0');
                                        
                                     
                                            currentDateInput.value = `${yyyy}-${mm}-${dd}`;
                                        </script>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="stubNo">Stub No.:</label>
                                        <input type="number" class="form-control" id="stub_no" name="stub_no">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="orNo">OR No.:</label>
                                        <input type="text" class="form-control" id="or_number" name="or_number">
                                    </div>
                                    
                                    <script>
                                     
                                        function generateRandomLetter() {
                                            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                            const randomIndex = Math.floor(Math.random() * characters.length);
                                            return characters.charAt(randomIndex);
                                        }
                                        
                                       
                                        const orIdInput = document.getElementById('or_number');
                                        const storedOrNumber = localStorage.getItem('orNumber');
                                        
                                        if (storedOrNumber === null) {
                                            const currentYear = new Date().getFullYear();
                                            const randomDigits = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                                            const randomLetter = generateRandomLetter();
                                            orIdInput.value = currentYear + randomDigits + randomLetter;
                                            localStorage.setItem('orNumber', orIdInput.value);
                                        } else {
                                            orIdInput.value = storedOrNumber;
                                        }
                                        </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="rateCase">Rate Case:</label>
                                        <input type="text" class="form-control" id="rate_case" name="rate_case" value="{{$user->rate_case}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <br>
                                        <input type="hidden" name="account_id" id="account_id" value="{{$user->account_id}}">
                                        <button type="button" style="margin-top:7px;" onclick="openReceivable()" class="btn btn-primary" id="receivable_btn">Receivables</button>
                                    </div>
                                </div>                                
                            </div>
                            <hr>
                            <label for="details">Details</label>
                            <div class="filter-container" style="flex: 1; white-space: nowrap;">
                                <div class="row" style="flex: 1; white-space: nowrap;">
                                   
                                    <div class="row" style="margin-left: 460px;margin-top:-25px">
                                        <div class="col-md-3">
                                            <label for="filterMonthYear" style="color: black;">As of:</label>
                                        </div>
                                        <div class="col-md-5" style="margin-top:-7px">
                                            <input type="date" id="filterMonthYear" name="filterMonthYear" style="width: 160px;" class="form-control">
                                            <h6 style="color:blue">Day / Month / Year</h6>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>  
                         
                            <table id="forReceiptLedger_table"  class="display table table-bordered" style="color: black !important; width: 100% !important;">
                                <thead>
                                    <tr>
                                    
                                        <th style="flex: 1; white-space: nowrap;">Account Date</th>
                                        <th style="flex: 1; white-space: nowrap;">Account type</th>
                                        <th style="flex: 1; white-space: nowrap;">Item name</th>
                                        <th style="flex: 1; white-space: nowrap;">Amount</th>
                                        <th style="flex: 1; white-space: nowrap;">Select</th>
                                        
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                   @foreach ($waterbill as $not)
                                   <tr>
                                    <td>
                                        <input type="checkbox" style="width: 30px;height:30px;padding-left:3mm;padding-right:3mm" class="form-control" id="selected_items[]" name="selected_items[]" value="{{$not->id}}" class="larger-checkbox">
                                    </td>
                                            
                                        <td><input type="string" class="form-control" style="width:160px" id="date" name="date" value="{{ date('F j, Y', strtotime($not->date)) }}" readonly></td>
                                        <td ><input type="text" class="form-control" style="width:130px" id="account_type" name="account_type" value="{{$not->account_type}}" readonly></td>
                                        <td ><input type="text" class="form-control" style="width:120px" id="item_name" name="item_name" value="{{$not->item_name}}" readonly></td>
                                        <td ><input type="text" class="form-control" style="width:120px" id="balance" name="balance" value="{{$not->balance}}" readonly></td>
                                    </tr>
                                  
                                   @endforeach
                                </tbody> --}}
                                <script>
                                    $(document).ready(function() {
                                    const sheetlistTable = $('#forReceiptLedger_table').DataTable({
                                        "columnDefs": [
                                                {
                                                    "className": "action-column",
                                                    "targets": -1
                                                }
                                            ],
                                            "processing": true,
                                            "language": {
                                                processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                                            },
                                            serverSide: true,
                                            ajax: {
                                                url: "/receivableAlreadyAddedToReceipt",
                                                type: "GET",
                                                data: { account_id: $('#account_id').val() },
                                            },
                                            order: [[0, 'desc']],
                                            columns: [
                                                {
                                                    data: 'date',
                                                    name: 'date',
                                                    render: function (data) {
                                                                            
                                                    var date = new Date(data);
                    
                                                
                                                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                                                    return date.toLocaleDateString(undefined, options);
                                                }
                                                },
                                                {
                                                    data: 'account_type',
                                                    name: 'account_type',
                                                    render: function(data) {
                                                        return '<div class="text-wrap">' + data + '</div>';
                                                    }
                                                },
                                                {
                                                    data: 'item_name',
                                                    name: 'item_name',
                                                    render: function(data) {
                                                        return '<div class="text-wrap">' + data + '</div>';
                                                    }
                                                },
                                                {
                                                    data: 'balance',
                                                    name: 'balance',
                                                    render: function(data) {
                                                        return '<div class="text-wrap">' + data + '</div>';
                                                    }
                                                },
                                                {
                                                    data: 'action',
                                                    name: 'action',
                                                    orderable: false,
                                                    searchable: false,
                                                    render: function(data, type, row) {
                                                        if (row.account_type === 'Discount') {
                                                            return '<div class="text-wrap" style="text-align:center;padding-left:0mm;padding-right:0mm">' + data + '</div>';
                                                        } else {
                                                            return '<div class="text-wrap" style="text-align:center;padding-left:0mm;padding-right:0mm">' + data + '</div>';
                                                        }
                                                    }
                                                }

                                            ],
                                            rowCallback: function (row, data) {
                                                    $(row).addClass('ledger-row');
                                                },
                                 
                                            initComplete: function() {
                                                        calculateTotalAmount();
                                                    }
                                                });

                                               
                                                sheetlistTable.on('draw', function() {
                                                    calculateTotalAmount();
                                                });

                                           
                                                function updateTotalBalance() {
                                                    const collectionBill = parseFloat($('#collection_bill').val()) || 0;
                                                    const totalAmountWaterBill = parseFloat($('#Total_Amount_Water_bill').val()) || 0;
                                                    const totalBalance = totalAmountWaterBill - collectionBill;
                                                    $('#Total_balance').val(totalBalance.toFixed(2)); 
                                                }

                                                
                                                $('#Total_Amount_Water_bill').on('input', function() {
                                                    const newTotalAmountWaterBill = parseFloat($(this).val()) || 0;
                                                    $('#Total_Amount_Water_bill').val(newTotalAmountWaterBill.toFixed(2)); 
                                                    $('#collection_bill').val(newTotalAmountWaterBill.toFixed(2)); 
                                                    updateTotalBalance();
                                                });

                                        
                                                $('#collection_bill').on('input', function() {
                                                    updateTotalBalance();
                                                });

                                                function calculateTotalAmount() {
                                                    let totalAmount = 0;
                                                    sheetlistTable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                                                        const data = this.data();
                                                        let numericValue = parseFloat(data.balance) || 0;

                                                        if (data.account_type === 'Discount') {
                                                            numericValue = -numericValue;
                                                        }

                                                        totalAmount += numericValue;
                                                    });

                                                    $('#Total_Amount_Water_bill').val(totalAmount.toFixed(2)); 
                                                    $('#collection_bill').val(totalAmount.toFixed(2)); 
                                                    updateTotalBalance();
                                                }
                                });
                                </script>
                                
                            </table>
                            
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="totalAmount" style="line-height: 2.5; margin-left:90px !important;">Total Amount:</label>
                                </div>
                                
                                {{-- <div class="col-md-2">
                                    <button type="button" class="btn btn-secondary" style="margin-left: 20px;" id="allocate" name="allocate">Allocate</button>
                                </div> --}}
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="Total_Amount_Water_bill" name="Total_Amount_Water_bill" readonly>
                                </div>
                                
                                
                                
                            </div>   
                            <div class="row">
                                  <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="totalAmount" style="line-height: 2.5; margin-left:90px !important;">Enter Amount:</label>
                                </div>
                                
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="collection_bill" name="collection_bill">
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                              <div class="col-md-4">
                                  <label for="Total_balance" style="line-height: 2.5; margin-left:90px !important;">Balance:</label>
                              </div>
                              
                              <div class="col-md-4">
                                  <input type="text" class="form-control" id="Total_balance" name="Total_balance" readonly>
                              </div>
                          </div> 
                          <script>
                         
                        </script>
                          
                            <hr>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group" style="display: flex !important;">
                                        <input type="checkbox" id="cash" name="cash" value="Cash" checked>
                                        <label for="cashCheckbox" style="margin-top:5px;margin-left:5px"> Cash</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4" style="margin-left: 25px;">
                                    <div class="form-group">
                                        <label for="draweeBank">Drawee Bank</label>
                                       
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-left:-55px;">
                                    <div class="form-group">
                                        <label for="checkNumber">Number</label>
                                       
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-left:30px;">
                                    <div class="form-group">
                                        <label for="checkDate">Date</label>
                                    </div>
                                </div>   
                            </div>
                            <div class="row" >
                                <div class="col-md-2">
                                    <div class="form-group" style="display: flex !important;line-height:2.5">
                                        <input style="margin-top: -8px;margin-right: 5px;" type="checkbox" id="drawee_Checkbox" name="drawee_Checkbox">
                                        <label for="tsekCheckbox">Check</label>
                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-left:25px;">
                                    <div class="form-group">
                                        <input class="form-control" name="drawee_input" id="drawee_input" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-left:-13px;">
                                    <div class="form-group">
                                        <input class="form-control" name="drawee_number" id="drawee_number" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-left:-14px;">
                                    <div class="form-group">
                                        <input class="form-control" name="draweeDate" id="draweeDate" type="date">
                                    </div>
                                </div>   
                            </div> 
                            <div class="row" >
                                <div class="col-md-4">
                                    <div class="form-group" style="display: flex !important;line-height:2.5">
                                        <input style="margin-top: -8px;margin-right: 5px;" type="checkbox" id="money_checkbox" name="money_checkbox">
                                        <label for="tsekCheckbox">Money Order</label>
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin-left:25px;">
                                </div>
                                <div class="col-md-3" style="margin-left:-13px;">
                                    <div class="form-group">
                                        <input class="form-control" name="money_order_number" id="money_order_number" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-left:-14px;">
                                    <div class="form-group">
                                        <input class="form-control" name="money_order_date" id="money_order_date" type="date">
                                    </div>
                                </div>   
                            </div> 
                            <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="print_receipt_btn"><i class="fa fa-print"></i> Print</button>
                                            <button type="button" class="btn btn-primary" id="create_receipt_btn"><i class="fa fa-check-circle-o"></i> Save</button>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group" style="display: flex !important;">
                                            <label for="collector" style="line-height:2.5;margin-left: -65px; margin-right: 15px;">Collector</label>
                                            <select class="form-control" name="collector" id="collector">
                                                <option value="">Select Collector Name</option>
                                                @php
                                                    $collector = DB::table('libraries')->geT();
                                                @endphp
                                                @foreach ($collector as $category)
                                                @if ($category->category === 'Collector')
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
            </div>
            {{-- modal --}}
            <div class="modal fade" id="receivableModal" tabindex="-1" role="dialog" aria-labelledby="receivableModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="receivableModalLabel"><div id="penalty_notif"></div></h5>
                   
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <table id="receivables_table" class="display table table-bordered" style="color: black !important; width: 100% !important;">
                            <thead>
                                <tr>
                                 
                                    <th style="flex: 1; white-space: nowrap;">Account Date</th>
                                    <th style="flex: 1; white-space: nowrap;">Account type</th>
                                    <th style="flex: 1; white-space: nowrap;">Item name</th>
                                    <th style="flex: 1; white-space: nowrap;">Amount</th>
                                    <th style="flex: 1; white-space: nowrap;text-align:center">Select</th>
                                </tr>
                            </thead>
                          
                         <script>
                        
                        
                         </script>
                           
                        </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="addReceipt_btn">Add to receipt</button>
                    </div>
                  </div>
                </div>
              </div>
              
            <script>
                function backToReceivable(id) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You are about to return it to account receivable of this consumer?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Return it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: 'POST',
                                    url: '/backToReceivable',
                                    data: { id: id },
                                    success: function(response) {
                                        Swal.fire({
                                            title:'Success!',
                                            icon: 'success',
                                        });
                                        $('#receivables_table').DataTable().ajax.reload();
                                        $('#forReceiptLedger_table').DataTable().ajax.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire('Error', 'An error occurred.', 'error');
                                    }
                                });
                            }
                        });
                    }
                    function Delete(id) {
                            
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    deleteDisc(id);
                                } else {
                                    Swal.fire(
                                        'Deletion canceled',
                                        'The discount was not deleted.',
                                        'info'
                                    )
                                }
                            });
                        }

                        function deleteDisc(id) {
                            
                            $.ajax({
                            
                                url: "{{ url('deleteDisc/') }}/" + id,
                                type: 'DELETE',
                                
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                
                                success: function(response) {
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'The discount has been deleted.',
                                        'success'
                                    ).then(() => {

                                        $('#penaltyrate_Table').DataTable().ajax.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the rate.',
                                        'error'
                                    );
                                }
                            });
                        }
               $(document).ready(function() {
               
                    $('#receivables_table').DataTable({
                        "columnDefs": [
                            {
                                "className": "action-column",
                                "targets": -1
                            }
                        ],
                        "processing": true,
                        "language": {
                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                        },
                        serverSide: true,
                        ajax: {
                            url: "/view",
                            type: "GET",
                            data: { account_id: $('#account_id').val() },
                        },
                        order: [[0, 'desc']],
                        columns: [
                            {
                                data: 'date',
                                name: 'date',
                                render: function (data) {
                                                        
                                var date = new Date(data);

                            
                                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                                return date.toLocaleDateString(undefined, options);
                            }
                            },
                            {
                                data: 'account_type',
                                name: 'account_type',
                                render: function(data) {
                                    return '<div class="text-wrap">' + data + '</div>';
                                }
                            },
                            {
                                data: 'item_name',
                                name: 'item_name',
                                render: function(data) {
                                    return '<div class="text-wrap">' + data + '</div>';
                                }
                            },
                            {
                                data: 'balance',
                                name: 'balance',
                                render: function(data) {
                                    return '<div class="text-wrap">' + data + '</div>';
                                }
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                render: function(data) {
                                    return '<div class="text-wrap" style="text-align:center;padding-left:0mm;padding:right:0mm">' + data + '</div>';
                                }
                            }
                        ]
                    });
                    
                });
                    $('#addReceipt_btn').on('click', function() {
                        var selectedItems = [];
                        var account_id = $('#account_id').val();
                        var receiptcurrentDate = $('#receiptcurrentDate').val(); 

                        $('input[name="selected_items[]"]:checked').each(function() {
                            var itemId = $(this).val();
                            selectedItems.push(itemId);
                        });

                        if (selectedItems.length > 0) {
                            $.ajax({
                                type: 'POST',
                                url: '/addedToReceipt',
                                data: { selectedItems: selectedItems, account_id: account_id, receiptcurrentDate: receiptcurrentDate}, // Include account_id in the data
                                success: function(response) {
                                    Swal.fire(
                                        'Successfully added to Receipt!',
                                        'Check it now',
                                        'success'
                                    );
                                    $('#forReceiptLedger_table').DataTable().ajax.reload();
                                    $('#receivables_table').DataTable().ajax.reload();
                                },
                                error: function(error) {
                                    Swal.fire(
                                        'No receivable added!',
                                        'Please select at least one checkbox and check your input fields',
                                        'error'
                                    );
                                }
                            });
                        }
                    });


                function openReceivable(id) {
                    $('#receivableModal').modal('show');
                }

                $('#receivable_btn').on('click', function(e){
                 
                 var account_id = $('#account_id').val();
                 
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                 });

                 $.ajax({
                     type: 'get',
                   
                     url: '/create-penalty/' + account_id,
                   
                     dataType: 'json',
                     success: function (response) {
                            $('#receivables_table').DataTable().ajax.reload();
                            const resultSection = document.getElementById('penalty_notif');
                            let alertHTML = '';

                          
                            alertHTML = '<div class="alert alert-success" style="color: green; width: 350px; text-align: left; font-weight: bold" role="alert"><i class="fa fa-check-circle" style="color: green"></i>  ' + response.message + '</div>';

                        
                            resultSection.innerHTML = alertHTML;

                           
                            setTimeout(function() {
                                resultSection.innerHTML = '';
                            }, 3000);
                        },

                     error: function (xhr, status, error) {
                         Swal.fire(
                             'No penalty added!',
                             'Please select at least one checkbox and check your input fields',
                             'error'
                         )
                     }
                 });
             });
                    

            </script>
        
          
            {{-- create receipt --}}
            <script>
       
          $('#print_receipt_btn').on('click', function () {
            if (!createButtonClicked) {
                    
                Swal.fire(
                    'Cannot print this receipt!',
                    'please save it first before printing this receipt',
                    'error'
                )
                    printWindow.close();
                } 
            function convertToWordsWithDecimal(number) {
                    var ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                    var teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
                    var tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

                    var numArr = number.toString().split('.');
                    var dollars = parseInt(numArr[0]);
                    var cents = numArr[1] ? parseInt(numArr[1]) : 0;

                    function convertThreeDigits(num) {
                        if (num === 0) return '';
                        if (num < 10) return ones[num];
                        if (num < 20) return teens[num - 10];
                        var digitOne = num % 10;
                        var digitTen = Math.floor(num / 10) % 10;
                        var digitHundred = Math.floor(num / 100);
                        var result = '';
                        if (digitHundred > 0) {
                            result += ones[digitHundred] + ' Hundred';
                            if (digitTen > 0 || digitOne > 0) result += ' and ';
                        }
                        if (digitTen >= 2) {
                            result += tens[digitTen];
                            if (digitOne > 0) result += '-';
                        }
                        if (digitOne > 0) {
                            result += ones[digitOne];
                        }
                        return result;
                    }

                    var dollarsText = convertThreeDigits(dollars);
                    var centsText = '';

                    if (cents > 0) {
                        var centsString = cents.toString();
                        if (centsString.length === 1) {
                            centsText = ' point ' + ones[cents] + ' Zero';
                        } else {
                            centsText = ' point ' +  (centsString[0] === '0' ? ones[centsString[1]] : tens[centsString[0]]) + (centsString[1] === '0' ? '' : ' ' + ones[centsString[1]]) + ' Pesos Only' ;
                        }
                    }

                    return dollarsText + centsText;
                }


                    var printWindow = window.open('', '', 'width=800,height=600');

                    var rateCase = $('#rate_case').val() || '';
                    var receiptDate = $('#receiptcurrentDate').val() || '';
                    if (receiptDate) {
                        var parsedDate = new Date(receiptDate);
                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                        receiptDate = parsedDate.toLocaleDateString(undefined, options);
                    }
                    var orNo = $('#or_number').val() || '';
                    var customerName = $('#customerName').val() || '';
                    var totalWaterBillAmount = $('#Total_Amount_Water_bill').val() || '';
                    var totalWaterBillAmountWords = convertToWordsWithDecimal(parseFloat(totalWaterBillAmount));
                    var collector = $('#collector').val() || '';

                    var selectedItemsTable = $('<table class="display table table-bordered" style="color: black !important;">' +
                        '<tbody></tbody></table>');

                        $('.ledger-row').each(function () {
                        var row = $(this);
                        var accountType = row.find('td:eq(1)').text() || '';
                        var itemName = row.find('td:eq(2)').text() || '';
                        var balance = row.find('td:eq(3)').text() || '';
                        
                    
                        if (accountType === 'Discount') {
                            balance = '-' + balance;
                        }

                        var balanceCell = '<td style="text-align:right">' + balance + '</td';

                        selectedItemsTable.find('tbody').append('<tr><td>' + '<p style="width:120px;"></p>' + accountType + '</td><td >' + '<p style="width:110px"></p>'+ itemName + '</td>' + balanceCell + '</tr>');
                    });


                    printWindow.document.write('<html><head><title>Receipt Printout</title>' +
                        '<style>body { margin-left: 50px; margin-top: 140px; }</style>' + '</head><body>');
                    printWindow.document.write('<h4 style="margin-left:100px;margin-top:30px">' + rateCase + '</h4>');
                    printWindow.document.write('<p style="margin-left:180px;margin-top:80px">' + orNo + '</p>');
                    printWindow.document.write('<p>' + receiptDate + '</p>');
                    printWindow.document.write('<p style="margin-top:40px;margin-bottom:50px">' + customerName + '</p>');
                    printWindow.document.write(selectedItemsTable[0].outerHTML);
                    printWindow.document.write('<p style="margin-top:150px;margin-left:240px">' + totalWaterBillAmount  + '</p>');
                    printWindow.document.write('<p style="margin-top:40px;margin-left:-20px">' + totalWaterBillAmountWords + '</p>');

                    printWindow.document.write('<p style="margin-left:200px;margin-top:90px;">' + collector + '</p>');
                    printWindow.document.write('</body></html>');

                    printWindow.document.close();
                    $('input[type="checkbox"]:checked').closest('tr').remove();
                    $('#forReceiptLedger_table').DataTable().ajax.reload();
                    printWindow.print();
                   
                });

            </script>
            <script>
                var createButtonClicked = false;

                $('#create_receipt_btn').on('click', function (e) {
                    createButtonClicked = true;
                    var selectedData = [];

                       
                        $('.ledger-row').each(function () {
                            var row = $(this);
                            var rowData = {
                                'date': row.find('td:eq(0)').text(),
                                'account_type': row.find('td:eq(1)').text(), 
                                'item_name': row.find('td:eq(2)').text(), 
                                'balance': row.find('td:eq(3)').text(),
                            };
                            selectedData.push(rowData);
                        });
            
                    var createReceiptForm = {
                        'selected_data': selectedData,
                        'account_id': $('#account_id').val(),
                        'customerName': $('#customerName').val(),
                        // 'receiptID': $('#receiptID').val(),
                        'receiptcurrentDate': $('#receiptcurrentDate').val(),
                        'stub_no': $('#stub_no').val(),
                        'or_number': $('#or_number').val(),
                        'rate_case': $('#rate_case').val(),
                        'cash': $('#cash').is(":checked") ? 1 : 0,
                        'drawee_Checkbox': $('#drawee_Checkbox').is(":checked") ? 1 : 0,
                        'drawee_input': $('#drawee_input').val(),
                        'drawee_number': $('#drawee_number').val(),
                        'checkDrawee': $('#checkDrawee').val(),
                        'money_checkbox': $('#money_checkbox').is(":checked") ? 1 : 0,
                        'money_order_number': $('#money_order_number').val(),
                        'money_order_date': $('#money_order_date').val(),
                        'collector': $('#collector').val(),
                        'collection_bill': $('#collection_bill').val(),
                        'Total_balance': $('#Total_balance').val(),
                        'Total_Amount_Water_bill': $('#Total_Amount_Water_bill').val(),
                    };
            
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            
                    $.ajax({
                        type: 'get',
                        url: '/create-receipt',
                        data: createReceiptForm,
                        dataType: 'json',
                        success: function (response) {
                            
                            const currentOrNumber = orIdInput.value;
                                const updatedOrNumber = currentOrNumber.substring(0, currentOrNumber.length - 1) + generateRandomLetter();
                                orIdInput.value = updatedOrNumber;
                                localStorage.setItem('orNumber', updatedOrNumber);
                            Swal.fire(
                                'Successfully Created Receipt!',
                                'You can now print the receipt',
                                'success'
                            )
                            
            
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Unsuccessfully Created Receipt!',
                                'please select at least one in account receivables and check you input fields',
                                'error'
                            )
                        }
                    });
                    $('#print_receipt_btn').prop('disabled', false);
                });
            </script>
            
      


        </div>        
   

        <script>
              $(document).ready(function() {
                    $('.fetch-details-receipt').on('click', function(e) {
                        e.preventDefault();
                        
                        var accountId = $(this).data('account-id');
                        console.log(accountId);
            
                        $.ajax({
                            url: '/collection.receipt-perUser/' + accountId, 
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