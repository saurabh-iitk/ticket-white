@extends('layouts.app')
@section('style')
<style>
.show_on_mobile
{
    display:none !important;
}

.bringer-backlight
{
    z-index:-9999;
}
#bringer-header.is-sticky
{
    top:0 !important;
}
@media screen and (max-width: 600px) {
    .show_on_mobile
    {
        display:block !important;
    }

    .hide_on_mobile
    {
        display:none !important;
    }

    .bringer-bento-grid-mobile
    {
        grid-auto-flow: row !important;
    }


}
</style>
@endsection

@section('main_content')
<div class="stg-container">
    <div class="container">
        <div class="row" style="text-align: center; margin-top:100px; margin-bottom:60px; overflow-x:scroll ">
            <h2 style="text-align: center; margin:0 auto; "> Sorry ! Your Ticket Booking has been Failed.<Br><Br></h2>
            <table id="example" class="table table-striped table-bordered responsive" style="width:100%; margin:0 auto; max-width:600px; ">
                <thead>
                    <tr>
                        <th>Transaction Details</th>
                        <th>Transaction Value </th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Payment Status </td>
                        <td style="color:red"> {{ $status }}</td>
                    </tr>
                    <tr>
                        <td>Transaction ID </td>
                        <td> {{ $txnid }}</td>
                    </tr>
                    <tr>
                        <td>Bank Ref. Number </td>
                        <td> {{ $bank_ref_num }}</td>
                    </tr>
                    <tr>
                        <td>PG Transaction ID </td>
                        <td> {{ $mihpayid }}</td>
                    </tr>
                    <tr>
                        <td>Name </td>
                        <td> {{ $firstname }}</td>
                    </tr>
                    <tr>
                        <td>Email </td>
                        <td> {{ $email }}</td>
                    </tr>
                    <tr>
                        <td>Mobile </td>
                        <td> {{ $phone }}</td>
                    </tr>
                    <tr>
                        <td>Reason </td>
                        <td> <?php $msg = $error_Message; $msg = json_decode($error_Message); if(isset($msg->note)) {echo $msg->note; }?></td>
                    </tr>
                    <tr>
                        <td>Payment Time </td>
                        <td> {{ $addedon }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
    $("#download_pdf").on("click", function () {
        // Initialize jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Add title to PDF
        doc.text("<?php echo env('APP_NAME'); ?> Magic Show Ticket", 16, 16);

        // Add table from HTML to PDF
        doc.autoTable({
            html: '#example',
            startY: 20, // Adjust as necessary to avoid overlap with title
            theme: 'striped', // You can change the theme: 'plain', 'striped', 'grid'
        });

        // Save the PDF
        doc.save("OP_Sharma_Magic_Show_Ticket.pdf");
    });
});

    posthog.capture('Payment Failed', {
        transaction_id: '@php echo $txnid @endphp',
        email: '@php echo $email @endphp',
        mobile: '@php echo $phone @endphp',
    });
        
        
   $('.bringer-button ').hide();
</script>


@endsection

