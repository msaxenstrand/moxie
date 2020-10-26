<template>
    <b-container class="py-5">
        <b-row>
            <b-col :key="year" xs="12" md="6" v-for="(docs, year) in documents" class="mb-3">
                <h4>{{ year }}</h4>
                <div class="document-wrapper d-flex" v-for="document in docs">
                    <i class="fas fa-file-alt fa-2x" />
                    <div class="pl-2">
                        <a :key="document.id" :href="`/documents/${document.id}`" :download="document.file_name">{{ document.title }}</a>
                        <div class="font-italic">{{ document.document_type.name }}</div>
                    </div>
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
