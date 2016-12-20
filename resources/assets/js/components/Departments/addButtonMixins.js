export default {
    data() {
        return {
            showAddButton: false,
        }
    },

    methods: {
        /**
         * show add button if no result found for inputted query
         */
        checkToShowAddButton() {
            const hasResult = this.hasQuery && (! this.hasUsers && ! this.hasDepartment);

            this.setShowAddButton( hasResult );
        },

        /**
         * condition whether to show or hide plus button
         * @param bool
         */
        setShowAddButton(bool) {
            this.showAddButton = bool;
        },
    }
}