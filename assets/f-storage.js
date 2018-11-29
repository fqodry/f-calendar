function saveData(key, data) {
	if(typeof(Storage) !== "undefined") {
		console.log("Support Web Storage...");

		sessionStorage.setItem(key, JSON.stringify(data));
	} else {
		alert("Sorry, your browser does not support Web Storage...");
	}
}