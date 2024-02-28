<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'Add/Update Blog')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Blog</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo base_url(ADMIN . '/blogs'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmNewsletter" role="form" class="form-horizontal blog-form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="">
                                <div class="panel-heading col-md-12">
                                    <div class="panel-title">
                                        <h3>Meta Information</h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Meta Title <span class="symbol required">*</span></label>
                                                <input type="text" name="meta_title" value="<?= $row->meta_title ?>" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Meta Keywords <span class="symbol required">*</span></label>
                                                <input type="text" name="meta_keywords" value="<?= $row->meta_keywords ?>" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Meta Description <span class="symbol required">*</span></label>
                                                <textarea rows="8" class="form-control" name="meta_description" required><?= $row->meta_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Open Graph Type(og:type) <span class="symbol required">*</span></label>&nbsp;
                                                <select name="og_type" id="og_type" class="form-control" required>
                                                    <!-- <option value="">-- Select --</option> -->
                                                    <option value="article" <?= ($row->og_type == 'article') ? 'selected' : '' ?>>Article</option>
                                                    <option value="website" <?= ($row->og_type == 'website') ? 'selected' : '' ?>>Website</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Open Graph Title(og:title) <span class="symbol required">*</span></label>&nbsp;
                                                <input type="text" name="og_title" class="form-control" value="<?= $row->og_title ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Open Graph Description(og:description) <span class="symbol required">*</span></label>
                                                <textarea name="og_description" rows="8" class="form-control" required><?php if (isset($row->og_description)) echo $row->og_description; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
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
                                                                <img src="<?= get_site_image_src("images/", $row->og_image) ?>" alt="--">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                                            <div>
                                                                <span class="btn btn-white btn-file">
                                                                    <span class="fileinput-new">Select image</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="og_image" accept="image/*" <?php if (empty($row->og_image)) {
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
                                    </div>
                                    <div class="clearfix"></div>


                                </div>
                                <div class="panel-heading col-md-12">
                                    <div class="panel-title">
                                        <h3>Blog Basic Information</h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Title <span class="symbol required">*</span></label>
                                                <input type="text" name="title" value="<?= $row->title ?>" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Slug</label>
                                                <input type="text" name="slug" value="<?= $row->slug ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Short Description <span class="symbol required">*</span></label>
                                                <textarea rows="8" class="form-control" name="short_description" required><?= $row->short_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Description <span class="symbol required">*</span></label>
                                                <textarea rows="8" class="form-control ckeditor" name="description" required><?= $row->description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-picture-o"></i> Thumbnail </div>
                                <div class="panel-body thumbnail_blog" style="padding: 10px" id="imgDiv">
                                    <img src="<?= !empty($row->image) ? get_site_image_src("blogs/", $row->image) : base_url() . '/assets/images/no_image.jpg' ?>" style="width: 100%; cursor: pointer;" id="newImg">

                                    <span class="btn btn-white btn-file" style="margin-top: 10px;">
                                        <span class="fileinput-new">Select image</span>
                                        <input type="file" name="image" accept="image/*" id="imgInput" <?php if (empty($row->image)) {
                                                                                                            echo 'required=""';
                                                                                                        } ?>>
                                    </span>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <label for="image_alt_text" class="control-label">Thumbnail Image Alt Text <span class="symbol required">*</span></label>
                                <input type="text" name="image_alt_text" value="<?php if (isset($row->image_alt_text)) echo $row->image_alt_text; ?>" class="form-control" required>
                            </div> -->
                        </div>
                        <br>
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Display Options</div>
                                <div class="panel-body" style="padding: 15.5px 0px">

                                    <div class="col-md-7">
                                        <h5>Active</h5>
                                    </div>
                                    <div class="col-md-5">
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
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Top Post Options</div>
                                <div class="panel-body" style="padding: 15.5px 0px">

                                    <div class="col-md-7">
                                        <h5>Is Top Post?</h5>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="btn-group" id="is_top_post" data-toggle="buttons">
                                            <label class="btn btn-default btn-on btn-sm <?php if ($row->is_top_post == 1) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                                <input type="radio" value="1" name="is_top_post" <?php if ($row->is_top_post == 1) {
                                                                                                        echo 'checked';
                                                                                                    } ?>><i class="fa fa-check" aria-hidden="true"></i></label>

                                            <label class="btn btn-default btn-off btn-sm <?php if ($row->is_top_post == 0) {
                                                                                                echo 'active';
                                                                                            } ?>">
                                                <input type="radio" value="0" name="is_top_post" <?php if ($row->is_top_post == 0) {
                                                                                                        echo 'checked';
                                                                                                    } ?>><i class="fa fa-times" aria-hidden="true"></i></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Featured Options</div>
                                <div class="panel-body" style="padding: 15.5px 0px">

                                    <div class="col-md-7">
                                        <h5>Is Featured?</h5>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="btn-group" id="is_featured" data-toggle="buttons">
                                            <label class="btn btn-default btn-on btn-sm <?php if ($row->is_featured == 1) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                                <input type="radio" value="1" name="is_featured" <?php if ($row->is_featured == 1) {
                                                                                                        echo 'checked';
                                                                                                    } ?>><i class="fa fa-check" aria-hidden="true"></i></label>

                                            <label class="btn btn-default btn-off btn-sm <?php if ($row->is_featured == 0) {
                                                                                                echo 'active';
                                                                                            } ?>">
                                                <input type="radio" value="0" name="is_featured" <?php if ($row->is_featured == 0) {
                                                                                                        echo 'checked';
                                                                                                    } ?>><i class="fa fa-times" aria-hidden="true"></i></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <h3>Blog Category</h3>
                            <p>(Select 1)</p>
                            <div class="panel panel-default">
                                <div class="panel-heading col-md-12" style="padding: 5.5px 10px">Blog Category</div>
                                <div class="panel-body" style="padding: 15.5px 0px">
                                    <div class="col-md-12">
                                        <?php foreach ($categories as $index => $cat) : ?>
                                            <div class="lblBtn">
                                                <input type="radio" name="category_id" id="category<?= $cat->id ?>" value="<?= $cat->id ?>" <?= $row->category_id == $cat->id ? 'checked' : '' ?>>
                                                <label class="control-label" for="category<?= $cat->id ?>"><?= $cat->title ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div>

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
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'Manage Blogs')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Blogs</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= base_url(ADMIN . '/blogs/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Image</th>
                <th width="20%">Title</th>
                <th width="10%">Category</th>

                <th width="30%">description</th>
                <th>Is Top Post</th>
                <th>Status</th>
                <th width="15%">created date</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($blogs) > 0) : $count = 0; ?>
                <?php foreach ($blogs as $blog) :  ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td>
                            <?php
                            if (empty($blog->image)) {
                            ?>
                                <img src="<?= base_url(); ?>adminassets/images/no_image.jpg" class="step_img" style="width: 100px">
                            <?php
                            } else {
                            ?>
                                <img src="<?= get_site_image_src("blogs", $blog->image, 'thumb_') ?>" class="step_img" style="width: 100px">
                            <?php
                            }
                            ?>
                        </td>
                        <td><b><?= short_text($blog->title, 40); ?></b></td>
                        <td><b><?= get_cat_name($blog->category_id)  ?></b></td>

                        <td><b><?= short_text($blog->description, 100); ?></b></td>
                        <td style="<?= $blog->is_top_post == 1 ? 'color: green' : 'color: red' ?>"><b><?= $blog->is_top_post == 1 ? 'Yes' : 'No' ?></b></td>

                        <td><b><?= get_active_status($blog->status) ?></b></td>
                        <td><b><?= dateFormat($blog->created_date) ?></b></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= base_url(ADMIN); ?>/blogs/manage/<?= $blog->id; ?>">Edit</a></li>
                                    <?php if (access(10)) : ?>
                                        <li><a href="<?= base_url(ADMIN); ?>/blogs/delete/<?= $blog->id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
