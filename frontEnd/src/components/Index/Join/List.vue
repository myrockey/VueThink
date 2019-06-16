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
                <div class="hs-join-box">
                    <div class="hs-container">
                        <el-card class="box-card">
                            <h2 class="tx-c m-b-20">职位列表</h2>
                       <el-table class="hs-join-tab-cont"
                                      :show-header="true"
                                      :data="joinData.detail"
                                      style="width: 100%">
                                <el-table-column
                                        fixed
                                        type="index"
                                        label="编号"
                                        width="200">
                                </el-table-column>
                                <el-table-column
                                        prop="title"
                                        label="职位"
                                        max-width="300">
                                </el-table-column>
                                <el-table-column
                                        prop="address"
                                        label="工作地点"
                                        max-width="300">
                                </el-table-column>
                                <el-table-column
                                        label="操作"
                                        width="200">
                                    <template slot-scope="scope" class="tx-c">
                                        <router-link :to="{ name: 'JoinDetail', params: { id: scope.row.id }}">
                                           查看详情
                                        </router-link>
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
                        </el-card>
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
          { src: require('../../../assets/images/banner10.png'), title: '河山官网' }
        ],
        joinData: { label: '资料', detail: [] }
      }
    },
    methods: {
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
      getWorkLists(index) {
        const data = {
          params: {
            page: this.currentPage,
            limit: this.limit
          }
        }
        this.apiGet('v1/api/works', data).then((res) => {
          this.handelResponse(res, (data) => {
            if (data.data) {
              this.joinData.detail = data.data
              this.dataCount = data.total
            }
          })
        })
      },
      init() {
        this.getCurrentPage()
        this.getWorkLists(0)
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
