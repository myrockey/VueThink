<?php


/**
 * 获取小组背景图片
 */
function get_groupbg($bg_id)
{
    $info = model('Picture')->where(['id' => $bg_id])->field('path,url')->find();


    if ($info) {


        if (!empty($info['url']))  : return config('static_domain') . SYS_DSS . $info['url']; endif;

        if (!empty($info['path'])) : return WEB_PATH_PICTURE . $info['path']; endif;

    } else {
        return '__PUBLIC__/images/background_group.jpg';
    }


}

/**
 * 获取小组头像图片
 */
function get_groupavatar($cover_id)
{

    $info = model('Picture')->where(['id' => $cover_id])->field('path,url')->find();


    if ($info) {


        if (!empty($info['url']))  : return config('static_domain') . SYS_DSS . $info['url']; endif;

        if (!empty($info['path'])) : return WEB_PATH_PICTURE . $info['path']; endif;

    } else {
        return '__PUBLIC__/images/favicon.png';
    }

}

/**
 * 应用公共（函数）文件
 */
function defaultval($data, $val)
{

    if (!$data) {
        return $val;
    } else {
        return $data;
    }
}

function hasfocus($touid, $uid)
{

    $fs = model('zan')->where(['uid' => $touid, 'sid' => $uid, 'type' => 0])->count();

    $gz = model('zan')->where(['uid' => $uid, 'sid' => $touid, 'type' => 0])->count();

    if ($gz > 0) {
        //这个是我关注的人
        if ($fs > 0) {
            //这个是我的粉丝
            $hasfocus = 3;//好友
        } else {
            $hasfocus = 2;//关注

        }
    } else {
        if ($fs > 0) {
            //这个是我的粉丝
            $hasfocus = 1;//粉丝
        } else {
            //没有任何关系

        }


    }
    return $hasfocus;
}

function getxsstatusname($status, $cnid)
{

    if ($cnid > 0) {
        return '已采纳';
    } else {
        if ($status == 1) {
            return '正在悬赏';
        } else {
            return '已结束';
        }

    }

}

function strReplace($search, $replace, &$array)
{
    $array = str_replace($search, $replace, $array);

    if (is_array($array)) {
        foreach ($array as $key => $val) {


            if (is_array($val)) {
                strReplace($search, $replace, $array[$key]);
            }
        }
    }
}

function strkeyReplace($search, $replace, &$array)
{

    foreach ($array as $key => $val) {
        $arr = $val;
        unset($array[$key]);
        $key = str_replace($search, $replace, $key);
        $array[$key] = $arr;

    }

}

function getpingfen($number)
{
    $arr[0] = 0;
    $arr[1] = 0;
    $arr[2] = 0;
    $arr[3] = 0;
    $arr[4] = 0;

    if ($number == 0) {


    } else {
        $number = $number * 100;

        $z = $number / 50;
        $count = 1;
        for ($i = 0; $i < $z; $i++) {

            if ($count == 2) {
                $arr[$i / 2] = 2;
                $count = 1;
            } else {
                $arr[$i / 2] = 1;
                $count++;
            }


        }
    }


    return $arr;
}

function getipstr($ext, $filename)
{//获得预览代码，本地模式

    $path = PATH_UPLOAD . 'docview/Data/';


    $options = [
        // 缓存类型为File
        'type' => 'file',
        // 缓存有效期为永久有效
        'expire' => 0,
        // 指定缓存目录
        'path' => $path,
        'cache_subdir' => false,

    ];

    $ipstr = cache($filename, '', $options);

    if (empty($ipstr)) {

        $extarr = array('xls', 'xlsx', 'ppt', 'pptx', 'dps', 'et');


        if (in_array($ext, $extarr)) {

            $pngname = PATH_UPLOAD . 'docview/Data/' . $filename . '/01.png';
            $filepath = PATH_UPLOAD . 'docview/Data/' . $filename . '/';
            $fileurl = config('web_url') . 'uploads/docview/Data/' . $filename . '/';

            if (file_exists($pngname)) {//如果该文档存在,则取出字符串
                $opendir = opendir($filepath);
                $ipstr = "<!--[if IE]>  <html class='ie'> <![endif]--><link rel='stylesheet' type='text/css' href='__CSS__/docstyle.css' />";
                $count = 0;
                while ($file = readdir($opendir)) {


                    if (is_file($filepath . $file)) {
                        if (strpos($fileurl . $file, '.png')) {
                            $count++;
                            $ipstr .= "<div class=\"stl_01 mod reader-page complex reader-page-" . $count . "\"><img src='" . $fileurl . $file . "' /></div>";
                        }
                    }

                }//经过循环已经得到$ipstr代码了

                cache($filename, $ipstr, $options);

            } else {

                //如果没有该文件则显示未生成预览
                $ipstr = "<div class=\"stl_01 mod reader-page complex reader-page-\"><div style=\"height:300px;font-size:30px;color:red;padding-top:150px;font-weight:bolder;text-align:center;\">该文档尚未生成预览</div></div>";

            }


        } else {

            $htmlname = PATH_UPLOAD . 'docview/Data/' . $filename . '.html';

            if (file_exists($htmlname)) {//如果该文档存在,则取出字符串


                $ipstr = file_get_contents(config('web_url') . 'uploads/docview/Data/' . $filename . '.html');
                $ipstr = str_replace("<!DOCTYPE html>", '', $ipstr);
                $ipstr = str_replace("<html>", '', $ipstr);
                $ipstr = str_replace("</html>", '', $ipstr);
                $ipstr = str_replace("<meta charset=\"utf-8\" />", '', $ipstr);
                $ipstr = str_replace("<title>", '', $ipstr);
                $ipstr = str_replace("</title>", '', $ipstr);
                $ipstr = str_replace("<head>", '', $ipstr);
                $ipstr = str_replace("</head>", '', $ipstr);
                $ipstr = str_replace("<body>", '', $ipstr);
                $ipstr = str_replace("</body>", '', $ipstr);
                $ipstr = str_replace($filename . '_files', config('web_url') . 'uploads/docview/Data/' . $filename . '_files', $ipstr);
                $ipstr = str_replace('stl_01', 'stl_01 mod reader-page complex reader-page-', $ipstr);
                $realstrcount = substr_count($ipstr, 'stl_01');
                for ($i = 1; $i <= $realstrcount; $i++) {

                    if (strpos($ipstr, 'reader-page')) {

                        $ipstr = preg_replace('/reader-page complex reader-page-/', 'reader-page' . $i . ' complex reader-page-' . $i, $ipstr, 1);

                    }


                }


                //得到ipstr


                cache($filename, $ipstr, $options);


            } else {


                //如果没有该文件则显示未生成预览
                $ipstr = "<div class=\"stl_01 mod reader-page complex reader-page-\"><div style=\"height:300px;font-size:30px;color:red;padding-top:150px;font-weight:bolder;text-align:center;\">该文档尚未生成预览</div></div>";
            }
        }


    }
    return $ipstr;


}

