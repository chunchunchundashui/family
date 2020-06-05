// 手机播放视频；
(function(jq){	
	
	var VideoPlay = function(options){
		this.options = jq.extend({}, VideoPlay.options, options);
		this.parent = jq(this.options.obj);
		this.reset();
	};
	VideoPlay.prototype = {
		reset : function(){
			this.CheckMedia();	
			
		},
		
		CheckMedia : function(){console.log('inin')
			if(navigator.userAgent.match(/Android/i)||(navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)) {
				var playBox = "<video id=\"media\" width=\""+this.options.str_Width+"\" height=\""+this.options.str_height+"\"><source src='"+this.options.url+"' type='video/mp4'></video>"
				this.parent.html('');
				this.parent.append(playBox);
				media =this.parent.find("#media")[0];
				this.AddPlay();
				}
		},
		
		AddPlay : function(){
			
			media.controls = this.options.controls;
			media.autoPlay = this.options.autoPlay;
			media.loop = this.options.loop;
			media.preload = true,
			this.CurrentTime();	
		},
		CurrentTime : function(){
			media.currentTime;
		}
	}
	//默认
	VideoPlay.options = {
		obj : "#playBox",
		str_Width : 694, 	//视频宽度
		str_height : 390, 	//视频高度
		url : "",    		//视频地址
		controls : true,	//是否有控制条
		autoPlay : false,	//是否自动播放，默认 不自动播放，true 自动播放
		loop : false,		//是否循环播放，默认 不循环播放，true 循环播放 
		startTime : 0,		//如果为流媒体或者不从0开始的资源，则不为0
		currentTime :0		//当前播放的位置，赋值可改变位置 
	}	
			
			
	window.VideoPlay = VideoPlay;
})(jQuery);

