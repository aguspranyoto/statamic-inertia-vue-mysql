<script setup>
import { defineProps, ref } from "vue";
import { useForm as useVeeForm, useField } from "vee-validate";
import { useForm as useInertiaForm } from "@inertiajs/vue3";
import * as yup from "yup";

defineProps({
    matkulsOptions: {
        type: Object,
        required: true,
    },
});

const schema = yup.object({
    name: yup
        .string()
        .required("Name is required")
        .min(3, "Name must be at least 3 characters long"),
    matkuls: yup
        .array()
        .min(1, "At least one matkul must be selected")
        .required("Matkuls is required"),
});

const { handleSubmit, errors } = useVeeForm({
    validationSchema: schema,
});

const { value: name } = useField("name");
const { value: matkuls } = useField("matkuls");

const inertiaForm = useInertiaForm({
    name: "",
    matkuls: [],
});

const onSubmit = handleSubmit((values) => {
    inertiaForm.name = values.name;
    inertiaForm.matkuls = values.matkuls;
    console.log(values.matkuls);

    inertiaForm.post("/store-mahasiswa", {
        preserveScroll: true,
        onSuccess: () => {
            // Reset form setelah berhasil
            name.value = "";
            matkuls.value = [];
            inertiaForm.reset();
        },
    });
});
</script>

<template>
    <v-form @submit.prevent="onSubmit">
        <v-text-field
            v-model="name"
            label="Name"
            :error-messages="errors.name"
            required
        ></v-text-field>

        <v-select
            v-model="matkuls"
            label="Matkuls"
            :items="matkulsOptions"
            :error-messages="errors.matkuls"
            multiple
            required
        ></v-select>

        <v-btn color="primary" type="submit" :loading="inertiaForm.processing">
            Submit
        </v-btn>
    </v-form>
</template>
