<template>
    <div class="hs-box hs-wrap demo-image__lazy">
        <el-container>
            <index-header></index-header>
            <el-main>
                <el-carousel :interval="5000" arrow="always" :autoplay="true" :loop="true" class="hs-banner-box">
                    <el-carousel-item v-for="item in imgData">
                        <img width="100%" :src="item.src" :alt="item.title"/>
                    </el-carousel-item>
                </el-carousel>
                <div class="hs-banner-tab-box">
                    <el-tabs class="hs-banner-tab">
                        <el-tab-pane v-for="(item, index) in serviceTabData" :label="item.label" :name="$index">
                            <el-row class="hs-container padding-0 hs-m-t-100">
                                <div v-for="item2 in item.detail">
                                    <el-image class="wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" width="100%" :src="item2.src" lazy></el-image>
                                </div>
                            </el-row>
                        </el-tab-pane>
                    </el-tabs>
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
          { src: require('../../../assets/images/banner01.png'), title: '河山官网' },
          { src: require('../../../assets/images/banner02.png'), title: '河山官网' },
          { src: require('../../../assets/images/banner03.png'), title: '河山官网' },
          { src: require('../../../assets/images/banner04.png'), title: '河山官网' }
        ],
        serviceTabData: [
          { label: '互联网信息服务',
            detail: [
              { src: require('../../../assets/images/service01.png') },
              { src: require('../../../assets/images/service02.png') }
            ]
          },
          { label: '物联网整体解决方案',
            title: '模型',
            detail: [
              { src: require('../../../assets/images/service03.png') }
            ]
          },
          { label: '宣品设计管理',
            detail: [
              { src: require('../../../assets/images/service04.png') }
            ]
          },
          { label: '企业管理咨询服务',
            detail: [
              { src: require('../../../assets/images/service05.png') }
            ]
          }
        ]
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
