import axios from "axios";

const restRequest = axios.create({
	baseURL: searchAlert_CoreScriptData.apiEndpoint,
	headers: {
		"Content-type": "application/json",
		"X-WP-Nonce": searchAlert_CoreScriptData.apiNonce,
	},
});

export { restRequest };