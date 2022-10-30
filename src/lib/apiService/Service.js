import axios from 'axios'

/* Create Instance */
const axiosInstance = axios.create({
    baseURL: `${location.protocol + '//' + location.host + '/wp-json/search_alert_base/v1'}`,
    headers: {
        "Content-type": "application/json"
    }
});

const getAll = path =>{
    return axiosInstance.get(path);
}

const dataUpdate = (path, args) => {
    return axiosInstance.post(path, args);
};

const datadelete = path => {
    return axiosInstance.delete(path);
};

const apiService = {
    getAll,
    dataUpdate,
    datadelete
}

export default apiService;