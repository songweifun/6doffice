/**
 * Created by david on 16/9/8.
 */
$(function(){

    function alertObj(obj){
        var output = "";
        for(var i in obj){
            var property=obj[i];
            output+=i+" = "+property+"\n";
        }
        alert(output);
    }


    var cache={}



    $( "#borough_name" ).autocomplete({

        //请求远程数据

        source: function( request, response ) {
            var term = request.term;

            if(term in cache){ //本地缓存 其实就是用一个数组保存已经发送过请求的key和对应返回的data对象
                data = cache[term];
                response($.map(data,function(item){
                    return {label:item.borough_name,value:item.borough_name,info:item.info,address:item.borough_address,borough_id:item.id}
                }))

            }else{
                //alert(11111)

                $.ajax({

                    url:hosesellajaxurl+"/action/getBoroughList",
                    dataType:'jsonp',
                    data:{
                        q:request.term
                    },
                    success:function(data){
                        cache[term] = data;
                        response($.map(data,function(item){
                            return {label:item.borough_name,value:item.borough_name,info:item.info,address:item.borough_address,borough_id:item.id}
                        }))//response



                    }//success
                })//ajax
            }

        },//source
        //选择后触发的动作
        select: function(event, ui) {
            //alert(ui.item.info[0].pic_url)
            if(ui.item.value=='我要创建新小区'){

                layer.open({
                    type: 2,
                    title: '增加小区',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area : ['400px' , '165px'],
                    content: addBoroughurl
                });
                //$('#borough_name').val()
                ui.item.value=''



            }else{
                var str="<div style='width:647px;line-height:30px;color:#999999'>以下为小区上传户型图，如无发布房源户型，请自行上传！</div>";
                var len=(ui.item.info)?ui.item.info.length:0;
                for(i=0;i<len;i++){
                    str+='<li style="width:160px; height:150px;margin-right:15px;float:left; text-align:center;overflow:hidden; margin-top:5px;">\
                    <a href="'+imagefooturl+ui.item.info[i].pic_url+'" target="_blank"><img src="'+imagefooturl+ui.item.info[i].pic_thumb+'" width=160 height=120 style="padding-bottom:3px"/></a>\
                    <input name="house_drawing" id="house_drawing"type="radio" value="'+ui.item.info[i].pic_url+'" />\
                    <span>'+ui.item.info[i].pic_desc+'</span>\
                    </li>\
                    ';
                }
                str+='</ul>';
                $("#borough_id").val(ui.item.borough_id);
                $("#borough_addr").val(ui.item.address);
                $("#house_drawing_dis").html(str);
                $("#borough_addr_tr").css("display","");
            }
        },
        minLength: 2,
        autoFocus: false,
        delay: 0,
        //定位,css设置
        position: { using:function(pos){

            var topOffset = $(this).css(pos).offset().top;

            $(this).css({'top':'topOffset','width':'260','height':'220','overflow':'scroll'});
            $(this).children().last().css('color','red');


        }},
    });



})
