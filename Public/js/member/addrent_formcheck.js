/**
 * Created by david on 16/9/7.
 */
$(function() {
    //alert($('.fafaf').attr('name'))
    // 联系电话(手机/电话皆可)验证
    /*$.validator.addMethod("isTel", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
        return this.optional(element) || tel.test(value) || (length == 11 && mobile.test(value));
    }, "请正确填写您的联系方式");*/

    $('#dataForm').validate(
        {
            //定义错误信息显示位置
            errorPlacement: function (error, element) {
                if (element.attr("name") == "house_fitment" || element.attr("name") == "house_type" || element.attr("name") == "house_toward"){

                    error.appendTo(element.parent().siblings(".errorMessage"));

                }else if(element.attr("name") == "house_feature[]"){

                    //error.insertAfter("#errMsg_house_feature");
                    error.appendTo(element.parent().parent().siblings(".errorMessage"));
                    //error.appendTo(element.parent()); //将错误信息添加当前元素的父结点后面
                }else if(element.attr("name") == "check_agree"){

                    error.appendTo(element.siblings(".errorMessage"));

                }else {
                    error.appendTo(element.siblings(".errorMessage"));
                }
            },
            //自定义验证信息
            rules: {
                house_title: {
                    required: true,
                    rangelength: [4, 30]
                },
                house_type: {
                    required: true
                },
                borough_name: {
                    required: true

                },
                house_floor: {
                    required: true,
                    digits:true
                },
                house_topfloor: {
                    required: true,
                    digits:true

                },
                house_price: {
                    required: true,
                    digits: true
                },
                house_deposit: {
                    required: true
                },
                house_totalarea: {
                    required: true,
                    number:true,
                    min:0
                },
                house_age: {
                    required: true
                },
                house_fitment: {
                    required: true
                }
                ,
                house_toward: {
                    required: true
                },
                'house_feature[]': {
                    required: true
                },
                check_agree:{
                    required:true
                }

            },
            messages: {
                house_title: {
                    required: "请输入房源标题",
                    rangelength: "长度须4-30个字符！"
                },
                house_type: {
                    required: "请选择房源类型!"
                },
                borough_name: {
                    required: "请输入小区名称!"
                },
                house_floor: {
                    required: "请输入所在楼层!",
                    digits:"请输入整数！"
                },
                house_topfloor: {
                    required: "请输入楼层总数!",
                    digits: "请输入整数！"
                },
                house_price: {
                    required: "请输入价格!",
                    digits: "请输入整数！"
                },
                house_deposit: {
                    required:"请选择付款方式！"
                },
                house_totalarea: {
                    required: "请输入建筑面积!",
                    number: "请输入数字！",
                    min:"面积不能小于0"
                },

                house_age:"请选择房龄！",
                house_fitment: {
                    required: "请选择装修情况!"
                },
                house_toward: {
                    required: "请选择房屋朝向!"
                }
                ,
                'house_feature[]': {
                    required: "请选择房源特色"
                },
                check_agree:"请接受我们的声明"
            }//message end
        }
    );
})