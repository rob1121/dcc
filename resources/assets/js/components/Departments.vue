<template>
    <div>
        <input type="text" class="form-control" v-model="query"> {{text}}

        <datalist id="departments" @enter>
            <option v-for="option in options" :value="option">
        </datalist>
        {{selected}}
        {{query}}
        <button @click.prevent="try123()">click me</button>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                query: null,
                text: null,
                selected: []
            }
        },
        mounted() {
            this.$on('test', _.debounce(function (msg) {
                this.searchQuery(msg);
            },1000))
        },

        watch: {
            query() {
                this.$emit('test', this.query);
                this.text = 'typing...';
            }
        },

        props: ['options'],

        methods: {
            searchQuery(msg) {
                this.text="seraching...";
                setTimeout(function() {
                    this.text=null
                }, 1000);

            }
        }
    }
</script>