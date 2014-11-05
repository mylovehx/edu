$(document).ready(function($)
	{

		var  time ;
		//修改首页标题
		$("#btntitle").click(function()
			{
				ajaxfunc('#uptitleform');
			});
		//修改首页标题
		$("#newvipsave").click(function()
			{
				ajaxfunc('#newvip');
			});
		//修改首页LOGO内容
		$("#btnlogo").click(function()
			{
				//$('#uplogoform').submit();
				ajaxfunc('#uplogoform');
			});

		$("#myfile").click(function()
			{
				$('.myfile').val('')
				$('.myfile').click();
				window.clearInterval(time);
				time =  setInterval(function ()
					{
						$("#myfile").val($('.myfile').val());
					}, 500);


			});

		$("#logofile").click(function()
			{
				$('#uplogofile').submit();
				window.clearInterval(time);
				$('.myfile').val('')
				time = setInterval(function ()
					{
						var text = $(window.frames["hidden_frame"].document).contents().text();
						if($("#myfile").val()!="")
						{
							toMessage(text);
						}
						$("#myfile").val('');
					}, 1000);

			});

		$('.navsave').click(function()
			{
				ajaxfunc($(this).parent().parent().children());
			});

		$('.contentsave').click(function()
			{
				ajaxfunc($(this).parent().parent().children());
			});

		$('.menuclick').click(function()
			{
				$('.menuclass').html($(this).html()+'<span class="caret"></span>');
				$('#menuclass').val($(this).attr('id'));
			});
		$('.vipsclick').click(function()
			{
				$(this).parent().parent().parent().find("input").eq(1).attr('value',$(this).attr('id'))
				$(this).parent().parent().parent().find("button").html($(this).html()+'<span class="caret"></span>');
			});
		$('#sevetext').click(function()
			{
				ajaxfunc('#sevecontent');
			});
		$('.vipsave').click(function()
			{
				ajaxfunc($(this).parent().parent().children());
			});

		$('.navshow').click(function()
			{
				if($(this).parent().children().attr('value') == '0')
				{
					$(this).parent().children().attr('value','1')
				}else
				{
					$(this).parent().children().attr('value','0')
				}
			});
		$('.navlogin').click(function()
			{
				if($(this).parent().children().attr('value') == '0')
				{
					$(this).parent().children().attr('value','1')
				}else
				{
					$(this).parent().children().attr('value','0')
				}
			});


		//$("div[class*='vip-group-btn']").removeClass('dropup');

	});

function ajaxfunc(uid)
{
	$.ajax(
		{
			cache: true,
			type: "POST",
			url:$(uid).attr('action'), //发送的连接默认"index.php?type=1&"
			data:$(uid).serialize(),// formid
			async: false,//异步
			error: function(request)
			{
				toMessage("send error");
			},
			success: function(data)
			{
				toMessage(data);
				if(uid="#sevetext")
				{
					padding(1);
				}
			}
		});
}
function deletetext(uid)
{
	$.ajax(
		{
			cache: true,
			type: "POST",
			url:"index.php?type=1&method=deletetext&edu_id="+uid, //发送的连接默认"index.php?type=1&"
			data:$(uid).serialize(),// formid
			async: false,//异步
			error: function(request)
			{
				alert("send error");
			},
			success: function(data)
			{
				//alert(data);
				toMessage(data);
				if(uid="#sevetext")
				{
					var page = $('#modern').attr('uid');
					if(page == 0 || page=="" || isNaN(page))
					{
						page = 1;
					}
					padding(page);
				}
			}
		});
}

function padding(uid)
{
	$('#modern').attr('uid',uid);
	$.ajax(
		{
			cache: true,
			type: "POST",
			url:"index.php?type=1&method=getpage&page="+uid, //发送的连接默认"index.php?type=1&"
			data:$(uid).serialize(),// formid
			async: false,//异步
			error: function(request)
			{
				toMessage("send error");
			},
			success: function(data)
			{
				var text = '';
				eval("var retu ="+data);
				for($i = 0; $i < retu.length; $i++)
				{
					text += "<a href=\"javascript:read("+retu[$i].edu_id+");\" class=\"list-group-item textclick\">"+retu[$i].edu_title+"<span class=\"badge\" onclick=\"deletetext('"+retu[$i].edu_id+"')\"><span aria-hidden=\"true\" >&times;</span></span><span class=\"badge\">"+retu[$i].edu_time+"</span><span class=\"badge\">"+retu[$i].edu_name+"</span></a>";
				}
				$('#textlist').html(text);
				//alert(data);
			}
		});
}
function read(uid)
{
	$.ajax(
		{
			cache: true,
			type: "POST",
			url:"index.php?type=1&method=readtext&eduid="+uid, //发送的连接默认"index.php?type=1&"
			data:$(uid).serialize(),// formid
			async: false,//异步
			error: function(request)
			{
				toMessage("send error");
			},
			success: function(data)
			{
				eval("var retu ="+data);
				$('#uptitle').val(retu[0].edu_title);
				$('#menu_edu_id').val(retu[0].edu_id);
				$('#menuclass').val(retu[0].edu_essayclass_id);
				setContent(retu[0].edu_text);
				$('.menuclass').html(retu[0].edu_name+'<span class="caret"></span>');
				$('#newtext').removeAttr('checked');
			}
		});
}
function toMessage(data)
{
	var let = new Array('a','b','c','d','e','f','g','h','i','g','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	var random1 = Math.round(Math.random()*25)+0;
	var random2 = Math.round(Math.random()*25)+0;
	var random3 = Math.round(Math.random()*25)+0;
	var name = let[random1]+let[random2]+let[random1]+let[random2]+let[random3];
	$('#messagecode').prepend('<div id="'+name+'" class="alert alert-success" style="margin:0;padding:2px;" role="alert">'+data+'</div>');
	setTimeout(function(){$('#'+name).remove()},3000);
}



