@extends('admin.layout')
@section('content')
    <form class="layui-form">
        <input type="hidden" name="vk_id" value="{{$arr['vk_id']}}" id="vk_id">
        <div class="layui-form-item">
            <label class="layui-form-label">直属单位名称</label>
            <div class="layui-input-inline">
                <input type="text" name="vk_name" required value="{{$arr['vk_name']}}" id="vk_name" lay-verify="required" placeholder="直属单位名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-inline">
                <select name="is_status" lay-verify="required" id="is_status">
                    <option value="">请选择</option>
                    <?php if ($arr['is_status']==0){?>
                        <option value="0" selected>是</option>
                        <option value="1">否</option>
                    <?php }else{?>
                        <option value="0">是</option>
                        <option value="1" selected>否</option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type="button" lay-submit lay-filter="formDemo" id="btn">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
</form>
    <script>
        $(function () {
            $("#vk_name").blur(function () {
                var vk_name = $("#vk_name").val();
                if (vk_name == ''){
                    alert("直属单位名称")
                }
            })
            $("#btn").click(function () {
                var vk_name = $("#vk_name").val();
                var is_status = $("#is_status").val();
                var vk_id = $("#vk_id").val();
                $.post(
                    '/vk/updateall',
                    {vk_name:vk_name,is_status:is_status,vk_id:vk_id},
                    function (msg) {
                        console.log(msg)
                        if(msg.status=='1500'){
                            alert('直属单位名称')
                        }else if (msg.status=='1200'){
                            alert('请选择父分类')
                        }else if (msg.status=='5002'){
                            alert('修改失败')
                        }else{
                            alert('修改成功')
                        }
                    }
                )
            })
        })
    </script>
@endsection