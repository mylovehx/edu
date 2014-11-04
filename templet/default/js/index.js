$(document).ready(function($)
	{

		

	});
	
//启动登录状态
function login(){
	document.cookie="session=1";
	window.location.href = "./?/index/login";
}