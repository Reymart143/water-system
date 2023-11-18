@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column1">
            <div class="col-md-2"></div>
                <div class="col-md-12 mt-3">
                    <div class="margin_bottom_30">
                        <div class="full graph_head" style="background: #007bff; border-radius: 5px;height:165px;width:100%;">
                            <h2 style="color:white !important"><i class="fa fa-book green_color" style="color:white !important"></i> Master List</h2> 
                            <div class="card-body" style="padding: 20px; width: 100% !important; box-shadow: 0px 0px 20px 0px #747f8a !important; margin-top: 15px;">
                                <div class="filter-container">
                                    <label for="classification-filter" style="color:white">Select Classification you wanted to print:</label>
                                    <select id="classification-filter" class="form-control">
                                        <option value="">All</option>
                                        @php
                                        $categories = DB::table('libraries')->get();
                                        @endphp
                                        @foreach ($categories as $category)
                                            @if ($category->category === 'Classification')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                    <table class="display table table-bordered" id="masterlist_table" style="color: black !important; width: 100% !important;">
                                        <thead style="background: #009688 !important;">
                                            <tr>
                                                <th class="header-table">Customer Name</th>
                                                <th class="header-table">Consumer Name</th>
                                                <th class="header-table">Concessioner Name</th>
                                                <th class="header-table">Classification</th>
                                                <th class="header-table">Rate Case</th>
                                                <th class="header-table">Cluster</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($masterlist as $list)
                                            <tr style="background-color: #f5f5f5">

                                                <td>{{$list->customerName}}</td>
                                                <td>{{$list->consumerName2}}</td>
                                                <td>{{$list->concessionerName}}</td>
                                                <td> {{$list->Classification}}</td>
                                                <td>{{$list->rate_case}}</td>
                                                <td> {{$list->cluster}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
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
<script>
    $(document).ready(function () {
    
        const masterlistTable = $('#masterlist_table').DataTable({
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
                    customize: function (win) {
                  
                        var printTable = $('<table>').addClass('display table table-bordered');
                        var thead = $('<thead>').appendTo(printTable);
                        var tbody = $('<tbody>').appendTo(printTable);

                      
                        thead.append('<tr><th style="color:black">Customer Name</th><th style="color:black">Consumer Name</th><th style="color:black">Concessioner Name</th><th style="color:black">Classification</th><th style="color:black">Rate Case</th><th style="color:black">Cluster</th></tr>');

                    
                        var selectedClassification = classificationFilter.value.toLowerCase();

                       
                        tableRows.forEach(function (row) {
                            var classificationCell = row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();

                            if (selectedClassification === '' || classificationCell === selectedClassification) {
                     
                                tbody.append(row.cloneNode(true));
                            }
                        });

                  
                        if (tbody.children().length > 0) {
                            
                            $(win.document.body).empty();

                          
                            $(win.document.body).append('<div class="header-text" style="margin-left:42%;color:black">Republic of the Philippines</div>');
                            $(win.document.body).append('<div class="header-text" style="margin-left:40%;color:black">Naawan Municipal Water System</div>');
                            $(win.document.body).append('<div class="header-text" style="margin-left:40%;color:black"><h4 style="margin-left:56px">Master List</h4></div>');
                           
                            $(win.document.body).append(printTable);
                        } else {
                         
                            $(win.document.body).html('<p>No data to print for the selected classification.</p>');
                        }
                    }

                }

            ],
            responsive: true,
            paging: true,
            "lengthMenu": [[10, 25, 50, 100,500], [10, 25, 50, 100,500]],
            "pageLength": 100, 
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    page: "%index%"
                }
            }
        });
    });

   
    const classificationFilter = document.getElementById('classification-filter');
    const tableRows = document.querySelectorAll('.table tbody tr');


    classificationFilter.addEventListener('change', function () {
        const selectedClassification = classificationFilter.value.toLowerCase(); 

     
        tableRows.forEach((row) => {
            const classificationCell = row.querySelector('td:nth-child(4)'); 

      
            const rowClassification = classificationCell.textContent.trim().toLowerCase();

            if (selectedClassification === '' || rowClassification === selectedClassification) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    });
</script>
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
        font-weight: bold; 
        margin-right: 10px; 
    }
    #content{
        overflow: auto;
    }

</style>

@endsection