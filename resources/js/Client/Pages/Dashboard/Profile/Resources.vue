<script setup>
import { AdminLayout } from "@/Client/Layouts";
import { ProfileTabNav} from "@/Client/Components/Shared";
import { Input, Button } from "@/Client/Components/Form";
import { computed, onMounted, reactive, ref } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { ValidateEach } from "@vuelidate/components";
import { helpers, minValue, requiredIf, integer } from "@vuelidate/validators";
import { Inertia } from "@inertiajs/inertia";
ValidateEach;
const props = defineProps({
  resources: Array,
  pricingResources: [Array, Object],
});

const myResource = ref([]);
const loader = ref(false);

onMounted(() => {
  props.resources.forEach((item) => {
    const pricingId = props.pricingResources?.find(
      (itemPricing) => itemPricing.resource_id === item.id
    );
    myResource.value.push({
      id: pricingId?.id ?? null,
      name: item.name,
      resource_id: item.id,
      minimum_units: pricingId?.minimum_units ?? null,
      price_cents: pricingId?.price_cents ? (pricingId?.price_cents / 100) : null,
      price_currency: "USD",
    });
  });
});

const rules = computed(() => ({
  $each: helpers.forEach({
    minimum_units: {
      minValue: minValue(1),
      required: requiredIf(function (value, object) {
        return object.price_cents > 0;
      }),
      integer,
    },
    price_cents: {
      minValue: minValue(1),
      required: requiredIf(function (value, object) {
        return object.minimum_units > 0;
      }),
      integer,
    },
  }),
}));

const $externalResults = ref([])

const v$ = useVuelidate(rules, myResource, { $externalResults });

const submit = async () => {
  $externalResults.value = [];
  const validate = await v$.value.$validate();
  if (!validate) {
    return false;
  }

  Inertia.put(
    route("dashboard.profile.resources.update"),
    myResource.value
      .filter((item) => {
        return item.price_cents > 0 && item.minimum_units > 0;
      })
      .map((item) => ({
        id: item.id,
        resource_id: item.resource_id,
        minimum_units: item.minimum_units,
        price_cents: item.price_cents * 100,
        price_currency: "USD",
      })),
    {
      onStart(){
        loader.value=true;
      },
      onFinish(){
        loader.value = false;
      },
      onError(errors) {
        $externalResults.value = errors
      }
    }
  );
};

const back = () => {
  Inertia.visit(route("provider.first-time"));
};
</script>

<template>
  <AdminLayout>
    <ProfileTabNav />
    <div class="md:max-w-[70%] mx-auto mb-5 pt-[16px]">
      <p class="text-justify text-body tracking-[.75px]">
        <b>EMERGENCY PRICING ONLY!!!</b>
        The purpose of emergency Market is to provide pricing for emergency situations only.
        That said, when entering your hourly pricing and minimums below, please keep in mind that the rate you are entering
        is for immediate dispatch of the assets. These are not rates for scheduled work.
      </p>
      <p class="text-justify text-body tracking-[.75px]">
        Needing to make sure your hourly rates work with your profit models?  We built this handy calculator  to help! Check it out. we hope it helps!
        <a class="text-blue-500" target="_blank" href="https://my.emergencymarket.com/insurance-claims/emergency-tree-removal-hourly-rate-pricing-calculator/?seq_no=2">https://my.emergencymarket.com/insurance-claims/emergency-tree-removal-hourly-rate-pricing-calculator/?seq_no=2</a>
      </p>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-x-4">
          <template v-for="(item, index) in myResource" :key="index">
            <span class="col-span-2 mt-6">{{ item.name }}</span>
            <Input
              class="col-span-1"
              label="Rate per hour"
              type="number"
              v-model="item.price_cents"
              :error-message="v$.$each.$response.$errors[index].price_cents"
            />
            <Input
              class="col-span-1"
              label="Minimun Hour"
              type="number"
              v-model="item.minimum_units"
              :error-message="v$.$each.$response.$errors[index].minimum_units"
            />
          </template>
        </div>

        <div class="flex space-x-4 mt-5">
          <Button class="flex" :loading="loader">
            Update Resources
          </Button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