<script src="<?= base_url('adminassets/js/jquery-3.4.1.js'); ?>"></script>
<script type="text/javascript">
    $(document).on('click', '.add_recipe', function(e) {
        e.preventDefault();
        $ad = $(".recipe_clone:first").clone();
        $ad.find("input").val("");
        $ad.find("textarea").html("");
        var i = 0;
        $('.recipe_container').append($ad);
        $(".remove_recipe").each(function() {
            console.log($(this));
            $(this).click(function(e) {
                e.preventDefault();
                $(this).parent().remove();
            });
        });
    });
    $('.add_new_cat').click(function(e) {
        $(".category_new").toggle();
    });
    jQuery(document).on('change', '#imgInput', function() {

        var preview = jQuery(this).closest("#imgDiv").find("#newImg");
        console.log(preview);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(jQuery(this)[0].files[0]);
        oFReader.addEventListener("load", function() {
            preview.attr('src', oFReader.result);
        }, false);
    });
    $(document).on('click', '#add_category', function(event) {
        event.preventDefault();
        var cat_name = $("#cat_name").val();
        console.log("<?php echo base_url('admin/Blogs/add_category'); ?>");
        $.ajax({
            url: "<?php echo base_url('admin/Blogs/add_category'); ?>",
            data: {
                cat_name: cat_name
            },
            type: "post",
            async: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status == true) {
                    $(".site_categories").append('<li><input type="radio" name="categories" value="' + response.cat_id + '" checked="checked"> <span>' + cat_name + '</span></li>');
                    $('.category_new').hide();
                    $('#cat_name').val("");
                }

            },
            error: function(response) {
                console.log(response);
            }
        });
    });
</script>