<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user=User_helper::get_user();
?>
<div id="system_content" class="system_content_margin">
    <div class="col-lg-4">
        <?php
        $CI->load_view("report/report_menus");
        ?>

    </div>
    <div class="col-lg-8">

        <div class="clearfix"></div>
        <form class="report_form" id="system_save_form" action="<?php echo $CI->get_encoded_url('report/registered_municipal_user_report/index/list'); ?>" method="get">
            <div class="row widget">
                <div class="widget-header">
                    <div class="title">
                        <?php echo $title; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row show-grid " id="division_option">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('DIVISION_NAME'); ?></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="division" id="user_division_id" class="form-control">
                            <?php
                            $CI->load_view('dropdown',array('drop_down_options'=>$divisions,'drop_down_default_option'=>$default_divisions));
                            ?>
                        </select>
                    </div>
                </div>
                <div style="display: <?php echo $display_zillas?'block':'none'; ?>" class="row show-grid " id="zilla_option">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('DISTRICT_NAME'); ?></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="zilla" id="user_zilla_id" class="form-control">
                            <?php
                            $CI->load_view('dropdown',array('drop_down_options'=>$zillas,'drop_down_default_option'=>$default_zillas));
                            ?>
                        </select>
                    </div>
                </div>
                <div style="display: <?php echo $display_municipal?'block':'none'; ?>" class="row show-grid " id="municipal_option">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('MUNICIPAL_NAME'); ?></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="municipal" id="user_municipal_id" class="form-control">
                            <?php
                            $CI->load_view('dropdown',array('drop_down_options'=>$municipals,'drop_down_default_option'=>$default_municipal));
                            ?>
                        </select>
                    </div>
                </div>
                <div style="display: <?php echo $display_municipal_ward?'block':'none'; ?>" class="row show-grid " id="municipal_ward_option">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('MUNICIPAL_WARD_NAME'); ?></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="municipal_ward" id="user_municipal_ward_id" class="form-control">
                            <?php
                            $CI->load_view('dropdown',array('drop_down_options'=>$municipal_wards,'drop_down_default_option'=>$display_municipal_ward));
                            ?>
                        </select>
                    </div>
                </div>
                <!--                <div class="row show-grid ">-->
                <!--                    <div class="col-xs-4">-->
                <!--                        <label class="control-label pull-right">--><?php //echo $CI->lang->line('STATUS'); ?><!--</label>-->
                <!--                    </div>-->
                <!--                    <div class="col-sm-4 col-xs-8">-->
                <!--                        <select name="status" class="form-control" id="status">-->
                <!--                            --><?php
                //                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('SELECT'),'value'=>''),array('text'=>$CI->lang->line('APPLIED'),'value'=>$this->config->item('STATUS_INACTIVE')),array('text'=>$CI->lang->line('APPROVED'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('NOT_APPROVED'),'value'=>$this->config->item('STATUS_REJECT'))),'drop_down_selected'=>''));
                //                            ?>
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="row show-grid">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <input type="submit" class="btn btn-primary" value="<?php echo $CI->lang->line('SEARCH'); ?>">
                    </div>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>

    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        $(document).on("change","#user_division_id",function()
        {
            $("#municipal_ward_option").hide();
            $("#municipal_option").hide();
            $("#zilla_option").show();

            $("#user_unioun_id").val("");
            $("#user_upazila_id").val("");
            $("#user_zilla_id").val("");
            var division_id=$(this).val();
            if(division_id>0)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_zilla'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{division_id:division_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $("#zilla_option").hide();

            }
        });
        $(document).on("change","#user_zilla_id",function()
        {
            $("#municipal_ward_option").hide();
            $("#municipal_option").show();


            $("#user_municipal_ward_id").val("");
            $("#user_municipal_id").val("");

            var zilla_id=$(this).val();
            if(zilla_id>0)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_municipal'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {

                $("#municipal_option").hide();
            }
        });
        $(document).on("change","#user_municipal_id",function()
        {
            $("#municipal_ward_option").show();
            $("#user_union_id").val("");
            var zilla_id=$("#user_zilla_id").val();
            var municipal_id=$(this).val();
            if(municipal_id>0)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_municipal_ward'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, municipal_id:municipal_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $("#municipal_ward_option").hide();
            }
        });
    });
</script>