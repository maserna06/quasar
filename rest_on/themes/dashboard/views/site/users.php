<?php

use App\User\User as U;

$user = U::getInstance();
$condition = "company_id = " . $user->companyId;
$criteria = new CDbCriteria();
$criteria->alias = "Auth";
$criteria->select ="*";
$criteria->join="INNER JOIN AuthAssignment a ON a.userid = user_id AND a.itemname <> 'supplier' AND a.itemname <> 'customer'";
$criteria->condition=$condition;
$criteria->group="user_id";

$users = new CActiveDataProvider("User", array("criteria"=>$criteria));
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

    .allSection { min-height: 500px;max-height: 500px; }

    .form_filter{ border: 1px solid #f3f3f3;border-radius: 6px;padding-bottom: 1%;background-color: #f4f4f4; }

    .market{ border: 1px solid #f4f4f4; }

    .ui-datepicker{ z-index:1151 !important; }

</style>
<div class="modal fade" id="modal-users" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header-users">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" >&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="allSection">
                    <div class="col-sm-12">
                        <div class="col-sm-12 form_filter">
                            <form onsubmit="return false;" class="modal-search">
                                <div class="col-sm-10">
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                        'name' => 'user_id',
                                        'source' => $this->createUrl('site/usersAutoComplete'),
                                        'options' => array(
                                            'minLength' => '2',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'form-control',
                                            'placeholder' => 'Nombre Usuario',
                                            'style' => 'text-align: center;'
                                        ),
                                    ));
                                    ?>
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" class="btn btn-warning btn-block btn-search-product" onclick="showFilteredResultsUsers()">Buscar</a>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div id="users-list">
                                <div class="col-sm-12">
                                    <div class="row-fluid">      
                                        <?php
                                        $this->widget('zii.widgets.CListView', array(
                                            'dataProvider' => $users,
                                            'itemView' => 'users_views',
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
                            <div id="users-list-filtered">

                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer" id="footer-users">
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function userDetails(id) {
        /*jQuery.ajax({
            url: "Site/User/" + id,
            type: "get",
            success: function (data, textStatus) {
                user_ = jQuery.parseJSON(data);
                
            }
        });*/
    }

    function showFilteredResultsUsers() {
        if ($("#user_id").val() != "") {
            $.get(
                    "Site/UsuarioAjax/?term=" + $("#user_id").val(),
                    function (data, status) {
                        $("#users-list").hide();
                        $('#users-list-filtered').show();
                        var html = '';
                        $.each(data, function (index, value) {
                                html = html +  '<div class="col-sm-3">';
                                html = html + '<div class="user">';
                                html = html + '<div class="user-info">';
                                html = html + '<div class="user-photo"><img src="' + value.user_photo + '"></div>';
                                html = html + '<p class="user-name">' + value.user_name + '</p>';
                                html = html + '<div class="user-roles">' + value.user_roles + '</div>';
                                html = html + '</div>';
                                html = html + '<div>';
                                html = html + '<p align="center">';
                                html = html + '<a href="javaScript:userDetails()" class="btn btn-warning btn-block btn-warning">Detalle</a>';
                                html = html + '</p>';
                                html = html + '</div>';
                                html = html + '</div>';
                                html = html + '</div>';
                        });
                        $('#users-list-filtered').html(html);
                    },
                    'json'
                    );
        } else {
            $("#users-list").show();
            $('#users-list-filtered').hide();
        }
    }

    $(function () {
        $('#users-list-filtered').hide();
    });
</script> 