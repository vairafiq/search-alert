import { createRoot } from 'react-dom/client';
import { Provider } from "react-redux";
import store from "./store/store";
import App from "./App.jsx";

document.addEventListener("DOMContentLoaded", function () {
	const container = document.getElementById("search-alert-settings");
	if (!container) {
		return;
	}

	const root = createRoot(container);

	root.render(
		<Provider store={store}>
			<App />
		</Provider>
	);
});
