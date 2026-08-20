<!DOCTYPE html>
<html>

<head>
    <title>Booking Confirmation Mail</title>
</head>

<body>
    <p>Dear Customer,</p><br>
    Your Booking Details at <strong>Magician OP Sharma</strong> is here:
    <br>
    <br>
    Payment Status : <strong>{{ ucwords($data['status']) }}</strong><br>
    Booking ID : <strong>{{ $data['booking_id'] }}</strong><br>
    Paid Amount : <strong>{{ $data['amount'] }}</strong><br>
    Ticket (s) : <strong>{{ $data['tickets'] }}</strong><br>
    Show : <strong>{{ $data['show_name'] }}</strong><br>
    Venue : <strong>{{ $data['venue'] }}</strong><br>
    SW Transaction ID : <strong>{{ $data['txnid'] }}</strong><br>
    Bank Ref. Number : <strong>{{ $data['bank_ref_num'] }}</strong><br>
    Gateway Transaction ID : <strong>{{ $data['pg_txn'] }}</strong><br>
    Name : <strong>{{ $data['name'] }}</strong><br>
    Email : <strong>{{ $data['email'] }}</strong><br>
    Mobile : <strong>{{ trim($data['mobile']) }}</strong><br>
    Payment Time : <strong>{{ $data['updated_at'] }}</strong><br>
    <br>
    <br>
    Team OP Sharma
    <br>
    For Any Enquiry : +91-8882546585
    <br>
    <br>
    Note: This is not a Ticket, You can collect your Physical Ticket from Booking Counter by Showing this Booking
    Confirmation to our Counter Staff.
    <br>
    <br>
    ********** This is System Generated E-Mail, Please do not respond **********
</body>

</html>
