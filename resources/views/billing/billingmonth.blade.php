@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">BILL MONTH</h2>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal fade" id="billmonthmodal" tabindex="-1" role="dialog" aria-labelledby="billmonthmodalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="billmonthmodalLabel"><i class="fa fa-plus"></i>  Billing Month</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <div class="row mt-3">
                                <label for="billing_rate">Billing month of </label>
                                <input type="date" id="billingmonth_date" name="billingmonth_date" class="form-control">
                            </div>
                            
                            <script>
                                
                                const currentDate = new Date().toISOString().split('T')[0];
                                
                               
                                document.getElementById("billingmonth_date").value = currentDate;
                            </script>
                            <div class="row mt-3">
                                <label for="billing_rate">Billing Rate</label>
                                <select name="billingrate_name" id="billingrate_name" class="form-control">
                                    <option value="">Select Billing rate</option>
                                    @php
                                    $categories = DB::table('billing_rates')->distinct()->pluck('billingrate_name');
                                    @endphp
                                
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                
                             
                            </div>
                            <div class="row mt-3">
                                <label for="penalty_rate">Penalty Rate</label>
                                <select name="penalty_name" id="penalty_name" class="form-control">
                                    <option value="">Select Penalty name</option>
                                    @php
                                    $categories = DB::table('penalty_rates')->distinct()->pluck('penalty_name');
                                    @endphp
                                
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mt-3">
                                <label for="discount_name">Discount Rate</label>
                                <select name="discount_name" id="discount_name" class="form-control">
                                    <option value="">Select Discount rate</option>
                                    @php
                                    $categories = DB::table('discount_rates')->distinct()->pluck('discount_name');
                                    @endphp
                                
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="row mt-3">
                                <label for="trust_fund_rate">Trust Fund Rate</label>
                                <select name="trust_fund_rate" id="trust_fund_rate" class="form-control">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="add_bill_month">Save changes</button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row column1">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                        {{-- TABLE --}}
                        <div class="card-body mt-4">
                           <button class="btn btn-info margin_bottom_30" onclick="addbilling()">Add billing month</button>
                       
                            <script>
                                function addbilling(){
                                    $('#billmonthmodal').modal('show');
                                }
                                $('#add_bill_month').on('click', function(e){
                                    var bill_month = {
                                        'billingmonth_date': $('#billingmonth_date').val(),
                                        'billingrate_name': $('#billingrate_name').val(),
                                        'penalty_name': $('#penalty_name').val(),
                                        'discount_name': $('#discount_name').val(),
                                        // 'trustfund_name': $('#trustfund_name').val(),
                                        'status_bill_month': 0
                                    };
                                    $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $.ajax({
                                    type: 'post',
                                    url: 'add/billmonth',
                                    data: bill_month,
                                    dataType: 'json',
                                    success: function (response) {
                                       
                                        Swal.fire({
                                            title: 'Successfully Added',
                                            text: 'Successfully add for billing month',
                                            icon: 'success',
                                        });
                                        $('#billmonthmodal').modal('hide');
                                        $('#billmonth_table').DataTable().ajax.reload();
                                    }
                                });
                                });


                            </script>
                           <table class="display table table-bordered" id="billmonth_table" style="margin-top:10px;width: 100% !important;">
                            <thead>
                                <tr>
                               
                                    <th>Billing rate Name</th>
                                    <th>Penalty rate Name</th>
                                    <th>Discount rate Name</th>
                                    {{-- <th>Trustfund rate Name</th> --}}
                                    <th>Status</th>
                                    <th style="width:100px">Tools</th>
                                </tr>
                            </thead>
                           
                                
                           </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
            <script>
                $(document).ready(function(){
                  
                    $('#billmonth_table').DataTable({
                        
                        processing: true,
                        serverSide:true,
                        ajax: "/billingmonth",
                        columns: [
                        {
                            data : 'billingrate_name',
                            name : 'billingrate_name'
                        },
                        {
                            data : 'penalty_name',
                            name : 'penalty_name'
                        },
                        {
                            data : 'discount_name',
                            name : 'discount_name'
                        },
                        // {
                        //     data : 'trustfund_name',
                        //     name : 'trustfund_name'
                        // },
                        {
                            data : 'status_bill_month',
                            name : 'status_bill_month',
                            render: function(data) {
                                if(data == 0){
                                    return '<span class="unknown-status" style="flex: 1; white-space: nowrap;">Not used</span>';
                                }
                                else if(data == 1){
                                    return '<span class="connected-status" style="flex: 1; white-space: nowrap;">Currently used</span>';
                                }else{
                                    return '<span class="unknown-status" style="flex: 1; white-space: nowrap;">Not used</span>';
                                }
                                
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return '<div class="action-buttons">' + data + '</div>';
                            }
                        }
                            
                        ],
                    });
                });
                function activate(id) {
                    Swal.fire({
                        text: 'Are you sure you want to use this Rate for the month?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.isConfirmed) {
                    
                            $.ajax({
                                url: '/check-status-exists',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: 'GET',
                                success: function (response) {
                                    if (response.status_exists) {
                                        Swal.fire({
                                            title: 'Cannot set this bill month if there is already used.',
                                            text: 'Click first the button to deactivate the status that is currently used to proceed this action',
                                            icon: 'error',
                                            customClass: {
                                                content: 'small-text' 
                                            }
                                        });
                                    } else {
                                    
                                        $.ajax({
                                            url: '/activate-status',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            method: 'POST',
                                            data: {
                                                id: id,
                                                status_bill_month: 1, 
                                            },
                                            success: function (response) {
                                                Swal.fire('Successfully Used', '', 'success');
                                                $('#billmonth_table').DataTable().ajax.reload();
                                            },
                                            error: function (xhr, status, error) {
                                                Swal.fire('Error', 'error');
                                            },
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire('Error', 'error');
                                },
                            });
                        }
                    });
                }


                function deactivate(id) {
                    
                    Swal.fire({
                        text: 'Unused this Rate for the month?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.isConfirmed) {
                        

                            $.ajax({
                                url: '/deactivate-status',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: 'POST',
                                data: {
                                    id: id,
                                    status_bill_month: 2, 
                                },
                                success: function (response) {
                                    Swal.fire('This rate is not successfully used', '', 'success');
                                    $('#billmonth_table').DataTable().ajax.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire('Error', 'error');
                                },
                            });
                        }
                    });
                }
    
                     function editbillingmonth(id){
                       
                    
                    $.ajax({
                        url: "/billingmonth/edit/" + id + "/",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            $('#editbillingmonth_date').val(data.result.billingmonth_date)
                            $('#editbillingrate_name').val(data.result.billingrate_name)
                            $('#editpenalty_name').val(data.result.penalty_name)
                            $('#editdiscount_name').val(data.result.discount_name)
                            // $('#edittrustfund_name').val(data.result.trustfund_name)
                            $('#edit_bill_month').val('Update');
                            $('#action').val('Edit');
                            $('#editbillmonthmodal').modal('show');
                        
                            $('#edit_bill_month').off('click').on('click', function () {
                                updateBillingMonth(id);
                            });
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                        }
                    });
                    }
                    function updateBillingMonth(id){
                        var updateBillingmonth = {
                            'id': id,
                            'billingrate_name': $('#editbillingrate_name').val(),
                            'penalty_name': $('#editpenalty_name').val(),
                            'discount_name': $('#editdiscount_name').val(),
                    
                            
                        };

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'put',
                            url: 'billingmonth/update',
                            data: updateBillingmonth,
                            dataType: 'json',
                            success: function (response) {
                            $('#billmonth_table').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Successfully Updated',
                                text: 'This Billing Month Rate Is Now Updated',
                                icon: 'success',
                            });
                            },
                            error: function (error) {
                                Swal.fire({
                                title: 'Something Went Wrong ',
                                text: 'Please Check you input fields',
                                icon: 'error',
                            });
                            }
                        });
                    }
                    function show(id) {
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/show-billmonth/' + id,
                        success: function (response) {
                            
                            const billingrateData = response.billingrate_name;
                            const penaltyData = response.penalty_name;
                            const discountData = response.discount_name;

                        
                            function createTable(data, tableCaption, headers) {
                                let tableHTML = `<h3>${tableCaption}:</h3><table class="table">`;

                            
                                tableHTML += '<tr>';
                                headers.forEach(header => {
                                    tableHTML += `<th>${header}</th>`;
                                });
                                tableHTML += '</tr>';

                            
                                data.forEach(item => {
                                    tableHTML += '<tr>';
                                    headers.forEach(header => {
                                        tableHTML += `<td>${item[header]}</td>`;
                                    });
                                    tableHTML += '</tr>';
                                });

                                tableHTML += '</table>';
                                return tableHTML;
                            }

                        
                            const billingHeaders = ['billingrate_name', 'rate_case', 'classification', 'minVol', 'maxVol', 'minAmount', 'increment'];
                            const penaltyHeaders = ['penalty_name', 'penalty_percent', 'penalty_days'];
                            const discountHeaders = ['discount_name', 'discount_percent', 'discount_days'];

            
                            const billingTableHTML = createTable(billingrateData, 'Billing Rate', billingHeaders);
                            const penaltyTableHTML = createTable(penaltyData, 'Penalty Rate', penaltyHeaders);
                            const discountTableHTML = createTable(discountData, 'Discount Rate', discountHeaders);

                          
                            $('.modal-body-class').html(`${billingTableHTML}${penaltyTableHTML}${discountTableHTML}`);

                           
                            $('#billingssmonthmodal').modal('show');
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Something Went Wrong',
                                text: 'Please Check your input fields',
                                icon: 'error',
                            });
                        }
                    });
                }

                function billingmonthconfirmDelete(id) {
                        
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
                                billingMonthDelete(id);
                            } else {
                                Swal.fire(
                                    'Deletion canceled',
                                    'The billing month was not deleted.',
                                    'info'
                                )
                            }
                        });
                    }

                    function billingMonthDelete(id) {
                        
                        $.ajax({
                        
                            url: "{{ url('deleteBillingmonth/') }}/" + id,
                            type: 'DELETE',
                            
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            
                            success: function(response) {
                                
                                Swal.fire(
                                    'Deleted!',
                                    'The billing month has been deleted.',
                                    'success'
                                ).then(() => {

                                    $('#billmonth_table').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                            
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the month.',
                                    'error'
                                );
                            }
                        });
                    }


            </script>    
             <div class="modal fade" id="billingssmonthmodal" tabindex="-1" role="dialog" aria-labelledby="billingmonthmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="billingmonthmodalLabel">  Billing Month Info</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body-class" style="padding:10px">
                   
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     
                  
                  </div>
                </div>
              </div>   
            </div>  
          <div class="modal fade" id="editbillmonthmodal" tabindex="-1" role="dialog" aria-labelledby="billmonthmodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="billmonthmodalLabel"><i class="fa fa-edit"></i>  Billing Month</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="row mt-3">
                            <label for="billing_rate">Billing month of </label>
                            <input type="date" id="editbillingmonth_date" name="editbillingmonth_date" class="form-control" readonly>
                        </div>
                        
                     
                        <div class="row mt-3">
                            <label for="billing_rate">Billing Rate</label>
                            <select name="editbillingrate_name" id="editbillingrate_name" class="form-control">
                                <option value="">Select Billing rate</option>
                                @php
                                $categories = DB::table('billing_rates')->distinct()->pluck('billingrate_name');
                                @endphp
                            
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                            
                         
                        </div>
                        <div class="row mt-3">
                            <label for="penalty_rate">Penalty Rate</label>
                            <select name="editpenalty_name" id="editpenalty_name" class="form-control">
                                <option value="">Select Penalty name</option>
                                @php
                                $categories = DB::table('penalty_rates')->distinct()->pluck('penalty_name');
                                @endphp
                            
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mt-3">
                            <label for="discount_rate">Discount Rate</label>
                            <select name="editdiscount_name" id="editdiscount_name" class="form-control">
                                <option value="">Select Discount name</option>
                                @php
                                $categories = DB::table('discount_rates')->distinct()->pluck('discount_name');
                                @endphp
                            
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="row mt-3">
                            <label for="trust_fund_rate">Trust Fund Rate</label>
                            <select name="edittrustfund_name" id="edittrustfund_name" class="form-control">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="edit_bill_month">Save changes</button>
                </div>
              </div>
            </div>
          </div>
    </div> 
     
    
@endsection