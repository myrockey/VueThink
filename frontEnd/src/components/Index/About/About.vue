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
                </el-carousel>
                <div class="hs-about-content-box hs-container">
                    <p class="hs-m-t-100 wow slideInUp" data-wow-duration="1s" data-wow-delay="1s">{{aboutDesc}}</p>
                    <p class="m-t-30 wow slideInUp" data-wow-duration="1s" data-wow-delay="1s">{{aboutDesc2}}</p>
                    <el-image class="hs-m-t-65 hs-m-b-60 wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" width="100%"  :src="aboutImgData.src" :alt="aboutImgData.title" lazy></el-image>

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
        imgData: [
          { src: require('../../../assets/images/banner06.png'), title: '河山官网' }
        ],
        aboutDesc: '河山信息致力于物联网管理层的设计与开发、智能通讯网络设计、互联网产品开发、金融科技产品委托开发等，主营产品有“智慧办公管理系统”、“城市之芯·资产行情终端”、“周期研习社”等。河山信息的主要业务范围为计算机软件、互联网相关软件的技术开发、技术咨询、技术服务、信息咨询；数据库管理；计算机系统集成的技术开发等。',
        aboutDesc2: '河山信息成立于2017年11月，注册在深圳市前海深港合作区，是前海金融同业公会的唯一非金融类企业会员，为公会会员提供信息技术服务。',
        aboutImgData: { src: require('../../../assets/images/about01.png'), title: '河山官网' }
      }
    },
    methods: {
      jump(pathLink) {
        this.$router.push(pathLink)
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
