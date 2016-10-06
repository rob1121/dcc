<template>
    <div class="col-sm-12">
        <button type="submit" :class="'btn btn-' + btnType + ' pull-right'">
            <slot></slot>
            <i class="fa fa-{{icon}} v-if="icon"></i>
        </button>
    </div>
</template>

<script>
    export default{
        props:{
            icon:{default:""},
            name:{default:""},
            btnType:{default:"primary"}
        }
    }
</script>
