<div class="addmore-html">
    <input type="hidden" name="counter[]" value="1">
    <input type="hidden" id="uId" name="uniqueId[]" value="">
    <h4>Create Static Block</h4>
    <div class="form-group">
        <label for="sposition" class="control-label">Section Position</label>
        <select name="sposition[]" id="sposition" class="form-control" style="width:100px;">
            <option value="top" selected="selected">Top</option>
            <option value="bottom">Bottom</option>
        </select>
    </div>
    <div class="form-group">
        <label for="stitle" class="control-label">Title</label>
        <input class="form-control" name="stitle[]" type="text" id="stitle">
    </div>
    <div class="form-group">
        <label for="scontent" class="control-label">Content</label>
        <textarea class="form-control scontent" name="scontent[]" id="scontent" aria-hidden="true"></textarea>
    </div>
    <div class="form-group">
        <label for="surl" class="control-label">URL</label>
        <input class="form-control" name="surl[]" type="url" id="surl">   
    </div>
    <div class="form-group static-image">
        <!-- <label for="simage" class="control-label">Image</label> -->
        <div class="browse-btn">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>Browse
                        <input name="simage[]" type="file" id="simage" class="simage">
                    </span>
                </span>
                <span class="disp_file_path_static" style="margin: 15px;"></span>
            </div>
        </div>
    </div>

</div>
<script>
    $('.simage').on('change', function ()
    {
        var filePath = $(this).val();
        $(this).parents('.browse-btn').find('.disp_file_path_static').html(filePath);
    });
</script>

