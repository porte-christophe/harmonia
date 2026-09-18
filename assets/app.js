import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

let btnFav = document.getElementById('my-super-btn');
if (btnFav!==null) {
	let trackId = btnFav.getAttribute('data_trackId');
	btnFav.addEventListener("click", function(){
		fetch("/handle-favorite/" + trackId)
		.then(res=>res.json())
		.then(data=>{
			if (data.created) {
				btnFav.innerHTML = "Retirer des favoris";
			} else {
				btnFav.innerHTML = "Ajouter aux Favoris";
			}
		})
	  
	}); 
}




//tu va recevoir du json
//vérifier que tout est ok

// mettre a jour le label du bouton

