<?php
/**
 * 在指定日期将灯笼挂在网站上。
 * @package DengLong
 * @author wxy
 * @version 1.0.1
 * @link http://118.178.241.13/
 */

require_once("Lunar.class.php");//先包含这个文件

/* 激活插件方法 */
class DengLong_Plugin implements Typecho_Plugin_Interface
{
    public static function activate(){
        Typecho_Plugin::factory('Widget_Archive')->header = array('DengLong_Plugin', 'submit');
        return _t('插件已启用');
    }
     
    /* 禁用插件方法 */
    public static function deactivate(){
        return _t('插件已禁用');
    }
     
    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form){


	    $date= new Typecho_Widget_Helper_Form_Element_Textarea('word', NULL,
		'1|01-01|新年快乐
1|10-01|国庆快乐', _t('挂灯笼的日期及祝福语(仅限4个字)'), _t('填入形如"1|01-01|新年快乐"，一行一个'."\n".'注意:最前面的1代表公历,2代表农历'));
	    $form->addInput($date);

    }
     
    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
     
    /* 插件实现方法 */
    public static function submit(){
       $CustomDate=Typecho_Widget::widget('Widget_Options')->plugin('DengLong')->word;
	    /*if ( strstr( $CustomDate, date( 'm-d', time() ) ) ){

            echo '';

	    }*/
	    $lunar = new Lunar();//生成对象
	    
	    if (trim($CustomDate)!=""){
	        $arr = explode("\n", $CustomDate);
	        if (is_array($arr)){
	            for ($i = 0;$i < count($arr);$i++){
	                $item = $arr[$i];
	                if (trim($item)!=""){
	                    $itemArr = explode("|",$item);
	                    if (is_array($itemArr)){
	                        if ($itemArr[0]=='1') {
	                            if (strstr($item, date('m-d', time()))){
	                                $itemZfy = $itemArr[2];
	                                $itemZfyArr = str_split($itemZfy,3);
	                            }
	                        }elseif ($itemArr[0]=='2') {
	                            $lunardate = $lunar->convertSolarToLunar(date('Y', time()),date('m', time()),date('d', time())); //公历转农历
	                            $lunarMonthDay = sprintf('%02s',$lunardate[4]).'-'.sprintf('%02s',$lunardate[5]);
	                            if (strstr($item, $lunarMonthDay)){
	                                $itemZfy = $itemArr[2];
	                                $itemZfyArr = str_split($itemZfy,3);
	                            }
	                        }
	                    }
	                }
	                
	                
	                if (!empty($itemZfyArr)){
	                    echo '<div class="xnkl">
<div class="deng-box2">
  <div class="deng">
    <div class="xian"></div>
    <div class="deng-a">
      <div class="deng-b"><div class="deng-t">'.$itemZfyArr[1].'</div></div>
    </div>
    <div class="shui shui-a">
      <div class="shui-c"></div>
      <div class="shui-b"></div>
    </div>
  </div>
</div>
<div class="deng-box3">
  <div class="deng">
    <div class="xian"></div>
    <div class="deng-a">
      <div class="deng-b"><div class="deng-t">'.$itemZfyArr[0].'</div></div>
    </div>
    <div class="shui shui-a">
      <div class="shui-c"></div>
      <div class="shui-b"></div>
    </div>
  </div>
</div>
<div class="deng-box1">
  <div class="deng">
    <div class="xian"></div>
    <div class="deng-a">
      <div class="deng-b"><div class="deng-t">'.$itemZfyArr[3].'</div></div>
    </div>
    <div class="shui shui-a">
      <div class="shui-c"></div>
      <div class="shui-b"></div>
    </div>
  </div>
</div>
<div class="deng-box">
  <div class="deng">
    <div class="xian"></div>
    <div class="deng-a">
      <div class="deng-b"><div class="deng-t">'.$itemZfyArr[2].'</div></div>
    </div>
    <div class="shui shui-a">
      <div class="shui-c"></div>
      <div class="shui-b"></div>
    </div>
  </div>
</div>  
</div>
<style type="text/css">
@media screen and (max-width: 768px) {

.xnkl{

display:none; }

}
.deng-box {
        position: fixed;
        top: -40px;
        right: 150px;
        z-index: 9999;
        pointer-events: none;
}

.deng-box1 {
        position: fixed;
        top: -30px;
        right: 10px;
        z-index: 9999;
        pointer-events: none
}

.deng-box2 {
        position: fixed;
        top: -40px;
        left: 150px;
        z-index: 9999;
        pointer-events: none
}

.deng-box3 {
        position: fixed;
        top: -30px;
        left: 10px;
        z-index: 9999;
        pointer-events: none
}

.deng-box1 .deng,.deng-box3 .deng {
        position: relative;
        width: 120px;
        height: 90px;
        margin: 50px;
        background: #d8000f;
        background: rgba(216,0,15,.8);
        border-radius: 50% 50%;
        -webkit-transform-origin: 50% -100px;
        -webkit-animation: swing 5s infinite ease-in-out;
        box-shadow: -5px 5px 30px 4px #fc903d
}

.deng {
        position: relative;
        width: 120px;
        height: 90px;
        margin: 50px;
        background: #d8000f;
        background: rgba(216,0,15,.8);
        border-radius: 50% 50%;
        -webkit-transform-origin: 50% -100px;
        -webkit-animation: swing 3s infinite ease-in-out;
        box-shadow: -5px 5px 50px 4px #fa6c00
}

.deng-a {
        width: 100px;
        height: 90px;
        background: #d8000f;
        background: rgba(216,0,15,.1);
        margin: 12px 8px 8px 8px;
        border-radius: 50% 50%;
        border: 2px solid #dc8f03
}

.deng-b {
        width: 45px;
        height: 90px;
        background: #d8000f;
        background: rgba(216,0,15,.1);
        margin: -4px 8px 8px 26px;
        border-radius: 50% 50%;
        border: 2px solid #dc8f03
}

.xian {
        position: absolute;
        top: -20px;
        left: 60px;
        width: 2px;
        height: 20px;
        background: #dc8f03
}

.shui-a {
        position: relative;
        width: 5px;
        height: 20px;
        margin: -5px 0 0 59px;
        -webkit-animation: swing 4s infinite ease-in-out;
        -webkit-transform-origin: 50% -45px;
        background: orange;
        border-radius: 0 0 5px 5px
}

.shui-b {
        position: absolute;
        top: 14px;
        left: -2px;
        width: 10px;
        height: 10px;
        background: #dc8f03;
        border-radius: 50%
}

.shui-c {
        position: absolute;
        top: 18px;
        left: -2px;
        width: 10px;
        height: 35px;
        background: orange;
        border-radius: 0 0 0 5px
}

.deng:before {
        position: absolute;
        top: -7px;
        left: 29px;
        height: 12px;
        width: 60px;
        content: " ";
        display: block;
        z-index: 999;
        border-radius: 5px 5px 0 0;
        border: solid 1px #dc8f03;
        background: orange;
        background: linear-gradient(to right,#dc8f03,orange,#dc8f03,orange,#dc8f03)
}

.deng:after {
        position: absolute;
        bottom: -7px;
        left: 10px;
        height: 12px;
        width: 60px;
        content: " ";
        display: block;
        margin-left: 20px;
        border-radius: 0 0 5px 5px;
        border: solid 1px #dc8f03;
        background: orange;
        background: linear-gradient(to right,#dc8f03,orange,#dc8f03,orange,#dc8f03)
}

.deng-t {
        font-family: 黑体,Arial,Lucida Grande,Tahoma,sans-serif;
        font-size: 3.2rem;
        color: #dc8f03;
        font-weight: 700;
        line-height: 85px;
        text-align: center
}

.night .deng-box,.night .deng-box1,.night .deng-t {
        background: 0 0!important
}

@-moz-keyframes swing {
        0% {
                -moz-transform: rotate(-10deg)
        }

        50% {
                -moz-transform: rotate(10deg)
        }

        100% {
                -moz-transform: rotate(-10deg)
        }
}

@-webkit-keyframes swing {
        0% {
                -webkit-transform: rotate(-10deg)
        }

        50% {
                -webkit-transform: rotate(10deg)
        }

        100% {
                -webkit-transform: rotate(-10deg)
        }
}</style>';
	                }
	            }
	        }
	    }

    }

}