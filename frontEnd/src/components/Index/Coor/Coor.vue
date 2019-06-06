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
                <div class="hs-container hs-m-t-65 hs-m-b-150 tx-c" >
                    <el-image class="wow swing" data-wow-duration="1s" data-wow-delay="1s" width="100%" :src="imgContentData.src" :alt="imgContentData.title" lazy></el-image>
                </div>
                <div class="coor-content-box">
                    <div class="hs-container">

                        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="200px" class="demo-ruleForm hs-p-b-150 fz-22 tx-c">
                            <el-form-item class="coor-content-title m-l-p10">
                                <div class="fz-24 hs-m-t-65">申请加入合作伙伴</div>
                            </el-form-item>
                            <el-form-item label="公司名称" prop="companyName" class="hs-m-t-65">
                                <el-input v-model="ruleForm.companyName"></el-input>
                            </el-form-item>
                            <el-form-item label="公司介绍" prop="companyDesc" class="hs-m-t-65">
                                <el-input type="textarea" v-model="ruleForm.companyDesc"></el-input>
                            </el-form-item>
                            <el-form-item label="公司网址" prop="companyUrl" class="hs-m-t-65">
                                <el-input v-model="ruleForm.companyUrl"></el-input>
                            </el-form-item>
                            <el-form-item label="行业属性" prop="companyType" class="hs-m-t-65">
                                <el-input v-model="ruleForm.companyType"></el-input>
                            </el-form-item>
                            <el-form-item label="联系人" prop="companyContact" class="hs-m-t-65">
                                <el-input v-model="ruleForm.companyContact"></el-input>
                            </el-form-item>
                            <el-form-item label="手机号码" prop="tel" class="hs-m-t-65">
                                <el-input v-model="ruleForm.tel"></el-input>
                            </el-form-item>
                            <el-form-item class="hs-m-t-65 hs-m-b-150 hs-submit-btn-box m-l-p10">
                                <el-button class="hs-submit-btn" type="warning" @click="submitForm('ruleForm')" :loading="isLoading">提交</el-button>
                            </el-form-item>
                        </el-form>
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
      let checkEmpty = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('不能为空'))
        } else {
          callback()
        }
      }
      let checkUrl = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('不能为空'))
        } else {
          let name = /[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/
          if (!(name.test(value))) {
            callback(new Error('url格式错误'))
          } else {
            callback()
          }
        }
      }
      let checkTel = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('不能为空'))
        } else {
          let name = /^[1][0-9]{10}$/
          if (!(name.test(value))) {
            callback(new Error('手机号格式错误'))
          } else {
            callback()
          }
        }
      }
      return {
        loading: false,
        imgData: [
          { src: require('../../../assets/images/banner05.png'), title: '河山官网' }
        ],
        imgContentData: { src: require('../../../assets/images/coor01.png'), title: '河山官网' },
        ruleForm: {
          companyName: '',
          companyDesc: '',
          companyUrl: '',
          companyType: '',
          companyContact: '',
          tel: ''
        },
        rules: {
          companyName: [
            { required: true, validator: checkEmpty, trigger: 'blur' }
          ],
          companyUrl: [
            { required: true, validator: checkUrl, trigger: 'blur' }
          ],
          companyContact: [
            { required: true, validator: checkEmpty, trigger: 'blur' }
          ],
          tel: [
            { required: true, validator: checkTel, trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      toOpen(pathLink) {
        window.open(pathLink, 'blank')
      },
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.isLoading = !this.isLoading
            this.apiPost('v1/api/coors', this.ruleForm).then((res) => {
              this.handelResponse(res, (data) => {
                _g.clearVuex('setRules')
                _g.toastMsg('success', '添加成功')
                setTimeout(() => {
                  this.$refs[formName].resetFields()
                  this.isLoading = !this.isLoading
                }, 1500)
              }, () => {
                this.isLoading = !this.isLoading
              })
            })
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      resetForm(formName) {
        this.$refs[formName].resetFields()
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
