<form id="processPaymentForm" action="{{ route('purchase') }}" method="POST">
    @csrf
    <input type="hidden" name="payable_type" value="{{ $payable_type }}"> <!-- Payable type: 'subscription' or 'certificate' -->
    <input type="hidden" name="payable_id" value="{{ $payable_id }}"> <!-- Payable ID: ID of the subscription or certificate -->
    <input type="hidden" name="user_id" value="{{ auth()->id() }}"> <!-- User ID: Current authenticated user's ID -->
    <input type="hidden" name="amount" value="{{ $amount }}"> <!-- Amount: The payment amount -->
    <button type="submit">Proceed to Payment</button>
</form>


<script>
    // Automatically submit the form when the page loads
    document.getElementById('processPaymentForm').submit();
</script>
