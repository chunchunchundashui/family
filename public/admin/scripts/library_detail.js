//模拟数据

    var template_list = {
        'list|2':[{
            'sort_title':'@title_cn',
            'sort_bg_img' : '',
            'contentList|1' : [{
                'video_title':'@title_cn',
                'video_path':'@url',
                'video_play_number':'@natural(10,99999)'
            }]
        }]
    }


$(function(){

    //placeholder

    // function placeholder(obj){
    //     var defaultStr = '请输入关键字';
    //     obj.css('color','#1482b0');
    //     obj.keydown(function(){
    //         if(obj.val() == defaultStr){
    //             obj.val('').css('color','#fff');
    //         }
    //     });

    //     obj.blur(function(){
    //         if(obj.val() == ''){
    //             obj.val(defaultStr).css('color','#1482b0');
    //         }
    //     })
    // }

    Mock.mock('www.library.com','post',template_list);
   
    var datasCheck = true;
    var _page = 2;
       
    function sendAjax(){
        if(!datasCheck){
            return false;
        }
        datasCheck = false;
        $.ajax({
            type:'post',
            url:'www.library.com',
            data:{page : _page},
            dataType:'json',
            async: false,
            success:function(data){
                var llist = '',  
                    rlist = '',
                    contentList = "",
                    leftBox = $('#J_leftBox'),
                    rightBox = $('#J_rightBox')
                    ;

                    // console.log(JSON.stringify(data, null, 4))

                if(data.list.length){
                    for(var i = 0 ;i<data.list.length;i++){
                        contentList = '';
                        for(var y =0; y < data.list[i].contentList.length; y++){
                            contentList += '<li><a title="'+data.list[i].contentList[y].video_title+'" href="javascript:;" class="J_showViewVideo" data-url="'+data.list[i].contentList[y].video_path+'">'+data.list[i].contentList[y].video_title+'</a><span><b class="play_number">'+data.list[i].contentList[y].video_play_number+'</b>次播放</span></li>'
                        }
                        if(i % 2 == 0){
                            llist +=    '<div class="zt-content-box">'
                            llist +=        '<h3 class="zt-con-title"><i class="zt-con-title-ico"></i>'+data.list[i].sort_title+'</h3>'
                            llist +=        '<div class="zt-content clearfix">'
                            llist +=            '<div class="zt-pic">'
                            llist +=                '<img src="'+ (data.list[i].sort_bg_img == "" ? "/images/base/nopic.jpg" : data.list[i].sort_bg_img ) +'" width="220" height="144" alt="">'
                            llist +=            '</div>'
                            llist +=            '<div class="zt-video-list">'
                            llist +=                '<ul class="clearfix">'
                            llist +=                 contentList
                            llist +=                '</ul>'
                            llist +=            '</div>'
                            llist +=        '</div>'
                            llist +=    '</div>'
                        }else{
                            rlist +=    '<div class="zt-content-box">'
                            rlist +=        '<h3 class="zt-con-title"><i class="zt-con-title-ico"></i>'+data.list[i].sort_title+'</h3>'
                            rlist +=        '<div class="zt-content clearfix">'
                            rlist +=            '<div class="zt-pic">'
                            rlist +=                '<img src="'+(data.list[i].sort_bg_img == "" ? "/images/base/nopic.jpg" : data.list[i].sort_bg_img ) +'" width="220" height="144" alt="">'
                            rlist +=            '</div>'
                            rlist +=            '<div class="zt-video-list">'
                            rlist +=                '<ul class="clearfix">'
                            rlist +=                 contentList
                            rlist +=                '</ul>'
                            rlist +=            '</div>'
                            rlist +=        '</div>'
                            rlist +=    '</div>'
                        };
                           
                    }
                }    
                  
                _page ++ ;
                // console.log(_page,datasCheck);
                leftBox.append(llist);
                rightBox.append(rlist);
                data.status == 0 ? datasCheck = false: datasCheck = true;

            }
        })
    }

    function isScroll(){
        sendAjax();
        $(window).scroll(function(){
            var scrollTop = $(document).height()-$(window).height()-127;
            var height = $(document).scrollTop()+($(window).height()-$('.mg-layer').height())/2;
            var ie6=!-[1,]&&!window.XMLHttpRequest;
            if(ie6){
                $('.mg-layer').css({
                    'position':'absolute',
                    'top':height
                });
            }

            if($(document).scrollTop() >= scrollTop){
               if(datasCheck){
                    sendAjax()
               }
               
              // sendAjax();
            }
        })

    }

    isScroll();


    //屏蔽右键
    $(document).ready(function(){  
        $(document).bind("contextmenu",function(e){   
              return false;   
        });
    });

    //视频播放
    $('#J_contentViewBox').on('click','.J_showViewVideo',function(){
            var _url = $(this).data('url');
            var _title = $(this).attr('title');
            var _html = '<div style="padding: 24px 20px; width:540px; height:403px; background-color:#F2F2F2"><div id="SoPlayer2"></div></div>'
            $.mgLayer({
                //fix:false,
                type : 1,
                title: _title,
                shade   :false,
                border:[1 , 1 , '#595959', true],
                maxWidth:580,
                doc:{
                    box: "#J_videoBox"
                },
                success : function(){
                    var ie6=!-[1,]&&!window.XMLHttpRequest;
                    var height = $(document).scrollTop()+($(window).height()-$('.mg-layer').height())/2;
                    
                    if(ie6){
                        $('.mg-layer').css({
                            'position':'absolute',
                            'top':height
                        });
                    }
                }
            });

            $('#SoPlayer2').mgVideoPlayer({
                title:_title,
                url:_url,
                width   : 540,                      
                height  : 403,
                autoPlay:true
            });
    })
})


