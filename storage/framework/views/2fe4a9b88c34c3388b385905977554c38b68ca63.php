<?php $__env->startSection('main'); ?>
<div class="col-md-10">

	<div class="jumbotron">
		<img src="/style/admin/img/4.jpg"height="310px" width="100%" alt="">
		<h2>联想 后台管理系统</h2>
		<p>开发者 ： 何天骄</p>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.public.admin", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>