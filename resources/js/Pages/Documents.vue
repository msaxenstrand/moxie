<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dokument
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end">
                    <b-button
                            :variant="isOpen ? 'danger' : 'outline-primary'"
                            @click="isOpen = !isOpen"
                    >
                        <font-awesome-icon :icon="isOpen ? 'times' : 'file'"/>
                        {{ isOpen ? 'Stäng' : 'Nytt dokument' }}
                    </b-button>
                </div>
                <div class="mb-4">
                    <b-collapse id="collapse-1" class="mt-2" v-model="isOpen">
                        <div v-if="isOpen">
                            <document-form :document-types="documentTypeItems" :items-callback="updateItems"></document-form>
                        </div>
                    </b-collapse>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <documents-table :documents="items" :on-edit="handleEdit"></documents-table>
                </div>
            </div>
        </div>
        <b-modal id="modal-1" title="Redigera dokument" hide-footer>
            <document-form :document-types="documentTypeItems" :items-callback="updateItems" :model="editModel"></document-form>
        </b-modal>
    </app-layout>
</template>

<script>
  import AppLayout from './../Layouts/AppLayout';
  import DocumentsTable from './../Components/DocumentsTable';
  import DocumentForm from '../Components/DocumentForm';

  export default {
    components: {
      AppLayout,
      DocumentsTable,
      DocumentForm
    },

    props: ['documents', 'documentTypes'],

    data() {
      return {
        isOpen: false,
        items: this.documents,
        documentTypeItems: this.documentTypes,
        editModel: null
      };
    },

    mounted() {

    },

    methods: {
      handleBtnClick: function() {
        this.isOpen = !this.isOpen;
      },

      handleEdit: function(document) {
        this.editModel = document
      },

      updateItems: function() {
        axios.get('/documents')
            .then(response => response.data)
            .then(data => {
              this.items = data
        })

        axios.get('/document-types')
        .then(response => response.data)
        .then(data => {
          this.documentTypeItems = data
        })
      }
    },
  };
</script>

<style scoped>

</style>
