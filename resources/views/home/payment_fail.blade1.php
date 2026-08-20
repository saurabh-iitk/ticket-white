<style>
    #marquee_topbar {
        display: none;
    }

    .navbar-nav-wrap-content,
    .navbar-collapse {
        visibility: hidden;
    }
</style>
<style>
    footer {
        display: none;
    }

    tr {
        border: 1px solid #ccc;
        line-height: 35px;
    }

    td {
        padding: 0px 15px;
    }

    th {
        margin-left: 40px;
    }

    .table td,
    .table th {
        padding: 0.15rem !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<div class="container space-top-3 space-top-md-2 space-top-lg-3">
    <h2 style="text-align: center;"> Payment Failed</h2>
    <div class="row justify-content-md-center">
        <table id="example" class="table table-striped table-bordered" style="width:60%; margin:0 20%">
            <thead>
                <tr>
                    <td>Transaction Details</td>
                    <td>Transaction Value </td>

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
                    <td> {{ $error_Message }}</td>
                </tr>
                <tr>
                    <td>Payment Time </td>
                    <td> {{ $addedon }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- ========== END MAIN CONTENT ========== -->

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>



<script type="text/javascript">
    $('#example').DataTable({
        dom: 'Bfr',
        searching: false,
        sorting: false,
        buttons: [{
            extend: 'pdf',
            text: 'Download Details'
        }]
    });
</script>
