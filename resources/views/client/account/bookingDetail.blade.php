@extends('client.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('client/css/account.css') }}">
@endpush

@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Chi tiết đặt phòng</h1>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="room-detail-wrapper">

            {{-- Thông tin cơ bản --}}
            @php
                $firstRoom = $booking->bookingRooms->first()?->room;
            @endphp
            <div class="room-basic-info">
                <div class="room-image">
                    <img  src="{{ asset('storage/' . ($firstRoom->images_room->first()->image_path ?? 'default.jpg')) }}"
                        alt="{{ $firstRoom->title ?? 'Phòng' }}">
                </div>
                <div class="room-info">

                    <div class="room-meta">
                        <span><i class="fas fa-building"></i> Tầng 5</span>
                        <span><i class="fas fa-users"></i> {{ $booking->adults ?? '---' }} người lớn</span>
                        <span><i class="fas fa-users"></i> {{ $booking->children ?? '---' }} trẻ em</span>
                        <span><i class="fas fa-ruler-combined"></i> 40m²</span>
                    </div>

                </div>
            </div>

            {{-- Thông tin đặt phòng --}}
            <div class="booking-details">
                <div class="detail-section">
                    <h3><i class="fas fa-calendar-alt"></i> Thông tin đặt phòng</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Mã đặt phòng</label>
                            <span>{{ $booking->booking_code }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Ngày đặt</label>
                            <span>{{ $booking->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Ngày nhận dự kiến</label>
                            <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Ngày trả dự kiến</label>
                            <span>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Số đêm</label>
                            @php
                                $nights = \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(
                                    $booking->check_out_date,
                                );
                            @endphp
                            <span>{{ $nights }} đêm</span>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3><i class="fas fa-concierge-bell"></i> Dịch vụ đã đặt</h3>
                    @if ($serviceItems->isEmpty())
                        <p>Không có dịch vụ nào được đặt.</p>
                    @else
                        <div class="amenities-grid">
                            @foreach ($serviceItems as $item)
                                <div class="amenity-item">
                                    <i class="fas fa-check"></i>
                                    <span>{{ $item->service->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="detail-section mt-4">
                    <h3><i class="fas fa-utensils"></i> Đồ ăn đã đặt</h3>
                    @if ($foodItems->isEmpty())
                        <p>Không có đồ ăn nào được đặt.</p>
                    @else
                        <div class="amenities-grid">
                            @foreach ($foodItems as $item)
                                <div class="amenity-item">
                                    <i class="fas fa-check"></i>
                                    <span>{{ $item->service->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>



                {{-- Các nút thao tác --}}
                <div class="action-buttons">
                    {{-- <button class="btn btn-primary">
                        <i class="fas fa-edit"></i> Yêu cầu thay đổi
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-times"></i> Hủy đặt phòng
                    </button> --}}
                    <button class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
