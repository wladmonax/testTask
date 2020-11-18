<template>
    <modal name="deleteModal" :height="'auto'" :pivotX="0.7">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-html="title"></h5>
                <button type="button" class="close" @click="closeDeleteModal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="word-break: break-all;" v-html="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeDeleteModal">Cancel
                </button>
                <button type="button" class="btn btn-danger" @click="confirmDeleteModal">Delete
                </button>
            </div>

        </div>
    </modal>
</template>

<script>
export default {
    name: 'DeleteModal',
    props: {
        isShown: {
            required: true,
            type: Boolean
        },
        title: {
            required: true,
            type: String
        },
        message: {
            required: true,
            type: String
        }
    },
    components: {},
    data () {
        return {}
    },
    methods: {
        closeDeleteModal () {
            this.$emit('cancelDelete')
        },
        confirmDeleteModal () {
            this.$emit('confirmDeleteModal')
        }
    },
    watch: {
        isShown: function () {
            if (this.isShown === true) {
                this.$modal.show('deleteModal')
            } else {
                this.$modal.hide('deleteModal')
            }
        }
    }
}
</script>

<style scoped>

</style>
