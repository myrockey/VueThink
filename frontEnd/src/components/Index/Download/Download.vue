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
                    <el-tabs class="hs-banner-tab hs-about-tab">
                        <el-tab-pane v-for="(item, index) in downloadTabData" :label="item.label" :name="$index">
                            <div class="hs-container hs-m-t-100">
                                <el-table class="hs-about-tab-cont"
                                          :show-header="false"
                                          :data="item.detail"
                                          style="width: 100%">
                                    <el-table-column
                                            prop="id"
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
                                            <el-button @click="handleClick(scope.row)" type="text"
                                                       size="small">下载
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
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
        imgData: [
          { src: require('../../../assets/images/banner07.png'), title: '河山官网' }
        ],
        downloadTabData: [
          {
            label: '资料',
            detail: [{
              id: '01',
              title: '“城市之芯·资产行情终端”用地需求要素表',
              url: 'www.baidu.com'
            }, {
              id: '02',
              title: '“城市之芯·资产行情终端”用地需求要素表',
              url: 'www.baidu.com'
            }, {
              id: '03',
              title: '“城市之芯·资产行情终端”用地需求要素表',
              url: 'www.baidu.com'
            }, {
              id: '04',
              title: '“城市之芯·资产行情终端”用地需求要素表',
              url: 'www.baidu.com'
            }]
          },
          {
            label: '软件',
            title: '模型',
            detail: [{
              id: '01',
              title: '“  城市之芯 · 资产行情终端装包',
              url: 'www.baidu.com'
            }, {
              id: '02',
              title: '“  城市之芯 · 资产行情终端装包',
              url: 'www.baidu.com'
            }, {
              id: '03',
              title: '“  城市之芯 · 资产行情终端装包',
              url: 'www.baidu.com'
            }]
          }
        ]
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
    },
    mounted() {
    },
    mixins: [http]
  }
</script>

<style>
</style>
