@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column1">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="card-body mt-4">
                        <div class="card-header mb-4" style="background-color: #fff;width: 100%;margin-top:-20px; display: inline-flex; ">
                            <h5 style="flex: 1;white-space: nowrap;"><i class="fa fa-book green_color" style="margin-top:0px;"></i> Reading</h5> 
                        </div>
                        <div class="filter-container" style="margin-left: -5px !important;margin-bottom:50px !important;">
                            <div class="filter-controls col-md-6" style="float: left;display: inline-flex;flex: 1; white-space: nowrap;">
                                <label for="filterMonthYear" style="color:black;margin-top:5px;margin-right:3px;">Select Month and Year: </label>
                                <input type="month" id="filterMonthYear" name="filterMonthYear" class="form-control col-md-4">
                            </div>
                            <div class="col-md-4" style="display:inline-flex;float:right;margin-right:-5px;">
                                <label for="cluster-filter" style="color:black; flex: 1; white-space: nowrap;margin-top:5px;margin-right:3px;">Filter Cluster:</label>
                                <select id="cluster-filter" id="cluster" name="cluster" class="form-control">
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
                        <table class="display table table-bordered" id="reading_table" style="color: black !important; width: 100% !important;font-size:3mm;">
                            <thead style="background: #009688 !important;">
                                <tr>
                                    <th class="header-table" style="flex: 1; white-space: nowrap;">Connection Name</th>
                                    <th class="header-table" style="flex: 1; white-space: nowrap;">Reading</th>
                                    <th class="header-table" style="flex: 1; white-space: nowrap;">Date Reading</th>
                                    <th class="header-table" style="flex: 1; white-space: nowrap;">Date Delivery</th>
                                    <th class="header-table" style="flex: 1; white-space: nowrap;">Reader</th>
                                    <th class="header-table">Vol</th>
                                    <th class="header-table" style="flex: 1; white-space: nowrap;">Amount</th>
                                    @if(Auth::user()->role == 3 || Auth::user()->role == 1 || Auth::user()->role == 0)
                                            <th class="header-table">Tools</th> 
                                        
                                        @else
                                            <th class="header-table">Status</th> 
                                        @endif
                                    <th style="display: none;">Cluster</th>
                                </tr>
                            </thead>
                    
                        </table>
                    </div>
                </div>
            </div>
            {{-- modal --}}
            <div class="modal fade" id="editreadingModal" tabindex="-1" role="dialog" aria-labelledby="editreadingModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editreadingModalLabel"></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="rate_case" id="rate_case">
                                <input type="hidden" name="classification" id="classification">
                                <div class="col-md-6 mb-3 mx-auto">
                                    <label for="customerName" style="color: black;"><i class="fa fa-user"></i> Customer Name</label>
                                    <input type="text" name="customerName" id="customerName" readonly class="form-control">
                                </div>
                                <div class="col-md-6 mb-3 mx-auto">
                                    <label for="account_id" style="color: black;"><i class="fa fa-id"></i> Account ID</label>
                                    <input type="text" name="account_id" id="account_id" readonly class="form-control">
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-md-6 mb-3 mx-auto">
                                    <label for="from_reading_date" style="color: black;"><i class="fa fa-calendar"></i> Reading Date From</label>
                                    <input id="from_reading_date" type="date" class="form-control" name="from_reading_date">
                                </div>
                                <div class="col-md-6 mb-3 mx-auto">
                                    <label for="to_reading_date" style="color: black;"><i class="fa fa-calendar"></i> Date delivery</label>
                                    <input id="date_delivered" type="date" class="form-control" name="date_delivered">
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-md-6 mb-3 mx-auto">
                                    <label for="previous_reading" style="color: black;"><i class="fa fa-tachometer"></i> Previous Reading</label>
                                    <input type="number" id="previous_reading" name="previous_reading" class="form-control" readonly>
                                </div>
                                <div class="col-md-6 mb-4 mx-auto">
                                    <label for="current_reading" style="color: black;"><i class="fa fa-tachometer"></i> Current Reading</label>
                                    <input type="number" id="current_reading" name="current_reading" class="form-control" placeholder="Enter the current reading">
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="main_bt" id="updatereading_btn" style="padding: 7px 10px !important;font-size: 14px !important;min-width: 0;">Save</button>
                    </div>
                  </div>
                </div>
            </div>
            <script>
                function editReading(id){
                    
                    $('#updatereading_btn').text('Update Info');
                        
                    
                        $.ajax({
                            url: "/edit/reading/" + id + "/",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function (data) {
                                $('#rate_case').val(data.result.rate_case)
                                $('#classification').val(data.result.classification)
                                $('#customerName').val(data.result.customerName)
                                $('#account_id').val(data.result.account_id)
                                $('#from_reading_date').val(data.result.from_reading_date)
                                $('#date_delivered').val(data.result.date_delivered)
                                $('#previous_reading').val(data.result.previous_reading)
                                $('#current_reading').val(data.result.current_reading)
                                $('#editreadingModalLabel').html('<i class="fa fa-edit"?></i> Edit Reading');
                                $('#updatereading_btn').val('Update');
                                $('#action').val('Edit');
                                $('#editreadingModal').modal('show');
                            
                                $('#updatereading_btn').off('click').on('click', function () {
                                    updateReading(id);
                                });
                            },
                            error: function (data) {
                                var errors = data.responseJSON;
                            }
                        });
                }
                //update reading
                function updateReading(id) {
            
                            var Readingform = {
                                'id': id,
                                'account_id': $('#account_id').val(),
                                'rate_case': $('#rate_case').val(),
                                'classification': $('#classification').val(),
                                'from_reading_date': $('#from_reading_date').val(),
                                'date_delivered': $('#date_delivered').val(),
                                'previous_reading': $('#previous_reading').val(),
                                'current_reading': $('#current_reading').val(),
                                
                            };

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'post',
                                url: 'reading/update',
                                data: Readingform,
                                dataType: 'json',
                                success: function (response) {
                                    
                                $('#reading_table').DataTable().ajax.reload();
                                Swal.fire({
                                    title: 'Successfully Updated',
                                    text: 'This Reading is Now Updated',
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
                        function confirmDeleteReading(id) {
                            
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
                                    deleteReading(id);
                                } else {
                                    Swal.fire(
                                        'Deletion canceled',
                                        'The reading was not deleted.',
                                        'info'
                                    )
                                }
                            });
                        }

                        function deleteReading(id) {
                            
                            $.ajax({
                            
                                url: "{{ url('deleteReading/') }}/" + id,
                                type: 'DELETE',
                                
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                
                                success: function(response) {
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'The Reading has been deleted.',
                                        'success'
                                    ).then(() => {

                                        $('#reading_table').DataTable().ajax.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the reading.',
                                        'error'
                                    );
                                }
                            });
                        }
            </script>
        </div>
    </div>        
</div>
<script>
    $(document).ready(function() {

                $('#reading_table').DataTable({
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
                    ajax: "{{ route('reading_table.view') }}",
                    "order": [[1, "desc"]],
                    columns: [
                       
                        {
                            data: 'customerName',
                            name: 'customerName',
                            render: function(data) {
                                return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                            }
                        },
                        {
                            data: 'current_reading',
                            name: 'current_reading',
                            render: function(data) {
                                if (data === null) {
                                    return '<div style="flex: 1; white-space: nowrap;">No reading</div>';
                                } else {
                                    return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                }
                            }
                        },

                        {
                                data: 'from_reading_date',
                                name: 'from_reading_date',
                                render: function(data) {
                                    if (data) {
                                        var date = new Date(data);
                                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                                        return '<div style="flex: 1; white-space: nowrap;">' + date.toLocaleDateString(undefined, options) + '</div>';
                                    } else {
                                        return 'no date selected'; 
                                    }
                                }
                            },
                            {
                                data: 'date_delivered',
                                name: 'date_delivered',
                                render: function(data) {
                                    if (data) {
                                        var date = new Date(data);
                                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                                        return '<div style="flex: 1; white-space: nowrap;">' + date.toLocaleDateString(undefined, options) + '</div>';
                                    } else {
                                        return 'no date selected'; 
                                    }
                                }
                            },

                        {
                            data: 'Reader',
                            name: 'Reader',
                            render: function(data) {
                                return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                            }
                        },
                        {
                            data: 'volume',
                            name: 'volume',
                            render: function(data) {
                                return '<div class="text-wrap">' + data + '</div>';
                            }
                        },
                           {
                            data: 'amount_bill',
                            name: 'amount_bill',
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
                                    var userRole = "{{ Auth::user()->role }}"; // Get user role from Blade
                                    if (userRole == 3) {
                                        return '<div style="white-space: nowrap;">' + data + '</div>';
                                    }else if(userRole == 1 || userRole == 0){
                                        var currentReading = row.current_reading;
                                        var badgeHtml = currentReading !== null
                                            ? '<i class="fa fa-check-circle" style="color:green"></i>'
                                            : '<i class="fa fa-exclamation-triangle" style="color:red"></i>';
                                   
                                        return '<div style="white-space: nowrap;">' + badgeHtml  + data + '</div>';
                                    }
                                     else {
                                        // If the user role is not 3, return a status badge
                                        var currentReading = row.current_reading;
                                        var badgeHtml = currentReading !== null
                                            ? '<span class="badge badge-success"><i class="fa fa-check"></i></span>'
                                            : '<span class="badge badge-danger"><i class="fa fa-close"></i></span>';
                                        return '<div style="white-space: nowrap;">' + badgeHtml + '</div>';
                                    }
                                }
                            },
                        {
                            data: 'cluster',
                            name: 'cluster',
                            render: function(data) {
                                return '<div style="display :none">' + data + '</div>';
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 8, 
                            visible: false
                        }
                    ],
                   
                "initComplete": function () {
                    $('#filterMonthYear').val('{{date('Y-m')}}');
                    $('#filterMonthYear').trigger('change');
                }
                });
                $('#cluster-filter').on('change', function () {
                    const selectedCluster = $(this).val();
                    const readingTable = $('#reading_table').DataTable();
                    readingTable.column(8).search(selectedCluster).draw();
                
                //     if (selectedCluster === '') {
                //     $('#Reader').val('');
                //     localStorage.removeItem('selectedReader');
                // }
                });
            
                            $('#filterMonthYear').on('change', function () {
                    const selectedMonthYear = $(this).val();
                    const readingTable = $('#reading_table').DataTable();
                    readingTable.column(2).search(selectedMonthYear).draw();
          
        
                    
                });
            });
</script>
@endsection