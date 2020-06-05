/**********************************


// @description: 弹出层mgLayer
// @author: 马腾
// @version: v1.10
// @update: 马腾 (2014-03-31)



//配置参数
type:0 					//层类型有 0: 信息框， 1：页面层, 2: iframe层， 3：tips层
fix:false 				//是否固定在可视区域 默认false;
title:'信息' 			//弹出层标题，去掉标题 title:false;
closeBtn[0,true] 		//关闭按钮，有0，1 两种按钮，没有标题时为1 按钮，不要按钮closeBtn[false]
time:0					//自动关闭时间 单位为秒，默认为0不自动关闭
zIndex:9999				//层叠顺序
shade:[0.3,'#000',true] //遮罩层
shadeClose:false,		//点击遮罩区域 关闭弹出层
border:[3 , 0.3 , '#000', true]	//弹出层边框
offset:['auto','50%']	//弹出层左边位置 220 为纵坐标， 50%为横坐标
area:['auto','auto']		//弹出层宽高 320px:宽，auto：高；auto 代表自适应
maxWidth:800			//弹出层最大宽度，当宽为auto才起作用；
move:['.mg-layer-title',true] //拖拽 元素
moveOut: false			//是否可以拖出可视区

dialog:{				//*信息框私有参数
	btns:2,				//按钮个数 从1开始;
	btn:["确认","取消"],  //按钮显示的名称 如果用背景字体可为空
	icoType:0,			//内容前的小图标类型；-1为没有图标
	msg:'显示内容',		//要显示的内容，可带HTML代码
	yes:function(index){},  //按钮1的回调函数
	no:function(index){}    //按钮2的回调函数 
}

doc:{					//*页面层私有参数
	box:"#J_mgLayer",	//弹出层页面的容器选择器 ID 或者 class（建议用ID 确保唯一性）
	html:'',			//自定义HTML字符串
	url:''				//ajax请求地址	
}

iframe:{
	src:'http://www.mgmall.com'	//嵌套到iframe里远程页面；	
}

loading:{type : 0}   	//加载样式0-2种选择 后续加上几种。配合ajax用


tips:{
						//v1.1不做开发后续加上	
	
}

success: function(mgLayer){}    //层弹出成功后的回调函数
close : function(index){}		//关闭按钮的回调函数。
end : function(){}				//层被彻底关闭后执行的回调函数。



**********************************/

