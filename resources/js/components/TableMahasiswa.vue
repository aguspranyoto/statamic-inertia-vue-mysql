<script setup>
import { defineProps, ref } from "vue";

const props = defineProps({
    mahasiswas: {
        type: Object,
        required: true,
    },
    showItem: {
        type: Function,
        required: true,
    },
    editItem: {
        type: Function,
        required: true,
    },
    deleteItem: {
        type: Function,
        required: true,
    },
});

const headers = ref([
    {
        title: "Nama Mahasiswa",
        align: "start",
        sortable: true,
        key: "title",
    },
    { title: "Mata Kuliah", key: "matkuls" },
    { title: "Actions", key: "actions", sortable: false },
]);
</script>
<template>
    <v-data-table
        :headers="headers"
        :items="mahasiswas"
        :items-per-page="5"
        class="elevation-1"
    >
        <template v-slot:item.matkuls="{ item }">
            {{ item.matkuls.map((matkul) => matkul.title).join(", ") }}
        </template>
        <template v-slot:item.actions="{ item }">
            <v-btn small color="primary" class="mr-2" @click="showItem(item)">
                Show
            </v-btn>
            <v-btn small color="warning" class="mr-2" @click="editItem(item)">
                Edit
            </v-btn>
            <v-btn small color="error" @click="deleteItem(item)">
                Delete
            </v-btn>
        </template>
    </v-data-table>
</template>
