/**
 * Created by david on 16/8/18.
 */
//全景图展示
    $(function(){
var panorama = new BMap.Panorama('panorama');

panorama.setPov({heading: -40, pitch: 6});

var myGeo = new BMap.Geocoder();
// 将地址解析结果显示在地图上,并调整地图视野
myGeo.getPoint("庐山路188号", function(point){
    panorama.setPosition(point); //根据经纬度坐标展示全景图
}, "南京市");
    })