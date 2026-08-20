<!DOCTYPE html>
<html>

<head>
    <title>Magician O P Sharma Jr Feedback</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- <script src="js/aws-sdk-2.771.0-sqs.min.js"></script> -->

    <script type="text/javascript">
    
   
    
        $(document).ready(function() {
            if ({{ is_null($booking->feedback_value) ? 'true' : 'false' }}) {
                $('body #screen-score').show();
                $('body #screen-score div.score img').on('click', function() {
                    $('.score').removeClass('highlighted-score');
                    $(this).addClass('highlighted-score');
                    var selectedVal = $(this).attr('val');
                    updateDescription(selectedVal);
                        $('.mybox').show();
                                    $(window).scrollTop(400); 

                });
            } else {
                $('body #screen-score').remove();
                var feedbackMessage = $(
                    '<div class="container"><div class="alert alert-info mt-5 text-center">You have submitted your feedback!</div></div>'
                );
                $('body').append(feedbackMessage);
            }
        });

        function updateDescription(val) {
            $('#feedback-hidden').val(val);
        }
     
      function send_data()
      {
          var textarea_val= $('#textarea-box').val();
            var feedback_type= $('#feedback-hidden').val();
            var txnid="<?php echo $txnid; ?>";
      
            $.ajax({
                type: 'POST',
                url: '{{ route('feedback.store', '') }}/' + txnid,
                data: {
                    _token: '{{ csrf_token() }}',
                    text: textarea_val,
                    id: txnid,
                    val: feedback_type,
                },
                success: function(response) {
                    if (response.success) {
                        alert('Feedback submitted successfully');
                         $('#textarea-box').val('');
                         $('#feedback-hidden').val('');
                        location.reload();
                    } else {
                        alert('You have submitted your feedback!');
                    }
                },
                error: function(xhr, status, error) {}
            });
            
      }
        
        
    </script>
    <style>
        body {
            margin-top: 10px;

        }

        .header {
            text-align: center;
        }

        .logo {
            width: 200px;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        #content>div {
            text-align: center;
            vertical-align: middle;
        }

        #screen-covid,
        #screen-score {
            margin-top: 5%;
        }

        #screen-covid .message,
        #screen-score .message {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        #screen-covid .score,
        #screen-score .score {
            display: inline-flex;
            padding: 10px;
            color: #E0E0E0;
            font-size: 1.5em;
        }

        #screen-score .score {
            background-color: #757575;
            /* border: 1px solid #757575; */
            border-radius: 10px;
        }

        #screen-covid .score>div {
            background-color: #212121;
            border: 1px solid #212121;
            border-radius: 10px;
            margin-right: 5px;
        }

        #screen-covid .score>div.blank-cell {
            background-color: inherit;
            border: none;
        }

        #screen-covid .score img,
        #screen-score .score img {
            width: 128px;
        }

        .hidden {
            display: none;
        }

        .category {
            text-align: center;
            margin-left: 20px;
            margin-right: 20px;
        }

        div.img-wrapper {
            display: inline-block;
            background-color: #212121;
            color: #BDBDBD;
            border-radius: 10px;
            border: 1px solid #212121;
            margin: 20px 0;
            padding: 10px;
            font-size: 1.2em;
        }

        #tc-category .selected,
        #fc-category .selected,
        #category-sub .selected {
            border: 3px solid #ED1B2F;
        }

        .th-sa-nu3 {
            font-size: 0.9em;
        }

        .rr-ef-tsn,
        .th-fq-ulw,
        .th-fd-wod {
            font-size: 0.8em;
        }

        #category-sub img,
        .category img {
            width: 100px;
        }

        .privilege {
            height: 128px;
        }

        .header div {
            text-align: center;
        }

        .mobile-visible {
            display: none;
        }

        #thankyou {
            margin-top: 35vh;
        }

        #thankyou img {
            width: 96px;
        }

        @media(max-width: 768px) {

            .message h2 {
                font-size: 1.5rem;
            }

            .message h3 {
                font-size: 1.2rem;
            }

            #screen-covid,
            #screen-score {
                margin-top: 0;
            }

            .blank-cell {
                display: none !important;
            }

            .header div {
                display: block;
            }

            .header div.hidden {
                display: none;
            }

            div.img-wrapper {
                margin: 10px 0;
            }

            #screen-covid .score img,
            #screen-score .score img,
            .img-wrapper img {
                width: 96px;
            }

            #screen-covid .score,
            #screen-score .score {
                display: inline-block;
                padding: 10px 0 0 0;
            }

            #screen-covid .score>div,
            #screen-score .score>div {
                margin-bottom: 10px;
                display: inline-grid;
            }


            .mobile-visible {
                display: block;
            }

            .touchpoint-fc {
                /*font-size:0.9em;*/
            }

            .rr-ef-tsn,
            .th-fq-ulw,
            .th-fd-wod,
            .th-sa-nu3 {
                font-size: 1.2em;
            }
        }

        @media (max-width: 576px) {
            .description {
                font-size: 0.8em;
                min-height: 52px;
            }

            .message h2 {
                font-size: 1.2rem;
            }

            .message h3 {
                font-size: 1.0rem;
            }

            #screen-covid .score img,
            #screen-score .score img,
            .img-wrapper img {
                width: 65px;
                min-height: 40px;
            }

            #fc-category .img-wrapper img {
                min-height: 88px;
            }

            #screen-score .score>div {
                margin-bottom: 0;
                display: inline-block;
            }

            #screen-covid .score>div {
                margin-bottom: 5px;
                display: inline-block;
            }
        }

        @media (max-width: 320px) {
            .description {
                font-size: 0.6em;
            }

            .message h2 {
                font-size: 1rem;
            }

            .message h3 {
                font-size: 0.8rem;
            }

            #screen-covid .score,
            #screen-score .score {
                padding: 5px 0 0 0;
            }
        }

        @media (orientation: landscape) {

            #screen-covid .score>div,
            #screen-score .score>div {
                display: inline-block;
            }
        }

        @media (orientation: landscape) and (max-width:830px) {

            #screen-covid .score>div,
            #screen-score .score>div {
                display: inline-grid;
            }
        }
        
        .mybox
        {
            margin: 0 auto;
            text-align: center;
            display: flex;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('home/logo/logo.png') }}" class="logo" />
    </div>
    <div id="content" class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div id="screen-score" class="col-lg-12 col-md-12 col-xs-12 col-sm-12" prev="" next="screen-touchpoint">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 message">
                <h2>How was your overall experience with Magician O P Sharma Jr?</h2>
            </div>
            <div class='score row col-lg-12 col-md-12 col-xs-12 col-sm-12'>
                <div class="col-lg-1 col-md-1 col-xs-12 col-sm-12  blank-cell">&nbsp;</div>
                <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12">

                    <img class="score" val="5" src="{{ asset('images/reason_excellent.png') }}" />
                    <div class="description">Very Good</div>
                </div>
                <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12">
                    <img class="score" val="4" src="{{ asset('images/reason_good.png') }}" />
                    <div class="description">Good</div>
                </div>
                <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12">
                    <img class="score" val="3" src="{{ asset('images/reason_average.png') }}" />
                    <div class="description">Average</div>
                </div>
                <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12">
                    <img class="score" val="2" src="{{ asset('images/reason_poor.png') }}" />
                    <div class="description">Poor</div>
                </div>
                <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12">
                    <img class="score" val="1" src="{{ asset('images/reason_very_poor.png') }}" />
                    <div class="description">Very Poor</div>
                </div>
                <div class="col-lg-1 col-md-1 col-xs-12 col-sm-12 blank-cell">&nbsp;</div>
            </div>
        </div>
        
        
       <div class="row mybox " id="" style="display:none; "> 
             
              <div class="col-lg-12">
                   <input id="feedback-hidden" type="hidden">
                    <textarea id="textarea-box" placeholder="Write your valuable feedback (Optional)"  style=" width: 300px;    height: 100px;"></textarea>
              </div>
     
       </div>
        
        
        
         <div class="row mybox " style="display:none; margin-bottom:20px;"> 
             
                <div class="col-lg-12" style="margin-top:-20px;">
                    <button id="submit" onclick="send_data()" style="background: rgb(252 192 22);color: rgb(0 0 0);border-radius: 10px;padding: 8px 30px;border-color: black;font-size: 24px;font-weight: bold;">Submit </button>
              </div>
          
            

       </div>
        
        
        
     
        
        <div id="thankyou" class="row" style="display: none;" prev="" next="thankyou">
           
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 hidden thankyou_logo">
                <img src="{{ asset('home/logo/logo.png') }}" />
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 message hidden score-5 score-4">
                <h2>Glad to know that you had a great experience</h2>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 message hidden score-3 score-2 score-1">
                <h2>Thank you for your feedback. We hope to improve your experience in future</h2>
            </div>
           
        </div>
        <div id="error" class="row" style="display: none;" prev="" next="">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 message">
                <h3>Sorry, you have an invalid resource. We are unable to process your request!</h3>
            </div>
        </div>
    </div>
</body>

</html>
<style>
    @media only screen and (max-width: 768px) {
        #screen-touchpoint {
            width: 100%;
        }
    }

    .highlighted-score {
        border: 2px solid red;
    }
</style>
<script>
    function hideFunction() {
        $('#closebtn').hide();
        $('#addnlbtn').hide();
    }
</script>