class WebInterface{

	constructor(){
		this.domain = window.location.origin;
		return this;
	}

	PlaySound(object){
		object[0].currentTime = 0;
		object[0].play();
	}

	overlay(){
		var self = this;
		this.create = function(){
			var overlay = "<div id='overlay'></div>";
			var loading = "<div id='loading'></div>";
			$("body").append(overlay);
			$("#overlay").html(loading);
			self.overlay().center("#loading","#overlay");
			return true;
		}
		this.load = function(path){
			if(self.overlay().create()){
				$("#overlay").load("/"+path, function(content, success){
					if(success == "success"){
						self.overlay().center("#window","#overlay");
					}
					//tooltip.listener();
				});
			}
		}
		this.LoadAjax = function(path, callback){
			if(self.overlay().create()){
				$("#overlay").load("/"+path, function(content, success){
					if(success == "success"){
						callback();
					}
					//tooltip.listener();
				});
			}
		}
		this.center = function(a, b){
			var top = ($(b)[0].getBoundingClientRect().height/2)-($(a)[0].getBoundingClientRect().height/2);
			var left = ($(b)[0].getBoundingClientRect().width/2)-($(a)[0].getBoundingClientRect().width/2);
			$(a).css({
				"margin-top":top+"px",
				"margin-left":left+"px",
				"opacity":"1"
			});
			return true;
		}
		this.close = function(){
			$("#overlay").remove();
			$("#window").css({"opacity":"0"});
			return true;
		}
		return this;
	}

} let WI = new WebInterface();