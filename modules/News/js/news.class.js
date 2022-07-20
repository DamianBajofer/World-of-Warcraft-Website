class News{

	constructor(){
		this.GetNews()
	}

	GetNews(){
		$.ajax({
			url: "modules/News/php/news.controller.php",
			success: function(response){
				response = JSON.parse(response)
				for(let i in response){
					$("#news").append(`${response[i]}<div class='divider'>`)
				}
			},
			error: function(){
				console.log("News module error.")
			}
		})
	}

} new News()