function getnavactive($link)
{


    //"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $mm = strtolower(trim(substr($link, 0, strrpos($link, '.'))));
    $local = $_SERVER['REQUEST_URI'];

    if ($local == getbaseurl()) {
        $local = url('index/index');
    }
    $local = strtolower($local);
    if (strpos($local, $mm) === false) {

        return false;

    } else {
        return true;
    }


}

/**
 * 发送HTTP请求方法
 * @param  string $url 请求URL
 * @param  array $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function http_curl($url, $params, $method = 'GET', $header = array(), $multi = false)
{


    $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) throw new Exception('请求发生错误：' . $error);
    return $data;
}

function point_controll($uid, $controllname, $id = 0)
{

    $info = model('point_rule')->where(['controller' => $controllname])->select();
    if ($info) {
        foreach ($info as $k => $v) {

            if ($v['type'] == 1) {
                //只有增加的才有次数的限制
                $where['uid'] = $uid;
                $where['controller'] = $controllname;
                $where['type'] = 1;
                $where['scoretype'] = $v['scoretype'];

                $where['create_time'] = array('gt', time() - 24 * 60 * 60);
                $count = model('point_note')->where($where)->count();

            } else {
                $count = 0;
            }
            if ($count < $v['num'] || $v['num'] == 0) {
                point_change($uid, $v['scoretype'], $v['score'], $v['type'], $controllname, $id, 0);
            }

        }


    }

}

function roll_point_controll($uid, $controllname, $id = 0)
{
    $info = model('point_rule')->where(['controller' => $controllname])->select();
    if ($info) {


        foreach ($info as $k => $v) {

            if ($v['type'] == 2) {
                $type = 1;

            } else {
                $type = 2;

            }

            point_change($uid, $v['scoretype'], $v['score'], $type, $controllname, $id, 0);
        }

    }

}

function formatnumber($hits)
{
    $b = 1000;
    $c = 10000;
    if ($hits > $b) {
        if ($hits < $c) {

            $hits = floor($hits / $b) . '千';
        } else {

            $hits = (floor(($hits / $c) * 10) / 10) . '万';
        }
    } else {

    }
    return $hits;
}

function usercz($uid, $did, $type = 2, $cid = 1)
{

    $data['uid'] = $uid;
    $data['did'] = $did;
    $data['create_time'] = time();
    $data['type'] = $type;
    $data['cid'] = $cid;

    if ($cid == 3 && $type == 2 && $uid == $did) {
        return;
    } else {
        model('usercz')->insert($data);
    }


}

function point_change($uid, $scoretype, $score, $type, $controllname, $id = 0, $infouid = 0)
{

    //无操作名的话是正常扣分和加分，

    if ($type == 1) {
        model('user')->where(['id' => $uid])->setInc($scoretype, $score);


    } else {
        model('user')->where(['id' => $uid])->setDec($scoretype, $score);
    }
    $data['uid'] = $uid;
    $data['itemid'] = $id;
    $data['controller'] = $controllname;
    $data['type'] = $type;
    $data['score'] = $score;
    $data['scoretype'] = $scoretype;
    $data['infouid'] = $infouid;
    $data['create_time'] = time();

    model('point_note')->insert($data);

}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{


    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    //截取内容时去掉图片，仅保留文字
    $strlen = mb_strlen($str, 'utf-8');
    if ($strlen < $length) {
        $suffix = false;
    }
    return $suffix ? $slice . '...' : $slice;
}

function clearcontent($content)
{

    $content = htmlspecialchars_decode($content);


    $content = preg_replace("/&lt;/i", "<", $content);


    $content = preg_replace("/&gt;/i", ">", $content);

    $content = preg_replace("/&amp;/i", "&", $content);


    $content = strip_tags($content);
    return $content;
}


function clearHtml($content)
{
    $content = preg_replace('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', "", $content);
    $content = preg_replace("/<a[^>]*>/i", "", $content);
    $content = preg_replace("/<\/a>/i", "", $content);
    $content = preg_replace("/<p>/i", "", $content);
    $content = preg_replace("/<\/p>/i", "", $content);
    $content = preg_replace("/<div[^>]*>/i", "", $content);
    $content = preg_replace("/<\/div>/i", "", $content);
    $content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容
    $content = preg_replace("/style=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/class=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/id=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/lang=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/width=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/height=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/border=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/face=.+?['|\"]/i", '', $content);//去除样式
    $content = preg_replace("/face=.+?['|\"]/", '', $content);//去除样式 只允许小写 正则匹配没有带 i 参数
    return $content;
}

function cutstr_html($string, $length = 0, $ellipsis = '…')
{

    $string = strip_tags($string);
    $string = preg_replace("/\n/is", '', $string);
    $string = preg_replace("/\r\n/is", '', $string);

    $string = preg_replace('/ |　/is', '', $string);
    $string = preg_replace('/&nbsp;/is', '', $string);
    $string = preg_replace('/&emsp;/is', '', $string);

    if (mb_strlen($string, 'utf-8') <= $length) {
        $ellipsis = '';
    }
    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $string);
    if (is_array($string) && !empty($string[0])) {
        if (is_numeric($length) && $length) {


            $string = join('', array_slice($string[0], 0, $length)) . $ellipsis;
        } else {
            $string = implode('', $string[0]);
        }
    } else {
        $string = '';
    }
    return $string;
}

/**
 * 解密函数
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = '', $ttl = 0)
{
    if (empty($txt)) return $txt;
    if (empty($key)) {
        $salt = model('user')->where('id', 1)->value('salt');
        $key = md5($salt);
    }
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum = 0;
    $i = 0;
    $tlen = @strlen($txt);
    while (isset($key{$i})) $knum += ord($key{$i++});
    $ch1 = @$txt{$knum % $tlen};
    $nh1 = strpos($chars, $ch1);
    $txt = @substr_replace($txt, '', $knum % $tlen--, 1);
    $ch2 = @$txt{$nh1 % $tlen};
    $nh2 = @strpos($chars, $ch2);
    $txt = @substr_replace($txt, '', $nh1 % $tlen--, 1);
    $ch3 = @$txt{$nh2 % $tlen};
    $nh3 = @strpos($chars, $ch3);
    $txt = @substr_replace($txt, '', $nh2 % $tlen--, 1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = @strlen($txt);
    $klen = @strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
        while ($j < 0) $j += 64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(array('-', '_', '.'), array('+', '/', '='), $tmp);
    $tmp = trim(base64_decode($tmp));
    if (preg_match("/\d{10}_/s", substr($tmp, 0, 11))) {
        if ($ttl > 0 && (time() - substr($tmp, 0, 11) > $ttl)) {
            $tmp = null;
        } else {
            $tmp = substr($tmp, 11);
        }
    }
    return $tmp;
}

/**
 * 加密函数
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypt($txt, $key = '')
{
    if (empty($txt)) return $txt;
    if (empty($key)) {
        $salt = model('user')->where('id', 1)->value('salt');
        $key = md5($salt);
    }
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $nh1 = rand(0, 64);
    $nh2 = rand(0, 64);
    $nh3 = rand(0, 64);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};
    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;
    $i = 0;
    while (isset($key{$i})) $knum += ord($key{$i++});
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $txt = base64_encode(time() . '_' . $txt);
    $txt = str_replace(array('+', '/', '='), array('-', '_', '.'), $txt);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum + strpos($chars, $txt{$i}) + ord($mdKey{$k++})) % 64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp, $ch3, $nh2 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch2, $nh1 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch1, $knum % ++$tmplen, 0);
    return $tmp;
}

function systemSetKey($user = '')
{

    if (is_array($user) && !empty($user)) {

        cookie('sys_key', encrypt(serialize($user)), 3600);

    }
}

function lefttime($sTime)
{

    if (!$sTime)
        return '';
    $cTime = time();
    $dTime = $cTime - $sTime;
    $dDay = intval(date("z", $cTime)) - intval(date("z", $sTime));

    return $dDay;

}

function sendsysmess($content, $uid, $touid, $type)
{

    $data['update_time'] = time();
    $data['create_time'] = time();
    $data['uid'] = $uid;
    $data['touid'] = $touid;
    $data['type'] = $type;
    $data['content'] = $content;

    model('message')->insert($data);


}

function friendlyDate($sTime, $type = 'normal', $alt = 'false')
{
    if (!$sTime)
        return '';
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime = time();
    $dTime = $cTime - $sTime;
    $dDay = intval(date("z", $cTime)) - intval(date("z", $sTime));
    //$dDay     =   intval($dTime/3600/24);
    $dYear = intval(date("Y", $cTime)) - intval(date("Y", $sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if ($type == 'normal') {
        if ($dTime < 60) {
            if ($dTime < 10) {
                return '刚刚';    //by yangjs
            } else {
                return intval(floor($dTime / 10) * 10) . "秒前";
            }
        } elseif ($dTime < 3600) {
            return intval($dTime / 60) . "分钟前";
            //今天的数据.年份相同.日期相同.
        } elseif ($dYear == 0 && $dDay == 0) {
            //return intval($dTime/3600)."小时前";
            return '今天' . date('H:i', $sTime);
        } elseif ($dYear == 0) {
            return date("m月d日 H:i", $sTime);
        } else {
            return date("Y-m-d", $sTime);
        }
    } elseif ($type == 'mohu') {
        if ($dTime < 60) {
            return $dTime . "秒前";
        } elseif ($dTime < 3600) {
            return intval($dTime / 60) . "分钟前";
        } elseif ($dTime >= 3600 && $dDay == 0) {
            return intval($dTime / 3600) . "小时前";
        } elseif ($dDay > 0 && $dDay <= 7) {
            return intval($dDay) . "天前";
        } elseif ($dDay > 7 && $dDay <= 30) {
            return intval($dDay / 7) . '周前';
        } elseif ($dDay > 30) {
            return intval($dDay / 30) . '个月前';
        }
        //full: Y-m-d , H:i:s
    } elseif ($type == 'full') {
        return date("Y-m-d , H:i:s", $sTime);
    } elseif ($type == 'ymd') {
        return date("Y-m-d", $sTime);
    } else {
        if ($dTime < 60) {
            return $dTime . "秒前";
        } elseif ($dTime < 3600) {
            return intval($dTime / 60) . "分钟前";
        } elseif ($dTime >= 3600 && $dDay == 0) {
            return intval($dTime / 3600) . "小时前";
        } elseif ($dYear == 0) {
            return date("Y-m-d H:i:s", $sTime);
        } else {
            return date("Y-m-d H:i:s", $sTime);
        }
    }
}

function getusernamebyid($uid)
{
    if ($uid == 0) {
        return '所有人';
    } else {
        $children = model('user')->where(['id' => $uid])->find();

        return $children['nickname'];


    }


}

function getheadurlbyid($uid)
{

    $children = model('user')->where(['id' => $uid])->find();

    if (preg_match("/^(http:\/\/|https:\/\/).*$/", $children['userhead'])) {
        return $head;
    } else {
        return 'http://' . $_SERVER['HTTP_HOST'] . getbaseurl() . $children['userhead'];
    }
}

function getxsnamebyid($id)
{

    $info = model('docxs')->where(['id' => $id])->find();

    return $info['name'];

}

function getgroupcatenamebyid($id)
{

    $info = model('groupcate')->where(['id' => $id])->find();

    return $info['name'];


}

function getdoccatenamebyid($id)
{

    $info = model('doccate')->where(['id' => $id])->find();

    return $info['name'];


}

function getusergrade($gradeid, $uid = 0)
{


    if ($gradeid == -1) {
        $name = '认证会员';
    } else {

        if ($uid == 0) {
            $name = model('usergrade')->where(['id' => $gradeid])->value('name');

            if (empty($name)) {
                $name = '普通会员';
            }


        } else {

            $info = model('user')->where('id', $uid)->find();

            $map['score'] = array('elt', $info['expoint1']);

            $res = model('usergrade')->where($map)->order('score desc')->limit(1)->value('id');


            if (!empty($res) && $res != $info['grades']) {
                model('user')->where('id', $uid)->setField('grades', $res);

            }
            $name = model('usergrade')->where('id', $res)->value('name');
            if (empty($name)) {
                $name = '普通会员';
            }


        }
    }


    return $name;
}

//用于生成用户密码的随机字符
function generate_password($length = 8)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

function generate_code($uid, $length = 6, $time = 3600)
{
    $min = pow(10, ($length - 1));
    $max = pow(10, $length) - 1;

    $code = rand($min, $max);

    cache('moblecode' . $uid, $code, $time);

    return $code;
}

function verifycode($code, $uid)
{

    if ($code == cache('moblecode' . $uid)) {
        return true;
    } else {
        return false;
    }

}

function getheadurl($head)
{
    if (preg_match("/^(http:\/\/|https:\/\/).*$/", $head)) {
        return $head;
    } else {
        return 'http://' . $_SERVER['HTTP_HOST'] . getbaseurl() . $head;
    }
}

/**
 * 获取图片url
 */
