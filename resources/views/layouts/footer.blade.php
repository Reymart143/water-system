
       <!-- jQuery -->
        {{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>

        {{-- datatables --}}
        {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script> --}}

        <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/3.1.3-jszip.min.js')}}"></script>
        <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/dataTables.buttons.min.js')}}"></script>
        <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/buttons.html5.min.js')}}"></script>
        <script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/buttons.print.min.js')}}"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.csv.min.js"></script>

        <script src="{{ asset('pluto/js/popper.min.js') }}"></script>
        <script src="{{ asset('pluto/js/bootstrap.min.js') }}"></script>
   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

        
        
        
        
    {{-- for date filter ramge --}}
 
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
        <!-- wow animation -->
        <script src="{{ asset('pluto/js/animate.js') }}"></script>
        <!-- select country -->
        <script src="{{ asset('pluto/js/bootstrap-select.js') }}"></script>
        <!-- owl carousel -->
        <script src="{{ asset('pluto/js/owl.carousel.js') }}"></script> 
        <!-- chart js -->
        {{-- <script src="{{ asset('pluto/js/Chart.min.js') }}"></script>
        <script src="{{ asset('pluto/js/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('pluto/js/utils.js') }}"></script>
        <script src="{{ asset('pluto/js/analyser.js') }}"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11 "></script> --}}
        <script src="{{asset('pluto/js/addJs/sweetAlert.js')}}"></script>
    
        <!-- nice scrollbar -->
        <script src="{{ asset('pluto/js/perfect-scrollbar.min.js') }}"></script>
        <script>
        var ps = new PerfectScrollbar('#sidebar');
        </script>
        <!-- custom js -->
        <script src="{{ asset('pluto/js/chart_custom_style1.js') }}"></script>
        <script src="{{ asset('pluto/js/custom.js') }}"></script>
        
        {{-- SUPERADMIN DATATABLE SCRIPT--}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('#superAdmin_table').DataTable({
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
                            ajax: "{{ route('superAdmin.view') }}",
                            order : [6, 'asc'],
                            columns: [
                                {
                                    data: 'role',
                                    name: 'role',
                                    render: function(data) {
                                        var roles = {
                                           
                                            1: { name: 'Administrator', color: '#051094'},
                                            2: { name: 'Treasurer', color: '#CC7722' },
                                            3: { name: 'Encoder', color: '#01796F' },
                                            4: { name: 'Assessor', color: '#7C0A02' }
                                        };
                                        // return '<div style="padding: 1mm; text-align: center; border-radius: 4px; color: white; background-color: ' + roles[data].color + '; font-family: YourCustomFont, sans-serif; font-size: 14px;">' + roles[data].name + '</div>';
                                        return '<div style="padding:1mm;text-align:center;border-radius: 4px;color:white;background-color: ' + roles[data].color + '">' + roles[data].name + '</div>';
                                    }
                                },
                                // {
                                //     data: 'image',
                                //     name: 'image',
                                //     render: function(data) {
                                //         var image = '<div class="image-container"><img src="{{ asset('storage/:image') }}" alt class="w-100 h-100 rounded-circle"/></div>';
                                //         image = image.replace(':image', data);
                                //         return image;
                                //     }
                                // },
                                {
                                    data: 'image',
                                    name: 'image',
                                    render: function (data) {
                                        var imageUrl = '{{ asset("storage/:image") }}'.replace(':image', data);
                                        var image = '<a data-fancybox="gallery" href="' + imageUrl + '"><div class="image-container"><img src="' + imageUrl + '" alt class="w-100 h-100 rounded-circle"/></div></a>';
                                        return image;
                                    }
                                },

                              
                                {
                                    data: 'name',
                                    name: 'name',
                                    render: function(data) {
                                        return '<div class="text-wrap" >' + data + '</div>';
                                    }
                                },
                                {
                                    data: 'username',
                                    name: 'username',
                                    render: function(data) {
                                        return '<div class="text-wrap" style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                    }
                                },
                               
                                {
                                    data: 'phoneNumber',
                                    name: 'phoneNumber',
                                    render: function(data) {
                                        if(data){
                                            return '<div class="text-wrap" style="flex: 1; white-space: nowrap;">' + data + '</div>';
                                        }
                                        else{
                                            return '<div class="text-wrap" style="flex: 1; white-space: nowrap;">No phone #</div>';
                                        }
                                        
                                    }
                                },
                                {
                                    data: 'address',
                                    name: 'address',
                                    render: function(data) {
                                        return '<div class="text-wrap">' + data + '</div>';
                                    }
                                },
                                {
                                        data: 'status',
                                        name: 'status',
                                        render: function(data, type, row) {
                                            if (data == 0) {
                                                return `<span class="connected-status" style="cursor: pointer;" onclick="selectStatus(${row.id})">Active</span>`;
                                            } else if (data == 1) {
                                                return `<span class="disconnected-status" style="cursor: pointer;" onclick="selectStatus(${row.id})">Inactive</span>`;
                                            } else {
                                                return '<span class="unknown-status">Unknown</span>';
                                            }
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

    //         function selectStatus(id) {
            
    //             Swal.fire({
    //                 title: 'Select Status',
    //                 html: '<select id="select_status" class="form-control">' +
    //                     '<option value="0">Active</option>' +
    //                     '<option value="1">Inactive</option>' +
                    
    //                     '</select>',
    //                 showCancelButton: true,
    //                 confirmButtonText: 'Save',
    //                 cancelButtonText: 'Cancel',
    //                 preConfirm: () => {
    //                     const selectedStatus = $('#select_status').val();
    //                     $.ajax({
    //                         url: '/superadmin-select-status',
    //                         headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                         },
    //                         method: 'POST',
    //                         data: {
    //                             id: id,
    //                             select_status: selectedStatus, 
    //                         },
    //                         success: function (response) {
                        
    //                             Swal.fire('success');
    //                             $('#superAdmin_table').DataTable().ajax.reload();
    //                         },
    //                         error: function (xhr, status, error) {
                                
    //                             Swal.fire('Error', 'Failed', 'error');
    //                         },
    //                     });
    //                 },
    //             });
    // }
    // function selectStatus(id) {
             
            //     if ({{ Auth::user()->role }} === 0 || {{ Auth::user()->role }} === 1) {
            //         Swal.fire({
            //             title: 'Select Status',
            //             html: '<select id="select_status" class="form-control">' +
            //                 '<option value="0">Active</option>' +
            //                 '<option value="1">Inactive</option>' +
            //                 '</select>',
            //             showCancelButton: true,
            //             confirmButtonText: 'Save',
            //             cancelButtonText: 'Cancel',
            //             preConfirm: () => {
            //                 const selectedStatus = $('#select_status').val();
            //                 $.ajax({
            //                     url: '/select-status',
            //                     headers: {
            //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                     },
            //                     method: 'POST',
            //                     data: {
            //                         id: id,
            //                         select_status: selectedStatus,
            //                     },
            //                     success: function (response) {
            //                         Swal.fire('Success');
            //                         $('#superAdmin_table').DataTable().ajax.reload();
            //                     },
            //                     error: function (xhr, status, error) {
            //                         Swal.fire('Error', 'Failed', 'error');
            //                     },
            //                 });
            //             },
            //         });
            //     } else {
          
            //         alert('You do not have permission to change status.');
            //     }
            // }
            function selectStatus(id) {
                Swal.fire({
                    title: 'Change Status',
                    html: `
                        <select id="select_status" class="form-control">
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Proceed Now',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const selectedStatus = $('#select_status').val();
                  
                        Swal.fire({
                            title: 'Confirm Password',
                            html: `
                                <input type="password" id="userPassword" class="form-control" placeholder="Enter Your Password">
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const userPassword = $('#userPassword').val();
                               
                                $.ajax({
                                    url: '/verify-password',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        password: userPassword,
                                    },
                                    success: function (response) {
                                     
                                        $.ajax({
                                            url: '/superadmin-select-status',
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {
                                                id: id,
                                                select_status: selectedStatus,
                                            },
                                            success: function (response) {
                                                Swal.fire('Success', 'Status changed successfully', 'success');
                                                $('#superAdmin_table').DataTable().ajax.reload();
                                            },
                                            error: function (xhr, status, error) {
                                                Swal.fire('Error', 'Failed to change status', 'error');
                                            },
                                        });
                                    },
                                    error: function (xhr, status, error) {
                                        Swal.fire('Error', 'Incorrect password', 'error');
                                    },
                                });
                            },
                        });
                    },
                });
            }


        </script>

        {{-- SUPERADMIN DATATABLE SCRIPT--}}
        <script>
            $(document).ready(function() {
                $('#customerTable').DataTable({
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
                            className: 'btn btn-print enlarge-on-hover'
                        }
                    ],
                    responsive: true, 
                    paging: true, 
                    pageLength: 10, 
                    
                    language: {
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        
                        paginate: {
                            page: "%index%"
                        }
                    }
                });
            });
        </script> 

<script>
    //this all for superadmin add catergories library ajax
            $(document).ready(function() {
                $('#addedlibrary_table').DataTable({
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
                    ajax: "{{ route('addlibrary.view') }}",
                    order: [[0, 'desc']],

                    columns: [
                        {
                            data: 'id',
                            name: 'id',
                            render: function(data) {
                                return '<div class="text-wrap">' + data + '</div>';
                            }
                        },
                        {
                            data: 'category',
                            name: 'category',
                            render: function(data) {
                                return '<div class="text-wrap">' + data + '</div>';
                            }
                        },
                        {
                            data: 'categoryaddedName',
                            name: 'categoryaddedName',
                            render: function(data, type, row) {
                                if (row.category === 'meter') {
                                
                                    var cleanedData = data.replace(/-/g, ' ');
                                    return '<div class="text-wrap">' + cleanedData + '</div>';
                                } else {
                                    
                                    return '<div class="text-wrap">' + data + '</div>';
                                }
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


            $('#addcategory-btn').on('click', function(e){
                e.preventDefault();

                var selectedCategory = $("#category").val();
                var data = {
                    category: selectedCategory,
                };

                if (selectedCategory === "Rate Case" || selectedCategory === "Classification" || selectedCategory === "Cluster" || selectedCategory === "Trade" || selectedCategory === "Collector" || selectedCategory === "Meter Brand" || selectedCategory === "Reader") {
                    data.categoryaddedName = $("#categoryaddedName").val();
                } else if (selectedCategory === "Meter") {
                    
                    var meterBrand = $("#meterBrand").val();
                    var meterSerialNum = $("#meterSerialNum").val();
                    
                    data.categoryaddedName =  meterBrand + "  " + meterSerialNum;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: 'addcategory',
                    data: data,
                    dataType: "json",
                    success: function(response){
                        console.log(data);
                       
                        $('#categoryaddedName').val('');
                        document.getElementById("meterSerialNum-error").style.display = "none";
                        document.getElementById("meterBrand-error").style.display = "none";
                        document.getElementById("categoryaddedName-error").style.display = "none";
                        document.getElementById("categoryaddedName-success").style.display = "none";
                        $('#meterBrand').val('');
                        $('#meterSerialNum').val('');
                        $('#addedlibrary_table').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Category is successfully added',
                            text : 'You can now check this out',
                            icon: 'success',
                            showConfirmButton: true,
                            timer: 3000
                        });
                        
                        
                    },
                    error: function(response){
                        Swal.fire({
                            title: 'Error ',
                            text : 'Error in adding category',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            });
                     function populateDropdown(dropdownId, options) {
                        const dropdown = document.getElementById(dropdownId);
                        dropdown.innerHTML = '<option value="" disabled selected>Select an option</option>';
                        options.forEach(option => {
                            const optionElement = document.createElement("option");
                            optionElement.value = option;
                            optionElement.text = option;
                            dropdown.appendChild(optionElement);
                        });
                    }
                    
                    function editmodalcategory(id) {
                        $.ajax({
                            type: "GET",
                            url: '/edit_norefresh', 
                            dataType: "json",
                            success: function(response){
                             
                                var editMeterBrandDropdown = $("#edit_meterBrand");
                                editMeterBrandDropdown.empty(); 

                              
                                response.forEach(function(brandName) {
                                    editMeterBrandDropdown.append('<option value="' + brandName + '">' + brandName + '</option>');
                                });
                            },
                            error: function(response){
                                console.log('Error in fetching brand names for editing');
                            }
                        });
                        $('#editCategory').modal('show');
                        
                        $.ajax({
                            url: "/category/edit/" + id + "/",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function (data) {
                                $('#edit_category').val(data.result.category);
                                
                                if (data.result.category === 'Meter') {
                                
                                    var meterData = data.result.categoryaddedName.split('  ');
                                    if (meterData.length === 2) {
                                       
                                        $('#edit_meterBrand').val(meterData[0]);
                                        $('#edit_meterSerialNum').val(meterData[1]);
                                    }
                                    
                            
                                    $('#edit_forCategory').hide();
                                    $('#edit_forAddedMeter').show();
                                } else {
                                    $('#edit_categoryaddedName').val(data.result.categoryaddedName);
                                    
                            
                                    $('#edit_forCategory').show();
                                    $('#edit_forAddedMeter').hide();
                                }
                                $('#updatecategory-btn').off('click').on('click', function () {
                                    categoryupdate(id);
                                });
                            }
                        });
                    }

                    function categoryupdate(id) {
                        var category = $('#edit_category').val();
                        var categoryaddedName = $('#edit_categoryaddedName').val();
                        
                        if (category === 'Meter') {
                 
                            var meterBrand = $('#edit_meterBrand').val();
                            var meterSerialNum = $('#edit_meterSerialNum').val();
                            
                            categoryaddedName = meterBrand + "  " + meterSerialNum;
                        }
                        
                        var categoryform = {
                            'id': id,
                            'category': category,
                            'categoryaddedName': categoryaddedName,
                        };

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'post',
                            url: 'category/update',
                            data: categoryform,
                            dataType: 'json',
                            success: function (response) {
                                $('#addedlibrary_table').DataTable().ajax.reload();
                                Swal.fire({
                                    title: 'Successfully Updated',
                                    text: 'Category Is Now Updated',
                                    icon: 'success',
                                });
                            },
                            error: function (error) {
                                Swal.fire({
                                    title: 'Something Went Wrong ',
                                    text: 'Please Check your input fields',
                                    icon: 'error',
                                });
                            }
                        });
                    }
                    function categorysuperadmin(id){
                        
                        Swal.fire({
                            title: 'You wont able to restore this Category',
                            text: "Please check carefully",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteCategory(id);
                            } else {
                                Swal.fire(
                                    'Deletion canceled',
                                    'The category was not deleted.',
                                    'info'
                                )
                            }
                        });
                    }

                    function deleteCategory(id) {
                        
                        $.ajax({
                        
                            url: "{{ url('superadmincategorydelete/') }}/" + id,
                            type: 'DELETE',
                            
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            
                            success: function(response) {
                                
                                Swal.fire(
                                    'Category Deleted!',
                                    'The category has been deleted.',
                                    'success'
                                ).then(() => {

                                    $('#addedlibrary_table').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                            
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the category.',
                                    'error'
                                );
                            }
                        });
                    
                    }

// // this is for the message 
//     $(function() {
       
//         $('#chat-submit').on('click', function(e) {
       
//         var messageform = {
           
//             'recipient_id': selectedUserId, 
//             'conversation': $('#conversation').val(),
//             'timestamp': new Date().getTime()
//         };

//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });

//         $.ajax({
//             type: 'POST',
//             url: 'send_message',
//             data: messageform,
//             dataType: 'json',
//             success: function(response) {
             
//                 $('#conversation').val('');
//                 Swal.fire({
//                 position: 'top-end',
//                 title: 'Message Sent',
//                 text: `Wait for the response for the recipients`,
//                 icon: 'success',
//                 showConfirmButton: false,
//                 timer: 2000
//               });
           
//                 const messageBubble = document.createElement('div');
//                 messageBubble.classList.add('message-bubble', 'outgoing');
//                 messageBubble.textContent = messageform.conversation;
//                 document.getElementById('message-container').appendChild(messageBubble);

               
//                 if (response.chat_history && response.chat_history.length > 0) {
//                     const messageContainer = document.getElementById('message-container');
//                     response.chat_history.forEach(message => {
//                         const chatBubble = document.createElement('div');
//                         chatBubble.classList.add('message-bubble', message.sender_id === sender_id ? 'outgoing' : 'incoming');
//                         chatBubble.textContent = message.message;
//                         messageContainer.appendChild(chatBubble);
//                     });
//                 }
                
//                 const messageContainer = document.getElementById('message-container');
//                 messageContainer.scrollTop = messageContainer.scrollHeight;
            
//             }
//         });
//     });


//         $("#chat-circle").click(function() {    
//             $("#chat-circle").toggle('scale');
//             $(".chat-box").toggle('scale');
//         })
        
//         $(".chat-box-toggle").click(function() {
//             $("#chat-circle").toggle('scale');
//             $(".chat-box").toggle('scale');
//         });
     
        
//  })
 document.addEventListener("click", function(event) {
    const ripple = document.createElement("div");
    ripple.className = "cursor-ripple";
    document.body.appendChild(ripple);
    
    ripple.style.left = `${event.clientX}px`;
    ripple.style.top = `${event.clientY}px`;
    
    ripple.addEventListener("animationend", function() {
        ripple.remove();
    });
});


</script>


    </body>
</html>