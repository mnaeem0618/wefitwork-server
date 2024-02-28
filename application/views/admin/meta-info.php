<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Meta information')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="fa fa-bars"></i> Add/Update <strong>Meta information for page (<?= $page_name ?>)</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/meta_info'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action=""  role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label"> Page Name <span class="symbol required">*</span></label>&nbsp;
                        <input type="text" name="page_name" class="form-control" value="<?= $page_name ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Page Slug <span class="symbol required">*</span></label>&nbsp;
                        <input type="text" name="slug" class="form-control" value="<?= $slug ?>">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <label class="control-label"> Meta Title</label>&nbsp;
                        <input type="text" name="meta_title" class="form-control" value="<?php if (isset($row->meta_title)) echo $row->meta_title; ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"> Meta Description <span class="symbol required">*</span></label>
                        <textarea  name="meta_description" rows="4" class="form-control" required><?php if (isset($row->meta_description)) echo $row->meta_description; ?></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"> Meta keywords(comma separated words) <span class="symbol required">*</span></label>
                        <textarea  name="meta_keywords" rows="4" class="form-control" required><?php if (isset($row->meta_keywords)) echo $row->meta_keywords; ?></textarea>
                    </div>
                    
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Open Graph Type(og:type) <span class="symbol required">*</span></label>&nbsp;
                        <select name="og_type" id="og_type" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="website" <?= ($row->og_type == 'website') ? 'selected' : '' ?>>Website</option>
                            <option value="article" <?= ($row->og_type == 'article') ? 'selected' : '' ?>>Article</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                            <label class="control-label">Open Graph Title(og:title) <span class="symbol required">*</span></label>&nbsp;
                            <input type="text" name="og_title" class="form-control" value="<?= $row->og_title ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"> Open Graph Description(og:description) <span class="symbol required">*</span></label>
                        <textarea  name="og_description" rows="8" class="form-control ckeditor" required><?php if (isset($row->og_description)) echo $row->og_description; ?></textarea>
                    </div>
                </div>         
                <div class="form-group">
                    <div class="col-md-6">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Open Graph image(og:image)
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= get_site_image_src("images/", $row->og_image)?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="og_image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    twitter_image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= get_site_image_src("images/", $row->twitter_image)?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="twitter_image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class = "col-md-6">
                        <img src = "<?= get_site_image_src(SITE_IMAGES,'/'.$row->og_image); ?>" height = "80"><br>
                        <input type = "file" name = "og_image" id = "og_image" class = "form-control file2 inline btn btn-primary" data-label = "<i class='fa fa-upload'></i> Browse" />
                        <div><br />
                            <label class="control-label"> Open Graph image(og:image) <span class="symbol required">*</span></label><br/>
                            <small style = "color:#F00;">* Best resolution is <strong>600 x 600</strong>.</small><br />
                            <small style = " color:#F00;">* Allowed formats are <strong>JPG | JPEG | PNG</strong>.</small><br>
                            <small style = "color:#F00;">* Image size maximum <strong>2MB</strong> allowed.</small>
                        </div>
                    </div>
                    <div class = "col-md-6">
                        <img src = "<?= get_site_image_src(SITE_IMAGES, '/'.$row->twitter_image); ?>" height = "80"><br>
                        <input type = "file" name = "twitter_image" id = "twitter_image" class = "form-control file2 inline btn btn-primary" data-label = "<i class='fa fa-upload'></i> Browse" />
                        <div><br />
                            <label class="control-label"> Twitter card image(Twitter:card) <span class="symbol required">*</span></label><br/>
                            <small style = "color:#F00;">* Best resolution is <strong>600 x 600</strong>.</small><br />
                            <small style = " color:#F00;">* Allowed formats are <strong>JPG | JPEG | PNG</strong>.</small><br>
                            <small style = "color:#F00;">* Image size maximum <strong>2MB</strong> allowed.</small>
                        </div>
                    </div> -->
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
            <div class="clearfix"></div>
        </div>
    <?php else: ?>
        <?= showMsg(); ?>
        <?= getBredcrum(ADMIN, array('#' => 'Manage Meta information')); ?>
        <div class="row margin-bottom-10">
            <div class="col-md-6">
                <h2 class="no-margin"><i class="fa fa-bars"></i> Manage <strong>Meta Information</strong></h2>
            </div>
            <div class="col-md-6 text-right">
                <!-- <a href="<?= site_url(ADMIN . '/meta_info/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a> -->
            </div>
        </div>
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th width="5%" class="text-center">Sr#</th>
                    <th width="10%">Page Name</th>
                    <th>Page Slug</th>
                    <th width="12%" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (countlength($rows) > 0): $count = 0; ?>
                    <?php foreach ($rows as $row): ?>
                        <tr class="odd gradeX">
                            <td class="text-center"><?= ++$count; ?></td>
                            <td class="text-center"><?= $row->page_name ?></td>
                            <td><?= $row->slug ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-primary" role="menu">

                                        <li><a href="<?= site_url(ADMIN); ?>/meta-info/manage/<?= $row->slug; ?>">Edit</a></li>
                                        <!-- <li><a href="<?= site_url(ADMIN); ?>/meta-info/delete/<?= $row->slug; ?>" onclick="return confirm('Are you sure?');">Delete</a></li> -->
                                    </ul>
                                </div>  
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>