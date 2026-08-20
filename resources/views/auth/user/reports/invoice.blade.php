<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice: {{$booking->invoice_no ?? ""}}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #333;
            border: 1px solid black;
            padding: 10px 0px;
            min-height: 900px; /* Approx height of A4 at 96 DPI */
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
       .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        }

        .logo {
        width: 400px;
        }

        .invoice-title {
        font-size: 20px;
        font-weight: bold;
        }
         .invoice-subtitle {
         margin-top: 5px;
         font-size: 15px !important; 
         display: flex;
        }
       

        .details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .details-box {
            width: 48%;
            padding: 10px;
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
        }

         .details-box1 {
            width: 48%;
            padding: 10px;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-bottom: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f3f3f3;
        }
        .tax-summary {
            width: 300px;
            float: right;
        }
        .signature-section {
            margin-top: 50px;
            clear: both;
            text-align: right;
        }
        .signature-section img {
            width: 100px;
            height: auto;
            margin-bottom: -10px;
        }
        .note {
            margin-top: 50px;
            font-size: 13px;
            color: #555;
        }
    </style>
</head>
<body>

<!-- First Row: Logos -->
<div class="header">
  <img src="https://magicianopsharma.co.in/assets/image/icon/prakash-magico-logo.png" class="logo" alt="Logo" style="width:350px">
  <div class="invoice-title">Tax Invoice<br> 
    <span class="invoice-subtitle">Invoice No: {{$booking->invoice_no ?? ""}}</span>
    <span class="invoice-subtitle">Invoice Date: {{ $booking->created_at ? $booking->created_at->format('d-m-Y') : '' }}</span>
    <span class="invoice-subtitle">Booking ID:: {{ $booking->booking_id_str ?? '' }}</span>
</div>
</div>

<!-- Second Row: Title -->

<div class="details">
    <div class="details-box">
        <strong>Customer Details:</strong><br>
        Name: {{$customer->customer_name ?? ""}}<br>
        Email: {{$customer->email ?? ""}}<br>
        Phone: {{"+91-".$customer->mobile_no ?? ""}}<br>
        Address: N/A<br>
        Place of Supply: {{ Str::title($event->city_name ?? '') }}, {{ Str::title($event->state_name ?? '') }}
    </div>

    <div class="details-box1">
        <strong>Company Details:</strong><br>
        {{$event->gst_name}}<br>
        GSTIN: {{$event->gst_no}}<br>
        Address: {{$event->gst_address}}<br>
        Email: info@magicianopsharma.com<br>
        Phone: +91-8882546585
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Service Description</th>
            <th>HSN/SAC</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i=1;
            if($bookings_get->is_gst_applicable == 0)
            {
                $ticket_rate = round($bookings_get->paid_amount/$bookings_get->total_quantity);
            }
            else
            {
                $ticket_rate =  $bookings_get->taxable_amount/$bookings_get->total_quantity;
            }
            
            $total_quantity = $bookings_get->total_quantity;
            $tax_value = $bookings_get->gst_amount * $bookings_get->total_quantity;
            
        @endphp
        <tr>
            <td>{{$i++}}</td>
            <td>Magic Show Entry Fee - {{ Str::title($bookings_get->ticket_type_name ?? '') }}</td>
            <td>999624</td>
            <td>{{$booking->total_quantity}}</td>
            <td>₹{{$ticket_rate}}</td>
            <td>₹{{$total_quantity * $ticket_rate}}</td>
        </tr>
    </tbody>
</table>

<div class="tax-summary">
   <table style="border-left:1px solid black">
        <thead>
             @if($tax_value > 0 || 1)
            <tr>
                <th>Tax</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
            @endif
        </thead>
        <tbody>
            
            @if($tax_value > 0)
                @if($taxType == "CGST_SGST")
                    <tr>
                        <td>CGST</td>
                        <td>9%</td>
                        <td>₹{{ number_format($tax_value / 2, 2) }}</td>
                    </tr>
                    <tr>
                        <td>SGST</td>
                        <td>9%</td>
                        <td>₹{{ number_format($tax_value / 2, 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td>IGST</td>
                        <td>18%</td>
                        <td>₹{{ number_format($tax_value, 2) }}</td>
                    </tr>
                @endif

            <tr>
                <th colspan="2">Total Tax</th>
                <th>₹{{ number_format($tax_value, 2) }}</th>
            </tr>
            @else
            
            
             <tr>
                        <td>GST</td>
                        <td>Nill</td>
                        <td>₹{{ number_format($tax_value, 2) }}</td>
                    </tr>

            <tr>
                <th colspan="2">Total Tax</th>
                <th>₹{{ number_format($tax_value, 2) }}</th>
            </tr>
            
            
            
            @endif
            <tr>
                <th colspan="2">Grand Total</th>
                <th>₹{{ number_format($bookings_get->paid_amount, 2) }}</th>
            </tr>
        </tbody>
    </table>
</div>

<div class="signature-section" style="visibility: hidden; height:280px">
    
</div>

<div class="note" style="width: 100%; text-align:center">
    This is a system generated invoice. No signature required.<br>
    Thank you for your business!
</div>

</body>
</html>
