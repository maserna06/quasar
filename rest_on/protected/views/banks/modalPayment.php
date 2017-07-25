<style type="text/css">

    .btn-payment {
        border: 1px solid #ddd;
		background-color: #f4f4f4;
		text-align: center;
		max-width: 46%;
		height: 100%;
		padding: 5%;
		border-radius: 3px;
		position: relative;
		margin: 0% 2% 3% 2%;
		color: #666;
    }

    .btn-payment:hover {
        background-color: #e7e7e7;
    }

    .btn-payment img{
    	width: 65%;
    }

    .btn-number {
        border: 1px solid #ddd;
        background-color: #f4f4f4;
        text-align: center;
        max-width: 31%;
        height: 100%;
        padding: 3.8%;
        border-radius: 3px;
        position: relative;
        margin: 1%;
        font-weight: bold;
        color: #666;
    }

    .marginContend
    {
        padding: 1%;
        border: 1px solid #ddd;
        margin: 1%;
        min-height: 300px;
    }

    .marginContendxs
    {
        padding: 1%;
        border: 1px solid #ddd;
        margin: 1%;
        min-height: 170px;
        max-height: 170px;
        overflow-y: scroll;
    }

    .titleContend
    {
        color: gray;
        text-align: center;
        font-size: 14px;
        padding: 0 0 2% 0;
        margin: 2% 0 4% 0;
    }

    .titleContendLg
    {
        color: gray;
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        padding: 0;
        margin: 1% 0% 0% 5%;
    }

    .textMargin
    {
        padding: 1%;
        border: 1px solid #ddd;
        margin: 0% 0% 0.5% 1%;
        min-height: 40px;
        background-color: #f4f4f4;
    }

    .textCount
    {
        padding: 1%;
        border: 1px solid #ddd;
        margin: 1% 0% 1% 1%;
        min-height: 40px;
        background-color: #f4f4f4;
        width: 97%;
    }

    .titleCount
    {
        color: #000;
        text-align: right;
        font-size: 22px;
        font-weight: bold;
        padding: 0;
        margin: 1% 2% 1% 1%;
    }

    .name_payment
    {
        text-align: left;
        font-weight: bold;
    }

    .value_payment
    {
        text-align: right;
    }

    .fa-times
    {
        cursor: pointer;
    }

</style>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'banks-form',
    'htmlOptions' => array("class" => "form",
        'onsubmit' => "return false;", /* Disable normal form submit */
    ),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        'afterValidate' => 'js:mySubmitFormFunction', // Your JS function to submit form
    )
        ));
?>
    <!--***************************** MEDIOS DE PAGO *****************************-->
   
<div class="col-xs-6 col-md-6 col-lg-6">
    <div class="col-xs-12 col-md-12 col-lg-12 marginContend payments_">

        <h3 class="page-header titleContend">Escoge el método de pago</h3>
        <div class="col-xs-6 btn btn-payment" id="Visa" name="Visa">
        	<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/credit/visa.png', '', array('class' => '')) ?>
        </div>
        <div class="col-xs-6 btn btn-payment" id="Amex" name="Amex">
        	<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/credit/american-express.png', '', array('class' => '')) ?>
        </div>
        <div class="col-xs-6 btn btn-payment" id="Cirrus" name="Cirrus">
        	<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/credit/cirrus.png', '', array('class' => '')) ?>
        </div>
        <div class="col-xs-6 btn btn-payment" id="Mastercard" name="Mastercard">
        	<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/credit/mastercard.png', '', array('class' => '')) ?>
        </div>
        <div class="col-xs-6 btn btn-payment" id="PayPal" name="PayPal">
        	<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/credit/paypal2.png', '', array('class' => '')) ?>
        </div>
        <div class="col-xs-6 btn btn-payment" id="Efectivo" name="Efectivo">
        	<?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/credit/cash.png', '', array('class' => '')) ?>
        </div>                

    </div>
    <div class="col-xs-12 col-md-12 col-lg-12 marginContend numbers_ hide">
    <input type="hidden" name="txt_nums" id="txt_nums">
        <h3 class="page-header titleContend">teclado numerico</h3>
        <div class="col-xs-12 col-md-12 col-lg-12 textCount">                        
            <p class="titleCount">$0</p>            
        </div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="1" name="1">1</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="2" name="2">2</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="3" name="3">3</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="4" name="4">4</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="5" name="5">5</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="6" name="6">6</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="7" name="7">7</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="8" name="8">8</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="9" name="9">9</div>
        <div class="col-xs-4 btn btn-number " id="back_" name="back_">Atras</div>
        <div class="col-xs-4 btn btn-number btn-numberClick" id="0" name="0">0</div>
        <div class="col-xs-4 btn btn-number " id="ok_" name="ok_">Hecho</div>
    </div>
