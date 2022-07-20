class Forums{

	constructor(){
		this.system = false;
		this.Threads  = [];
		this.ThreadIcon;
		return this;
	}

	SendAnswer(){
		var self = this;
		if(this.system){
			return false;
		}
		this.system = true;
		var Form = $("#answer-thread").serialize();
		$.ajax({
			type: "POST",
			url: "/forums/php/controllers/SendAnswer.php",
			data: Form
		}).success(function(data){
			if(data){
				$("#comment-area .comments-box").append(data);
				$("#page").animate({
					"scrollTop":"9999999px"
				}, 400, function(){
					$(".answer-content").val("");
				});
			}
		}).fail(function(){
			console.log("SendAnswer error.");
		});
		this.system = false;
	}

	ShowAnswerArea(user){
		var self = this;
		$("#comment-area .box").slideDown(250, function(){
			$("#page").animate({
				"scrollTop":$("#forum #thread")[0].getBoundingClientRect().height+"px"
			}, 400, function(){
				self.AddUser(user);
			});
		});
	}

	SendThread(){
		var self = this;
		if(this.system){
			return false;
		}
		this.system = true;
		var Form = $("#NewThreadForm").serialize();
		$.ajax({
			type: "POST",
			url: `/forums/php/controllers/SendThread.php`,
			data: Form
		}).success(function(data){
			window.location.href = data;
		}).fail(function(){
			console.log("Error del modulo.");
		});
		this.system = false;
	}

	events(){
		var self = this;
		$("#forum .category .sections .section").on("click", function(){
			self.GoTo($(this).attr("id"));
		});
	}

	icons(){
		var self = this;
		$("#window.forum-title-icon .content .icon").on("click", function(){
			self.ThreadIcon = $(this).attr("icon");
			if(WI.overlay().close()){
				$("#ThreadTitle").css({
					"background-image":"url('/forums/images/icons/"+self.ThreadIcon+"')",
					"padding-left":"3vmin"
				});
				$("#ThreadIcon").val(self.ThreadIcon);
			}
		});
		$("#window.forum-title-icon .button").on("click", function(){
			self.ThreadIcon = 0;
			if(WI.overlay().close()){
				$("#ThreadTitle").css({
					"background-image":"url('')",
					"padding-left":"1vmin"
				});
				$("#ThreadIcon").val(self.ThreadIcon);
			}
		});
	}

	setSelectionRange(input, selectionStart, selectionEnd) {
		if(input.setSelectionRange) {
			input.focus();
			input.setSelectionRange(selectionStart, selectionEnd);
		}else if(input.createTextRange) {
			var range = input.createTextRange();
			range.collapse(true);
			range.moveEnd('character', selectionEnd);
			range.moveStart('character', selectionStart);
			range.select();
		}
	}

	setCaretToPos (input, pos) {
		this.setSelectionRange(input, pos, pos);
	}

	AddList(textarea){
		var Index = 1;
		var List = "";
		var Elements = "[UL]\n";
		while(List != null){
			List = prompt("Inserte el elemento "+Index);
			if(List != null){
				Elements += "[LI]"+List+"[/LI]\n";
				Index++;
			}
		}
		Elements += "[/UL]";
		var FocusStart = $(textarea).prop('selectionStart');
		var FocusEnd = $(textarea).prop('selectionEnd');
		var Content = $(textarea).val();
		var Before = Content.substring(0, FocusStart);
		var After = Content.substring(FocusStart, Content.length);
		$(textarea).val(Before+Elements+After);
	}

	AddUser(user){
		var textarea = ".answer-content";
		var FocusStart = $(textarea).prop('selectionStart');
		var FocusEnd = $(textarea).prop('selectionEnd');
		var Content = $(textarea).val();
		var Before = Content.substring(0, FocusStart);
		var After = Content.substring(FocusStart, Content.length);
		var Element1 = "[USER]";
		var Element2 = "[/USER]\n";
		$(textarea).val(Before+Element1+user+Element2+After).focus();
	}

	AddLink(textarea){
		var FocusStart = $(textarea).prop('selectionStart');
		var FocusEnd = $(textarea).prop('selectionEnd');
		var Content = $(textarea).val();
		var Embed = Content.substring(FocusStart, FocusEnd);
		if(Embed.length <= 0){
			var Link = prompt("Inserta el enlace:");
			if(Link == null || Link.length <= 0){
				return false;
			}
			var Before = Content.substring(0, FocusStart);
			var After = Content.substring(FocusStart, Content.length);
			var Element1 = "[LINK:"+Link+";]"+Link;
			var Element2 = "[/LINK]";
			$(textarea).val(Before+Element1+Element2+After).focus();
			self.setCaretToPos($(textarea)[0], Before.length+Element1.length);
			return false;
		}
		var Before = Content.substring(0, FocusStart);
		var After = Content.substring(FocusStart, Content.length);
		var Element1 = "[LINK:"+Embed+";]";
		var Element2 = "[/LINK]";
		After = Content.substring(Before.length+Embed.length, Content.length);
		$(textarea).val(Before+Element1+Embed+Element2+After).focus();
	}

	Toolbar(textarea){
		var self = this;
		$('#toolbar div').on('click', function(){
			if($(this).attr("class") == "list"){
				self.AddList(textarea);
				return false;
			}
			if($(this).attr("class") == "link"){
				self.AddLink(textarea);
				return false;
			}
			var FocusStart = $(textarea).prop('selectionStart');
			var FocusEnd = $(textarea).prop('selectionEnd');
			var Content = $(textarea).val();
			var Before = Content.substring(0, FocusStart);
			var After = Content.substring(FocusStart, Content.length);
			var Embed = Content.substring(FocusStart, FocusEnd);
			var Element1 = $(this).attr("E1");
			var Element2 = $(this).attr("E2");
			if(Embed.length <= 0){
				$(textarea).val(Before+Element1+Element2+After).focus();
				self.setCaretToPos($(textarea)[0], Before.length+Element1.length);
			}else{
				After = Content.substring(Before.length+Embed.length, Content.length);
				$(textarea).val(Before+Element1+Embed+Element2+After).focus();
			}
		});
		$('#toolbar .color').on('change', function() {
			var FocusStart = $(textarea).prop('selectionStart');
			var FocusEnd = $(textarea).prop('selectionEnd');
			var Content = $(textarea).val();
			var Before = Content.substring(0, FocusStart);
			var After = Content.substring(FocusStart, Content.length);
			var Embed = Content.substring(FocusStart, FocusEnd);
			var Element1 = "[C:"+$(this).val()+";]";
			var Element2 = "[/C]";
			if(Embed.length <= 0){
				$(textarea).val(Before+Element1+Element2+After).focus();
				self.setCaretToPos($(textarea)[0], Before.length+Element1.length);
			}else{
				After = Content.substring(Before.length+Embed.length, Content.length);
				$(textarea).val(Before+Element1+Embed+Element2+After).focus();
			}
		});
		$('#toolbar .languages').on('change', function() {
			var FocusStart = $(textarea).prop('selectionStart');
			var FocusEnd = $(textarea).prop('selectionEnd');
			var Content = $(textarea).val();
			var Before = Content.substring(0, FocusStart);
			var After = Content.substring(FocusStart, Content.length);
			var Embed = Content.substring(FocusStart, FocusEnd);
			var Element1 = "[LANG:"+$(this).val()+";]";
			var Element2 = "[/LANG]";
			if(Embed.length <= 0){
				$(textarea).val(Before+Element1+Element2+After).focus();
				self.setCaretToPos($(textarea)[0], Before.length+Element1.length);
			}else{
				After = Content.substring(Before.length+Embed.length, Content.length);
				$(textarea).val(Before+Element1+Embed+Element2+After).focus();
			}
		});
	}

	GoTo(ForumID){
		window.location.href = window.location.origin+"/forums/forum/"+ForumID;
	}

	NewThread(ForumID){
		window.location.href = window.location.origin+"/forums/newthread/"+ForumID+"/";
	}

	GetThreads(section, order){
		var self = this;
		if(this.system){
			return false;
		}
		this.system = true;
		$("#forum").append("<div id='loading'><div>");
		WI.overlay().center("#loading", "#forum");
		$.ajax({
			type: "POST",
			url: "/forums/php/controllers/GetThreads.php",
			data: {section: section, order: order}
		}).success(function(data){
			if(data){
				$("#loading").fadeOut(0, function(){
					$(this).remove();
					$("#forum #threads-box").append(data);
				});
			}else{
				$("#loading").fadeOut(0, function(){
					$("#forum #threads-box").append("<div class='no-threads'>Aun no hay hilos en este foro. ¡Se el primero!</div>");
					$("#forum .no-threads").slideDown(400);
				});
			}
		}).fail(function(){
			console.log("Modulo no encontrado.");
		});
		this.system = false;
	}

}
var forum = new Forums();