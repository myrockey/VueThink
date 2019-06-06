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
                <div class="hs-banner-tab-box">
                    <el-tabs class="hs-banner-tab hs-about-tab" @tab-click="tabClick">
                        <el-tab-pane v-for="(item, index) in downloadTabData" :label="item.label" :name="$index">
                            <div class="hs-container hs-m-t-100">
                                <el-table class="hs-about-tab-cont"
                                          :show-header="false"
                                          :data="item.detail"
                                          style="width: 100%">
                                    <el-table-column
                                            type="index"
                                            label="序号"
                                            width="100">
                                    </el-table-column>
                                    <el-table-column
                                            prop="title"
                                            label="名称"
                                            width="400">
                                    </el-table-column>
                                    <el-table-column
                                            fixed="right"
                                            label="操作"
                                            width="100">
                                        <template slot-scope="scope" class="tx-c">
                                            <el-button @click="downloadClick(scope.row)" type="text"
                                                       size="small">下载
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
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
        dataCount: null,
        currentPage: null,
        limit: 15,
        imgData: [
          { src: require('../../../assets/images/banner07.png'), title: '河山官网' }
        ],
        downloadTabData: [{ label: '资料', detail: [] }, { label: '软件', title: '模型', detail: [] }]
      }
    },
    methods: {
      jump(pathLink) {
        this.$router.push(pathLink)
      },
      tabClick(tab) {
        this.tid = Number(tab.index) + Number(1)
        router.push({ query: { page: 1 }})
        this.getDocumentLists(tab.index, this.tid)
      },
      downloadClick(row) {
        window.open(row.path, 'blank')
      },
      handleCurrentChange(page) {
        router.push({ path: this.$route.path, query: { tid: this.tid, page: page }})
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
      getDocumentLists(index, tid) {
        if (tid) {
          this.tid = tid
        }
        const data = {
          params: {
            tid: this.tid,
            page: this.currentPage,
            limit: this.limit
          }
        }
        this.apiGet('v1/api/document/lists', data).then((res) => {
          this.handelResponse(res, (data) => {
            if (data.data) {
              this.downloadTabData[index].detail = data.data
              this.dataCount = data.total
            }
          })
        })
      },
      init() {
        this.getCurrentPage()
        this.getDocumentLists(0, 1)
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
