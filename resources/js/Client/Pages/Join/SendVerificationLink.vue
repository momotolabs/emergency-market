<script setup>
import { ref } from "vue";
import { useForm } from '@inertiajs/inertia-vue3';
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { Default as DefaultLayout } from "@/Client/Layouts";
import { Card, CardHeader } from "@/Client/Components/Shared";
import { Input, Button } from "@/Client/Components/Form";

const props = defineProps(['status']);

const inputs = useForm({
  email: "",
});

const rules = {
  email: { required, email },
};

const $externalResults = ref({});

const v$ = useVuelidate(rules, inputs, { $externalResults });

const submit = async () => {
  $externalResults.value = {};
  const validate = await v$.value.$validate();

  if (!validate) {
    // Notification of validation error
    return false;
  }

  inputs.post(route('email.link'), {
    onError: (errors) => {
      // Notification of validation error
      $externalResults.value = errors;
    },
  });
};
</script>

<template>
  <DefaultLayout>
    <Card>

      <template #header>
        <CardHeader title="Resend Verification Link" ></CardHeader>
        <p class="my-4 font-medium text-sm text-green-600" v-if="props.status">{{ props.status }}</p>
      </template>

      <form @submit.prevent="submit" class="space-y-4">
        <Input
          label="Email"
          name="Email"
          v-model="inputs.email"
          :error-message="v$.email.$errors"
        />

        <Button :loading="inputs.processing">Submit</Button>
      </form>
    </Card>
  </DefaultLayout>
</template>
