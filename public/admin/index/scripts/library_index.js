
	//模拟数据

	var template_list = {
		'list|9':[{
			'videoPic' : '@img',
			'videoUrl':'@url',
			'title':'@title_cn',
			'intro':'@paragraph_cn(1)',
			'videoTotal':'@natural(10,99999)',
			'videoPlayTotal':'@natural(10,99999)'
		}]
	}

$(function() {

	function placeholder(obj){
		var defaultStr = '请输入关键字';
		obj.css('color','#1482b0');
		obj.keydown(function(){
			if(obj.val() == defaultStr){
				obj.val('').css('color','#fff');
			}
		});

		obj.blur(function(){
			if(obj.val() == ''){
				obj.val(defaultStr).css('color','#1482b0');
			}
		})
	}

	placeholder($('.search-input'));

	Mock.mock('www.library.com','get',template_list);
	
	$.ajax({
		type:'get',
		url:'www.library.com',
		dataType:'json',
		success:function(data){
			var list = '';
			$.each(data.list,function(i,v){
				list +=	'<li>'
				list +=		'<div class="video-bg">'
	            list +=            '<a href="'+v.videoUrl+'" title="" target="_bank">'
	            list +=                '<img src="'+v.videoPic+'" width="220" height="144" alt="">'
	            list +=            '</a>'
				list +=		'</div>'
				list +=		'<div class="video-info">'
				list +=			'<dl>'
				list +=				'<dd class="video-title"><i class="video-title-ico"></i><a href="'+v.videoUrl+'" target="bank">'+v.title+'</a></dd>'
				list +=				'<dd class="video-intro">'+v.intro+'</dd>'
				list +=				'<dd class="video-record">'
				list +=					'<span class="video-total"><i class="video-total-ico"></i><em>'+v.videoTotal+'</em>条视频</span>'
				list +=					'<span class="video-play-total"><i class="video-play-total-ico"></i><em>'+v.videoPlayTotal+'</em>次播放</span>'
				list +=				'</dd>'
				list +=			'</dl>'
				list +=		'</div>'
				list +=	'</li>'
			})

			$('.video-directory').append(list);
		}
	})
})