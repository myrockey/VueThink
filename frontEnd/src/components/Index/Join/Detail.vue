<template>
    <div class="hs-box hs-wrap demo-image__lazy hs-join-detail-box">
        <el-container>
            <index-header></index-header>
            <el-main>
                <el-carousel :interval="5000" arrow="never" :autoplay="true" :loop="true" class="hs-banner-box">
                    <el-carousel-item v-for="item in imgData">
                        <img width="100%" :src="item.src" :alt="item.title"/>
                    </el-carousel-item>
                </el-carousel>
                <div class="hs-join-detail-box2">
                    <div class="hs-container">
                        <el-card class="box-card hs-m-b-150">
                          <div class="join-detail-item join-detail-title">{{worksData.title}}</div>
                          <div class="m-t-20 fz-12 p-l-10">
                              <div class="fl p-r-10">分享到</div>
                             <!-- <div class="fl" @click="shareTo('qzone')">
                                  <img src="http://zixuephp.net/static/images/qqzoneshare.png" width="30">
                              </div>-->
                              <div class="fl p-r-10" @click="shareTo('wechat')">
                                  <img src="http://zixuephp.net/static/images/wechatshare.png" width="20">
                              </div>
                              <div class="fl p-r-10" @click="shareTo('sina')">
                                  <img src="http://zixuephp.net/static/images/sinaweiboshare.png" width="20">
                              </div>
                              <div class="fl p-r-10" @click="shareTo('qq')">
                                  <img src="http://zixuephp.net/static/images/qqshare.png" width="20">
                              </div>
                              <div class="hs-clear"></div>


                          </div>
                            <div class="hs-join-detail-div m-t-30">
                                <el-row :gutter="100">
                                    <el-col :span="8"><div class="grid-content bg-purple">工作地点：<span>{{worksData.address}}</span></div></el-col>
                                    <el-col :span="8"><div class="grid-content bg-purple">工作经验：<span>{{worksData.year}}</span></div></el-col>
                                    <el-col :span="8"><div class="grid-content bg-purple">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;历：<span>{{worksData.study}}</span></div></el-col>
                                </el-row>
                                <el-row :gutter="100">
                                    <el-col :span="8"><div class="grid-content bg-purple">工作类型：<span>{{worksData.type}}</span></div></el-col>
                                    <el-col :span="8"><div class="grid-content bg-purple">招聘人数：<span>{{worksData.num}}</span></div></el-col>
                                    <el-col :span="8"><div class="grid-content bg-purple">发布时间：<span>{{worksData.create_time | formatDate}}</span></div></el-col>
                                </el-row>
                            </div>
                            <div class="join-detail-item">职位描述</div>
                            <div class="m-t-20" v-html='text(worksData.desc)'></div>
                            <div class="join-detail-item">任职要求</div>
                            <div class="m-t-20" v-html='text(worksData.content)'></div>
                            <div class="join-detail-item">投递简历</div>
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
        imgData: [
          { src: require('../../../assets/images/banner11.png'), title: '河山官网' }
        ],
        id: null,
        worksData: {
          title: '',
          address: '',
          year: '',
          study: '',
          type: '',
          num: '',
          desc: '',
          content: ''
        }
      }
    },
    methods: {
      text(content) {
        return (content)
      },
      shareTo(stype) {
        var ftit = ''
        var flink = ''
        var lk = ''
        if (typeof flink == 'undefined') {
          flink = ''
        }
        if (flink == '') {
          lk = 'http://' + window.location.host + '/logo.png'
        }
        if (flink.indexOf('/uploads/') != -1) {
          lk = 'http://' + window.location.host + flink
        }
        if (flink.indexOf('ueditor') != -1) {
          lk = flink
        }
        console.log(document.location.href)
        console.log(lk)
        if (stype == 'qzone') {
          window.open('https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + document.location.href + '?sharesource=qzone&title=' + ftit + '&pics=' + lk + '&summary=河山官网招聘')
        }
        if (stype == 'sina') {
          window.open('http://service.weibo.com/share/share.php?url=' + document.location.href + '?sharesource=weibo&title=' + ftit + '&pic=' + lk + '&appkey=2706825840')
        }
        if (stype == 'qq') {
          window.open('http://connect.qq.com/widget/shareqq/index.html?url=' + document.location.href + '?sharesource=qzone&title=' + ftit + '&pics=' + lk + '&summary=河山官网招聘&desc=河山官网')
        }
        if (stype == 'wechat') {
          window.open('http://zixuephp.net/inc/qrcode_img.php?url=http://www.rimount.com')
        }
      }
    },
    components: {
      IndexHeader,
      IndexFooter
    },
    created() {
      this.id = this.$route.params.id
      this.apiGet('v1/api/works/' + this.id).then((res) => {
        this.handelResponse(res, (data) => {
          this.worksData = data
        })
      })
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
