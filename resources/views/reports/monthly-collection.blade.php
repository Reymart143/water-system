@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
                <div class="row column1">
                    <div class="col-md-2"></div>
                        <div class="col-md-12 mt-4">
                            <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                                <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                    <h3 class="mt-1" style="color: white !important;">Monthly Collection Summary</h3>
                                
                                    
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                    <div class="row column1">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: -55px;">
                                {{-- TABLE --}}
                                <div class="card-body mt-4" style="padding: 10px;" style="width: 100% !important;">
                                        <div class="filter-container" style="display: flex; justify-content: space-between;">
                                            <div class="filter-controls" style="display: flex; align-items: center;">
                                                <label for="filterMonthYear" style="color: rgb(6, 5, 5); margin-right: 10px;">Select Month and Year:</label>
                                                <input type="month" id="filterMonthYear" name="filterMonthYear" style="width: 160px;" class="form-control">
                                            
                                            </div>
                                            <div>
                                                <label for="ratecase-filter" style="color: rgb(0, 0, 0);">Select Rate Case you want to print:</label>
                                                <select id="ratecase-filter" class="form-control" style="width: 70%;">
                                                    <option value="">All</option>
                                                    @php
                                                    $categories = DB::table('libraries')->get();
                                                    @endphp
                                                    @foreach ($categories as $category)
                                                        @if ($category->category === 'Rate Case')
                                                            <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>
                                    
                                        
                                            <table class="display table table-bordered mt-1" id="monthly_summary_table" style="color: black !important; width: 100% !important;">
                                                <thead style="background: #009688 !important;">
                                                    <tr>
                                                        {{-- <th class="header-table" style="display:none">Month || Year</th> --}}
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Rate Case</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Cluster</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Water Rental</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Surcharge</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Discount</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Miscellaneous</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">watershed</th>
                                                        <th class="header-table" style="flex: 1; white-space: nowrap;">Total</th>
                                                    </tr>
                                                </thead>
                                                <script>
                                                    $('#filterMonthYear').on('change', function(e){
                                                        var date = $(this).val();
                                                        var data = {
                                                            'date': date
                                                        }
                                                        var url = "/monthly-collection/grand";
                                                        $.ajax({
                                                            type: 'GET',
                                                            url: url,
                                                            data: data,
                                                            dataType: 'JSON',
                                                            success: function(response){
                                                                $('#monthly_summary_table tfoot td:eq(2)').text(response.water_rental_grand.toFixed(2));
                                                                $('#monthly_summary_table tfoot td:eq(3)').text(response.surcharge_grand.toFixed(2));
                                                                $('#monthly_summary_table tfoot td:eq(4)').text(response.discount_grand.toFixed(2));
                                                                $('#monthly_summary_table tfoot td:eq(5)').text(response.misc_grand);
                                                                $('#monthly_summary_table tfoot td:eq(6)').text(response.watershed_grand.toFixed(2));
                                                                $('#monthly_summary_table tfoot td:eq(7)').text(response.total_grand.toFixed(2));
                                                            }
                                                        })
                                                    })
                                                     $(document).ready(function(){
                                                        var CollectiondataTable = $('#monthly_summary_table').DataTable({
                                                            "processing": true,
                                                            "language": {
                                                                processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                                                            },
                                                            serverSide: true,
                                                            ajax: {
                                                                url: "/monthly-collection",
                                                                data: function (d) {
                                                                    d.filterMonthYear = $('#filterMonthYear').val();
                                                                }
                                                            },
                                                            columns: [ 
                                                                { data: 'rate_case',
                                                                  name: 'rate_case', 
                                                                  render: function(data, type, row, meta) {
                                                                    if (type === 'display') {
                                                                        
                                                                        if (meta.row === 0 || data !== CollectiondataTable.cell({ row: meta.row - 1, column: meta.col }).data()) {
                                                                            return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                                                        } else {
                                                                            return ''; 
                                                                        }
                                                                    }
                                                                    return data;
                                                                }
                                                                  
                                                                },
                                                                { data: 'cluster', 
                                                                  name: 'cluster',
                                                                  render: function(data) {
                                                                  
                                                                        return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';

                                                                }
                                                                },
                                                                { data: 'water_rental', 
                                                                  name: 'water_rental' 
                                                                },
                                                                { data: 'surcharge', 
                                                                  name: 'surcharge' 
                                                                },
                                                                { data: 'discount',
                                                                  name: 'discount',
                                                                        render: function(data) {
                                                                        if(data == 0.00){
                                                                            return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                                                        }else{
                                                                            return '<div style="flex: 1; white-space: nowrap;">(' + data + ')</div>';
                                                                        }
                                                                        

                                                                }
                                                                },
                                                                { data: 'misc', 
                                                                  name: 'misc' 
                                                                },
                                                                { data: 'watershed', 
                                                                  name: 'watershed' 
                                                                },
                                                                { data: 'total', 
                                                                  name: 'total' 
                                                                }
                                                            ],
                                                            dom: 'Bfrtip',
                                                            buttons: [
                                                                {
                                                                    extend: 'copy',
                                                                    text: '<i class="fas fa-copy"></i> Copy',
                                                                    className: 'btn btn-copy enlarge-on-hover'
                                                                },
                                                                {
                                                                    extend: 'csv',
                                                                    text: '<i class="fas fa-file-csv"></i> CSV',
                                                                    className: 'btn btn-csv enlarge-on-hover'
                                                                },
                                                                {
                                                                    extend: 'excel',
                                                                    text: '<i class="fas fa-file-excel"></i> Excel',
                                                                    className: 'btn btn-excel enlarge-on-hover'
                                                                },
                                                                {
                                                                    extend: 'print',
                                                                    text: '<i class="fas fa-file-pdf"></i> PDF | <i class="fas fa-print"></i> Print',
                                                                    className: 'btn btn-print enlarge-on-hover',
                                                                    title: function () {
                                                                        
                                                                            var date = new Date($('#filterMonthYear').val());

                                                                            var date = date.toLocaleDateString(undefined, { year: 'numeric', month: 'long' });
                                                                           

                                                                            return '<h1>Monthly Collection Summary</h1><h2>for the month of ' + date + '</h2>';
                                                                        },
                                                                    customize: function (win) {
                                                                        
                                                                        $(win.document.body).find('table').append($('#monthly_summary_table tfoot').clone());
                                                                    }
                                                                }
                                                            ],
                                                            
               
                                                        });

                                                        $('#filterMonthYear').on('change', function () {
                                                            CollectiondataTable.ajax.reload(); 
                                                        });
                                                        $('#ratecase-filter').on('change', function () {
                                                        var selectedrate_case = $(this).val();
                                                        CollectiondataTable.column('0').search(selectedrate_case).draw();
                                                    });
                                                    
                                                    });

                                                </script>
                                                <tfoot>
                                                    <tr id="grand_total_row">
                                                        <td><strong style="flex: 1; white-space: nowrap;">Grand Total</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        
                                    </div>
                                <br>
                                <br>
                                <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>        
        </div>
       
<style>
    .filter-container {
        margin-bottom: 20px;
    }


    #classification-filter {
        width: 100%; 
        padding: 8px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
        background-color: #fff; 
        font-size: 14px;
        color: #333; 
        height: 40px;
    }


    label[for="classification-filter"] {
        font-weight: bold;  `````````
        margin-right: 10px; 
    }
    #content{
        overflow: auto;
    }
    h1 {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    h2 {
        font-size: 18px;
        color:black;
        font-weight: normal;
        text-align: center;
        margin-bottom:20px;
    }

</style>

@endsection