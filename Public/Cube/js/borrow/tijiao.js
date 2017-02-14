function aa()
{    
	var title=$('#name').val(); //标题
	var content=$('#zqxmjs').val(); //债权项目说明
	var zjyz=$('#grqksm').val(); //个人情况说明
	var zcjscfx=$('#zcjscfx').val(); //政策及市场分析/调查人综合意见:
	var qybj=$('#qybj').val(); //企业背景/抵押担保情况调查:
	var uuser=$('#username').val();//用户名
	var account=$("#account").val();//借款金额
	
	
		if(title == "")
		{
			alert("请填写标题");
			return false;
		} else if(content == "") {
			alert("请填写(个人贷款项目说明/项目描述)");
			return false;
		} else if(uuser == "") {
			alert("请填写(用户名)");
			return false;			
		} else if(zjyz == ""){
			alert("请填写(贷款个人情况说明/资金运转)");
			return false;
		} else if(zcjscfx == ""){
			alert("请填写(调查人综合意见/政策及市场分析)");
			return false;
		} else if(qybj == ""){
			alert("请填写(抵押担保情况调查/企业背景)");
			return false;
		} else {
			$('#form1').submit();
		} 
	
}