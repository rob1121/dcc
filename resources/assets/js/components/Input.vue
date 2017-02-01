<template>
    <div :class="['form-group', 'col-sm-'+col, {'has-error' : error }]">
        <label class="control-label">{{capitalize(label ? label : name)}}</label>
        <input :type="type"
               class="form-control input-sm"
               autocomplete="off"
               :value="value"
               :name="name"
               :id="name"
               :list="list"
               :readonly="readOnly"
        >
        <h6 class="help-block" v-if="error">{{error}}</h6>
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
      },

        methods: {
          capitalize(string) {
              return _.capitalize(string);
          }
        }
  }
</script>
