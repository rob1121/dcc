<template>
    <div class="modal fade" tabindex="-1" :id="id">
        <div :class="'modal-dialog modal-' + size">
            <div class="modal-content">
                <div :class="'modal-header bg-' + classType">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{title}}</h4>
                </div>
                <div :class="['modal-body' ,{'modal-scroll' : scroll === 'on'}]">
                    <slot></slot>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>
<style>
    .close {
        font-size: 3em;
    }

    .modal {
        overflow-y: auto;
    }

    .modal-scroll {
        height: 80vh;
        overflow-y: auto;
    }
</style>
<script>
    export default {

        props: {
            id:{default:"modal-id"},
            title:{default:"modal-title"},
            size:{default:"lg"},
            classType:{default:"default"},
            scroll:{default:"off"}
        }
    }
</script>
