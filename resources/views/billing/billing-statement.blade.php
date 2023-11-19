@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">BILLING STATEMENT</h2>
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
                                <div class="filter-controls" style="margin-top:-20px; margin-right: 55%;">
                                    <label for="filterMonthYear" style="margin-right:5px;color:rgb(0, 0, 0)" >Select Month and Year: </label>
                                    <input type="month" id="filterMonthYear" style="width: 100%" class="form-control">
                                </div>
                                <div class="filter-container" style="margin-top:-20px;margin-bottom:10px;width:200px">
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
                            
                            <table id="billing_statement" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                                <thead>
                                    <tr>
                                     
                                        <th>Account ID</th>
                                        <th>Name</th>
                                        <th>classification</th>
                                        <th>Rate Case</th>
                                        <th>Cluster</th>
                                        <th class="action">Tools</th>
                                        <th style="display: none">From_reading_Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         
            
            {{-- modal for billing statement --}}
            <div class="modal fade" id="billingStatementModal" tabindex="-1" role="dialog" aria-labelledby="billingStatementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="billingStatementModalLabel">Billing Statement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="text-center" style="font-size: 3mm">
                            <h5 class="mb-1" >MUNICIPAL ECONOMIC ENTERPRISE AND DEVELOPMENT OFFICE</h5>
                            <h4 class="mb-1">NAAWAN MUNICIPAL WATER SYSTEM</h4>
                            <p class="mb-0" style="color: black">LGU-naawan, Misamis Oriental</p>
                            <h4 class="mt-3">STATEMENT OF ACCOUNT</h4>
                            <p style="color: black">for the month of <span id="month_current_date_cell">[Month]</span></p>
                            <p style="color: black">Covering date of <span id="previous_from_reading_date_cell"></span> to <span id="current_from_reading_date_cell"></span></p>
                            <p style="color: black">As of <span id="currentDate">   <script>
                              
                                var currentDate = new Date();
                            
                          
                                var currentDateElement = document.getElementById("currentDate");
                            
                             
                                var formattedDate = currentDate.toLocaleDateString("en-US", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                });
                            
                                
                                currentDateElement.textContent = formattedDate;
                            </script></span></p>
                        </div>
            
                            <!-- Table Section -->
                            <table class="box-table" id="customer_info_table">
                                <tr>
                                    <td>Account No</td>
                                    <td>Classification</td>
                                    <td>Rate Case</td>
                                    <td>Meter No</td>
                                    <td>Cluster</td>
                                </tr>
                                <tr>
                                    <td id="account_no_cell"></td>
                                    <td id="classification_cell"></td>
                                    <td id="rate_case_cell"></td>
                                    <td id="meter_no_cell"></td>
                                    <td id="cluster_cell"></td>
                                </tr>
                            </table>
                            
                            <table class="box-table" id="customerName_info_table">
                                <tr>
                                    <td style="width: 100px">Customer</td>
                                    <td id="customer_name_cell" style="margin-right: 200px !important;"></td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td id="location_cell"></td>
                                </tr>
                            </table>
            
                            <!-- Meter Reading Section -->
                            <div style="display: flex;">
                            <table class="box-table" id="reading_table">
                                <tr>
                                    <td>Present Reading</td>
                                    <td id="current_reading_cell" style="text-align: right"></td>
                                </tr>
                                <tr>
                                    <td>Previous Reading</td>
                                    <td id="previous_reading_cell" style="text-align: right"></td>
                                </tr>
                                <tr>
                                    <td>Cubic Meter Used</td>
                                    <td id="volume_cell" style="text-align: right"></td>
                                </tr>
                                <tr>
                                    <td>Present Bill</td>
                                    <td id="amount_bill_cell" style="text-align: right">0.00</td>
                                </tr>
                                <tr>
                                    <td>Arrears</td>
                                    <td style="text-align: right" id="water_bill_arrears_cell">0.00</td>
                                </tr>
                                <tr>
                                    <td>Surcharged</td>
                                    <td style="text-align: right" id="surcharge_arrears_cell">0.00</td>
                                </tr>
                                <tr>
                                    <td>Discounts</td>
                                    <td style="text-align: right" id="discount_arrears_cell">0.00</td>
                                </tr>
                                <tr>
                                    <td>Other Accounts</td>
                                    <td style="text-align: right" id="other_cell">0.00</td>
                                </tr>
                                <tr>
                                    <td>Watershed</td>
                                    <td style="text-align: right" id="watershed_arrears_cell">0.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        Total Amount Due:
                                    </td>
                                    <td id="totalAmountDue" style="text-align: right">
                                        0.00
                                    </td>
                                </tr>
                            </table>
                            <table class="box-table" style="margin-left:20px" id="note">
                                <tbody>
                                    <tr>
                                        <td>

                                            <p style="margin-left:20px;color: black">Please pay this bill at the</p>
                                            <p style="color: black">Municipal Treasurer's OFFICE</p>
                                            <p style="color: black">(MTO) within 20 days upon</p>
                                            <p style="color: black">receipt to avoid the 2% penalty</p>
                                            <p style="color: black">per month.</p>
                                            <p style="margin-left:20px;color: black">However, if payment </p>
                                            <p style="color: black">is made within 5 working days</p>
                                            <p style="color: black">upon the receipt, a discount of 10%</p>
                                            <p style="color: black">shall be granted.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                           
                        <div style="display: flex">
                            <table class="box-table" id="date_table">
                                <tr>
                                    <td>Date Delivered</td>
                                    <td id="date_delivered_cell"></td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td id="due_date_cell"></td>
                                </tr>
                              
                            </table>
                            <table class="box-table" id="meter_Table">
                                <tr>
                                    <td>Meter Reader</td>
                                </tr>
                                <tr>
                                    <td id="reader_cell">
                                    </td>
                                </tr>
                            </table>
                        </div>
                         
                            
            
                            <table class="box-table" id="notes">
                                <tr><td>
                              <p style="color: black">Note: likaye nga ikaw dli maputlan kay ang reconnection fee is php 500.00.</p>
                                </td>

                                </tr>
                               
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="print-modal-content-btn" class="btn btn-success" onclick="printModalContent()"><i class="fa fa-print"></i> Print</button>

                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
      

            <style>
           
                .box-table td {
                    margin: 10px;
                    color:black; 
                }

                .modal-content {
                    max-width: 100%; 
                }

              
                .table-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between; 
                }

                .table {
                    width: 48%; 
                    margin-bottom: 20px; 
                }

            
                @media (max-width: 768px) {
                    .table {
                        width: 100%;
                    }
                }
                .box-table {
                border: 1px solid #000; 
                padding: 10px; 
                width: 30%; 
            }
            #customer_info_table{
                margin-left:30px;
                border: 1px solid #000; 
                padding: 10px; 
                width: 90%;
            }
            #customerName_info_table{
                margin-left:30px;
                border: 1px solid #000;
                padding: 10px; 
                width: 90%;
                margin-top:10px;
            }
            #reading_table{
                margin-left:30px;
                border: 1px solid #000; 
                padding: 10px; 
                width: 50%;
                margin-top:10px;
            }
            #note{
                margin-left:30px;
                border: 1px solid #000; 
                padding: 10px; 
                width: 37%;
                margin-top:10px;
            }
            #date_table{
                margin-left:30px;
                border: 1px solid #000; 
                padding: 10px;
                width: 50%;
                margin-top:10px;
            }
            #meter_Table{
                 margin-left:20px;
                border: 1px solid #000; 
                padding: 10px; 
                width: 37%;
                margin-top:10px;
            }
            #notes{
                margin-left:30px;
                border: 1px solid #000; 
                padding: 10px;
                width: 90%;
                margin-top:10px;
            }

            </style>
            <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
            <script>
               
                function printModalContent() {
                    
                    var modalContent = document.querySelector('.modal-content');
                    var clonedContent = modalContent.cloneNode(true);

                  
                    var header = clonedContent.querySelector('.modal-header');
                    var footer = clonedContent.querySelector('.modal-footer');
                    var printButton = clonedContent.querySelector('#print-modal-content-btn');

                    if (header) {
                        header.parentNode.removeChild(header);
                    }

                    if (footer) {
                        footer.parentNode.removeChild(footer);
                    }

                    if (printButton) {
                        printButton.parentNode.removeChild(printButton);
                    }

                
                    var printWindow = window.open('', '', 'width=600,height=600');
                    printWindow.document.open();
                    printWindow.document.write('<html><head><title>Meedo Naawan Water System</title></head><body>');

                 
                    printWindow.document.write(`
                        <style>
                            /* Your CSS styles here */
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                                
                            }
                            .box-table td {
                                    margin: 10px; /* Adjust the margin as needed */
                                }
                        /* CSS for the modal content */
                        .text-center {
                                text-align: center;
                            }
                                .modal-content {
                                    max-width: 100%; /* Allow content to expand to the full width of the modal */
                                }

                                /* CSS for the tables */
                                .table-container {
                                    display: flex;
                                    flex-wrap: wrap; /* Allow tables to wrap to the next line if needed */
                                    justify-content: space-between; /* Space between tables */
                                }

                                .table {
                                    width: 48%; /* Adjust the width as needed to fit two tables within the modal */
                                    margin-bottom: 20px; /* Add some space between tables */
                                }

                                /* Additional CSS for responsiveness */
                                @media (max-width: 768px) {
                                    .table {
                                        width: 100%; /* Full width for tables on smaller screens */
                                    }
                                }
                                .box-table {
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 30%; /* Make the table expand to the full width */
                            }
                            #customer_info_table{
                                margin-left:30px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 90%;
                            }
                            #customerName_info_table{
                                margin-left:30px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 90%;
                                margin-top:10px;
                            }
                            #reading_table{
                                margin-left:30px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 50%;
                                margin-top:10px;
                            }
                            #note{
                                margin-left:30px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 37%;
                                margin-top:10px;
                            }
                            #date_table{
                                margin-left:30px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 50%;
                                margin-top:10px;
                            }
                            #meter_Table{
                                margin-left:20px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 37%;
                                margin-top:10px;
                            }
                            #notes{
                                margin-left:30px;
                                border: 1px solid #000; /* Add a black border */
                                padding: 10px; /* Add padding to create space between the content and the border */
                                width: 90%;
                                margin-top:10px;
                            }
                        </style>
                    `);

                  
                    printWindow.document.write(clonedContent.outerHTML);

                   
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                  
                }

                
                document.getElementById('print-modal-content-btn').addEventListener('click', function () {
                    printModalContent();
                });

            </script>
           <script>
        
               function viewBillingStatement(id) {
                
                var selectedMonthYear = $('#filterMonthYear').val();
                var selectedCluster = $('#cluster-filter').val();

                    if (!selectedMonthYear || !selectedCluster) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Required to select Cluster and Month/Year',
                            text: 'Please select both the Filter Month/Year and Cluster before viewing the billing statement.',
                        });
                        return; 
                    }
                $.ajax({
                    url: "/billingstatement/edit/" + id + "?monthYear=" + selectedMonthYear,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function (data) {
                        // Populate the modal with the retrieved data
                        $('#account_no_cell').text(data.billingStatement.account_id);
                        $('#classification_cell').text(data.billingStatement.classification);
                        $('#rate_case_cell').text(data.billingStatement.rate_case);
                        $('#meter_no_cell').text(data.billingStatement.meter);
                        $('#cluster_cell').text(data.billingStatement.cluster);
                        $('#location_cell').text(data.billingStatement.location);
                        $('#customer_name_cell').text(data.billingStatement.customerName);
                  
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        if(data.previous_reading.previous_from_reading_date){
                            const previousFromDate = new Date(data.previous_reading.previous_from_reading_date);
                           
                            const formattedPreviousFromDate = previousFromDate.toLocaleDateString(undefined, options);
                            $('#previous_from_reading_date_cell').text(formattedPreviousFromDate);
                       
                        }
                       else{
                        const formattedPreviousFromDate = 'No previous date';
                        $('#previous_from_reading_date_cell').text(formattedPreviousFromDate);

                     }
                        
                 
                       

                        
                        const currentFromDate = new Date(data.billingStatement.from_reading_date);
                        const formattedCurrentFromDate = currentFromDate.toLocaleDateString(undefined, options);

                       
                        const currentMonth = currentFromDate.toLocaleDateString(undefined, { month: 'long' });
                        const currentYear = currentFromDate.getFullYear();

                        const dateDelivered = new Date(data.billingStatement.date_delivered);
                        const formattedDateDelivered = dateDelivered.toLocaleDateString(undefined, options);
                        
                        const DueDate = new Date(data.billingStatement.due_date);
                        const formattedDueDate = DueDate.toLocaleDateString(undefined, options);
                                     
                        $('#volume_cell').text(data.billingStatement.volume);
                        $('#date_delivered_cell').text(formattedDateDelivered); 
                        $('#previous_reading_cell').text(data.billingStatement.previous_reading);
                        $('#current_reading_cell').text(data.billingStatement.current_reading);
                      
                        $('#current_from_reading_date_cell').text(formattedCurrentFromDate);
                        $('#month_current_date_cell').text(`${currentMonth} ${currentYear}`);
                        $('#due_date_cell').text(formattedDueDate);
                        // Display arrears for Water Bill and Watershed
                        $('#water_bill_arrears_cell').text(data.billingStatement.water_bill_arrears);
                        $('#watershed_arrears_cell').text(data.billingStatement.watershed_arrears);
                        $('#surcharge_arrears_cell').text(data.billingStatement.surcharge_arrears);
                        $('#discount_arrears_cell').text(data.billingStatement.discount_arrears);
                        $('#amount_bill_cell').text(data.billingStatement.amount_bill);
                        const waterBillArrears = parseFloat($('#water_bill_arrears_cell').text().replace(',', ''));
                        const amountBill = parseFloat($('#amount_bill_cell').text().replace(',', ''));
                        const watershedArrears = parseFloat($('#watershed_arrears_cell').text().replace(',', ''));
                        const surcharge_arrears = parseFloat($('#surcharge_arrears_cell').text().replace(',', ''));
                        const discount_arrears = parseFloat($('#discount_arrears_cell').text().replace(',', ''));
                        const totalAmountDue = waterBillArrears + amountBill + watershedArrears + surcharge_arrears - discount_arrears;

                        // Display the calculated totalAmountDue
                        $('#totalAmountDue').text(totalAmountDue.toFixed(2));
                        $('#reader_cell').text(data.billingStatement.Reader);
                        $('#billingStatementModal').modal('show');
                    },
                    error: function (data) {
                        var errors = data.billingStatement.responseJSON;
                      
                    }
                });
            }

                $(document).ready(function(){
                    var StatementdataTable = $('#billing_statement').DataTable({
                        "processing": true,
                        "language": {
                            processing: '<img src="{{ asset("pluto/images/logo/naawan_icon.png") }}" class="fa-spin fa-3x fa-fw" style="width: 50px; height: 50px;" /> <span style="font-weight: bold; color: black;">Wait for a moment ...</span>'
                        },
                        serverSide: true,
                        ajax: "/billing-statement",
                        columns: [
                          
                            {
                                data : 'account_id',
                                name : 'account_id',
                                render: function(data, type, row, meta) {
                                    if (type === 'display') {
                                        
                                        if (meta.row === 0 || data !== StatementdataTable.cell({ row: meta.row - 1, column: meta.col }).data()) {
                                            return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                        } else {
                                            return ''; 
                                        }
                                    }
                                    return data;
                                }
                            },
                            {
                                data : 'customerName',
                                name : 'customerName'
                            },
                           
                            {
                                data : 'classification',
                                name : 'classification'
                            },
                            {
                                data : 'rate_case',
                                name : 'rate_case'
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
                            },
                            {
                                data : 'from_reading_date',
                                name : 'from_reading_date',
                                render: function(data) {
                                    return '<div style="display:none">' + data + '</div>';
                                }
                            }
                        ],
                        columnDefs: [
                        {
                            targets: [6], 
                            visible: false, 
                        }
                    ],
                    
                    });

     
                    $('#cluster-filter').on('change', function () {
                        var selectedCluster = $(this).val();
                        StatementdataTable.column('4').search(selectedCluster).draw();
                    });
                    $('#filterMonthYear').on('change', function () {
                    const selectedMonthYear = $(this).val();
                    const StatementdataTable = $('#billing_statement').DataTable();
                    StatementdataTable.column(6).search(selectedMonthYear).draw();
          
        
                    
                });
                });

            </script>       
         
    </div> 
     
    
@endsection