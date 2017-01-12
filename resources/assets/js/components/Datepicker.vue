<template>
    <div>
        <datepicker input-class="form-control input-sm"
                    :value="value"
                    :name="name"
                    format="yyyy-MM-dd">
        </datepicker>
        
        <h6 class="help-block">{{error}}</h6>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },

        props: ['error','value','name']
    }
</script>