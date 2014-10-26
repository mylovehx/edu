$(document).ready(function(){
	
	var  time ;
        //修改首页标题
        $("#btntitle").click(function(){
                ajaxfunc('#uptitleform');
            });
        //修改首页LOGO内容
        $("#btnlogo").click(function(){
                //$('#uplogoform').submit();
                ajaxfunc('#uplogoform');
            });

        $("#myfile").click(function(){
                $('.myfile').click();
               time =  setInterval(function () {
                        $("#myfile").val($('.myfile').val());
                    }, 500);


            });

        $("#logofile").click(function(){
                $('#uplogofile').submit();
                window.clearInterval(time);
                $("#myfile").val('');
                
            });


    });

function ajaxfunc(uid){
    $.ajax({
            cache: true,
            type: "POST",
            url:$(uid).attr('action'), //发送的连接默认"index.php?type=1&"
            data:$(uid).serialize(),// formid
            async: false,//异步
            error: function(request) {
                alert("send error");
            },
            success: function(data) {
                alert(data);
            }
        });
}

