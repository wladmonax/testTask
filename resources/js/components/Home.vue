<template>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col mt-5">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Hello!</h4>
                        <p>Welcome to my notifications site! =) </p>
                        <hr>
                        <p class="mb-0">Any updates? Just click button!  &#8595;&#8595;&#8595;</p>
                    </div>
                    <button @click="showNotification" type="button" class="btn btn-outline-success">Click</button>
                </div>
            </div>
            <div class="row">
                <div class="col mt-5">
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        @on-row-click="onRowClick"
                        :pagination-options="{
                            enabled: true,
                            mode: 'records',
                            perPage: 3,
                            position: 'top',
                            perPageDropdown: [3, 7, 9],
                            dropdownAllowAll: false,
                            setCurrentPage: 2,
                            nextLabel: 'next',
                            prevLabel: 'prev',
                            rowsPerPageLabel: 'Rows per page',
                            ofLabel: 'of',
                            pageLabel: 'page',
                            allLabel: 'All',
                        }"
                    />
                    <small>*click to the row to delete it</small>
                </div>
            </div>
        </div>
        <delete-modal :is-shown="deleteModal.isShown"
                      :title="deleteModal.title"
                      :message="deleteModal.message"
                      @confirmDeleteModal="confirmDeleteModal"
                      @cancelDelete="cancelDelete"
        ></delete-modal>
        <Notification
            :is-shown="showNotificationModal"
            :notification="editingNotification"
            @notificationWasSaved="notificationWasSaved"
            @clearNotificationModal="clearNotificationModal"
        ></Notification>
    </div>
</template>

<script>
import DeleteModal from './Modals/DeleteModal'
import Notification from './Modals/Notification'
import axios from 'axios'

export default {
    name: 'Home',
    props: {
        notes: {
            required: true,
            type: Array
        }
    },
    components: {
        DeleteModal,
        Notification
    },
    data () {
        return {
            editingNotification:{},
            showNotificationModal: false,
            deleteModal: {
                isShown: false,
                title: '',
                message: '',
                deletingId:null
            },
            rows: [],
            columns: [
                {
                    label: 'Id',
                    field: 'id'
                },
                {
                    label: 'Title',
                    field: 'title'
                },
                {
                    label: 'Description',
                    field: 'description',
                    sortable: false
                },
                {
                    label: 'Image',
                    field: 'image',
                    html: true,
                    sortable: false
                }
            ]
        }
    },
    methods: {
        showNotification(){
            this.showNotificationModal = true;
        },
        clearNotificationModal(){
            this.showNotificationModal = false;
        },
        notificationWasSaved(){
            this.showNotificationModal = false;
            this.updateData()
        },
        onRowClick (params) {
            this.deleteModal.isShown = true
            this.deleteModal.title = 'Delete item'
            this.deleteModal.message = 'Do you really wont to delete this item?'
            this.deleteModal.deletingId = params.row.id
        },
        updateData () {
            axios.get(`/api/notifications`
            ).then( (result) => {
                this.rows = result.data.data.map(element => ({
                    ...element,
                    image: `<img width="80" height="80" src="${element.image}"/>`
                }));
            })
        },
        cancelDelete () {
            this.deleteModal.isShown = false
            this.deleteModal.title = ''
            this.deleteModal.message = ''
        },
        confirmDeleteModal () {
            axios.delete(`/api/notifications/${this.deleteModal.deletingId}`
            ).then( (result) => {
                this.updateData();
            })
            this.deleteModal.isShown = false
            this.deleteModal.title = ''
            this.deleteModal.message = ''
        },
        prepareData () {
            this.rows = this.notes.map(element => ({
                ...element,
                image: `<img width="80" height="80" src="${element.image}"/>`
            }))
        }
    },
    created () {

    },
    mounted () {
        this.prepareData()
    }
}
</script>

<style scoped>

</style>
