<template>
    <div :class="['form-group',{'has-error' : error }, 'col-sm-'+col]">
        <label class="control-label">{{label ? label : capitalize(name)}}</label>
        <textarea rows="5"
                  cols="30"
                  class="form-control"
                  :name="name"
                  :id="name"
                  v-model="value"
        ></textarea>
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
            col:{default:"12"}
        },

        methods: {
          capitalize(string) {
              return _.capitalize(string);
          },
        }
    }
</script>
