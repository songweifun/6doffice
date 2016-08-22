/**
 * Created by david on 16/8/22.
 */
$(function(){
    // 联系电话(手机/电话皆可)验证
    $.validator.addMethod("isTel", function(value,element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
        return this.optional(element) || tel.test(value) || (length==11 && mobile.test(value));
    }, "请正确填写您的联系方式");

    $('#registerform').validate(

        {
            //定义错误信息显示位置
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().siblings(".reg_b123"));
            },
            //自定义验证信息
            rules: {
                username: {
                    required: true,
                    rangelength:[4,16]
                },
                passwd: {
                    required: true,
                    rangelength:[6,20]
                },
                passwd2: {
                    required: true,
                    rangelength:[6,20],
                    equalTo: "#passwd"
                },
                email: {
                    required: true,
                    email: true
                },
                realname:{
                    required: true,
                    rangelength:[2,5],

                },
                outlet_first:{
                    required:true
                },
                outlet_last:{
                    required:true
                },
                mobile:{
                    required:true,
                    isTel:true
                },
                verify:{
                    required:true
                }

            },
            messages: {
                username: {
                    required: "请输入用户名",
                    rangelength: "长度须4-16个字符！"
                },
                passwd: {
                    required: "请输入密码",
                    rangelength: "长度6-20个字符！"
                },
                passwd2: {
                    required: "请输入密码",
                    rangelength: "长度6-20个字符！",
                    equalTo: "两次密码输入不一致"
                },
                email: {
                    required:"请输入邮箱",
                    email:"Email格式不正确！"
                },
                realname:{
                    required:"请输入真实姓名！",
                    rangelength: "长度须2-5个字符！"
                },
                outlet_first:"请填写所属公司！",
                outlet_last:"请填写门店！",
                mobile:{
                    required:"请输入联系方式",
                    isTel:"联系方式格式错误"
                },
                verify:"请输入验证码"

            }
        }







    );

    $('.reg_b128').click(function(){


        var code=$('#verifycode').val();
        $.ajax({
            url:codeCheckAjaxUrl,
            dataType:'json',
            type:'post',
            data:{'code':code},
            success:function(result){
                if(result.status){
                    $('#registerform').submit();
                }else {
                   $('#errMsg_vaild')[0].innerHTML=result.returnMSG;
                }
            }
        })

    })

})

/*
<script type="text/javascript">

var  msgInfo  =  [];
msgInfo["username"] = '4-16个字符(包括小写字母、数字、下划线)<span class="cRed">(必填)</span>' ;
msgInfo["passwd"] = '6-20个字符组成(包括英文字母、数字、符号)，区分大小写。<span class="cRed">(必填)</span>' ;
msgInfo["passwd2"] = '请再输入一遍您上面输入的密码。<span class="cRed">(必填)</span>';
msgInfo["email"] = '重要！这是您找回密码的唯一方式！请留常用的Email。<span class="cRed">(必填)</span>';
msgInfo["valid"] = '请输入左侧显示的字符。<span class="cRed">(必填)</span>';

FormValid.showError = function(errMsg,errName,formName) {
    if (formName=='registerform') {
        for (key in FormValid.allName) {//alert('errMsg_'+FormValid.allName[key]);
            document.getElementById('errMsg_'+FormValid.allName[key]).innerHTML = '';
        }
        for (key in errMsg) {
            document.getElementById('errMsg_'+errName[key]).innerHTML = errMsg[key];
        }
    }
}

var r = null;
function ckname (inp) {
    $.ajax({type:"GET", url:"ajax.php?r="+Math.random()+'&action=unique&username='+inp.value, dataType:"text",async:false,success:function (msg){
        r = msg;
    }});
    if (r==0) {
        return false;
    } else {
        return true;
    }
}
</script>
<script type="text/javascript">
    initValid(document.registerform);
</script>*/
