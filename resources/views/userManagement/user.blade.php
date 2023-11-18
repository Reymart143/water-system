@extends('layouts.dash')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px;">
                                <h2 class="mt-1" style="color: white !important;">LIST OF EMPLOYEES</h2>    
                                {{-- ADD EMPLOYEE BUTTON --}}
                                <button type="button" onclick="openModal()" class="btn btn-dark submit enlarge-on-hover" style="width: 160px;margin-left:850px; float: right; margin-top:-30px;"><i class="fa fa-plus"></i> Add Employee</button>                               
                                {{-- MODAL SCRIPT --}}
                                <script>
                                    function openModal(){
                                        $('#addEmployeeLabel').html('<i class="fa fa-user-plus"></i> Create New User for Meedo Water System');
                                        $('#addEmployee').modal('show');
                                    
                                        $('#add-btn').on('click', function (e) {
                                            e.preventDefault(); 
                                            
                                            var name = $('#name').val().trim();
                                            var username = $('#username').val().trim();
                                            var address = $('#address').val().trim();
                                            var phoneNumber = $('#phoneNumber').val().trim();
                                            var role = $('#role').val();
                                            var image = $('.image-tag').val().trim();
                                            var password = $('#password').val().trim();
                                            var passwordConfirmation = $('#password_confirmation').val().trim(); 
                                            var errors = false;

                                            // Validation checks
                                            if (name === '') {
                                                $('#name').addClass('is-invalid');
                                                $('#name-error').text('Please enter a name.');
                                                errors = true;
                                            } else {
                                                $('#name').removeClass('is-invalid');
                                                $('#name-error').text('');
                                            }if (username.trim() === '') {
                                                $('#username').addClass('is-invalid');
                                                $('#username-error').text('Please enter an employee ID.');
                                                errors = true;
                                            } else {
                                                $('#username').removeClass('is-invalid');
                                                $('#username-error').text('');
                                            }

                                            if (role === null) {
                                            $('#role').addClass('is-invalid');
                                            $('#role-error').text('Please select a position.');
                                            errors = true;
                                            } else {
                                            $('#role').removeClass('is-invalid');
                                            $('#role-error').text('');
                                            }
                                            if (phoneNumber.trim() === '') {
                                            $('#phoneNumber').addClass('is-invalid');
                                            $('#phoneNumber-error').text('Please select a Phone Number.');
                                            errors = true;
                                            }  else if (phoneNumber.length < 11) {
                                                $('#phoneNumber').addClass('is-invalid');
                                                $('#phoneNumber-error').text('Please enter at least 11 digits.');
                                                errors = true;
                                            } else if (phoneNumber.length > 11) {
                                                $('#phoneNumber').addClass('is-invalid');
                                                $('#phoneNumber-error').text('Please enter no more than 11 digits.');
                                                errors = true;
                                            }else {
                                            $('#phoneNumber').removeClass('is-invalid');
                                            $('#phoneNumber-error').text('');
                                            }
                                        
                                            if (address.trim() === '') {
                                            $('#address').addClass('is-invalid');
                                            $('#address-error').text('Please select a address.');
                                            errors = true;
                                            } else {
                                            $('#address').removeClass('is-invalid');
                                            $('#address-error').text('');
                                            }

                                        

                                            if (password.trim() === '') {
                                                $('#password').addClass('is-invalid');
                                                $('#password-error').text('Please enter a password.');
                                                errors = true;
                                            }  else if (password !== passwordConfirmation) {
                                                $('#password').addClass('is-invalid');
                                                $('#password_confirmation').addClass('is-invalid');
                                                $('#password-error').text('Password do not match');
                                                errors = true;
                                            } else {
                                                $('#password').removeClass('is-invalid');
                                                $('#password-error').text('');
                                            }
                                            

                                            if (errors) {
                                                Swal.fire({
                                                    title: 'Register Failed',
                                                    text: 'Please fill in all required fields.',
                                                    icon: 'error',
                                                });
                                                return; 
                                            }

                                            
                                            var Usersform = {
                                                'id': $('#hidden_id').val(),
                                                'name': name,
                                                'username': username,
                                                'role': role,
                                                'image': image,
                                                'phoneNumber': phoneNumber,
                                                'address': address,
                                                'password': password,
                                                
                                            };

                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });

                                            $.ajax({
                                                type: 'post',
                                                url: 'add',
                                                data: Usersform,
                                                dataType: 'json',
                                                success: function (response) {
                                                    $('#name').val('');
                                                    $('#username').val('');
                                                    $('#role').val('');
                                                    $('#image').val('');
                                                    $('#address').val('');
                                                    $('#phoneNumber').val('');
                                                    $('#password').val('');
                                                    $('#password_confirmation').val('');
                                                    Swal.fire({
                                                        title: 'Successfully Created',
                                                        text: 'Successfully Created Account For Meedo Water System',
                                                        icon: 'success',
                                                    });
                                                    $('#superAdmin_table').DataTable().ajax.reload();
                                                },
                                                error: function (xhr) {
                                                    Swal.fire({
                                                        title: 'Username is already taken',
                                                        text: 'An error occurred while creating the account.',
                                                        icon: 'error',
                                                    });
                                                }
                                            });

                                        });

                                        $('#image').on('change', function (e) {
                                        var filesSelected = document.getElementById('image').files[0];
                                        var reader = new FileReader();
                                        reader.readAsDataURL(filesSelected);
                                        reader.onload = function () {
                                            console.log(reader.result)
                                            $(".image-tag").val(reader.result);
                                            // $("#previewImage").attr("src", reader1.result);
                                        }
                                        });
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
                        <div class="card-body mt-4" style="padding:20px;width: 100% !important;overflow-x: auto;font-size:3mm">
                            <table id="superAdmin_table" class="display table" style="color:black !important;width: 100% !important;table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th >Position</th>
                                        <th style="width: 7%; !important">Image</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th style="flex: 1; white-space: nowrap;">Phone Number</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th class="action" style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- EDIT BUTTON SCRIPT --}}
            <script>
                function editSuperAdmin(id){
                    
                    
                    $('#edit-btn').text('Update Info');
                    
                
                    $.ajax({
                        url: "/superAdmin/edit/" + id + "/",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            $('#edit_name').val(data.result.name)
                            $('#edit_username').val(data.result.username)
                            $('#edit_phoneNumber').val(data.result.phoneNumber)
                            $('#edit_role').val(data.result.role)
                            $('#editLabel').html('<i class="fa fa-edit"?></i> Edit Employee Info');
                            $('#edit-btn').val('Update');
                            $('#action').val('Edit');
                            $('#editEmployee').modal('show');
                        
                            $('#edit-btn').off('click').on('click', function () {
                                updateUser(id);
                            });
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                        }
                    });
                }
                //update
                    function updateUser(id) {
                        var Usersform = {
                            'id': id,
                            'name': $('#edit_name').val(),
                            'username': $('#edit_username').val(),
                            'phoneNumber': $('#edit_phoneNumber').val(),
                            
                            'role': $('#edit_role').val(),
                            
                        };

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'post',
                            url: 'superAdmin/update',
                            data: Usersform,
                            dataType: 'json',
                            success: function (response) {
                            $('#superAdmin_table').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Successfully Updated',
                                text: 'This User Information Is Now Updated',
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
                    function confirmDelete(id) {
                        
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
                                deleteUser(id);
                            } else {
                                Swal.fire(
                                    'Deletion canceled',
                                    'The user was not deleted.',
                                    'info'
                                )
                            }
                        });
                    }

                    function deleteUser(id) {
                        
                        $.ajax({
                        
                            url: "{{ url('delete/') }}/" + id,
                            type: 'DELETE',
                            
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            
                            success: function(response) {
                                
                                Swal.fire(
                                    'Deleted!',
                                    'The user has been deleted.',
                                    'success'
                                ).then(() => {

                                    $('#superAdmin_table').DataTable().ajax.reload();
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

            {{-- ADD MODAL CONTENT --}}
            <div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="margin-top: -15px; overflow:hidden !important;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEmployeeLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body" style="overflow: hidden;">
                            <div id="showing"></div>

                            <div class="login_form" style="padding: 20px 30px !important;">
                                
                                <form style="background-color:white;">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center" >
                                            <div style="position: relative; width: 200px; height: 200px; overflow: hidden; border-radius: 50%;">
                                                <img class="img-responsive" id="avatarImage" style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('pluto/images/logo/avatar.webp') }}" alt="emptyUserImage">
                                            </div>
                                            <input type="file" id="image" name="image" style="display: none;" accept="image/png, image/gif, image/jpeg" required>
                                            <input type="hidden" name="image" class="image-tag">
                                            <button type="button" class="btn btn-info upload-image-btn rounded-circle" onclick="uploadImage()"><i class="fa fa-camera"></i></button>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="input" style="color: black;"><i class="fa fa-user"></i> Username</label>
                                            <input id="username" type="text" class="form-control" name="username" placeholder="Enter Username" required>
                                            <span id="username-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                            <div>
                                                <label for="input" style="color: black;"><i class="fa fa-mobile-phone"></i> Phone Number</label>
                                                <input id="phoneNumber" type="text" class="form-control" name="phoneNumber" placeholder="Enter Phone Number" required>
                                                <span id="phoneNumber-error" style="color:red" class="is-invalid" role="alert"></span>
                                                <script>
                                                    document.querySelector('input#phoneNumber').oninput = checkInput;
                                
                                                    function checkInput()
                                                    {
                                                        var clean = this.value.replace(/[^0-9,.]/g, "")
                                                                            .replace(/(,.*?),(.*,)?/, "$1");
                                                        if (clean !== this.value){
                                                
                                                        Swal.fire({
                                                                position: 'center',
                                                                icon: 'error',
                                                                title: 'Invalid Phone Number!',
                                                                html: '<span style="color: #df0000; font-weight:bold;">You have enter invalid Phone number </span><br/><br/><span style="color: #df0000;">This is an example:</span> <span style="color: #08288B;"> 09752760459</span><br/><br/><span style="color: #08288B;"> A- Z does not accept in  phone Number.</span>',
                                                                showConfirmButton: true,
                                                            });
                                                
                                                        this.value = clean;
                                                        document.getElementById("save_btn").disabled = true;
                                                
                                                        } else{
                                                        document.getElementById("save_btn").disabled = false;
                                                    
                                                        }
                                            
                                                }
                                                </script>
                                            </div>
                                            @if(Auth::user()->role == 0)
                                            <div>
                                                <label for="input" style="color: black;"><i class="fa fa-users"></i> Position</label>
                                                <select class="form-control form-select placement-dropdown" id="role" name="role" required autocomplete="role">
                                                    <option value="" disabled selected>Select type of Position</option>
                                                    <option value="1"> Administrator</option>
                                                    <option value="2"> Treasurer</option>
                                                    <option value="3"> Encoder</option>
                                                    <option value="4"> Assesor</option>
                                                </select>
                                                <span id="role-error" style="color:red" class="is-invalid" role="alert"></span>
                                            </div>
                                            @elseif(Auth::user()->role == 1)
                                            <div>
                                                <label for="input" style="color: black;"><i class="fa fa-users"></i> Position</label>
                                                <select class="form-control form-select placement-dropdown" id="role" name="role" required autocomplete="role">
                                                    <option value="" disabled selected>Select type of Position</option>

                                                    <option value="2"> Treasurer</option>
                                                    <option value="3"> Encoder</option>
                                                    <option value="4"> Assesor</option>
                                                </select>
                                                <span id="role-error" style="color:red" class="is-invalid" role="alert"></span>
                                            </div>
                                            @else
                                            @endif
                                        </div>
                                    </div>

                                    <script>
                                        function uploadImage() {
                                            document.getElementById('image').click();
                                        }
                                    
                                        document.getElementById('image').addEventListener('change', function(event) {
                                            const selectedImage = event.target.files[0];
                                            if (selectedImage) {
                                                const avatarImage = document.getElementById('avatarImage');
                                                avatarImage.src = URL.createObjectURL(selectedImage);
                                            }
                                        });
                                    </script>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-user"></i> Name</label>
                                            <input id="name" type="text" class="form-control" name="name" placeholder="Enter Name" required>
                                            <span id="name-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-lock"></i> Password</label>
                                            <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password" required>
                                            <span id="password-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-location"></i> Address</label>
                                            <input id="address" type="text" class="form-control" name="address" placeholder="Enter Address" required>
                                            <label style="font-size:11px; font-style:italic;" class="text-primary" for="example"> Ex. Purok 1, Maputi, Naawan, Misamis Oriental </label>                    
                                            <span id="address-error" style="color:red" class="is-invalid" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input" style="color: black;"><i class="fa fa-lock"></i> Confirm Password</label>
                                            <input  type="password" id="password_confirmation" name="password_confirmation" 
                                            placeholder="Re-type password" class="form-control" required>                     
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal-footer" style="margin-right: 30px;">
                            <button type="button" class="btn btn-secondary enlarge-on-hover" data-dismiss="modal">Close</button>
                            <button type="button" id="add-btn" value="add" class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div> 
            {{-- EDIT MODAL --}}
            <div class="modal fade" id="editEmployee" tabindex="-1" role="dialog" aria-labelledby="editEmployeeLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editLabel"></h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body" style="overflow: hidden;">
                        <div id="showing"></div>
                        <div class="login_form" style="padding: 30px 30px !important;">
                            
                            <form style="background-color:white;">
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-user"></i> Name</label>
                                    <input id="edit_name" type="text" class="form-control" name="name" placeholder="Enter Name" required>
                                    <span id="name-error" style="color:red" class="is-invalid" role="alert"></span>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="input" style="color: black;"><i class="fa fa-user"></i> Username</label>
                                    <input id="edit_username" type="text" class="form-control" name="username" placeholder="Enter Username" required>
                                    <span id="username-error" style="color:red" class="is-invalid" role="alert"></span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="input" style="color: black;"><i class="fa fa-mobile-phone"></i> Phone Number</label>
                                        <input id="edit_phoneNumber" type="text" class="form-control" name="phoneNumber" placeholder="Enter Phone Number" required>
                                        <span id="phoneNumber-error" style="color:red" class="is-invalid" role="alert"></span>
                                        <script>
                                            document.querySelector('input#edit_phoneNumber').oninput = checkInput;
                        
                                            function checkInput()
                                            {
                                                var clean = this.value.replace(/[^0-9,.]/g, "")
                                                                    .replace(/(,.*?),(.*,)?/, "$1");
                                                if (clean !== this.value){
                                        
                                                Swal.fire({
                                                        position: 'center',
                                                        icon: 'error',
                                                        title: 'Invalid Phone Number!',
                                                        html: '<span style="color: #df0000; font-weight:bold;">You have enter invalid Phone number </span><br/><br/><span style="color: #df0000;">This is an example:</span> <span style="color: #08288B;"> 09752760459</span><br/><br/><span style="color: #08288B;"> A- Z does not accept in  phone Number.</span>',
                                                        showConfirmButton: true,
                                                    });
                                        
                                                this.value = clean;
                                                document.getElementById("save_btn").disabled = true;
                                        
                                                } else{
                                                document.getElementById("save_btn").disabled = false;
                                            
                                                }
                                    
                                        }
                                        </script>
                                    </div>
                                    @if(Auth::user()->role == 0)
                                    <div class="col-md-6">
                                        <label for="input" style="color: black;"><i class="fa fa-users"></i> Position</label>
                                        <select class="form-control form-select placement-dropdown" id="edit_role" name="role" required autocomplete="role">
                                            <option value="" disabled selected>Select type of Position</option>
                                            <option value="1"> Administrator</option>
                                            <option value="2"> Treasurer</option>
                                            <option value="3"> Encoder</option>
                                            <option value="4"> Assesor</option>
                                        </select>
                                        <span id="role-error" style="color:red" class="is-invalid" role="alert"></span>
                                    </div>
                                    @elseif(Auth::user()->role == 1)
                                    <div class="col-md-6">
                                        <label for="input" style="color: black;"><i class="fa fa-users"></i> Position</label>
                                        <select class="form-control form-select placement-dropdown" id="edit_role" name="role" required autocomplete="role">
                                            <option value="" disabled selected>Select type of Position</option>
                                         
                                            <option value="2"> Treasurer</option>
                                            <option value="3"> Encoder</option>
                                            <option value="4"> Assesor</option>
                                        </select>
                                        <span id="role-error" style="color:red" class="is-invalid" role="alert"></span>
                                    </div>
                                    @else
                                    @endif
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-right: 30px;">
                    <button type="button" class="btn btn-secondary enlarge-on-hover" data-dismiss="modal">Close</button>
                    
                    <button type="button" id="edit-btn"  class="btn btn-primary submit enlarge-on-hover"><i class="fa fa-send-o"></i> Submit</button>
                    </div>
                </div>
                </div>
            </div>
            
        </div>  
    </div>
@endsection