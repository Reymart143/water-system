@extends('layouts.dash')

@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column1">
            <div class="col-md-2"></div>
                <div class="col-md-12 mt-4">
                    <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                        <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                            <h2 class="mt-1" style="color: white !important;">CATEGORY LIST</h2>
                            {{-- ADD EMPLOYEE BUTTON --}}
                            <button type="button" onclick="openModal()" class="btn btn-dark submit enlarge-on-hover" style="width: 160px;margin-left:850px; float: right; margin-top:-28px;"><i class="fa fa-plus"></i> Add Categories</button>
                            
                            {{-- MODAL SCRIPT --}}
                            <script>
                                function openModal(){
                                    $('#addCategoryLabel').html('<i class="fa fa-plus"></i> Add Category');
                                    $('#addCategory').modal('show');
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
                        <table id="addedlibrary_table" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th class="action">Action</th>
                                </tr>
                            </thead>
                        </table>
                        
                    </div>
                   
                </div>
            </div>
        </div>
        
        {{-- MODAL CONTENT --}}
      
        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryLabel"></h5>
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div id="showing"></div>
                        <div style="padding: 0px 30px !important;">
                            
                                <form id="categoryForm" style="background-color:white;">
                                    @csrf
                                    <div class="row mt-4 mb-3">
                                        <div class="col-md-12">
                                            <label for="input" style="color: black;"><i class="fa fa-qrcode"></i> Category</label>
                                            <select  class="form-control form-select placement-dropdown" id="category" name="category" required autocomplete="role" onchange="handleCategoryChange()">
                                                <option value="" disabled selected>Select type of Category</option>
                                                <option value="Rate Case">Rate Case</option>
                                                <option value="Classification">Classification</option>
                                                <option value="Cluster">Cluster</option>
                                                
                                                <option value="Trade">Trade</option>
                                                <option value="Meter Brand">Name of Brand Meter</option>
                                                <option value="Meter" href="#" data-toggle="tooltip" data-placement="bottom" title="Add Meter Brand First">Meter</option>
                                                <option value="Collector">Collector</option>
                                                <option value="Reader">Reader</option>
                                                <option value="Miscellaneous">Miscellaneous Item</option>
                                            
                                            </select>
                                            <span id="rate-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="row" name="forCategory" id="forCategory"  style="display: none;">
                                        <div class="col-md-12">
                                            <label for="input" style="color: black;"><i class="fa fa-qrcode"></i> Name</label>
                                            <input id="categoryaddedName" type="text" class="form-control capitalize" name="categoryaddedName" required>
                                            <span id="categoryaddedName-error" style="color:red" class="is-invalid" role="alert"></span>
                                            <span id="categoryaddedName-error" style="color: red; display: none;" class="is-invalid" role="alert">Please input this field</span>
                                            <span id="categoryaddedName-success" style="color: green; display: none;" class="is-valid" role="alert"><i class="fa fa-check-circle"></i> Review your input fields</span>
                                        </div>
                                      
                                    </div>
                                    <div class="row" name="forAddedMeter" id="forAddedMeter" style="display: none;">
                                    
                                        <div class="col-md-12">
                                            <label for="meterBrand" style="color: black;"><i class="fa fa-tachometer"></i> Brand Name</label>
                                            <select class="form-control form-select placement-dropdown" id="meterBrand" name="meterBrand" required autocomplete="role">
                                                <option value="" disabled selected>Select type of Meter Brand Name</option>
                                                @php
                                                $categories = DB::table('libraries')->get();
                                            @endphp

                                            @foreach ($categories as $category)
                                                @if ($category->category === 'Meter Brand')
                                                    <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            <span id="meterBrand-error" style="color: red; display: none;" class="is-invalid" role="alert">Please select a Meter Brand</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="meterSerialNum" style="color: black;"><i class="fa fa-barcode"></i> Serial Number</label>
                                            <input id="meterSerialNum" type="text" class="form-control" name="meterSerialNum" required>
                                            <span id="meterSerialNum-error" style="color: red" class="is-invalid" role="alert"></span>
                                            <span id="meterSerialNum-error" style="color: red; display: none;" class="is-invalid" role="alert">Please input this field</span>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    // Get the input elements
                                    const categoryaddedNameInput = document.getElementById("categoryaddedName");
                                    const meterBrandInput = document.getElementById("meterBrand");
                                    const meterSerialNumInput = document.getElementById("meterSerialNum");
                                
                                    // Input formatting for the "Name" field
                                    categoryaddedNameInput.addEventListener("input", function() {
                                        let inputValue = categoryaddedNameInput.value;
                                        let capitalizedValue = inputValue.charAt(0).toUpperCase() + inputValue.slice(1).toLowerCase();
                                        categoryaddedNameInput.value = capitalizedValue;
                                    });
                                
                                    // Validation for the "Name" field
                                    categoryaddedNameInput.addEventListener("blur", function() {
                                        if (categoryaddedNameInput.value.trim() === "") {
                                            document.getElementById("categoryaddedName-error").style.display = "block";
                                            document.getElementById("categoryaddedName-success").style.display = "none";
                                            categoryaddedNameInput.style.borderColor = "red";
                                        } else {
                                            document.getElementById("categoryaddedName-error").style.display = "none";
                                            document.getElementById("categoryaddedName-success").style.display = "block";
                                            categoryaddedNameInput.style.borderColor = "green";
                                        }
                                    });
                                
                                    // Validation for the "Brand Name" field
                                    meterBrandInput.addEventListener("blur", function() {
                                        if (meterBrandInput.value === "") {
                                            document.getElementById("meterBrand-error").style.display = "block";
                                            meterBrandInput.style.borderColor = "red";
                                        } else {
                                            document.getElementById("meterBrand-error").style.display = "none";
                                            meterBrandInput.style.borderColor = "green";
                                        }
                                    });
                                
                                    // Validation for the "Serial Number" field
                                    meterSerialNumInput.addEventListener("blur", function() {
                                        if (meterSerialNumInput.value.trim() === "") {
                                            document.getElementById("meterSerialNum-error").style.display = "block";
                                            meterSerialNumInput.style.borderColor = "red";
                                        } else {
                                            document.getElementById("meterSerialNum-error").style.display = "none";
                                            meterSerialNumInput.style.borderColor = "green";
                                        }
                                    });
                                </script>
                                
                                <form action="">
                                    @csrf
                                    <div class="row" name="forAddedMicel" id="forAddedMicel" style="display: none;">
                                        <div class="col-md-12">
                                            <input type="hidden" id="hidden_id" value="id">
                                            <label for="meterBrand" style="color: black;"><i class="fa fa-person"></i> Miscellaneous Name</label>
                                            <input class="form-control" id="miscellaneous_name" name="miscellaneous_name" required>
                                            <span id="miscellaneous_name-error" style="color: red; display: none;" class="is-invalid" role="alert">Please input this field</span>
                                            <span id="miscellaneous_name-success" style="color: green; display: none;" class="is-valid" role="alert"><i class="fa fa-check-circle"></i> Review your input fields</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="meterSerialNum" style="color: black;"><i class="fa fa-money"></i> Amount</label>
                                            <input id="amount" type="text" class="form-control" name="amount" required>
                                            <span id="amount-error" style="color: red; display: none;" class="is-invalid" role="alert">Please input a valid amount</span>
                                            <span id="amount-success" style="color: green; display: none;" class="is-valid" role="alert"><i class="fa fa-check-circle"></i> After done input amount just Tap Anywhere</span>
                                        </div>
                                    </div>
                                    <script>
                                        const miscellaneousNameInput = document.getElementById("miscellaneous_name");
                                        const amountInput = document.getElementById("amount");
                                
                                        miscellaneousNameInput.addEventListener("input", function() {
                                            const inputValue = miscellaneousNameInput.value;
                                            const errorSpan = document.getElementById("miscellaneous_name-error");
                                            const successSpan = document.getElementById("miscellaneous_name-success");
                                
                                            if (inputValue.trim() === "") {
                                                errorSpan.style.display = "block";
                                                successSpan.style.display = "none";
                                            } else {
                                                errorSpan.style.display = "none";
                                                successSpan.style.display = "block";
                                            }
                                        });
                                
                                        amountInput.addEventListener("input", function() {
                                            const inputValue = amountInput.value;
                                            const errorSpan = document.getElementById("amount-error");
                                            const successSpan = document.getElementById("amount-success");
                                
                                            if (inputValue.trim() === "") {
                                                errorSpan.style.display = "block";
                                                successSpan.style.display = "none";
                                            } else {
                                                if (/^-?\d*\.?\d+$/.test(inputValue) && parseFloat(inputValue) >= 0) {
                                                    errorSpan.style.display = "none";
                                                    successSpan.style.display = "block";
                                                } else {
                                                    errorSpan.style.display = "block";
                                                    successSpan.style.display = "none";
                                                }
                                            }
                                        });
                                
                                        amountInput.addEventListener("blur", function() {
                                            let inputValue = this.value;
                                
                                            if (/^-?\d*\.?\d+$/.test(inputValue) && parseFloat(inputValue) >= 0) {
                                                let formattedValue = parseFloat(inputValue).toFixed(2);
                                                this.value = formattedValue;
                                            }
                                        });
                                    </script>
                                </form>
                                
                           
                        </div>
                    </div>
                    <script>
                        document.querySelectorAll('.capitalize').forEach(function (input) {
                        input.addEventListener('input', function () {
                       
                            var inputValue = input.value;

                            
                            var capitalizedValue = inputValue.charAt(0).toUpperCase() + inputValue.slice(1).toLowerCase();

                           
                            input.value = capitalizedValue;
                        });
                    });
                    </script>
                    <div class="modal-footer" style="margin-right: 30px;">
                        <button type="button" class="btn btn-secondary enlarge-on-hover" data-dismiss="modal">Close</button>
                        <button type="button" id="addcategory-btn" class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i> Save </button>
                        <button type="button" id="addmiscellaneous-btn" style="display:none" class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i> Add now </button>
                    </div>
                </div>

                <script>
                    function handleCategoryChange() {
                        var selectedValue = document.getElementById("category").value;
                        var forCategoryRow = document.getElementById("forCategory");
                        var forAddedMeterRow = document.getElementById("forAddedMeter");
                        var forAddedMicel = document.getElementById("forAddedMicel");
                        var addcategory_Btn = document.getElementById("addcategory-btn");
                        var addmiscellaneous_btn = document.getElementById("addmiscellaneous-btn");
                        
                        if (selectedValue === "Rate Case" || selectedValue === "Classification" || selectedValue === "Cluster" || selectedValue === "Trade" || selectedValue === "Collector" || selectedValue === "Meter Brand" || selectedValue === "Reader") {
                            forCategoryRow.style.display = "block";
                            forAddedMeterRow.style.display = "none";
                            forAddedMicel.style.display = "none";
                            addmiscellaneous_btn.style.display = "none";
                            addcategory_Btn.style.display = "block";
                        } else if (selectedValue === "Meter") {
                            forCategoryRow.style.display = "none";
                            forAddedMeterRow.style.display = "block";
                            forAddedMicel.style.display = "none";
                            addmiscellaneous_btn.style.display = "none";
                            addcategory_Btn.style.display = "block";

                            
                            $.ajax({
                                type: "GET",
                                url: '/noreload', 
                                dataType: "json",
                                success: function(response){
                                    var meterBrandDropdown = $("#meterBrand");
                                    meterBrandDropdown.empty(); 

                                    
                                    response.forEach(function(brandName) {
                                        meterBrandDropdown.append('<option value="' + brandName + '">' + brandName + '</option>');
                                    });
                                },
                                error: function(response){
                                    console.log('Error in fetching brand names');
                                }
                            });
                        }  else if(selectedValue === "Miscellaneous"){
                            forCategoryRow.style.display = "none";
                            forAddedMeterRow.style.display = "none";
                            forAddedMicel.style.display = "block";
                            addcategory_Btn.style.display = "none";
                            addmiscellaneous_btn.style.display = "block";

                            addmiscellaneous_btn.addEventListener('click', function (e) {
                                e.preventDefault();

                                    var hidden_id = document.getElementById("hidden_id").value;
                                    var miscellaneous_name = document.getElementById("miscellaneous_name").value;
                                    var amount = document.getElementById("amount").value;

                                    var itemForm = {
                                        'id': hidden_id,
                                        'miscellaneous_name': miscellaneous_name,
                                        'amount': amount
                                    };

                                    var xhr = new XMLHttpRequest();
                                    xhr.open("POST", "/add-miscell", true);
                                    xhr.setRequestHeader("Content-Type", "application/json");
                                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                                    xhr.onload = function () {
                                        if (xhr.status == 200) {
                                           
                                            document.getElementById("miscellaneous_name").value = '';
                                            document.getElementById("amount").value = '';

                                           
                                            document.getElementById("miscellaneous_name-error").style.display = "none";
                                            document.getElementById("miscellaneous_name-success").style.display = "none";
                                            document.getElementById("amount-error").style.display = "none";
                                            document.getElementById("amount-success").style.display = "none";

                                            Swal.fire({
                                                title: 'Successfully Added',
                                                text: 'Successfully Added Miscellaneous Item',
                                                icon: 'success',
                                            }).then(() => {
                                              
                                                setTimeout(function() {
                                                    document.getElementById("miscell_table").scrollIntoView({ behavior: 'smooth' });
                                                }, 500); 
                                            });

                                            document.querySelector('[data-dismiss="modal"]').click();

                                           
                                            $('#miscell_table').DataTable().ajax.reload();
                                        } else {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'Unsuccessfully Added Miscellaneous Item',
                                                icon: 'error',
                                            });
                                        }
                                    };

                                    xhr.send(JSON.stringify(itemForm));
                                });

                        
                           
                            }
                        else {
                            forCategoryRow.style.display = "none";
                            forAddedMeterRow.style.display = "none";
                            forAddedMicel.style.display = "none";
                           
                        }
                    }

                    
                </script>
                {{-- <script>
                        $('#addmiscellaneous-btn').on('click', function(e){
                                var itemForm = {
                                    'id': $('#hidden_id').val(),                   
                                    'miscellaneous_name': $('#miscellaneous_name').val(),
                                    'amount' : $('#amount').val()
                                };
                
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                 $.ajax({
                                type: "POST",
                                url: '/add-miscell', 
                                dataType: "json",
                                success: function(response){    
                                  alert('sucess');
                                },
                                error: function(response){
                                    console.log('Error in fetching brand names');
                                }
                            });

                            })
                </script> --}}
            </div>
        </div>  
    </div> 
    {{-- table for miscellaneous --}}
        <script>
             $(document).ready(function() {
                $('#miscell_table').DataTable({
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
                    ajax: "{{ route('addmiscell.view') }}",
                    order: [[1, 'desc']],

                    columns: [
                        {
                            data: 'miscellaneous_name',
                            name: 'miscellaneous_name',
                            render: function(data) {
                                return '<div class="text-wrap">' + data + '</div>';
                            }
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            render: function(data) {
                                return '<div class="text-wrap">' + data + '</div>';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
            function editMiscell(id){
                       
                    
                       $.ajax({
                           url: "/miscell/edit/" + id + "/",
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           dataType: "json",
                           success: function (data) {
                               $('#editmiscellaneous_name').val(data.result.miscellaneous_name)
                               $('#editamount').val(data.result.amount)
                            
                               $('#UpdateMiscell_btn').val('Update');
                               $('#action').val('Edit');
                               $('#editmiscellModal').modal('show');
                           
                               $('#UpdateMiscell_btn').off('click').on('click', function () {
                                   updateMiscellItem(id);
                               });
                           },
                           error: function (data) {
                               var errors = data.responseJSON;
                           }
                       });
                       }
                       function updateMiscellItem(id){
                           var updateItem = {
                               'id': id,
                               'miscellaneous_name': $('#editmiscellaneous_name').val(),
                               'amount': $('#editamount').val(),
                               
                       
                               
                           };
   
                           $.ajaxSetup({
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               }
                           });
   
                           $.ajax({
                               type: 'put',
                               url: 'MiscellItem/update',
                               data: updateItem,
                               dataType: 'json',
                               success: function (response) {
                               $('#miscell_table').DataTable().ajax.reload();
                               Swal.fire({
                                   title: 'Successfully Updated',
                                   text: 'This Miscellaneous Item Is Now Updated',
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
                       function miscellDelete(id) {
                           
                           Swal.fire({
                               title: 'Are you sure?',
                               text: "You won't be able to revert this!",
                               icon: 'warning',
                               showCancelButton: true,
                               confirmButtonColor: '#3085d6',
                               cancelButtonColor: '#d33',
                               confirmButtonText: 'Yes, delete it!'
                           }).then((result) => {
                               if (result.isConfirmed) {
                                   deleteItem(id);
                               } else {
                                   Swal.fire(
                                       'Deletion canceled',
                                       'The Miscellaneous item was not deleted.',
                                       'info'
                                   )
                               }
                           });
                       }
   
                       function deleteItem(id) {
                           
                           $.ajax({
                           
                               url: "{{ url('deleteItem/') }}/" + id,
                               type: 'DELETE',
                               
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                               
                               success: function(response) {
                                   
                                   Swal.fire(
                                       'Deleted!',
                                       'The Miscellaneous item has been deleted.',
                                       'success'
                                   ).then(() => {
   
                                       $('#miscell_table').DataTable().ajax.reload();
                                   });
                               },
                               error: function(xhr, status, error) {
                               
                                   Swal.fire(
                                       'Error!',
                                       'An error occurred while deleting the Miscellaneous item .',
                                       'error'
                                   );
                               }
                           });
                       }
        </script>
        {{-- edit modal in add category  --}}
        <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryLabel"><i class="fa fa-edit"></i> Edit category</h5>
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body-edit">
                        
                        <div style="padding: 0px 30px !important;">
                            
                            <form id="categoryForm" style="background-color:white;">
                                @csrf
                                <div class="row mt-4 mb-3">
                                    <div class="col-md-12">
                                        <label for="input" style="color: black;"><i class="fa fa-qrcode"></i> Category</label>
                                        <select  class="form-control form-select placement-dropdown" disabled id="edit_category" name="edit_category" required autocomplete="role" onchange="edit_handleCategoryChange()">
                                            <option value="" disabled selected>Select type of Category</option>
                                            <option value="Rate Case">Rate Case</option>
                                            <option value="Classification">Classification</option>
                                            <option value="Cluster">Cluster</option>
                                           
                                            <option value="Trade">Trade</option>
                                            <option value="Meter Brand">Add Meter Brand Name</option>
                                            <option value="Meter">Meter</option>
                                             <option value="Collector">Collector</option>
                                             <option value="Reader">Reader</option>
                                         
                                        </select>
                                        <span id="rate-error" style="color:red" class="is-invalid" role="alert"></span>
                                    </div>
                                </div>
                                <div class="row" name="edit_forCategory" id="edit_forCategory"  style="display: none;">
                                    <div class="col-md-12">
                                        <label for="input" style="color: black;"><i class="fa fa-qrcode"></i> Name</label>
                                        <input id="edit_categoryaddedName"  type="text" class="form-control" name="edit_categoryaddedName" required>
                                        <span id="categoryaddedName-error" style="color:red" class="is-invalid" role="alert"></span>
                                    </div>
                                </div>
                                <div class="row" name="edit_forAddedMeter" id="edit_forAddedMeter" style="display: none;">
                                  
                                    <div class="col-md-12">
                                        <label for="meterBrand" style="color: black;"><i class="fa fa-tachometer"></i> Brand Name</label>
                                        <select class="form-control form-select placement-dropdown" id="edit_meterBrand" name="edit_meterBrand" required autocomplete="role">
                                            <option value="" disabled selected>Select type of Meter Brand Name</option>
                                            @php
                                            $categories = DB::table('libraries')->get();
                                        @endphp

                                        @foreach ($categories as $category)
                                        
                                            @if ($category->category === 'Meter Brand')
                                                <option value="{{ $category->categoryaddedName }}">{{ $category->categoryaddedName }}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meterSerialNum" style="color: black;"><i class="fa fa-barcode"></i> Serial Number</label>
                                        <input id="edit_meterSerialNum" type="text" class="form-control" name="edit_meterSerialNum" required>
                                        <span id="meterSerialNum-error" style="color: red" class="is-invalid" role="alert"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer" style="margin-right: 30px;">
                        <button type="button" class="btn btn-secondary enlarge-on-hover" data-dismiss="modal">Close</button>
                        <button type="button" id="updatecategory-btn" class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i> Update</button>
                    </div>
                </div>

                <script>
               
                    function edit_handleCategoryChange() {
                        var selectedValue = document.getElementById("edit_category").value;
    
                        var forCategoryRow = document.getElementById("edit_forCategory");
                        var forAddedMeterRow = document.getElementById("edit_forAddedMeter");
                        
                        if (selectedValue === "Rate Case" || selectedValue === "Classification" || selectedValue === "Cluster" || selectedValue === "Trade" || selectedValue === "Collector" || selectedValue === "Meter Brand" || selectedValue === "Reader") {
                            forCategoryRow.style.display = "block";
                            forAddedMeterRow.style.display = "none";
                        } else if (selectedValue === "Meter") {
                            forCategoryRow.style.display = "none";
                            forAddedMeterRow.style.display = "block";

                        } else {
                            forCategoryRow.style.display = "none";
                            forAddedMeterRow.style.display = "none";
                        }
                    }
                </script>
            </div>
            
        </div>
        <script>
            document.querySelectorAll('.capitalize').forEach(function (input) {
            input.addEventListener('input', function () {
           
                var inputValue = input.value;

                
                var capitalizedValue = inputValue.charAt(0).toUpperCase() + inputValue.slice(1).toLowerCase();

               
                input.value = capitalizedValue;
            });
        });
        </script>
        {{-- modal for miscell item --}}

        <div class="modal fade" id="editmiscellModal" tabindex="-1" role="dialog" aria-labelledby="editmiscellModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editmiscellModalLabel">Edit Miscellaneous Item</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row" name="forAddedMicel" id="forAddedMicel">
                        <div class="col-md-12">
                            <input type="hidden" id="hidden_id" value="id">
                            <label for="meterBrand" style="color: black;"><i class="fa fa-person"></i> Miscellaneous Name</label>
                            <input class="form-control" id="editmiscellaneous_name" name="editmiscellaneous_name" required>
                            {{-- <span id="miscellaneous_name-error" style="color: red; display: none;" class="is-invalid" role="alert">Please input this field</span>
                            <span id="miscellaneous_name-success" style="color: green; display: none;" class="is-valid" role="alert"><i class="fa fa-check-circle"></i> Review your input fields</span> --}}
                        </div>
                        <div class="col-md-12">
                            <label for="meterSerialNum" style="color: black;"><i class="fa fa-money"></i> Amount</label>
                            <input id="editamount" type="text" class="form-control" name="editamount" required>
                            {{-- <span id="amount-error" style="color: red; display: none;" class="is-invalid" role="alert">Please input a valid amount</span>
                            <span id="amount-success" style="color: green; display: none;" class="is-valid" role="alert"><i class="fa fa-check-circle"></i> After done input amount just Tap Anywhere</span> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id ="UpdateMiscell_btn" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
          {{-- //table  --}}
        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 1;">  
        <div class="card-body mt-4" style="padding: 20px;" style="width: 100% !important;">
            <h2 class="mb-4">Miscellaneous Item</h2>
             <table id="miscell_table" class="display table table-bordered" style="color:black !important;width: 100% !important;">
                 <thead>
                     <tr>
                         <th>Miscellaneous Name</th>
                         <th>Amount</th>
                         <th class="action">Action</th>
                     </tr>
                 </thead>
             </table>
            </div>  
         </div>
    </div>        
</div>

@endsection