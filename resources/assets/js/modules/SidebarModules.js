
const searchKey =  "";
const searchCategoryKey =  null;
const activeCategory =  "";

const setActiveCategory = function(category_no) {
    this.activeCategory = category_no;
    this.setSearchCategoryKey(category_no);
    this.emptySearchKey();
};

const setSearchCategoryKey = function(category_no) {
    this.searchCategoryKey = category_no;
};

const emptySearchKey = function() {
    this.searchKey= '';
};

export {
    setActiveCategory,
    setSearchCategoryKey,
    emptySearchKey,
    searchKey,
    searchCategoryKey,
    activeCategory
}