</div>
<div class="col-xs-6 col-md-6 col-lg-6">
    <div class="col-xs-12 col-md-12 col-lg-12 marginContendxs" id="div-total">
        <input type="hidden" name="txt_payment" id="txt_payment">
        <h3 class="page-header titleContend">total formas de pago</h3>
        <div class="lbl_payment"></div>
    </div>
    <div class="col-xs-12 col-md-12 col-lg-12 textMargin">
        <input type="hidden" name="txt_network" id="txt_network">      
        <p class="titleContendLg">Falta: $0</p>
        
    </div>
    <div class="col-xs-12 col-md-12 col-lg-12 textMargin">
        <input type="hidden" name="txt_total" id="txt_total">        
        <p class="titleContendLg lblTotal">TOTAL: $0</p>        
    </div>
    <div class="col-xs-12 col-md-12 col-lg-12" style="padding: 0 0 0 2%;">
        <input id="savePayment" class="btn btn-block btn-primary btn-lg" name="yt0" type="button" value="PAGAR">
    </div>
</div> 

<?php $this->endWidget(); ?>

<script>
    jQuery(function ($) {
        $('#section_1').on('click', function(){
            alert(1);
        });
        
        $('#txt_payment').on('click', '.delete_', function () {
            alert(1);
        });
        //Init Values
        $('#txt_payment').val('');
        $('#txt_total').val(0);

        //Count Payments
        var i = 0;

        //Click to Numbers Contend
        $('.btn-payment').on('click', function (e) {
            e.preventDefault();
            $('#txt_payment').val($(this).attr('id'));
            $('.payments_').addClass('hide');
            $('.numbers_').show();
            $('.numbers_').removeClass('hide');
        });

        //Click to Numbers Contend
        $('.btn-numberClick').on('click', function (e) {
            e.preventDefault();
            var nums = $(this).attr('id');
            $('#txt_nums').val($('#txt_nums').val()+nums);
            $('.titleCount').html("$ "+$('#txt_nums').val());
        });

        //Click to Payments Contend
        $('#back_').on('click', function (e) {
            e.preventDefault();
            $('#txt_payment').val('');
            $('.numbers_').addClass('hide');
            $('.payments_').show();
            $('.payments_').removeClass('hide');
            $('.titleCount').html("$ 0");
            $('#txt_nums').val('');
        });

        //Click to Print Payments
        $('#ok_').on('click', function (e) {
            e.preventDefault();
            //Increment Count
            i++;

            //Totals
            var tt = (parseInt($('#txt_total').attr('value')) + parseInt($('#txt_nums').attr('value')));
            $('#txt_total').val(tt);
            $('.lblTotal').html('TOTAL: $'+tt);

            //Print Data
            var row = '<div class="col-xs-4 name_payment section_'+i+'">'+$('#txt_payment').val()+'</div><div class="col-xs-6 value_payment section_'+i+'"> $ '+$('#txt_nums').val()+'</div><div class="col-xs-1"><i class="fa fa-times delete_" id="section_'+i+'"></i></div>';
            var payments = $('.lbl_payment').html()+row;
            $('.lbl_payment').html(payments);

            //Reset Form
            $('#txt_payment').val('');
            $('.numbers_').addClass('hide');
            $('.payments_').show();
            $('.payments_').removeClass('hide');
            $('.titleCount').html("$ 0");
            $('#txt_nums').val('');
        });

        //Click to Numbers Contend
        $('.delete_').on('click', function (e) {
            e.preventDefault();
            $('.'+$(this).attr('id')).addClass('hide');
        });

    });
</script>