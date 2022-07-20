window.onload = (e) => {
	SetSectionsLevel()
}

const SetSectionsLevel = () => {
	let a = $("#left").height()
	let b = $("#right").height()
	if(a > b){
		$("#right").height(a)
	}else{
		$("#left").height(b)
	}
}