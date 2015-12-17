$('#select_type').change(function () {
    var type_id = $(this).val();

    $.ajax({
        type: "GET",
        data: {type_id: type_id},
        url: "/admin/good/select_type",
        dataType: "html",
        beforeSend: function (data) {
            //加载中图片显示
        },
        success: function (data) {
            $("#attributes").html(data);
            $('.att_select').selected({
                btnSize: 'sm',
                btnStyle: 'secondary',
                maxHeight: '360',
            });

        }
    })
})


//增加属性
$(document).on("click", ".add_attribute", function () {
    var attr_id = $(this).attr('data-id');
    var _this = $(this);

    $.ajax({
        type: "GET",
        data: {attr_id: attr_id},
        url: "/admin/good/select_type/add_form",
        dataType: "html",
        success: function (data) {

            _this.parents(".am-g").next().after(data);
            //重设样式
            $('.att_select').selected({
                btnSize: 'sm',
                btnStyle: 'secondary',
                maxHeight: '360',
            });
        }
    })
})

//删除属性
$(document).on("click", ".trash1", function () {
    $(this).parents(".am-g").remove();
});

$(document).on("click", ".trash0", function () {
    $(this).parents('.am-g').find('.money').val('');
});