<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
            <a href="/home"><img class="logo_icon img-responsive" src="{{ asset('pluto/images/logo/naawan_icon.png') }}" alt="#" /></a>
            </div>
        </div>
        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
            <div class="user_img"><img class="img-responsive" style="height: 75px; width:75px; object-fit: cover;" src="{{ asset('storage/' . Auth::user()->image) }}" alt="#" /></div>
            <div class="user_info">
                <h6>   @php
                    $user = Auth::user();
                    $fullName = $user->name;
                    $nameParts = explode(' ', $fullName);
                    $firstName = $nameParts[0];
                @endphp
                
                {{ $firstName }}</h6>
                <p><span class="online_animation"></span> Online</p>
            </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">
        <h4>M E E D O</h4>
        <ul class="list-unstyled components">
            @php
                $role = Auth::user()->role;
            @endphp
            @if($role == 0 || $role == 1)
                {{-- SUPER ADMIN & ADMIN --}}
                <li><a href="/home"><i class="fa fa-laptop yellow_color"></i> <span>Dashboard</span></a></li>
                <li>
                    <a href="#billing" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-dollar orange_color"></i> <span>Billing</span></a>
                    <ul class="collapse list-unstyled" id="billing">
                        <li>
                            <a href="/superAdmincustomer"><i class="fa fa-user"></i> <span>Customer</span></a>
                        </li>
                        <li>
                            <a href="/billing.reading-sheet"><i class="fa fa-book"></i> <span>Reading Sheet</span></a>
                        </li>
                        <li>
                            <a href="/reading"><i class="fa fa-book"></i> <span>Reading</span></a>
                        </li>
                        <li>
                            <a href="/billingmonth"><i class="fa fa-money-bill-1-wave"></i> <span>Billing Month</span></a>
                        </li>
                        <li>
                            <a href="/billing-statement"><i class="fa fa-file-invoice-dollar"></i> <span>Billing Statement</span></a>
                        </li>
                        <li>
                            <a href="/billing.miscellaneous_list"><i class="fa fa-user"></i> <span style="font-size:12px">Customer Misc</span></a>
                        </li>
                         <li>
                            <a href="/disconnection-notice"><i class="fa fa-warning" style="color:yellow"></i> <span style="font-size:12px">Disconnection Notice</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#collection" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tasks blue1_color"></i> <span>Collections</span></a>
                    <ul class="collapse list-unstyled" id="collection">
                        <li><a href="/collection.receipt"><i class="fa fa-receipt"></i> <span>Abstract of Receipt</span></a></li>

                        <li><a href="/collection.AbstractCollection"><i class="fa fa-shopping-cart"></i> <span>Abstract of Collection</span></a></li>
                        <li>
                            <a href="/consumer-ledger"><i class="fa fa-user blue2_color"></i> <span>Consumer's Ledger</span></a>
                        </li>
                        <li>
                            <a href="/treasurer-account-receivables"><i class="fa fa-user blue2_color"></i> <span>Account Receivables</span></a>
                        </li>
                    </ul>
                </li>
              
                <li>
                    <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-file-text-o red_color"></i> <span>Reports</span></a>
                    <ul class="collapse list-unstyled" id="reports">
                        <li><a href="/master-list"><i class="fa fa-book"></i> <span>Master List</span></a></li>
                        <li><a href="/reports.aging-account-list"><i class="fa fa-calendar"></i> <span>Aging of Accounts</span></a></li>
                        <li><a href="/monthly-billing-sum"><i class="fa fa-calendar"></i> <span>Monthly Billing</span></a></li>
                        <li><a href="/monthly-collection"><i class="fa fa-calendar"></i> <span>Monthly Collection</span></a></li>
                        <li><a href="/reportLogs"><i class="fa fa-clock"></i> <span>Report Logs</span></a></li>
                    </ul>
                </li>
                <li><a href="/library"><i class="fa fa-book purple_color2"></i> <span>Library</span></a></li>
                <li>
                    <a href="/about-rate"><i class="fa fa-calendar"></i> <span>Rate / Holidays</span></a>
                </li>
                <li>
                    <a href="/user.superAdmin"><i class="fa fa-users blue2_color"></i> <span>User Management</span></a>
                </li>
                
            @elseif($role == 2)
                {{-- TREASURER --}}
                <li>
                    <a href="/collection.treasurer-receipt"><i class="fa-solid fa-receipt green2_color"></i> <span>Receipt</span></a>
                </li>
               
               
                <li>
                    <a href="#collection" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tasks blue1_color"></i> <span>Inquiry</span></a>
                    <ul class="collapse list-unstyled" id="collection">
                        <li><a href="/collection.receipt"><i class="fa fa-receipt"></i> <span>Abstract of Receipt</span></a></li>

                        <li><a href="/collection.AbstractCollection"><i class="fa fa-shopping-cart"></i> <span>Abstract of Collection</span></a></li>
                        <li>
                            <a href="/treasurer-account-receivables"><i class="fa fa-user blue2_color"></i> <span>Account Receivables</span></a>
                        </li>
                        <li>
                            <a href="/consumer-ledger"><i class="fa fa-user blue2_color"></i> <span>Consumer's Ledger</span></a>
                        </li>
                      
                    </ul>
                </li> 
            @elseif($role == 3)
                {{-- ENCODER --}}
                <li><a href="/billing.encoder-billing"><i class="fa fa-book yellow_color"></i> <span>Input Reading</span></a></li>
                <li>
                    <a href="#billing" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-dollar orange_color"></i> <span>Billing</span></a>
                    <ul class="collapse list-unstyled" id="billing">
                        <li>
                            <a href="/reading"><i class="fa fa-book"></i> <span>Reading</span></a>
                        </li>
                        <li>
                            <a href="/billing.reading-sheet"><i class="fa fa-book"></i> <span>Reading Sheet</span></a>
                        </li>
                      
                        <li>
                            <a href="/billing-statement"><i class="fa fa-file-invoice-dollar"></i> <span>Billing Statement</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#collection" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tasks blue1_color"></i> <span>Collection</span></a>
                    <ul class="collapse list-unstyled" id="collection">
                        <li>
                            <a href="/treasurer-account-receivables"><i class="fa fa-user blue2_color"></i> <span>Account Receivables</span></a>
                        </li>
                        <li>
                            <a href="/consumer-ledger"><i class="fa fa-user blue2_color"></i> <span>Consumer's Ledger</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-file-text-o red_color"></i> <span>Reports</span></a>
                    <ul class="collapse list-unstyled" id="reports">
                        <li><a href="/master-list"><i class="fa fa-book"></i> <span>Master List</span></a></li>
                        <li><a href="/reports.aging-account-list"><i class="fa fa-calendar"></i> <span>Aging of Accounts</span></a></li>
                        <li><a href="/monthly-billing-sum"><i class="fa fa-calendar"></i> <span>Billing Summary</span></a></li>
                        <li><a href="/monthly-collection"><i class="fa fa-calendar"></i> <span>Collection Summary</span></a></li>
                        {{-- <li><a href="/reportLogs"><i class="fa fa-rocket"></i> <span>Report Logs</span></a></li> --}}
                    </ul>
                </li>
            @elseif($role == 4)
            <li>
                <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-file-text-o red_color"></i> <span>Reports</span></a>
                <ul class="collapse list-unstyled" id="reports">
                    <li><a href="/master-list"><i class="fa fa-book"></i> <span>Master List</span></a></li>
                    <li><a href="/reports.aging-account-list"><i class="fa fa-calendar"></i> <span>Aging of Accounts</span></a></li>
                    <li><a href="/monthly-billing-sum"><i class="fa fa-calendar"></i> <span>Billing Summary</span></a></li>
                    <li><a href="/monthly-collection"><i class="fa fa-calendar"></i> <span>Collection Summary</span></a></li>

                </ul>
            </li>
            <li>
                <a href="#billing" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-dollar orange_color"></i> <span>Billing</span></a>
                <ul class="collapse list-unstyled" id="billing">
                    <li>
                        <a href="/reading"><i class="fa fa-book"></i> <span>Reading</span></a>
                    </li>
                    <li>
                        <a href="/billing.reading-sheet"><i class="fa fa-book"></i> <span>Reading Sheet</span></a>
                    </li>
                  
                    <li>
                        <a href="/billing-statement"><i class="fa fa-file-invoice-dollar"></i> <span>Billing Statement</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#collection" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-tasks blue1_color"></i> <span>Inquiry</span></a>
                <ul class="collapse list-unstyled" id="collection">
                    <li>
                        <a href="/treasurer-account-receivables"><i class="fa fa-user blue2_color"></i> <span>Account Receivables</span></a>
                    </li>
                    <li>
                        <a href="/consumer-ledger"><i class="fa fa-user blue2_color"></i> <span>Consumer's Ledger</span></a>
                    </li>
                    <li><a href="/collection.receipt"><i class="fa fa-receipt"></i> <span>Abstract of Receipt</span></a></li>

                    <li><a href="/collection.AbstractCollection"><i class="fa fa-shopping-cart"></i> <span>Abstract of Collection</span></a></li>
                </ul>
            </li> 
          
            @else
            @endif
            
        </ul>
        <script>
        
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.list-unstyled.components li');
            
            menuItems.forEach(item => {
                const link = item.querySelector('a');

                if (link.getAttribute('href') === currentPath) {
                    item.classList.add('active');

                    const dropdownToggle = link.closest('.dropdown-toggle');
                    if (dropdownToggle) {
                        dropdownToggle.parentNode.classList.add('active');

                        const dropdownMenu = dropdownToggle.nextElementSibling;
                        if (dropdownMenu) {
                            dropdownMenu.classList.add('show');
                        }
                    }

                    if (currentPath === '/superAdmincustomer' || currentPath === '/billingmonth' || currentPath === '/reading' || currentPath === '/billing.reading-sheet'|| currentPath ==='/billing-statement' || currentPath === '/billing.miscellaneous_list'|| currentPath === '/disconnection-notice') {
                        const billingDropdown = document.querySelector('#billing');
                        if (billingDropdown) {
                            billingDropdown.classList.add('show');
                        }
                    }

                    if (currentPath === '/treasurer-account-receivables' || currentPath === '/collection.receipt' || currentPath === '/collection.AbstractCollection' || currentPath === '/consumer-ledger') {
                        const collectionsDropdown = document.querySelector('#collection');
                        if (collectionsDropdown) {
                            collectionsDropdown.classList.add('show');
                        }
                    }

                    if (currentPath === '/master-list' || currentPath === '/reports.aging-account-list' || currentPath === '/monthly-billing-sum' || currentPath === '/monthly-collection' || currentPath === '/reportLogs') {
                        const reportsDropdown = document.querySelector('#reports');
                        if (reportsDropdown) {
                            reportsDropdown.classList.add('show');       
                        }
                    }
                }
            });

        </script>
    </div>
</nav>