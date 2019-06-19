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
        aboutDesc: '深圳河山信息技术有限公司基于新一代互联网技术，为企业提供智能化信息技术服务，助力企业全面实现数字化建设。河山信息业务范围：计算机软件、互联网相关软件的技术开发、技术咨询、技术服务；信息咨询；数据库管理；计算机系统集成技术开发等。河山信息现主营产品有：周期量化技术平台、智慧办公管理系统、智慧营销系统、城市之芯·资产行情终端系统等。',
        aboutDesc2: '河山信息团队拥有丰富的互联网产品开发经验，将数据化管理思维与互联网大数据深度整合，以解决企业运营、资产管理、业务拓展过程中的诸多痛点。为企业提供智慧企业管理系统开发、量化系统开发、互联网产品开发、物联网云平台等信息技术服务，以及金融科技产品委托开发等服务。',
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
