class Slideshow{

	constructor(){
		this.Effects = ["fade"]
		this.Images = {list: [], current: 0, total: 0}
		this.Settings = {
			IntervalBtweenImage: 2500,
			ImageEffectDuration: 1000
		}
		this.SetControlSize()
		this.events()
		this.init()
	}

	events(){
		window.onresize = () => {
			this.SetControlSize()
		}
	}

	SetControlSize(){
		this.button_width = $("#slide-controls .slide-button.right")[0].getBoundingClientRect().width
		this.slide_width = $("#slide-controls")[0].getBoundingClientRect().width
		$("#slide-controls .slide-button.right").css({
			"left": `${(this.slide_width - this.button_width)*98/100}px`
		})
	}

	init(){
		$.ajax({
			url: `modules/Slideshow/php/slideshow.controller.php`,
			success: (response) => {
				$(".slide-message").hide("fade", 1000, () => { $(".slide-message").remove() })
				const images = JSON.parse(response)
				for(let key in images){
					$("#slideshow #frame").append(`<div class='slide-image' id='slide_${key}'></div>`)
					$(`#slide_${key}`).css({"background-image": `url('${images[key]}')`})
					$("#slideshow #slide-controls .bullets").append(`<div class='image-bullet' id='bullet_${key}'></div>`)
					//$(`#bullet_${key}`).on("click", (e) => { this.SetImage(key) })
				}
				$(`#slide_0`).show()
				$("#slideshow #slide-controls .bullets .image-bullet:first-child").css({"background-color": "#ff6600"})
				this.Images = {list: images, current: 1, total: images.length}
				this.interval = setInterval(() => {this.start()}, this.Settings.IntervalBtweenImage)
			},
			error: () => {
				console.log("Ocurrio un error interno del sistema.")
			}
		})
	}

	start(){
		const Random = Math.floor((Math.random()*this.Effects.length))
		const RandomEffect = this.Effects[Random]
		const Time = this.Settings.IntervalBtweenImage
		const TimeEffect = this.Settings.ImageEffectDuration
		if(this.Images.current >= this.Images.total){
			$(".slide-image:not(:first-child)").hide(RandomEffect, TimeEffect)
			this.SetBullet(0)
			this.Images.current = 1
			return
		}
		$(`#slide_${this.Images.current}`).show(RandomEffect, TimeEffect)
		this.SetBullet(this.Images.current)
		this.Images.current++
	}

	next(){
		
	}

	prev(){
		
	}

	SetBullet(index){
		$(`#slide-controls .bullets .image-bullet`).css({"background-color":"#e5e5e5"})
		$(`#slide-controls .bullets #bullet_${index}`).css({"background-color":"#ff6600"})
	}

	SetImage(e){
		this.Images.current = e
		$(`.slide-image`).hide("fade", 500)
		$(`#slide_${e}`).show()
		this.SetBullet(e)
	}

}