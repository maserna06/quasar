<style type="text/css">  
    .content-wharehouses {
        position: relative;
        z-index: 1;
        overflow-y: scroll;
        height: 400px; }
    .parent-display {
        padding: 0 4px; }
    .display-wharehouse {
        border-right: 1px solid #ccc;
        margin: 10px 0;
        padding: 7px 10px 5px 10px; }
    .display-wharehouse label {
        cursor: pointer;
        width: 100%; }
    .display-wharehouse label input[type='checkbox'] {
        display: inline-block;
        width: 20px !important;
        vertical-align: middle; }
    .display-wharehouse label img {
        display: inline-block;
        vertical-align: top; }
    .display-wharehouse label .small {
        vertical-align: middle;
        text-align: center;
        width: 90%;
        text-align: left;
        margin-top: 6px; }
    .display-wharehouse label .small.small {
        display: inline-block;
        font-size: 1rem; }
    .display-wharehouse label .small h3 {
        margin: 0;
        font-size: 1.3rem;
        transition: all 0.3s;
        font-weight: 600; }
    .display-wharehouse label .small h3 span {
        font-size: 0.9em;
        font-weight: normal;
        width: 100%;
        display: block; }
    .display-wharehouse label .toogle-check {
        display: inline-block; }
    .display-wharehouse:nth-child(4n+0) {
        border-right: none; }
    .display-wharehouse:hover label .small h3 {
        text-shadow: 1px 1px 5px #6d6d6d; }
    .default-3d {
        position: relative;
        border: 0 !important;
        cursor: pointer;
        -webkit-font-smoothing: antialiased;
        font-weight: bold !important;
        -webkit-border-radius: 10px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 10px;
        -moz-background-clip: padding;
        border-radius: 10px;
        background-clip: padding-box;
        -webkit-transition: all 50ms ease;
        -moz-transition: all 50ms ease;
        -o-transition: all 50ms ease;
        transition: all 50ms ease;
        border: 0;
        text-shadow: 0px 1px 0px #e0e0e0;
        background-color: #fafafa;
        -webkit-box-shadow: 0px 6px 0px #e0e0e0;
        -moz-box-shadow: 0px 6px 0px #e0e0e0;
        box-shadow: 0px 6px 0px #e0e0e0; }
    .default-3d:focus {
        outline: 0; }
    .default-3d.active {
        top: 3px;
        border: 0;
        background-color: #008d4c !important;
        color: #FFF;
        -webkit-box-shadow: 0px 4px 0px #e0e0e0;
        -moz-box-shadow: 0px 4px 0px #e0e0e0;
        box-shadow: 0px 4px 0px #e0e0e0; }
    .default-3d:hover, .default-3d:active{
        top: 6px;
        -webkit-box-shadow: inset 0px 3px 0px #00a65a;
        -moz-box-shadow: inset 0px 3px 0px #00a65a;
        box-shadow: inset 0px 3px 0px #00a65a; }
    @media (max-width: 768px) {
    .toogle-check {
        float: right;
        margin-top: 10px; } }
</style>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'wharehouseclassification-form',
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
    ),
        ));
?>
<div class="col-md-12 col-md-offset-0">
    <div class="col-xs-12 main_">
        <div class="row">
            <div class="col-sm-12 content-wharehouses">
              <div class="row-fluid">
              <?php foreach ($wharehouses as $wharehouse): ?>
                <div class="col-xs-12 col-sm-6 col-md-3 parent-display">
                  <div class="display-wharehouse default-3d ">
                    <label for="wharehouse-<?php echo $wharehouse['wharehouse_id'] ?>">
                      <div class="small">
                        <h3>
                            <?php echo $wharehouse['wharehouse_name'] ?>
                            <span style="margin-top: 1%;">
                                <b>DIR: </b><?php echo ($wharehouse['wharehouse_address']) ?>
                            </span>
                        </h3>
                      </div>
                      <div class="hidden toogle-check btn btn-danger">Off</div>
                      <div class="hidden">
                        <input <?php
                        if (isset($wharehouse['wharehouse_related']) && $wharehouse['wharehouse_related'] == $wharehouse['wharehouse_id']) {
                          echo ' checked ';
                        }
                        ?> name="wharehouse[<?php echo $wharehouse['wharehouse_id'] ?>]" id="wharehouse-<?php echo $wharehouse['wharehouse_id'] ?>" value="<?php echo $wharehouse['wharehouse_id'] ?>" type="checkbox" />
                      </div>
                    </label>
                  </div>
                </div>
              <?php endforeach; ?>
              </div>
            </div>        
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script languaje="javascript">
  jQuery(function ($) {
    var checkbox = $('input[type="checkbox"]');
    $.each(checkbox, function (key, item) {
      parentActive(item);
      $(item).on('click', function () {
        parentActive(item);
      });
    });
    function parentActive(e) {
      $parent = $(e).parents('.display-wharehouse');
      if ($(e).is(':checked')) {
        $($parent).addClass('active');
        $($parent).find('.toogle-check').addClass('btn-success').removeClass('btn-danger').html('On');
      } else {
        $($parent).removeClass('active');
        $($parent).find('.toogle-check').removeClass('btn-success').addClass('btn-danger').html('Off');
      }
    }
    $('.small').children('h3').slimScroll({
      height: '45px'
    });
  });
</script>