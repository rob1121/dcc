@if($show)
    <form>
        <div class="input-group" style="padding-right: 10px">
            <input type="text"
                   class="form-control"
                   placeholder="&#128270; Look for..."
                   v-model="searchKeyword"
                   name="search-field"
                   id="search-field"
                   @keyup.enter="displaySearchResult"
            >

            <span class="clear-btn" v-if="searchKeyword" @click="clearSearchInput">&times;</span>

            <span class="input-group-btn">
            <button @click.prevent="displaySearchResult"
                    class="btn btn-default btn-search"
                    name="search-field-submit"
            >
                Search
            </button>
        </span>
        </div>
    </form>
@endif