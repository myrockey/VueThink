<template>
    <el-footer>
        <div class="hs-footer-bottom">
            <!--底部版权-->
            <br>
            <a href="#">{{companyName}}</a>
            <br>
            <a href="http://www.miitbeian.gov.cn/" rel="external nofollow" target="_blank"> {{companyIcp}} </a>
            <!--底部版权-->
        </div>
    </el-footer>
</template>

<script>
  export default {
    props: [],
    data() {
      return {
        companyName: '深圳河山信息技术有限公司',
        companyIcp: '粤ICP备19029207号-1'
      }
    },
    methods: {
    }
  }
</script>

