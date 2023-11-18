{{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
<div class="topbar">
    @if(Session::has('success'))
        <style>
    
        @keyframes bounce {
                0%, 20%, 50%, 80%, 100% {
                    transform: translateY(0);
                }
                40% {
                    transform: translateY(-20px);
                }
                60% {
                    transform: translateY(-10px);
                }
            }


            #success-alert {
                animation: bounce 1s ease;
                animation-iteration-count: 1;
            }
        </style>
        <div id="success-alert" class="alert alert-success" style="width: 40%;position: absolute;z-index:5;text-align:center;margin-left:15%;margin-top:10px">
            <strong>{{ Session::get('success') }}</strong>
        </div>
        <script>
            setTimeout(function() {
                $('#success-alert').fadeOut('fast');
            }, 3000); 
        </script>
    @endif
    <div id="reading_success" style="width: 40%;position: absolute;z-index:5;text-align:center;margin-left:15%;margin-top:10px"></div>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
        {{-- <div class="logo_section">
            <a href="/home"><img class="img-responsive" src="{{ asset('pluto/images/logo/logo_white.png') }}" alt="#" /></a>
        </div> --}}
        <div class="right_topbar">
            <div class="icon_info">
                <ul>
                    {{-- <li>
                        @php
                        $userRole = Auth::user()->role;
                        @endphp
                    
                        @if ($userRole == 0 || $userRole == 1)
                        <a href="#" id="notification-icon">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge" id="notification-badge">
                                0 <!-- Initially set to zero -->
                            </span>
                        </a>
                        <div class="alert alert-info" id="notification-alert" role="alert" style="display: none; position: absolute; top: 40px; width: 400px; right: 10px; z-index: 1000;">
                            You have <span id="notification-count">0</span> Notifications from your report logs <br><a href="reportLogs" style="font-size:15px;color: black">View details</a>
                        </div>
                        @endif
                    </li>
                    
                    <script>
                        $(document).ready(function () {
                            // Function to update the notification count
                            function updateNotificationCount() {
                                $.get('/get-latest-notification-count', function (data) {
                                    $('#notification-badge').text(data.latestCount);
                                });
                            }
                    
                            // Initial notification count update
                            updateNotificationCount();
                    
                            // Click event for the notification badge
                            $('#notification-icon').on('click', function (e) {
                                e.preventDefault();
                    
                                // Mark notifications as viewed and update count
                                $.get('/mark-notifications-as-viewed', function () {
                                    updateNotificationCount(); // Update the count on click
                                });
                            });
                        });
                    </script> --}}
                    
                        
                        
                    
                    <li>
                        <a href="/chatify" id="message-icon">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge">
                                @php
                                use Illuminate\Support\Facades\Auth;
                                use Illuminate\Support\Facades\DB;
                
                                $authUserId = Auth::user()->id;
                
                                $messageCount = DB::table('ch_messages')
                                    ->where('to_id', $authUserId)
                                    ->count();
                
                                echo $messageCount;
                                @endphp
                            </span>
                        </a>
                        {{-- <div class="alert alert-success" role="alert" id="message-alert" style="display: none; position: absolute; top: 40px;width:400px; right: 10px; z-index: 1000;">
                            @php
                            $convo = DB::table('ch_messages')->count();
                            @endphp
                            There are {{ $messageCount }} messages. Reply to them!
                            <br>
                            <a href="/chatify" class="details_link">
                                <button class="btn btn-info"><span style="color:black"><i class="fa-brands fa-facebook-messenger fa-2x"></i> Messenger</span></button>
                            </a>
                        </div> --}}
                    </li>
                </ul>
                
                    <script>
                          $('#notification-icon').click(function() {
                            $('#notification-alert').toggle();
                        });
                        // $('#message-icon').click(function() {
                        //     $('#message-alert').toggle();
                        // });
                       
                    </script>
                    
                    
                    
                    
                <ul class="user_profile_dd">
                    <li>
                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" style="height: 35px; object:fit;" src="{{ asset('storage/' . Auth::user()->image) }}" alt="#" /><span class="name_user">
                        @php
                        $user = Auth::user();
                        $fullName = $user->name;
                        $nameParts = explode(' ', $fullName);
                        $firstName = $nameParts[0];
                    @endphp
                    
                    {{ $firstName }}</span></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/superadmin">My Profile</a>
                        {{-- @if(Auth::user()->role == 0 || Auth::user()->role == 1)
                        <a class="dropdown-item" href="/about-rate">Rate / Holidays</a>
                        @else
                        @endif --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }} <i class="fa fa-sign-out"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
</div>