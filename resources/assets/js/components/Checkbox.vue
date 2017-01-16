<template>
    <div>
        <label class="control-label">
            <input type="hidden"
                   :value="checked"
                   :name="name"
                   :id="name">

            <input type="checkbox"
                   v-model="checked"
                   :true-value="true"
                   :false-value="false"
                   hidden>
            <i :class="'fa fa-toggle-' + toggle + ' fa-2x'"></i>
            {{label}}
        </label>
    </div>
</template>

<style>
    .fa-toggle-on {
        color: green;
    }
</style>

<script>
    export default{
        data() {
            return {
                checked: true,
                toggle: "on"
            }
        },

        props:{
            name:{default:"checkbox"},
            value:{default:""},
            init:{default:false},
            label:{default:""}
        },

        created() {
             const checked = this.hasInitialInput()
                 ? JSON.parse(this.init)
                 : this.value;

            this.setChecked(checked);
        },

        watch:{
            checked() {
                this.toggleCheckBox(this.checked);
                this.$emit('input', this.checked);
            }
        },

        methods: {
            toggleCheckBox(checked) {
                this.toggle = checked  ? "on" : "off";
            },

            setChecked(checked) {
                this.checked = checked;
            },

            hasInitialInput() {
                return this.init !== "";
            }
        }
    }
</script>