@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">Notice of Disconnection</h2>
                              
                               
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="row column1">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                        {{-- TABLE --}}
            
                            <div class="card text-center" style="margin-top: 30px">
                                <div class="card-header">
                                    <h5 class="card-title">Fill up the fields below</h5>
                                </div>
                                <div class="card-body">
                                
                                    <div class="col-md-4 " style="margin-left:300px">
                                        <label for="date-input">As of:</label>
                                        <input type="date" name="asof_date" class="form-control" id="asof_date">
                                    </div>
                                    <div class="col-md-6" style="margin-left:300px">
                                        <label for="cluster_selected" style="color: rgb(9, 9, 9);margin-right:150px">Cluster:</label>
                                        <select id="cluster_selected" name="cluster_selected" class="form-control" style="width: 64%">
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
                                    <div class="col-md-6" style="margin-left:300px">
                                        <label for="customer_selected" style="color: rgb(0, 0, 0);margin-right:150px">Customer:</label>
                                        <select id="customer_selected" name="customer_selected" class="form-control" style="width: 64%">
                                            <option value="">All</option>
                                            @php
                                            $customers = DB::table('consumer_infos')->select('customerName', 'cluster')->get();
                                            @endphp
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->customerName }}" data-cluster="{{ $customer->cluster }}">{{ $customer->customerName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                        <script>
                                            $(document).ready(function () {
                                            $('#cluster_selected').on('change', function () {
                                                var selectedCluster = $(this).val();
                                                $('#customer_selected option').show();
                                                if (selectedCluster) { 
                                                    $('#customer_selected option[data-cluster]').each(function () {
                                                        var customerCluster = $(this).data('cluster');
                                                        if (customerCluster !== selectedCluster) {
                                                            $(this).hide();
                                                        }
                                                    });
                                                }
                                            });
                                        });
                                        </script>                                    
                            
                                    <button class="btn btn-success mt-4" style="width: 50%" id="disconnection_btn">Show</button>
                            
                                </div>
                            </div>
                    </div>
                </div>
                {{-- script for show  --}}
                <script>
                    $('#disconnection_btn').on('click', function() {
                        var asof_date = $('#asof_date').val();
                        var selectedCluster = $('#cluster_selected').val();
                        var selectedCustomer = $('#customer_selected').val();
                
                        if (!asof_date || !selectedCluster) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error in Showing Notice of Disconnection',
                                text: 'Please fill out the form completely!',
                            });
                        } else {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: '/billing.disconnection-list',
                                data: {
                                    asof_date: asof_date,
                                    cluster_selected: selectedCluster,
                                    customer_selected: selectedCustomer
                                },
                                success: function(response) {
                                    console.log(response);
                
                                    if (response.status === 400) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'No customer found',
                                            text: response.message,
                                        });
                                    } else if (response.status === 500) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'No notice found',
                                            text: response.message,
                                        });
                                    }else {
                                        window.location.href = '/billing.disconnection-list?asof_date=' + encodeURIComponent(asof_date)
                                            + '&cluster_selected=' + encodeURIComponent(selectedCluster)
                                            + '&customer_selected=' + encodeURIComponent(selectedCustomer);
                                    }
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        }
                    });
                </script>
                
                
                
            
            
            
          
      
   
@endsection