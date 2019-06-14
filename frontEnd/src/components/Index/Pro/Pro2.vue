<template>
    <div class="hs-box hs-wrap demo-image__lazy">
        <el-container>
            <index-header></index-header>
            <el-main>
                <el-carousel :interval="5000" arrow="never" class="hs-banner-box">
                    <el-carousel-item v-for="item in imgData">
                        <img width="100%" :src="item.src" :alt="item.title"/>
                    </el-carousel-item>
                    <!--<div class="hs-banner-content">
                        <div class="hs-banner-title">{{bannerTitle}}</div>
                        <div class="hs-banner-line-divide"></div>
                        <div class="hs-banner-desc">{{bannerDesc}}</div>
                    </div>-->
                    <el-row class="pro2-btn-box">
                        <el-button  class="wow flip" data-wow-duration="1s" data-wow-delay="1s" @click="toOpen(btnData.src)" type="warning" round>{{btnData.title}}<br>{{btnData.link}}</el-button>
                    </el-row>
                </el-carousel>
                <div class="hs-container">
                    <div class="hs-pro2-content wow slideInUp" data-wow-duration="1s" data-wow-delay="1s">
                        <div class="hs-pro2-title">{{pro2Data.title}}</div>
                        <div class="hs-pro2-line-divide"></div>
                        <div class="hs-pro2-desc">{{pro2Data.desc}}</div>
                    </div>
                    <el-row :gutter="32" class="pro2-border-box">
                        <el-col :span="6" v-for="item in pro2Data.detail" class="wow slideInUp" data-wow-duration="1s" data-wow-delay="1s">
                            <el-card shadow="hover" class="pro2-bor-content">
                                <div class="pro2-bor-content-title">{{item.title}}</div>
                                <div class="pro2-bor-content-desc">{{item.desc}}</div>
                            </el-card>
                        </el-col>
                    </el-row>
                    <el-image class="wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" width="100%" :src="imgPro2Data.src" :alt="imgPro2Data.title" lazy></el-image>
                    <div class="hs-pro2-center-title wow slideInUp" data-wow-duration="1s" data-wow-delay="1s">线下服务</div>
                    <el-row :gutter="10" class="m-b-30">
                        <el-col :span="12" v-for="item in imgPro2Data2">
                            <el-image class="wow slideInUp" data-wow-duration="2s" data-wow-delay="2s" width="100%" :src="item.src" :alt="item.title" lazy></el-image>
                        </el-col>
                    </el-row>
                </div>


            </el-main>
            <index-footer></index-footer>
        </el-container>
    </div>
</template>

<script>
  import IndexHeader from '../../Index/Common/Header'
  import IndexFooter from '../../Index/Common/Footer'
  import http from '../../../assets/js/http'

  export default {
    data() {
      return {
        btnData: { title: '进入城市之芯官网', link: 'www.citycore88.com', src: 'http://www.citycore88.com' },
        imgData: [
          { src: require('../../../assets/images/pro2.jpg'), title: '城市之芯', link: 'Pro2' }
        ],
        pro2Data: {
          title: '痛点',
          desc: '以土地资产作为特殊投资标的，解决管理过程中存在的资产信息不对称、多方博弈较繁琐、政策复杂难分析等诸多痛点，使信息传递更透明、投资管理更简化、规划研判更规范。',
          detail: [
          { title: '智能管理系统', desc: '全流程化管理，便捷省心' },
          { title: '规划研判系统', desc: '专业规划研判，清晰透明' },
          { title: '资料整合系统', desc: '深度信息整合，详尽全面' },
          { title: '会员定制系统', desc: '会员分级管理，安全可靠' }
          ]
        },
        imgPro2Data: { src: require('../../../assets/images/pro2_01.png'), title: '城市之芯' },
        imgPro2Data2: [
          { src: require('../../../assets/images/pro2_02.png'), title: '城市之芯' },
          { src: require('../../../assets/images/pro2_03.png'), title: '城市之芯' }
        ]
      }
    },
    methods: {
      toOpen(pathLink) {
        window.open(pathLink, 'blank')
      }
    },
    components: {
      IndexHeader,
      IndexFooter
    },
    created() {
    },
    mounted() {
    },
    mixins: [http]
  }
</script>

<style>
</style>
