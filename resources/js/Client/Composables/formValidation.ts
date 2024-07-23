import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useVuelidate } from "@vuelidate/core";
// export function useForm({metho='post'}) {

export async function useForm({
  v$,
  path,
  method = "post",
  rules = ref(),
  inputs = ref(),
  $externalResults = ref({}),
  valError = "",
  backError = "",
  onSuccess = ()=>{}
}) {
  const validate = await v$.value.$validate();


  if (!validate) {
    // Notificatio of validation error
    return false;
  }

  Inertia.post(path, inputs.value, {
    onProgress: (param) => {
      console.log(param);
    },
    onError: (errors) => {
    // Notificatio of validation error
      $externalResults.value = errors;
    },
    onSuccess: () => {
      // redirect/Clean/Notificate success
    },
  });
}
