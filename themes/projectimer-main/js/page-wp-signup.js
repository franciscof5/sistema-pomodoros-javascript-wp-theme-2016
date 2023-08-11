jQuery( document ).ready(function($) {
	//wp-signup.php
	$('#signup-content h2').text('Get your team working together, more close than ever');
	$('[for="signupblog"]').parent().parent().parent().parent().parent().parent().parent().parent().find(".nav-menu").hide();
	$('[for="signupblog"]').text("A free username and a Projectimer Team PRO Account (single user for free + U$5,00 member/month)");
	$('[for="signupuser"]').text("Just a free username, you can join in a Public Projectimer Team (and share a free workspace with cool people) or get invited to join a Projectimer Team PRO");
	$('[for="blogname"]').text("Team URL");
	$('[for="blog_title"]').text("Team Name");
	//
	//alert($('.mu_register').children().eq(6).html());
	//if($('.mu_register').children().eq(1).text()=="");
	//$('.mu_register').children().eq(1).text("There is no limit to the number of sites you can have. By filling out the form below, you can get another team account");
	$('.mu_register').children().eq(2).text("Teams you are already a member of:");
	$('.mu_register').children().eq(4).text("Please, if you’re not going to use a great team url, leave it for a new user.");
});
