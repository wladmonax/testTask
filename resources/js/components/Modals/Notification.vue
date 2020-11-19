<template>
    <modal name="notificationModal"
           @before-close="beforeClose"
           :height="'auto'"
           :pivotX="0.7"
           :pivotY="1"
           :scrollable="true"
           :styles="'margin-top: 133px;'"
           :draggable="true">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ title }}</h5>
                <button type="button" class="close" @click="closeModal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" v-if="editingNotification">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Title</span>
                    </div>
                    <input
                        class="form-control"
                        type="text"
                        v-validate="'required'"
                        placeholder="title"
                        name="title"
                        v-model="editingNotification.title">
                </div>
                <div class="error">
                    <span>{{ errors.first('title') }}</span>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Description</span>
                    </div>
                    <textarea
                        class="form-control"
                        v-validate="'required'"
                        placeholder="description"
                        name="description"
                        v-model="editingNotification.description">
                    </textarea>
                </div>
                <div class="error">
                    <span>{{ errors.first('description') }}</span>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Image</span>
                    </div>
                    <input
                        type="file"
                        class="form-control"
                        name="image"
                        ref="file" v-on:change="handleFileUpload()"
                    >
                </div>
                <div class="error">
                    <span>{{ errors.first('image') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-primary"
                    :disabled="errors.items.length > 0"
                    @click="save">Save
                </button>
                <button type="button" class="btn btn-secondary" @click="closeModal">Close
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
import axios from 'axios'

export default {
    name: 'Notification',
    props: {
        notification: {
            required: false,
            type: Object | null
        },
        isShown: {
            required: true,
            type: Boolean
        }
    },
    components: {},
    data () {
        return {
            title: 'Create notification',
            file: null,
            editingNotification: {
                title: '',
                description: '',
                image: null
            }
        }
    },
    methods: {
        handleFileUpload () {
            this.file = this.$refs.file.files[0]
        },
        beforeClose (event) {
            this.closeModal()
        },
        closeModal () {
            this.$emit('clearNotificationModal')
        },
        save () {
            this.$validator.validate().then(valid => {
                if (!valid) {
                    // do stuff if not valid.
                } else {
                    let formData = new FormData()
                    formData.append('image', this.file)
                    formData.append('title', this.editingNotification.title);
                    formData.append('description', this.editingNotification.description);

                    axios.post(`/api/notifications`,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then( () => {
                        this.file =  null;
                        this.$emit('notificationWasSaved')
                    })

                }
            })
        }
    },
    created () {

    },
    mounted () {
    },
    watch: {
        isShown: function () {
            if (this.isShown === true) {
                Object.assign(this.editingNotification, this.notification)
                this.$modal.show('notificationModal')
            } else {
                this.file =  null;
                this.editingNotification = {
                    title: '',
                    description: '',
                    image: null
                }
                this.$modal.hide('notificationModal')
            }
        }
    }
}
</script>

<style scoped>

</style>
