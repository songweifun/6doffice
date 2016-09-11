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

    $('#dataInfo').validate(
        {

            //自定义验证信息
            rules: {
                msg_to: {
                    required: true

                },
                msg_title: {
                    required: true,
                    rangelength: [1, 25]
                },
                msg_content: {
                    required: true

                }

            },
            messages: {
                msg_to: {
                    required: "输入收件人用户名",

                },
                msg_title: {
                    required: "请输入信件主题!",
                    rangelength: "主题最多25个汉字"
                },
                msg_content: {
                    required: "请输入信件内容!"
                }
            }//message end
        }
    );
})