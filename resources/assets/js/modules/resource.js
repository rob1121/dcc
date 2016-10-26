const fetchData = function(pagination_url, category)
{
    this.$http.get(pagination_url, {
        params: { category: category }
    }).then(
        response => this.pagination = response.json(),
        () => this.errorDialogMessage()
    );
};

const deletes = function(collection, spec)
{
    var index = collection.indexOf(spec);
    collection.splice(index, 1)
};

const deleteData = function(spec)
{
    this.$http.delete(spec.internal_destroy).then(
            () => this.deletes(this.pagination, spec),
            () => this.errorDialogMessage()
        );
};
export {
    fetchData, deleteData
}