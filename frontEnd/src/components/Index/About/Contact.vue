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
                <div class="hs-container">
                    <div class="hs-contact-box">
                        <h2 class="hs-m-t-100">{{title}}</h2>
                        <el-divider></el-divider>
                        <div class="hs-contact-detail">
                            <div class="fl">
                                <p><i class="icon-add"></i>{{address}}</p>
                                <p><i class="icon-tel"></i>{{tel}}</p>
                                <p><i class="icon-ser"></i>{{service}}</p>
                            </div>
                            <div class="fr"><el-image width="150" :src="imgWechat.src" :alt="imgWechat.title" lazy></el-image></div>
                            <div class="hs-clear"></div>
                        </div>
                        <h2 class="hs-m-t-100">{{titleMap}}</h2>
                        <el-image class="m-t-20 tx-c wow slideInUp hs-m-b-150" data-wow-duration="1s" data-wow-delay="1s" width="100%" :src="imgMap.src" :alt="imgMap.title" lazy></el-image>
                    </div>
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
          { src: require('../../../assets/images/banner09.png'), title: '河山官网' }
        ],
        title: '深圳河山信息技术有限公司',
        tel: '联系电话：0755-61123863',
        service: '客服微信：13510123411',
        address: '地址：深圳市南山区高新南环路29号留学生创业大厦',
        imgWechat: { src: require('../../../assets/images/contact.png'), title: '河山官网' },
        titleMap: '深圳河山信息技术有限公司所在地地图',
        imgMap: { src: require('../../../assets/images/map.png'), title: '河山官网' }
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
