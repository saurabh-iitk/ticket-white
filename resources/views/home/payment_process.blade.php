

<h1>Please Wait, Processing.....</h1>
<form action='{{$PAYU_URL}}' method='post' id="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">
   <input type="hidden" name="key" value="{{$PAYU_KEY}}" />
    <input type="hidden" name="txnid" value="{{$txnid}}" />
    <input type="hidden" name="productinfo" value="{{$productinfo}}" />
    <input type="hidden" name="amount" value="{{$amount}}" />
    <input type="hidden" name="email" value="{{$email}}" />
    <input type="hidden" name="firstname" value="{{$name}}" />
    <input type="hidden" name="lastname" value="{{$name}}" />
    <input type="hidden" name="surl" value="{{ route('payment_success', $user_id_txn ) }}" />
    <input type="hidden" name="furl" value="{{ route('payment_fail', $user_id_txn ) }}" />
    <input type="hidden" name="phone" value="{{$mobile}}" />
    <input type="hidden" name="hash" value="{{$hash}}" />
    <input type="hidden" name="service_provider" value="payu_paisa"  /><br />
    <input type="hidden" name="enforce_paymethod" value="upi"  /><br />
    <input type="submit" value="submit" style="display: none;"> 
</form>
<script>
  document.getElementById("form").submit();
</script>
