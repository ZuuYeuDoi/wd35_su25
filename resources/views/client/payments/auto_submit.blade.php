<form id="paymentForm" action="{{ route('payment.create') }}" method="POST">
    @csrf
    <input type="hidden" name="booking_id" value="{{ $booking_id }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
</form>
<script>
    document.getElementById('paymentForm').submit();
</script>
