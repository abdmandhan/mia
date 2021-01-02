import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import TokenService from "./token.service";
import { MESSAGE, LOGOUT } from "./store/auth.module";
import store from "./store";
import router from "./../router"

/**
 * Service to call HTTP request via Axios
 */
const ApiService = {
    init() {
        Vue.use(VueAxios, axios);
        // Vue.axios.defaults.baseURL = "http://mia.test/api";
        Vue.axios.defaults.baseURL = "http://mia.syailendra.xyz/api";
    },

    /**
     * Set the default HTTP request headers
     */
    setHeader() {
        Vue.axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${TokenService.getToken()}`;

        Vue.axios.defaults.headers.common["Accept"] = 'application/json';
        Vue.axios.defaults.headers.common["Content-Type"] = 'multipart/form-data';
    },

    query(resource, params) {
        return Vue.axios.get(resource, params).catch(error => {
            throw new Error(`[KT] ApiService ${error}`);
        });
    },

    /**
     * Send the GET HTTP request
     * @param resource
     * @param slug
     * @returns {*}
     */
    get(resource, params = {}) {
        this.setHeader();

        return Vue.axios.get(`${resource}`, { params: params }).then((result) => {
            store.dispatch(MESSAGE, { message: result.data.message, color: result.status ? 'green' : 'red' });
            console.log("GET RESPONSE", result);

            return result;
        }).catch((err) => {
            if (err.response.status == 401) {
                store.dispatch(LOGOUT).then(() => router.push({ name: "login" }));
                console.log("LOGOUT");
            }
            console.log("ERROR RESPONSE", err.response);
            console.log("ERROR STATUS", err.response.status);
            return err.response;
        });
    },

    /**
     * Set the POST HTTP request
     * @param resource
     * @param params
     * @returns {*}
     */
    post(resource, params) {
        this.setHeader();

        return Vue.axios.post(`${resource}`, params)
            .then((result) => {
                store.dispatch(MESSAGE, { message: result.data.message, color: result.status ? 'green' : 'red' });
                console.log("POST RESPONSE", result);
                return result;

            }).catch((err) => {
                if (err.response.status == 401) {
                    store.dispatch(LOGOUT).then(() => router.push({ name: "login" }));
                    console.log("LOGOUT");
                }
                console.log("ERROR RESPONSE", err.response);
                console.log("ERROR STATUS", err.response.status);
                return err.response;
            });
    },

    /**
     * Send the UPDATE HTTP request
     * @param resource
     * @param slug
     * @param params
     * @returns {IDBRequest<IDBValidKey> | Promise<void>}
     */
    update(resource, slug, params) {
        return Vue.axios.put(`${resource}/${slug}`, params);
    },

    /**
     * Send the PUT HTTP request
     * @param resource
     * @param params
     * @returns {IDBRequest<IDBValidKey> | Promise<void>}
     */
    put(resource, params) {
        this.setHeader();

        return Vue.axios.post(`${resource}`, params)
            .then((result) => {
                store.dispatch(MESSAGE, { message: result.data.message, color: result.status ? 'green' : 'red' });
                console.log("PUT RESPONSE", result);
                return result;

            }).catch((err) => {
                if (err.response.status == 401) {
                    store.dispatch(LOGOUT).then(() => router.push({ name: "login" }));
                    console.log("LOGOUT");
                }
                console.log("ERROR RESPONSE", err.response);
                console.log("ERROR STATUS", err.response.status);
                return err.response;
            });
    },

    /**
     * Send the DELETE HTTP request
     * @param resource
     * @returns {*}
     */
    delete(resource) {
        this.setHeader();

        return Vue.axios.delete(`${resource}`)
            .then((result) => {
                store.dispatch(MESSAGE, { message: result.data.message, color: result.status ? 'green' : 'red' });
                console.log("DELETE RESPONSE", result);
                return result;

            }).catch((err) => {
                if (err.response.status == 401) {
                    store.dispatch(LOGOUT).then(() => router.push({ name: "login" }));
                    console.log("LOGOUT");
                }
                console.log("ERROR RESPONSE", err.response);
                console.log("ERROR STATUS", err.response.status);
                return err.response;
            });

    }
};

export default ApiService;
