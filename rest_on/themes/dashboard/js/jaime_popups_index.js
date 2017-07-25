
jQuery(document).ready(function () {
    jQuery('#purchases-list-filtered').hide();
    jQuery('#sales-list-filtered').hide();
    jQuery('#users-list-filtered').hide();

    $(window).resize(function () {
        var $table = $('#product-details-grid table');
        $table.find('tr').children().each(function (i, v) {
            $(v).width($("#product-details-grid").width() + $("#product-details-grid").width() / 14);
        });

        $table.find('thead tr').children().each(function (i, v) {
            $(v).width($("#product-details-grid").width() + $("#product-details-grid").width() / 14);
        });
    });

    jQuery.ajax({
        url: "Sales/salesMonthlyIncrement",
        type: "get",
        success: function (data, textStatus) {
            jQuery("#sales-increment").html(data);
        }
    });
    
    if(typeof modalClone === 'undefined') {
        var modalClone = jQuery("#modal_0").clone();
    }
    
    jQuery('body').keyup(function (e) {
        if (e.which == 27) {
            jQuery('button.close').click();
            jQuery("#modal_0").replaceWith(modalClone);
        }
    });
    jQuery('button.close').click(function() {
            jQuery("#modal_0").replaceWith(modalClone);
    });
});

function purchaseDetails(id) {
    jQuery.ajax({
        url: "Site/Compra/" + id,
        type: "get",
        success: function (data, textStatus) {
            obj = jQuery.parseJSON(data);
            jQuery("#purchase_consecut").html(obj.purchase_consecut);
            jQuery("#purchase_date").html(obj.purchase_date);
            jQuery("#order_id").html(obj.purchase_order_id);
            jQuery("#purchase_net_worth").html(obj.purchase_net_worth);
            jQuery("#purchase_account_name").html(obj.purchase_account_name);
            jQuery("#purchase_company_logo").html('<img src="' + obj.purchase_company_logo + '">');
            jQuery("#purchase_company_name").html(obj.purchase_company_name);
            jQuery("#purchase_company_address").html(obj.purchase_company_address);
            jQuery("#purchase_supplier_name").html(obj.purchase_supplier_name);
            jQuery("#purchase_supplier_phone").html(obj.purchase_supplier_phone);
            jQuery("#purchase_supplier_address").html(obj.purchase_supplier_address);
            jQuery("#purchase_supplier_contact").html(obj.purchase_supplier_contact);
            jQuery("#purchase_user_name").html(obj.purchase_user_name);
            if (obj.purchase_status == 0) {
                jQuery("#purchase_status").html('<span title="pendiente.." class="badge bg-orange">Pendiente</span>');
            } else {
                if (obj.purchase_status == 1) {
                    jQuery("#purchase_status").html('<span title="paga.." class="badge bg-green">Paga</span>');
                } else {
                    jQuery("#purchase_status").html('<span title="descargada.." class="badge bg-red">Descargada</span>');
                }
            }
        }
    });


    jQuery.ajax({
        url: "Site/CompraDetalle/" + id,
        type: "get",
        success: function (data, status) {
            jQuery('a[href=#impuestos]').show();
            jQuery("#purchases-details").html(data);
            document.getElementById('tab1').click();
            document.getElementById('tab1').innerHTML = "Detalles de la Compra <span class='badge'>\n"
                    + jQuery("#detallesComprasCount").val() + "</span>";

            // Change the selector if needed                                       
            var $table = $('#product-details-grid table');

            jQuery("#purchase_taxes").html(jQuery("#totalImpuestos").val());
            jQuery("#purchase_total").html(jQuery("#total").val());
            /*     $bodyCells = $table.find('tbody tr:first').children(),
             colWidth;*/

            $table.find('tr').children().each(function (i, v) {
                $(v).width($("#product-details-grid").width() + $("#product-details-grid").width() / 18);
            });

            $table.find('thead tr').children().each(function (i, v) {
                $(v).width($("#product-details-grid").width() + $("#product-details-grid").width() / 18);
            });
            /*         colWidth = $bodyCells.map(function() {
             return $(this).width();
             }).get();
             console.log(colWidth);
             // Set the width of thead columns
             $table.find('thead tr').children().each(function(i, v) {
             $(v).width(colWidth[i]);
             });    */

        }
    });
}

function showFilteredResults() {
    if (jQuery("#purchase_id").val() != "") {
        jQuery.ajax({
            url: "Site/CompraAjax/" + jQuery("#purchase_id").val(),
            type: "get",
            success: function (data, status) {
                obj = jQuery.parseJSON(data);
                 jQuery("#purchases-list").hide();
                if(obj.purchase_consecut != null) {
                     jQuery('#purchases-list-filtered').show();
                } 
                jQuery("#purchase_consecut_f").html(obj.purchase_consecut);
                jQuery("#purchase_order_id_f").html(obj.purchase_order_id);
                jQuery("#purchase_date_f").html(obj.purchase_date);
                jQuery("#purchase_remarks_f").html(obj.purchase_remarks);
                var status = obj.purchase_status;
                if (status == 0) {
                    jQuery("#purchase_status_f").html('<i class="fa fa-circle  text-warning"></i>');
                } else {
                    if (status == 1) {
                        jQuery("#purchase_status_f").html('<i class="fa fa-circle  text-success"></i>');
                    } else {
                        jQuery("#purchase_status_f").html('<i class="fa fa-circle  text-danger"></i>');
                    }
                }
                jQuery("#purchases-list-filtered .purchase a").attr('href',
                        'javaScript:purchaseDetails(' + obj.purchase_id + ')');
            }
        });
    } else {
        jQuery("#purchases-list").show();
        jQuery('#purchases-list-filtered').hide();
    }
}

