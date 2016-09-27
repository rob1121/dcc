<template>
    <div class="modal fade" tabindex="-1" id="{{id}}">
        <div class="modal-dialog modal-{{size}}">
            <div class="modal-content">
                <div class="modal-header bg-{{classType}}">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{title}}</h4>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer" v-if="hasFooter">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>
<style>
    .close {
        font-size: 3em;
    }
</style>
<script>
    export default{
        props: {
            id:{default:"modal-id"},
            title:{default:"modal-title"},
            hasFooter:{default:false},
            size:{default:"lg"},
            classType:{default:"default"}
        }
    }
</script>
