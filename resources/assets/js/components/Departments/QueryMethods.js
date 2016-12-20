/**
 * search query from database
 * @success get result data
 * @failed  console log the error
 */

const fetchQuery = function(q) {
    const departmentList = laroute.route('department.list');
    const params = { q };

    this.$http
        .get( departmentList , { params } )
        .then( response => {
            this.setResult( response.data );
            this.checkToShowAddButton();
        }, error => console.log(error) );
};

/**
 * @set querying status
 * @param status
 */
const queryStatus = function(status=null) {
    this.text = this.isSuccess(status) || _.isEmpty(status)
        ? null : `${status}...`
};

/**
 * check if fetchQuery() success
 * @param status
 * @returns {boolean}
 */
const isSuccess = function(status) {
    return status === 'success';
};

/**
 * @set search query
 * @param inputQuery
 */
const setQuery = function(inputQuery=null) {
    this.query = inputQuery;
};

/**
 * validate input query
 * @returns {boolean}
 */
const isQueryValid = function() {
    return ! _.isEmpty( this.query )
};



const hasQuery = function() {
    return ! _.isEmpty( this.query );
};

const hasQueryText = function() {
    return ! _.isEmpty( this.text );
};


/**
 * @true search query from database
 * @else show add button
 */
const getResults = function() {
    if(this.isQueryValid()) {
        this.queryStatus('searching');
        this.fetchQuery( this.query );
    }
    else {
        this.hideResultsContainer();
        this.checkToShowAddButton();
    }
};

export {
    setQuery, fetchQuery, queryStatus, isSuccess, isQueryValid, hasQuery, hasQueryText, getResults
}