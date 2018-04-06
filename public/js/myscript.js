$('#auto-receipt-id').change(function() {
	if (this.checked) {
		$('#receipt-code').attr('disabled', true);
	}
	else {
		$('#receipt-code').attr('disabled', false);
	}
});

$('#tot').change(function() {
	
	if ($('#toa').val() > $('#tot').val()) {
		$('#toa').val($(this).val());	
	}
	$('#toa').attr('max', $(this).val());
});