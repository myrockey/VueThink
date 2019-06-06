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
                                    <router-link :to="{ name: 'NewsDetail', params: { id: item.id }}">
                                        <el-image width="100%" :src="item.thumb" :alt="item.title">
                                            <div slot="error" class="image-slot fz-24">
                                                {{item.title}}
                                                <i class="el-icon-picture-outline"></i>
                                            </div>
                                        </el-image>
                                    </router-link>
                                </el-col>
                                <el-col :span="12">
                                    <div class="news-item-title">
                                        <router-link :to="{ name: 'NewsDetail', params: { id: item.id }}">
                                        {{item.title}}
                                        </router-link>
                                    </div>
                                    <div class="news-item-date">{{item.create_time | formatDate}}</div>
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
                        <div class="tx-c hs-m-t-100">
                            <el-pagination
                                    background
                                    hide-on-single-page
                                    @current-change="handleCurrentChange"
                                    layout="prev, pager, next"
                                    :page-size="limit"
                                    :current-page="currentPage"
                                    :total="dataCount">
                            </el-pagination>
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
        dataCount: null,
        currentPage: null,
        limit: 15,
        imgData: [
          { src: require('../../../assets/images/banner08.png'), title: '河山官网' }
        ],
        newsListData: []
      }
    },
    methods: {
      jump(pathLink) {
        this.$router.push(pathLink)
      },
      handleClick(row) {
      },
      handleCurrentChange(page) {
        router.push({ path: this.$route.path, query: { page: page }})
      },
      getCurrentPage() {
        let data = this.$route.query
        if (data) {
          if (data.page) {
            this.currentPage = parseInt(data.page)
          } else {
            this.currentPage = 1
          }
        }
      },
      getArticleLists() {
        const data = {
          params: {
            page: this.currentPage,
            limit: this.limit
          }
        }
        this.apiGet('v1/api/articles', data).then((res) => {
          this.handelResponse(res, (data) => {
            this.newsListData = data.data
            this.dataCount = data.total
          })
        })
      },
      init() {
        this.getCurrentPage()
        this.getArticleLists()
      }
    },
    components: {
      IndexHeader,
      IndexFooter
    },
    created() {
      this.init()
    },
    mounted() {
    },
    watch: {
      '$route' (to, from) {
        this.init()
      }
    },
    mixins: [http]
  }
</script>

<style>
</style>
