<script setup>
import { AdminLayout } from '@/Client/Layouts/'
import { ContractTabNav } from '@/Client/Components/Shared'
import { Table } from '@/Client/Components/Admin/Table'
import { EyeOutlined, } from '@ant-design/icons-vue'
import { FilePdfOutlined } from '@ant-design/icons-vue'

const props = defineProps(['contracts'])
const tabledHead = [
  {
    title: 'First Name',
    value: 'insured.first_name',
    slot: 'name',
    main: true,
  },
  {
    title: 'Last Name',
    value: 'insured.last_name',
    slot: 'name',
    main: true,
  },
  {
    title: 'Date Closed',
    value: 'signed_at',
    slot: 'signed_at',
    sortable: false
  },
  {
    title: 'Insurance company',
    value: 'insured.insurance_company',
    slot: 'insurance',
    sortable: false
  },
  {
    title: 'Homeowner email',
    value: 'insured.email',
    slot: 'homeowner',
    sortable: false
  },
]
</script>
<template>
  <AdminLayout>
    <div class="mb-4">
      <ContractTabNav />

      <div class="mb-5">
        <Table :header="tabledHead" :items="props.contracts">

          <template #actions="{item}">
            <div class="flex items-center">
              <a
                class="font-bold text-red-500 disabled:text-red-300 disabled:cursor-not-allowed text-2xl"
                :href="route('directory.contract.complete', { id: item.id })"
              >
                <FilePdfOutlined />
              </a>
              <Link :href="route('dashboard.invoices.show', {id: item.invoice.id})" title="View invoice" class="mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-4 -2 24 24" width="24" fill="currentColor"
                     class="w-7 h-7"><path
                  d="M3 0h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3V3a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H3zm2 13h2a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2zm6-12a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm-6 6h6a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2zm0-3h6a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2zm.5-6h2A1.5 1.5 0 0 1 9 4.5v2A1.5 1.5 0 0 1 7.5 8h-2A1.5 1.5 0 0 1 4 6.5v-2A1.5 1.5 0 0 1 5.5 3z"></path></svg>
              </Link>
              <Link
                :href="route('dashboard.contracts.show', { insuredcontract: item.id })"
                class="text-blue-700 text-xl"
              >
                <EyeOutlined />
              </Link>
            </div>
          </template>
        </Table>
      </div>
    </div>
  </AdminLayout>
</template>
