<script setup>
import { Input, Button } from '@/Client/Components/Form';
import { Card, CardHeader } from '@/Client/Components/Shared';
import { computed, ref } from 'vue';
import { required, email, minLength, sameAs } from '@vuelidate/validators';
import useVuelidate from '@vuelidate/core';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const inputs = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const rules = computed(() => ({
  email: { required, email },
  password: { required, minLength: minLength(8) },
  password_confirmation: {
    required,
    sameAsPassword: sameAs(inputs.password, "password"),
  },
}))

const $externalResults = ref()

const v$ = useVuelidate(rules, inputs, { $externalResults });

const submit = async () => {
  $externalResults.value = {}
  const validate = await v$.value.$validate();
  if(!validate){
    return
  }

  inputs.post(route('password.store'), {
    onError (errors) {
      $externalResults.value = errors
    },
    onFinish: () => inputs.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <div class="h-screen flex items-center justify-center">
    <div>
      <Card>
        <template #header>
          <CardHeader title="Reset Password" />
          <p class="mb-4 font-medium text-sm text-green-600">{{ props.status }}</p>
        </template>

        <form @submit.prevent="submit" class="space-y-5">
          <Input label="Email" v-model="inputs.email" :error-message="v$.email.$errors" type="email" />

          <Input label="Password" v-model="inputs.password" :error-message="v$.password.$errors" type="password" />

          <Input label="Password confirmation" v-model="inputs.password_confirmation" :error-message="v$.password_confirmation.$errors" type="password" />

          <Button :disabled="inputs.processing" :loading="inputs.processing">Reset Password</Button>
        </form>
      </Card>
    </div>
  </div>
</template>
