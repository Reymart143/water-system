@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">Customer Miscellaneous</h2>
                                <div class="filter-container" style="margin-top:20px;margin-bottom:10px;width:200px">
                                    <label for="cluster-filter" style="color:rgb(252, 252, 252)">Select Cluster:</label>
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
            <div class="row column1">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                        {{-- TABLE --}}
                        <div class="card-body mt-4" style="padding: 20px;" style="width: 100% !important;">
                            <table id="miscellaneousList_table" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Account No</th>
                                        <th>Consumer Name</th>
                                        <th>Cluster</th>
                                        <th>Rate case</th>
                                        <th>Status</th>
                                        <th class="action" style="text-align: center;width:30px;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MODAL CONTENT --}}
            <div class="modal fade" id="modalItemMiscell" tabindex="-1" role="dialog" aria-labelledby="modalItemMiscellLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title" id="modalItemMiscellLabel"></h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        {{-- <input type="text" name="account_id" id="account_id" value="{{}}">
                        <input type="text" name="customerName" id="customerName" value="{{}}"> --}}
                        <button class="btn btn-success mt-2 mb-2" id="showHideTableButton">Show List of Miscellaneous</button>
                         

                        <div id="tableContainer" style="display: none;">
                           
                        <table id="listOfItems_table" class="display table table-bordered" >
                            <thead>
                            <tr>
                                <th style="">Select</th>
                                <th>Miscellaneous name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $listMiscellItem = DB::table('miscellaneous_items')
                                ->select('id','miscellaneous_name','amount')
                                ->get();
                            @endphp
                          
                                @foreach ($listMiscellItem as $l)
                                <tr>
                                <td style="width: 20px">
                                    <input type="checkbox" style="width: 25px;height:25px;padding-left:2mm;padding-right:2mm;text-align:center" class="form-control" id="selected_items[]" name="selected_items[]" value="{{$l->id}}">
                                </td>
                                <td ><input type="text" class="form-control" id="item_name" name="item_name" value="{{$l->miscellaneous_name}}" readonly></td>
                                <td ><input type="text" class="form-control" id="item_name" name="item_name" value="{{$l->amount}}" readonly></td>
                            </tr>
                                @endforeach
                             
                        </tbody> 
                        
                      </table>
                      <button class="btn btn-primary mb-2" style="width: 120px;margin-left:10px" id="addItemToConsumer_btn"><i class="fa fa-plus"></i> Add Now</button>
                        </div>
                        <script>
                            var dataTableInitialized = false; 
                        
                            $(document).ready(function () {
                                $('#showHideTableButton').click(function () {
                                    var $tableContainer = $('#tableContainer');
                                    var $tableButton = $('#showHideTableButton');
                        
                                    if ($tableContainer.is(':visible')) {
                                        $tableContainer.hide();
                                        $tableButton.text('Show List of Miscellaneous');
                                    } else {
                                        $tableContainer.show();
                                        $tableButton.text('Hide List of Miscellaneous');
                        
                                        if (!dataTableInitialized) {
                                            $('#listOfItems_table').DataTable({
                                                "paging": true,
                                                "pageLength": 5,
                                                "lengthMenu": [5, 10, 25, 50, 100],
                                                "order": [[1, 'asc']],
                                                "searching": false, 
                                            });
                                            dataTableInitialized = true;
                                        }
                                    }
                                });
                            });
                            $('#addItemToConsumer_btn').on('click', function (e) {
                                var selectedItems = [];
                                var account_id = $(this).data('account-id');
                                var customerName = $(this).data('customer-name');

                                $('input[name="selected_items[]"]:checked').each(function () {
                                    selectedItems.push($(this).val());
                                });

                                if (selectedItems.length > 0) {
                                    var customerData = {
                                        account_id: account_id,
                                        customerName: customerName,
                                        selected_items: selectedItems
                                    };

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type: 'post',
                                        url: 'customer-item',
                                        data: customerData,
                                        dataType: 'json',
                                        success: function (response) {
                                            if (response.status === 200) {
                                                Swal.fire({
                                                    title: 'Successfully Added',
                                                    text: 'Check it now in the table below',
                                                    icon: 'success'
                                                }).then(() => {
                                              
                                              setTimeout(function() {
                                                  document.getElementById("listAddedItems").scrollIntoView({ behavior: 'smooth' });
                                              }, 500); 
                                          });

                                                
                                                $('input[name="selected_items[]"]:checked').prop('checked', false);
                                               
                                                
                                                $('#listAddedItems').DataTable().ajax.reload();
                                            } else if (response.status === 400) {
                                                Swal.fire({
                                                    title: 'Error',
                                                    text: response.message,
                                                    icon: 'error'
                                                });
                                                $('input[name="selected_items[]"]:checked').prop('checked', false);
                                            }
                                        },
                                        error: function (response) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'Cannot proceed, there is something wrong',
                                                icon: 'error'
                                            });
                                            
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Please select at least one item to save.',
                                        icon: 'error'
                                    });
                                }
                            });

                    </script>
                    <hr>
                      <table class="display table table-bordered" id="listAddedItems">
                        <thead>
                            <tr>
                                <th>Miscellaneous Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                       <script>
                            
                       </script>
                          
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   
                    </div>
                  </div>
                </div>
              </div>
          <script>
           
            var CustomerItemdataTable;

           
            function initializeDataTable(account_id) {
             
                if ($.fn.DataTable.isDataTable('#listAddedItems')) {
                    CustomerItemdataTable.destroy();
                }

                CustomerItemdataTable = $('#listAddedItems').DataTable({
                    "processing": true,
                    "language": {
                        processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                    },
                    serverSide: true,
                    order: [
                        [0, 'desc'],
                    ],
                    ajax: {
                        url: "/list-addeditems/" + account_id,
                        type: "GET",
                    },
                    columns: [
                        {
                            data: 'miscellaneous_name',
                            name: 'miscellaneous_name'
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data) {                   
                                    return '<span class="connected-status"><i class="fa fa-check-circle"></i>  Paid</span>';
                            }
                        },
                    ],
                });
            }

           
            $(document).ready(function() {
                initializeDataTable(account_id);
            });

         
            function addItem(button) {
                var account_id = $(button).data('account-id');
                var customerName = $(button).closest('tr').find('input[type="hidden"]').val();
                
                $('#addItemToConsumer_btn').data('account-id', account_id);
                $('#addItemToConsumer_btn').data('customer-name', customerName);
              
                $('#modalItemMiscellLabel').text(customerName);
                $('#modalItemMiscell').modal('show');
                
                initializeDataTable(account_id);
            }


                 $(document).ready(function(){
                    var ItemdataTable = $('#miscellaneousList_table').DataTable({
                        "processing": true,
                        "language": {
                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                        },
                        serverSide: true,
                        order: [
                          [4, 'desc'], 
                        ],
                        ajax: "/billing.miscellaneous_list",
                        columns: [
                            {
                                data : 'account_id',
                                name : 'account_id'
                            },
                            
                            {
                                data : 'customerName',
                                name : 'customerName'
                            },
                            
                           
                            {
                                data : 'cluster',
                                name : 'cluster'
                            }, 
                            {
                                data : 'rate_case',
                                name : 'rate_case'
                            },
                            {
                                data : 'status',
                                name : 'status',
                                render: function(data) {
                                    if (data == 0) {
                                        return '<span class="connected-status">Connected</span>';
                                    } else if (data == 1) {
                                        return '<span class="reconnected-status">Reconnected</span>';
                                    } else if (data == 2) {
                                        return '<span class="disconnected-status">Disconnected</span>';
                                    } else {
                                        return '<span class="unknown-status">Unknown</span>';
                                    }
                                }
                            },
                            // {
                            //     data : 'or_number',
                            //     name : 'or_number',
                            //     render: function(data) {
                            //         return '<div style="display:none">' + data + '</div>';
                            //     }
                            // }
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                render: function(data) {
                                    return '<div class="action-buttons">' + data + '</div>';
                                }
                            },
                           
                        ],
                       
                    
                    });

     
                    $('#cluster-filter').on('change', function () {
                        var selectedCluster = $(this).val();
                        ItemdataTable.column('2').search(selectedCluster).draw();
                    });  
                }); 
          </script>
        </div>        
    </div>
@endsection