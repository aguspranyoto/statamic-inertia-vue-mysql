<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    modal: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["update:deleteConfirm"]);
</script>

<template>
    <v-dialog v-model="props.modal.open" width="auto">
        <v-card
            max-width="400"
            prepend-icon="mdi-cat"
            :title="
                props.modal.type == 'delete'
                    ? 'Hapus data mahasiswa'
                    : 'Detail mahasiswa'
            "
        >
            <template v-if="props.modal.type === 'show'" v-slot:text>
                <div>Id: {{ props.modal.id }}</div>
                <div>Nama: {{ props.modal.title }}</div>
                <div>
                    Mata kuliah:
                    {{
                        props.modal.matkuls
                            .map((matkul) => matkul.title)
                            .join(", ")
                    }}
                </div>
            </template>
            <template v-if="props.modal.type === 'delete'" v-slot:text>
                <div>
                    Apa kamu yakin ingin menhapus data id
                    {{ props.modal.id }}?
                </div>
            </template>
            <template v-slot:actions>
                <v-btn
                    class="ms-auto"
                    text="Close"
                    @click="props.modal.open = false"
                ></v-btn>
                <v-btn
                    v-if="props.modal.type === 'delete'"
                    text="Delete"
                    @click="$emit('update:deleteConfirm', true)"
                ></v-btn>
            </template>
        </v-card>
    </v-dialog>
</template>
