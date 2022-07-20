class TopMenu{

	constructor(){
		this.GetItems()
	}

	GetItems(){
		var self = this;
		$.ajax({
			url: "modules/TopMenu/php/menu.controller.php",
			success: function(response){
				response = JSON.parse(response);
				$("#menu .link").remove();
				for(var i = 0; i < response.length; i++){
					var link = response[i]["link"];
					var name = response[i]["name"];
					var time = 500;
					$("#menu").append(`<a href='?page=${link}' class='link' id='${i}'>${name}</a>`);
				}
			},
			error: function(){
				$("#menu .link").html("ITEMS LOADING FAILED").attr("class", "link error");
			}
		});
	}

} new TopMenu()