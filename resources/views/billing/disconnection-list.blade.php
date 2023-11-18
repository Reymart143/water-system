@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">List of Disconnection</h2>
                                 <div style="margin-left:90%;margin-top:-30px">
                <button class="btn btn-success" id="print_notice"  onclick="printContent()"><i class="fa fa-print"></i> Print</button>
            </div>
                               
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <a href="/disconnection-notice"><button  class="btn btn-secondary"><i class="fa fa-arrow-circle-left"></i> Back</button></a>
            
           
            <script>
                function printContent() {
                   
                    var printWindow = window.open('', '', 'width=600,height=600');
            
      
                    printWindow.document.write('<html><head><title>Printed Copy</title></head><body>');
                       
                    printWindow.document.write('<style>');
                    printWindow.document.write('@media print {');
                        
                    printWindow.document.write('  body { font-family: Arial, sans-serif; }');
                    printWindow.document.write('  .card-body { margin: -10px;margin-left: -10px; padding: -10px;font-size:4mm }');
                    printWindow.document.write('  table { width: 100%; border-collapse: collapse; }');
                    printWindow.document.write('  th, td { border: 1px solid #000; padding: -5px; text-align: center; }');
                    printWindow.document.write('  th { background-color: #f2f2f2; }');
                    printWindow.document.write('}');
                    printWindow.document.write('</style>');
           
                            printWindow.document.write(`
                            @foreach ($disconnectionNotices as $userKey => $userData)
                                    @php
                                    $customerGrandWaterBill = 0;
                                    $customerGrandSurcharge = 0;
                                    $customerGrandWatershed = 0;
                                    $customerGrandTotal = 0;
                                    @endphp
                                    <div class="page"> 
                                        <div class="row column1" style="margin-left:-8px;margin-bottom:66px;margin-top:20px">
                                            <div class="col-md-12">
                                                <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: 5px;">
                                                    {{-- TABLE --}}
                                                    <div class="card-body mt-4 mb-4" style="padding: 20px;" style="width: 100% !important;">
                                        
                                                @if (isset($userData['cluster']))
                                                    <span id="name" style="color: black;display:none">{{ $userData['cluster'] }}</span>
                                                @else
                                                    <span id="name">N/A</span>
                                                @endif
                                                <h5 class="card-title" style="text-align: center;margin-top:-10px">MUNICIPAL ECONOMIC ENTERPRISE AND DEVELOPMENT OFFICE</h5>
                                                <h5 class="card-title" style="text-align: center;margin-top:-10px">NAAWAN MUNICIPAL WATER SYSTEM</h5>
                                                <h4 class="card-title" style="text-align: center;margin-top:-15px;" >DISCONNECTION NOTICE</h4>
                                                <div class="card-body" style="margin-left: 4%">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="margin-left: -5px">
                                                                <label for="name">Name:</label>
                                                                @if (isset($userData['customerName']))
                                                                    <span id="name" style="color: black">{{ $userData['customerName'] }}</span>
                                                                @else
                                                                    <span id="name">N/A</span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group" style="margin-left: -5px">
                                                                <label for="address">Address:</label>
                                                                @if (isset($userData['location']))
                                                                    <span id="address" style="color: black">{{ $userData['location'] }}</span>
                                                                @else
                                                                    <span id="address" style="color: black">N/A</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="margin-left: 450px; margin-top: -40px">
                                                            <div class="form-group">
                                                                <label for="date">Date:</label>
                                                                <span id="date" style="color: black">{{ \Carbon\Carbon::parse($asofdate)->format('F d, Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p style="color: black;margin-top:30px">Sir/Madam:</p>
                                                        <p style="color: black; margin-left: 8px;margin-top:-15px">Much of our desire to continue serving you as a consumer of Naawan Municipal Water System (NMWS),</p>
                                                        <p style="color: black; margin-left: -5px;margin-top:-15px">but we have no other choice except to discontinue your water supply should you fail to settle your overdue
                                                    account and old account balance of 0.00 within (2) days from receipt of this notice. </p>
                                                    </div>
                                                    <p style="margin-left:20px">Further, a 2% penalty per month shall be charged against your delinquent bills.</p>
                                                    <table class="display table table-bordered" id="cardbody_search" style="color: black !important; width: 90% !important;margin-left:20px">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 170px">Month Delinquent</th>
                                                                <th>Water Bill</th>
                                                                <th>Surcharge</th>
                                                                <th>Watershed</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($userData['water_bills'] as $waterBill)
                                                            @php
                                                                $waterRental = (float) str_replace(',', '', $waterBill['water_rental']);
                                                                $surcharge = (float) str_replace(',', '', $waterBill['surcharge']);
                                                                $watershed = (float) str_replace(',', '', $waterBill['watershed']);
                                                                $total = (float) str_replace(',', '', $waterBill['total']);
                                                                
                                                                $customerGrandWaterBill += $waterRental;
                                                                $customerGrandSurcharge += $surcharge;
                                                                $customerGrandWatershed += $watershed;
                                                                $customerGrandTotal += $total;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $waterBill['month_delinquent'] }}</td>
                                                                <td>{{ number_format($waterRental, 2) }}</td>
                                                                <td>{{ number_format($surcharge, 2) }}</td>
                                                                <td>{{ number_format($watershed, 2) }}</td>
                                                                <td>{{ number_format($total, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <td style="font-weight: bold">Total Unpaid Bill</td>
                                                        <td>{{ number_format($customerGrandWaterBill, 2) }}</td>
                                                        <td>{{ number_format($customerGrandSurcharge, 2) }}</td>
                                                        <td>{{ number_format($customerGrandWatershed, 2) }}</td>
                                                        <td>{{ number_format($customerGrandTotal, 2) }}</td>
                                                    </tfoot>
                                                    </table>
                                                <p style="color: black;margin-left: -5px">Kindly settle your account in the office of the Municipal Treasurer Naawan, Misamis Oriental.</p>
                                                <p style="color: black;margin-top:-13px;margin-left: -5px">Please disregard this notice if payment has been made.</p>
                                                <p style="color: black;margin-top:-13px;margin-left: -5px;font-size:3mm">PAHIMANGNO: LIKAYE NGA DILI IKAW MAPUTLAN KAY ANG RECONNECTION FEE IS P500.00)</p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style=";margin-left: -5px">
                                                            <label for="received-by">Received by:</label>
                                                            <span id="received-by">_________________</span>
                                                        </div>
                                                        <div class="form-group" style=";margin-left: -5px">
                                                            <label for="date-received">Date Received:</label>
                                                            <span id="date-received">_________________</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-left: 450px; margin-top: -35px;text-align:center">
                                                            <span id="signature" style="border-bottom: 1px solid #000;font-size:3mm">ROWENA B. LEOTERO</span>

                                                            <br>
                                                            <span id="position">MEEDO Manager</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>



                     @endforeach
                               
                            `);
             
                    printWindow.document.write('</body></html>');
                    
            
                    printWindow.document.close();
                    printWindow.print();
               
                }
            </script>
         
            @foreach ($disconnectionNotices as $userKey => $userData)
                @php
                $customerGrandWaterBill = 0;
                $customerGrandSurcharge = 0;
                $customerGrandWatershed = 0;
                $customerGrandTotal = 0;
            @endphp
         <div class="row column1">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;margin-top: 0px;">
                    {{-- TABLE --}}
                    <div class="card-body mt-4 mb-4" style="padding: 20px;" style="width: 100% !important;">
          
                @if (isset($userData['cluster']))
                    <span id="name" style="color: black;display:none">{{ $userData['cluster'] }}</span>
                @else
                    <span id="name">N/A</span>
                @endif
                <h4 class="card-title" style="text-align: center">MUNICIPAL ECONOMIC ENTERPRISE AND DEVELOPMENT OFFICE</h4>
                <h6 class="card-title" style="text-align: center">NAAWAN MUNICIPAL WATER SYSTEM</h6>
                <h4 class="card-title" style="text-align: center">DISCONNECTION NOTICE</h4>
                <div class="card-body" style="margin-left: 7%">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                @if (isset($userData['customerName']))
                                    <span id="name" style="color: black">{{ $userData['customerName'] }}</span>
                                @else
                                    <span id="name">N/A</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                @if (isset($userData['location']))
                                    <span id="address" style="color: black">{{ $userData['location'] }}</span>
                                @else
                                    <span id="address" style="color: black">N/A</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-left: 590px; margin-top: -80px">
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <span id="date" style="color: black">{{ \Carbon\Carbon::parse($asofdate)->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p style="color: black">Sir/Madam:</p>
                        <p style="color: black; margin-left: 25px">Much of our desire to continue serving you as a consumer of Naawan Municipal Water System (NMWS),</p>
                        <p style="color: black">but we have no other choice except to discontinue your water supply should you fail to settle your overdue</p>
                        <p style="color: black">account and old account balance of 0.00 within (2) days from receipt of this notice. Further, a 2% penalty</p>
                        <p style="color: black">per month shall be charged against your delinquent bills.</p>
                    </div>
                    <table class="display table table-bordered" id="cardbody_search" style="color: black !important; width: 85% !important;">
                        <thead>
                            <tr>
                                <th style="width: 170px">Month Delinquent</th>
                                <th>Water Bill</th>
                                <th>Surcharge</th>
                                <th>Watershed</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userData['water_bills'] as $waterBill)
                            @php
                                $waterRental = (float) str_replace(',', '', $waterBill['water_rental']);
                                $surcharge = (float) str_replace(',', '', $waterBill['surcharge']);
                                $watershed = (float) str_replace(',', '', $waterBill['watershed']);
                                $total = (float) str_replace(',', '', $waterBill['total']);
                                
                                $customerGrandWaterBill += $waterRental;
                                $customerGrandSurcharge += $surcharge;
                                $customerGrandWatershed += $watershed;
                                $customerGrandTotal += $total;
                            @endphp
                            <tr>
                                <td>{{ $waterBill['month_delinquent'] }}</td>
                                <td>{{ number_format($waterRental, 2) }}</td>
                                <td>{{ number_format($surcharge, 2) }}</td>
                                <td>{{ number_format($watershed, 2) }}</td>
                                <td>{{ number_format($total, 2) }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <td style="font-weight: bold">Total Unpaid Bill</td>
                        <td>{{$customerGrandWaterBill}}</td>
                        <td>{{ $customerGrandSurcharge }}</td>
                        <td>{{number_format($customerGrandWatershed,2) }}</td>
                        <td>{{ $customerGrandTotal }}</td>
                        
                    </tfoot>
                    </table>
                <p style="color: black">Kindly settle your account in the office of the Municipal Treasurer Naawan, Misamis Oriental.</p>
                <p style="color: black">Please disregard this notice if payment has been made.</p>
                <p style="color: black">PAHIMANGNO: LIKAYE NGA DILI IKAW MAPUTLAN KAY ANG RECONNECTION FEE IS P500.00)</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="received-by">Received by:</label>
                            <span id="received-by">_________________</span>
                        </div>
                        <div class="form-group">
                            <label for="date-received">Date Received:</label>
                            <span id="date-received">_________________</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-left:180px;color:black">
                            <span id="signature">ROWENA B. LEOTERO</span>
                            <br>
                            <span id="position">MEEDO Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
        @endforeach
        {{-- <div class="row column1 mt-5">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1; margin-top: -55px;">

                    
                    <!-- Pagination -->
                    <div class="pagination button_section button_style2">
                        <!-- pagination -->
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                           <button type="button" class="active btn" >1</button> 
                           <button type="button" class="btn">2</button> 
                           <button type="button" class="btn">3</button> 
                           <button type="button" class="btn">4</button>
                        </div>
                     
                     </div>
                </div>
            </div>
        </div>   --}}
    </div>  

@endsection