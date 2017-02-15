<?php
/**
 * Kindeditor编辑器Widget
 * Created by PhpStorm.
 * User: zc
 * Date: 2015/11/19
 * Time: 11:31
 */
namespace Admin\Widget;

use Think\Controller;

class KindeditorWidget extends Controller
{
    /**
     * 编辑器是否被使用过
     *
     * @var bool
     */
    static $_used = false;

    /**
     * KindEditor css js file
     *
     * @author zhangcheng
     * @return string
     */
    protected function cssJsFile()
    {
        if (self::$_used) {
            return '';
        }

        self::$_used = true;

        return '<link rel="stylesheet" href="' . C('TMPL_PARSE_STRING.__KINDEDITOR__') . '/themes/default/default.css" />
        <script src="' . C('TMPL_PARSE_STRING.__KINDEDITOR__') . '/kindeditor-all-min.js"></script>
        <script charset="utf-8" src="' . C('TMPL_PARSE_STRING.__KINDEDITOR__') . '/lang/zh-CN.js"></script>';
    }


    /**
     * 单独上传一张图片
     *
     * @param string $inputImageId 存放图片地址的ipnut框id
     * @param string $btnUploadId  上传按钮的id
     * @param string $imgId        上传之后 设置图片url到指定img标签的id  展示新图像
     *
     * @author zhangcheng
     *
     * @return string
     */
    public function uploadOneImg($inputImageId, $btnUploadId, $imgId = '')
    {

        $scriptString = "<script>
            KindEditor.ready(function(K) {
                var uploadbutton = K.uploadbutton({
                            button : K('#{$btnUploadId}')[0],
                            fieldName : 'imgFile',
                            url : '" . C('TMPL_PARSE_STRING.__KINDEDITOR__') . "/php/upload_json.php?dir=image',
                            afterUpload : function(data) {
                    if (data.error === 0) {
                        var url = K.formatUrl(data.url, 'absolute');
                        K('#{$inputImageId}').val(url);

                        if( {$imgId} != ''){

                            K('#{$imgId}').attr('src',url);
                            K('#{$imgId}').css('display','block');
                        }
                    } else {
                        alert(data.message);
                    }
                },
                            afterError : function(str) {
                    alert('自定义错误信息: ' + str);
                }
                        });
                        uploadbutton.fileBox.change(function(e) {
                            uploadbutton.submit();
                        });
                    });
        </script>";

        $cssJsFile = $this->cssJsFile();


        echo $cssJsFile . $scriptString;

    }

    /**
     * 单独上传一张图片
     *
     * @param string $inputImageId 存放图片地址的ipnut框id
     * @param string $btnUploadId  上传按钮的id
     * @param string $imgId        类别
     *
     * @author fengchao
     *
     * @return string
     */
    public function uploadOneImgMode($inputImageId, $btnUploadId, $imgId = '')
    {	
    	$scriptString = "<script>
					    	KindEditor.ready(function(K) {
					    		var editor = K.editor({
					    			allowFileManager : true
					    		});
						    	K('.{$btnUploadId}').click(function() {
							    	editor.loadPlugin('image', function() {
								    	editor.plugin.imageDialog({
									    	imageUrl : K('#{$inputImageId}').val(),
									    	clickFn : function(url, title, width, height, border, align) {
									    		$('#hidden').children('div').addClass('{$inputImageId}-list');
    											$('#hidden').find('div').find('a').attr('data-lightbox','example-set');
    											$('#hidden').find('div').find('a').attr('href',url);
						                        $('#hidden').find('div').find('a').find('img').attr('src',url);
						                        $('#hidden').find('div').find('div').addClass('{$inputImageId}-div');
						                        $('#hidden').find('div').find('div').find('.fa-eye').addClass('{$inputImageId}-edit');
						                        $('#hidden').find('div').find('div').find('.fa-eye').attr('onclick','eye(this)');
						                        $('#hidden').find('div').find('div').find('.fa-trash-o').addClass('{$inputImageId}-del');
						                        $('#hidden').find('div').find('div').find('.fa-trash-o').attr('onclick','{$imgId}del(this)');
						                        $('#hidden').find('div').find('input').attr('name','{$inputImageId}-url[]');
						                        $('#hidden').find('div').find('input').attr('value',url);
						                        var html = $('#hidden').html();
						                        $('#{$inputImageId}-list').append(html);
						                        $('#{$inputImageId}').siblings('*:last').hide();
						                        $('button.btn-info').prop('disabled',false);
												$('#hidden').children('div').removeClass('{$inputImageId}-list');
    											$('#hidden').find('div').find('a').attr('data-lightbox','');
    											$('#hidden').find('div').find('a').attr('href','');
						                        $('#hidden').find('div').find('a').find('img').attr('src','');
						                        $('#hidden').find('div').find('div').removeClass('{$inputImageId}-div');
						                        $('#hidden').find('div').find('div').find('.fa-eye').removeClass('{$inputImageId}-edit');
						                        $('#hidden').find('div').find('div').find('.fa-eye').attr('onclick','');
						                        $('#hidden').find('div').find('div').find('.fa-trash-o').removeClass('{$inputImageId}-del');
						                        $('#hidden').find('div').find('div').find('.fa-trash-o').attr('onclick','');
						                        $('#hidden').find('div').find('input').attr('value','');
									    		editor.hideDialog();
									    	}
								    	});
							    	});
						    	});
					    	});
				    	</script>";
    
    $cssJsFile = $this->cssJsFile();
    
    
    echo $cssJsFile . $scriptString;
    
    }

