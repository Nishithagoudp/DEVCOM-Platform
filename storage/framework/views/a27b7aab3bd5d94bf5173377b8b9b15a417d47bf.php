<form id="processPaymentForm" action="<?php echo e(route('purchase')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="payable_type" value="<?php echo e($payable_type); ?>"> <!-- Payable type: 'subscription' or 'certificate' -->
    <input type="hidden" name="payable_id" value="<?php echo e($payable_id); ?>"> <!-- Payable ID: ID of the subscription or certificate -->
    <input type="hidden" name="user_id" value="<?php echo e(auth()->id()); ?>"> <!-- User ID: Current authenticated user's ID -->
    <input type="hidden" name="amount" value="<?php echo e($amount); ?>"> <!-- Amount: The payment amount -->
    <button type="submit">Proceed to Payment</button>
</form>


<script>
    // Automatically submit the form when the page loads
    document.getElementById('processPaymentForm').submit();
</script>
<?php /**PATH C:\xampp\htdocs\DevCom\resources\views/dashboard/payments/process.blade.php ENDPATH**/ ?>