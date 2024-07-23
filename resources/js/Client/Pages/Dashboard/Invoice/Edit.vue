<script setup>
import { AdminLayout } from "@/Client/Layouts";
import { Card } from "@/Client/Components/Shared";
import { Resources, TotalCalculate } from "@/Client/Components/Admin/Invoice";
import { GaleryPicker } from "@/Client/Components/ImagePickers";
import { Fieldset, Input, Label, Button } from "@/Client/Components/Form";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";
import dayjs from 'dayjs';

const calculation = ref(null);
const props = defineProps({
  invoice: {
    type: Object,
  },
});

const files = ref([]);

const inputs = useForm({
  id: props.invoice.id,
  invoice_number: props.invoice.invoice_number,
  subject: props.invoice.subject,
  clientMessage: props.invoice.message,
  invoiceResources: [],
  discounts: [],
  taxes: [],
  total: null,
  subtotal: null,
  totalDiscount: null,
  totalTaxes: null,
  //
  internalNotes: props.invoice.internal_notes,
  images: [],
});

const subtotal = computed(() => {
  const sum = ref(null);
  inputs.invoiceResources.forEach((item) => {
    if('total' in item){
      sum.value += item.total;
    }else{
      sum.value += item.quantity * (item.price_cents/100)
    }
  });
  return sum;
});

const getTotals = () => {
  const { total, totalDiscount, totalTaxes, discounts, taxes } =
    calculation.value.getData();
  inputs.total = total;
  inputs.subtotal = subtotal.value;
  inputs.totalDiscount = totalDiscount;
  inputs.totalTaxes = totalTaxes;
  inputs.discounts = discounts;
  inputs.taxes = taxes;
};

const submit = async () => {
  await getTotals();
  await inputs.post(
    route("dashboard.invoices.update", props.invoice.id),
    {
      onError(errors) {
        console.log(errors);
      },
      onFinish() {
        console.log("finish");
      },
    }
  );
};
</script>

<template>
  <AdminLayout>
    <Card class="md:w-full">
      <form @submit.prevent="submit">
        <div id="insured">
          <h1 class="font-bold text-2xl">
            Job Breakdown for
            {{
              `${props.invoice.insured_contract.insured.first_name} ${props.invoice.insured_contract.insured.last_name}`
            }}
          </h1>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10">
            <Fieldset legend="Invoice subject">
              <Input
                label="Subject"
                v-model="inputs.subject"
                placeholder="Subject"
              />
              <div class="grid grid-cols-2 gap-5 mt-3">
                <div>
                  <h2 class="font-bold text-xl">Service address</h2>
                  <Label
                    :label="props.invoice.insured_contract.insured.address"
                  ></Label>
                </div>
                <div>
                  <h2 class="font-bold text-xl">Contact details</h2>
                  <Label
                    :label="props.invoice.insured_contract.insured.phone"
                  ></Label>
                  <span class="text-green-500 font-semibold">{{
                    props.invoice.insured_contract.insured.email
                  }}</span>
                </div>
              </div>
            </Fieldset>
            <div>
              <h2 class="font-bold text-2xl">
                Invoice #
                <Input
                  type="number"
                  label=""
                  placeholder="Invoice #"
                  v-model="inputs.invoice_number"
                />
              </h2>
              <h2 class="font-bold text-xl">Issue date</h2>
              <p class="text-green-500 font-semibold">
                {{
                  dayjs(props.invoice.insured_contract.signed_at).format(
                    "MM/DD/YYYY"
                  )
                }}
              </p>
            </div>
          </div>
        </div>

        <div id="resoureces" class="mt-16">
          <Resources
            :resources="props.invoice.insured_contract.insured_resources"
            :actual-resources="props.invoice.invoice_resources"
            v-model="inputs.invoiceResources"
            edit
          />
        </div>

        <div id="totals">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-16">
            <div>
              <Input
                label="Client message"
                placeholder="Client message"
                textarea
                v-model="inputs.clientMessage"
              />
            </div>
            <div>
              <TotalCalculate ref="calculation" :subtotal="subtotal" edit :all-discounts="props.invoice.invoice_fees" />
            </div>
          </div>
        </div>

        <div class="w-full lg:w-1/2">
          <Input
            label="Internal Notes"
            placeholder="Internal Notes"
            textarea
            v-model="inputs.internalNotes"
          />
          <!-- <GaleryPicker v-model="inputs.images" :files="files" /> -->
        </div>

        <div id="actions" class="flex justify-center items-center gap-4 mt-20">
          <Button class="w-52" secundary>Update invoice</Button>
        </div>
      </form>
    </Card>
  </AdminLayout>
</template>
