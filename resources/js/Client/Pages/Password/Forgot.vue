<script setup>
import { Input, Button } from '@/Client/Components/Form';
import { Card, CardHeader } from '@/Client/Components/Shared';
import { useForm } from '@inertiajs/inertia-vue3';
import { useVuelidate } from '@vuelidate/core';
import { required, email } from '@vuelidate/validators';
import { ref } from 'vue';

const props = defineProps({
  errors: Object,
  status: {
    required: false
  }
})

const inputs = useForm({
  email: ''
})

const rules = {
  email: { required, email }
}

const $externalResults = ref()

const v$ = useVuelidate(rules, inputs, {$externalResults})

const submit = async () => {
  $externalResults.value = {}

  const validate = await v$.value.$validate();

  if(!validate){
    return false;
  }

  inputs.post(route('forgot-password'), {
    onError(errors){
      $externalResults.value = errors
    }
  });
}
</script>

<template>
  <div class="h-screen flex items-center justify-center">
    <div>
      <Card>
        <template #header>
          <CardHeader title="Forgot Password" />
          <p> Forgot your password? No problem. Just let us know your email address and we will email you a password reset
              link that will allow you to choose a new one.</p>

          <p class="mb-4 font-medium text-sm text-green-600" v-if="props.status">{{ props.status }}</p>
        </template>

        <form @submit.prevent="submit" class="space-y-5">
          <Input label="Email" v-model="inputs.email" :error-message="v$.email.$errors" type="email" />

          <Button :disabled="inputs.processing" :loading="inputs.processing">Email Password Reset Link</Button>
        </form>
      </Card>
    </div>
  </div>
</template>
