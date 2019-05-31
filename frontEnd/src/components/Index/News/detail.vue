<template>
    <div class="hs-box hs-wrap demo-image__lazy">
        <el-container>
            <index-header></index-header>
            <el-main>
                <div class="hs-container">
                   <div class="hs-news-detail-box">
                       <h2 class="hs-m-t-100 tx-c">{{newsData.title}}</h2>
                       <div class="hs-news-detail-desc tx-c">{{newsData.copyfrom}} {{newsData.create_time | formatDate2}}</div>
                       <div class="m-t-30 hs-news-detail-content" v-html='text(newsData.content)'></div>
                       <div class="tx-c hs-m-t-100 hs-m-b-150"><router-link :to="{ name: 'NewsList' }" class="el-button el-button--warning is-round">返回新闻页</router-link></div>
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
        id: null,
        newsData: {
          title: '',
          copyfrom: '',
          create_time: '',
          content: ''
        }
      }
    },
    methods: {
      jump(pathLink) {
        this.$router.push(pathLink)
      },
      handleClick(row) {
        console.log(row)
      },
      text(content) {
        return (content)
      }
    },
    components: {
      IndexHeader,
      IndexFooter
    },
    created() {
      this.id = this.$route.params.id
      this.apiGet('v1/api/news/' + this.id).then((res) => {
        console.log(res)
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
