<template>
    <el-header class="hs-header">
        <div class="hs-container hs-menu-pc">
            <a href="/" class="hs-logo"></a>
            <el-menu :default-active="$route.path" class="el-menu-demo hs-el-menu" mode="horizontal">
                <el-menu-item index="Index"><router-link :to="{name: 'Index'}">首页</router-link></el-menu-item>
                <el-menu-item v-for="item in indexMenuData" index="item.link"><router-link :to="{name: item.link}">{{item.name}}</router-link></el-menu-item>
            </el-menu>
            <div class="hs-clear"></div>
        </div>
        <div class="hs-container hs-menu-mobile">
            <el-row class="hs-el-row">
                <el-col :span="8"><router-link class="hs-tl" :to="{name: 'Index'}">首页</router-link></el-col>
                <el-col :span="8"><router-link class="hs-tc" :to="{name: 'Index'}">{{systemName}}</router-link></el-col>
                <el-col :span="8">
                    <el-dropdown trigger="click" class="hs-menu-el-dropdown">
                        <span class="el-dropdown-link ">更多菜单<i class="el-icon-menu el-icon--right"></i></span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item v-for="item in indexMenuData" index="item.link"><router-link :to="{name: item.link}">{{item.name}}</router-link></el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </el-col>
            </el-row>
        </div>
    </el-header>
</template>

<script>
  import { WOW } from 'wowjs'
  export default {
    props: [],
    data() {
      return {
        activeIndex: '1',
        systemName: '河山官网',
        indexMenuData: [
          { name: '产品', link: 'Pro1' },
          { name: '服务', link: 'Service' },
          { name: '合作伙伴', link: 'Coor' },
          { name: '关于我们', link: 'About' },
          { name: '联系我们', link: 'Contact' },
          { name: '下载', link: 'Download' }
        ]
      }
    },
    methods: {
    },
    created() {
    },
    mounted() {
      var wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        live: false,
        offset: 0,
        mobile: true
      })
      wow.init()
    }
  }
</script>

