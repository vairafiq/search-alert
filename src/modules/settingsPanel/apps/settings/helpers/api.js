import axios from "axios";

const axiosObj = axios.create({
	baseURL: searchAlert_SettingsScriptData.apiEndpoint,
	headers: {
		"Content-type": "application/json",
		"X-WP-Nonce": searchAlert_SettingsScriptData.apiNonce,
	},
});

const updateOptions = async (data) => {
	
	if ( data ) {
		return await axiosObj.post("/settings", {
			options: data
		});
	}
};

const getOptions = async (data) => {
	return await axiosObj.get("/settings", {});
};

const api = {
	axiosObj,
	updateOptions,
	getOptions,
};

export default api;
