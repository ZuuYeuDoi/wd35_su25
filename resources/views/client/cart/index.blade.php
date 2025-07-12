@extends('client.index')

@push('css')
    <style>
        .quantity-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .qty-btn {
            width: 48px;
            height: 48px;
            font-size: 28px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .qty-btn:hover {
            background: #f1f1f1;
        }

        .qty-input {
            width: 60px;
            height: 48px;
            text-align: center;
            font-size: 24px;
            background: #f7f8fa;
            border-radius: 12px;
            border: none;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
    </style>
@endpush

@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Giỏ hàng</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li>Giỏ hàng</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container pt-120 pb-100">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        @if ($cart && $cart->services->count())
                            <form action="{{ route('cart.update') }}" method="POST" id="cartForm">
                                @csrf
                                <table class="table table-striped table-bordered tbl-shopping-cart">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Ảnh</th>
                                            <th>Tên Món</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart->services as $item)
                                            @php
                                                $inputId = 'qty-' . $item->id;
                                                $maxQty = $item->service->quantity;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <button type="submit"
                                                        formaction="{{ route('cart.remove', $item->id) }}"
                                                        formmethod="POST" class="remove-btn"
                                                        onclick="return confirm('Xóa sản phẩm này?')">
                                                        @csrf
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $item->service->image) }}"
                                                        width="60" alt="Ảnh sản phẩm">
                                                </td>
                                                <td>{{ $item->service->name }}</td>
                                                <td>{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                                                <td>
                                                    <div class="quantity-box">
                                                        <button type="button" class="qty-btn btn-minus"
                                                            data-target="{{ $inputId }}" data-min="1">−</button>
                                                        <input type="number" id="{{ $inputId }}"
                                                            name="quantities[{{ $item->id }}]"
                                                            value="{{ $item->quantity }}" min="1"
                                                            max="{{ $maxQty }}" class="qty-input"
                                                            data-max="{{ $maxQty }}" />
                                                        <button type="button" class="qty-btn btn-plus"
                                                            data-target="{{ $inputId }}"
                                                            data-max="{{ $maxQty }}">+</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="amount" id="subtotal-{{ $item->id }}">
                                                        {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }} đ
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-warning">Cập nhật</button>
                            </form>

                            <!-- Form đặt món -->
                            <form action="{{ route('cart.orderUser') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                @foreach ($cart->services as $item)
                                    <input type="hidden" name="quantities[{{ $item->id }}]"
                                        id="order-qty-{{ $item->id }}" value="{{ $item->quantity }}">
                                @endforeach
                                <button type="submit" class="btn btn-success">Đặt món</button>
                            </form>
                        @else
                            <p class="text-center">Không có sản phẩm nào trong giỏ hàng.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const inputId = this.getAttribute('data-target');
                const input = document.getElementById(inputId);
                const max = parseInt(input.getAttribute('max'));
                let value = parseInt(input.value) || 1;
                if (value < max) {
                    input.value = value + 1;
                    input.dispatchEvent(new Event('input'));
                }
            });
        });

        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const inputId = this.getAttribute('data-target');
                const input = document.getElementById(inputId);
                let value = parseInt(input.value) || 1;
                if (value > 1) {
                    input.value = value - 1;
                    input.dispatchEvent(new Event('input'));
                }
            });
        });

        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('input', function() {
                let value = parseInt(this.value) || 1;
                const min = parseInt(this.getAttribute('min')) || 1;
                const max = parseInt(this.getAttribute('max'));
                if (value < min) value = min;
                if (value > max) value = max;
                this.value = value;

                const row = this.closest('tr');
                if (row) {
                    const price = parseInt(row.querySelector('td:nth-child(4)').innerText.replace(/\D/g, ''));
                    row.querySelector('.amount').innerText = (value * price).toLocaleString('vi-VN') + ' đ';
                }

                const hiddenInput = document.getElementById('order-qty-' + this.id.replace('qty-', ''));
                if (hiddenInput) {
                    hiddenInput.value = this.value;
                }
            });
        });
    </script>
@endpush
