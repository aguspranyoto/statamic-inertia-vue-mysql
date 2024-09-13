<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import ModalComponent from "../../components/Modal.vue";
import TableMahasiswaComponent from "../../components/TableMahasiswa.vue";
import Form from "../../components/Form.vue";

const toast = useToast();

defineProps({
    mahasiswas: {
        type: Object,
        required: true,
    },
    matkuls: {
        type: Object,
        required: true,
    },
});

const modal = ref({
    open: false,
    type: "",
    item: {
        id: "",
        title: "",
        matkuls: [],
    },
});
const deleteConfirm = ref(false);

const showItem = (item) => {
    modal.value = {};
    modal.value = {
        open: true,
        type: "show",
        id: item.id,
        title: item.title,
        matkuls: item.matkuls,
    };
};

const editItem = (item) => {
    console.log(item);
};

const deleteItem = (item) => {
    modal.value = {};
    modal.value = {
        open: true,
        type: "delete",
        id: item.id,
        title: item.title,
        matkuls: item.matkuls,
    };

    watch(deleteConfirm, () => {
        if (deleteConfirm.value) {
            router.delete(`/delete/${item.id}`, {
                onSuccess: () => {
                    modal.value.open = false;
                    deleteConfirm.value = false;
                    toast.success("Mahasiswa deleted successfully", {
                        timeout: 2000,
                    });
                },
                onError: () => {},
            });
        }
    });
};
</script>

<template>
    <div
        class="max-w-4xl xl:max-w-5xl 2xl:max-w-7xl mx-auto px-6 sm:px-8 lg:px-0 py-20"
    >
        <div class="grid grid-cols-2 gap-10">
            <div class="w-full">
                <Form :matkulsOptions="matkuls" />
            </div>
            <div class="w-full">
                <TableMahasiswaComponent
                    :mahasiswas="mahasiswas"
                    :showItem="showItem"
                    :editItem="editItem"
                    :deleteItem="deleteItem"
                />
            </div>
        </div>
        <ModalComponent
            :modal="modal"
            @update:deleteConfirm="deleteConfirm = $event"
        />
    </div>
</template>
