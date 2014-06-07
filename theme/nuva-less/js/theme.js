function showMenu() {

	elementDisplay = document.getElementById("mobile-menu").style.display;

   if (elementDisplay === "none" || elementDisplay === "") {
		document.getElementById("mobile-menu").style.display = "block";
	} else {
		document.getElementById("mobile-menu").style.display = "none";
	}
}
