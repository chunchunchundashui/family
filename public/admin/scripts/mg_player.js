//mgVideoPlayer播放器插件 V1.2
// SobeyPlayer FLASH 版本：v3.2

;(function($) {
  	$.fn.mgVideoPlayer = function(options){
  		var $this = this;
  		var obj = $(this);
   		$this.options =$.extend({}, $.fn.mgVideoPlayer.defaults, options);
   		var methods = {
   			//初始化
   			init : function(){
   				methods.addPlayer();
   				if($this.options.plugin){
   					var plugin = [];
   					$this.options.adPlugin == true ? plugin.push('ad') : plugin;
   					$this.options.episodePlugin == true ? plugin.push('episode') : plugin;
   					for(var i =0; i<plugin.length; i++){
   						//console.log(methods.getPlugin(plugin[i]))
   						methods.getPlugin(plugin[i]);
   					}
   				}
   				methods.callback()
   			},

   			addPlayer : function(){
   				var playerHtml = "";
   				_this = $this.options;
   				if(checkMobile()){
   					//移动端
					playerHtml = '<video id="media_'+obj.attr('id')+'" width="'+$this.options.width+'" height="'+$this.options.height+'">'
					+'<source src="'+$this.options.url+'" type="video/mp4">'
					+'</video>';
   					obj.html(playerHtml);
   					methods.addPlayerProperty();
   				}else{
   					//PC端
   					obj.html('<div id="media_'+obj.attr('id')+'"></div>')

   					var version = "10.1.0";
					var xiSwfUrlStr = "playerProductInstall.swf";

					// swf 文件的入口参数
					var flashvars = {
						url			: _this.url,
				 		streamType	: _this.streamType,
				 		isshowcontrol:_this.controls,		
				 		volume		: _this.volume,
				 		plugin 		: _this.plugin,
				 		initMedia	: _this.initMedia,
				 		loadinglogo : _this.loadinglogo,
				 		mode		: _this.mode,
				 		audioOnly   : _this.audioOnly,
				 		loop		: _this.loop,
				 		autoLoad	: _this.autoLoad,
				 		autoPlay	: _this.autoPlay

					};

					//加载 swf 文件时的 Flash 参数；
					var params = {
						quality				: "high",
						bgcolor 			: "#ffffff",
						allowscriptaccess 	: "sameDomain",
						allowfullscreen 	: "true"
						//wmode 				: "transparent"
					};
					
					// swf 对象的属性
					var attributes = {
						id 		: "media_"+obj.attr('id'),
						wmode 	: "transparent",
						name 	: _this.title,
						align 	: "middle"
					};
					
					swfobject.embedSWF(
						_this.playerPath+"/SoPlayer.swf", 
						"media_"+obj.attr('id'),
						_this.width,
						_this.height,
						version, 
						xiSwfUrlStr,
						flashvars, 
						params, 
						attributes
					);
					
   				}
   			},
   			addPlayerProperty : function(){
   				var media = $('#media_'+obj.attr('id'));
   				media.attr({
   					autoplay 	:  _this.autoPlay,
   					controls 	:  "controls",
   					loop 		:  _this.loop,
   					preload 	:  _this.autoLoad
   				});
   			},
   			//插件
   			getPlugin : function(type){
   				switch(type){
   					case "ad" :

   						break;
   					case "episode" :
   						return '[{"source" : "'+$this.options.playerPath+'/plugins/EpisodePlugin.swf"}]'
   						break;

   				}
   			},
   			//剧集
   			episodePlugin : function(){

   			},
   			//广告
   			adPlugin : function(){

   			},
   			//callback
   			callback : function(){
   				if(typeof $this.options.callback == 'function'){

   					$this.options.callback();
   				};
   			}

   		}
   		methods.init(); 		
   	};

   	//检测客户端类型 PC端 移动端
	function checkMobile(){
		if(navigator.userAgent.match(/Android/i)||(navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)){
			return true;
		}else{
			return false;
		}
	}

 	//默认配置
 	$.fn.mgVideoPlayer.defaults = {
 		title 		: '视频标题',			//视频标题
 		playerPath	: '/resources/extensions/SobeyPlayer', //播放器路径
 		width 	: 600,					//设置视频宽度(4:3)			
 		height 	: 450,					//设置视频高度(4:3)
 		url			: '',					//视频地址
 		streamType	: 'vod',				//播放流类型: live:普通直播流 vod:普通点播流(rtmp服务器提供的点播流即支持服务器seek)
 		volume		: 90,					//初始音量(0-100);
 		controls	: true,
 		plugin 		: false,				//是否启动插件true或者flase
 		//插件  应用插件,需要将播放器的plugin参数设为true,并提供js函数getPlugins来返回插件配置数组.
 		adPlugin 	: false,
 		episodePlugin : false,
 		callback 	: function(){},
 		initMedia	: null,					//初始化媒体地址,视频开始前显示的画面
 		loadinglogo : "http://front.mgmall.com/resources/images/base/logo.jpg",
 		mode		: 1,					//播放模式(1:letterbox,2:none,3:fill)
 		audioOnly   : false,				//是否强制设置为音频模式(true or false)
 		loop		: false,				//是否循环播放true或者flase
 		autoLoad	: true,					//是否自动加载,设为false,视频将不自动加载,仅点击播放按钮或外部调用Resume方法是型加载
 		autoPlay	: false				//是否自动播放,设为false,视频在加载后





 	}

})(jQuery);


