<template>
    <div :class="['form-group',{'has-error' : error }, 'col-sm-'+col]">
        <label class="control-label">{{label ? label : name |capitalize}}</label>
        <input type="{{type}}"
               class="form-control input-sm"
               v-model="value"
               name="{{name}}"
               id="{{name}}"
               :list="list"
               readonly="{{readOnly}}"
        >
        <h6 class="help-block" v-show="error">{{error}}</h6>
    </div>
</template>
<script>
    export default {
        props: {
            name:{default:""},
            value:{default:""},
            type:{default:"text"},
            error:{default:""},
            label:{default:""},
            col:{default:"12"},
            readOnly:{default:false},
            list:{default:""}
        }
    }
</script>
