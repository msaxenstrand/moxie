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
                        <b-form @submit.prevent="onSubmit" v-if="show" enctype="multipart/form-data" ref="form">
                            <b-form-group id="input-group-type" label="Dokumenttyp" label-for="type">
                                <b-form-select
                                        id="document_type"
                                        v-model="form.document_type_id"
                                        :options="documentTypes"
                                        value-field="id"
                                        text-field="name"
                                        required
                                ></b-form-select>
                            </b-form-group>

                            <b-form-group
                                    id="input-group-title"
                                    label="Titel"
                                    label-for="title"
                            >
                                <b-form-input
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        required
                                        placeholder="Titel"
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group
                                    id="input-group-description"
                                    label="Beskrivning"
                                    label-for="description"
                            >
                                <b-form-textarea
                                        id="description"
                                        v-model="form.description"
                                        type="textarea"
                                        placeholder="Beskrivning"
                                ></b-form-textarea>
                            </b-form-group>

                            <b-form-group
                                    id="input-group-file"
                                    label="Fil"
                                    label-for="file"
                            >
                                <b-form-file
                                        id="document"
                                        name="document"
                                        v-model="form.document"
                                        placeholder="Välj en fil eller dra och släpp den här..."
                                        drop-placeholder="Släpp filen här..."
                                        required
                                ></b-form-file>
                            </b-form-group>

                            <b-button type="submit" variant="primary">Submit</b-button>
                            <b-button type="reset" variant="danger">Reset</b-button>
                        </b-form>
                    </b-collapse>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <documents-table></documents-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
  import AppLayout from './../Layouts/AppLayout';
  import DocumentsTable from './../Components/DocumentsTable';

  export default {
    components: {
      AppLayout,
      DocumentsTable,
    },

    props: ['documentTypes'],

    data() {
      return {
        form: {},
        isOpen: true,
        show: true
      };
    },

    mounted() {

    },

    methods: {
      handleBtnClick: function() {
        this.isOpen = !this.isOpen;
      },

      onSubmit() {
        const data = new FormData();
        const { document_type_id, title, description, document} = this.form
        data.append('document_type_id', document_type_id)
        data.append('title', title)
        data.append('description', description)
        data.append('document', document)
        this.$inertia.post('/documents', data)
            .then(() => {
              this.onReset()
        })
      },
      onReset(evt) {
        evt && evt.preventDefault();
        // Reset our form values
        this.form.document_type_id = null;
        this.form.title = '';
        this.form.description = '';
        this.form.document = null;
        // Trick to reset/clear native browser form validation state
        this.show = false;
        this.$nextTick(() => {
          this.show = true;
        });
      },
    },
  };
</script>

<style scoped>

</style>
