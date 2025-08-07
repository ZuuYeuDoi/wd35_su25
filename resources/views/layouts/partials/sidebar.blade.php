       <aside id="sidebar-left" class="sidebar-left">
           <div class="sidebar-header">
               <div class="sidebar-title">
                   Điều hướng
               </div>
               <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html"
                   data-fire-event="sidebar-left-toggle">
                   <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
               </div>
           </div>
           <div class="nano">
               <div class="nano-content">
                   <nav id="menu" class="nav-main" role="navigation">
                       <ul class="nav nav-main">
                           <li>
                               <a class="nav-link" href="{{ route('dashboard.index') }}">
                                   <i class="fas fa-dollar-sign" aria-hidden="true"></i>
                                   <span>Thống kê</span>
                               </a>
                           </li>
                           <li>
                               <a class="nav-link" href="/admin/info">
                                   <i class="bx bx-home-alt" aria-hidden="true"></i>
                                   <span>Thông tin khách sạn</span>
                               </a>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="bx bx-home-alt" aria-hidden="true"></i>
                                   <span>Quản lý Loại Phòng</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="{{ route('room_types.index') }}">
                                           Danh sách loại Phòng
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="bx bx-home-alt" aria-hidden="true"></i>
                                   <span>Quản lý Phòng</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="{{ route('room.index') }}">
                                           Danh sách Phòng ({{$countRooms ?? '0'}})
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="{{ route('room.map') }}">
                                           Sơ đồ Phòng
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="{{ route('room_order.index') }}">
                                           Đơn đặt
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="bx bx-cog" aria-hidden="true"></i>
                                   <span>Quản lý Tiện ích</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="{{ route('amenitie.index') }}">
                                           Danh sách tiện ích
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="bx bx-cog" aria-hidden="true"></i>
                                   <span>Quản lý Dịch vụ</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="{{ route('services.index') }}">
                                           Danh sách Dịch vụ
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="fas fa-user" aria-hidden="true"></i>
                                   <span>Quản lý Hóa đơn</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="{{ route('bills.index') }}">
                                           Danh sách Hóa đơn
                                       </a>
                                   </li>
                               </ul>
                           </li>

                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="bx bx-home-alt" aria-hidden="true"></i>
                                   <span>Quản lý Sự kiện</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="#">
                                           Danh sách Sự kiện
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="#">
                                           Đơn đặt
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="#">
                                           Dịch vụ Sự kiện
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="fas fa-user" aria-hidden="true"></i>
                                   <span>Quản lý Người dùng</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="/admin/users">
                                           Danh sách Người dùng
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="/admin/add-user">
                                           Thêm Người dùng
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="javascript:void(0)">
                                   <i class="fas fa-user" aria-hidden="true"></i>
                                   <span>Quản lý Nhân viên</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="/admin/staffs">
                                           Danh sách Nhân viên
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="/admin/add-staff">
                                           Thêm Nhân viên
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li>
                               <a class="nav-link" href="{{ route('admin.comment.index') }}">
                                   <i class="bx bx-envelope" aria-hidden="true"></i>
                                   <span>Quản lý Bình luận</span>
                               </a>
                           </li>
                           <li>
                               <a class="nav-link" href="/admin/">
                                   <i class="fas fa-user" aria-hidden="true"></i>
                                   <span>Quản lý hỏi đáp (tư vấn)</span>
                               </a>
                           </li>
                           <li>
                               <a class="nav-link" href="/admin/media-gallery">
                                   <i class="fas fa-life-ring" aria-hidden="true"></i>
                                   <span>Quản lý Kho ảnh</span>
                               </a>
                           </li>
                           <li class="nav-parent">
                               <a class="nav-link" href="#">
                                   <i class="bx bx-cart-alt" aria-hidden="true"></i>
                                   <span>eCommerce</span>
                               </a>
                               <ul class="nav nav-children">
                                   <li>
                                       <a class="nav-link" href="ecommerce-dashboard.html">
                                           Dashboard
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-products-list.html">
                                           Products List
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-products-form.html">
                                           Products Form
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-category-list.html">
                                           Categories List
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-category-form.html">
                                           Category Form
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-coupons-list.html">
                                           Coupons List
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-coupons-form.html">
                                           Coupons Form
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-orders-list.html">
                                           Orders List
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-orders-detail.html">
                                           Orders Detail
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-customers-list.html">
                                           Customers List
                                       </a>
                                   </li>
                                   <li>
                                       <a class="nav-link" href="ecommerce-customers-form.html">
                                           Customers Form
                                       </a>
                                   </li>
                               </ul>
                           </li>
                           <li>
                               <a class="nav-link" href="mailbox-folder.html">
                                   <span class="float-end badge badge-primary">182</span>
                                   <i class="bx bx-envelope" aria-hidden="true"></i>
                                   <span>Mailbox</span>
                               </a>
                           </li>
                       </ul>
                   </nav>
               </div>
               <script>
                   // Maintain Scroll Position
                   if (typeof localStorage !== 'undefined') {
                       if (localStorage.getItem('sidebar-left-position') !== null) {
                           var initialPosition = localStorage.getItem('sidebar-left-position'),
                               sidebarLeft = document.querySelector('#sidebar-left .nano-content');
                           sidebarLeft.scrollTop = initialPosition;
                       }
                   }
               </script>
           </div>
       </aside>
