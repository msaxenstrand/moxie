<template>
    <b-container class="py-5">
        <b-row>
            <b-col :key="year" xs="12" md="6" v-for="(docs, year) in documents" class="mb-3">
                <h4 class="ml-2">{{ year }}</h4>
                <div class="document-wrapper d-flex" v-for="document in docs">
                  <div class="d-flex">
                    <i class="fas fa-2x" :class="document.mime_type === 'application/pdf' ? 'fa-file-pdf' : 'fa-file-alt'" />
                    <div class="pl-2">
                      <a :key="document.id" :href="`/documents/${document.id}`" :download="document.file_name">{{ document.title }}</a>
                      <div class="font-italic">{{ document.document_type.name }}</div>
                    </div>
                  </div>
                  <a class="download" :key="document.id" :href="`/documents/${document.id}`" :download="document.file_name">
                    <i class="fas fa-download" />
                  </a>
                </div>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
  export default {
    name: 'Home',

    props: ['documents']
  };
</script>
