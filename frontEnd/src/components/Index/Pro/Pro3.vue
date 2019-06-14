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

                        <div class="pro3-btn-box">
                        <div class="hs-container">
                            <el-row class="fr">
                            <img width="132" height="132" :src="imgQrData.src" :alt="imgQrData.title"/>
                            <div>微信二维码扫码进入</div>
                            </el-row>
                        </div>
                        </div>

                </el-carousel>
                <div class="hs-container hs-m-t-65 hs-m-b-150" >
                    <el-image class="wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" width="100%" :src="imgPro3Data.src" :alt="imgPro3Data.title" lazy></el-image>
                </div>
                <img width="100%" :src="imgPro3Data2.src" :alt="imgPro3Data2.title"/>
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
          { src: require('../../../assets/images/pro3.jpg'), title: '城市之芯', link: 'Pro3' }
        ],
        imgQrData: { src: require('../../../assets/images/pro3_qr.png'), title: '周期研习社' },
        imgPro3Data: { src: require('../../../assets/images/pro3_01.png'), title: '周期研习社' },
        imgPro3Data2: { src: require('../../../assets/images/pro3_02.png'), title: '周期研习社' }
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
