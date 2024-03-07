<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Update Maintenance Cover')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Update <strong>Maintenance Cover</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/maintenance_covers'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                                Status
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

                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="service_title"> Service Title</label>
                        <input type="text" name="service_title" id="service_title" value="<?php if (isset($row->service_title)) echo $row->service_title; ?>" class="form-control" autofocus required>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="title"> Main Title</label>
                        <input type="text" name="title" id="title" value="<?php if (isset($row->title)) echo $row->title; ?>" class="form-control" autofocus required>
                    </div>
                </div>

                <div class="form-group">
                    <!-- <div class="col-md-4">
                        <label class="control-label" for="paystack_plan_code"> Paystack Code</label>
                        <input type="text" name="paystack_plan_code" id="paystack_plan_code" value="</?php if (isset($row->paystack_plan_code)) echo $row->paystack_plan_code; ?>" class="form-control" autofocus required>
                    </div> -->

                    <div class="col-md-6">
                        <label class="control-label" for="price">Starting from Price</label>
                        <div class="input-group">
                            <span class="input-group-addon">NGN</span>
                            <input type="number" name="price" step="any" value="<?= $row->price ?>" class="form-control">

                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <label class="control-label" for="interval"> Interval</label>
                        <select name="interval" id="interval" class="form-control" required>
                            <option value="" >Choose Interval</option>
                            <option value="monthly" </?= $row->interval == 'monthly' ? "selected='selected'" : ''?>>Monthly</option>
                            <option value="yearly" </?= $row->interval == 'yearly' ? "selected='selected'" : ''?>>Yearly</option>

                        </select>
                    </div> -->

                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="short_desc" class="control-label"> Add Prices <span class="symbol required">*</span></label>
                        <table class="table table-bordered newTable" id="newTable">
                            <tr style="background-color: #eee">
                                <th>Type of house</th>
                                <th>Price</th>
                                <th width="10%">Order#</th>
                                <th width="4%" class="text-center"><a href="javascript:void(0)" id="addNewRowTbl" class="addNewRowTbl"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                            </tr>
                            <?php $mc_prices = getMcoverPrices($row->id); ?>
                            <?php if (count($mc_prices) > 0) {
                                $mc_prices_count = 1; ?>
                                <?php foreach ($mc_prices as $price) { ?>
                                    <tr>
                                        <td>
                                            <input type="text" name="type_of_house[]" id="type_of_house" value="<?= $price->type_of_house; ?>" class="form-control" placeholder="Duration in Seconds" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">NGN</span>
                                                <input type="number" name="mc_price[]" id="price" value="<?= $price->price ?>" class="form-control" placeholder="Price" required>
                                            </div>
                                        </td>
                                        <td>
                                                <input type="number" name="mc_sort_order[]" id="mc_sort_order" value="<?= $price->sort_order ?>" class="form-control" placeholder="Order#" required>
                                            </td>
                                        <td class="text-center">
                                            <?php if ($mc_prices_count > 1) { ?>
                                                <a href="javascript:void(0)" id="delNewRowTbl" class="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $mc_prices_count++; ?>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <input type="text" name="type_of_house[]" id="type_of_house" value="" class="form-control" required placeholder="Duration in Seconds">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">NGN</span>
                                            <input type="number" name="mc_price[]" id="mc_price" value="" class="form-control" placeholder="Price" required>
                                        </div>
                                    </td>
                                    <td>
                                                <input type="number" name="mc_sort_order[]" id="mc_sort_order" value="" class="form-control" placeholder="Order#" required>
                                            </td>
                                    <td class="text-center">
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <label for="short_desc" class="control-label"> Short Description <span class="symbol required">*</span></label>
                        <textarea name="short_desc" rows="3" class="form-control" required=""><?= $row->short_desc ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="detail" class="control-label">Details <span class="symbol required">*</span></label>
                        <textarea name="detail" rows="3" class="form-control ckeditor" required=""><?= $row->detail ?></textarea>
                    </div>
                </div>
                <hr>
                <div class="clearfix"></div>

                <h3>Section 2</h3>
                <div class="form-group">

                    <div class="col-md-12">
                        <div class="form-group">

                            <div class="col-md-6">
                                <label for="sec2_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                                <input type="text" name="sec2_heading" value="<?= $content['sec2_heading'] ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="sec2_tagline" class="control-label"> Tagline <span class="symbol required">*</span></label>
                                <input type="text" name="sec2_tagline" value="<?= $content['sec2_tagline'] ?>" class="form-control" required>
                            </div>
                            <div class="clearfix"></div>
                            <!-- <hr> --> <br>
                            <div class="col-md-6">
                                <label class="control-label"> Included <span class="symbol required">*</span></label>

                                <table class="table table-bordered newTable" id="newTable">
                                    <tr style="background-color: #eee">
                                        <th>Included</th>
                                        <th width="4%" class="text-center"><a href="javascript:void(0)" id="addNewRowTbl" class="addNewRowTbl"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                    </tr>
                                    <?php $includeds = getIncluded($row->id); ?>
                                    <?php if (countlength($includeds) > 0) {
                                        $includeds_count = 1; ?>
                                        <?php foreach ($includeds as $included) { ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="included_title[]" id="included_title" value="<?= $included->title; ?>" class="form-control" placeholder="Text">
                                                </td>

                                                <td class="text-center">
                                                    <?php if ($includeds_count > 1) { ?>
                                                        <a href="javascript:void(0)" id="delNewRowTbl" class="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $includeds_count++; ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>

                                            <td>
                                                <input type="text" name="included_title[]" id="included_title" value="" class="form-control" placeholder="Text">
                                            </td>

                                            <td class="text-center">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label"> Excluded <span class="symbol required">*</span></label>
                                <table class="table table-bordered newTable" id="newTable">
                                    <tr style="background-color: #eee">
                                        <th>Excluded</th>
                                        <th width="4%" class="text-center"><a href="javascript:void(0)" id="addNewRowTbl" class="addNewRowTbl"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                    </tr>
                                    <?php $excludeds = getExcluded($row->id); ?>
                                    <?php if (countlength($excludeds) > 0) {
                                        $excludeds_count = 1; ?>
                                        <?php foreach ($excludeds as $excluded) { ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="excluded_title[]" id="excluded_title" value="<?= $excluded->title; ?>" class="form-control" placeholder="Text">
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($excludeds_count > 1) { ?>
                                                        <a href="javascript:void(0)" id="delNewRowTbl" class="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $excludeds_count++; ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="excluded_title[]" id="excluded_title" value="" class="form-control" placeholder="Text">
                                            </td>
                                            <td class="text-center">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="clearfix"></div>

                <h3>Section 3</h3>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <div class="form-group">

                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Background Image
                                        </div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                                <img src="<?= !empty($content['image1']) ? get_site_image_src("maintenance_covers/", $content['image1']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="image1" accept="image/*" <?php if (empty($content['image1'])) {
                                                                                                            echo 'required=""';
                                                                                                        } ?>>
                                                </span>
                                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="sec3_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                                    <input type="text" name="sec3_heading" value="<?= $content['sec3_heading'] ?>" class="form-control" required>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <label for="sec3_tagline" class="control-label"> Text <span class="symbol required">*</span></label>
                                    <input type="text" name="sec3_tagline" value="<?= $content['sec3_tagline'] ?>" class="form-control" required>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <label for="sec3_heading2" class="control-label"> Heading 2<span class="symbol required">*</span></label>
                                    <input type="text" name="sec3_heading2" value="<?= $content['sec3_heading2'] ?>" class="form-control" required>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <label for="sec3_tagline2" class="control-label"> Text <span class="symbol required">*</span></label>
                                    <input type="text" name="sec3_tagline2" value="<?= $content['sec3_tagline2'] ?>" class="form-control" required>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <label for="sec3_button1_text" class="control-label"> Link Text <span class="symbol required">*</span></label>
                                    <input type="text" name="sec3_button1_text" value="<?= $content['sec3_button1_text'] ?>" class="form-control" required>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <h3>Section 4</h3>
                <div class="form-group">

                    <div class="col-md-12">
                        <div class="form-group">

                            <div class="col-md-12">
                                <label for="sec4_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                                <input type="text" name="sec4_heading" value="<?= $content['sec4_heading'] ?>" class="form-control" required>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <label for="sec4_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                                <textarea name="sec4_detail" rows="3" class="form-control ckeditor" id="editor"><?= $content['sec4_detail'] ?></textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- <hr> --> <br>
                            <div class="col-md-12">
                                <label class="control-label"> Faq's <span class="symbol required">*</span></label>

                                <table class="table table-bordered newTable" id="newTable">
                                    <tr style="background-color: #eee">
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th width="10%">Order#</th>
                                        <th width="4%" class="text-center"><a href="javascript:void(0)" id="addNewRowTbl" class="addNewRowTbl"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                    </tr>
                                    <?php $faqs = getMcoverFaqs($row->id); ?>
                                    <?php if (countlength($faqs) > 0) {
                                        $faqs_count = 1; ?>
                                        <?php foreach ($faqs as $faq) { ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="question[]" id="question" value="<?= $faq->question; ?>" class="form-control" placeholder="Question">
                                                </td>
                                                <td>
                                                    <textarea name="answer[]" id="answer" rows="3" class="form-control" placeholder="Text"><?= $faq->answer ?></textarea>

                                                </td>

                                                <td>
                                                    <input type="number" name="sort_order[]" id="sort_order" value="<?= $faq->sort_order; ?>" class="form-control" placeholder="Order#">
                                                </td>

                                                <td class="text-center">
                                                    <?php if ($faqs_count > 1) { ?>
                                                        <a href="javascript:void(0)" id="delNewRowTbl" class="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $faqs_count++; ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>

                                            <td>
                                                <input type="text" name="question[]" id="question" value="" class="form-control" placeholder="Question">
                                            </td>
                                            <td>
                                                <textarea name="answer[]" id="answer" rows="3" class="form-control" placeholder="Text"></textarea>

                                            </td>
                                            <td>
                                                <input type="number" name="sort_order[]" id="sort_order" value="" class="form-control" placeholder="Order#">
                                            </td>
                                            <td class="text-center">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>


                            <div class="clearfix"></div>
                        </div>
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
    <?= getBredcrum(ADMIN, array('#' => 'Manage Maintenance Covers')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Maintenance Covers</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/maintenance_covers/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Service Title</th>
                <!-- <th>Playstack Code</th> -->
                <!-- <th>Interval</th> -->
                <th>Starting Price</th>
                <th>Status</th>
                <th width="12%" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td class=""><?= $row->service_title  ?></td>
                        <!-- <td class=""></?= $row->paystack_plan_code  ?></td> -->
                        <!-- <td class=""></?= $row->interval  ?></td> -->
                        <td class=""><?= $row->price ?></td>
                        <td class="text-center"><?= get_member_active_status($row->status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/maintenance_covers/manage/' . $row->id); ?>">Edit</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?= site_url(ADMIN . '/maintenance_covers/add_sub_services/' . $row->id); ?>" class="btn btn-danger"> Add / Manage Sub Services </a>

                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>