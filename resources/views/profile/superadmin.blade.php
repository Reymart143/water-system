@extends('layouts.dash')

@section('content')
    <!-- dashboard inner -->
    <div class="midde_cont">
        
        <div class="container-fluid">
            <div class="row column1">
                <div class="col-md-2"></div>
                    <div class="col-md-12 mt-4">
                        <div class="white_shd full margin_bottom_30" style="position: relative; z-index: 2; box-shadow: 0px 0px 20px 0px #747f8a !important;">
                            <div class="full graph_head" style="    background: #007bff; border-radius: 5px; border-bottom: none;">
                                <h2 class="mt-1" style="color: white !important;">PROFILE INFORMATION</h2>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <!-- row -->
            <div class="row column1">
              <div class="col-md-4">
                 <div class="white_shd full margin_bottom_30" style="position: relative;margin-top: -55px;">
                    <div class="full price_table padding_infor_info">
                       <div class="row">
                        
                          <!-- user profile section --> 
                          <!-- profile image -->
                          <div class="col-lg-12 mb-4 mt-4">
                             <div class="full centered-container">
                                <div class="picture" ><img width="180" id="profilePicture" class="rounded-circle" style="margin-top:10px;width: 200px; height: 190px; border-radius: 50%; object-fit: cover;margin-left:100px" src="{{ asset('storage/' . Auth::user()->image) }}" alt="#" /></div>
                                <i class="fa fa-camera fa-2x"   data-toggle="popover" data-placement="top" 
                                data-content="Upload Profile Photo" title="Click to upload a new profile photo" data-trigger="hover" onclick="profile_modal()" style="cursor:pointer;background-color: rgb(196, 196, 196);padding: 2mm;border-radius: 1.5rem;margin-bottom:-150px;margin-right:80px;margin-left:-50px"></i>
                            </div>
                          </div>
                          <div class="modal fade" id="AdminModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                              <div class="modal-content">
                                <div class="modal-header" >
                                  <h5 class="modal-title" id="exampleModalLabel2" style=" text-align: center;margin-left:15px; font-size:18px; margin-top: 5px;"><i class="fa fa-file-image-o"></i> Update Profile</h5>
              
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div id="admin_upload"></div>
                                
                                <div class="modal-body">
                                  {{-- <div class="spinner-border text-primary" role="status" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                  </div> --}}
                                  <input type="file" accept="image/*" id="image" name="image" style="display: none;">
                                <input type="hidden"  name="image" class="image-tag">
                                <button style="width: 100%;height:100%" class="btn btn-secondary">
                                    <label for="image" class="profile-btn" style="cursor: pointer;margin-top:-120px;margin-left:20px">
                                       <div style="margin-top:120px"> <i class="fa-regular fa-image fa-3x" style="margin-bottom:40px"></i></div> Click to open gallery </label>
                                    </button>
                                </div>
                                
                                <div class="modal-footer" style="border-top: 1px solid #ccc;">
                                  <button type="button" id="upload_btn" class="btn btn-primary" style="margin-top: -6px;">Update</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                          <script>
                            
                            document.getElementById('upload_btn').addEventListener('click', function () {
                              var spinner = document.querySelector('.spinner-border');
                              spinner.style.display = 'inline-block'; 
                          
                             
                              var modalContent = document.querySelector('.modal-content');
                              var body = document.querySelector('body');
                              modalContent.classList.add('blur-background');
                              body.classList.add('blur-background');
                          
                             
                              setTimeout(function () {
                                spinner.style.display = 'none'; 
                          
                             
                                modalContent.classList.remove('blur-background');
                                body.classList.remove('blur-background');
                          
                       
                              }, 1000); 
                            });
                          </script>
                          <script>
                            function profile_modal(){
                                $('#AdminModal').modal('show');
                                
                                $('[data-toggle="popover"]').popover();


                               $(document).ready(function() {

                                    $('.profile-btn').on('click', function(e) {
                                        e.preventDefault();
                                        
                                        $('#image').trigger('click');
                                        });
                                    
                                        $('#image').on('change', function (e) {
                                        var filesSelected = document.getElementById('image').files[0];
                                        var reader = new FileReader();
                                        reader.readAsDataURL(filesSelected);
                                        reader.onload = function () {
                                            console.log(reader.result)
                                            $(".image-tag").val(reader.result);
                                            // $("#previewImage").attr("src", reader1.result);
                                            $('#profilePicture').attr('src', reader.result);
                                        }
                                        });
                                        const profileBtn = document.querySelector('#upload_btn');
                                profileBtn.addEventListener('click', () => {

                                        const image = document.querySelector('.image-tag').value; 


                                            $.ajax({
                                            url: "/superadmin/upload/update/",
                                            method: "POST",
                                            headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {
                                            image: image,

                                            },
                                            success: function (data) {
                                                setTimeout(function() {
                                                resultSection.innerHTML = ''; 
                                                $('#AdminModal').modal('hide'); 
                                            }, 2000);
                                                const alertHTML = '<div class="alert alert-success small-alert" role="alert" style="background-color:green;color:white">' + data.message + '</div>';
                                                const resultSection = document.getElementById('admin_upload');
                                                resultSection.innerHTML = alertHTML;
                                                

                                                for (let i = 0; i < displayElements.length; i++) {
                                                    displayElements[i].textContent = inputElements[i].value;
                                                }
                                                
                                               
                                               
                                            },
                                            error: function (data) {
                                                Swal.fire({
                                                    title: 'ERROR',
                                                    text: 'Your Profile Picture is failed to changed',
                                                    icon: 'error',
                                                });
                                            }
                                            });


                                    });
                                    });
            
                      
                            }
                        </script>
                          <div class="col-lg-12 mt-4">
                            <div class="profile_contant">
                                <div class="contact_inner" style="text-align:center">
                                   <h3>{{ Auth::user()->name }}</h3>
                                  
                                   <p class="mb-3">
                                    @switch(Auth::user()->role)
                                    @case(0)
                                            <div style="font-size: 20px;color:rgb(255, 255, 255);margin-top:13px;padding:2px;border-radius:7px;background-color:rgb(223, 40, 198)">Supervisor</div>
                                            @break  
                                            @case(1)
                                            <div style="font-size: 20px;color:rgb(255, 255, 255);margin-top:13px;padding:2px;border-radius:7px;background-color:rgb(36, 91, 209)">Administrator</div>
                                            @break
                                        @case(2)
                                         <div style="font-size: 20px;color:rgb(255, 255, 255);margin-top:13px;padding:2px;border-radius:7px;background-color:rgb(209, 154, 36)">Treasurer</div>
                                            @break
                                        @case(3)
                                            <div style="font-size: 20px;color:rgb(255, 255, 255);margin-top:13px;padding:2px;border-radius:7px;background-color:#01796F">Encoder</div>
                                            @break
                                        @case(4)
                                            <div style="font-size: 20px;color:rgb(255, 255, 255);margin-top:13px;padding:2px;border-radius:7px;background-color:rgb(161, 11, 11)">Assessor</div>
                                        
                                            @break
                                        @default
                                            Unknown Position
                                    @endswitch
                                </p>
                                 </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                <div class="col-md-8">
                    <div class="white_shd full margin_bottom_30" style="position: relative; margin-top: -55px;">
                        <div class="full price_table padding_infor_info">
                            <div class="row">
                                <!-- user profile section --> 
                                <!-- profile image -->
                                <div class="col-lg-12 mb-2 mt-4">
                                    <label class="prof-label" for="name">Name</label>
                                    <input class="form-control prof-border" type="text" name="name" id="name" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label class="prof-label" for="name">Username</label>
                                    <input class="form-control prof-border" type="text" name="username" id="username" value="{{ Auth::user()->username }}">
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label class="prof-label" for="name">Address</label>
                                    <input class="form-control prof-border" type="text" name="address" id="address" value="{{ Auth::user()->address }}">
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label class="prof-label" for="name">Phone Number</label>
                                    <input class="form-control prof-border" type="text" name="phoneNumber" id="phoneNumber" value="{{ Auth::user()->phoneNumber }}">
                                </div>
                                <div id="password-section" style="width: 100% !important;">
                                    <div class="col-lg-12 mb-2">
                                        <label class="prof-label" id="old-label" for="name" style="display: none;">Old Password</label>
                                        <div class="input-group">
                                            <input class="form-control prof-border" type="password" name="password" placeholder="Enter Old Password" id="password" style="display: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="iconCont" style="display: none;">
                                                    <i class="far fa-eye" id="old-password-toggle" style="display: none;margin-top:5px;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span id="password-error" class="text-danger" style="display: none;"></span>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label class="prof-label" id="new-label" for="name" style="display: none;">New Password</label>
                                        <div class="input-group">
                                            <input class="form-control prof-border" type="password" name="new_password" placeholder="Enter New Password" id="new_password" style="display: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="iconContNew" style="display: none;">
                                                    <i class="far fa-eye" id="new-password-toggle" style="display: none;margin-top:5px;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span id="new_password-error" class="text-danger" style="display: none;"></span>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label class="prof-label" id="confirm-label" for="name" style="display: none;">Confirm Password</label>
                                        <div class="input-group">
                                            <input class="form-control prof-border" type="password" name="confirm_password" placeholder="Re-Type New Password" id="confirm_password" style="display: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="iconContCon" style="display: none;">
                                                    <i class="far fa-eye" id="confirm-password-toggle" style="display: none;margin-top:5px;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span id="confirm-password-error" class="text-danger" style="display: none;"></span>
                                    </div>
                                    <div class="col-lg-12 mt-3" style="display: inline-flex; ">
                                        <button class="main_bt" id="show_password_btn" style="background-color: rgb(158, 3, 3) !important; min-width:90px !important; padding: 10px 10px; font-size:12px !important;">Change Password ?</button>
                                        <button class="main_bt" id="hide_password_btn" style="background-color: rgb(158, 3, 3) !important; min-width:90px !important; padding: 10px 10px; font-size:12px !important; display: none;">Hide Password</button>
                                        <button class="main_bt" id="save_btn" style="background-color: rgb(2, 2, 196) !important; min-width:90px !important; padding: 10px 10px; font-size:12px !important; margin-left:10px; ">Save Changes</button>
                                    </div>
                                </div>
                                {{-- PASSWORD TOGGLING --}}
                                <script>
                                    document.getElementById("old-password-toggle").addEventListener("click", function () {
                                        togglePasswordVisibility("password", "old-password-toggle");
                                    });
                                    document.getElementById("new-password-toggle").addEventListener("click", function () {
                                        togglePasswordVisibility("new_password", "new-password-toggle");
                                    });
                                    document.getElementById("confirm-password-toggle").addEventListener("click", function () {
                                        togglePasswordVisibility("confirm_password", "confirm-password-toggle");
                                    });
                                
                                    function togglePasswordVisibility(fieldId, iconId) {
                                        const passwordInput = document.getElementById(fieldId);
                                        const icon = document.getElementById(iconId);
                                
                                        if (passwordInput.type === "password") {
                                            passwordInput.type = "text";
                                            icon.classList.remove("fa-eye-slash");
                                            icon.classList.add("fa-eye");
                                        } else {
                                            passwordInput.type = "password";
                                            icon.classList.remove("fa-eye");
                                            icon.classList.add("fa-eye-slash");
                                        }
                                    }
                                </script>                          
                                {{-- HIDE AND SHOW FIELDS --}}
                                <script>
                                    const showPasswordBtn = document.getElementById("show_password_btn");
                                    const hidePasswordBtn = document.getElementById("hide_password_btn");
                                    const oldPasswordField = document.getElementById("password");
                                    const newPasswordField = document.getElementById("new_password");
                                    const confirmPasswordField = document.getElementById("confirm_password");
                                    const oldPasswordlabel = document.getElementById("old-label");
                                    const newPasswordlabel = document.getElementById("new-label");
                                    const confirmPasswordlabel = document.getElementById("confirm-label");
                                    const oldPasswordIcon = document.getElementById("old-password-toggle");
                                    const newPasswordIcon = document.getElementById("new-password-toggle");
                                    const confirmPasswordIcon = document.getElementById("confirm-password-toggle");
                                    const iconContainer = document.getElementById("iconCont");
                                    const iconContainerNew = document.getElementById("iconContNew");
                                    const iconContainerConfirm = document.getElementById("iconContCon");

                                    document.getElementById("show_password_btn").addEventListener("click", function() {
                                        document.getElementById("password").style.display = "block";
                                        document.getElementById("new_password").style.display = "block";
                                        document.getElementById("confirm_password").style.display = "block";
                                        document.getElementById("old-label").style.display = "block";
                                        document.getElementById("new-label").style.display = "block";
                                        document.getElementById("confirm-label").style.display = "block";
                                        document.getElementById("old-password-toggle").style.display = "block";
                                        document.getElementById("new-password-toggle").style.display = "block";
                                        document.getElementById("confirm-password-toggle").style.display = "block";
                                        document.getElementById("iconCont").style.display = "block";
                                        document.getElementById("iconContNew").style.display = "block";
                                        document.getElementById("iconContCon").style.display = "block";
                                        hidePasswordBtn.style.display = "block";
                                        this.style.display = "none"; 
                                        const passwordSection = document.getElementById("password-section");
                                        passwordSection.scrollIntoView({ behavior: "smooth" });
                                    });

                                        hidePasswordBtn.addEventListener("click", function() {
                                        oldPasswordField.style.display = "none";
                                        newPasswordField.style.display = "none";
                                        confirmPasswordField.style.display = "none";
                                        oldPasswordlabel.style.display = "none";
                                        newPasswordlabel.style.display = "none";
                                        confirmPasswordlabel.style.display = "none";
                                        confirmPasswordlabel.style.display = "none";
                                        oldPasswordIcon.style.display = "none";
                                        newPasswordIcon.style.display = "none";
                                        confirmPasswordIcon.style.display = "none";
                                        iconContainer.style.display = "none";
                                        iconContainerNew.style.display = "none";
                                        iconContainerConfirm.style.display = "none";
                                        showPasswordBtn.style.display = "block";
                                        this.style.display = "none";
                                    });
                                    
                                    
                                </script>
                                {{-- EDIT PROFILE INFO SAVE BTN --}}
                                <script>
                                  const saveBtn = document.querySelector('#save_btn');
                                    saveBtn.addEventListener('click', () => {
                                        const name = document.querySelector('input[name="name"]').value;
                                        const userName = document.querySelector('input[name="username"]').value;
                                        const Address = document.querySelector('input[name="address"]').value;
                                        const phoneNo = document.querySelector('input[name="phoneNumber"]').value;
                                        const oldPasswordField = document.getElementById("password");
                                        const newPasswordField = document.getElementById("new_password");
                                        const confirmPasswordField = document.getElementById("confirm_password");

                                        const newPasswordValue = newPasswordField.value;
                                        const confirmPasswordValue = confirmPasswordField.value;
                                        
                                        if (newPasswordValue !== confirmPasswordValue) {
                                            const confirmError = document.getElementById('confirm-password-error');
                                            confirmError.style.display = 'block';
                                            confirmError.textContent = 'Passwords do not match';
                                            confirmPasswordField.classList.add('is-invalid');

                                            setTimeout(function () {
                                                confirmError.style.display = 'none';
                                                confirmError.textContent = '';
                                                confirmPasswordField.classList.remove('is-invalid');
                                            }, 5000);

                                            return; 
                                        }
                                        $.ajax({
                                            url: "/superadminprofile/update/",
                                            method: "POST",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {
                                                name: name,
                                                username: userName,
                                                address: Address,
                                                phoneNumber: phoneNo,
                                                password: oldPasswordField.value,
                                                new_password: newPasswordField.value,
                                            },
                                            success: function (data) {
                                                $('#password').val('');
                                                $('#new_password').val('');
                                                $('#confirm_password').val('');
                                                Swal.fire({
                                                        title: 'Successfully Updated',
                                                        text: 'Your Profile Information Is Now Updated',
                                                        icon: 'success',
                                                    });
                                            },
                                            error: function (data) {
                                                const errorMessage = data.responseJSON.message; 
                                                const passwordError = document.getElementById('password-error');
                                                const passwordField = document.getElementById('password');

                                               
                                                passwordError.style.display = 'block';
                                                passwordError.textContent = errorMessage;
                                                passwordField.classList.add('is-invalid'); 

                                                
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: errorMessage,
                                                });

                                                setTimeout(function () {
                                                    passwordError.style.display = 'none';
                                                    passwordError.textContent = '';
                                                    passwordField.classList.remove('is-invalid');
                                                    Swal.close();
                                                }, 5000);
                                            }

                                        });
                                    });
                                   
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- end row -->
            </div>
        </div>
      
    </div>

@endsection