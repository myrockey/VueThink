<template>
    <div class="hs-box hs-wrap demo-image__lazy">
        <el-container>
            <index-header></index-header>
            <el-main>
                <el-carousel :interval="5000" arrow="never" :autoplay="true" :loop="true" class="hs-banner-box">
                    <el-carousel-item v-for="item in imgData">
                        <img width="100%" :src="item.src" :alt="item.title"/>
                    </el-carousel-item>
                </el-carousel>
                <div class="hs-container">
                    <div class="hs-m-b-150 hs-new-box">
                        <div class="hs-news-item" v-for="item in newsListData" >
                            <el-row :gutter="20">
                                <el-col :span="12">
                                    <el-image width="100%" :src="item.imgUrl" :alt="item.title" lazy>
                                        <div slot="error" class="image-slot fz-24">
                                            <i class="el-icon-picture-outline"></i>
                                        </div>
                                    </el-image>
                                </el-col>
                                <el-col :span="12">
                                    <div class="news-item-title">{{item.title}}</div>
                                    <div class="news-item-data">{{item.create_time | formatDate}}</div>
                                    <div class="news-item-desc">{{item.description}}</div>
                                    <div class="news-item-btn">
                                        <router-link :to="{ name: 'NewsDetail', params: { id: item.id }}" class="el-button el-button--warning is-plain">
                                            阅读全文 >>
                                        </router-link>
                                    </div>
                                </el-col>
                            </el-row>
                            <el-divider></el-divider>
                        </div>

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
          { src: require('../../../assets/images/banner08.png'), title: '河山官网' }
        ],
        newsListData: [{
          id: '1',
          imgUrl: require('../../../assets/images/list01.png'),
          title: '合一产业与河山信息举行战略合作签约仪式',
          date: '2019.01.20',
          desc: '党中央、国务院高度重视信息化，特别是习近平总书记关于信息化建设的一系列重要讲话和指示，是新时代“数字法治·智慧司法”建设工作的科学.....指南和根本遵循。各级司法行政机关要认真学习、贯彻落实，充分认识智慧监狱建设的重要性和紧迫性，加快建设步伐，为全面实现“数字法治·智慧司法”战略部署做出表率，要切实加强组织领导，积极筹措建设资金，努力造就一支高素质的信息技术人才队伍，全面推进智慧监狱建设。'
        }, {
          id: '2',
          imgUrl: require('../../../assets/images/list02.png'),
          title: '城市之芯与乌尔比安律所战略合作签约',
          date: '2019.01.20',
          desc: '党中央、国务院高度重视信息化，特别是习近平总书记关于信息化建设的一系列重要讲话和指示，是新时代“数字法治·智慧司法”建设工作的科学.....指南和根本遵循。各级司法行政机关要认真学习、贯彻落实，充分认识智慧监狱建设的重要性和紧迫性，加快建设步伐，为全面实现“数字法治·智慧司法”战略部署做出表率，要切实加强组织领导，积极筹措建设资金，努力造就一支高素质的信息技术人才队伍，全面推进智慧监狱建设。'
        }]
      }
    },
    methods: {
      jump(pathLink) {
        this.$router.push(pathLink)
      },
      handleClick(row) {
        console.log(row)
      }
    },
    components: {
      IndexHeader,
      IndexFooter
    },
    created() {
      this.apiGet('v1/api/news').then((res) => {
        this.handelResponse(res, (data) => {
          this.newsListData = data
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
