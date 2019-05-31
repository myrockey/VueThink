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
        companyDesc: '河山信息致力于物联网管理层的设计与开发、智能通讯网络设计、互联网产品开发、金融科技产品委托开发等，主营产品有“智慧办公管理系统“、 ”城市之芯·资产行情终端“、”周期精灵“等。',
        companyDesc2: '河山信息的主要业务范围为计算机软件、互联网相关软件的技术开发 、技术咨询、技术服务、信息咨询；数据库管理；计算机系统集成的技术开发等。',
        newsData: [
          { id: '1', title: '合一产业与河山信息举行战略合作签约仪式' },
          { id: '2', title: '城市之芯与乌尔比安律所战略合作签约' }
        ],
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
      this.apiGet('v1/api/news').then((res) => {
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
