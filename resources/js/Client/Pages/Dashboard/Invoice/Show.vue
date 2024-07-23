<script setup>
import { AdminLayout } from '@/Client/Layouts'
import { Card } from "@/Client/Components/Shared"
import { Fieldset, Input, Label, Button } from "@/Client/Components/Form"
import { ref, onMounted } from "vue"
import dayjs from 'dayjs'
import DiscountItem from "@/Client/Components/Admin/Invoice/DiscountItem.vue";

const props = defineProps(['invoice', 'evidences'])

const subTotal = ref(0)
const finalTotal = ref(0)
const discountTotals =ref(0)
const taxTotals =ref(0)


const getSubTotal = () => {
  props.invoice.invoice_resources.forEach((item)=>{
    subTotal.value += (item.price_cents * item.quantity)
  })
}

const calculateDiscounts = ()=>{
  let discounts = 0

  props.invoice.invoice_fees.forEach( item => {
    if (item.type === "discount") {
      if (item.fee_type === "discount") {
        discounts += item.amount
      } else {
        discounts += ((item.amount/100) * subTotal.value)
      }
    }
  })
  discountTotals.value = discounts

}
const  calculateTaxes = ()=>{
  let tax =0
  props.invoice.invoice_fees.forEach( item => {

      if (item.type === "tax") {
        if (item.fee_type === "percentage") {
          tax += ((item.amount/100) * (subTotal.value-discountTotals.value))
        } else {
          tax += item.amount
        }
      }
  })
  taxTotals.value =  tax
}
const getTotal = () =>{
  finalTotal.value = (subTotal.value - discountTotals.value + taxTotals.value)
}

onMounted(() => {
  getSubTotal()
  calculateDiscounts()
  calculateTaxes()
  getTotal()
})
</script>

<template>
  <AdminLayout>
    <Card class="md:w-full ">
      <div id="insured">
        <h1 class="font-bold text-2xl">Preview Invoice for {{ `${props.invoice.insured_contract.insured.first_name} ${props.invoice.insured_contract.insured.last_name}` }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10">
          <Fieldset legend="Invoice subject">
            <Input label="Subject" v-model="props.invoice.subject" :disabled="true" />
            <div class="grid grid-cols-2 gap-5 mt-3">
              <div>
                <h2 class="font-bold text-xl">Service address</h2>
                <Label :label="props.invoice.insured_contract.insured.address"></Label>
              </div>
              <div>
                <h2 class="font-bold text-xl">Contact details</h2>
                <Label :label="props.invoice.insured_contract.insured.phone"></Label>
                <span class="text-green-500 font-semibold">{{ props.invoice.insured_contract.insured.email }}</span>
              </div>
            </div>
          </Fieldset>
          <div>
            <h2 class="font-bold text-2xl">Invoice # {{ props.invoice.invoice_number }}</h2>
            <h2 class="font-bold text-xl">Issue date</h2>
            <p class="text-green-500 font-semibold">{{ props.invoice.insured_contract.signed_at }}</p>
          </div>
        </div>
      </div>

      <div id="resoureces" class="mt-16">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-5 border-b-2 font-bold">
          <div class="col-span-3">PRODUCT / SERVICE</div>
          <div class="col-span-1">QTY</div>
          <div class="col-span-1">UNIT PRICE</div>
          <div class="col-span-1">TOTAL</div>
        </div>
        <div
          v-for="resource in props.invoice.invoice_resources"
          class="grid grid-cols-1 md:grid-cols-6 gap-5 mt-5 pb-2 border-b"
        >
          <div class="col-span-3">
            <h3 class="text-lg font-medium">
              {{ resource.insured_contract_resource.pricing_resources.resource.name }}
            </h3>
            <p class="text-base">
              {{ resource.description }}
            </p>
          </div>
          <div class="col-span-1">
            {{ resource.quantity }}
          </div>
          <div class="col-span-1">
            {{ resource.price_cents/100 }}
          </div>
          <div class="col-span-1">
            {{ ((resource.price_cents/100) * resource.quantity) }}
          </div>
        </div>
      </div>

      <div id="totals">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-16">
          <div>
            <Input label="Client message" placeholder="Client message" textarea v-model="props.invoice.message" :disabled="true" />
          </div>
          <div class="space-y-2 divide-y">
            <!-- <TotalCalculate ref="calculation" :subtotal="subtotal" /> -->
            <div class="flex justify-between items-center">
              <p class="m-0">Subtotal</p>
              <p class="m-0">${{subTotal/100}}</p>
            </div>
            <div class="flex justify-between items-center">
              <div class="grid grid-cols-2 justify-around w-full">
                <div class="col-span-2"> <h4 class="text-[21px] text-green-800">Discounts</h4></div>
              <template v-for="item in props.invoice.invoice_fees">
                <template v-if="item.type == 'discount'">
                  <span>{{ item.name}} </span>
                  <span>{{ item.fee_type === 'percentage'? '%' : '$'}} {{ item.fee_type === 'percentage'?item.amount:(item.amount/100) }}</span>

                </template>

              </template>
              </div>
            </div>
            <div class="flex justify-between items-center">
              <div class="grid grid-cols-2 justify-around w-full">
                <div class="col-span-2"> <h4 class="text-[21px] text-blue-800">Taxes</h4></div>
                <template v-for="item in props.invoice.invoice_fees">
                  <template v-if="item.type == 'tax'">
                    <span>{{ item.name}} </span>
                    <span>{{ item.fee_type === 'percentage'? '%' : '$'}} {{ item.fee_type === 'percentage'?item.amount:(item.amount/100) }}</span>

                  </template>

                </template>
              </div>
            </div>
            <div class="flex justify-between items-center font-bold">
              <p>Total</p>
              <p>${{ finalTotal/100 }}</p>
            </div>
          </div>
        </div>
      </div>

      <section class="w-1/2">
        <Input label="Internal Notes" textarea v-model="props.invoice.internal_notes" :disabled="true"/>
      </section>

<!--      <section class="mt-7">-->
<!--        <h3 class="font-bold text-xl">Evidences</h3>-->
<!--        <div class="grid grid-cols-2 md:grid-cols-3 gap-8">-->
<!--          <div v-for="image in props.evidences">-->
<!--            <img :src="image.path" alt="">-->
<!--          </div>-->
<!--        </div>-->
<!--      </section>-->
    </Card>
  </AdminLayout>
</template>
