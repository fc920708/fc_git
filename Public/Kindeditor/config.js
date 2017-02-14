KindEditor.ready(function(K) {
		window.editor = K.create('#content', {
		filterMode : false, // 是否开启过滤模式
		resizeType : 1,
		allowPreviewEmoticons : false,
		allowImageUpload : true,
		uploadJson : '/Admin/Upload/uploadImg',
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
	           $("#content").blur();
	           $("#content").siblings('*:last').hide();
	       }   
	});
});