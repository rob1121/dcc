export const getData = function(store, url, num, category) {

    this.$http.get(url, { params: { page:num, category: category } })
        .then(
            (response) => {
                var dispatch = store.dispatch;
                dispatch('GET_DATA', response.json());
            }).catch((response) => {
                console.log('Error', response);
            });
}