<template>
    <div class="hs-box hs-wrap demo-image__lazy">
        <el-container>
            <index-header></index-header>
            <el-main>
                <el-carousel :interval="5000" arrow="never" class="hs-banner-box">
                    <el-carousel-item v-for="item in imgData">
                        <img width="100%" :src="item.src" :alt="item.title"/>
                    </el-carousel-item>
                    <!--<div class="hs-banner-content">
                        <div class="hs-banner-title">{{bannerTitle}}</div>
                        <div class="hs-banner-line-divide"></div>
                        <div class="hs-banner-desc">{{bannerDesc}}</div>
                    </div>-->
                </el-carousel>
                <div class="hs-banner-tab-box">
                        <el-tabs class="hs-banner-tab">
                            <el-tab-pane v-for="(item, index) in proTabData" :label="item.label" :name="$index">
                                <el-row class="hs-pro-detail-nav">
                                    <div class="hs-container">
                                    <div class="hs-pro-detail-nav-title-en wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s">{{item.titleEn}}</div>
                                    <div class="hs-pro-detail-nav-title wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s">{{item.title}}</div>
                                    </div>
                                </el-row>
                                <el-row v-for="(item2, index2) in item.detail" v-bind:class="[(index2 % 2 !== 0) ? 'hs-pro-bgcolor' : '', 'hs-m-t-65']">
                                    <div class="hs-container">
                                    <div v-if="index2 % 2 === 0">
                                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                                            <div class="hs-pro-detail-box wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="50">
                                                <div class="hs-pro-detail-title">{{item2.title}}</div>
                                                <div class="hs-pro-detail-desc">{{item2.desc}}</div>
                                            </div>
                                        </el-col>
                                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                                            <el-image class="wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="50" :src="item2.src" lazy></el-image>
                                        </el-col>
                                       </div>
                                     <div v-else>
                                         <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                                             <el-image class="wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="50" :src="item2.src" lazy></el-image>
                                         </el-col>
                                         <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                                             <div class="hs-pro-detail-box wow slideInUp" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="50">
                                                 <div class="hs-pro-detail-title">{{item2.title}}</div>
                                                 <div class="hs-pro-detail-desc">{{item2.desc}}</div>
                                             </div>
                                         </el-col>
                                    </div>
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
        bannerTitle: '智慧办公管理系统',
        bannerDesc: '一款企业数字化应管理系统，集办公管理、资料规整、业务拓展、私密沟通为一体，功能完备、紧密联动的企业数字化管理平台解决方案，助企业实现、财、物、客全数字化管理。',
        imgData: [
          { src: require('../../../assets/images/pro1.jpg'), title: '城市之芯', link: 'Pro1' }
        ],
        proTabData: [
          { label: '日程管理',
            title: '日程管理平台',
            titleEn: 'Schedule management'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img01.png'), title: '个人行程日历', desc: '实时制定/修改个人日程，形成个人专属行程日历，可设置行程提醒' },
              { src: require('../../../assets/images/img02.png'), title: '领导行程', desc: '呈现领导行程信息，设置行程开放级别，如个人可见、指定可见、群组可见、全部可见等。' },
              { src: require('../../../assets/images/img03.png'), title: '申请会谈', desc: '权限内人员申请领导会谈，填写会谈时间地点、主题等信息。会谈卡片一键发送至领导移动端。' },
              { src: require('../../../assets/images/img04.png'), title: '行程共享', desc: '应用内或跨应用共享行程安排。' }
            ]
          },
          { label: '智慧办公',
            title: '智慧办公平台',
            titleEn: 'Intelligent Office Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img05.png'), title: '合约管理', desc: '合同移动查阅审核，授权指定人员使用唯一授权码进行审阅，在平台及时反馈审阅意见。' },
              { src: require('../../../assets/images/img06.png'), title: '工作汇报', desc: '提交日报、周报、月报等资料汇报工作进度，管理者在移动端可随时随地的查阅/批准。' },
              { src: require('../../../assets/images/img07.png'), title: '自定义信息模板', desc: '审批模板、意见征集模板、非公开通知模板等，可一键发送至相关人员移动终端进行审批。' }
            ]
          },
          { label: '品宣资料',
            title: '品宣资料平台',
            titleEn: 'Pinxuan Information Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img08.png'), title: '资料云盘', desc: '企业私有化资料共享云盘，业务资料归档管理。按照子公司、项目等主体划分云盘。管理员后台实时上传/更新资料。员工账号分级授权查看/分享/收藏资料。应用内或跨应用分享。' },
              { src: require('../../../assets/images/img09.png'), title: '加密资料盘', desc: '重要资料加密管理。' },
              { src: require('../../../assets/images/img10.png'), title: '管理资料盘', desc: '权内部管理制度、学习资料、培训资料、活动资料等。' },
              { src: require('../../../assets/images/img11.png'), title: '自建文件盘', desc: '根据需求自建文件盘，并可进行加密设置。。' }
            ]
          },
          { label: '密级通讯',
            title: '密级通讯平台',
            titleEn: 'Secret Communication Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img12.png'), title: '通讯录', desc: '清晰展示组织架构，可后台批量导入员工通讯信息、统一管理。领导手机号码可隐藏。' },
              { src: require('../../../assets/images/img13.png'), title: '交流群/一对一交流', desc: '仅用于工作使用的独立高密级即时通讯系统，无需添加好友即可实名制沟通。可设置总交流群、项目/部门交流群、自建交流群等。' },
              { src: require('../../../assets/images/img14.png'), title: '文件传输', desc: '支持文字、语音、视频、图片、文件等多种聊天形式，已读未读一目了解。应用内信息实时转发。' }
            ]
          },
          { label: '会议管理',
            title: '会议管理平台',
            titleEn: 'Conference Management Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img15.png'), title: '会议室预约', desc: '会议室使用状态一目了然，一键预约/取消预约。提交会议室布置需求，管理人员实时审批和调配。' },
              { src: require('../../../assets/images/img16.png'), title: '会议邀约', desc: '一键发送会议信息，通知参会人员。' },
              { src: require('../../../assets/images/img17.png'), title: '电子签到', desc: '通过扫描动态个人信息二维码进行会场电子签到。一键导出会议签到表' },
              { src: require('../../../assets/images/img18.png'), title: '会议记录/追踪', desc: '记录会议重要信息，追踪会议结果，实现工作会议闭环管理。仅参会人员可见。' }
            ]
          },
          { label: '任务管理',
            title: '任务管理平台',
            titleEn: 'Task management platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img19.png'), title: '任务分解/分配', desc: '团队负责人创建任务并分配给团队成员，标记任务紧急程度，设置完成截止时间。' },
              { src: require('../../../assets/images/img20.png'), title: '任务发送', desc: '自选短信、应用内等方式发送任务，任务到期前提醒等。设置任务抄送人，监督任务进度。' },
              { src: require('../../../assets/images/img21.png'), title: '任务状态追踪', desc: '任务状态分为已接、进行时、已完成。相关人员可随时上传/查阅任务相关附件。' },
              { src: require('../../../assets/images/img22.png'), title: '任务日历标签', desc: '已接任务自动添加至个人专属行程日历表中。' }
            ]
          },
          { label: '对外合作管理',
            title: '对外合作管理平台',
            titleEn: 'Management Platform for Foreign Cooperation'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img23.png'), title: '合作方资料', desc: '授权合作方专属账号，上传合作方信息资料，平台统一展示。随时查阅/调取合作方业务资料。' },
              { src: require('../../../assets/images/img24.png'), title: '业务合作需求', desc: '合作方实时发布新的业务合作需求，快速实现业务合作精准匹配、无缝对接。' },
              { src: require('../../../assets/images/img25.png'), title: '专属电子名片', desc: '企业定制专属名片样式，品牌形象统一管理，全面展示个人及企业信息。一键形成电子名片，下载保存至本地，便于对外推介。' }
            ]
          },
          { label: '移动物联',
            title: '移动物联平台',
            titleEn: 'Mobile Material Link Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img26.png'), title: '物联场景一键连接', desc: '可通过“扫一扫”功能扫描二维码，实现一键连接物联设备和场景。' },
              { src: require('../../../assets/images/img27.png'), title: '物联网场景操控', desc: '一键连接智能会议室/办公室/接待室等物联网场景，一键操控形成预设情景。' },
              { src: require('../../../assets/images/img28.png'), title: '智能设备操作列表', desc: '智能设备操作列表' },
              { src: require('../../../assets/images/img29.png'), title: '智能设备操作列表', desc: '智能化设计施工一体化服务为企业提供物联网场景搭建整体解决方案。' }
            ]
          },
          { label: '信息管理',
            title: '信息管理平台',
            titleEn: 'Information Management Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img30.png'), title: '新闻/通知/公告', desc: '统一后台发布新闻/通知/公告等企业信息，规范内部信息管理。' },
              { src: require('../../../assets/images/img31.png'), title: '动态信息提醒', desc: '系统中各类信息实时提醒，包括日程发布/变更，资料上传/更新、通知/公告发布、任务发布等。' },
              { src: require('../../../assets/images/img32.png'), title: '关键信息登记', desc: '员工重要信息填写上传，重要信息变化及时更新。后台一键导出员工重要信息。' },
              { src: require('../../../assets/images/img33.png'), title: '账号权限管理', desc: '账号权限分级管理。' }
            ]
          },
          { label: '安全防范管理',
            title: '安全防范管理平台',
            titleEn: 'Security management platform '.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img34.png'), title: '系统截屏预警', desc: '系统用户截图时预警提示。同一ID三次预警后将后台报警，通过ID和截图页面判断信息泄露情形。' },
              { src: require('../../../assets/images/img35.png'), title: '账号分级管理', desc: '系统账号仅由后台授权，不可独立注册，分级管理资料信息调阅权限。' },
              { src: require('../../../assets/images/img36.png'), title: '私有云服务器', desc: '企业独立私有服务器。' }
            ]
          },
          { label: '定制化资源管理',
            title: '定制化资源管理平台',
            titleEn: 'Customized Resource Management Platform'.toUpperCase(),
            detail: [
              { src: require('../../../assets/images/img37.png'), title: '资源管理平台', desc: '根据企业需求定制化设计开发设施、园区、场地、资产等各类型资源管理平台，实现资源池化。' },
              { src: require('../../../assets/images/img38.png'), title: '企业管理数据库', desc: '搭建企业管理数据库，开发和融合各类型资源管理平台，实现人、财、物、客全面数字化管理。' },
              { src: require('../../../assets/images/img39.png'), title: '企业数字化建设', desc: '搭建开放、互联、融合、智能的一体化企业数字化创新平台。' }
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