function get_picture_url($id = 0)
{

    $info = model('Picture')->where(['id' => $id])->field('path,url')->find();

    if (!empty($info['url']))  : return config('static_domain') . SYS_DSS . $info['url']; endif;


    if (!empty($info['path'])) : return WEB_PATH_PICTURE . $info['path']; endif;

    return '__PUBLIC__/images/onimg.png';
}

/**
 * 获取文件url
 */
function get_file_url($id = 0)
{

    $info = model('File')->where(['id' => $id])->field('savepath,url')->find();

    if (!empty($info['url']))  : return config('static_domain') . SYS_DSS . $info['url']; endif;

    if (!empty($info['savepath'])) : return WEB_PATH_FILE . $info['savepath']; endif;

    return 'file is not exist';
}

function getfileurl_jd($fileid, $type)
{
    $path = '';
    if ($type == 1) {
        $path = PATH_PICTURE;
        $model = model('picture');
        $info = $model->where(['id' => $fileid])->find();
        //if(!empty($info['url'])){
        //$path=$info['url'];
        //}else{
        $path = $path . $info['path'];
        //}

    } else {
        $path = PATH_FILE;
        $model = model('file');
        $info = $model->where(['id' => $fileid])->find();
        //if(!empty($info['url'])){
        //$path=$info['url'];
        //}else{
        $path = $path . $info['savepath'];
        //}
    }

    return $path;


}

