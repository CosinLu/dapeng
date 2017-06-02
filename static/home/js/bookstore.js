
var class_;
console.log(localStorage.search);
var _cookie = localStorage.search;
var arr =  _cookie.split(',');
for(var i in arr){
    class_ += "<li>"+
        "<a href=''><span class='search_s1'>"+arr[i]+"</span></a>"+
        "<span class='search_s2'>×</span>"+
        "</li>";
}
$(".search_result_text").html(class_);

var str = $(".search_result_text").html();
str=str.replace("undefined","");
$(".search_result_text").html(str);
if($(".search_s1").html() == ""){
    $(".search_result_text").html("");
}
$(".search_countdown").click(function(){
    localStorage.search = "";
    $(".search_result_text").remove();
});
$(".search_result_text li").click(function(){
    var _this_val = $(this).find(".search_s1").html();
    var index_url = "http://www.iyaoread.com/pps/s.do?pg=c&pd=100030000&gd=4107&ad=001&cd=6882&fc=28000000&pn=1&rt=1&st=4&key="+_this_val;

    $(this).find("a").attr('href',index_url);
});
$(".search_s2").click(function(){
    $(this).parent().remove();
    var remove_text = $(this).parent().find(".search_s1").html();
    _cookie=_cookie.replace(remove_text,"");
    localStorage.search = _cookie;
});