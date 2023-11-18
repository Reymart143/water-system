@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
       <div class="row column_title">
          <div class="col-md-12">
             <div class="page_title">
                <h2><i class="fa fa-star"></i> Rates</h2>
             </div>
          </div>
       </div>
       <!-- row -->
       <div class="row">
          <!-- billing rate table section -->
          <div class="col-md-12">
             <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                   <div class="heading1 margin_0" style="display: inline-flex; ">
                      <h2>Billing Rate</h2>
                      <button class="btn btn-info" onclick="openBillingModal()" style="margin-left: 580px;"> Add billing rate</button>
                   </div>
                </div>
                {{-- modal for billing rate --}}
                <div class="modal fade" id="rateBillingModal" tabindex="-1" role="dialog" aria-labelledby="rateBillingModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="rateBillingModalLabel"><i class="fa fa-plus"></i> Add Billing Rate</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body-billing" style="padding: 15px !important;">
                          <form>
                            @csrf
                            <div class="col-md-12 mb-2">
                                <label for="input" style="color: black;"></i>Billing rate name</label>
                                <input type="text" class="form-control" name="billingrate_name" id="billingrate_name" placeholder="Enter billing rate name">
                            </div>
                            <div class="col-md-12">
                                <label for="input" style="color: black;"><i class="fa fa-star"></i> Rate Case</label>
                                <select class="form-control form-select placement-dropdown" id="rate_case" name="rate_case" required autocomplete="role">
                                    <option value="" disabled selected>Select type of Rate CAse</option>
                                    @php
                                        $categories = DB::table('libraries')->get();
                                    @endphp

                                    @foreach ($categories as $category)
                                        @if ($category->category === 'Rate Case')
                                            <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span id="rate_case-error" style="color:red" class="is-invalid" role="alert"></span>
                            </div>
                            <div class="col-md-12">
                                <label for="input" style="color: black;"><i class="fa fa-cube"></i> Classification</label>
                                <select class="form-control form-select placement-dropdown" id="classification" name="classification" required autocomplete="role">
                                    <option value="" disabled selected>Select type of Classification</option>
                                    @php
                                    $categories = DB::table('libraries')->get();
                                @endphp

                                @foreach ($categories as $category)
                                    @if ($category->category === 'Classification')
                                        <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                    @endif
                                @endforeach
                                </select>
                                <span id="classification-error" style="color:red" class="is-invalid" role="alert"></span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="input" style="color: black;"></i>Minimum Volume</label>
                                <input type="number" class="form-control" name="minVol" id="minVol" placeholder="Enter Minimum Volume">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="input" style="color: black;">Maximun Volume</label>
                                <input type="number" class="form-control" name="maxVol" id="maxVol" placeholder="Enter Maximum Volume">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="input" style="color: black;">Minimum Amount</label>
                                <input type="number" class="form-control" name="minAmount" id="minAmount" placeholder="Enter Minimum Amount">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="input" style="color: black;">Increment</label>
                                <input type="number" class="form-control" name="increment" id="increment" placeholder="Enter Increment">
                            </div>
                        </form>
                        </div>
                       
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" id="add_billing_btn" class="btn btn-primary">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script>
                    function openBillingModal(){
                        $('#rateBillingModal').modal('show');
                    }
                        $('#add_billing_btn').on('click', function(){
                            var billingrateForm = {
                                'id' : $('#hidden_id').val(),
                                
                                'billingrate_name' : $('#billingrate_name').val(),
                                'rate_case' : $('#rate_case').val(),
                                'classification' : $('#classification').val(),
                                'minVol' : $('#minVol').val(),
                                'maxVol' : $('#maxVol').val(),
                                'minAmount' : $('#minAmount').val(),
                                'increment' : $('#increment').val()
                            };
                            $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'post',
                            url: 'add-billingrate',
                            data: billingrateForm,
                            dataType: 'json',
                            success: function (response) {
                                $('#name').val('');
                              
                                $('#minVol').val('');
                                $('#maxVol').val('');
                                $('#minAmount').val('');
                                $('#increment').val('');
                              
                                Swal.fire({
                                    title: 'Successfully Added',
                                    text: 'Successfully Added Billing Rate',
                                    icon: 'success',
                                });
                                $('#billingrate_Table').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'error',
                                    text: 'An error occurred while adding the billing rate.',
                                    icon: 'error',
                                });
                            }
                        });
                        })
                 
                    </script>
                    <div class="modal fade" id="editrateBillingModal" tabindex="-1" role="dialog" aria-labelledby="editrateBillingModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editrateBillingModalLabel"><i class="fa fa-edit"></i> Edit Billing Rate</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body-billing" style="padding: 15px !important;">
                              <form>
                                @csrf
                                <div class="col-md-12 mb-2">
                                    <label for="input" style="color: black;"></i>Billling rate name</label>
                                    <input type="text" class="form-control" name="edit_billingrate_name" id="edit_billingrate_name" placeholder="Enter name">
                                </div>
                                <div class="col-md-12">
                                    <label for="input" style="color: black;"><i class="fa fa-star"></i> Rate Case</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_rate_case" name="edit_rate_case" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Rate CAse</option>
                                        @php
                                            $categories = DB::table('libraries')->get();
                                        @endphp
    
                                        @foreach ($categories as $category)
                                            @if ($category->category === 'Rate Case')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span id="rate_case-error" style="color:red" class="is-invalid" role="alert"></span>
                                </div>
                                <div class="col-md-12">
                                    <label for="input" style="color: black;"><i class="fa fa-cube"></i> Classification</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_classification" name="edit_classification" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Classification</option>
                                        @php
                                        $categories = DB::table('libraries')->get();
                                    @endphp
    
                                    @foreach ($categories as $category)
                                        @if ($category->category === 'Classification')
                                            <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                    <span id="classification-error" style="color:red" class="is-invalid" role="alert"></span>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="input" style="color: black;"></i>Minimum Volume</label>
                                    <input type="number" class="form-control" name="edit_minVol" id="edit_minVol" placeholder="Enter Minimum Volume">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="input" style="color: black;">Maximun Volume</label>
                                    <input type="number" class="form-control" name="edit_maxVol" id="edit_maxVol" placeholder="Enter Maximum Volume">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="input" style="color: black;">Minimum Amount</label>
                                    <input type="number" class="form-control" name="edit_minAmount" id="edit_minAmount" placeholder="Enter Minimum Amount">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="input" style="color: black;">Increment</label>
                                    <input type="number" class="form-control" name="edit_increment" id="edit_increment" placeholder="Enter Increment">
                                </div>
                            </form>
                            </div>
                           
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" id="Updatebillingrate_btn" class="btn btn-primary"></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <script>
                    function editbillingrate(id){
                        $('#Updatebillingrate_btn').text('Update Billing Rate');
                    
                    $.ajax({
                        url: "/billingrate/edit/" + id + "/",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            $('#edit_billingrate_name').val(data.result.billingrate_name)
                            $('#edit_rate_case').val(data.result.rate_case)
                            $('#edit_classification').val(data.result.classification)
                            $('#edit_minVol').val(data.result.minVol)
                            $('#edit_maxVol').val(data.result.maxVol)
                            $('#edit_minAmount').val(data.result.minAmount)
                            $('#edit_increment').val(data.result.increment)
                      
                            $('#Updatebillingrate_btn').val('Update');
                            $('#action').val('Edit');
                            $('#editrateBillingModal').modal('show');
                        
                            $('#Updatebillingrate_btn').off('click').on('click', function () {
                                updateBillingRate(id);
                            });
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                        }
                    });
                    }
                    function updateBillingRate(id){
                        var updateBillingrate = {
                            'id': id,
                            'billingrate_name': $('#edit_billingrate_name').val(),
                            'rate_case': $('#edit_rate_case').val(),
                            'classification': $('#edit_classification').val(),
                            'minVol': $('#edit_minVol').val(),
                            'maxVol': $('#edit_maxVol').val(),
                            'minAmount': $('#edit_minAmount').val(),
                            'increment': $('#edit_increment').val(),
                            
                        };

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'post',
                            url: 'bilingrate/update',
                            data: updateBillingrate,
                            dataType: 'json',
                            success: function (response) {
                            $('#billingrate_Table').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Successfully Updated',
                                text: 'This Billing Rate Is Now Updated',
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
                    function billingrateconfirmDelete(id) {
                        
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
                                deleteBillingrate(id);
                            } else {
                                Swal.fire(
                                    'Deletion canceled',
                                    'The billing rate was not deleted.',
                                    'info'
                                )
                            }
                        });
                    }

                    function deleteBillingrate(id) {
                        
                        $.ajax({
                        
                            url: "{{ url('deleteBillingrate/') }}/" + id,
                            type: 'DELETE',
                            
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            
                            success: function(response) {
                                
                                Swal.fire(
                                    'Deleted!',
                                    'The rate has been deleted.',
                                    'success'
                                ).then(() => {

                                    $('#billingrate_Table').DataTable().ajax.reload();
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
                  </script>
                  {{-- end modal --}}
                <div class="table_section padding_infor_info">
                   <div class="table-responsive-sm">
                      <table id="billingrate_Table" class="table table-bordered">
                         <thead>
                            <tr>
                                <th style="flex: 1; white-space: nowrap;">Name</th>
                               <th style="flex: 1; white-space: nowrap;">Case Name</th>
                               <th style="flex: 1; white-space: nowrap;">Class Name</th>
                               <th style="flex: 1; white-space: nowrap;">Min Vol</th>
                               <th style="flex: 1; white-space: nowrap;">Max Vol</th>
                               <th style="flex: 1; white-space: nowrap;">Min Amt</th>
                               <th style="flex: 1; white-space: nowrap;">Increment</th>
                               <th style="flex: 1; white-space: nowrap;">tools</th>
                            </tr>
                         </thead>
                        <script>
                             $(document).ready(function() {
                               const billingrate_Table =  $('#billingrate_Table').DataTable({
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
                                    ajax: "{{ route('addBillingRate.view') }}",
                                    order: [[0, 'desc']],

                                    columns: [
                                        {
                                            data: 'billingrate_name',
                                            name: 'billingrate_name',
                                            render: function(data, type, row, meta) {
                                                if (type === 'display') {
                                                    
                                                    if (meta.row === 0 || data !== billingrate_Table.cell({ row: meta.row - 1, column: meta.col }).data()) {
                                                        return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                                    } else {
                                                        return ''; 
                                                    }
                                                }
                                                return data;
                                            }
                                        },
                                      
                                        {
                                            data: 'rate_case',
                                            name: 'rate_case',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'classification',
                                            name: 'classification',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'minVol',
                                            name: 'minVol',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'maxVol',
                                            name: 'maxVol',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'minAmount',
                                            name: 'minAmount',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'increment',
                                            name: 'increment',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                   
                                        {
                                            data: 'action',
                                            name: 'action',
                                            orderable: false,
                                            searchable: false
                                        }
                                    ]
                                });
                            });

                        </script>
                      </table>
                   </div>
                </div>
             </div>
          </div>
        <!-- penalty rate table section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0" style="display: inline-flex; ">
                        <h2>Penalty Rate</h2>
                        <button class="btn btn-info" style="margin-left: 550px" onclick="penaltyrate()">Add penalty rate</button>
                    </div>

                    {{-- modal for billing rate --}}
                    <div class="modal fade" id="penaltyModal" tabindex="-1" role="dialog" aria-labelledby="penaltyModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="penaltyModalLabel"><i class="fa fa-plus"></i> Add Penalty Rate</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body-billing" style="padding: 15px !important;">
                                <form>
                                    @csrf
                                    
                                    <div class="col-md-12 mb-2">
                                        <label for="input" style="color: black;">Name</label>
                                        <input type="text" class="form-control" name="penalty_name" id="penalty_name" placeholder="Enter Penalty name">
                                    </div>
                                    
                                    <script>
                                        const currentYear = new Date().getFullYear();
                                    
                                    
                                        const penaltyName = `rate${currentYear}`;
                                    
                                    
                                        document.getElementById('penalty_name').value = penaltyName;
                                    </script>
                                    
                                    <label for="input" style="color: black;margin-left:13px">Penalty Rate</label>
                                    <div style="display: inline-flex; ">
                                        <div class="col-md-5 mb-2">
                                        
                                            <input type="number" class="form-control" name="penalty_percent" id="penalty_percent" placeholder="% rate">
                                        </div>
                                        <p style="line-height: 2.5;">% after </p>
                                        <div class="col-md-4 mb-2">
                                        
                                            <input type="number" class="form-control" name="penalty_days" id="penalty_days" placeholder="days">
                                        </div>
                                        <p style="line-height: 2.5;">days</p>
                                    </div>
                                
                                </form>
                            </div>
                        
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="add_penalty_btn" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        </div>
                    </div>
                  
                    <script>
                            function penaltyrate(){
                                $('#penaltyModal').modal('show');
                            }
                            $('#add_penalty_btn').on('click', function(e){
                                var penaltyform = {
                                    'id': $('#hidden_id').val(),
                                    'penalty_name': $('#penalty_name').val(),
                                    'penalty_percent': $('#penalty_percent').val(),
                                    'penalty_days': $('#penalty_days').val(),
                                };
                                    $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $.ajax({
                                    type: 'post',
                                    url: 'add-penaltyRate',
                                    data: penaltyform,
                                    dataType: 'json',
                                    success: function (response) {
                                        $('#penalty_name').val('');
                                        $('#penalty_percent').val('');
                                        $('#penalty_days').val('');
                                    
                                        Swal.fire({
                                            title: 'Successfully Added',
                                            text: 'Successfully Added Penalty Rate',
                                            icon: 'success',
                                        });
                                        $('#penaltyrate_Table').DataTable().ajax.reload();
                                    },
                                    error: function (xhr) {
                                        Swal.fire({
                                            title: 'error',
                                            text: 'An error occurred while adding the penalty rate.',
                                            icon: 'error',
                                        }); 
                                    }
                            });
                        
                        });
                            
                    </script>

                    {{-- modal for editpenalty rate --}}
                    <div class="modal fade" id="editpenaltyModal" tabindex="-1" role="dialog" aria-labelledby="penaltyModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="editpenaltyModalLabel"><i class="fa fa-edit"></i> edit Penalty Rate</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body-editPenalty" style="padding: 15px !important;">
                            <form>
                                @csrf
                                
                                <div class="col-md-12 mb-2">
                                    <label for="input" style="color: black;">Name</label>
                                    <input type="text" class="form-control" name="editpenalty_name" id="editpenalty_name" placeholder="Enter Penalty name">
                                </div>

                                <label for="input" style="color: black;margin-left:13px">Penalty Rate</label>
                                <div style="display: inline-flex; ">
                                    <div class="col-md-5 mb-2">
                                    
                                        <input type="number" class="form-control" name="editpenalty_percent" id="editpenalty_percent" placeholder="% rate">
                                    </div>
                                    <p style="line-height: 2.5;">% after </p>
                                    <div class="col-md-4 mb-2">
                                    
                                        <input type="number" class="form-control" name="editpenalty_days" id="editpenalty_days" placeholder="days">
                                    </div>
                                    <p style="line-height: 2.5;">days</p>
                                </div>
                            
                            </form>
                            </div>
                        
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="UpdatePenaltyrate_btn" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    {{-- for edit --}}
                    <script>
                        function editpenaltyrate(id){
                        
                        
                        $.ajax({
                            url: "/penalty/edit/" + id + "/",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function (data) {
                                $('#editpenalty_name').val(data.result.penalty_name)
                                $('#editpenalty_percent').val(data.result.penalty_percent)
                                $('#editpenalty_days').val(data.result.penalty_days)
                                
                        
                                $('#UpdatePenaltyrate_btn').val('Update');
                                $('#action').val('Edit');
                                $('#editpenaltyModal').modal('show');
                            
                                $('#UpdatePenaltyrate_btn').off('click').on('click', function () {
                                    updatePenaltyRate(id);
                                });
                            },
                            error: function (data) {
                                var errors = data.responseJSON;
                            }
                        });
                        }
                        function updatePenaltyRate(id){
                            var updatePenaltyrate = {
                                'id': id,
                                'penalty_name': $('#editpenalty_name').val(),
                                'penalty_percent': $('#editpenalty_percent').val(),
                                'penalty_days': $('#editpenalty_days').val(),
                        
                                
                            };

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'put',
                                url: 'penaltyrate/update',
                                data: updatePenaltyrate,
                                dataType: 'json',
                                success: function (response) {
                                $('#penaltyrate_Table').DataTable().ajax.reload();
                                Swal.fire({
                                    title: 'Successfully Updated',
                                    text: 'This Penalty Rate Is Now Updated',
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
                        function PenaltyrateconfirmDelete(id) {
                            
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
                                    deletePenaltyrate(id);
                                } else {
                                    Swal.fire(
                                        'Deletion canceled',
                                        'The penalty rate was not deleted.',
                                        'info'
                                    )
                                }
                            });
                        }

                        function deletePenaltyrate(id) {
                            
                            $.ajax({
                            
                                url: "{{ url('deletePenaltyrate/') }}/" + id,
                                type: 'DELETE',
                                
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                
                                success: function(response) {
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'The penalty rate has been deleted.',
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
                    </script>
                </div>

               {{-- boundary line haha --}}
               <div class="table_section padding_infor_info">
                  <div class="table-responsive-sm">
                     <table class="table table-bordered" id="penaltyrate_Table">
                        <thead>
                           <tr>
                                <th style="flex: 1; white-space: nowrap;">Penalty Name</th>
                                <th style="flex: 1; white-space: nowrap;">Penalty %</th>
                                <th style="flex: 1; white-space: nowrap;">Days</th>
                                <th>tools</th>
                           </tr>
                        </thead>
                        <script>
                             $(document).ready(function() {
                                $('#penaltyrate_Table').DataTable({
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
                                    ajax: "{{ route('addPenaltyRate.view') }}",
                                    order: [[0, 'desc']],

                                    columns: [
                                      
                                        {
                                            data: 'penalty_name',
                                            name: 'penalty_name',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'penalty_percent',
                                            name: 'penalty_percent',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        {
                                            data: 'penalty_days',
                                            name: 'penalty_days',
                                            render: function(data) {
                                                return '<div class="text-wrap">' + data + '</div>';
                                            }
                                        },
                                        
                                   
                                        {
                                            data: 'action',
                                            name: 'action',
                                            orderable: false,
                                            searchable: false
                                        }
                                    ]
                                });
                            });
                        </script>
                     </table>
                  </div>
               </div>
            </div>
        </div>

        <!-- discount table section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0" style="display: inline-flex; ">
                        <h2>Discount Rate</h2>
                        <button class="btn btn-info" style="margin-left: 540px" onclick="discountrate()">Add discount rate</button>
                    </div>
                </div>
                
                {{-- modal for billing rate --}}
                <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="discountModalLabel"><i class="fa fa-plus"></i> Add Discount Rate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body-billing" style="padding: 15px !important;">
                        <form>
                            @csrf
                            
                            <div class="col-md-12 mb-2">
                                <label for="input" style="color: black;">Name</label>
                                <input type="text" class="form-control" name="discount_name" id="discount_name" placeholder="Enter Discount name">
                            </div>
                            
                            <script>
                                const currentYear = new Date().getFullYear();
                            
                            
                                const discountName = `rate${currentYear}`;
                            
                            
                                document.getElementById('discount_name').value = discountName;
                            </script>
                            
                            <label for="input" style="color: black;margin-left:13px">Discount Rate</label>
                            <div style="display: inline-flex; ">
                                <div class="col-md-5 mb-2">
                                
                                    <input type="number" class="form-control" name="discount_percent" id="discount_percent" placeholder="% rate">
                                </div>
                                <p style="line-height: 2.5;">% after </p>
                                <div class="col-md-4 mb-2">
                                
                                    <input type="number" class="form-control" name="discount_days" id="discount_days" placeholder="days">
                                </div>
                                <p style="line-height: 2.5;">days</p>
                            </div>
                        
                        </form>
                        </div>
                    
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_discount_btn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    </div>
                </div>

                <script>
                    function discountrate(){
                        $('#discountModal').modal('show');
                            }
                            $('#add_discount_btn').on('click', function(e){
                                var discountform = {
                                    'id': $('#hidden_id').val(),
                                    'discount_name': $('#discount_name').val(),
                                    'discount_percent': $('#discount_percent').val(),
                                    'discount_days': $('#discount_days').val(),
                                };
                                    $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $.ajax({
                                    type: 'post',
                                    url: 'add-discountRate',
                                    data: discountform,
                                    dataType: 'json',
                                    success: function (response) {
                                        $('#discount_name').val('');
                                        $('#discount_percent').val('');
                                        $('#discount_days').val('');
                                    
                                        Swal.fire({
                                            title: 'Successfully Added',
                                            text: 'Successfully Added Discount Rate',
                                            icon: 'success',
                                        });
                                        $('#discountrate_table').DataTable().ajax.reload();
                                    },
                                    error: function (xhr) {
                                        Swal.fire({
                                            title: 'error',
                                            text: 'An error occurred while adding the discount rate.',
                                            icon: 'error',
                                        }); 
                                    }
                            });
                        
                        });
                </script>

                {{-- TABLE --}}
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered" id="discountrate_table">
                            <thead>
                                <tr>
                                    <th style="flex: 1; white-space: nowrap;">Discount name</th>
                                    <th style="flex: 1; white-space: nowrap;">Discount %</th>
                                    <th style="flex: 1; white-space: nowrap;">Days</th>
                                    <th style="flex: 1; white-space: nowrap;">tools</th>
                                </tr>
                            </thead>
                            <script>
                                $(document).ready(function() {
                                    $('#discountrate_table').DataTable({
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
                                        ajax: "{{ route('addDiscountRate.view') }}",
                                        order: [[0, 'desc']],

                                        columns: [
                                        
                                            {
                                                data: 'discount_name',
                                                name: 'discount_name',
                                                render: function(data) {
                                                    return '<div class="text-wrap">' + data + '</div>';
                                                }
                                            },
                                            {
                                                data: 'discount_percent',
                                                name: 'discount_percent',
                                                render: function(data) {
                                                    return '<div class="text-wrap">' + data + '</div>';
                                                }
                                            },
                                            {
                                                data: 'discount_days',
                                                name: 'discount_days',
                                                render: function(data) {
                                                    return '<div class="text-wrap">' + data + '</div>';
                                                }
                                            },
                                            
                                    
                                            {
                                                data: 'action',
                                                name: 'action',
                                                orderable: false,
                                                searchable: false
                                            }
                                        ]
                                    });
                                });

                            </script>
                        </table>
                    </div>
                </div>
            </div>
        </div>
               {{-- modal for editdiscountyrate --}}
               <div class="modal fade" id="editdiscountModal" tabindex="-1" role="dialog" aria-labelledby="penaltyModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editdiscountModalLabel"><i class="fa fa-edit"></i> edit Discount Rate</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body-editDiscount" style="padding: 15px !important;">
                      <form>
                        @csrf
                        
                        <div class="col-md-12 mb-2">
                            <label for="input" style="color: black;">Name</label>
                            <input type="text" class="form-control" name="editdiscount_name" id="editdiscount_name" placeholder="Enter Penalty name">
                        </div>

                        <label for="input" style="color: black;margin-left:13px">Penalty Rate</label>
                        <div style="display: inline-flex; ">
                            <div class="col-md-5 mb-2">
                             
                                <input type="number" class="form-control" name="editdiscount_percent" id="editdiscount_percent" placeholder="% rate">
                            </div>
                            <p style="line-height: 2.5;">% after </p>
                            <div class="col-md-4 mb-2">
                               
                                <input type="number" class="form-control" name="editdiscount_days" id="editdiscount_days" placeholder="days">
                            </div>
                            <p style="line-height: 2.5;">days</p>
                        </div>
                      
                    </form>
                    </div>
                   
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" id="UpdateDiscountrate_btn" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
               </div>

                {{-- for edit --}}
                <script>
                    function editdiscountrate(id){
                    
                    
                    $.ajax({
                        url: "/discount/edit/" + id + "/",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            $('#editdiscount_name').val(data.result.discount_name)
                            $('#editdiscount_percent').val(data.result.discount_percent)
                            $('#editdiscount_days').val(data.result.discount_days)
                            
                    
                            $('#UpdateDiscountrate_btn').val('Update');
                            $('#action').val('Edit');
                            $('#editdiscountModal').modal('show');
                        
                            $('#UpdateDiscountrate_btn').off('click').on('click', function () {
                                updateDiscountRate(id);
                            });
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                        }
                    });
                    }
                    function updateDiscountRate(id){
                        var updateDiscountrate = {
                            'id': id,
                            'discount_name': $('#editdiscount_name').val(),
                            'discount_percent': $('#editdiscount_percent').val(),
                            'discount_days': $('#editdiscount_days').val(),
                    
                            
                        };

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'put',
                            url: 'discountrate/update',
                            data: updateDiscountrate,
                            dataType: 'json',
                            success: function (response) {
                            $('#discountrate_table').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Successfully Updated',
                                text: 'This Discount Rate Is Now Updated',
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
                    function DiscountrateconfirmDelete(id) {
                            
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
                                    deleteDiscountrate(id);
                                } else {
                                    Swal.fire(
                                        'Deletion canceled',
                                        'The discount rate was not deleted.',
                                        'info'
                                    )
                                }
                            });
                        }

                        function deleteDiscountrate(id) {
                            
                            $.ajax({
                            
                                url: "{{ url('deleteDiscountrate/') }}/" + id,
                                type: 'DELETE',
                                
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                
                                success: function(response) {
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'The discount rate has been deleted.',
                                        'success'
                                    ).then(() => {

                                        $('#discountrate_table').DataTable().ajax.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the discount rate.',
                                        'error'
                                    );
                                }
                            });
                        }
                </script>
         <!-- trustfund table section -->
         {{-- <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
               <div class="full graph_head">
                  <div class="heading1 margin_0">
                     <h2>Trustfund Rate</h2>
                  </div>
               </div>
               <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                   <table class="table table-bordered">
                      <thead>
                         <tr>
                            <th>Case Name</th>
                            <th>Class Name</th>
                            <th>Min Vol</th>
                            <th>Max Vol</th>
                            <th>Min Amt</th>
                            <th>Increment</th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td>Naawan</td>
                            <td>Residential</td>
                            <td>0</td>
                            <td>5</td>
                            <td>90.65</td>
                            <td>0.00</td>
                         </tr>
                         <tr>
                             <td>Naawan</td>
                             <td>Residential</td>
                             <td>6</td>
                             <td>10000</td>
                             <td>108.55</td>
                             <td>17.90</td>
                         </tr>
                         <tr>
                             <td>Naawan</td>
                             <td>Commercial</td>
                             <td>0</td>
                             <td>10000</td>
                             <td>0.00</td>
                             <td>36.25</td>
                         </tr>
                         <tr>
                             <td>Naawan</td>
                             <td>Industrial</td>
                             <td>0</td>
                             <td>5</td>
                             <td>90.65</td>
                             <td>0.00</td>
                         </tr>
                         <tr>
                             <td>Naawan</td>
                             <td>Government</td>
                             <td>0</td>
                             <td>5</td>
                             <td>90.65</td>
                             <td>17.90</td>
                         </tr>
                         <tr>
                             <td>Manticao</td>
                             <td>Residential</td>
                             <td>0</td>
                             <td>10000</td>
                             <td>0.00</td>
                             <td>20.09</td>
                         </tr>
                         <tr>
                             <td>Manticao</td>
                             <td>Commercial</td>
                             <td>0</td>
                             <td>10000</td>
                             <td>0.00</td>
                             <td>40.00</td>
                         </tr>
                      </tbody>
                   </table>
                </div>
             </div>
            </div>
         </div> --}}
         {{-- holiday --}}

         <!-- Nonworking holiday table section -->
         <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0" style="display: inline-flex">
                        <h2><i class="fa fa-calendar"></i> Non-working holidays</h2>
                        <button class="btn btn-info" style="margin-left:470px;" onclick="holiday()">Add Holiday</button>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered" id="holiday_table">
                            <thead>
                                <tr>
                                    <th>Date of Holiday</th>
                                    <th>Holiday Name</th>
                                    <th>tools</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
         </div>
       </div>
    </div>
    <div class="modal fade" id="holiday_Modal" tabindex="-1" role="dialog" aria-labelledby="holiday_ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="holiday_ModalLabel"><i class="fa fa-plus"></i> Add No-working days</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body-holiday" style="padding: 15px !important;">
              <form>
                @csrf
                <div class="col-md-12 mb-2">
                    <label for="input" style="color: black;"></i>Holiday Date</label>
                    <input type="date" class="form-control" name="holiday_date" id="holiday_date" placeholder="Enter date">
                </div>
                
                <div class="col-md-12 mb-2">
                    <label for="input" style="color: black;"></i>Holiday name</label>
                    <input type="text" class="form-control" name="holiday_name" id="holiday_name" placeholder="Enter name">
                </div>
                
            </form>
            </div>
           
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="add_holiday_btn" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
    </div>
    
    {{-- modal for  add holiday --}}
    <div class="modal fade" id="editHolidayModal" tabindex="-1" role="dialog" aria-labelledby="editHolidayModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editHolidayModalLabel"><i class="fa fa-edit"></i> Edit No-working days</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body-editholiday" style="padding: 15px !important;">
              <form>
                @csrf
                <div class="col-md-12 mb-2">
                    <label for="input" style="color: black;"></i>Holiday Date</label>
                    <input type="date" class="form-control" name="editholiday_date" id="editholiday_date" placeholder="Enter date">
                </div>
                
                <div class="col-md-12 mb-2">
                    <label for="input" style="color: black;"></i>Holiday name</label>
                    <input type="text" class="form-control" name="editholiday_name" id="editholiday_name" placeholder="Enter name">
                </div>
                
            </form>
            </div>
           
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="Updateholiday_btn" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
    </div>

        <script>
            $(document).ready(function() {
            $('#holiday_table').DataTable({
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
                ajax: "{{ route('holiday.view') }}",
                order: [[1, 'asc']],

                columns: [
                    
                    {
                        data: 'holiday_name',
                        name: 'holiday_name',
                        render: function(data) {
                            return '<div class="text-wrap">' + data + '</div>';
                        }
                    },
                    {
                        data: 'holiday_date',
                        name: 'holiday_date',
                        render: function(data) {
                            
                            var date = new Date(data);
                            var options = { year: 'numeric', month: 'long', day: 'numeric' };
                            return '<div class="text-wrap">' + date.toLocaleDateString('en-US', options) + '</div>';
                        }
                    },
                    
                    
                
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            });

                function holiday(){
                    $('#holiday_Modal').modal('show');
                }
                $('#add_holiday_btn').on('click', function(e){
                        var holidayform = {
                            'id': $('#hidden_id').val(),
                            'holiday_name': $('#holiday_name').val(),
                            'holiday_date': $('#holiday_date').val(),
                            
                        };
                            $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'post',
                            url: 'add-holiday',
                            data: holidayform,
                            dataType: 'json',
                            success: function (response) {
                                $('#holiday_name').val('');
                                $('#holiday_date').val('');
                                
                                
                                Swal.fire({
                                    title: 'Successfully Added',
                                    text: 'Successfully Added Holiday',
                                    icon: 'success',
                                });
                                $('#holiday_table').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'error',
                                    text: 'An error occurred while adding the holiday.',
                                    icon: 'error',
                                }); 
                            }
                    });
                
                });
                function editHoliday(id){
                    
                    
                    $.ajax({
                        url: "/holiday/edit/" + id + "/",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            $('#editholiday_name').val(data.result.holiday_name)
                            $('#editholiday_date').val(data.result.holiday_date)
                            $('#Updateholiday_btn').val('Update');
                            $('#action').val('Edit');
                            $('#editHolidayModal').modal('show');
                        
                            $('#Updateholiday_btn').off('click').on('click', function () {
                                updateHoliday(id);
                            });
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                        }
                    });
                    }
                    function updateHoliday(id){
                        var updateHoliday = {
                            'id': id,
                            'holiday_name': $('#editholiday_name').val(),
                            'holiday_date': $('#editholiday_date').val()
                            
                        };
    
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
    
                        $.ajax({
                            type: 'put',
                            url: 'holiday/update',
                            data: updateHoliday,
                            dataType: 'json',
                            success: function (response) {
                            $('#holiday_table').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Successfully Updated',
                                text: 'This Non-working days is now Updated',
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
                    function holidayDelete(id) {
                            
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
                                    deleteHoliday(id);
                                } else {
                                    Swal.fire(
                                        'Deletion canceled',
                                        'The non-workings was not deleted.',
                                        'info'
                                    )
                                }
                            });
                        }

                        function deleteHoliday(id) {
                            
                            $.ajax({
                            
                                url: "{{ url('deleteHoliday/') }}/" + id,
                                type: 'DELETE',
                                
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                
                                success: function(response) {
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'The non-working days has been deleted.',
                                        'success'
                                    ).then(() => {

                                        $('#holiday_table').DataTable().ajax.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the non-working days.',
                                        'error'
                                    );
                                }
                            });
                        }
        </script>

    <!-- footer -->
    <div class="container-fluid">
       <div class="footer">
          <p>Copyright ©2023 Project by MEEDO Naawan Water System. All rights reserved.</p>
       </div>
    </div>
 </div>
@endsection