function getbaseurl()
{
    $baseUrl = str_replace('\\', '', dirname($_SERVER['SCRIPT_NAME']));
    $baseUrl = empty($baseUrl) ? '/' : '/' . trim($baseUrl, '/') . '/';
    return $baseUrl;
}

function format_bytes($size, $delimiter = '')
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= 1024 && $i < 6; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/*
 * 来判断导航链接内部外部从而生成新链接
 * 
 * 
 * */
function getnavlink($link, $sid)
{
    if ($sid == 1) {

        $arr = explode(',', $link);

        $url = $arr[0];

        array_shift($arr);
        if (empty($arr)) {

            $link = routerurl($url);

        } else {
            $m = 1;
            $queue = array();
            foreach ($arr as $k => $v) {

                if ($m == 1) {
                    $n = $v;
                    $m = 2;

                } else {
                    $b = $v;
                    $queue[$n] = $b;
                    $m = 1;
                }
            }
            if (empty($queue)) {
                $link = routerurl($url);
            } else {
                $link = routerurl($url, $queue);
            }


        }


    }

    return $link;
}

function routerurl($url, $arr = array())
{
    if (empty($arr)) {
        $str = url($url);
    } else {
        $str = url($url, $arr);
    }


    $str = str_replace('admin.php', 'index.php', $str);

    return $str;
}

