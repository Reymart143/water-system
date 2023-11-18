@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">Official Receipt of the Treasurer</h2>
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
                            <div style="display: flex;">
                                
                                <div class="filter-container" style="margin-top:-20px;margin-bottom:10px;width:200px;margin-left:10px">
                                    <label for="cluster-filter" style="color:rgb(7, 6, 6)">Select Cluster:</label>
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
                            <table id="receipt_treasurer" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Account ID</th>
                                        <th>Name</th>
                                        <th>Rate Case</th>
                                        <th>Classification</th>
                                        <th>Cluster</th>
                                        <th class="action">Tools</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
            <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
           <script>
                $(document).ready(function(){
                    let selectedCluster = '';
           
                    const storedCluster = localStorage.getItem('selectedCluster');
                    

                    if (storedCluster) {
                        selectedCluster = storedCluster;
                        $('#cluster-filter').val(selectedCluster);
                    }
                    var StatementdataTable = $('#receipt_treasurer').DataTable({
                        
                        "processing": true,
                        "language": {
                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                        },
                        serverSide:true,
                        ajax: "/collection.treasurer-receipt",
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
                            data : 'rate_case',
                            name : 'rate_case'
                        },
                        {
                            data : 'classification',
                            name : 'classification'
                        },
                        {
                            data : 'cluster',
                            name : 'cluster'
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
                        initComplete: function () 
                            {
                            this.api().column(4).search(selectedCluster).draw();
                        }
                    });
                    $('#cluster-filter').on('change', function () {
                        
                        var selectedCluster = $(this).val();
                        StatementdataTable.column('4').search(selectedCluster).draw();
                        localStorage.setItem('selectedCluster', selectedCluster);
                    });
                });
            </script>   
         
    </div> 
     
    
@endsection