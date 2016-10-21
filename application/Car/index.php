<?php

include_once '../common/header.inc.php';
include_once '../inc/page.inc.php';
?>
<style>
.table th, .table td {
	text-align: center;
}
</style>
<body>

<form class="form-inline definewidth m20" action="" method="POST">
	车主名：
	<input type="text" name="cuser" id="rolename"
					class="abc input-default" placeholder="" value="">
	&nbsp;&nbsp;车牌号：
	<input type="text" name="ccar_num"
					class="abc input-default" placeholder="" value="">
	&nbsp;&nbsp;
				办理日期：
	<input type="text" name="cadd_time" id="datepicker-query"
					class="abc input-default" placeholder="" value="">
	&nbsp;&nbsp;
					车检有效期：
	<input type="text" name="ceffective_time" id="datepicker-query2"
					class="abc input-default" placeholder="" value="">
	&nbsp;&nbsp;
	<button type="submit" class="btn btn-primary btn-xs" name="query">查询</button>
	&nbsp;&nbsp;
	<a href="add.php" class="btn btn-success btn-xs">添加车辆信息</a>
</form>
<br />
<?php


//
if (isset ( $_POST ['query'] ) )
{
	$query_count = "select count(*) from liu_car_info where cadd_time like binary \"%{$_POST['cadd_time']}%\" and 	cuser like \"%{$_POST['cuser']}%\" and 	ceffective_time like \"%{$_POST['ceffective_time']}%\" and 	ccar_num like \"%{$_POST['ccar_num']}%\" ";
	$result_count = execute ( $link, $query_count );
	$count = num ( $link, $query_count );
	$page = page ( $count, 20 );
	$query = "select * from liu_car_info where cadd_time like binary \"%{$_POST['cadd_time']}%\" and 	cuser like binary \"%{$_POST['cuser']}%\" and 	ccar_num like \"%{$_POST['ccar_num']}%\" and 	ceffective_time like binary \"%{$_POST['ceffective_time']}%\"	order by cid desc  {$page['limit']}";
}else {
	$query_count = "select count(*) from liu_car_info ";
	$result_count = execute ( $link, $query_count );
	$count = num ( $link, $query_count );
	$page = page ( $count, 20 );
	$query = "select * from liu_car_info  order by cid desc  {$page['limit']}";
}
//var_dump ( $query );
$result = execute ( $link, $query );
?>
<table class="table table-condensed table-bordered table-hover definewidth m10">
	<thead>
		<tr>

			<th>序号</th>
			<th>办理日期</th>
			<th>车牌号</th>
			<th>车主姓名</th>
			<th>联系电话</th>
			<th>汽车品牌</th>
			<th>车架号</th>
			<th>发动机号</th>
			<th>注册日期</th>
			<th>发证日期</th>
			<th>车检有效期</th>
			<th>下次有效期</th>
			<th colspan="3">操作</th>
		</tr>
	</thead>

	<?php

					while ( $data = mysqli_fetch_assoc ( $result ) ) {
							?>
	<tr>

		<td>
			<a href="info.php?cid=<?php echo $data['cid']?>
				">
				<?php echo $data['cid']?></a>
		</td>
		<td>
			<?php echo date('Y年m月d日',strtotime($data['cadd_time']))?></td>
			<td>
			<?php echo $data['ccar_num']?></td>
		<td>
			<?php echo $data['cuser']?></td>
			<td>
			<?php echo $data['cuser_phone']?></td>
		<td>
			<?php echo $data['cbrand']?></td>


		<td>
			<?php echo $data['cchejia_num']?></td>
		<td>
			<?php echo $data['cmotor_num']?></td>
		<td>
			<?php echo $data['creg_time']?></td>
		<td>
			<?php echo $data['cbanfa_time']?></td>
		<td>
			<?php echo $data['cnext_time']?></td>
		<td>
			<?php echo $data['ceffective_time']?></td>
		<td>
			<a href="info.php?cid=<?php echo $data['cid']?>
				">
				<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
				查看
			</a>
		</td>
		<td>
			<a style="color: orange" href="edit.php?cid=<?php echo $data['cid']?>
				">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				编辑
			</a>
		</td>
		<td >
			<!-- <a href="del.php?cid=<?php echo $data['cid']?>
				">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				删除
			</a> -->
			<a style="color: red" href="javascript:void(0)" onclick="del(<?php echo $data['cid']?>)">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				删除
			</a>
		</td>
	</tr>

	<?php } ?></table>

<div class="inline pull-right page">
	<nav style="float: right">
		<ul class="pagination pagination-sm">

			<?php
			  if ($count != 0) {
			  echo " <li >
			<a >
				共 <b><span aria-hidden='true'>".$count."</span></b>
				条记录
			</a>
		</li>
		";

						echo $page ['html'];
					}
					?>
	</ul>
</nav>
</div>



</body>
</html>

<script>
$(function () {
    $('#datepicker-query').datepicker({
    	language: 'zh-CN',
        format: 'yyyy-mm',
        autoclose:true,
        todayBtn: 'linked'
    });
});
 $(function () {
    $('#datepicker-query2').datepicker({
    	language: 'zh-CN',
        format: 'yyyy年mm月',
        autoclose:true,
        todayBtn: 'linked'
    });
});


function del(cid)
	{


		if(confirm("确定要删除第"+cid+"条记录吗？"))
		{

			var url = "del.php?cid="+cid;

			window.location.href=url;

		}


	}


</script>