//获取图片
function getcontentimage($content)
{
    preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $content, $images);
    if ($images) {
        return $images;
    } else {
        return '';
    }

}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name)
{
    $result = false;
    if (is_dir($dir_name)) {
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login()
{

    $member = session('member_auth');

    if (empty($member)) {
        $action = request()->action();
        $array = ['login','logout','register','continuetopay','wxlogin','callback','notify'];
        if(!in_array($action,$array)){
            $lasturl = urlencode(htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
            session('lasturl',$lasturl);
        }
        return DATA_DISABLE;
    } else {
        if (MODULE_NAME == 'admin') {
            $memberinfo = session('member_info');

            if (!$memberinfo['is_inside']) {
                return DATA_DISABLE;
            } else {
                return $member['member_id'];
            }

        } else {
            if(session('member_auth_sign') == data_auth_sign($member)){
                return $member['member_id'];
            }else{
                $action = request()->action();
                $array = ['login','logout','register','continuetopay','wxlogin','callback','notify'];
                if(!in_array($action,$array)){
                    $lasturl = urlencode(htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
                    session('lasturl',$lasturl);
                }
                return DATA_DISABLE;
            }
//            return session('member_auth_sign') == data_auth_sign($member) ? $member['member_id'] : DATA_DISABLE;
        }

    }
}

/**
 * 检测用户是否会员
 * @return integer 0-不是会员，大于0-当前登录用户ID
 */
function is_vip()
{
    if (!is_login()) return 0;

    $memberinfo = session('member_info');
    //放开工作账号id：1,2,60,63,64,68,78以及这几个待过期后，关闭的id ：71,73,74,99
    if(in_array($memberinfo['id'],array(1,2,60,63,64,68,78,71,73,74,99))){
        return $memberinfo['id'];
    }
    return ($memberinfo['is_vip'] && ($memberinfo['vip_expire_time'] > time())) ? $memberinfo['id'] : 0;
}

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 */
function data_md5($str, $key = 'OneBase')
{

    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 数据签名认证
 * @param  array $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data)
{

    // 数据类型检测
    if (!is_array($data)) : $data = (array)$data; endif;

    // 排序
    ksort($data);

    // url编码并生成query字符串
    $code = http_build_query($data);

    // 生成签名
    $sign = sha1($code);

    return $sign;
}

/**
 * 检测当前用户是否为管理员
 * @return boolean true-管理员，false-非管理员
 */
function is_administrator($member_id = null)
{

    $return_id = is_null($member_id) ? is_login() : $member_id;

    return $return_id && (intval($return_id) === SYS_ADMINISTRATOR_ID);
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{

    // 创建Tree
    $tree = [];

    if (!is_array($list)):
        return false;
    endif;

    // 创建基于主键的数组引用
    $refer = [];

    foreach ($list as $key => $data) {

        $refer[$data[$pk]] =& $list[$key];
    }

    foreach ($list as $key => $data) {

        // 判断是否存在parent
        $parentId = $data[$pid];

        if ($root == $parentId) {

            $tree[] =& $list[$key];

        } else if (isset($refer[$parentId])) {

            is_object($refer[$parentId]) && $refer[$parentId] = $refer[$parentId]->toArray();

            $parent =& $refer[$parentId];

            $parent[$child][] =& $list[$key];
        }
    }

    return $tree;
}

/**
 * 分析数组及枚举类型配置值 格式 a:名称1,b:名称2
 * @return array
 */
function parse_config_attr($string)
{

    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));

    if (strpos($string, ':')) {

        $value = [];

        foreach ($array as $val) {

            list($k, $v) = explode(':', $val);

            $value[$k] = $v;
        }

    } else {

        $value = $array;
    }

    return $value;
}

/**
 * 解析数组配置
 */
function parse_config_array($name = '')
{

    return parse_config_attr(config($name));
}

/**
 * 获取单例对象
 */
function get_sington_object($object_name = '', $class = null)
{

    $request = \think\Request::instance();

    $request->__isset($object_name) ?: $request->bind($object_name, new $class());

    return $request->__get($object_name);
}

/**
 * 将二维数组数组按某个键提取出来组成新的索引数组
 */
function array_extract($array = [], $key = 'id')
{

    $count = count($array);

    $new_arr = [];

    for ($i = 0; $i < $count; $i++) {

        if (!empty($array) && !empty($array[$i][$key])) {

            $new_arr[] = $array[$i][$key];
        }
    }

    return $new_arr;
}

/**
 * 根据某个字段获取关联数组
 */
function array_extract_map($array = [], $key = 'id')
{


    $count = count($array);

    $new_arr = [];

    for ($i = 0; $i < $count; $i++) {

        $new_arr[$array[$i][$key]] = $array[$i];
    }

    return $new_arr;
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str 要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
function str2arr($str, $glue = ',')
{

    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array $arr 要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
function arr2str($arr, $glue = ',')
{

    return implode($glue, $arr);
}

/**
 * 获取目录下所有文件
 */
function file_list($path = '')
{

    $file = scandir($path);

    foreach ($file as $k => $v) {

        if (is_dir($path . SYS_DSS . $v)) : unset($file[$k]); endif;
    }

    return array_values($file);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name = '')
{

    $lower_name = strtolower($name);

    $class = SYS_ADDON_DIR_NAME . "\\{$lower_name}\\{$name}";

    return $class;
}

/**
 * 钩子
 */
function hook($tag = '', $params = [])
{

    \think\Hook::listen($tag, $params);
}

/**
 * 保存文件
 */
function sf($arr = [], $fpath = 'D:\test.php')
{

    $data = "<?php\nreturn " . var_export($arr, true) . ";\n?>";

    file_put_contents($fpath, $data);
}

/**
 * 获取插件的模型名
 * @param strng $name 插件名
 * * @param strng $model 模型名
 */
function get_addon_model($name, $model)
{
    $name = strtolower($name);
    $model = strtolower($model);
    $class = "addon\\{$name}\model\\{$model}";
    return $class;
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array())
{

    $parse_url = parse_url($url);
    $addons = $parse_url['scheme'];
    $controller = $parse_url['host'];
    $action = $parse_url['path'];

    /* 基础参数 */
    $params_array = array(
        'addon_name' => $addons,
        'controller_name' => $controller,
        'action_name' => substr($action, 1),
    );

    $params = array_merge($params_array, $param); //添加额外参数

    return url('addon/execute', $params);
}

/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type = 0)
{

    if ($type) {

        return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
            return strtoupper($match[1]);
        }, $name));
    } else {

        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}

/**
 * 获取目录列表
 */
function get_dir($dir_name)
{

    $dir_array = [];

    if (false != ($handle = opendir($dir_name))) {

        $i = 0;

        while (false !== ($file = readdir($handle))) {

            if ($file != "." && $file != ".." && !strpos($file, ".")) {

                $dir_array[$i] = $file;

                $i++;
            }
        }

        closedir($handle);
    }

    return $dir_array;
}


/**
 * 导出excel信息
 * @param string $titles 导出的表格标题
 * @param string $keys 需要导出的键名
 * @param array $data 需要导出的数据
 * @param string $file_name 导出的文件名称
 */
function export_excel($titles = '', $keys = '', $data = [], $file_name = '导出文件')
{

    $objPHPExcel = get_excel_obj($file_name);

    $y = 1;
    $s = 0;

    $titles_arr = str2arr($titles);

    foreach ($titles_arr as $k => $v) : $objPHPExcel->setActiveSheetIndex($s)->setCellValue(string_from_column_index($k) . $y, $v); endforeach;

    $keys_arr = str2arr($keys);

    foreach ($data as $k => $v) {

        is_object($v) && $v = $v->toArray();

        foreach ($v as $kk => $vv) {

            $num = array_search($kk, $keys_arr);

            false !== $num && $objPHPExcel->setActiveSheetIndex($s)->setCellValue(string_from_column_index($num) . ($y + $k + 1), $vv);
        }
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    $objWriter->save('php://output');
    exit;
}


/**
 * 获取excel
 */
function get_excel_obj($file_name = '导出文件')
{

    set_time_limit(0);

    vendor('phpoffice/phpexcel/Classes/PHPExcel');

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header('Content-Disposition:attachment;filename=' . iconv("utf-8", "gb2312", $file_name) . '.xlsx');
    header("Content-Transfer-Encoding:binary");

    return new PHPExcel();
}

/**
 * 数字转字母
 */
function string_from_column_index($pColumnIndex = 0)
{
    static $_indexCache = [];

    if (!isset($_indexCache[$pColumnIndex])) {

        if ($pColumnIndex < 26) {

            $_indexCache[$pColumnIndex] = chr(65 + $pColumnIndex);
        } elseif ($pColumnIndex < 702) {

            $_indexCache[$pColumnIndex] = chr(64 + ($pColumnIndex / 26)) . chr(65 + $pColumnIndex % 26);
        } else {

            $_indexCache[$pColumnIndex] = chr(64 + (($pColumnIndex - 26) / 676)) . chr(65 + ((($pColumnIndex - 26) % 676) / 26)) . chr(65 + $pColumnIndex % 26);
        }
    }

    return $_indexCache[$pColumnIndex];
}

function asyn_sendmail($data)
{
    $domain = $_SERVER['HTTP_HOST'];

    $url = getbaseurl() . 'index.php/Index/send_mail';


    http_curl($url, $data, 'POST');


}

/**
 * 发送邮件
 */
function send_email($address, $title, $message)
{
    /*
     * 邮件发送类
     * 支持发送纯文本邮件和HTML格式的邮件，可以多收件人，多抄送，多秘密抄送，带附件(单个或多个附件),支持到服务器的ssl连接
     * 需要的php扩展：sockets、Fileinfo和openssl。
     * 编码格式是UTF-8，传输编码格式是base64
     * @example
     *  */
    $mail = new \es\sendmail();
    //  $mail->setServer("SMTP.QQ.com", "49007623@qq.com", "5150161**"); //设置smtp服务器，普通连接方式
    $mail->setServer(config('mailserver'), config('mailusername'), config('mailpassword'), config('mailport'), true); //设置smtp服务器，到服务器的SSL连接
    $mail->setFrom(config('mailusername')); //设置发件人
    $mail->setFromname(config('mailname')); //设置发件人
    $mail->setReceiver($address); //设置收件人，多个收件人，调用多次
    //	 $mail->setCc("XXXX"); //设置抄送，多个抄送，调用多次
    //	 $mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
    //	 $mail->addAttachment( array("XXXX","xxxxx") ); //添加附件，多个附件，可调用多次，第一个文件名是 程序要去抓的文件名，第二个文件名是显示在邮件中的文件名。
    $mail->setMail($title, html_entity_decode($message)); //设置邮件主题、内容


    $mail->sendMail(); //发送


    return $mail->error();
}

/**
 * 获取星期方法
 * @param $date 2019-04-01
 * @return mixed
 */
function get_week($date, $exp = '-')
{
    //强制转换日期格式
    $date_str = date('Y-m-d', strtotime($date));
    //封装成数组
    $arr = explode($exp, $date_str);
    //参数赋值
    //年
    $year = $arr[0];
    //月，输出2位整型，不够2位右对齐
    $month = sprintf('%02d', $arr[1]);
    //日，输出2位整型，不够2位右对齐
    $day = sprintf('%02d', $arr[2]);
    //时分秒默认赋值为0；
    $hour = $minute = $second = 0;
    //转换成时间戳
    $strap = mktime($hour, $minute, $second, $month, $day, $year);
    //获取数字型星期几
    $number_wk = date("w", $strap);
    //自定义星期数组
    $weekArr = array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
    //获取数字对应的星期
    return $weekArr[$number_wk];
}

/**
 * 获取单个股票数组
 * @param str
 * @return 返回 array(array('股票名称','买入价','卖出价','涨幅'),...);
 */
function get_shares_item_arr($str, $exp = ';')
{
    if (empty($str)) return false;
    $str = trim($str, $exp);
    $arr = explode($exp, $str);
    if (!empty($arr)) {
        $newArr = array();
        foreach ($arr as $k => $val) {
            $newArr[$k] = explode('|', $val);
        }
        return $newArr;
    }

    return false;
}

/**
 * 生成二维码图片（可生成带logo的二维码）
 *
 * @param string $data 二维码内容
 *         示例数据：http://www.tf4.cn或weixin://wxpay/bizpayurl?pr=0tELnh9
 * @param string $saveDir 保存路径名（示例:Qrcode）
 * @param string $logo 图片logo路径
 *         示例数据：./Public/Default/logo.jpg
 *         注意事项：1、前面记得带点（.）；2、建议图片Logo正方形，且为jpg格式图片；3、图片大小建议为xx*xx
 *
 * 注意：一般用于生成带logo的二维码
 *
 * @return
 */
function createQrcode($data, $saveDir = "Qrcode", $logo = "", $matrixPointSize = 20)
{
    $rootPath = PATH_PUBLIC;
    $path = $saveDir . '/' . date("Y-m-d") . '/';
    $fileName = uniqid();
    if (!is_dir($rootPath . $path)) {
        mkdir($rootPath . $path, 0777, true);
    }
    $originalUrl = $path . $fileName . '.png';

    Vendor('phpqrcode/phpqrcode');
    $object = new \QRcode();
    $errorCorrectionLevel = 'L';    //容错级别
//	$matrixPointSize = 20;            //生成图片大小（这个值可以通过参数传进来判断）
    $object->png($data, $rootPath . $originalUrl, $errorCorrectionLevel, $matrixPointSize, 2);

    //判断是否生成带logo的二维码
    if (file_exists($logo)) {
        $QR = imagecreatefromstring(file_get_contents($rootPath . $originalUrl));        //目标图象连接资源。
        $logo = imagecreatefromstring(file_get_contents($logo));    //源图象连接资源。
        if (imageistruecolor($logo)) {
            imagetruecolortopalette($logo, false, 65535);//添加这行代码来解决颜色失真问题
        }
        $QR_width = imagesx($QR);            //二维码图片宽度
        $QR_height = imagesy($QR);            //二维码图片高度
        $logo_width = imagesx($logo);        //logo图片宽度
        $logo_height = imagesy($logo);        //logo图片高度
        $logo_qr_width = $QR_width / 4;       //组合之后logo的宽度(占二维码的1/5)
        $scale = $logo_width / $logo_qr_width;       //logo的宽度缩放比(本身宽度/组合后的宽度)
        $logo_qr_height = $logo_height / $scale;  //组合之后logo的高度
        $from_width = ($QR_width - $logo_qr_width) / 2;   //组合之后logo左上角所在坐标点

        //重新组合图片并调整大小
        //imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        //输出图片
        imagepng($QR, $rootPath . $originalUrl);
        imagedestroy($QR);
        imagedestroy($logo);
    }

    $result['errcode'] = 0;
    $result['errmsg'] = 'ok';
    $result['data'] = $originalUrl;
    return $result;

}

/**
 * 生成临时二维码图片
 * 这里返回的是base64进制图片
 * 一般用于微信扫码支付二维码生成场景
 *
 * @param string $data 二维码内容
 *         示例数据：http://www.tf4.cn或weixin://wxpay/bizpayurl?pr=0tELnh9
 *
 * @return
 */
function createTempQrcode($data)
{
    Vendor('phpqrcode.phpqrcode');
    $object = new \QRcode();
    $errorCorrectionLevel = 'L';    //容错级别
    $matrixPointSize = 5;            //生成图片大小

    //打开缓冲区
    ob_start();
    //生成二维码图片
    $returnData = $object->png($data, false, $errorCorrectionLevel, $matrixPointSize, 2);
    //这里就是把生成的图片流从缓冲区保存到内存对象上，使用base64_encode变成编码字符串，通过json返回给页面。
    $imageString = base64_encode(ob_get_contents());
    //关闭缓冲区
    ob_end_clean();
    $base64 = "data:image/png;base64," . $imageString;

    $result['errcode'] = 0;
    $result['errmsg'] = 'ok';
    $result['data'] = $base64;
    return $result;
}

/**
 * 生成邀请码
 * @param $user_id
 * @return string
 */
function createRecommendCode($user_id)
{
    static $source_string = 'LYZFE5CDG3HQA4B1NOPIJ2RSTUV67MWX89K';
    $num = $user_id;
    $code = '';
    while ($num > 0) {
        $mod = $num % 35;
        $num = ($num - $mod) / 35;
        $code = $source_string[$mod] . $code;
    }
    if (empty($code[3]))
        $code = str_pad($code, 5, '0', STR_PAD_LEFT);
    return $code;
}

/**
 * 根据邀请码，逆向获取推荐人的userid
 * @param $code
 * @return bool|int
 */
function deRecommendCode($code)
{
    static $source_string = 'LYZFE5CDG3HQA4B1NOPIJ2RSTUV67MWX89K';
    if (strrpos($code, '0') !== false)
        $code = substr($code, strrpos($code, '0') + 1);
    $len = strlen($code);
    $code = strrev($code);
    $num = 0;
    for ($i = 0; $i < $len; $i++) {
        $num += strpos($source_string, $code[$i]) * pow(35, $i);
    }
    return $num;
}

/**
 * 微信支付
 * @param string $openId openid
 * @param string $goods 商品名称
 * @param string $attach 附加参数,我们可以选择传递一个参数,比如订单ID
 * @param string $order_sn 订单号
 * @param string $total_fee 金额
 */
function wxpay($openId, $goods, $order_sn, $total_fee, $attach)
{
    require_once ROOT_PATH . "api/wxpay/lib/WxPay.Api.php";
    require_once ROOT_PATH . "api/wxpay/example/WxPay.JsApiPay.php";
    require_once ROOT_PATH . "api/wxpay/example/WxPay.Config.php";
    require_once ROOT_PATH . 'api/wxpay/example/log.php';

////初始化日志
//    $logHandler = new CLogFileHandler(ROOT_PATH . "api/wxpay/logs/" . date('Y-m-d') . '.log');
//    $log = Log::Init($logHandler, 15);
//
////①、获取用户openid
//    try {

        $tools = new JsApiPay();
        if (empty($openId)) $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($goods);
        $input->SetAttach($attach);
        $input->SetOut_trade_no($order_sn);
        $input->SetTotal_fee($total_fee*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://vip.rimount.com/payment.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $config = new WxPayConfig();
        $order = WxPayApi::unifiedOrder($config, $input);
        $jsApiParameters = $tools->GetJsApiParameters($order);

        return $jsApiParameters;

//    } catch (Exception $e) {
//        Log::ERROR(json_encode($e));
//    }
//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php

}

/**
 * 获取会员等级名称
 * @param $data
 * @return mixed
 */
function getMemberGrade($data)
{
    //普通游客；体验会员是7天免费体验；研习会员是2周体验；高级会员是3个月或一年。
    $status = ['普通游客','体验会员', '研习会员', '高级会员','管理员'];
    return $status[$data];
 /*   if(!$data['leader_id']){
        $key = 0;
    }else{
        $array = model('Pay')->where(['userid' => $data['id']])->column('member_goodsid');
        if(!$array){
            $key = 1;
        }else{
            $count = count($array);
            if(in_array(1,$array) && ($count==1)){
                $key = 2;
            }else{
                $key = 3;
            }
        }
    }

    return $status[$key];*/

}

/**
 * 获取域名  例如：http://www.rimount.com
 * //保证域名配置，前台是www开头 例如：www.rimount.com，后台是admin开头 例如：admin.rimount.com
 */
function getDomain(){
    $domain = preg_replace('/www/i','admin',$_SERVER['HTTP_HOST']);
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .'://'.$domain;
}