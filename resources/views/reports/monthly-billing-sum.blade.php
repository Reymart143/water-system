@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column1">
            <div class="col-md-2"></div>
                <div class="col-md-12 mt-3">
                    <div class="margin_bottom_30">
                        <div class="full graph_head" style="background: #007bff; border-radius: 5px;height:165px;width:100%;">
                            <h2 style="color:white !important"><i class="fa fa-book green_color" style="color:white !important"></i> Monthly Billing Summary</h2> 
                                <div class="card-body" style="padding: 20px; width: 100% !important; box-shadow: 0px 0px 20px 0px #747f8a !important; margin-top: 15px;">
                                        <div class="filter-container" style="display: flex; justify-content: space-between;">
                                            <div class="filter-controls" style="display: flex; align-items: center;">
                                                <label for="filterMonthYear" style="color: rgb(255, 255, 255); margin-right: 10px;">Select Month and Year:</label>
                                                <input type="month" id="filterMonthYear" name="filterMonthYear" style="width: 160px;" class="form-control">
                                               
                                            </div>
                                            <div>
                                                <label for="ratecase-filter" style="color: white;">Select Rate Case you want to print:</label>
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
                                    
                                        
                                            <table class="display table table-bordered" id="monthly_summary_table" style="color: black !important; width: 100% !important;">
                                                <thead style="background: #009688 !important;">
                                                    <tr>
                                                        <th class="header-table" style="display:none">Month || Year</th>
                                                        <th class="header-table">Rate Case</th>
                                                        <th class="header-table">Cluster</th>
                                                        <th class="header-table">Volume</th>
                                                        <th class="header-table">Amount Bill</th>
                                                        <th class="header-table">tools</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    @foreach($billingSummary as $summary)
                                                    <tr style="background-color: #f5f5f5">
                                                        <td style="display:none">{{ $summary->year }}-{{ str_pad($summary->month, 2, '0', STR_PAD_LEFT) }}</td>
                                                        <td>{{ $summary->rate_case }}</td>
                                                        <td>{{ $summary->cluster }}</td>
                                                        <td>{{ $summary->total_volume }}</td>
                                                        <td>{{ $summary->total_amount_bill }}</td>
                                                        
                                                            <td>
                                                                <button type="button" name="view" data-toggle="modal" data-target="#viewsummaryModal" data-view-customer="{{ $summary->cluster }}" class="action-button btn-info btn-sm view-btn" style="margin-left:20px;padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                                                                    <i class="fa fa-eye"></i>
                                                                    <span class="action-text" style="font-size:10px">View</span>
                                                                </button>
                                                            </td>
                                                       
                                                       
                                                    </tr>
                                                @endforeach
                                            
                                                </tbody>
                                                <tfoot>
                                                    <tr id="grand_total_row">
                                                        <td><strong>Grand Total for the Month</strong></td>
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
        {{-- modal for all in cluster --}}
        <div class="modal fade" id="viewsummaryModal" tabindex="-1" aria-labelledby="viewsummaryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="viewsummaryModalLabel"> for Cluster: <span id="modalCluster"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Volume</th>
                                <th>Amount Bill</th>               
                            </tr>
                        </thead>
                        <tbody id="modalApplications">
                       
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <td id="totalVolume">0</td>
                                <td id="totalAmountBill">0</td>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="print_btn" class="btn btn-primary">Print</button>
                </div>
              </div>
            </div>
          </div>
          <script>
         
                function printModalContent() {
                   
                    var printWindow = window.open('', '', 'width=800,height=600');

                
                    var clusterName = document.getElementById('modalCluster').textContent;

                    var content = `
                        <html>
                        <head>
                            <title>Printed Copy of List</title>
                            <style>
                                /* Add any custom CSS styles for printing here */
                                /* For example, you can style the header */
                                .header {
                                    text-align: center;
                                    font-weight: bold;
                                    margin-bottom: 10px;
                                }
                                table {
                                    border-collapse: collapse;
                                    width: 100%;
                                }
                                th, td {
                                    padding: 8px; /* Adjust the padding as needed */
                                    text-align: left;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                Republic of the Philippines<br>
                                Naawan Municipal Water System<br>
                                Cluster of ${clusterName} 
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th >Customer Name</th>
                                        <th >Volume</th>
                                        <th >Amount Bill</th>               
                                    </tr>
                                </thead>
                                <tbody>
                                    ${document.getElementById('modalApplications').innerHTML}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <td>${document.getElementById('totalVolume').textContent || '0'}</td>
                                        <td>${document.getElementById('totalAmountBill').textContent || '0'}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </body>
                        </html>
                    `;

                    printWindow.document.open();
                    printWindow.document.write(content);
                    printWindow.document.close();
                    printWindow.print();
                 
                }

              
                document.getElementById('print_btn').addEventListener('click', function () {
                    printModalContent();
                });

            $('.view-btn').click(function () {
                var Cluster = $(this).data('view-customer');
                    var selectedMonthYear = $('#filterMonthYear').val();

                    if (!selectedMonthYear) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Reminder',
                            text: 'Please select Month/Year to get your monthly billing summary!',
                        });
                        return; 
                       
                    }

                    $('#modalCluster').text(Cluster);
                    $('#modalApplications').empty();
                var totalVolume = 0;
                var totalAmountBill = 0;

                $.ajax({
                    url: '/each-customer-cluster',
                    method: 'GET',
                    data: {
                        cluster: Cluster,
                        monthYear: selectedMonthYear
                    },
                    success: function (data) {
                        data.forEach(function (application) {
                            $('#modalApplications').append(`
                                <tr>
                                    <td>${application.customerName}</td>
                                    <td>${application.volume}</td>
                                    <td>${application.amount_bill}</td>
                                </tr>
                            `);

                            totalVolume += parseFloat(application.volume);
                            totalAmountBill += parseFloat(application.amount_bill);
                        });

                       
                        $('#totalVolume').text(totalVolume.toFixed(2)); 
                        $('#totalAmountBill').text(totalAmountBill.toFixed(2)); 
                    }
                });
            });

          </script>
        <script>
            $(document).ready(function () {
                
                const table = $('#monthly_summary_table').DataTable({

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

                                        thead.append('<tr><th class="header-table" style="color:black">Rate Case</th><th class="header-table" style="color:black">Cluster</th><th class="header-table" style="color:black">Volume</th><th class="header-table" style="color:black">Amount Bill</th>');

                                        var selectedClassification = ratecaseFilter.value.toLowerCase();
                                
                                            
                                        $('#monthly_summary_table tbody tr').each(function () {
                                            var classificationCell = $(this).find('td:nth-child(2)').text().trim().toLowerCase();
                                            var rateCell = $(this).find('td:eq(0)');
                                           
                                            rateCell.css({
                                                'display' : 'none',
                                                'flex': '1',
                                                'white-space': 'nowrap'
                                            });
                                            
                                            if (selectedClassification === '' || classificationCell === selectedClassification) {
                                                
                                                var clonedRow = $(this).clone();

                                                   
                                                    clonedRow.find('.view-btn').closest('td').hide();

                                                    tbody.append(clonedRow);
                                            }
                                        });

                                if (tbody.children().length > 0) {
                                    var grandTotalVolume = 0;
                                        var grandTotalAmountBill = 0;

                                        tbody.find('tr').each(function () {
                                            var volume = parseFloat($(this).find('td:nth-child(4)').text());
                                            var amountBill = parseFloat($(this).find('td:nth-child(5)').text());

                                            grandTotalVolume += isNaN(volume) ? 0 : volume;
                                            grandTotalAmountBill += isNaN(amountBill) ? 0 : amountBill;
                                        });

                        
                                        tbody.append('<tr><td><strong>Grand Total for the Month</strong></td><td></td><td><strong>' + grandTotalVolume.toFixed(2) + '</strong></td><td><strong>' + grandTotalAmountBill.toFixed(2) + '</strong></td></tr>');

                                    $(win.document.body).empty();

                                    $(win.document.body).append('<h1 class="header-text" style="margin-left:37%;color:black">Republic of the Philippines</h1>');
                                    $(win.document.body).append('<div class="header-text" style="margin-left:40%;color:black">Naawan Municipal Water System</div>');
                                    $(win.document.body).append('<div class="header-text" style="margin-left:33%;color:black">Monthly Billing Summary in the month of ' + formatMonthYear($('#filterMonthYear').val()) + '</div>');

                                
                                    function formatMonthYear(monthYear) {
                                    
                                        const date = new Date(monthYear);
                                        
                                    
                                        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    
                                        const month = monthNames[date.getMonth()];
                                        const year = date.getFullYear();
                                        
                                    
                                        return month + ' ' + year;
                                    }

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
                $('#filterMonthYear').on('change', function () {
                        const selectedMonthYear = $(this).val();
                        const readingTable = $('#monthly_summary_table').DataTable();

            
                        readingTable.column(0).search(selectedMonthYear).draw();
                        calculateGrandTotal();
                });
                const ratecaseFilter = document.getElementById('ratecase-filter');

                ratecaseFilter.addEventListener('change', function () {
                    const selectedRateCase = ratecaseFilter.value.toLowerCase();

                    table.rows().every(function() {
                        var row = this.node();
                        var rateCaseCell = row.querySelector('td:nth-child(2)'); 
                        var rowRateCase = rateCaseCell.textContent.trim().toLowerCase();

                        if (selectedRateCase === '' || rowRateCase === selectedRateCase) {
                            $(row).show();
                        } else {
                            $(row).hide();
                        }

                        return true;
                    });
                });
                function calculateGrandTotal() {
                    const selectedMonthYear = $('#filterMonthYear').val().trim();
                    const selectedRateCase = ratecaseFilter.value.toLowerCase();

                    let totalVolume = 0;
                    let totalAmountBill = 0;

                    table
                        .rows({ search: 'applied' }) 
                        .every(function () {
                            const row = this.data();
                            const monthYearCell = row[0];
                            const rateCaseCell = row[1].toLowerCase(); 

                            if (
                                (selectedMonthYear === '' || monthYearCell.includes(selectedMonthYear)) &&
                                (selectedRateCase === '' || rateCaseCell === selectedRateCase)
                            ) {
                                totalVolume += parseFloat(row[3]); 
                                totalAmountBill += parseFloat(row[4]); 
                            }

                            return true;
                        });

                    
                    const grandTotalRow = $('#grand_total_row');
                    grandTotalRow.find('td:nth-child(3)').text(totalVolume.toFixed(2)); 
                    grandTotalRow.find('td:nth-child(4)').text(totalAmountBill.toFixed(2)); 
                }

     
                calculateGrandTotal();

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