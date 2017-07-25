<?php

use App\User\User as U;

$user = U::getInstance();
if ($user->isSuper) {
    $condition = "purchase_status <> 3 ";
    $order = "company_id ASC, purchase_consecut DESC";
} else {
    if ($user->isVendor) {
        $condition = "purchase_status <> 3 AND company_id = " . $user->companyId .
                " AND user_id = " . Yii::app()->user->getId();
        $order = "purchase_consecut DESC";
    } else {
        $condition = "purchase_status <> 3 AND company_id = " . $user->companyId;
        $order = "purchase_consecut DESC";
    }
}

$purchases = new CActiveDataProvider('Purchases', array(
    'criteria' => array(
        'condition' => $condition,
    ),
    'sort' => array(
        'defaultOrder' => $order,
    ),
    'pagination' => array(
        'PageSize' => 8,
    )
));
?>
<style type="text/css">

    .modal {
      text-align: center;
      padding: 0!important;
    }

    .modal:before {
      content: '';
      display: inline-block;
      height: 100%;
      vertical-align: middle;
      margin-right: -4px;
    }

    .modal-dialog {
      display: inline-block;
      text-align: left;
      vertical-align: middle;
    }

    .ui-datepicker{ z-index:1151 !important; }

    .allSection { min-height: 550px;max-height: 550px; }

    .form_filter{ border: 1px solid #f3f3f3;border-radius: 6px;padding-bottom: 1%;background-color: #f4f4f4; }

    .market{ border: 1px solid #f4f4f4; }

</style>
<div class="modal fade" id="modal-purchases" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header-purchases">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" >&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <section class="allSection">
                    <div class="col-sm-12">
                        <div class="col-sm-12 form_filter">
                            <form onsubmit="return false;" class="modal-search">
                                <div class="col-sm-2">
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                        'name' => 'purchase_id',
                                        'source' => $this->createUrl('site/purchasesAutoComplete'),
                                        'options' => array(
                                            'minLength' => '2',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'form-control',
                                            'placeholder' => '# Compra',
                                            'style' => 'text-align: center;'
                                        ),
                                    ));
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-6">
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'purchase_datestart',
                                            'language' => 'es',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => 'readonly',
                                                'class' => 'form-control',
                                                'maxlength' => '10',
                                                'style' => 'text-align: center;',
                                                'id' => 'purchase_datestart',
                                                'placeholder' => date('Y-m-d'),
                                                'value' => date('Y-m-d'),
                                            ),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'purchase_dateend',
                                            'language' => 'es',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => 'readonly',
                                                'class' => 'form-control',
                                                'maxlength' => '10',
                                                'style' => 'text-align: center;',
                                                'id' => 'purchase_dateend',
                                                'placeholder' => date('Y-m-d'),
                                                'value' => date('Y-m-d'),
                                            ),
                                        ));
                                        ?>
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                        echo CHtml::dropDownList('', 'supplier_nit', SuppliersExtend::supplierCompany(), array('class' => 'form-control', 'prompt' => '--Seleccione--'));
                                    ?> 
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" class="btn btn-primary btn-block btn-search-product" onclick="showFilteredResults()">Buscar</a>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div id="purchases-list">
                                <div class="col-sm-12">
                                    <div class="row-fluid">      
                                        <?php
                                        $this->widget('zii.widgets.CListView', array(
                                            'dataProvider' => $purchases,
                                            'itemView' => 'purchases_views',
                                            'pager' => array('htmlOptions' => array('class' => 'pagination pull-right'),
                                                'header' => '',
                                                'firstPageLabel' => '<<',
                                                'lastPageLabel' => '>>',
                                                'prevPageLabel' => '<',
                                                'nextPageLabel' => '>',),
                                            'pagerCssClass' => 'col-sm-12',
                                            'template' => "{sorter}\n{items}\n{pager}",
                                        ));
                                        ?>
                                    </div>    
                                </div>
                            </div>
                            <div id="purchases-list-filtered">
                                <div class="col-sm-12">
                                    <div class="row-fluid">  
                                        <div class="col-sm-3">
                                            <div class="purchase">
                                            <div class="market">
                                                <div class="purchase-info">
                                                    <p class="purchase-title">
                                                        Compra #  <span id="purchase_consecut_f"></span>
                                                        <span id="purchase_status_f"></span>
                                                    </p>
                                                    <p><span class="purchase-label">Fecha</span>:<span id="purchase_date_f"></span></p>
                                                    <p>

                                                    </p>
                                                    <p><span class="purchase-label">Orden</span>: <span id="purchase_order_id_f"></span></p>
                                                </div>
                                                <div>
                                                    <div class="purchase-remarks">    
                                                        <span id="purchase_remarks_f"></span>
                                                    </div>
                                                    <p align="center">
                                                        <a href="#" class="btn btn-primary btn-block">Detalle</a>
                                                    </p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <div class="modal-footer" id="footer-purchases">
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function purchaseDetails(id) {
        jQuery.ajax({
            url: "Site/Compra/" + id,
            type: "get",
            success: function (data, textStatus) {
                purchase_ = jQuery.parseJSON(data);
                
            }
        });
    }

    function showFilteredResults() {
        if ($("#purchase_id").val() != "") {
            $.ajax({
                url: "Site/CompraAjax/" + $("#purchase_id").val(),
                type: "get",
                success: function (data, status) {
                    purchase_ = $.parseJSON(data);
                    $("#purchases-list").hide();
                    $('#purchases-list-filtered').show();
                    if(purchase_.purchase_consecut != null) {
                        $("#purchase_consecut_f").html(purchase_.purchase_consecut);
                        $("#purchase_order_id_f").html(purchase_.purchase_order_id);
                        $("#purchase_date_f").html(purchase_.purchase_date);
                        $("#purchase_remarks_f").html(purchase_.purchase_remarks);
                        var status = purchase_.purchase_status;
                        if (status == 0)
                            $("#purchase_status_f").html('<i class="fa fa-circle  text-warning"></i>');
                        else if (status == 1)
                            $("#purchase_status_f").html('<i class="fa fa-circle  text-success"></i>');
                        else
                            $("#purchase_status_f").html('<i class="fa fa-circle  text-danger"></i>');
                        $("#purchases-list-filtered .purchase a").attr("disabled", false);
                        $("#purchases-list-filtered .purchase a").attr('href','javaScript:purchaseDetails(' + purchase_.purchase_id + ')');
                    }else
                    {
                        $("#purchase_consecut_f").html($("#purchase_id").val());
                        $("#purchase_order_id_f").html("NAN");
                        $("#purchase_date_f").html("NAN");
                        $("#purchase_remarks_f").html("NO EXISTE");
                        $("#purchase_status_f").html('<i class="fa fa-circle  text-danger"></i>');
                        $("#purchases-list-filtered .purchase a").attr('disabled', 'disabled');
                    }
                }
            });
        } else {
            $("#purchases-list").show();
            $('#purchases-list-filtered').hide();
        }
    }

    $(function () {
        $('#purchases-list-filtered').hide();
    });
</script> 