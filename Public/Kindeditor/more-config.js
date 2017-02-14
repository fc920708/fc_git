/**
 * fengchao	2015.12.30
 * 页面加载完后 执行方法  需要 N 个编辑器 则  num = N  ;  
 * 编辑器 id 固定为  content0 开始  content1 content2 content3 content4 content5 ......
 * **/
function more_kindeditor(num){
	KindEditor.ready(function(K) {
		for(var i=0;i<num;i++){
			var id = 'content'+i;
			window.editor = K.create("#"+id, {
			filterMode : false, // 是否开启过滤模式
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : true,
			uploadJson : '/Admin/Mode/uploadImg',
			items : [ 'source', 'undo', 'clearhtml', 'hr', 'fullscreen',
						'formatblock', 'fontname', 'fontsize', '|', 'forecolor',
						'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough',
						'lineheight', '|', 'removeformat', '/', 'justifyleft',
						'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'media', '|',
						'image', 'multiimage','link', 'unlink', 'baidumap', 'lineheight', 'table'],
			afterCreate : function(){
		        this.sync();
		       },
		    afterBlur:function(){
		           this.sync();
		       }   
			});
		}
	});
}