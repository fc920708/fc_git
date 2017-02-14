function aa()
{
	var title=$('#name').val(); //标题
	var content=$('#zqxmjs').val(); //个人贷款项目说明
	var zjyz=$('#grqksm').val(); //个人情况说明
	var zcjscfx=$('#zcjscfx').val(); //政策及市场分析/调查人综合意见:
	var qybj=$('#qybj').val(); //企业背景/抵押担保情况调查:
	var advise=$('#advise').val(); //初审意见
	
	if(title == "")
		{
			alert("请填写标题");
			return false;
		} else if(content == "") {
			alert("请填写(个人贷款项目说明/项目描述)");
			return false;
		} else if(zjyz == ""){
			alert("请填写(个人情况说明)");
			return false;
		} else if(zcjscfx == ""){
			alert("请填写(政策及市场分析/调查人综合意见)");
			return false;
		} else if(qybj == ""){
			alert("请填写(企业背景/抵押担保情况调查)");
			return false;
		} else {
			$('#form1').submit();
		} 
}