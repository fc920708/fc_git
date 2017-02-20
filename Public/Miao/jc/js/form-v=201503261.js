// JavaScript Document
function subJob()
{
	var hrefVar = 'title='+$('#job_title').val();
	if ( $('#job_name').val() == '' )
	{
		showDiv('err_job_name','请输入姓名');
		$('#job_name').focus();
		return false;
	}
	else
		hideDiv('err_job_name')

	hrefVar += '&name='+$('#job_name').val();

	var job_sex = $("input[name='job_sex']:checked").val();
	if( typeof(job_sex) == 'undefined' )
	{
		showDiv('err_job_sex','请选择性别');
		$('#job_sex_1').focus();
		return false;
	}
	else
		hideDiv('err_job_sex')
	hrefVar += '&sex='+job_sex;

	if ( $('#job_age').val() == '' )
	{
		showDiv('err_job_age','请输入年龄');
		$('#job_age').focus();
		return false;
	}
	else
		hideDiv('err_job_age')
	hrefVar += '&age='+$('#job_age').val();

	if ( $('#contact').val() == '' )
	{
		showDiv('err_contact','请输入联系方式');
		$('#contact').focus();
		return false;
	}
	else
		hideDiv('err_contact')
	hrefVar += '&contact='+$('#contact').val();

	if ( $('#domicile').val() == '' )
	{
		showDiv('err_domicile','请输入居住地');
		$('#domicile').focus();
		return false;
	}
	else
		hideDiv('err_domicile')
	hrefVar += '&domicile='+$('#domicile').val();

	if ( $('#job_school').val() == '' )
	{
		showDiv('err_job_school','请输入毕业院校');
		$('#job_school').focus();
		return false;
	}
	else
		hideDiv('err_job_school')
	hrefVar += '&school='+$('#job_school').val();

	if ( $('#job_by_time').val() == '' )
	{
		showDiv('err_job_by_time','请输入毕业时间');
		$('#job_by_time').focus();
		return false;
	}
	else
		hideDiv('err_job_by_time')
	hrefVar += '&by_time='+$('#job_by_time').val();

/*	if ( $('#job_profession').val() == '' )
	{
		showDiv('err_job_profession','请输入所学专业');
		$('#job_profession').focus();
		return false;
	}
	else
		hideDiv('err_job_profession')
	hrefVar += '&profession='+$('#job_profession').val();*/

/*	if ( $('#job_education').val() == '' )
	{
		showDiv('err_job_education','请输入最高学历');
		$('#job_education').focus();
		return false;
	}
	else
		hideDiv('err_job_education')
	hrefVar += '&education='+$('#job_education').val();*/

/*	if ( $('#job_tel').val() == '' )
	{
		showDiv('err_job_tel','请输入联系电话');
		$('#job_tel').focus();
		return false;
	}
	else
		hideDiv('err_job_tel')
	hrefVar += '&tel='+$('#job_tel').val();*/

	//对电子邮件的验证
/*	var myreg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(!myreg.test($('#job_email').val()))
	{
		showDiv('err_job_email','请输入有效的邮箱');
		$('#job_email').focus();
		return false;
	}
	else
		hideDiv('err_job_email')
	hrefVar += '&email='+$('#job_email').val();*/

/*	if ( $('#job_address').val() == '' )
	{
		showDiv('err_job_address','请输入联系地址');
		$('#job_address').focus();
		return false;
	}
	else
		hideDiv('err_job_address')
	hrefVar += '&address='+$('#job_address').val();*/

	if ( $('#job_intro').val() == '' )
	{
		showDiv('err_job_intro','请输入个人简介');
		$('#job_intro').focus();
		return false;
	}
	else
		hideDiv('err_job_intro');
	hrefVar += '&intro='+$('#job_intro').val();

	if ( $('#job_filename').val() == '' )
	{
		showDiv('err_job_filename','请上传简历');
		$('#filename').focus();
		return false;
	}
	else
		hideDiv('err_job_filename');
	hrefVar += '&filename='+$('#job_filename').val();

/*	if ( $('#job_yp_time').val() == '' )
	{
		showDiv('err_job_yp_time','请输入应聘日期');
		$('#job_yp_time').focus();
		return false;
	}
	else
		hideDiv('err_job_yp_time');
	hrefVar += '&yp_time='+$('#job_yp_time').val();*/

	if ( $('#code').val() == '' )
	{
		showDiv('err_code','请输入验证码');
		$('#code').focus();
		return false;
	}
	else
		hideDiv('err_code');
	hrefVar += '&code='+$('#code').val();

	var dataUrl = "index.php?a=resumeSave&m=Ajax&g=Contents";

	$.ajax({
		url: dataUrl,
		type: "POST",
		data: hrefVar,
		cache: false,
		dataType: 'html',
		success: function(html){
			if ( html == 1 )
			{
				alert('提交成功！');
				closeLay('#zhiwei_sq');
				document.getElementById("resumeForm").reset(); 
				document.getElementById('code_img').src='api.php?m=Checkcode&code_len=4&font_size=14&width=100&height=40&font_color=&background=&cname=resume&time='+Math.random();
			}
			else if ( html == 2 )
			alert('请填写详细信息！');
			else if ( html == 3 )
			{
				showDiv('err_code','验证码错误');
				$('#code').focus();
			}
			else
			alert('系统繁忙，请稍后再试！');
		}
	});	
}
function subTest()
{
	var hrefVar = '';
	if ( $('#sj_name').val() == '' )
	{
		showDiv('err_sj_name','请输入姓名');
		$('#sj_name').focus();
		return false;
	}
	else
		hideDiv('err_sj_name');
	hrefVar += 'name='+$('#sj_name').val();

	//对电子邮件的验证
/*	var myreg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(!myreg.test($('#sj_email').val()))
	{
		showDiv('err_sj_email','请输入有效的邮箱');
		$('#sj_email').focus();
		return false;
	}
	else
		hideDiv('err_sj_email')
	hrefVar += '&email='+$('#sj_email').val();*/

	if ( $('#sj_tel').val() == '' )
	{
		showDiv('err_sj_tel','请输入手机号码');
		$('#sj_tel').focus();
		return false;
	}
	else
		hideDiv('err_sj_tel');
	hrefVar += '&tel='+$('#sj_tel').val();

/*	if ( $('#sj_address').val() == '' )
	{
		showDiv('err_sj_address','请输入联系地址');
		$('#sj_address').focus();
		return false;
	}
	else
		hideDiv('err_sj_address');
	hrefVar += '&address='+$('#sj_address').val();*/

/*	if ( $('#car').val() == '请选择' )
	{
		showDiv('err_car','请选择感兴趣的车系');
		$('#car').focus();
		return false;
	}
	else
		hideDiv('err_car');
	hrefVar += '&car='+$('#car').val();*/

	if ( $('#models').val() == '请选择' )
	{
		showDiv('err_models','请选择感兴趣的车型');
		$('#models').focus();
		return false;
	}
	else
		hideDiv('err_models');
	hrefVar += '&models='+$('#models').val();

	if ( $('#s1').val() == '省份' )
	{
		showDiv('err_province','请选择省份');
		$('#s1').focus();
		return false;
	}
	else
		hideDiv('err_province');
	hrefVar += '&province='+$('#s1').val();

	if ( $('#s2').val() == '城市' )
	{
		showDiv('err_city','请选择城市');
		$('#s2').focus();
		return false;
	}
	else
		hideDiv('err_city');
	hrefVar += '&city='+$('#s2').val();

	if ( $('#s3').val() == '地区' )
	{
		showDiv('err_area','请选择地区');
		$('#s3').focus();
		return false;
	}
	else
		hideDiv('err_area');
	hrefVar += '&area='+$('#s3').val();

	if ( $('#buy_time').val() == '' )
	{
		showDiv('err_buy_time','请输入计划购车时间');
		$('#buy_time').focus();
		return false;
	}
	else
		hideDiv('err_buy_time');
	hrefVar += '&buy_time='+$('#buy_time').val();

/*	if ( $('#budget').val() == '请选择' )
	{
		showDiv('err_budget','请选择购车预算');
		$('#budget').focus();
		return false;
	}
	else
		hideDiv('err_budget');
	hrefVar += '&budget='+$('#budget').val();*/

/*	var license = $("input[name='license']:checked").val();
	if( typeof(license) == 'undefined' )
	{
		showDiv('err_license','请选择是否拥有驾照');
		$('#license_1').focus();
		return false;
	}
	else
		hideDiv('err_license');
	hrefVar += '&license='+license;*/

	if ( $('#code').val() == '' )
	{
		showDiv('err_code','请输入验证码');
		$('#code').focus();
		return false;
	}
	else
		hideDiv('err_code');
	hrefVar += '&code='+$('#code').val();
	var dataUrl = "index.php?a=testSave&m=Ajax&g=Contents";

	$.ajax({
		url: dataUrl,
		type: "POST",
		data: hrefVar,
		cache: false,
		dataType: 'html',
		success: function(html){
			if ( html == 1 )
			{
				alert('提交成功！');
				document.getElementById("testForm").reset(); 
				document.getElementById('code_img').src='api.php?m=Checkcode&code_len=4&font_size=14&width=100&height=40&font_color=&background=&cname=test&time='+Math.random();
			}
			else if ( html == 2 )
			alert('请填写详细信息！');
			else if ( html == 3 )
			{
				showDiv('err_code','验证码错误');
				$('#code').focus();
			}
			else
			alert('系统繁忙，请稍后再试！');
		}
	});	
}
function subJoin()
{
	var hrefVar = '';
	if ( $('#jm_name').val() == '' )
	{
		showDiv('err_jm_name','请输入姓名');
		$('#jm_name').focus()
		return false;
	}
	else
		hideDiv('err_jm_name');
	hrefVar += 'name='+$('#jm_name').val();

/*	var jm_sex = $("input[name='jm_sex']:checked").val();
	if( typeof(jm_sex) == 'undefined' )
	{
		showDiv('err_jm_sex','请选择性别');
		$('#jm_sex_1').focus()
		return false;
	}
	else
		hideDiv('err_jm_sex');
	hrefVar += '&sex='+jm_sex;*/

	if ( $('#jm_age').val() == '' )
	{
		showDiv('err_jm_age','请输入年龄');
		$('#jm_age').focus()
		return false;
	}
	else
		hideDiv('err_jm_age');
	hrefVar += '&age='+$('#jm_age').val();

	if ( $('#jm_tel').val() == '' )
	{
		showDiv('err_jm_tel','请输入电话');
		$('#jm_tel').focus()
		return false;
	}
	else
		hideDiv('err_jm_tel');
	hrefVar += '&tel='+$('#jm_tel').val();

/*	if ( $('#jm_idnumber').val() == '' )
	{
		showDiv('err_jm_idnumber','请输入身份证号');
		$('#jm_idnumber').focus()
		return false;
	}
	else
		hideDiv('err_jm_idnumber');
	hrefVar += '&idnumber='+$('#jm_idnumber').val();*/

/*	if ( $('#jm_origin').val() == '' )
	{
		showDiv('err_jm_origin','请输入籍贯');
		$('#jm_origin').focus()
		return false;
	}
	else
		hideDiv('err_jm_origin');
	hrefVar += '&origin='+$('#jm_origin').val();*/

	if ( $('#jm_address').val() == '' )
	{
		showDiv('err_jm_address','请输入联系地址');
		$('#jm_address').focus()
		return false;
	}
	else
		hideDiv('err_jm_address');
	hrefVar += '&address='+$('#jm_address').val();

	if ( $('#jm_money').val() == '' )
	{
		showDiv('err_jm_money','请输入拟投资金');
		$('#jm_money').focus()
		return false;
	}
	else
		hideDiv('err_jm_money');
	hrefVar += '&money='+$('#jm_money').val();

	var store = $("input[name='store']:checked").val();
	if( typeof(store) == 'undefined' )
	{
		showDiv('err_jm_store','请选择有无店面');
		$('#jm_store_1').focus()
		return false;
	}
	else
		hideDiv('err_jm_store');
	hrefVar += '&store='+store;

	var level = $("input[name='level']:checked").val();

/*	if( typeof(level) == 'undefined' )
	{
		showDiv('err_jm_level','请选择加盟级别');
		$('#jm_level_1').focus()
		return false;
	}
	else
		hideDiv('err_jm_level');
	hrefVar += '&level='+level;

	var people = $("input[name='people']:checked").val();
	if( typeof(people) == 'undefined' )
	{
		showDiv('err_jm_people','请选择有无员工');
		$('#jm_people_1').focus()
		return false;
	}
	else
		hideDiv('err_jm_people');
	hrefVar += '&people='+people;*/



/*	var experience = $("input[name='experience']:checked").val();
	if( typeof(experience) == 'undefined' )
	{
		showDiv('err_jm_experience','请选择有无经验');
		$('#jm_experience_1').focus()
		return false;
	}
	else
		hideDiv('err_jm_experience');
	hrefVar += '&experience='+experience;*/

/*	var repair = $("input[name='repair']:checked").val();
	if( typeof(repair) == 'undefined' )
	{
		repair = '';
	}*/
	var jobs = $('#jm_jobs').val();
	var area = $('#jm_area').val();
	var population = $('#jm_population').val();
	var terrain = $('#jm_terrain').val();
	var business_area = $('#jm_business_area').val();
	var tool = $("input[name='tool']:checked").val();
	if( typeof(tool) == 'undefined' )
	{
		tool = '';
	}
	var brand = $("input[name='brand']:checked").val();
	if( typeof(brand) == 'undefined' )
	{
		brand = '';
	}
	var store_area = $('#jm_store_area').val();
	var site = $('#jm_site').val();
	var source = $('#jm_source').val();
	var average_wage = $('#jm_average_wage').val();
	var types = $('#jm_types').val();
	var rent = $('#jm_rent').val();
	var cooperation = $('#jm_cooperation').val();
	if ( $('#code').val() == '' )
	{
		showDiv('err_code','请输入验证码');
		$('#code').focus();
		return false;
	}
	else
		hideDiv('err_code');
	//hrefVar += '&repair='+repair+'&jobs='+jobs+'&area='+area+'&population='+population+'&terrain='+terrain+'&business_area='+business_area+'&tool='+tool+'&brand='+brand+'&store_area='+store_area+'&site='+site+'&source='+source+'&average_wage='+average_wage+'&types='+types+'&rent='+rent+'&cooperation='+cooperation+'&code='+$('#code').val();
	hrefVar += '&jobs='+jobs+'&area='+area+'&population='+population+'&terrain='+terrain+'&business_area='+business_area+'&tool='+tool+'&brand='+brand+'&store_area='+store_area+'&site='+site+'&source='+source+'&average_wage='+average_wage+'&types='+types+'&rent='+rent+'&cooperation='+cooperation+'&code='+$('#code').val();
	var dataUrl = "index.php?a=joinSave&m=Ajax&g=Contents";

	$.ajax({
		url: dataUrl,
		type: "POST",
		data: hrefVar,
		cache: false,
		dataType: 'html',
		success: function(html){
			if ( html == 1 )
			{
				alert('提交成功！');
				document.getElementById("joinForm").reset(); 
				document.getElementById('code_img').src='api.php?m=Checkcode&code_len=4&font_size=14&width=100&height=40&font_color=&background=&cname=join&time='+Math.random();
			}
			else if ( html == 2 )
			alert('请填写详细信息！');
			else if ( html == 3 )
			{
				showDiv('err_code','请输入验证码');
				$('#code').focus();
			}
			else
			alert('系统繁忙，请稍后再试！');
		}
	});	
}
function subTs()
{
	if ( $('#ts_name').val() == '' )
	{
		showDiv('err_ts_name','请输入姓名');
		$('#ts_name').focus();
		return false;
	}
	else
		hideDiv('err_ts_name');

	if ( $('#ts_email').val() == '' )
	{
		showDiv('err_ts_email','请输入邮箱');
		$('#ts_email').focus();
		return false;
	}
	else
		hideDiv('err_ts_email');
	//对电子邮件的验证
	var myreg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(!myreg.test($('#ts_email').val()))
	{
		showDiv('err_ts_email','请输入有效的邮箱');
		$('#ts_email').focus();
		return false;
	}
	else
		hideDiv('err_ts_email');
	if ( !isMobel($('#ts_tel').val()) )
	{
		showDiv('err_ts_tel','请输入有效的手机号码');
		$('#ts_tel').focus();
		return false;
	}
	else
		hideDiv('err_ts_tel');
	if ( $('#ts_address').val() == '' )
	{
		showDiv('err_ts_address','请输入联系地址');
		$('#ts_address').focus();
		return false;
	}
	else
		hideDiv('err_ts_address');
	if ( $('#ts_zipcode').val() == '' )
	{
		showDiv('err_ts_zipcode','请输入邮编');
		$('#ts_zipcode').focus();
		return false;
	}
	else
		hideDiv('err_ts_zipcode');
	if ( $('#ts_title').val() == '' )
	{
		showDiv('err_ts_title','请输入主题');
		$('#ts_title').focus();
		return false;
	}
	else
		hideDiv('err_ts_title');
	if ( $('#ts_content').val() == '' )
	{
		showDiv('err_ts_content','请输入内容');
		$('#ts_content').focus();
		return false;
	}
	else
		hideDiv('err_ts_content');
	if ( $('#code').val() == '' )
	{
		showDiv('err_code','请输入验证码');
		$('#code').focus();
		return false;
	}
	else
		hideDiv('err_code');
	var hrefVar = 'title='+$('#ts_title').val()+'&name='+$('#ts_name').val()+'&email='+$('#ts_email').val()+'&tel='+$('#ts_tel').val()+'&content='+$('#ts_content').val()+'&zipcode='+$('#ts_zipcode').val()+'&address='+$('#ts_address').val()+'&code='+$('#code').val();
	var dataUrl = "index.php?a=bookSave&m=Ajax&g=Contents";

	$.ajax({
		url: dataUrl,
		type: "POST",
		data: hrefVar,
		cache: false,
		dataType: 'html',
		success: function(html){
			if ( html == 1 )
			{
				alert('提交成功！');
				$('#ts_name').val('');
				$('#ts_email').val('');
				$('#ts_tel').val('');
				$('#ts_address').val('');
				$('#ts_zipcode').val('');
				$('#ts_title').val('');
				$('#ts_content').val('');
				$('#code').val('');
				document.getElementById('code_img').src='api.php?m=Checkcode&code_len=4&font_size=14&width=100&height=40&font_color=&background=&cname=ts&time='+Math.random();
			}
			else if ( html == 2 )
			alert('请填写详细信息！');
			else if ( html == 3 )
			{
				showDiv('err_code','验证码错误');
				$('#code').focus();
			}
			else
			alert('系统繁忙，请稍后再试！');
		}
	});	

}
function subReg()
{
	var hrefVar = '';
	if ( $('#reg_name').val() == '' )
	{
		showDiv('err_reg_name','请输入姓名');
		$('#reg_name').focus()
		return false;
	}
	else
		hideDiv('err_reg_name');
	hrefVar += 'name='+$('#reg_name').val();

	var reg_sex = $("input[name='reg_sex']:checked").val();
	if( typeof(reg_sex) == 'undefined' )
	{
		showDiv('err_reg_sex','请选择性别');
		$('#reg_sex_1').focus()
		return false;
	}
	else
		hideDiv('err_reg_sex');
	hrefVar += '&sex='+reg_sex;

	if ( $('#models').val() == '请选择' )
	{
		showDiv('err_models','请选择车辆型号');
		$('#models').focus()
		return false;
	}
	else
		hideDiv('err_models');
	hrefVar += '&models='+$('#models').val();

	if ( $('#buy_time').val() == '' )
	{
		showDiv('err_buy_time','请输入购买日期');
		$('#buy_time').focus()
		return false;
	}
	else
		hideDiv('err_buy_time');
	hrefVar += '&buy_time='+$('#buy_time').val();

	if ( !isMobel($('#reg_tel').val()) )
	{
		showDiv('err_reg_tel','请输入有效的手机号码');
		$('#reg_tel').focus();
		return false;
	}
	else
		hideDiv('err_reg_tel');
	hrefVar += '&tel='+$('#reg_tel').val();
	//对电子邮件的验证
	var myreg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(!myreg.test($('#reg_email').val()))
	{
		showDiv('err_reg_email','请输入有效的邮箱');
		$('#reg_email').focus();
		return false;
	}
	else
		hideDiv('err_reg_email');
	hrefVar += '&email='+$('#reg_email').val();

	if ( $('#reg_address').val() == '' )
	{
		showDiv('err_reg_address','请输入联系地址');
		$('#reg_address').focus()
		return false;
	}
	else
		hideDiv('err_reg_address');
	hrefVar += '&address='+$('#reg_address').val();

	if ( $('#reg_zipcode').val() == '' )
	{
		showDiv('err_reg_zipcode','请输入邮编');
		$('#reg_zipcode').focus()
		return false;
	}
	else
		hideDiv('err_reg_zipcode');
	hrefVar += '&zipcode='+$('#reg_zipcode').val();

	if ( $('#code').val() == '' )
	{
		showDiv('err_code','请输入验证码');
		$('#code').focus();
		return false;
	}
	else
		hideDiv('err_code');
	hrefVar += '&code='+$('#code').val();
	var dataUrl = "/index.php?a=regSave&m=Ajax&g=Contents";

	$.ajax({
		url: dataUrl,
		type: "POST",
		data: hrefVar,
		cache: false,
		dataType: 'html',
		success: function(html){
			if ( html == 1 )
			{
				alert('提交成功！');
				document.getElementById("regForm").reset(); 
				document.getElementById('code_img').src='api.php?m=Checkcode&code_len=4&font_size=14&width=100&height=40&font_color=&background=&cname=reg&time='+Math.random();
			}
			else if ( html == 2 )
			alert('请填写详细信息！');
			else if ( html == 3 )
			{
				showDiv('err_code','验证码错误');
				$('#code').focus();
			}
			else
			alert('系统繁忙，请稍后再试！');
		}
	});	
}
function isMobel(value)
{
	if(/^13\d{9}$/g.test(value)||(/^15[0-35-9]\d{8}$/g.test(value))||   
	(/^18[05-9]\d{8}$/g.test(value)))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function hideDiv(id)
{
	$('#'+id).html('');
	$('#'+id).hide();
}
function showDiv(id,str)
{
	$('#'+id).html(str);
	$('#'+id).show();
}