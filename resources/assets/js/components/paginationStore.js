const state =  {
    pagination: []
}

const mutations = {
    GET_DATA (state, data) {
        state.pagination = data;
    },

    ADD_DATA (state, data) {
        state.pagination.push(data);
    },

    ERROR_MESSAGE() {
        return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
    }
}

export default {
    state, mutations
}