(function(window, undefined){

ready = {};

//内置方法
window.mgLayer = {
	
	version: 'v1.10',
	index : 0,
	
	ready: function(callback){
        return callback && callback()
    }, 
	
	//普通对话框，类似系统默认alert();
	alert : function(alertMsg, icotype, alertTitle, alertYes){
		return $.mgLayer({
				title : alertTitle,
				dialog: { btns:1, msg:alertMsg, icoType: icotype, yes:alertYes}
			});
	},
	
	//询问框,
	confirm : function(conMsg, conTitle, conYes, conNo){
		return $.mgLayer({
				title:conTitle,
				dialog:{ btns:2,icoType:1,msg:conMsg,yes:conYes,no:conNo }
		});
	},
	
	//信息框
	msg : function(msgText, msgTime, parme, callback){
		var icon, conf = {title: false, closeBtn: false};
        (msgText == '' || msgText == undefined) && (msgText = '&nbsp;');
        msgTime === undefined && (msgTime = 2);
        if(typeof parme === 'number'){
            icon = parme;
        } else {
            parme = parme || {};
            icon = parme.icoType;
			conf.success = function(){mgLayer.shift(parme.rate)};
            conf.shade = parme.shade;
        }
        conf.time = msgTime;
        conf.dialog = {msg: msgText, icoType: icon};
        conf.end = typeof parme === 'function' ? parme : callback;
        return $.mgLayer(conf);	
	},
	
	//加载框
    load: function(parme, loadIcon){
        if(typeof parme === 'string'){
            return this.msg(parme, 3, 0);
        } else {
            return $.mgLayer({
                time: parme,
                loading: {type : loadIcon},
                bgcolor: '',
				shade	:[0.1,'#000',true],
                border :false,
				offset	:['auto','50%'],
                type : 3,
                title : ['',false],
                closeBtn : [0 , false]
            });
        }
    }, 
	
	//提示框
	tips : function(){
		
	}		
		
};


var Class = function(setings){
	var config = this.config;
	mgLayer.index++;
	this.index = mgLayer.index;
	this.config = $.extend({} , config , setings);
    this.config.dialog = $.extend({}, config.dialog , setings.dialog);
    this.config.doc = $.extend({}, config.doc , setings.doc);
    this.config.iframe = $.extend({}, config.iframe , setings.iframe);	
    this.config.loading = $.extend({}, config.loading , setings.loading);
    this.config.tips = $.extend({}, config.tips , setings.tips);
    this.creat();
};


//默认配置
Class.prototype.config = {
	type	: 0,
	fix		: true,
	title	:['信息',true],
	closeBtn:[0,true],
	time	:0,
	zIndex	:9999,
	shade	:[0.3,'#000',true],
	shadeClose:false,
	bgcolor	:'#fff',
	border	:[4 , 0.2 , '#000', true],
	offset	:['auto','50%'],
	area	:['auto','auto'],
	maxWidth:1190,
	move	:['.mg-layer-title',true],
	moveOut	:false,
	
	dialog:{				
		btns:0,				
		btn:["确认","取消"],  
		icoType:0,			
		msg:'',		
		yes:function(index){ mgLayer.close(index); },  
		no:function(index){ mgLayer.close(index); }     
	},
	
	doc:{					
		box:"#J_mgLayer",	
		html:'',			
		url:''				
	},
	
	iframe:{
		src:'http://www.mgmall.com'		
	},
	
	loading:{type : 0},
	
	tips:{
		//v1.1不做开发后续加上	
	},
	
	success: function(mgLayer){},
	 
	close : function(index){ mgLayer.close(index); },
		
	end : function(){}
		
};

//弹出层类型
Class.prototype.type = ['dialog', 'doc', 'iframe', 'loading', 'tips'];

Class.prototype.ele = {
	lay : 'J_mgLayer',
	ifr : 'J_mgIframe'	
};

//容器
Class.prototype.container = function(html){
	var html = html || '', vindex = this.index, config = this.config, dialog = config.dialog, ele = this.ele,
		ico = dialog.icoType === -1 ? '' : '<span class="layer-msgico layer-msgico-type'+dialog.icoType+'"></span>';
	var btnBox = '';
	//按钮
	switch(dialog.btns){
		case 1 :
			btnBox = '<div id="J_mgLayerBtn'+vindex+'" class="mg-layer-button"><a class="btn mg-layer-btn mg-layer-confirm" href="javascript:;">'+dialog.btn[0]+'</a></div>';
		break;
		case 2 :
			btnBox = '<div id="J_mgLayerBtn'+vindex+'" class="mg-layer-button"><a class="btn mg-layer-btn mg-layer-confirm" href="javascript:;">'+dialog.btn[0]+'</a><a class="btn mg-layer-btn mg-layer-cancel" href="javascript:;">'+dialog.btn[1]+'</a></div>';
	}
	var shade = "", border="", zIndex = config.zIndex + vindex,
		shadeStyle = 'z-index:'+zIndex+'; background-color:'+config.shade[1]+'; opacity:'+config.shade[0]+'; filter:alpha(opacity='+(config.shade[0]*100)+')';
	config.shade[2] && ( shade = '<div id="J_mgShade'+vindex+'" class="mg-shade" style="'+shadeStyle+'"></div>' );
	
	config.zIndex = zIndex;
	
	var frame = [
		//dialog
		'<div class="mg-layer-dialog clearfix">'+ico+'<span class="layer-text" style="'+(ico ? '' : 'padding-left:10px;')+'">'+dialog.msg+'</span></div>'+btnBox,
		//doc
		'<div class="mg-layer-doc clearfix">'+html+'</div>',
		//iframe
		'<iframe id="J_mgIframe'+vindex+'" class="mg-layer-iframe" onload="$(this).removeClass(\'layer-iframe-loading\')" name="mg-layer-iframe'+vindex+'" src="'+config.iframe.src+'" allowTransparency="true" frameborder="0" style="position:relative; z-index:'+zIndex+'"></iframe>',
		//loading
		'<span class="layer-loading layer-loading-type'+config.loading.type+'"></span>',
		//tips
		'<div id="J_mgTips'+vindex+'" class="mg-tips" style="position:relative;  z-index:'+zIndex+'"></div>'
	];
	
	
	
	var title = "", closeBtn="";
	config.closeBtn[1] && (closeBtn = '<a href="javascript:;" title="关闭" class="mg-layer-colse mg-layer-colse'+config.closeBtn[0]+'" >关闭</a>');
	config.title[1] && (title = '<div class="mg-layer-title" ><span class="title">'+config.title[0]+'</span></div>');
	
	var borderStyle = ' position:absolute; z-index:'+(zIndex-1)+'; background-color: '+ config.border[2] +'; opacity:'+ config.border[1] +'; filter:alpha(opacity='+ config.border[1]*100 +'); top:-'+ config.border[0] +'px; left:-'+ config.border[0] +'px; '
	 config.border[3] && (border = '<div id="J_mgLayerBorder'+ vindex +'" class="mg-layer-border" style="'+ borderStyle +'"></div>');
	
	var domeHtml = 	'<div id="J_mgLayer'+vindex+'" class="'+(config.type==3 ? "mg-layer mg-layer-loading":"mg-layer")+'" style="z-index:'+zIndex+'" vindex="'+vindex+'" showtime="'+config.time+'" type="'+this.type[config.type]+'">'
					+'<div class="mg-layer-main clearfix" style="'+(config.title[1] ? 'padding-top:34px;' :'' )+'position:relative; z-index:'+zIndex+'; background-color:'+config.bgcolor+'">'
					+frame[config.type]
					+title
					+closeBtn
					+'</div>'+border+'</div>';
					
	return [shade, domeHtml];
}



//创建框架
Class.prototype.creat = function(){
	var that = this, config = this.config, dialog = config.dialog, title = that.config.title, ele = that.config.ele, vindex = that.index;
	
	title.constructor === Array || (that.config.title=[title,true]);
	title === false && (that.config.title=[title,false]);
	
	var doc = config.doc, body = $("body"), container="";
	var	setContainer = function(html){
			var html = html || '';
			container = that.container(html);
			body.append(container[0]);
		};
	
	switch(config.type){
		case 1:	
			if(doc.html !== ''){
				setContainer('<div class="mgLayerHtml">'+doc.html+'</div>');
				body.append(container[1]);	
			}else if(doc.url !== ''){
				setContainer('<div id="J_mgLayerHtml'+vindex+'" class="mgLayerHtml">'+doc.html+'</div>');
				body.append(container[1]);
				$.get(doc.url, function(datas){
                    $('#J_mgLayerHtml'+ vindex).html(datas.toString());
                    doc.ok && doc.ok(datas);
                });
			}else{
				if( $(doc.box).parents(".mg-layer-doc").length == 0){
					setContainer();
					$(doc.box).show().wrap(container[1]);
				}else{
					return;
				}	
			};
		break;
		
		case 2:
			setContainer();
			body.append(container[1]);
		break;
		
		case 3:
			that.config.closeBtn =['',false];
			that.config.title =['',false];
			setContainer();
			body.append(container[1]);
		break;
			
		case 4:
		//tips内容
		break;
		
		default:
			config.title[1] || (config.area = ['auto','auto']);
			//$('.mg-layer-dialog')[0] && mgLayer.close($('.mg-layer-dialog').parents('.mg-layer').attr('vindex'));
			setContainer();
			body.append(container[1])
		break;			
	};
	//存储层ID
	this.layerE = $('#J_mgLayer'+vindex);
	this.layerB = $('#J_mgLayerBorder'+vindex);
	this.layerS = $('#J_mgShade'+vindex);
	
	var layerE = this.layerE;
	this.layerMain 	= layerE.find('.mg-layer-main');
    this.layerTitle = layerE.find('.mg-layer-title');
    this.layerText 	= layerE.find('.layer-text');
    this.layerDoc 	= layerE.find('.mg-layer-doc');
    this.layerBtn 	= layerE.find('.mg-layer-button');
	
	//层坐标控制
	
	if(config.offset[1].indexOf("px") != -1){
        var _left = parseInt(config.offset[1]);
    }else{
        if(config.offset[1] == '50%'){
            var _left =  config.offset[1];
        }else{
           var _left =  parseInt(config.offset[1])/100 * win.width();
        }
    };
	
	var _marginLeft, _marginTop;
	
	if(that.config.area[0]=="auto"){
		_marginLeft = parseInt((this.layerE.innerWidth()))/2;
	}else{
		_marginLeft = (parseInt(that.config.area[0])+parseInt(that.config.border[0])+parseInt(this.layerE.innerWidth())-parseInt(this.layerE.width()))/2;
	};
	
	this.layerE.css({left: _left, width: that.config.area[0], height: that.config.area[1]})
	
	that.set(vindex)
	//自动关闭层 事件
	config.time <=0 || that.autoClose(); 
	this.callback();	
};


//初始化框架
Class.prototype.set = function(vindex){
	var that = this, layerE = that.layerE, config = that.config, doc = config.doc, box = that.box
	that.autoArea(vindex);
	
	switch(config.type){
		case 1:	
			config.shade[2] && layerE.css({zIndex: config.zIndex + 1});
			layerE.find(doc.box).addClass('layer_docContent');
		break;
		case 2:
            var iframe = layerE.find('.mg-layer-iframe'), heg = layerE.height();
            iframe.addClass('layer-iframe-loading').css({width: layerE.width()});
            config.title[1] ? iframe.css({ height: heg - that.layerTitle.height()}) : iframe.css({ height : heg});
			config.title[1] ? that.layerMain.css({height: heg - that.layerTitle.height()}) : that.layerMain.css({height : heg});
        break;
		
	};
	that.move();
};

//自适应宽高
Class.prototype.autoArea = function(vindex){
	var that = this, layerE = that.layerE, layerB = that.layerB, config = that.config, doc = config.doc, layerDoc = that.layerDoc, layerMain = that.layerMain
	var outHeight,titHeight
	var _borderWidth = config.border[3]? parseInt(config.border[0]) : 0;
	if(config.area[0] === 'auto' && layerMain.outerWidth() >= config.maxWidth){	
        layerE.css({width : config.maxWidth});
    };
	config.title[1] ? titHeight = that.layerTitle.innerHeight() : titHeight = 0;
	
	switch(config.type){
		case 1:
			outHeight = $(doc.box).outerHeight();
			config.area[0] === 'auto' && layerE.css({width : layerDoc.outerWidth()});
			if(doc.html !== '' || doc.url !== ''){
				outHeight = layerDoc.outerHeight();
			}
		break;
		
				
	};
	
	//层样式设置
	var _top;
	if(layerE.outerHeight() >= win.height()){
		_top=0;	
	}else{
		config.offset[0] === 'auto' ? _top = (win.height()-layerE.outerHeight())/2 : _top = parseInt(config.offset[0]);
	};
	
	config.fix ? layerE.css({top: _top + _borderWidth, position: "fixed"}) : layerE.css({top: _top + _borderWidth, position: "absolute"});
	
	(config.area[1] === 'auto') && layerMain.css({height: outHeight});
	layerB.css({width: layerE.outerWidth() + 2*_borderWidth , height: layerE.outerHeight() + 2*_borderWidth});
	(config.offset[1] === '50%' || config.offset[1] == '') && (config.type !== 4) ? layerE.css({marginLeft : -layerE.outerWidth()/2}) : layerE.css({marginLeft : 0});
}




//拖拽层
Class.prototype.move = function(){
	var that = this, config = this.config
	var conf = {
		setY : 0,
		moveLayer : function(){
			if(parseInt(conf.layerE.css('margin-left')) == 0){
				var lefts = parseInt(conf.move.css('left'));
			}else{
				var lefts = parseInt(conf.move.css('left'))+(-parseInt( conf.layerE.css('margin-left')));
			};
			if(conf.layerE.css('position') !== 'fixed'){
				lefts = lefts - conf.layerE.parent().offset().left;
				conf.setY = 0;	
			};
			conf.layerE.css({left: lefts, top: parseInt(conf.move.css('top')) - conf.setY});
		}
	};
	config.move[1] && that.layerE.find(config.move[0]).attr('move','ok');
	config.move[1] ? that.layerE.find(config.move[0]).css({'cursor':'move'}) : that.layerE.find(config.move[0]).css({'cursor':'auto'});
	
	$(config.move[0]).on('mousedown',function(M){
		M.preventDefault();
		if($(this).attr('move') == 'ok'){
			conf.isMove = true;
			conf.layerE = $(this).parents('.mg-layer');
			var thisX = conf.layerE.offset().left,
				thisY = conf.layerE.offset().top,
				thisW = conf.layerE.width()-6,
				thisH = conf.layerE.height()-6;
				
			if(!$('#J_mgMove')[0]){
				$('body').append('<div id="J_mgMove" class="mg-move" style="left:'+thisX+'px; top:'+thisY+'px; width:'+thisW+'px; height:'+thisH+'px; z-index:201404081983"></div>')
			};
			conf.move = $("#J_mgMove");
			conf.moveType && conf.move.css({'opacity':0});
			conf.moveX = M.pageX - conf.move.position().left;
			conf.moveY = M.pageY - conf.move.position().top;
			conf.layerE.css('position') !== 'fixed' || (conf.setY = win.scrollTop());
		};
	});
	
	$(document).mousemove(function(M){
		if(conf.isMove){
			var offsetX = M.pageX - conf.moveX,
				offsetY = M.pageY - conf.moveY;
				
			M.preventDefault();
			
			//是否可以拖出视窗
			if(!config.moveOut){
				conf.setY = win.scrollTop();
                var setRig = win.width() - conf.move.outerWidth() - config.border[0], setTop =  config.border[0] + conf.setY;               
                offsetX < config.border[0] && (offsetX = config.border[0]);
                offsetX > setRig && (offsetX = setRig); 
                offsetY < setTop && (offsetY = setTop);
                offsetY > win.height() - conf.move.outerHeight() - config.border[0] + conf.setY && (offsetY = win.height() - conf.move.outerHeight() -config.border[0] + conf.setY);	
			};
			
			conf.move.css({left: offsetX, top: offsetY});	
            config.moveType && conf.moveLayer();
            
            offsetX = null;
            offsetY = null;
            setRig = null;
            setTop = null
		}
	}).mouseup(function(){
        try{
            if(conf.isMove){
                conf.moveLayer();
                conf.move.remove();
            }
            conf.isMove = false;
        }catch(e){
            conf.isMove = false;
        }
        config.moveEnd && config.moveEnd();
    });
	
	
};

//自动关闭层
Class.prototype.autoClose = function(){
	var that = this, time = this.config.time
	var autoLoad = function(){
		time--;
		if(time==0){
			mgLayer.close(that.index);
			clearInterval(that.autoTime);
		}	
	};
	this.autoTime = setInterval(autoLoad,1000);
};

ready.config = {
    end : {}
};

Class.prototype.callback = function(){
	var that = this, layerE = that.layerE, layerS = that.layerS, config = that.config, dialog = config.dialog;
	that.openLayer();
	that.config.success(that.layerE)
	
	//取消默认事件并关闭层
	layerE.find('.mg-layer-colse').off('click').on('click',function(e){
		e.preventDefault();
		config.close(that.index);	
	});
	
	layerE.find('.mg-layer-confirm').off('click').on('click',function(e){
		e.preventDefault();
		config.yes ? config.yes(that.index) : dialog.yes(that.index);
	});
	
	layerE.find('.mg-layer-cancel').off('click').on('click',function(e){
		e.preventDefault();
		config.no ? config.no(that.index) : dialog.no(that.index);
	});
	
	layerS.off('click').on('click',function(e){
		e.preventDefault();
		config.shadeClose && mgLayer.close(that.index)
	});
	
	ready.config.end[that.index] = config.end;
	
};

//拓展layer方法
Class.prototype.openLayer = function(){
	var that = this, box = that.box
	
	//自适应宽高
	mgLayer.autoArea = function(index){
		return that.autoArea(index)	
	};
	
	//获取layer当前索引
    mgLayer.getIndex = function(selector){
        return $(selector).parents('.mg-layer').attr('vindex');	
    };

    //获取子iframe的DOM
    mgLayer.getChildFrame = function(selector, index){
        index = index || $('.').parents('.mg-layer-iframe').attr('vindex');
        return $('#J_mgLayer'+ index).find('.mg-layer-iframe').contents().find(selector);	
    };

    //得到当前iframe层的索引，子iframe时使用
    mgLayer.getFrameIndex = function(name){
        return $(name ? '#'+ name : '.mg-layer-iframe').parents('.mg-layer').attr('vindex');
    };
	
	//close 事件
	mgLayer.close = function(index){
		var mgLayerNow = $('#J_mgLayer'+index),
			mgShadeNow = $('#J_mgMove, #J_mgShade'+index);
		if(mgLayerNow.attr('type') == that.type[1]){
            if(mgLayerNow.find('.mgLayerHtml')[0]){
                mgLayerNow.remove();
            }else{
                mgLayerNow.find('.mg-layer-colse,.mg-layer-button,.mg-layer-title,.mg-layer-border').remove();
                for(var i = 0 ; i < 5 ; i++){
                    mgLayerNow.find('.layer_docContent').unwrap().hide();
                }
            }
        }else{
            document.all && mgLayerNow.find('#J_mgIframe' + index).remove();;
            mgLayerNow.remove();
        };	
		mgShadeNow.remove();
		typeof ready.config.end[index] === 'function' && ready.config.end[index]();
		delete ready.config.end[index];	
	};
	//关闭所有层
	mgLayer.closeAll = function(){
		var that = this;
		var layerObj = $('.mg-layer');
		$.each(layerObj, function(){
			var i = $(this).attr('vindex');
			mgLayer.close(i);
		});
	};
	
	
	//出场内置动画
    mgLayer.shift = function(type, rate){
        var config = that.config, layerE = that.layerE, cutWth = layerE.outerWidth(), ww = win.width(), wh = win.height();
		var _top = (wh-layerE.outerHeight())/2;
        var anim = {
            t: _top,
            b: wh - layerE.outerHeight() - config.border[0],
			l: (ww-cutWth-config.border[0])/2,
			r: (ww-cutWth-config.border[0])/2
            
        };
        switch(type){
            case 'left':
                layerE.css({left:-ww, top: anim.t, marginLeft: 0}).animate({left:anim.l}, rate);
            break; 
            case 'top':
                layerE.css({top: -wh}).animate({top:anim.t}, rate);
            break;
            case 'right':
                layerE.css({left:ww, top: anim.t, marginLeft: 0}).animate({left:anim.l}, rate);
            break;
            case 'bottom':
                layerE.css({top: wh}).animate({top:anim.t}, rate);
            break;
            
            
        };	
    };
	
	
	
	//初始化拖拽
	mgLayer.setMove = function(){
		return that.move();	
	};
	
	//给指定层重置属性
   // mgLayer.area = function(index, options){
//        var nowobect = [$('#J_mgLayer' + index), $('#J_mgLayerBorder'+ index)],
//        type = nowobect[0].attr('type'), main = nowobect[0].find('.mg-layer-main'),
//        title = nowobect[0].find('.mg-layer-title');
//        if(type === that.type[1] || type === that.type[2]){
//            nowobect[0].css(options);
//            main.css({height: options.height});
//            if(type === that.type[2]){
//                var iframe = nowobect[0].find('iframe');
//                iframe.css({width: options.width, height: title ? options.height - title.outerHeight() : options.height});
//            }
//            if(nowobect[0].css('margin-left') !== '0px') {
//                options.hasOwnProperty('top') && nowobect[0].css({top: options.top - (nowobect[1][0] && parseInt(nowobect[1].css('top')))});
//                options.hasOwnProperty('left') && nowobect[0].css({left: options.left + nowobect[0].outerWidth()/2 - (nowobect[1][0] && parseInt(nowobect[1].css('left')))})
//                nowobect[0].css({marginLeft : -nowobect[0].outerWidth()/2});
//            }
//            if(nowobect[1][0]){
//                nowobect[1].css({
//                    width: parseFloat(options.width) - 2*parseInt(nowobect[1].css('left')), 
//                    height: parseFloat(options.height) - 2*parseInt(nowobect[1].css('top'))
//                });
//            }
//        }
//    };



};


ready.run = function(){
	$ = jQuery;
	win = $(window);
	$.mgLayer = function(deliver){
		var o = new Class(deliver);
		return o.index;
	};
};

ready.run();

	
	
	
})(window)
