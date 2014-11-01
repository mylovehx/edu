$(document).ready(function($){

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
                $('.myfile').val('')
                $('.myfile').click();
                window.clearInterval(time);
                time =  setInterval(function () {
                        $("#myfile").val($('.myfile').val());
                    }, 500);


            });

        $("#logofile").click(function(){
                $('#uplogofile').submit();
                window.clearInterval(time);
                $('.myfile').val('')
                time = setInterval(function () {
                        var text = $(window.frames["hidden_frame"].document).contents().text();
                        if($("#myfile").val()!=""){
                            alert(text);
                        }
                        $("#myfile").val('');
                    }, 1000);

            });

        $('.navsave').click(function(){
                ajaxfunc($(this).parent().parent().children());
            });

        $('.contentsave').click(function(){
                ajaxfunc($(this).parent().parent().children());
            });

	$('.menuclick').click(function(){
		$('.menuclass').html($(this).html()+'<span class="caret"></span>');
		$('#menuclass').val($(this).attr('id'));
	});
	

        $('.navshow').click(function(){
                if($(this).parent().children().attr('value') == '0'){
                    $(this).parent().children().attr('value','1')
                }else{
                    $(this).parent().children().attr('value','0')
                }
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

