<template>
    <div>
        <b-table striped hover :items="items" :fields="fields" responsive="sm">
            <template v-slot:cell(size)="data">
                {{ getSizeString(data.item.size) }}
            </template>
            <template v-slot:cell(created_at)="data">
                {{ getFormattedDate(data.item.created_at) }}
            </template>
            <template v-slot:cell(actions)="data">
                <div class="actions flex justify-end">
                    <font-awesome-icon icon="edit" class="mr-2" v-b-modal.modal-1 @click="onEdit(data.item)"></font-awesome-icon>
                    <font-awesome-icon icon="trash-alt" @click.prevent="handleDelete(data.item.id)"></font-awesome-icon>
                </div>
            </template>
        </b-table>
    </div>
</template>

<script>
  import { formatBytes } from '../app'
  import dayjs from 'dayjs'
  import DocumentForm from './DocumentForm'

  export default {
    name: 'DocumentsTable',
    components: {DocumentForm},
    props: ['documents', 'onEdit'],

    data() {
      return {
        fields: [
          {
            key: 'title',
            label: 'Namn',
            sortable: true
          },
          {
            key: 'document_type.name',
            label: 'Dokumenttyp',
            sortable: true
          },
          {
            key: 'file_name',
            label: 'Filnamn',
            sortable: true
          },
          {
            key: 'year',
            label: 'År',
            sortable: true
          },
          {
            key: 'size',
            label: 'Storlek',
            sortable: true
          },
          {
            key: 'created_at',
            label: 'Uppladdad',
            sortable: true,
          },
          'actions'
        ],
        items: this.documents
      }
    },

    methods: {
        getSizeString(size) {
          return formatBytes(size)
        },

        getFormattedDate(date) {
          return dayjs(date).format('YYYY-MM-DD HH:mm')
        },

        handleDelete(documentId) {
          axios.delete(`/documents/${documentId}`)
            .then(() => {
              this.items = _.filter(this.items, item => item.id !== documentId)
          })
        },
    },

    watch: {
        documents(newValue) {
          this.items = newValue
        }
    }
  };
</script>

<style scoped>

</style>