    /**
     * KindEditor Simple
     *
     * @param string $textareaName textarea name值
     * @param array  $config       Kindeditor编辑器配置项
     * @param string $editorName   编辑器对象赋值名称 以便接下来其他js调用 默认 editor
     *
     * @author zhangcheng
     *
     * @return string
     */
    public function createTextarea($textareaName, $config, $editorName = 'editor')
    {
        //默认配置
        $default = array(
            'resizeType'            => 1,
            'width'                 => '100%',
            'allowPreviewEmoticons' => true,
            'allowImageUpload'      => true,
            'items'                 => array(
                'fontname', 'fontsize', '|',
                'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'removeformat', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|',
                'emoticons', 'image', 'link'
            ),

        );

        $config = array_merge($default, $config);

        //KindEditor配置对象
        $configStr = json_encode($config, true);

        $scriptString = "
		<script>
			var {$editorName};
			KindEditor.ready(function(K) {
				{$editorName} = K.create('textarea[name=\"{$textareaName}\"]',
                {$configStr}
            );
			});
		</script>
        ";

        $cssJsFile = $this->cssJsFile();


        echo $cssJsFile . $scriptString;
    }

    
    
     /**
     * 图片上传插件
     *
     * @param string $btnUpload 图片上传按钮class值
     * @param string $showImg  图片显示id
     * @param string $imgHidden  图片路径隐藏域id
     *
     * @author wangpeng
     *
     * @return string
     */
    public  function  uploadImage($btnUpload,$showImg,$imgHidden){
    	$scriptString = "<script>
    	KindEditor.ready(function(K) {
    		var editor = K.editor({
    			allowFileManager : true
    		});
    		K('.{$btnUpload}').click(function() {
    			editor.loadPlugin('image', function() {
    				editor.plugin.imageDialog({
    					imageUrl : K('#{$imgHidden}').val(),
    					clickFn : function(url, title, width, height, border, align) {
    						K('#{$imgHidden}').val(url);
    						$('#{$showImg}').attr('src',url);
    						editor.hideDialog();
    					}
    				});
    			});
    		});
    	
    	});
    	</script>";
    	
    	$cssJsFile = $this->cssJsFile();
    	
    	
    	echo $cssJsFile . $scriptString;
    }
    
    /**
     * 新闻
     *
     * @param string $btnUpload 图片上传按钮class值
     * @param string $showImg  图片显示id
     * @param string $imgHidden  图片路径隐藏域id
     *
     * @author fengchao
     *
     * @return string
     */
    public  function  uploadNewsImage($btnUpload,$showImg,$imgHidden){
    	$scriptString = "<script>
		    	KindEditor.ready(function(K) {
			    	var editor = K.editor({
			    	allowFileManager : true
			    });
			    K('.{$btnUpload}').click(function() {
				    editor.loadPlugin('image', function() {
					    editor.plugin.imageDialog({
						    imageUrl : K('#{$imgHidden}').val(),
						    clickFn : function(url, title, width, height, border, align) {
							    K('#{$imgHidden}').val(url);
							    $('#{$showImg}').attr('src',url);
							    $('#{$imgHidden}').siblings('*:last').hide();
							    $('#{$imgHidden}').blur();
							    editor.hideDialog();
					    	}
				    	});
			    	});
		    	});
     		});
    </script>";
     
    $cssJsFile = $this->cssJsFile();
     
     
    echo $cssJsFile . $scriptString;
    }

}