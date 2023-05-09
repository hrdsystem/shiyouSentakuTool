import Vue from 'vue';
import Vuex from 'vuex';
import VuePersist from 'vuex-persistedstate';

// Vue.use(Vuex)
// export default new Vuex.Store({
//     state:{},
//     actions:{}, 
//     mutations:{},
//     getters:{},
//     plugins: [createPersistedState()]
// });

Vue.use(Vuex)
const createPersistedState = new VuePersist({
    key:'ShioSentakuTool',
    storage: localStorage,
    reducer : state => ({
        item2List : state.item2List
    })

})
export default new Vuex.Store({
    
    state : {
        item2List : []
    },

    actions:{
        getItem2List({commit}, data){
            console.log(data,'getItem2List')
            commit("getItem2List", data)
        }
    },

    mutations:{
        getItem2List(state,payload){
           state.item2List = payload 
        }
    },

    plugins: [createPersistedState]
})