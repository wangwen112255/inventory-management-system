$(function () {



    //统一全选的实现
    $(".check-all").click(function () {
        $(".ids,.check-all").prop("checked", this.checked);
        // $(".check-all").prop("checked", this.checked);
    });
    $(".ids").click(function () {
        var option = $(".ids");
        option.each(function (i) {
            if (!this.checked) {
                $(".check-all").prop("checked", false);
                return false;
            } else {
                $(".check-all").prop("checked", true);
            }
        });
    });
    //统一全选的实现end


    var data_result = function (data) {


    }
    //
    //ajax get请求
    $(document).on("click", '.ajax-get', function () {
        var target;
        var that = this;
        if ($(this).hasClass('confirm')) {
            if (!confirm('确认要执行该操作吗?')) {
                return false;
            }
        }
        if ((target = $(this).attr('href')) || (target = $(this).attr('url'))) {



            $.ajax({
                url: target,
                type: 'get',
                timeout: 5000,
                beforeSend: function (XMLHttpRequest) {
                    $(that).button('loading');
                },
                success: function (data, textStatus) {

                    if (data.code == 1) {
                        if (data.msg) {
                            toastr.info(data.msg);
                            if (data.url) {
                                setTimeout(function () {
                                    location.href = data.url;
                                }, 1500);
                            }
                        } else {
                            location.href = data.url;
                        }
                    } else {
                        toastr.warning(data.msg);
                    }

                    $(that).button('reset');
                },
                complete: function (XMLHttpRequest, textStatus) {
                    $(that).button('reset');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    toastr.warning(errorThrown);
                    $(that).button('reset');
                }
            });





        }
        return false;
    });
    //ajax post submit请求
    $(document).on("click", '.ajax-post', function () {


        var target, query, form;
        var target_form = $(this).attr('target-form');
        var that = this;
        var nead_confirm = false;
        if (($(this).attr('type') == 'submit') || (target = $(this).attr('href')) || (target = $(this).attr('url'))) {
            form = $('.' + target_form);
            if ($(this).attr('hide-data') === 'true') {//无数据时也可以使用的功能
                form = $('.hide-data');
                query = form.serialize();
            } else if (form.get(0) == undefined) {
                return false;
            } else if (form.get(0).nodeName == 'FORM') {
                if ($(this).hasClass('confirm')) {
                    if (!confirm('确认要执行该操作吗?')) {
                        return false;
                    }
                }
                if ($(this).attr('url') !== undefined) {
                    target = $(this).attr('url');
                } else {
                    target = form.attr("action");
                }
                query = form.serialize();
            } else if (form.get(0).nodeName == 'INPUT' || form.get(0).nodeName == 'SELECT' || form.get(0).nodeName == 'TEXTAREA') {
                form.each(function (k, v) {
                    if (v.type == 'checkbox' && v.checked == true) {
                        nead_confirm = true;
                    }
                })
                if (nead_confirm && $(this).hasClass('confirm')) {
                    if (!confirm('确认要执行该操作吗?')) {
                        return false;
                    }
                }
                //增加以下代码用于兼容IE8
                if ($(this).attr('url') !== undefined) {
                    target = $(this).attr('url');
                } else {
                    target = form.attr("action");
                }
                //增加以上代码用于兼容IE8                
                query = form.serialize();
            } else {
                if ($(this).hasClass('confirm')) {
                    if (!confirm('确认要执行该操作吗?')) {
                        return false;
                    }
                }
                query = form.find('input,select,textarea').serialize();
            }
            //$(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);

            $.ajax({
                url: target,
                type: 'post',
                data: query,
                timeout: 15000,
                beforeSend: function (XMLHttpRequest) {
                    $(that).button('loading');
                },
                success: function (data, textStatus) {
                    if (data.code == 1) {
                        if (data.msg) {
                            toastr.info(data.msg);
                            if (data.url) {
                                setTimeout(function () {
                                    location.href = data.url;
                                }, 1500);
                            }
                        } else {
                            location.href = data.url;
                        }
                    } else {
                        toastr.warning(data.msg);
                    }
                    $(that).button('reset');
                },
                complete: function (XMLHttpRequest, textStatus) {
                    $(that).button('reset');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    toastr.warning(errorThrown);
                    $(that).button('reset');
                }
            });



        }
        return false;
    });
});