<!DOCTYPE html>
<html>
<body>
    <h1>Loan Status Update</h1>
    <p>Your loan (ID: {{ $loan->id }}) for ${{ $loan->amount }} has been {{$loan->status}}.</p>
    <p>Update Date: {{ date($loan->updated_at) }}</p>
</body>
</html>