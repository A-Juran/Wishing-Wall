<template>
	<div id="app">
		<!-- 头部 -->
		<img src="../assets/images/background.jpg" alt="" id="bodybk">
		<div class="header">
			<div class="nav main">
				<h2>许愿墙</h2>
				<span>
					<el-row>
						<el-button type="primary" icon="el-icon-edit" circle size="medium "
							@click="dialogFormVisible = true">
						</el-button>
					</el-row>
				</span>
			</div>
		</div>
		<!-- 添加信息框 -->
		<template>
			<el-dialog title="许下承诺" :visible.sync="dialogFormVisible" width="500px" ref="Addw_Card">
				<el-form :model="form">
					<el-form-item label="夙愿者" :label-width="formLabelWidth">
						<el-input v-model="form.name" autocomplete="off"></el-input>
					</el-form-item>
					<el-form-item label="贴纸颜色">
						<!-- <el-color-picker v-model="form.color"></el-color-picker> -->
						<el-color-picker v-model="form.color" show-alpha></el-color-picker>
					</el-form-item>
					<el-form-item label="夙愿内容" :label-width="formLabelWidth">
						<el-input type="textarea" v-model="form.content"></el-input>
					</el-form-item>
					<el-form-item label="查看密码" :label-width="formLabelWidth">
						<el-input v-model="form.password" autocomplete="off"></el-input>
					</el-form-item>
				</el-form>
				<div slot="footer" class="dialog-footer">
					<el-button @click="dialogFormVisible = false">取 消</el-button>
					<el-button type="primary" @click="AddWishCard()">确 定</el-button>
				</div>
			</el-dialog>
		</template>
		<!-- 中间部分 -->
		<div class="section">
			<w_card></w_card>
		</div>
		<!-- 脚部 -->
		<div class="footer">
			<div class="f_main main">
				<h4>许愿墙</h4>
			</div>
		</div>
	</div>
</template>

<script>
	import w_card from './w_card.vue'
	export default {
		name: 'Index',
		data() {
			return {
				dialogFormVisible: false, //弹出框是否可见
				form: {
					name: '',
					content: '',
					password: '',
					color: '',
				},
				formLabelWidth: '80px',
				
			};
		},
		methods: {
			AddWishCard() {
				var qs = require('querystring');
				let _this = this;
				let api = 'http://wishingwall.com/index.php/Index/Index/w_insert';
				_this.$axios.post(api, qs.stringify(_this.form)).then(res => {
						if (res.data.code == 200) {
							_this.$message.success("许愿成功,希望你一如既往的努力。");
							console.log(res);
							location.reload();
						} else {
							_this.$message.success(res.data.msg);
						}
					})
					.catch(function(error) {
						console.log(error);
					});
			},
			
		},
		components: {
			w_card,
		},


	};
</script>

<style>
	@import url("../assets/css/global.css");
</style>
