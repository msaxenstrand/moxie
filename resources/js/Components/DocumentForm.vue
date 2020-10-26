<template>
    <b-form @submit.prevent="onSubmit" v-if="show" ref="form">
        <b-form-group id="input-group-type" label="Dokumenttyp" label-for="type">
            <v-select
                    :options="documentTypes"
                    v-model="form.document_type"
                    label="name"
                    placeholder="Välj typ av dokument eller skriv in en ny typ och tryck Enter"
                    taggable
                    searchable
            >
                <template #search="{attributes, events}">
                    <input
                            class="vs__search"
                            :required="!form.document_type"
                            v-bind="attributes"
                            v-on="events"
                    />
                </template>
            </v-select>
        </b-form-group>

        <b-form-group
                id="input-group-year"
                label="År"
                label-for="year"
        >
            <b-form-select
                    v-model="form.year"
                    :options="yearOptions"
                    size="sm">
            </b-form-select>
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

        <div v-if="model && model.file_name">
            {{ model.file_name }}
            <font-awesome-icon icon="times" @click="model.file_name = null" />
        </div>

        <b-form-group
                id="input-group-file"
                label="Fil"
                label-for="file"
                v-else
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
        <b-button v-if="!model" type="reset" variant="danger">Reset</b-button>
    </b-form>
</template>

<script>
  export default {
    name: 'DocumentForm',

    props: ['documentTypes', 'itemsCallback', 'model'],

    data() {
      return {
        form: this.model ? {...this.model} : {
          year: '2020/2021'
        },
        show: true,
        yearOptions: [
          { value: '2017/2018', text: '2017/2018' },
          { value: '2018/2019', text: '2018/2019' },
          { value: '2019/2020', text: '2019/2020' },
          { value: '2020/2021', text: '2020/2021' }
        ]
      }
    },

    methods: {
      onSubmit() {
        const data = new FormData();
        const { document_type, title, description, document, year } = this.form
        data.append('document_type', JSON.stringify(document_type))
        data.append('title', title)
        data.append('description', description || '')
        data.append('document', document)
        data.append('year', year)
        this.model && data.append("_method", "put")

        axios({
          method: 'post',
          url: this.model ? `/documents/${this.form.id}` : '/documents',
          data,
          headers: {'Content-Type': 'multipart/form-data' }
        })
        .then(response => {
          this.itemsCallback(response.data, this.model ? 'updated' : 'created')
          this.onReset()
          this.$bvModal.hide('modal-1')
        })
      },
      onReset(evt) {
        evt && evt.preventDefault();
        // Reset our form values
        this.form.document_type = null;
        this.form.title = '';
        this.form.description = '';
        this.form.document = null;
        // Trick to reset/clear native browser form validation state
        this.show = false;
        this.$nextTick(() => {
          this.show = true;
        });
      },
    }
  };
</script>

<style scoped>

</style>
