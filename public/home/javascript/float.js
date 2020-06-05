var owner="北京尚才家教";
var sf_mess_cfg={
	theme:"luxury",color:"black",title:"北京尚才家教欢迎您！",send:"提交",copyright:"请家教 010-62642730",mbpos:"RD"
};
var sf_mess_msg={
	emailErr:'请填写正确的Email',messErr:'您的留言字数已超过限制，请保留在1000个字以内。',prefix:'请填写',success:'我们已经收到您的留言,稍候会与您联系.谢谢!',fail:'您的留言发送失败，请重试。'
};
var sf_mess_cols=[{
	type:"textarea",mbtype:"message",tip:"留言内容",innertip:"学员或家长请直接拨打：010-62642730，我们帮您推荐最合适的教员，或在此留言！",idname:"content"
},{
	type:"text",mbtype:"must",tip:"家教科目",innertip:"请输入家教科目",idname:"contact"
},{
	type:"text",mbtype:"tel",tip:"手机号码",innertip:"请输入您的手机号码",idname:"phone"
}];
document.write('<script src="float/entry.js" type="text/javascript"></script>');