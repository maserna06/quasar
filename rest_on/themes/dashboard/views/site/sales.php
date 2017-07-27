<?php

use App\User\User as U;
$user = U::getInstance();

if ($user->isSuper) {
    $condition = "sale_status <> 3 ";
    $order = "company_id ASC, sale_consecut DESC";
} else {
    if ($user->isVendor && (!$user->isSuper && !$user->isAdmin && !$user->isSupervisor)) {
        $condition = "sale_status <> 3 AND company_id = " . $user->companyId .
                " AND user_id = " . Yii::app()->user->getId();
        $order = "sale_consecut DESC";
    } else {
        $condition = "sale_status <> 3 AND company_id = " . $user->companyId;
        $order = "sale_consecut DESC";
    }
}

$sales = new CActiveDataProvider('Sales', array(
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
<div class="modal fade" id="modal-sales" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header-sales">
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
                                        'name' => 'sale_id',
                                        'source' => $this->createUrl('site/salesAutoComplete'),
                                        'options' => array(
                                            'minLength' => '2',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'form-control',
                                            'placeholder' => '# Venta',
                                            'style' => 'text-align: center;'
                                        ),
                                    ));
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-6">
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'sale_datestart',
                                            'language' => 'es',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => 'readonly',
                                                'class' => 'form-control',
                                                'maxlength' => '10',
                                                'style' => 'text-align: center;',
                                                'id' => 'sale_datestart',
                                                'placeholder' => date('Y-m-d'),
                                                'value' => date('Y-m-d'),
                                            ),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'sale_dateend',
                                            'language' => 'es',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => 'readonly',
                                                'class' => 'form-control',
                                                'maxlength' => '10',
                                                'style' => 'text-align: center;',
                                                'id' => 'sale_dateend',
                                                'placeholder' => date('Y-m-d'),
                                                'value' => date('Y-m-d'),
                                            ),
                                        ));
                                        ?>
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    echo CHtml::dropDownList('', 'customer_nit', CustomersExtend::customerCompany(), array('class' => 'form-control customer', 'prompt' => '--Seleccione Cliente--'));
                                    ?> 
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" class="btn btn-success btn-block btn-search-product" onclick="showFilteredResultsSales()">Buscar</a>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div id="purchases-list">
                                <div class="col-sm-12">
                                    <div class="row-fluid">      
                                        <?php
                                        $this->widget('zii.widgets.CListView', array(
                                            'dataProvider' => $sales,
                                            'itemView' => 'sales_views',
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
                            <div id="sales-list-filtered">
                                <div class="col-sm-12">
                                    <div class="row-fluid">  
                                        <div class="col-sm-3">
                                            <div class="purchase">
                                                <div class="market">
                                                    <div class="purchase-info">
                                                        <p class="purchase-title">
                                                            Venta #  <span id="sale_consecut_f"></span>
                                                            <span id="sale_status_f"></span>
                                                        </p>
                                                        <p><span class="purchase-label">Fecha</span>:<span id="sale_date_f"></span></p>
                                                        <p>

                                                        </p>
                                                        <p><span class="purchase-label">Pedido</span>: <span id="sale_order_id_f"></span></p>
                                                    </div>
                                                    <div>
                                                        <div class="purchase-remarks">    
                                                            <span id="sale_remarks_f"></span>
                                                        </div>
                                                        <p align="center">
                                                            <a href="#" class="btn btn-success btn-block">Detalle</a>
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
            <div class="modal-footer" id="footer-sales">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function saleDetails(id) {
        jQuery.ajax({
            url: "Site/Venta/" + id,
            type: "get",
            success: function (data, status) {
                sale_ = jQuery.parseJSON(data);

            }
        });
    }

    function showFilteredResultsSales() {
        if ($("#sale_id").val() != "") {
            $.ajax({
                url: "Site/VentaAjax/" + $("#sale_id").val(),
                type: "get",
                success: function (data, status) {
                    sale_ = $.parseJSON(data);
                    $("#sales-list").hide();
                    $('#sales-list-filtered').show();
                    if (sale_.sale_consecut != null) {
                        $("#sale_consecut_f").html(sale_.sale_consecut);
                        $("#sale_order_id_f").html(sale_.sale_order_id);
                        $("#sale_date_f").html(sale_.sale_date);
                        $("#sale_remarks_f").html(sale_.sale_remarks);
                        var status = sale_.sale_status;
                        if (status == 0)
                            $("#sale_status_f").html('<i class="fa fa-circle  text-warning"></i>');
                        else if (status == 1)
                            $("#sale_status_f").html('<i class="fa fa-circle  text-success"></i>');
                        else
                            $("#sale_status_f").html('<i class="fa fa-circle  text-danger"></i>');
                        $("#sales-list-filtered .purchase a").attr("disabled", false);
                        $("#sales-list-filtered .purchase a").attr('href', 'javaScript:saleDetails(' + sale_.sale_id + ')');
                    } else
                    {
                        $("#sale_consecut_f").html($("#purchase_id").val());
                        $("#sale_order_id_f").html("NAN");
                        $("#sale_date_f").html("NAN");
                        $("#sale_remarks_f").html("NO EXISTE");
                        $("#sale_status_f").html('<i class="fa fa-circle  text-danger"></i>');
                        $("#sales-list-filtered .purchase a").attr('disabled', 'disabled');
                    }
                }
            });
        } else {
            $("#sales-list").show();
            $('#sales-list-filtered').hide();
        }
    }

    $(function () {
        $('#sales-list-filtered').hide();
    });
</script> 