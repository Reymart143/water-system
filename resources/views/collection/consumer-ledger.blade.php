@extends('layouts.dash')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chosen-js@1.8.7/chosen.min.css">
<script src="https://cdn.jsdelivr.net/npm/chosen-js@1.8.7/chosen.jquery.min.js"></script>

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">Water Consumer ledger</h2>
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
                            <table id="consumerledger_table" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Consumer Name</th>
                                        <th>Cluster</th>
                                        <th>Rate case</th>
                                        {{-- <th>OR NO.</th> --}}
                                        <th class="action" style="text-align: center;width:30px;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MODAL CONTENT --}}
          <script>
            // $(document).ready(function() {
                
            //     $('#cluster-filter').chosen({
            //         search_contains: true,
            //         allow_single_deselect: true
            //     });
            // });
                 $(document).ready(function(){
                    var LedgerdataTable = $('#consumerledger_table').DataTable({
                        "processing": true,
                        "language": {
                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                        },
                        serverSide: true,
                        ajax: "/consumer-ledger",
                        columns: [
                          
                            
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
                        LedgerdataTable.column('1').search(selectedCluster).draw();
                    });  
                }); 
          </script>
        </div>        
    </div>
@endsection