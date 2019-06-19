<template>
    <div class="hs-box hs-wrap demo-image__lazy">
        <el-container>
            <index-header></index-header>
            <el-main class="hs-index-bg">
                <div class="hs-container">
                    <el-row>
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <div class="hs-m-t-130">
                               <div class="hs-content-title">{{companyTitle}}</div>
                               <div class="hs-content-title-en">{{companyTitleEN}}</div>
                               <div class="hs-content-desc m-t-20">
                                   {{companyDesc}}
                               </div>
                                <div class="hs-content-desc m-t-20">
                                    {{companyDesc2}}
                                </div>
                                <div class="hs-news-list wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s" >
                                    <div class="hs-news-title"><router-link :to="{ name: 'NewsList' }">新闻简要</router-link></div>
                                    <div class="hs-news-content" >

                                        <router-link v-for="item in newsData" :to="{ name: 'NewsDetail', params: { id: item.id }}">
                                            {{item.title}}
                                        </router-link>
                                    </div>
                                </div>

                                <el-row :gutter="80" class="hs-index-pro-btn">
                                    <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" v-for="item in proData">
                                        <el-button  class="wow flip" data-wow-duration="1s" data-wow-delay="1s" @click="jump(item.link)" type="warning" round>{{item.title}}</el-button>
                                    </el-col>
                                </el-row>

                            </div>
                        </el-col>

                    </el-row>
                </div>
            </el-main>
            <index-footer></index-footer>
        </el-container>
    </div>
</template>

<script>
  import IndexHeader from '../Index/Common/Header'
  import IndexFooter from '../Index/Common/Footer'
  import http from '../../assets/js/http'

  export default {
    data() {
      return {
        companyTitle: '河山信息技术有限公司',
        companyTitleEN: 'HESHAN INFORMATION',
        companyDesc: '深圳河山信息技术有限公司基于新一代互联网技术，为企业提供智能化信息技术服务，助力企业全面实现数字化建设。主营产品有：周期量化技术平台、智慧办公管理系统、智慧营销系统、城市之芯·资产行情终端系统等。',
        companyDesc2: '河山信息团队拥有丰富的互联网产品开发经验，将数据化管理思维与互联网大数据深度整合，以解决企业运营、资产管理、业务拓展过程中的诸多痛点。为企业提供智慧企业管理系统开发、量化系统开发、互联网产品开发、物联网云平台等信息技术服务，以及金融科技产品委托开发等服务。',
        newsData: [],
        proData: [
          { link: '/pro2', title: '城市之芯' },
          { link: '/pro3', title: '周期研习社' }
        ]
      }
    },
    methods: {
      jump(pathLink) {
        _g.jump(pathLink)
      }
    },
    components: {
      IndexHeader, IndexFooter
    },
    created() {
      this.apiGet('v1/api/index/articleLists').then((res) => {
        this.handelResponse(res, (data) => {
          this.newsData = data
        })
      })
    },
    mounted() {
    },
    mixins: [http]
  }
</script>

<style>

</style>
