@extends('client.index')

@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Cart</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Cart</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!--cart Start-->
    <section>
        <div class="container pt-120 pb-100">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
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
                                    <tr class="cart_item">
                                        <td class="product-remove"><a title="Remove this item" class="remove"
                                                href="#">×</a></td>
                                        <td class="product-thumbnail"><a href="#"><img alt="product"
                                                    src="{{ asset('client/images/resource/products/1.jpg') }}"></a></td>
                                        <td class="product-name"><a href="shop-product-details.html">Winter Black Jacket</a>
                                            <ul class="variation">
                                                <li class="variation-size">Size: <span>Medium</span></li>
                                            </ul>
                                        </td>
                                        <td class="product-price"><span class="amount">$36.00</span></td>
                                        <td class="product-quantity">
                                            <div class="product-details__quantity">
                                                <div class="quantity-box">
                                                    <button type="button" class="sub"><i
                                                            class="fa fa-minus"></i></button>
                                                    <input type="number" id="1" value="1" />
                                                    <button type="button" class="add"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span class="amount">$36.00</span></td>
                                    </tr>
                                    <tr class="cart_item">
                                        <td class="product-remove"><a title="Remove this item" class="remove"
                                                href="#">×</a></td>
                                        <td class="product-thumbnail"><a href="#"><img alt="product"
                                                    src="{{ asset('client/images/resource/products/2.jpg') }}"></a></td>
                                        <td class="product-name"><a href="shop-product-details.html">Swan Crop V-Neck
                                                Tee</a>
                                            <ul class="variation">
                                                <li class="variation-size">Size: <span>Small</span></li>
                                            </ul>
                                        </td>
                                        <td class="product-price"><span class="amount">$115.00</span></td>
                                        <td class="product-quantity">
                                            <div class="product-details__quantity">
                                                <div class="quantity-box">
                                                    <button type="button" class="sub"><i
                                                            class="fa fa-minus"></i></button>
                                                    <input type="number" id="1" value="1" />
                                                    <button type="button" class="add"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span class="amount">$115.00</span></td>
                                    </tr>
                                    <tr class="cart_item">
                                        <td class="product-remove"><a title="Remove this item" class="remove"
                                                href="#">×</a></td>
                                        <td class="product-thumbnail"><a href="#"><img alt="product"
                                                    src="{{ asset('client/images/resource/products/3.jpg') }}"></a></td>
                                        <td class="product-name"><a href="shop-product-details.html">Blue Solid Casual
                                                Shirt</a>
                                            <ul class="variation">
                                                <li class="variation-size">Size: <span>Large</span></li>
                                            </ul>
                                        </td>
                                        <td class="product-price"><span class="amount">$68.00</span></td>
                                        <td class="product-quantity">
                                            <div class="product-details__quantity">
                                                <div class="quantity-box">
                                                    <button type="button" class="sub"><i
                                                            class="fa fa-minus"></i></button>
                                                    <input type="number" id="1" value="1" />
                                                    <button type="button" class="add"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span class="amount">$68.00</span></td>
                                    </tr>
                                    <tr class="cart_item">
                                        <td colspan="3">
                                            
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                        <td><button type="button" class="theme-btn btn-style-one"><span
                                                    class="btn-title">Thêm Món</span></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 mt-30">
                        <div class="row">
                            <div class="col-md-5">
                                <h4>Thông tin phòng</h4>
                                <form class="form" action="#">

                                    <div class="mb-10">
                                        <input type="text" class="form-control" placeholder="Số Phòng"
                                            value="">
                                    </div>
                                    <div class="mb-30">
                                        <button type="button" class="theme-btn btn-style-one"><span
                                                class="btn-title">Thêm</span></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-5">
                                <h4>Tổng thanh toán</h4>
                                <table class="table table-bordered cart-total">
                                    <tbody>
                                        <tr>
                                            <td>Cart Subtotal</td>
                                            <td>$180.00</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping and Handling</td>
                                            <td>$70.00</td>
                                        </tr>
                                        <tr>
                                            <td>Order Total</td>
                                            <td>$250.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a class="theme-btn btn-style-one" href="shop-checkout.html"><span
                                        class="btn-title">Tiến hành thanh toán</span> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
