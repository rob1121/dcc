@if($show)
    <form>
        <div class="form-group">
            <label for=""> Search:
                <input type="text"
                       class="form-control"
                       placeholder="&#128270;"
                       v-model="searchKeyword"
                       name="search-field"
                       id="search-field"
                       @keyup.enter="displaySearchResult"
                >
                <span class="clear-btn" v-if="searchKeyword" @click="clearSearchInput">&times;</span>
            </label>
            <button @click.prevent="displaySearchResult"
                    class="btn btn-default btn-search"
                    name="search-field-submit"
            >
                Search
            </button>
        </div>
    </form>
@endif