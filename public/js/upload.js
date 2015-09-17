//文件上传

$('#doc-form-file').on('change', function () {
    var fileNames = '';
    $.each(this.files, function () {
        fileNames += '<span class="am-badge">' + this.name + '</span> ';
    });
    $('#file-list').html(fileNames);
});

var opts = {
    url: "/upload",
    type: "POST",
    beforeSend: function () {
        $("#loading").attr('class', 'am-icon-spinner am-icon-spin');
    },
    success: function (result, status, xhr) {
        // console.log(result);
        $("#loading").attr('class', 'am-icon-cloud-upload');

        if (result.status == 0) {
            alert(result.info);
            return false;
        }
        $('#img').val(result.info);
        $('#img_show').attr('src', result.info);
    },
    error: function (result, status, errorThrown) {
        // alert(errorThrown)
        $("#loading").attr('class', 'am-icon-cloud-upload');
        alert('文件上传失败');
    }
}
$('#doc-form-file').fileUpload(opts);