const search = function(table, keyword = "")
{
    if(keyword === "") return false;
    var search_route = laroute.route("search");
    this.$http.get(search_route, {
        params: { table: table, q: keyword}
    }).then(
        response => this.pagination = response.json(),
        () => this.errorDialogMessage()
    );
};

export {
    search
}