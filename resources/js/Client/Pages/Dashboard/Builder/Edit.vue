
<script setup>
import { AdminLayout } from "@/Client/Layouts";
import { PlayCircleOutlined } from '@ant-design/icons-vue'
import { ContractForm } from '@/Client/Components/Admin/Builder'
import { ref } from 'vue';
import { Inertia } from "@inertiajs/inertia";
import { Modal } from '@/Client/Components/Shared'

const props = defineProps(['contract'])

const disponiblesValues = {
  first_name: 'First name',
  last_name: 'Last name',
  address: 'Address',
  phone_number: 'Phone number',
  insurance_company: 'Insurance company',
  claim_number: 'Claim number',
  email: 'Email',
  date: 'Date Signed'
}

const errors = ref({})
const isModalVisible = ref(false)

const closeModal = () => isModalVisible.value = false

const submit = async (item) => {
  await Inertia.put(route('dashboard.builder.update', { contract: props.contract.id }), item, {
    onError(errors){
      errors.value = errors
    }
  })
}
</script>

<template>
  <AdminLayout>
    <h2 class="font-inter text-[28px] font-medium">Create Template</h2>

    <div>
      <ol class="list-decimal list-outside pl-7 space-y-2">
        <li>
          See this video for how to use this form:
          <button
            class="inline-flex flex-row flex-nowrap items-center gap-x-2 text-primary underline"
            @click=" isModalVisible = true"
          >
            <PlayCircleOutlined />
            Play video
          </button>
        </li>
        <li>
          Copy paste your emergency mitigation contract that
          you have with your customer below.
        </li>
        <li>
          A couple things to keep in mind and bring up to your legal
          team as you're writing your contract.

          <ol class="list-[lower-alpha] list-outside pl-8">
            <li>The  Pricing rates for your assets will always go “below” your legal verbiage.</li>
            <li>Specialized resource offerings-	If you have specialized resources  that you
              utilize  on job sites that differ from the  resources we track, please mention that
              resource and its pricing in The legal verbiage of your contract. These resources will
              not be able to be compared to the other tree services as they are specialized to you
              and your contract.
            </li>
            <li>
              Debris hauling is not one of the line items offered. So please talk to your
              legal team and incorporate  the cost of debris hauling into the legal verbiage of your contract.
            </li>
          </ol>
        </li>
        <li>Short Codes- Below is a list of short codes to insert into your contract.
          The short codes will automatically insert your customers information into your
          contract. To use,  simply copy and paste into your contract where appropriate.
        </li>
      </ol>
      <hr class="my-3">
      <details>
        <summary class="list-none after:content-['+'] after:ml-5 cursor-pointer font-semibold">Shortcodes</summary>
        <ul class="mb-4">
          <li v-for="(item, index) of disponiblesValues" :key="index">
            {{ "{" + index + "}" }} = {{ item }}
          </li>
        </ul>
      </details>
      <hr class="my-3">
      <ContractForm
        :contract="props.contract"
        :errors="errors"
        :edit="true"
        @submit="submit"
        :validations="errors"
      />
    </div>
    <Modal
      :isModalVisible="isModalVisible"
      titleModal="How to use contract template"
      :closeModal="closeModal"
      modalWidth="w-[90%] md:w-[50%]"
    >
      <iframe
        v-if="isModalVisible"
        class="w-full h-80 md:h-96 xl:h-[600px]"
        src="https://www.youtube.com/embed/cd4vHvR5D60"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      />
    </Modal>
  </AdminLayout>
</template>

<style scoped lang="scss"></style>
