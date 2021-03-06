<?php
// +----------------------------------------------------------------------
// | Author: Zaker <49007623@qq.com>
// +----------------------------------------------------------------------

namespace addon\region;

use app\common\controller\AddonBase;
use addon\AddonInterface;

/**
 * 区域选择插件
 */
class Region extends AddonBase implements AddonInterface
{
    
    /**
     * 实现钩子
     */
    public function RegionSelect($param = [])
    {
        
        $this->assign('addons_data', $param);
        
        $this->assign('addons_config', $this->addonConfig($param));
        
        $this->addonTemplate('index/index');
    }
    
    /**
     * 插件安装
     */
    public function addonInstall()
    {
    	$arr=$this->addonInfo();
    	$this->getisHook('RegionSelect', $arr['name'], $arr['describe']);
    	$this->installAddon($arr);
    	
    	$this->addonCacheUpdate();
    	
        return [RESULT_SUCCESS, '安装成功'];
    }
    
    /**
     * 插件卸载
     */
    public function addonUninstall()
    {
    	$arr=$this->addonInfo();
    	$this->deleteHook('RegionSelect');
    	$this->uninstallAddon($arr['name']);
    	$this->addonCacheUpdate();
        return [RESULT_SUCCESS, '卸载成功'];
    }
    
    /**
     * 插件基本信息
     */
    public function addonInfo()
    {
        
        return ['name' => 'Region', 'title' => '区域选择', 'describe' => '区域三级联动选择插件', 'author' => 'Bigotry', 'version' => '1.0', 'has_adminlist' => '0'];
    }
    
    /**
     * 插件配置信息
     */
    public function addonConfig($param)
    {
        
        return $param;
    }
}
