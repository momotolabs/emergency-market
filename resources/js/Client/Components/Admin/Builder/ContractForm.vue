<script setup>
import { computed, reactive, ref } from "vue";
import {
  Input,
  Button,
  Label,
  ErrorValidation,
} from "@/Client/Components/Form";
import { ContractContent } from "@/Client/Components/Shared/Contract";
import { ContractEditor } from "@/Client/Components/Admin/Builder";
import { useForm } from "@inertiajs/inertia-vue3";
import { useVuelidate } from "@vuelidate/core";
import { required, requiredIf } from "@vuelidate/validators";
import { Inertia } from "@inertiajs/inertia";



const props = defineProps({
  errors: Object,
  edit: false,
  contract: [Object, null],
  validations: [Object, null],
  loaderMain:false
});

const formState = useForm({
  name: props.contract !== null ? props.contract?.name : "",
  content: props.contract !== null ? props.contract?.content : "",
});



const rules = computed(() => ({
  name: { required },
  content: {
    required
  },
}));

const $externalResults = ref(props.validations);

const v$ = useVuelidate(rules, formState, { $externalResults });

const emits = defineEmits(["submit"]);

const disponiblesValues = {
  first_name: "First name",
  last_name: "Last name",
  address: "Address",
  phone_number: "Phone number",
  insurance_company: "Insurance company",
  claim_number: "Claim number",
  email: "Email",
  date: "Date Signed",
};

const inputIndex = ref(0);
const inputCreator = () => {
  const inputString = `<input type="text" id="data${inputIndex.value}" />`;
  return inputString;
};

const stringFormat = computed(() => {
  return formState.content
    .replaceAll("[initials]", () => {
      inputIndex.value++;
      return inputCreator();
    })
    .format(disponiblesValues);
});

const errorss = reactive({
  content: null,
});

const save = async () => {
  const validate = await v$.value.$validate();
  if (!validate) {
    return;
  }

  emits("submit", formState);
};

const goBack = () => {
  Inertia.visit(route('dashboard.builder.index'));
}
</script>

<template>
  <form @submit.prevent="save">
    <Input
      id="email"
      v-model="formState.name"
      rules="required"
      name="name"
      label="Name"
      :error-message="v$.name.$errors"
    />
    <div style="margin-top: 1rem">
      <Label label="Content" for="editorContent" />
      <ContractEditor v-model="formState.content" id="editorContent" />
      <ErrorValidation :message="v$.content.$errors" name="content" />


      <details class="mt-10 border-y-2 py-2">
        <summary class="list-none after:content-['+'] after:ml-5 cursor-pointer font-semibold">Preview</summary>
        <ContractContent :content="formState.content" />
      </details>
    </div>
    <div class="mt-4 flex items-center justify-center space-x-4">
      <Button type="button" secundary @click="goBack()">
        Back
      </Button>

      <Button :loading="loaderMain" :disabled="formState.name==='' && formState.content===''"> Submit </Button>
    </div>
  </form>
</template>

<style lang="scss" scoped>
.emergency-label-input {
  padding-bottom: 3px;
  font-family: "Poppins";
  font-style: normal;
  font-weight: 500;
  font-size: 16px;
  line-height: 22px;
  // color: $label;
}
</style>
