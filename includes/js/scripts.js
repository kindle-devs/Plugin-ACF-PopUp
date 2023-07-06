
let kindle_popup = document.querySelector("#popupPlugin");
kindle_popup.querySelector('.kindlePopup__content').insertAdjacentHTML('afterbegin', '<button class="kindlePopup__close" title="fechar">fechar</button>');

document.addEventListener("DOMContentLoaded", function () {
	// let menuOperacoes = document
	// 	.querySelector(".js-submenu-operacoes")
	// 	.querySelector(".sub-menu");
	// let conteudoMenuOperacoes = document.querySelector(
	// 	"[js-submenu-operacoes]"
	// ).innerHTML;

	// menuOperacoes.innerHTML = conteudoMenuOperacoes;

	let btn_fechar_popup = kindle_popup.querySelector('.kindlePopup__close');

	btn_fechar_popup.addEventListener('click', function () {
		kindle_popup.classList.remove('active');
	});

	let exibir_popup = document.querySelector("#exibir_popup").value;
	let exibindo = document.querySelector("#exibindo").value;

	if (exibir_popup == "ocultar") {
		setCookie("popupPlugin", "ocultar", 1);
	} else if (exibir_popup == "Sempre") {
		setCookie("popupPlugin", "exibir", 1);
	}

	if (getCookie("popupPlugin") != "ocultar" && exibindo) {
		kindle_popup.classList.add('active');
		setCookie("popupPlugin", "ocultar", 1)
	}

	// Código modificado para aguardar a presença do elemento #popupAviso no DOM
	if (getCookie("popupPlugin") !== "ocultar" && exibindo) {
		waitForElement("#popupPlugin", function (element) {
			kindle_popup.classList.add('active');
			setCookie("popupPlugin", "ocultar", 1)
		});
	}
});

function isElementInDOM(element) {
	return document.body.contains(element);
}

// Função auxiliar para aguardar a presença do elemento no DOM
function waitForElement(selector, callback) {
	const element = document.querySelector(selector);
	if (isElementInDOM(element)) {
		callback(element);
	} else {
		const observer = new MutationObserver(function (mutations) {
			if (isElementInDOM(element)) {
				observer.disconnect();
				callback(element);
			}
		});
		observer.observe(document.body, { childList: true, subtree: true });
	}
}

function setCookie(c_name, value, exdays) {
	var exdate = new Date(
		new Date(new Date().setHours(0, 0, 0, 0)).setDate(
			new Date().getDate() + exdays
		)
	);
	var c_value =
		escape(value) + (exdays == null ? "" : "; expires=" + exdate.toUTCString());
	document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
	var i,
		x,
		y,
		ARRcookies = document.cookie.split(";");
	for (i = 0; i < ARRcookies.length; i++) {
		x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
		y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
		x = x.replace(/^\s+|\s+$/g, "");
		if (x == c_name) {
			return unescape(y);
		}
	}
}
