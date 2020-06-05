var menus=document.getElementsByClassName("menu");//上方菜单数组
var pages=document.getElementsByClassName("page");//下面页面数组

var index=0;//index是索引值，表示第几个页面正在显示

var clearActive=function(){
	for(var i=0;i<menus.length;i++){
	menus[i].className='menu';
	pages[i].className='page';
	
	}
}//用来清除操作留下的问题
var goindex=function(){
	clearActive();
	menus[index].className='menu active';
    pages[index].className='page active';
  
    
}//改变index的值

//三个按钮菜单
var page1=function(){
	index=0;
	goindex();
}
var page2=function(){
	index=1;
	goindex();
}
var page3=function(){
	index=2;
	goindex();
}
//计时器
window.onload=function(){
				var time={
					init:function(){
						var oTime=document.getElementById("time_dsq");
						var h = '0'+1;
						var m = 59;
						var s = 60;
						oTime.innerHTML="02:00:00";
						//进行倒计时显示
						var time = setInterval(function(){
							--s;
							if(s<0){
								m--;
								s = 59
							}
							if(m<0){
								h--;
								m = 59;
							}
							if(h<0){
								s = 0;
								m = 0;
							}
							//当分秒小于10时补0
							function chekTime(i){
								if (i<10){
									i = '0'+i;
								}
								return i;
							}
							s = chekTime(s);
							m = chekTime(m);
							oTime.innerHTML=h+":"+m+":"+s;
						},1000)
					}
				}
				time.init()
			}