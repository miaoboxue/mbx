@extends('admin.layout')
@section('content')

    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">展示图片</label>
            <div class="layui-input-block">
                <input type="hidden" id="image">
                <button type="button" class="layui-btn" id="img">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>
        {{--<div class="layui-form-item">
            <label class="layui-form-label">轮播图</label>
            <div class="layui-input-block">
                <input type="hidden"  id="images">
                <button type="button" class="layui-btn" id="imgs">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-inline">
                <select name="is_status" lay-verify="required" id="status">
                    <option value="">请选择</option>
                    <option value="0">是</option>
                    <option value="1">否</option>
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
           layui.use(['form','upload','layer'], function(){
               var form = layui.form;
               var layer=layui.layer;
               var upload = layui.upload;
               //上传图片执行实例
               var uploadInst = upload.render({
                   elem: '#img' //绑定元素
                   ,url: "/img/imgAll?type=1" //上传接口
                   ,accept:'images'
                   ,exts:'jpg|jpeg|png|gif'
                   ,size:2048
                   ,done: function(res){
                       console.log(res)
                       layer.msg(res.font,{icon:res.code});
                       if(res.code==1){
                           $('#image').val(res.url);

                       }
                       //上传完毕回调

                       //console.log(res)
                   }

               });
               var uploadInst = upload.render({
                   elem: '#imgs' //绑定元素
                   ,url: "/content/img?type=2" //上传接口
                   ,multiple:true
                   ,number:3
                   ,done: function(res){
                       layer.msg(res.font,{icon:res.code});

                       if(res.code==1){
                           var _src=$('#images').val();
                           //console.log(_src)
                           $('#images').val(_src+'|'+res.url);
                       }
                       //console.log(res)
                   }

               });
               $("#btn").click(function () {
                   var image = $("#image").val();
                   var is_status = $("#status").val();
                   $.post(
                       'imgData',
                       {image:image,is_status:is_status},
                       function(res){
                           console.log(res)
                           if (res.status==640){
                               alert('请上传一张图片')
                           }else if (res.status==730){
                               alert('添加失败')
                           }else{
                               alert('添加成功')
                           }
                       }
                   )
               })
           })
       })
    </script>

@endsection