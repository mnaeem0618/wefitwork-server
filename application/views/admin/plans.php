<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Update Plan')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Update <strong>Plan</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/plans'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmPromos" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading col-md-12" style="padding: 5.5px 10px">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                Display Options
                            </div>
                            <div class="panel-body" style="padding: 15.5px 0px">
                                <div class="col-md-1">
                                    <h5>Status</h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on btn-sm <?php if ($row->status == 1) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                            <input type="radio" value="1" name="status" <?php if ($row->status == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>><i class="fa fa-check" aria-hidden="true"></i></label>

                                        <label class="btn btn-default btn-off btn-sm <?php if ($row->status == 0) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                            <input type="radio" value="0" name="status" <?php if ($row->status == 0) {
                                                                                            echo 'checked';
                                                                                        } ?>><i class="fa fa-times" aria-hidden="true"></i></label>
                                    </div>
                                </div>

                                <!-- <div class="col-md-1">
                                    <h5>Sort Order</h5>
                                </div> -->
                                <!-- <div class="col-md-3">
                                    <input type="text" name="sort_order" id="sort_order" value="</?php if (isset($row->sort_order)) echo $row->sort_order; ?>" class="form-control" autofocus required>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="paystack_plan_code">
                    <div class="col-md-12">
                        <label class="control-label" for="paystack_plan_code"> Paystack Plan Code</label>
                        <input type="text" name="paystack_plan_code" id="paystack_plan_code" value="<?php if (isset($row->paystack_plan_code)) echo $row->paystack_plan_code; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group" id="plan_name">
                    <div class="col-md-12">
                        <label class="control-label" for="plan_name"> Plan Name</label>
                        <input type="text" name="plan_name" id="plan_name" value="<?php if (isset($row->plan_name)) echo $row->plan_name; ?>" class="form-control" autofocus required>
                    </div>
                </div>
                <div class="form-group" id="plan_interval">
                    <div class="col-md-12">
                        <label class="control-label" for="plan_interval">Plan Interval</label>
                        <input type="text" name="plan_interval" id="plan_interval" value="<?php if (isset($row->plan_interval)) echo $row->plan_interval; ?>" class="form-control" required>
                    </div>
                </div>
                <!-- <div class="form-group" id="no_of_days">
                    <div class="col-md-12">
                        <label class="control-label" for="no_of_days"> No Of Days</label>
                        <input type="number" name="no_of_days" id="no_of_days" value="</?php if (isset($row->no_of_days)) echo $row->no_of_days; ?>" class="form-control" autofocus required>
                    </div>
                </div> -->
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label" for="plan_price"> Plan Price</label>
                        <div class="input-group">
                            <span class="input-group-addon">NGN</span>
                            <input type="number" name="plan_price" step="any" value="<?= $row->plan_price ?>" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="plan_desc" class="control-label"> Plan Details <span class="symbol required">*</span></label>
                        <textarea name="plan_desc" rows="3" class="form-control ckeditor" required=""><?= $row->plan_desc ?></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="hr-short">
                    <div class="form-group text-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Plans')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Plans</strong></h2>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Plan Name</th>
                <th>Playstack Plan Code</th>
                <th>Plan Interval</th>
                <th>PLan Price</th>

                <th>Display</th>
                <th width="12%" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td class=""><?= $row->plan_name  ?></td>
                        <td class=""><?= $row->paystack_plan_code  ?></td>
                        <td class=""><?= $row->plan_interval  ?></td>
                        <td class=""><?= $row->plan_price ?></td>

                        <td class="text-center"><?= get_member_active_status($row->status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/plans/manage/' . $row->id); ?>">Edit</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- <script type="text/javascript">
    jQuery(document).click('.is_featured', function(){
        var is_featured = this;
        alert(this.val());
    });
</script> -->