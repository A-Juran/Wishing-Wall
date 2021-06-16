<template>
	<div class="s_contant main clearfix" id="s_contant" v-if="w_card_all.data">
			<div id="w_card" class="w_card" v-for="(item,index) in w_card_all.data.data" :key="index">
				<div class="tips" @click="dialogFormVisible = true,form.id = item.w_id">
					<!-- :style="{'background': item.w_Color,}" -->
					<div class="tips_avatar" :style="{'background': item.w_Color,}">
						<img :src="a_random()" alt="">
					</div>
					<div class="tips_content" :style="{'background': item.w_Color,}">
						<p>{{item.w_Content}}</p>
					</div>
					<div class="tips_footer clearfixs">
						<a href="#" class="author">许愿者:
							<span>{{item.w_Name}}</span>
						</a>
						<a href="#" class="time">
							<span>{{item.w_Time}}</span>
						</a>
					</div>
				</div>
			</div>
		<div class="page_button">
			<el-pagination :page-size="16" :pager-count="pagetotal" layout="prev, pager, next" :total="card_total"
				@current-change="handleCurrentChange">
			</el-pagination>
		</div>
		<!-- 密码验证框 -->
		<el-dialog :visible.sync="dialogFormVisible" width="300px">
			<el-form :model="form">
				<el-form-item label="id" :label-width="formLabelWidth">
					<el-input v-model="form.id" autocomplete="off" disabled></el-input>
				</el-form-item>
				<el-form-item label="查看密码" :label-width="formLabelWidth">
					<el-input v-model="form.password" autocomplete="off"></el-input>
				</el-form-item>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click="dialogFormVisible = false">取 消</el-button>
				<el-button type="primary" @click="verifi_card(form.id)">确 定</el-button>
			</div>
		</el-dialog>
		<!-- 修改愿望框 -->
		<template>
			<el-dialog title="许下承诺" :visible.sync="dialogFormVisible_one" width="500px" ref="Addw_Card">
				<el-form :model="form_two">
					<el-form-item label="夙愿者" :label-width="formLabelWidth">
						<el-input v-model="form_two.name" autocomplete="off" disabled></el-input>
					</el-form-item>
				<el-form-item label="贴纸颜色">
					<!-- <el-color-picker v-model="form.color"></el-color-picker> -->
					<el-color-picker v-model="form_two.color" show-alpha></el-color-picker>
				</el-form-item>
					<el-form-item label="夙愿内容" :label-width="formLabelWidth">
						<el-input type="textarea" v-model="form_two.content"></el-input>
					</el-form-item>
					<el-form-item label="添加时间" :label-width="formLabelWidth">
						<el-input v-model="form_two.time" autocomplete="off" disabled></el-input>
					</el-form-item>
				</el-form>
				<div slot="footer" class="dialog-footer">
					<el-button @click="delete_card()">删 除</el-button>
					<el-button type="primary" @click="updata_card()">更 新</el-button>
				</div>
			</el-dialog>
		</template>

	</div>
</template>
<script src="../assets/js/global.js" type="text/javascript" charset="utf-8"></script>
<script>
	export default {
		name: 'w_card',
		data() {
			return {
				dialogFormVisible: false,
				dialogFormVisible_one: false,
				form: {
					id: '',
					password: ''
				},
				form_two: {
					id: '',
					name: '',
					color: '',
					content: '',
					time: ''
				},
				formLabelWidth: '80px',
				w_card_all: [],
				pagetotal: 0, //分页数
				card_total: 0, //总条数
			};
		},
		methods: {
			card_all(val) {
				let _this = this;
				let api = 'http://wishingwall.com/index.php/Index/Index/w_select';
				let page = 0;
				val ? page = val : page = 1;
				_this.$axios.post(api, {
					pages: page
				}).then(res => {
					if (res) {
						console.log(res);
						_this.w_card_all = res;
						this.card_total = Math.ceil(res.data.total_num / 16);
						this.card_total = res.data.total_num;
					}
				});
			},
			verifi_card() {
				var qs = require('querystring');
				let _this = this;
				let api = 'http://wishingwall.com/index.php/Index/Index/w_retrieve';
				_this.$axios.post(api, qs.stringify(_this.form)).then(res => {
					console.log(res);
					if (res.data == null) {
						_this.$message.success("密码错误");
						return 0;
					}
					if (res.data) {
						_this.dialogFormVisible = false;
						_this.$message.success("success");
						_this.form_two.id = res.data.w_id;
						_this.form_two.name = res.data.w_Name;
						_this.form_two.color = res.data.w_Color;
						_this.form_two.content = res.data.w_content;
						_this.form_two.time = res.data.w_Time;
						_this.dialogFormVisible_one = true;
					}
				});
			},
			delete_card() {
				var qs = require('querystring');
				let _this = this;
				let api = 'http://wishingwall.com/index.php/Index/Index/w_delete';
				console.log(_this.form.id);
				_this.$axios.post(api, qs.stringify(_this.form)).then(res => {
					if (res.data.code == 200) {
						_this.$message.success(res.data.msg);
						_this.dialogFormVisible_one = false;
						location.reload();
					}
				});
			},
			updata_card() {
				var qs = require('querystring');
				let _this = this;
				let api = 'http://wishingwall.com/index.php/Index/Index/w_update';
				console.log(_this.form_two);
				_this.$axios.post(api, qs.stringify(_this.form_two)).then(res => {
					if (res.data.code == 200) {
						_this.$message.success(res.data.msg);
						_this.dialogFormVisible_one = false;
						location.reload();
					}
				});
			},
			handleCurrentChange(val) {
				this.card_all(`${val}`);
			},
			a_random() {
				let number = Math.ceil(Math.random() * 10);
				return require("../assets/images/"+number+".png");
			}

		},
		created() {
			this.card_all();
		},
	}
</script>

<style>
	.el-dialog__body {
		padding: 30px 20px 0px 20px;
	}
</style>
