<!-- Your custom script -->
@push('css')
    <style>
        .search-popup .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            z-index: 1100;
        }
        .search-popup {
            overflow: auto;
        }

    </style>
@endpush

<header class="main-header header-style-five">

    <div class="header-lower">
        <!-- Main box -->
        <div class="main-box">
            <div class="logo-box">
                <div class="logo"><a href="index.html"><img src="{{ asset('client/images/logo-2.png') }}" alt=""
                            title="Hoteler"></a></div>
            </div>

            <!--Nav Box-->
            @include('client.layout.nav')

            <div class="outer-box">
                <div class="ui-btn-outer">
                    <button class="ui-btn ui-btn search-btn">
                        <span class="icon lnr lnr-icon-search"></span>
                    </button>
                    <a href="shop-cart.html" class="ui-btn cart-btn">
                        <i class="lnr-icon-shopping-cart"></i>
                        <span class="items-count">0</span>
                    </a>
                </div>
                <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                <!-- Mobile Nav toggler -->
            </div>
        </div>
        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            <nav class="menu-box">
                <div class="upper-box">
                    <div class="nav-logo"><a href="index.html"><img src="{{ asset('client/images/logo-2.png') }}"
                                alt=""></a></div>
                    <div class="close-btn"><i class="icon fa fa-times"></i></div>
                </div>
                <ul class="navigation clearfix">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </ul>
                <ul class="contact-list-one">
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <i class="icon lnr-icon-phone-handset"></i>
                            <span class="title">Gọi Ngay</span>
                            <a href="tel:+92880098670">+92 (8800) - 98670</a>
                        </div>
                    </li>
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <span class="icon lnr-icon-envelope1"></span>
                            <span class="title">Gửi Email</span>
                            <a
                                href="https://html.kodesolution.com/cdn-cgi/l/email-protection#95fdf0f9e5d5f6faf8e5f4fbecbbf6faf8"><span
                                    class="__cf_email__"
                                    data-cfemail="cba3aea7bb8ba8a4a6bbaaa5b2e5a8a4a6">[email&#160;protected]</span></a>
                        </div>
                    </li>
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <span class="icon lnr-icon-clock"></span>
                            <span class="title">Khung Giờ</span>
                            Thứ Hai - Thứ Bảy 8:00 - 6:30, Chủ Nhật - Đóng cửa
                        </div>
                    </li>
                </ul>
                <ul class="social-links">
                    <li><a href="#"><i class="fab fa-x-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </nav>
        </div><!-- End Mobile Menu -->

        <!-- Header Search -->
        <div class="search-popup">
            <span class="search-back-drop"></span>
            <button class="close-search"><span class="fa fa-times"></span></button>
            <div class="search-inner">

                @php
                    $childAges = old('child_ages', $childAges ?? []);
                @endphp

                <div class="bg-white shadow rounded px-4 py-3 mb-4">
                    <form action="{{ route('room.indexRoom') }}" method="GET">
                        <div class="row g-2 align-items-center">
                            <!-- Kiểu lưu trú -->
                            <div class="col-auto">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="stay_type" id="overnight"
                                        value="overnight" autocomplete="off"
                                        {{ old('stay_type', 'overnight') === 'overnight' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="overnight">Chỗ ở Qua Đêm</label>

                                    <input type="radio" class="btn-check" name="stay_type" id="dayuse"
                                        value="dayuse" autocomplete="off"
                                        {{ old('stay_type') === 'dayuse' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="dayuse">Chỗ ở Trong Ngày</label>
                                </div>
                            </div>

                            <!-- Ngày nhận/trả -->
                            <div class="col-md-auto">
                                <input type="text" name="check_in" id="check_in" class="form-control"
                                    placeholder="Ngày nhận phòng" value="{{ old('check_in', $checkIn ?? '') }}">
                            </div>
                            <div class="col-md-auto" id="checkout_container">
                                <input type="text" name="check_out" id="check_out" class="form-control"
                                    placeholder="Ngày trả phòng" value="{{ old('check_out', $checkOut ?? '') }}">
                            </div>

                            <!-- Dropdown chọn khách -->
                            <div class="col-md-auto position-relative">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <span id="guestSummary">Tổng số khách</span>
                                    </button>
                                    <div class="dropdown-menu p-3" style="min-width: 270px;">
                                        <div class="mb-2">
                                            <label>Phòng</label>
                                            <div class="input-group">
                                                <button class="btn btn-light" type="button"
                                                    onclick="adjustGuest('rooms', -1)">-</button>
                                                <input type="number" name="rooms" id="rooms"
                                                    value="{{ old('rooms', 1) }}" min="1"
                                                    class="form-control text-center" readonly>
                                                <button class="btn btn-light" type="button"
                                                    onclick="adjustGuest('rooms', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label>Người lớn</label>
                                            <div class="input-group">
                                                <button class="btn btn-light" type="button"
                                                    onclick="adjustGuest('adults', -1)">-</button>
                                                <input type="number" name="adults" id="adults"
                                                    value="{{ old('adults', 2) }}" min="1"
                                                    class="form-control text-center" readonly>
                                                <button class="btn btn-light" type="button"
                                                    onclick="adjustGuest('adults', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label>Trẻ em</label>
                                            <div class="input-group">
                                                <button class="btn btn-light" type="button"
                                                    onclick="adjustGuest('children', -1, true)">-</button>
                                                <input type="number" name="children" id="children"
                                                    value="{{ old('children', 0) }}" min="0"
                                                    class="form-control text-center" readonly>
                                                <button class="btn btn-light" type="button"
                                                    onclick="adjustGuest('children', 1, true)">+</button>
                                            </div>
                                            <small class="form-text text-muted mt-1">Nhập độ tuổi trẻ để xác định
                                                giá</small>
                                            <div id="children-ages"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nút tìm kiếm -->
                            <div class="col-md-auto">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- End Header Search -->

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="inner-container">
                    <!--Logo-->
                    <div class="logo">
                        <a href="index.html"><img src="{{ asset('client/images/logo-2.png') }}" alt=""></a>
                    </div>
                    <!--Right Col-->
                    <div class="nav-outer">
                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <div class="navbar-collapse show collapse clearfix">
                                <ul class="navigation clearfix">
                                    <!--Keep This Empty / Menu will come through Javascript-->
                                </ul>
                            </div>
                        </nav><!-- Main Menu End-->
                        <!--Mobile Navigation Toggler-->
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    </div>
                </div>
            </div>
        </div><!-- End Sticky Menu -->
    </div>
</header>

<script>
    function adjustGuest(field, delta, isChild = false) {
        const input = document.getElementById(field);
        let value = parseInt(input.value);
        value += delta;
        if (value < parseInt(input.min || 0)) value = parseInt(input.min || 0);
        input.value = value;
        updateGuestSummary();
        if (isChild) updateChildAgeInputs(value);
    }

    function updateGuestSummary() {
        const adults = document.getElementById('adults').value;
        const children = document.getElementById('children').value;
        document.getElementById('guestSummary').innerText = `${adults} người lớn, ${children} trẻ em`;
    }

    function updateChildAgeInputs(count) {
        const container = document.getElementById('children-ages');
        container.innerHTML = '';

        const savedAges = @json($childAges);

        if (count === 0) {
            container.innerHTML = '<div class="text-muted">Không có trẻ em</div>';
            return;
        }

        for (let i = 1; i <= count; i++) {
            const label = document.createElement('label');
            label.textContent = `Tuổi của Trẻ ${i}`;
            label.classList.add('mt-2');

            const select = document.createElement('select');
            select.name = 'child_ages[]';
            select.classList.add('form-select', 'mt-1');

            for (let age = 0; age <= 17; age++) {
                const option = document.createElement('option');
                option.value = age;
                option.textContent = `${age} tuổi`;
                if (savedAges[i - 1] !== undefined && parseInt(savedAges[i - 1]) === age) {
                    option.selected = true;
                }
                select.appendChild(option);
            }

            container.appendChild(label);
            container.appendChild(select);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateGuestSummary();
        updateChildAgeInputs(parseInt(document.getElementById('children').value));

        document.getElementById('overnight').addEventListener('change', function() {
            document.getElementById('checkout_container').style.display = 'block';
        });
        document.getElementById('dayuse').addEventListener('change', function() {
            document.getElementById('checkout_container').style.display = 'none';
        });

        flatpickr.localize(flatpickr.l10ns.vn);

        const checkIn = flatpickr("#check_in", {
            dateFormat: "d/m/Y",
            minDate: "today",
            onChange: function(selectedDates) {
                if (selectedDates.length) {
                    checkOut.set('minDate', new Date(selectedDates[0].getTime() + 86400000));
                }
            }
        });

        const checkOut = flatpickr("#check_out", {
            dateFormat: "d/m/Y",
            minDate: new Date().fp_incr(1)
        });

        // Ẩn check_out nếu là "dayuse"
        if (document.getElementById('dayuse').checked) {
            document.getElementById('checkout_container').style.display = 'none';
        }
    });
</script>
