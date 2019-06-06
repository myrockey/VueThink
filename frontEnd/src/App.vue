<template>
	<div id="app">
		<transition name="my">
			<router-view></router-view>
		</transition>
	</div>
</template>

<script>
export default {
  name: 'app',
  components: {
  }
}
</script>

<style>
	@import "assets/css/font-awesome.min.css";

	/* 自定义vue效果  my */
	.my{
		position: absolute;left:0;right: 0;
	}
	.my-enter-active {
		transition: all .5s ease;
	}
	.my-leave-active {

		transition: all .1s cubic-bezier(2.0, 0.5, 0.8, 1.0);
	}
	.my-enter, .my-leave-to
	{
		left:0;right: 0;
		transform: scale(1);
		opacity: 1;
	}
	/* slide-fade 效果 */
/*	.slide-fade{
		position: absolute;left:0;right: 0;
	}
	.slide-fade-enter-active {
		transition: all 1.2s ease;
	}
	.slide-fade-leave-active {

		transition: all .1s cubic-bezier(2.0, 0.5, 0.8, 1.0);
	}
	.slide-fade-enter, .slide-fade-leave-to
	{
		left:0;right: 0;
		transform: translateX(50px);
		opacity: 0;
	}*/

	/* bounce 效果 */
	.bounce-enter-active {
		animation: bounce-in .5s;
	}

	.bounce-leave-active {
		animation: bounce-out .2s;
	}

	@keyframes bounce-in {
		0% {
			transform: scale(0);
		}
		50% {
			transform: scale(1.05);
		}
		100% {
			transform: scale(1);
		}
	}

	@keyframes bounce-out {
		0% {
			transform: scale(1);
		}
		50% {
			transform: scale(0.95);
		}
		100% {
			transform: scale(0);
		}
	}

	body {
		margin: 0px;
		padding: 0px;
		/*background: #1F2D3D;*/
		font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
		font-weight: 400;
		-webkit-font-smoothing: antialiased;
	}

	#app {
		position: absolute;
		top: 0px;
		bottom: 0px;
		width: 100%;
	}

	.el-submenu [class^=fa] {
		vertical-align: baseline;
		margin-right: 10px;
	}

	.el-menu-item [class^=fa] {
		vertical-align: baseline;
		margin-right: 10px;
	}
</style>
