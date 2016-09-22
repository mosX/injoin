<form action="/advertisement/edit/addphoto/{{$id}}" method="post" enctype="multipart/form-data" name="upload-image" id="upload-form">
    <input type="hidden" id="MAX_FILE_SIZE" value="134217728" name="MAX_FILE_SIZE">
    <input type="hidden" value="0" name="size" id="imageSize">
    <input type="file" style="font-size: 199px; height: 200px; cursor: pointer; -moz-opacity: 0; opacity: 0; filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=50); margin-left:-450px;" size="1" tabindex="1" maxlength="1024" id="image" name="file">
    <input type="submit" class="authorization-btn" tabindex="2" value="Submit" id="login-button" name="upload">
</form>

    <?php if($status == 'success'){ ?>
        <script type="text/javascript">
            (function(){
                
                parent.addImage('/assets/adv/{{Auth::user()->id}}/{{$id}}/thumb{{$filename}}','/assets/adv/{{Auth::user()->id}}/{{$id}}/{{$filename}}');
            })();
        </script>
    <?php }else if($status == 'error'){ ?>
        <script type="text/javascript">
            (function(){
                parent.addError({{$error}});
            })();
        </script>
    <?php } ?>

<script type="text/javascript">
    parent.$('document').ready(function(){
        document.getElementById('imageSize').setAttribute('value',parent.$('select[name=size] option:selected').val());
        parent.$('select[name=size]').change(function(){
            document.getElementById('imageSize').setAttribute('value',parent.$('select[name=size] option:selected').val());
        }); 
    });
    var changeHandler = function () {
        
        if (document.getElementById('image').value.length > 0) {
            document.forms["upload-image"].submit();
        }
    }
    var element = document.getElementById('image');

    if (element.addEventListener) {
        element.addEventListener("change", changeHandler, false);
    } else {
        element.attachEvent("onchange", changeHandler);
    }
</script>