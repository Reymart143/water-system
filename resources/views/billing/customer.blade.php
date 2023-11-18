@extends('layouts.dash')

@section('content')

    {{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="crossorigin="anonymous"></script> --}}
<script src="{{asset('pluto/js/addJs/jquery-3.7.0.min.js')}}" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="crossorigin="anonymous"></script>    
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">LIST OF CUSTOMERS</h2>

                                {{-- ADD EMPLOYEE BUTTON --}}
                                <button type="button" onclick="openModal()" class="btn btn-dark submit enlarge-on-hover" style="width: 160px;margin-left:850px; float: right; margin-top:-28px;"><i class="fa fa-plus"></i> Add Customer</button>
                                
                                {{-- MODAL SCRIPT --}}
                                <script>
                                    function openModal(){
                                        $('#addCustomerLabel').html('<i class="fa fa-user-plus"></i> Add New Consumer');
                                        $('#addCustomer').modal('show');
                                    }
                                </script>
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
                            <table id="superAdmincustomer_table" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th style="flex: 1; white-space: nowrap;">Account ID</th>
                                        <th style="width: 100px !important;">Name</th>
                                        <th>Location</th>
                                        <th style="width: 100px !important;">Meter</th>
                                        <th>Status</th>
                                        <th class="action">Tools</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- MODAL CONTENT --}}
      
            <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="    margin-top: -15px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCustomerLabel"></h5>
                        
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body-add">
                            <div id="showing"></div>
                            <div class="login_form" style="padding: 0px 30px !important;">
                                
                                <form style="background-color:white;">
                                        @csrf
                                    <div class="row mt-4 mb-3">
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-user"></i> Name</label>
                                            <input id="customerName" type="text" class="form-control capitalize" name="customerName" placeholder="First name, Last name, Middlename" required>
                                            <span id="customerName-error" style="color:red" class="is-invalid" role="alert"></span>
                                            </div>
                                        <div class="col-md-6">
                                        
                                            <label for="input" style="color: black;"><i class="fa fa-tachometer"></i> Meter</label>
                                            <select class="form-control form-select placement-dropdown" id="meter" name="meter" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Meter</option>
                                                @php
                                                $categories = DB::table('libraries')->get();
                                            @endphp

                                            @foreach ($categories as $category)
                                            @if ($category->category === 'Meter')
                                                @php
                                                    $cleanedName = str_replace('-', ' ', $category->categoryaddedName);
                                                @endphp
                                                <option value="{{ $category->categoryaddedName }}">{{ $cleanedName }}</option>
                                            @endif
                                            @endforeach
                                               
                                            </select>
                                            <span id="meter-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                 
                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-calendar"></i> Connection Date</label>
                                            <input id="connectionDate" type="date" class="form-control" name="connectionDate" required>
                                            <span id="connectionDate-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-star"></i> Rate Case</label>
                                            <select class="form-control form-select placement-dropdown" id="rate_case" name="rate_case" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Rate CAse</option>
                                                @php
                                                    $categories = DB::table('libraries')->get();
                                                @endphp

                                                @foreach ($categories as $category)
                                                    @if ($category->category === 'Rate Case')
                                                        <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span id="rate_case-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-cube"></i> Classification</label>
                                            <select class="form-control form-select placement-dropdown" id="classification" name="classification" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Classification</option>
                                                @php
                                                $categories = DB::table('libraries')->get();
                                            @endphp

                                            @foreach ($categories as $category)
                                                @if ($category->category === 'Classification')
                                                    <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            <span id="classification-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-cubes"></i> Cluster</label>
                                            <select class="form-control form-select placement-dropdown" id="cluster" name="cluster" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Cluster</option>
                                                @php
                                                    $categories = DB::table('libraries')->get();
                                                @endphp

                                                @foreach ($categories as $category)
                                                    @if ($category->category === 'Cluster')
                                                        <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                    @endif
                                                @endforeach
                                               
                                            </select>
                                            <span id="cluster-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                            <label for="input" style="color: black;"><i class="fa fa-user"></i> Consumer Name (Optional)</label>
                                            <input id="consumerName2" type="text" class="form-control capitalize" name="consumerName2" placeholder="Enter Address" required>
                                            <span id="consumerName2-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-arrows-rotate"></i> Trade</label>
                                            <select class="form-control form-select placement-dropdown" id="trade1" name="trade1" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Trade</option>
                                                @php
                                                $categories = DB::table('libraries')->get();
                                            @endphp

                                            @foreach ($categories as $category)
                                                @if ($category->category === 'Trade')
                                                    <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                @endif
                                            @endforeach
                                               
                                            </select>
                                            <span id="trade-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-user"></i> Concessioner Name (Optional)</label>
                                            <input id="concessionerName" type="text" class="form-control capitalize" name="concessionerName" placeholder="Enter Address" required>
                                            <span id="concessionerName-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-arrows-rotate"></i> Trade</label>
                                            <select class="form-control form-select placement-dropdown" id="trade2" name="trade2" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Trade</option>
                                                @php
                                                $categories = DB::table('libraries')->get();
                                            @endphp

                                            @foreach ($categories as $category)
                                                @if ($category->category === 'Trade')
                                                    <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            <span id="trade-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <label for="input" style="color: black;padding-left: 15px;"><i class="fa fa-location"></i> Location</label>
                                        <div class="input-group col-md-12 mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">Region</i>
                                            </span>
                                        </div>
                                            <select class="form-control" name="region" id="region" on="getProvince(this);" style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;" @readonly(true)>
                                                <option value="Region X" selected>Region X</option>
                                            </select>
                                            
                                        </div>
                                        <div class="input-group col-md-12 mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">Province</i>
                                            </span>
                                        </div>
                                            <select name="Province" class="form-control" id="Province" style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;" @readonly(true)>
                                                <option value="Misamis Oriental" selected>Misamis Oriental</option>
                                            </select>
                                        </div>
                                        <div class="input-group col-md-12 mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">Municipality</i>
                                                </span>
                                            </div>
                                            <select name="municipality" class="form-control" id="municipality" style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;">
                                                <option value="" disabled selected>Select Municipality</option>
                                                <option value="Naawan">Naawan</option>
                                                <option value="Manticao">Manticao</option>
                                                <option value="Lugait">Lugait</option>
                                            </select>
                                        </div>
                                            <span id="municipality-error" style="color:red; padding-left:18px; margin-top: -5px; margin-bottom:10px;" class="is-invalid" role="alert"></span>
                                        <div class="input-group col-md-12 mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons"  style="padding-bottom: 4px">Barangay</i>
                                                </span>
                                            </div>
                                            <input type="text" name="barangay"  id="barangay" class="form-control p-2" placeholder="Enter Barangay" value="{{ old('name') }}" required style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;">
                                        </div>
                                            <span id="barangay-error" style="color:red; padding-left:18px;margin-top: -5px; margin-bottom:10px;" class="is-invalid" role="alert"></span>
                                        <div class="input-group col-md-12 mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons"  style="padding-bottom: 4px">Purok</i>
                                                </span>
                                            </div>
                                                <input type="text" name="purok"  id="purok" class="form-control p-2" placeholder="Enter Purok" value="{{ old('name') }}" required style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;">
                                        </div>          
                                            <span id="purok-error" style="color:red; padding-left:18px;margin-top: -5px; margin-bottom:10px;" class="is-invalid" role="alert"></span>   
                                    </div>       
                                </form>
                            </div>
                        </div>

                        <div class="modal-footer" style="margin-right: 30px;">
                            <button type="button" class="btn btn-secondary enlarge-on-hover" data-dismiss="modal">Close</button>
                            <button type="button" id="create-btn" class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i> Submit</button>
                        </div>
                        {{-- CAPITALIZED OF THE FIRST LETTER IN THE INPUTS --}}
                        <script>
                            document.querySelectorAll('.capitalize').forEach(function (input) {
                                input.addEventListener('input', function () {
            
                                    var inputValue = input.value;
                                    var capitalizedValue = inputValue.charAt(0).toUpperCase() + inputValue.slice(1).toLowerCase();
                                    
                                    input.value = capitalizedValue;
                                });
                            });
                        </script>
                    </div>

                {{-- VALIDATION SCRIPT --}}
                <script>
                    

                    var inputFields = document.querySelectorAll("input,select");
                        inputFields.forEach(function(input) {
                            input.classList.add("input-default");
                        });

                       $('#create-btn').on('click', function(e){
                   
                        if (validateForm()) {
                                var customerform = {
                                    
                                    'id': $('#hidden_id').val(),
                                    // 'account_id': $('#account_id').val(),
                                    'customerName': $('#customerName').val(),
                                    'connectionDate': $('#connectionDate').val(),
                                    'rate_case': $('#rate_case').val(),
                                    'classification': $('#classification').val(),
                                    'cluster': $('#cluster').val(),
                                    'consumerName2': $('#consumerName2').val(),
                                    'trade1': $('#trade1').val(),
                                    'concessionerName': $('#concessionerName').val(),
                                    'trade2': $('#trade2').val(),
                                    'meter': $('#meter').val(),
                                    
                                    'region': $('#region').val(),
                                    'municipality': $('#municipality').val(),
                                    'barangay': $('#barangay').val(),
                                    'purok': $('#purok').val(),
                                    'Province': $('#Province').val(),
                                
                                    
                                };

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $.ajax({
                                    type: 'post',
                                    url: 'register',
                                    data: customerform,
                                    dataType: 'json',
                                    success: function (response) {
                                        $('#municipality').val(''),
                                        $('#trade1').val(''),
                                        $('#trade2').val(''),
                                        $('#classification').val(''),
                                        $('#rate_case').val(''),
                                        $('#customerName').val(''),
                                        $('#connectionDate').val(''),
                                        $('#cluster').val(''),
                                        $('#consumerName2').val(''),
                                     
                                        $('#concessionerName').val(''),   
                                        $('#barangay').val(''),
                                        $('#purok').val(''),
                                      
                                        Swal.fire({
                                            title: 'Successfully Registered',
                                            text: 'Successfully Registered For Meedo Water System',
                                            icon: 'success',
                                        });
                                        $('#superAdmincustomer_table').DataTable().ajax.reload();
                                    },
                                    error: function (xhr) {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'An error occurred while creating the account.',
                                            icon: 'error',
                                        });
                                    }
                                });
                            }
                            
                       });

                        function validateForm() {
                            // var account_id = document.getElementById("account_id");
                            var customerName = document.getElementById("customerName");
                            var connectionDate = document.getElementById("connectionDate");
                            var rate_case = document.getElementById("rate_case");
                            var classification = document.getElementById("classification"); 
                            var cluster = document.getElementById("cluster");
                         
                            // var consumerName2 = document.getElementById("consumerName2");
                            // var concessionerName = document.getElementById("concessionerName");
                            var meter = document.getElementById("meter");
                            var municipality = document.getElementById("municipality");
                            var barangay = document.getElementById("barangay");
                            var purok = document.getElementById("purok");
                            var isValid = true;
                    
                            clearErrorMessages();
                    
                            // if (account_id.value.trim() === "") {
                            //     displayError("account_id", "Account ID is required.");
                            //     isValid = false;
                            // }
                    
                            if (customerName.value.trim() === "") {
                                displayError("customerName", "Customer's Name is required.");
                                isValid = false;
                            }
                    
                            if (connectionDate.value === "") {
                                displayError("connectionDate", "Connection Date is required.");
                                isValid = false;
                            }
                           
                    
                            if (rate_case.value === "") { 
                                displayError("rate_case", "Rate Case is required.");
                                isValid = false;
                            }
                    
                            if (classification.value === "") { 
                                displayError("classification", "Classification is required.");
                                isValid = false;
                            }
                    
                            if (cluster.value === "") {
                                displayError("cluster", "Cluster is required.");
                                isValid = false;
                            }
                    
                            // if (consumerName2.value === "") {
                            //     displayError("consumerName2", "Consumer Name is required.");
                            //     isValid = false;
                            // }
                    
                            // if (concessionerName.value === "") {
                            //     displayError("concessionerName", "Concessioner Name is required.");
                            //     isValid = false;
                            // }

                            if (meter.value === "") {
                                displayError("meter", "Meter is required");
                                isValid = false;
                            }

                            if (municipality.value.trim() === "") {
                                displayError("municipality", "Municipality Status is required.");
                                isValid = false;
                            }

                            if (barangay.value.trim() === "") {
                                displayError("barangay", "Barangay Status is required.");
                                isValid = false;
                            }

                            if (purok.value.trim() === "") {
                                displayError("purok", "Purok Status is required.");
                                isValid = false;
                            }

                    
                            return isValid;
                        }
                    
                        function displayError(fieldId, errorMessage) {
                            var errorElement = document.getElementById(fieldId + "-error");
                            errorElement.textContent = errorMessage;

                            var inputField = document.getElementById(fieldId);
                            inputField.classList.remove("input-default");
                            inputField.classList.add("input-error");

                            inputField.scrollIntoView({ behavior: "smooth", block: "center" });
                        }

                            inputFields.forEach(function(input) {
                                input.addEventListener("input", function() {
                                    input.classList.remove("input-error");
                                });
                            });
                    
                        function clearErrorMessages() {
                            var errorElements = document.querySelectorAll(".is-invalid");
                            errorElements.forEach(function(element) {
                                element.textContent = "";
                            });

                        }
                        // for customer list in superadmin view
                        $(document).ready(function() {
                        $('#superAdmincustomer_table').DataTable({
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
                                        ajax: "{{ route('superAdmincustomer.view') }}",
                                       
                                        columns: [
                                            
                                            {
                                                data: 'account_id',
                                                name: 'account_id',
                                                render: function(data) {
                                                    return '<div class="text-wrap">' + data + '</div>';
                                                }
                                            },
                                            {
                                                data: 'customerName',
                                                name: 'customerName',
                                                render: function(data) {
                                                    return '<div class="text-wrap"  style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                                }
                                            },
                                        
                                            {
                                                data: 'location',
                                                name: 'location',
                                                render: function(data) {
                                                    return '<div class="text-wrap"  >' + data + '</div>';
                                                }
                                            },
                                            {
                                                data: 'meter',
                                                name: 'meter',
                                                render: function(data) {
                                                  
                                                    return '<div class="text-wrap">' + data + '</div>';
                                                }
                                            },
                                            {
                                                data: 'status',
                                                name: 'status',
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
                                        order: [
                                            [4, 'asc'], 
                                        ],
                                      
                            });
                        });
                        function formatDate(dateString) {
                            const months = [
                                'January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November', 'December'
                            ];

                            const dateParts = dateString.split('-');
                            const year = dateParts[0];
                            const month = parseInt(dateParts[1]) - 1; 
                            const day = parseInt(dateParts[2]);

                            return `${months[month]} ${day}, ${year}`;
                        }

                    function viewSuperAdmincustomer(id) {
                       
                            $.ajax({
                                url: '/getCustomerInfo/' + id, 
                                method: 'GET',
                                success: function(data) {
                                 
                                    let statusText = "";
                                        if (data.status == 0) {
                                            statusText = '<span class="connected-status">Connected</span>';
                                        } else if (data.status == 2) {
                                            statusText = '<span class="disconnected-status">Disconnected</span>';
                                        }else if (data.status == 1) {
                                            statusText = '<span class="reconnected-status">Reconnected</span>';
                                        }
                                         else {
                                            statusText = '<span class="unknown-status">Unknown</span>';
                                        }
                                       
                                    $('#viewcustomer_superadminModal').modal('show');
                                    let updateStatusDateText = data.updatestatusDate ? formatDate(data.updatestatusDate) : 'No update status yet';
                                    $('.modal-body').html(`
                                    <div class="view-header mb-4" style="text-align:center">
                                        <h5>MUNICIPALITY OF NAAWAN</h5>
                                        <h5>PROVINCE OF MISAMIS ORIENTAL</h5>
                                        <h5>MUNICIPAL ECONOMIC ENTERPRISE AND DEVELOPMENT OFFICE</h5>
                                        <h6>Naawan Water System</h6>
                                        <div class="naawan-logo">
                                            <img class="image-responsive rounded-circle" style="position: absolute;top: 5px;height: 10%;width:10%;right: 10px;" src="{{ asset('pluto/images/logo/logo.jpg') }}" alt="Naawan Logo">
                                        </div>
                                    </div>
                                    <div class="search-result">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Account ID:</strong> <span style="color: black;">${data.account_id}</span></p>
                                                <p><strong>Customer Name:</strong> <span style="color: black;">${data.customerName}</span></p>
                                                <p><strong>Cluster:</strong> <span style="color: black;">${data.cluster}</span></p>
                                                <p><strong>Rate Case:</strong> <span style="color: black;">${data.rate_case}</span></p>
                                                <p><strong>Classification:</strong> <span style="color: black;">${data.classification}</span></p>
                                                <p><strong>Region:</strong> <span style="color: black;">${data.region}</span></p>
                                            
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Consumer Name 2:</strong> <span style="color: black;">${data.consumerName2}</span></p>
                                                <p>
                                                    <strong>Trade 1:</strong>
                                                    <span style="color: black;">
                                                        ${data.trade1 ? data.trade1 : 'No data inputted'}
                                                    </span>
                                                </p>

                                                <p>
                                                    <strong>Trade 2:</strong>
                                                    <span style="color: black;">
                                                        ${data.trade2 ? data.trade2 : 'No data inputted'}
                                                    </span>
                                                </p>
                                                <p><strong>Concessioner Name:</strong> <span style="color: black;">${data.concessionerName}</span></p>
                                                <p><strong>Meter:</strong> <span style="color: black;">${data.meter}</span></p>
                                              
                                             
                                                <p><strong>Connection Date:</strong> <span style="color: black;">${data.connectionDate}</span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Province:</strong> <span style="color: black;">${data.Province}</span></p>
                                                <p><strong>Municipality:</strong> <span style="color: black;">${data.municipality}</span></p>
                                                <p><strong>Barangay:</strong> <span style="color: black;">${data.barangay}</span></p>
                                                <p><strong>Purok:</strong> <span style="color: black;">${data.purok}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Status:</strong> <span style="color: black;">${statusText}</span></p>
                                                <p><strong>Update Date Status:</strong> <span style="color: black;">${updateStatusDateText}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                `);
                               

                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error ',
                                        text : 'Error in adding category',
                                        icon: 'error',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            });
                        }
                </script>
                  
                {{-- modal for view customer list in superadmin --}}
                <style>
                    .search-result {
                        padding: 15px;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                        background-color: #f8f8f8;
                        color: #333;
                    }

                    /* Style for strong tags */
                    .search-result strong {
                        font-weight: bold;
                        color: #555;
                    }
                </style>
                </div>
            </div>   
        </div>        
    </div>

    {{-- VIEW MODAL --}}
    <div class="modal fade" id="viewcustomer_superadminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i> Customer Information</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p><strong>Customer Name:</strong> <span id="customerName"></span></p>
                <p><strong>Connection Date:</strong> <span id="connectionDate"></span></p>  
            </div>
            <div id="printContent" style="display: none;"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="exportExcelButton" data-dismiss="modal">Close</button>
              <button type="button" class="btn" style="background-color: #4b5ab1; color:white;" id="printButton"><i class="fa fa-print"></i> PDF</button>
            </div>
          </div>
        </div>
    </div>
    {{-- PRINT AND EXCEL BUTTON SCRIPT --}}
    <script>
            $('#printButton').on('click', function() {
                const modalBodyContent = $('.modal-body').html();
                const printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Customer Information</title>
                    </head>
                    <body>
                        ${modalBodyContent}
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
        });
        $('#exportExcelButton').on('click', function() {
            const modalBodyContent = $('.modal-body').html();
            const worksheet = XLSX.utils.table_to_sheet($('<table>').append(modalBodyContent));
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'CustomerInformation');
            const excelBlob = XLSX.write(workbook, { bookType: 'xlsx', type: 'blob' });

            // Create a download link for the Excel file
            const excelFileName = 'customer_information.xlsx';
            const downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(excelBlob);
            downloadLink.download = excelFileName;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        });
    </script>
    {{-- MODAL FOR EDIT USER INFO --}}
    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin-top: -15px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerLabel"></h5>
                
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body-edit">
                
                    <div class="login_form" style="padding: 0px 30px !important;">
                        
                        <form style="background-color:white;">
                                @csrf
                            <div class="row mt-4 mb-3">
                                <div class="col-md-6">
                                <label for="input" style="color: black;"><i class="fa fa-user"></i> Account No</label>
                                <input id="edit_account_id" readonly type="text" class="form-control" name="edit_account_id" placeholder="Enter Account ID" required>
                            
                                </div>
                                <div class="col-md-6">
                                <label for="input" style="color: black;"><i class="fa fa-user"></i> Name</label>
                                <input id="edit_customerName" type="text" class="form-control" name="edit_customerName" placeholder="Enter Customer's Name" required>
                                
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-calendar"></i> Connection Date</label>
                                    <input id="edit_connectionDate" type="date" class="form-control" name="edit_connectionDate" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-star"></i> Rate Case</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_rate_case" name="edit_rate_case" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Rate CAse</option>
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

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-cube"></i> Classification</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_classification" name="edit_classification" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Classification</option>
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
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-cubes"></i> Cluster</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_cluster" name="edit_cluster" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Cluster</option>
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

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-user"></i> Consumer Name</label>
                                    <input id="edit_consumerName2" type="text" class="form-control" name="edit_consumerName2" placeholder="Enter Address" required>
                                
                                </div>
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-arrows-rotate"></i> Trade</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_trade1" name="edit_trade1" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Trade</option>
                                        @php
                                        $categories = DB::table('libraries')->get();
                                        @endphp

                                        @foreach ($categories as $category)
                                            @if ($category->category === 'Trade')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-user"></i> Concessioner Name</label>
                                    <input id="edit_concessionerName" type="text" class="form-control" name="edit_concessionerName" placeholder="Enter Address" required>
                                
                                </div>
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-arrows-rotate"></i> Trade</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_trade2" name="edit_trade2" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Trade</option>
                                        @php
                                        $categories = DB::table('libraries')->get();
                                        @endphp

                                        @foreach ($categories as $category)
                                            @if ($category->category === 'Trade')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label for="input" style="color: black;"><i class="fa fa-tachometer"></i> Meter</label>
                                    <select class="form-control form-select placement-dropdown" id="edit_meter" name="edit_meter" required autocomplete="role">
                                        <option value="" disabled selected>Select type of Meter</option>
                                        @php
                                        $categories = DB::table('libraries')->get();
                                        @endphp

                                        @foreach ($categories as $category)
                                            @if ($category->category === 'Meter')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                              
                            </div>
                            <div class="row mb-3" >
                                <label for="input" style="color: black;padding-left: 15px;"><i class="fa fa-location"></i> Location</label>
                                <div class="input-group col-md-12 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">Region</i>
                                    </span>
                                </div>
                                    <select class="form-control" name="edit_region" id="edit_region" style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;" @readonly(true)>
                                        <option value="Region X" selected>Region X</option>
                                    </select>
                                    
                                </div>
                                <div class="input-group col-md-12 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">Province</i>
                                    </span>
                                </div>
                                    <select name="edit_Province" class="form-control" id="edit_Province" style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;" @readonly(true)>
                                        <option value="Misamis Oriental" selected>Misamis Oriental</option>
                                    </select>
                                </div>
                                <div class="input-group col-md-12 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">Municipality</i>
                                        </span>
                                    </div>
                                    <select name="edit_municipality" class="form-control" id="edit_municipality" style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;">
                                        <option value="" disabled selected>Select Municipality</option>
                                        <option value="Naawan">Naawan</option>
                                        <option value="Manticao">Manticao</option>
                                        <option value="Lugait">Lugait</option>
                                    </select>
                                </div>
                                
                                <div class="input-group col-md-12 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons"  style="padding-bottom: 4px">Barangay</i>
                                        </span>
                                    </div>
                                    <input type="text" name="edit_barangay"  id="edit_barangay" class="form-control p-2" placeholder="Enter Barangay" value="{{ old('name') }}" required style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;">
                                </div>
                                
                                <div class="input-group col-md-12 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons"  style="padding-bottom: 4px">Purok</i>
                                        </span>
                                    </div>
                                        <input type="text" name="edit_purok"  id="edit_purok" class="form-control p-2" placeholder="Enter Purok" value="{{ old('name') }}" required style="max-width: 100% !important; border:solid 1px #d9d8d9; border-radius: 3px;">
                                </div>          
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-exclamation-circle green_color"></i> Customer Status</label>
                                    <select class="form-control form-select placement-dropdown" id="status" name="status" required autocomplete="status">
                                        <option value="0">CONNECTED</option>
                                        <option value="1">RECONNECTED</option>
                                        <option value="2">DISCONNECTED</option>
                                    </select>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const statusDropdown = document.getElementById("status");
                                        
                                        statusDropdown.addEventListener("change", function() {
                                            const selectedValue = this.value;
                                            Swal.fire({
                                                title: "REMINDER ONLY",
                                                text: "You are about to change the status of this customer,double check before you click the update button",
                                                icon: "warning",
                                            
                                                confirmButtonText: "OK",
                                                
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    
                                                } else {
                                                
                                                    this.value = selectedValue;
                                                }
                                            });
                                        });
                                    });

                                </script>
                                <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-calendar"></i> Update status Date</label>
                                    <input id="updatestatusDate" type="date" class="form-control" name="updatestatusDate" required placeholder="No date Update Yet!">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer" style="margin-right: 30px;">
                    <button type="button" class="btn btn-secondary enlarge-on-hover" data-dismiss="modal">Close</button>
                
                    <button type="button" id="update-btn" class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- script for edit customer in super admin --}}
    <script>

        // Initialize options visibility based on default status
        
        function editSuperAdmincustomer(id){
        

            $('#editCustomer').modal('show');
            $('#editCustomerLabel').html('<i class="fa fa-edit"></i> Edit Customer Information');
            $('#update-btn').text('Update Info');
                        
                        
                $.ajax({
                    url: "/customersuperAdmin/edit/" + id + "/",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        var defaultStatus = $('#status').val(data.result.status); 
                        if (defaultStatus === '0') {
                            $('#status option[value="2"]').show(); 
                            $('#status option[value="1"]').hide(); 
                            $('#status option[value="0"]').hide(); 
                        } else if (defaultStatus === '2') {
                            $('#status option[value="1"]').show(); 
                            $('#status option[value="0"]').hide(); 
                            $('#status option[value="2"]').hide(); 
                        } else if (defaultStatus === '1') {
                            $('#status option[value="1"]').hide(); 
                            $('#status option[value="2"]').show(); 
                            $('#status option[value="0"]').hide(); 
                        }

                        $('#status').on('change', function () {
                            var selectedStatus = $(this).val();

                            if (selectedStatus === '0') {
                                $('#status option[value="2"]').show(); 
                                $('#status option[value="1"]').hide(); 
                                $('#status option[value="0"]').hide();
                            } else if (selectedStatus === '2') {
                                $('#status option[value="1"]').show(); 
                                $('#status option[value="0"]').hide(); 
                                $('#status option[value="2"]').hide();
                            } else if (selectedStatus === '1') {
                                $('#status option[value="1"]').hide(); 
                                $('#status option[value="2"]').show(); 
                                $('#status option[value="0"]').hide(); 
                            }

                            var currentTime = new Date().toISOString().slice(0, 10); 
                            $('#updatestatusDate').val(currentTime);
                        });

                        $('#status').trigger('change'); 
                
                        $('#edit_customerName').val(data.result.customerName);
                        $('#edit_account_id').val(data.result.account_id);
                    
                        $('#edit_connectionDate').val(data.result.connectionDate);
                        $('#edit_rate_case').val(data.result.rate_case);
                        $('#edit_classification').val(data.result.classification);
                        $('#edit_cluster').val(data.result.cluster);
                        $('#edit_consumerName2').val(data.result.consumerName2);
                        $('#edit_trade1').val(data.result.trade1);
                        $('#edit_concessionerName').val(data.result.concessionerName);
                        $('#edit_trade2').val(data.result.trade2);
                        $('#edit_meter').val(data.result.meter);
                        $('#edit_region').val(data.result.region);
                        $('#edit_Province').val(data.result.Province);
                        $('#edit_municipality').val(data.result.municipality);
                        $('#edit_barangay').val(data.result.barangay);
                        $('#edit_purok').val(data.result.purok);
                        $('#status').val(data.result.status);
                        $('#updatestatusDate').val(data.result.updatestatusDate);
                        $('#edit-btn').val('Update');
                        $('#action').val('Edit');
                        $('#editEmployee').modal('show');
                    
                        $('#update-btn').off('click').on('click', function () {
                            customerupdate(id);
                        });
                    },
                
                });
            }
                //update
                function customerupdate(id) {
                            var customerform = {
                                'id': id,
                                'account_id': $('#edit_account_id').val(),
                                'customerName': $('#edit_customerName').val(),
                                'connectionDate': $('#edit_connectionDate').val(),
                                'rate_case': $('#edit_rate_case').val(),
                                'classification': $('#edit_classification').val(),
                                'cluster': $('#edit_cluster').val(),
                                'consumerName2': $('#edit_consumerName2').val(),
                                'trade1': $('#edit_trade1').val(),
                                'trade2': $('#edit_trade2').val(),
                                'concessionerName': $('#edit_concessionerName').val(),
                                'meter': $('#edit_meter').val(),
                                'region': $('#edit_region').val(),
                           
                                'municipality': $('#edit_municipality').val(),
                                'barangay': $('#edit_barangay').val(),
                                'purok': $('#edit_purok').val(),
                                'Province': $('#edit_Province').val(),
                                'status': $('#status').val(),
                                'updatestatusDate': $('#updatestatusDate').val(),
                            };

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'post',
                                url: 'customersuperAdmin/update',
                                data: customerform,
                                dataType: 'json',
                                success: function (response) {
                                $('#superAdmincustomer_table').DataTable().ajax.reload();
                                Swal.fire({
                                    title: 'Successfully Updated',
                                    text: 'This Customer Information Is Now Updated',
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

                        //delete customer in superadmin
                        function superadminDeletecustomer(id){
                            
                            Swal.fire({
                                title: 'You wont able to restore this Customer ?',
                                text: "Please check carefully if this is the customer you want to delete",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    deleteUser(id);
                                } else {
                                    Swal.fire(
                                        'Deletion canceled',
                                        'This Customer was not deleted.',
                                        'info'
                                    )
                                }
                            });
                        }

                        function deleteUser(id) {
                            
                            $.ajax({
                            
                                url: "{{ url('superadmincustomerdelete/') }}/" + id,
                                type: 'DELETE',
                                
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                
                                success: function(response) {
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'The customer has been deleted.',
                                        'success'
                                    ).then(() => {

                                        $('#superAdmincustomer_table').DataTable().ajax.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the user.',
                                        'error'
                                    );
                                }
                            });
                        
                        }
        
    </script>
    {{-- PESO SIGN IN CUBIC METER AMOUNT INPUT --}}
    <script>
        var inputElement = document.getElementById('watershed');
    
        inputElement.addEventListener('input', function() {
        var inputValue = inputElement.value;
    
        if (!inputValue.startsWith('₱')) {
            inputElement.value = '₱ ' + inputValue;
        }
        });
    </script>
  
@endsection