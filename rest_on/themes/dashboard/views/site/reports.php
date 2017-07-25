<?php

use App\User\User as U;

$user = U::getInstance();

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
<div class="modal fade" id="modal-reports" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header-reports">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" >&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="allSection">
                    
                </section>
            </div>
            <div class="modal-footer" id="footer-reports">
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