function showFilteredResultsSales() {
    if (jQuery("#sale_id").val() != "") {
        jQuery.ajax({
            url: "Site/VentaAjax/" + jQuery("#sale_id").val(),
            type: "get",
            success: function (data, status) {
                obj = jQuery.parseJSON(data);
                jQuery("#sales-list").hide();
                if(obj.sale_consecut != null) {
                    jQuery('#sales-list-filtered').show();
                }
                jQuery("#sale_consecut_f").html(obj.sale_consecut);
                jQuery("#sale_order_id_f").html(obj.sale_order_id);
                jQuery("#sale_date_f").html(obj.sale_date);
                jQuery("#sale_remarks_f").html(obj.sale_remarks);
                var status = obj.sale_status;
                if (status == 0) {
                    jQuery("#sale_status_f").html('<i class="fa fa-circle  text-warning"></i>');
                } else {
                    if (status == 1) {
                        jQuery("#sale_status_f").html('<i class="fa fa-circle  text-success"></i>');
                    } else {
                        jQuery("#sale_status_f").html('<i class="fa fa-circle  text-danger"></i>');
                    }
                }
                jQuery("#sales-list-filtered .purchase a").attr('href',
                        'javaScript:saleDetails(' + obj.sale_id + ')');
            }
        });
    } else {
        jQuery("#sales-list").show();
        jQuery('#sales-list-filtered').hide();
    }
}

function showFilteredResultsUsers() {
    if (jQuery("#user_id").val() != "") {
        jQuery.get(
                "Site/UsuarioAjax/?term=" + jQuery("#user_id").val(),
                function (data, status) {
                    jQuery("#users-list").hide();
                    jQuery('#users-list-filtered').show();
                    var html = '';
                    jQuery.each(data, function (index, value) {
                            html = html +  '<div class="col-sm-3">';
                            html = html + '<div class="user">';
                            html = html + '<div class="user-info">';
                            html = html + '<div class="user-photo"><img src="' + value.user_photo + '"></div>';
                            html = html + '<p class="user-name">' + value.user_name + '</p>';
                            html = html + '<div class="user-roles">' + value.user_roles + '</div>';
                            html = html + '</div>';
                            html = html + '<div>';
                            html = html + '<p align="center">';
                            html = html + '<a href="javaScript:userDetails()" class="btn btn-primary btn-block btn-warning">Detalle</a>';
                            html = html + '</p>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                    });
                    jQuery('#users-list-filtered').html(html);
                },
                'json'
                );
    } else {
        jQuery("#users-list").show();
        jQuery('#users-list-filtered').hide();
    }
}

function saleDetails(id) {
    jQuery.ajax({
        url: "Site/Venta/" + id,
        type: "get",
        success: function (data, status) {
            obj = jQuery.parseJSON(data);
            jQuery("#sale_consecut").html(obj.sale_consecut);
            jQuery("#sale_date").html(obj.sale_date);
            jQuery("#request_id").html(obj.sale_request_id);
            jQuery("#sale_net_worth").html(obj.sale_net_worth);
            jQuery("#sale_account_name").html(obj.sale_account_name);
            jQuery("#sale_company_logo").html('<img src="' + obj.sale_company_logo + '">');
            jQuery("#sale_company_name").html(obj.sale_company_name);
            jQuery("#sale_company_address").html(obj.sale_company_address);
            jQuery("#sale_customer_name").html(obj.sale_customer_name);
            jQuery("#sale_customer_phone").html(obj.sale_customer_phone);
            jQuery("#sale_customer_address").html(obj.sale_customer_address);
            jQuery("#sale_customer_contact").html(obj.sale_customer_contact);
            jQuery("#sale_user_name").html(obj.sale_user_name);
            if (obj.sale_status == 0) {
                jQuery("#sale_status").html('<span title="pendiente.." class="badge bg-orange">Pendiente</span>');
            } else {
                if (obj.sale_status == 1) {
                    jQuery("#sale_status").html('<span title="paga.." class="badge bg-green">Paga</span>');
                } else {
                    jQuery("#sale_status").html('<span title="descargada.." class="badge bg-red">Descargada</span>');
                }
            }
        }
    });

    jQuery.ajax({
        url: "Site/VentaDetalle/" + id,
        type: "get",
        success: function (data, status) {
            jQuery('a[href=#detalles-ventas]').show();
            jQuery("#sales-details").html(data);
            document.getElementById('tab3').click();
            document.getElementById('tab3').innerHTML = "Detalles de la Venta <span class='badge'>\n"
                    + jQuery("#detallesVentasCount").val() + "</span>";

            var $table = $('#product-details-grid table');

            jQuery("#sale_taxes").html(jQuery("#totalImpuestos").val());
            jQuery("#sale_total").html(jQuery("#total").val());
            /*     $bodyCells = $table.find('tbody tr:first').children(),
             colWidth;*/

            $table.find('tr').children().each(function (i, v) {
                $(v).width($("#product-details-grid").width() + $("#product-details-grid").width() / 18);
            });

            $table.find('thead tr').children().each(function (i, v) {
                $(v).width($("#product-details-grid").width() + $("#product-details-grid").width() / 18);
            });
        }
    });
}



  