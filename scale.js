$(window).load(function(){
	$('img').each(function(idx,item){
		if($(item).attr('data-src')){
			console.log(item);
			$(item).attr('src','/img/scale/'+$(item).width()+'/0'+$(item).attr('data-src'));
		}
	});
});